<?php

namespace App\Services;

use Exception;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Log;
use Illuminate\Support\Facades\Storage;

class USPSService
{
    protected $oauthUrl;
    protected $paymentUrl;
    protected $apiUrl;
    protected $clientId;
    protected $clientSecret;

    public function __construct()
    {
        $this->oauthUrl = rtrim((string) config('services.usps.oauth_url', 'https://apis.usps.com'), '/');
        $this->paymentUrl = rtrim((string) config('services.usps.payment_url', 'https://apis.usps.com'), '/');
        $this->apiUrl = rtrim((string) config('services.usps.api_url', 'https://apis.usps.com'), '/');
        $this->clientId = config('services.usps.consumer_key');
        $this->clientSecret = config('services.usps.consumer_secret');
    }

    public function getAccessToken()
    {
        if (empty($this->clientId) || empty($this->clientSecret)) {
            throw new Exception('USPS Consumer Key or Consumer Secret is missing. Check config/services.php and .env.');
        }

        $cacheKey = 'usps_access_token_' . md5($this->oauthUrl . '_' . $this->clientId);
        $cached = Cache::get($cacheKey);
        if (!empty($cached)) {
            return $cached;
        }

        $response = Http::acceptJson()->asJson()->post($this->oauthUrl . '/oauth2/v3/token', [
            'grant_type' => 'client_credentials',
            'client_id' => $this->clientId,
            'client_secret' => $this->clientSecret,
        ]);

        if (!$response->successful()) {
            Log::error('USPS OAuth failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new Exception('USPS OAuth failed. Status: ' . $response->status() . ' Body: ' . $response->body());
        }

        $json = $response->json() ?: [];
        if (empty($json['access_token'])) {
            throw new Exception('USPS OAuth response did not include access_token.');
        }

        $expiresIn = isset($json['expires_in']) ? (int) $json['expires_in'] : 900;
        $cacheSeconds = $expiresIn > 180 ? $expiresIn - 120 : max(30, (int) floor($expiresIn * 0.75));
        Cache::put($cacheKey, $json['access_token'], now()->addSeconds($cacheSeconds));

        return $json['access_token'];
    }

    public function getDomesticRates(array $data)
    {
        $response = Http::withToken($this->getAccessToken())
            ->acceptJson()
            ->asJson()
            ->post($this->apiUrl . '/prices/v3/base-rates/search', $data);

        if (!$response->successful()) {
            Log::error('USPS rate request failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new Exception('Unable to get USPS shipping rates. Status: ' . $response->status() . ' Body: ' . $response->body());
        }

        return $response->json() ?: [];
    }

    public function getPaymentAuthorizationToken()
    {
        $crid = config('services.usps.crid');
        $mid = config('services.usps.mid');
        $manifestMid = config('services.usps.manifest_mid');
        $accountType = config('services.usps.account_type', 'EPS');
        $accountNumber = config('services.usps.account_number');

        if (empty($crid) || empty($mid) || empty($manifestMid) || empty($accountType) || empty($accountNumber)) {
            throw new Exception('USPS payment details are missing. Check USPS_CRID, USPS_MID, USPS_MANIFEST_MID, USPS_ACCOUNT_TYPE and USPS_ACCOUNT_NUMBER.');
        }

        $cacheKey = 'usps_payment_authorization_token_' . md5(
            $this->paymentUrl . '_' . $crid . '_' . $mid . '_' . $accountNumber
        );

        $cached = Cache::get($cacheKey);
        if (!empty($cached)) {
            return $cached;
        }

        $payload = [
            'roles' => [
                [
                    'roleName' => 'PAYER',
                    'CRID' => $crid,
                    'MID' => $mid,
                    'manifestMID' => $manifestMid,
                    'accountType' => $accountType,
                    'accountNumber' => $accountNumber,
                ],
                [
                    'roleName' => 'LABEL_OWNER',
                    'CRID' => $crid,
                    'MID' => $mid,
                    'manifestMID' => $manifestMid,
                    'accountType' => $accountType,
                    'accountNumber' => $accountNumber,
                ],
            ],
        ];

        $response = Http::withToken($this->getAccessToken())
            ->acceptJson()
            ->asJson()
            ->post($this->paymentUrl . '/payments/v3/payment-authorization', $payload);

        if (!$response->successful()) {
            Log::error('USPS payment authorization failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);
            throw new Exception('USPS Payment Authorization failed. Status: ' . $response->status() . ' Body: ' . $response->body());
        }

        $json = $response->json() ?: [];
        if (empty($json['paymentAuthorizationToken'])) {
            throw new Exception('USPS paymentAuthorizationToken is missing from the response.');
        }

        // Keep this deliberately short. A stale payment token can make label operations fail unexpectedly.
        Cache::put($cacheKey, $json['paymentAuthorizationToken'], now()->addMinutes(20));

        return $json['paymentAuthorizationToken'];
    }

    /**
     * Purchase a USPS domestic label.
     *
     * IMPORTANT: the USPS label create endpoint is not idempotent. The UUID is
     * still sent because USPS uses it for downstream reprint/cancel operations,
     * but callers must never blindly retry an uncertain successful request.
     */
    public function createDomesticLabel(array $labelData, $requestUuid)
    {
        try {
            $response = Http::withToken($this->getAccessToken())
                ->withHeaders([
                    'X-Payment-Authorization-Token' => $this->getPaymentAuthorizationToken(),
                    'X-Idempotency-Key' => (string) $requestUuid,
                ])
                ->timeout(90)
                ->asJson()
                ->post($this->apiUrl . '/labels/v3/label', $labelData);
        } catch (\Throwable $e) {
            // A connection/timeout failure can be uncertain. Let the controller block an automatic retry.
            throw $e;
        }

        if (!$response->successful()) {
            Log::error('USPS label creation failed', [
                'status' => $response->status(),
                'body' => $response->body(),
            ]);

            return [
                'success' => false,
                'safeToRetry' => true,
                'httpStatus' => $response->status(),
                'message' => 'USPS label creation failed. Status: ' . $response->status() . ' Body: ' . $response->body(),
            ];
        }

        $parsed = $this->parseDomesticLabelResponse(
            $response->body(),
            (string) $response->header('Content-Type')
        );
        $parsed['success'] = true;

        return $parsed;
    }

    /** Edit eligible package attributes on an already-created label. */
    public function editDomesticLabel($trackingNumber, array $changes)
    {
        $allowed = [
            'weight', 'length', 'height', 'width',
            'processingCategory', 'girth', 'rateIndicator', 'containers',
        ];

        $operations = [];
        foreach ($changes as $field => $value) {
            if (!in_array($field, $allowed, true)) {
                throw new Exception('Unsupported USPS label edit field: ' . $field);
            }
            if ($value === null) {
                continue;
            }
            $operations[] = [
                'op' => 'replace',
                'path' => '/packageDescription/' . $field,
                'value' => $value,
            ];
        }

        if (empty($operations)) {
            throw new Exception('No label package changes were supplied.');
        }

        $response = Http::withToken($this->getAccessToken())
            ->withHeaders([
                'X-Payment-Authorization-Token' => $this->getPaymentAuthorizationToken(),
            ])
            ->acceptJson()
            ->asJson()
            ->patch(
                $this->apiUrl . '/labels/v3/label/' . rawurlencode((string) $trackingNumber),
                $operations
            );

        if (!$response->successful()) {
            throw new Exception('USPS label edit failed. Status: ' . $response->status() . ' Body: ' . $response->body());
        }

        return $response->json() ?: [];
    }

    /** Reprint a label by tracking number. USPS limits reprints to 3 and only through the mailing date. */
    public function reprintDomesticLabel($trackingNumber)
    {
        $response = Http::withToken($this->getAccessToken())
            ->withHeaders([
                'X-Payment-Authorization-Token' => $this->getPaymentAuthorizationToken(),
            ])
            ->timeout(90)
            ->asJson()
            ->post(
                $this->apiUrl . '/labels/v3/label-reprint/' . rawurlencode((string) $trackingNumber),
                [
                    'imageInfo' => [
                        'imageType' => 'PDF',
                        'labelType' => '4X6LABEL',
                        'suppressPostage' => true,
                    ],
                ]
            );

        if (!$response->successful()) {
            throw new Exception('USPS label reprint failed. Status: ' . $response->status() . ' Body: ' . $response->body());
        }

        return $this->parseDomesticLabelResponse(
            $response->body(),
            (string) $response->header('Content-Type'),
            (string) $trackingNumber
        );
    }

    /** Cancel an unused label or request a refund for an eligible unused label. */
    public function cancelOrRefundLabel($trackingNumber)
    {
        $response = Http::withToken($this->getAccessToken())
            ->withHeaders([
                'X-Payment-Authorization-Token' => $this->getPaymentAuthorizationToken(),
            ])
            ->acceptJson()
            ->delete($this->apiUrl . '/labels/v3/label/' . rawurlencode((string) $trackingNumber));

        if (!$response->successful()) {
            throw new Exception('USPS cancel/refund request failed. Status: ' . $response->status() . ' Body: ' . $response->body());
        }

        return $response->json() ?: [];
    }

    private function parseDomesticLabelResponse($responseBody, $contentType, $fallbackTrackingNumber = null)
    {
        $contentType = (string) $contentType;
        $metadata = null;
        $pdfContent = null;

        if (stripos($contentType, 'application/pdf') !== false && strpos($responseBody, '%PDF-') === 0) {
            $pdfContent = $responseBody;
        } else {
            if (!preg_match('/\\bboundary=(?:"([^"]+)"|([^;\\s]+))/i', $contentType, $matches)) {
                throw new Exception('USPS label response boundary is missing. Content-Type: ' . $contentType);
            }

            $boundaryName = !empty($matches[1]) ? $matches[1] : (isset($matches[2]) ? $matches[2] : '');
            $parts = explode('--' . $boundaryName, $responseBody);

            foreach ($parts as $part) {
                $part = ltrim($part, "\r\n");
                if ($part === '' || strpos($part, '--') === 0) {
                    continue;
                }

                $sections = preg_split("/\\r?\\n\\r?\\n/", $part, 2);
                if (!$sections || count($sections) !== 2) {
                    continue;
                }

                $rawHeaders = $sections[0];
                $content = preg_replace("/\\r?\\n$/", '', $sections[1], 1);

                $isMetadata = stripos($rawHeaders, 'name="labelMetadata"') !== false ||
                    ($metadata === null && stripos($rawHeaders, 'application/json') !== false);

                if ($isMetadata) {
                    $decoded = json_decode(trim($content), true);
                    if (!is_array($decoded)) {
                        throw new Exception('Unable to decode USPS label metadata: ' . json_last_error_msg());
                    }
                    $metadata = $decoded;
                    continue;
                }

                $isLabelImage = stripos($rawHeaders, 'name="labelImage"') !== false ||
                    stripos($rawHeaders, 'application/pdf') !== false;

                if ($isLabelImage) {
                    if (strpos($content, '%PDF-') === 0) {
                        $pdfContent = $content;
                    } else {
                        $base64 = preg_replace('/\\s+/', '', $content);
                        $decodedPdf = base64_decode($base64, true);
                        if ($decodedPdf !== false && strpos($decodedPdf, '%PDF-') === 0) {
                            $pdfContent = $decodedPdf;
                        }
                    }
                }
            }
        }

        $metadata = is_array($metadata) ? $metadata : [];
        $trackingNumber = !empty($metadata['trackingNumber']) ? $metadata['trackingNumber'] : $fallbackTrackingNumber;

        if (empty($trackingNumber)) {
            throw new Exception('USPS tracking number was not returned with the label.');
        }
        if ($pdfContent === null) {
            throw new Exception('USPS label PDF is missing or could not be decoded.');
        }

        $safeTracking = preg_replace('/[^A-Za-z0-9_-]/', '', (string) $trackingNumber);
        $relativePath = 'usps-labels/' . $safeTracking . '.pdf';

        if (Storage::disk('local')->put($relativePath, $pdfContent) === false) {
            throw new Exception('Unable to save the USPS label PDF to private storage.');
        }

        return [
            'trackingNumber' => (string) $trackingNumber,
            'postage' => isset($metadata['postage']) ? $metadata['postage'] : null,
            'labelMetadata' => $metadata,
            'labelPath' => $relativePath,
        ];
    }

    public function clearTokens()
    {
        Cache::forget('usps_access_token_' . md5($this->oauthUrl . '_' . $this->clientId));
        Cache::forget('usps_payment_authorization_token_' . md5(
            $this->paymentUrl . '_' .
            config('services.usps.crid') . '_' .
            config('services.usps.mid') . '_' .
            config('services.usps.account_number')
        ));
    }
}
