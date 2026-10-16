<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Str;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\CheckPayment;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\OtherPayment;
use App\Models\StoreCardPayment;
use App\Models\StoreOrder;
use App\Models\QuickbookRecord;
use App\Services\QuickBooksService;
use Illuminate\Support\Facades\Cache;
use App\Models\QuickbooksToken;

class QuickBooksController extends Controller
{
    /* ======================================
       CONNECT TO QUICKBOOKS
    ====================================== */
    public function connect()
    {
        $state = Str::random(40);
        session(['qb_state' => $state]);

        $query = http_build_query([
            'client_id'     => config('services.qbo.client_id'),
            'response_type' => 'code',
            'scope'         => 'com.intuit.quickbooks.accounting',
            'redirect_uri'  => config('services.qbo.redirect_uri'),
            'state'         => $state,
        ]);

        return redirect("https://appcenter.intuit.com/connect/oauth2?$query");
    }

    /* ======================================
       CALLBACK
    ====================================== */
    public function callback(Request $request)
    {
        if ($request->state !== session('qb_state')) {
            return "Invalid state — possible CSRF attack";
        }

        $response = Http::asForm()
            ->withHeaders([
                'Authorization' => 'Basic ' . base64_encode(
                    config('services.qbo.client_id') . ':' .
                    config('services.qbo.client_secret')
                ),
                'Accept' => 'application/json'
            ])
            ->post('https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer', [
                'grant_type' => 'authorization_code',
                'code' => $request->code,
                'redirect_uri' => config('services.qbo.redirect_uri'),
            ]);

        $data = $response->json();

        if (!isset($data['access_token'])) {
            \Log::error('QuickBooks token error', [
                'response' => $data,
            ]);

            return "Failed to get access token";
        }

        /*
        |--------------------------------------------------------------------------
        | Save QuickBooks Credentials in Session
        |--------------------------------------------------------------------------
        */

        session([
            'quickbooks.access_token' => $data['access_token'],
            'quickbooks.refresh_token' => $data['refresh_token'],
            'quickbooks.realm_id' => $request->realmId,
        ]);

        /*
        |--------------------------------------------------------------------------
        | Save QuickBooks Credentials in Database
        |--------------------------------------------------------------------------
        */

        QuickbooksToken::updateOrCreate(
            [
                'id' => 1,
            ],
            [
                'access_token' => $data['access_token'],
                'refresh_token' => $data['refresh_token'],
                'realm_id' => $request->realmId,
                'access_token_expires_at' => now()->addSeconds(
                    $data['expires_in'] ?? 3600
                ),
            ]
        );

        /*
        |--------------------------------------------------------------------------
        | Save QuickBooks Credentials in Cache
        |--------------------------------------------------------------------------
        */

        Cache::forever(
            'quickbooks.access_token',
            $data['access_token']
        );

        Cache::forever(
            'quickbooks.refresh_token',
            $data['refresh_token']
        );

        Cache::forever(
            'quickbooks.realm_id',
            $request->realmId
        );

        return redirect()->route('allTransactions');
    }

    /* ======================================
       LOAD IMPORT PAGE
    ====================================== */

    /* ======================================
       QUICKBOOK RECORD IDENTITY HELPERS
    ====================================== */

    private function quickbookRecordQuery($orderId, $recordId, $paymentType, $fromTsrModule, $isRefund = 0)
    {
        return QuickbookRecord::where('order_id', (string) $orderId)
            ->where('record_id', (int) $recordId)
            ->where('payment_type', (string) $paymentType)
            ->where('from_tsr_module', (int) $fromTsrModule)
            ->where('is_refund', (int) $isRefund);
    }

    private function findPaymentRecord(string $type, int $id)
    {
        switch ($type) {
            case 'Card':
                return PaymentLog::find($id);
            case 'Check':
                return CheckPayment::find($id);
            case 'Venmo':
                return VenmoPayment::find($id);
            case 'Paypal':
                return PaypalPayment::find($id);
            case 'Other':
                return OtherPayment::find($id);
            default:
                return null;
        }
    }

    private function findQuickBooksCustomerId($customers, ?string $name, $fallback = null)
    {
        $needle = strtolower(trim((string) $name));

        if ($needle === '') {
            return $fallback;
        }

        $customer = collect($customers)->first(function ($item) use ($needle) {
            return strtolower(trim((string) data_get($item, 'name', data_get($item, 'Name', '')))) === $needle;
        });

        return data_get($customer, 'id', data_get($customer, 'Id', $fallback));
    }

    private function findQuickBooksPaymentMethodId($paymentMethods, string $type, $fallback = 43)
    {
        $needle = strtolower(trim($type));

        $method = collect($paymentMethods)->first(function ($item) use ($needle) {
            return strtolower(trim((string) data_get($item, 'name', data_get($item, 'Name', '')))) === $needle;
        });

        return data_get($method, 'id', data_get($method, 'Id', $fallback));
    }

    private function findQuickBooksAccountId($accounts, string $name, $fallback = null)
    {
        $account = collect($accounts)->first(function ($item) use ($name) {
            return strtolower(trim((string) data_get($item, 'name', data_get($item, 'Name', ''))))
                === strtolower(trim($name));
        });

        return data_get($account, 'id', data_get($account, 'Id', $fallback));
    }

    /**
     * Convert the address textarea used by the preview page into a QBO address.
     * Keeping each visible line separate makes the QuickBooks receipt look much
     * closer to the source order and avoids trying to guess city/state fields.
     */
    private function quickBooksAddressFromText(?string $address): ?array
    {
        $lines = preg_split(
            '/\r\n|\r|\n/',
            trim((string) $address)
        );

        $lines = array_values(
            array_filter(
                array_map(
                    fn ($line) => trim((string) $line),
                    $lines ?: []
                ),
                fn ($line) => $line !== ''
            )
        );

        if (empty($lines)) {
            return null;
        }

        $result = [];

        foreach (array_slice($lines, 0, 5) as $index => $line) {
            $result['Line' . ($index + 1)] = mb_substr($line, 0, 500);
        }

        return $result;
    }

    /**
     * Return a configured default QBO id only when it actually exists in the
     * collection returned by QuickBooks.
     */
    private function validQuickBooksDefaultId($collection, $configuredId)
    {
        if ($configuredId === null || $configuredId === '') {
            return null;
        }

        $match = collect($collection)->first(function ($item) use ($configuredId) {
            return (string) data_get($item, 'id', data_get($item, 'Id', ''))
                === (string) $configuredId;
        });

        return $match
            ? data_get($match, 'id', data_get($match, 'Id'))
            : null;
    }

    /**
     * Find QuickBooks' "Discounts given" account when available.
     *
     * QBO DiscountLineDetail can work with a DiscountAccountRef. Supplying the
     * proper DiscountsRefundsGiven income account prevents company-specific
     * discount configuration errors.
     */
    private function getQuickBooksDiscountAccountId(): ?string
    {
        return Cache::remember(
            'quickbooks.discount_account_id',
            now()->addHours(12),
            function () {
                $accessToken =
                    session('quickbooks.access_token')
                    ?: Cache::get('quickbooks.access_token');

                $realmId =
                    session('quickbooks.realm_id')
                    ?: Cache::get('quickbooks.realm_id');

                if (!$accessToken || !$realmId) {
                    return null;
                }

                $baseUrl = rtrim(
                    (string) config(
                        'services.qbo.base_url',
                        'https://quickbooks.api.intuit.com'
                    ),
                    '/'
                );

                $query = "select * from Account where AccountSubType = 'DiscountsRefundsGiven' MAXRESULTS 1";

                try {
                    $response = Http::withToken($accessToken)
                        ->acceptJson()
                        ->get(
                            $baseUrl . '/v3/company/' . $realmId . '/query',
                            [
                                'query' => $query,
                                'minorversion' => 75,
                            ]
                        );

                    if (!$response->successful()) {
                        \Log::warning(
                            'Unable to resolve QuickBooks discount account',
                            [
                                'status' => $response->status(),
                                'response' => $response->json(),
                            ]
                        );

                        return null;
                    }

                    $account = data_get(
                        $response->json(),
                        'QueryResponse.Account.0'
                    );

                    return $account['Id'] ?? null;
                } catch (\Throwable $exception) {
                    \Log::warning(
                        'QuickBooks discount account lookup failed',
                        [
                            'error' => $exception->getMessage(),
                        ]
                    );

                    return null;
                }
            }
        );
    }

    /**
     * Query QuickBooks tax codes and tax rates.
     *
     * The user's source order already contains the exact tax amount charged.
     * We therefore resolve a QBO tax configuration with the same effective
     * percentage and send TxnTaxDetail explicitly instead of assuming QBO's
     * automatic tax engine will reproduce the source amount.
     */
    private function getQuickBooksTaxResources(): array
    {
        return Cache::remember(
            'quickbooks.tax_resources',
            now()->addHours(6),
            function () {
                $accessToken =
                    session('quickbooks.access_token')
                    ?: Cache::get('quickbooks.access_token');

                $realmId =
                    session('quickbooks.realm_id')
                    ?: Cache::get('quickbooks.realm_id');

                if (!$accessToken || !$realmId) {
                    return [
                        'codes' => [],
                        'rates' => [],
                    ];
                }

                $baseUrl = rtrim(
                    (string) config(
                        'services.qbo.base_url',
                        'https://quickbooks.api.intuit.com'
                    ),
                    '/'
                );

                $endpoint =
                    $baseUrl
                    . '/v3/company/'
                    . $realmId
                    . '/query';

                try {
                    $rateResponse = Http::withToken($accessToken)
                        ->acceptJson()
                        ->get(
                            $endpoint,
                            [
                                'query' =>
                                    'select * from TaxRate '
                                    . 'startposition 1 maxresults 1000',
                                'minorversion' => 75,
                            ]
                        );

                    $codeResponse = Http::withToken($accessToken)
                        ->acceptJson()
                        ->get(
                            $endpoint,
                            [
                                'query' =>
                                    'select * from TaxCode '
                                    . 'startposition 1 maxresults 1000',
                                'minorversion' => 75,
                            ]
                        );

                    if (
                        !$rateResponse->successful()
                        || !$codeResponse->successful()
                    ) {
                        \Log::warning(
                            'Unable to load QuickBooks tax configuration',
                            [
                                'tax_rate_status' =>
                                    $rateResponse->status(),
                                'tax_code_status' =>
                                    $codeResponse->status(),
                                'tax_rate_response' =>
                                    $rateResponse->json(),
                                'tax_code_response' =>
                                    $codeResponse->json(),
                            ]
                        );

                        return [
                            'codes' => [],
                            'rates' => [],
                        ];
                    }

                    return [
                        'codes' => data_get(
                            $codeResponse->json(),
                            'QueryResponse.TaxCode',
                            []
                        ) ?: [],

                        'rates' => data_get(
                            $rateResponse->json(),
                            'QueryResponse.TaxRate',
                            []
                        ) ?: [],
                    ];
                } catch (\Throwable $exception) {
                    \Log::warning(
                        'QuickBooks tax configuration lookup failed',
                        [
                            'error' => $exception->getMessage(),
                        ]
                    );

                    return [
                        'codes' => [],
                        'rates' => [],
                    ];
                }
            }
        );
    }

    /**
     * Resolve a QBO tax code/rate matching the source transaction's effective
     * percentage.
     *
     * Returns:
     * [
     *   'percent' => 9.25,
     *   'tax_code_id' => '...',
     *   'rates' => [
     *      ['id' => '...', 'percent' => 6.25],
     *      ...
     *   ],
     * ]
     */
    private function resolveQuickBooksTaxConfiguration(
        float $taxableBase,
        float $taxAmount
    ): ?array {
        $taxableBase = round($taxableBase, 2);
        $taxAmount = round($taxAmount, 2);

        if ($taxAmount <= 0) {
            return null;
        }

        if ($taxableBase <= 0) {
            throw new \Exception(
                'Sales tax exists but the taxable subtotal is zero.'
            );
        }

        $effectivePercent = round(
            ($taxAmount / $taxableBase) * 100,
            6
        );

        $resources =
            $this->getQuickBooksTaxResources();

        $ratesById = [];

        foreach ($resources['rates'] as $rate) {
            $id = (string) ($rate['Id'] ?? '');

            if ($id === '') {
                continue;
            }

            if (
                array_key_exists('Active', $rate)
                && $rate['Active'] === false
            ) {
                continue;
            }

            $ratesById[$id] = [
                'id' => $id,
                'name' => (string) ($rate['Name'] ?? ''),
                'percent' => (float) ($rate['RateValue'] ?? 0),
            ];
        }

        /*
         * First prefer a TaxCode. This is the best representation when a QBO
         * sales tax consists of multiple state/county/district components.
         */
        foreach ($resources['codes'] as $code) {
            if (
                array_key_exists('Active', $code)
                && $code['Active'] === false
            ) {
                continue;
            }

            if (
                array_key_exists('Taxable', $code)
                && !$code['Taxable']
            ) {
                continue;
            }

            $details = data_get(
                $code,
                'SalesTaxRateList.TaxRateDetail',
                []
            ) ?: [];

            $matchedRates = [];
            $combinedPercent = 0.0;

            foreach ($details as $detail) {
                $rateId = (string) data_get(
                    $detail,
                    'TaxRateRef.value',
                    ''
                );

                if (
                    $rateId === ''
                    || !isset($ratesById[$rateId])
                ) {
                    continue;
                }

                $ratePercent =
                    (float) $ratesById[$rateId]['percent'];

                if (abs($ratePercent) < 0.000001) {
                    continue;
                }

                $matchedRates[] = [
                    'id' => $rateId,
                    'percent' => $ratePercent,
                    'name' =>
                        $ratesById[$rateId]['name'],
                    'order' => (int) (
                        $detail['TaxOrder']
                        ?? 0
                    ),
                    'type' => (string) (
                        $detail['TaxTypeApplicable']
                        ?? 'TaxOnAmount'
                    ),
                ];

                /*
                 * Most US sales-tax groups are TaxOnAmount components, so their
                 * effective rate is the sum. TaxOnTax is uncommon; the final
                 * source TotalTax is still sent explicitly below.
                 */
                $combinedPercent +=
                    $ratePercent;
            }

            if (
                !empty($matchedRates)
                && abs(
                    $combinedPercent
                    - $effectivePercent
                ) <= 0.02
            ) {
                usort(
                    $matchedRates,
                    fn ($a, $b) =>
                        $a['order'] <=> $b['order']
                );

                return [
                    'percent' =>
                        $effectivePercent,

                    'tax_code_id' =>
                        (string) ($code['Id'] ?? ''),

                    'tax_code_name' =>
                        (string) ($code['Name'] ?? ''),

                    'rates' =>
                        $matchedRates,
                ];
            }
        }

        /*
         * If the company has one standalone TaxRate exactly matching the source
         * effective percentage, it can be used without a TaxCode group.
         */
        foreach ($ratesById as $rate) {
            if (
                abs(
                    $rate['percent']
                    - $effectivePercent
                ) <= 0.02
            ) {
                return [
                    'percent' =>
                        $effectivePercent,

                    'tax_code_id' =>
                        null,

                    'tax_code_name' =>
                        null,

                    'rates' => [[
                        'id' =>
                            $rate['id'],

                        'percent' =>
                            $rate['percent'],

                        'name' =>
                            $rate['name'],

                        'order' =>
                            0,

                        'type' =>
                            'TaxOnAmount',
                    ]],
                ];
            }
        }

        return null;
    }

    /**
     * Create the TxnTaxDetail used by QBO.
     *
     * We send the source tax total explicitly. This prevents a successful
     * receipt from silently losing tax when the QBO item/customer tax settings
     * do not cause the automatic tax engine to calculate the same amount.
     */
    private function buildQuickBooksTxnTaxDetail(
        float $taxableBase,
        float $taxAmount
    ): ?array {
        $taxableBase = round(
            max(0, $taxableBase),
            2
        );

        $taxAmount = round(
            max(0, $taxAmount),
            2
        );

        if ($taxAmount <= 0) {
            return null;
        }

        $configuration =
            $this->resolveQuickBooksTaxConfiguration(
                $taxableBase,
                $taxAmount
            );

        if (
            !$configuration
            || empty($configuration['rates'])
        ) {
            $effectivePercent =
                $taxableBase > 0
                    ? round(
                        ($taxAmount / $taxableBase)
                        * 100,
                        4
                    )
                    : 0;

            throw new \Exception(
                'QuickBooks tax configuration could not be matched for '
                . number_format($effectivePercent, 4)
                . '% sales tax. The receipt was NOT exported. '
                . 'Create/enable the matching sales tax rate in QuickBooks '
                . 'or correct the tax amount before exporting.'
            );
        }

        $rates =
            $configuration['rates'];

        $rateTotal = array_reduce(
            $rates,
            fn ($total, $rate) =>
                $total
                + abs(
                    (float) ($rate['percent'] ?? 0)
                ),
            0.0
        );

        if ($rateTotal <= 0) {
            throw new \Exception(
                'QuickBooks tax configuration has no usable sales tax rates.'
            );
        }

        $taxLines = [];
        $allocatedTax = 0.0;
        $lastIndex = count($rates) - 1;

        foreach ($rates as $index => $rate) {
            if ($index === $lastIndex) {
                $lineTax = round(
                    $taxAmount - $allocatedTax,
                    2
                );
            } else {
                $lineTax = round(
                    $taxAmount
                    * (
                        abs(
                            (float) $rate['percent']
                        )
                        / $rateTotal
                    ),
                    2
                );

                $allocatedTax +=
                    $lineTax;
            }

            $taxLines[] = [
                'Amount' =>
                    $lineTax,

                'DetailType' =>
                    'TaxLineDetail',

                'TaxLineDetail' => [
                    'TaxRateRef' => [
                        'value' =>
                            (string) $rate['id'],
                    ],

                    'PercentBased' =>
                        true,

                    'TaxPercent' =>
                        (float) $rate['percent'],

                    'NetAmountTaxable' =>
                        $taxableBase,
                ],
            ];
        }

        $detail = [
            'TotalTax' =>
                $taxAmount,

            'TaxLine' =>
                $taxLines,
        ];

        if (
            !empty(
                $configuration['tax_code_id']
            )
        ) {
            $detail['TxnTaxCodeRef'] = [
                'value' =>
                    (string) $configuration[
                        'tax_code_id'
                    ],
            ];
        }

        return $detail;
    }

    /**
     * Turn a QBO Fault response into a readable error for the browser/logs.
     */
    private function quickBooksFaultMessage(array $response): ?string
    {
        $fault = $response['Fault'] ?? null;

        if (!$fault) {
            return null;
        }

        $errors = $fault['Error'] ?? [];

        if (!is_array($errors)) {
            return 'QuickBooks returned an unknown error.';
        }

        $messages = [];

        foreach ($errors as $error) {
            $message = trim(
                (string) (
                    $error['Message']
                    ?? $error['Detail']
                    ?? ''
                )
            );

            $detail = trim(
                (string) ($error['Detail'] ?? '')
            );

            if ($message !== '' && $detail !== '' && $message !== $detail) {
                $message .= ': ' . $detail;
            }

            if ($message !== '') {
                $messages[] = $message;
            }
        }

        return !empty($messages)
            ? implode(' | ', $messages)
            : 'QuickBooks returned an unknown error.';
    }

    /**
     * Prefer the document number shown on the preview page. Auto sync has no
     * page, so it falls back to the existing sequential generator.
     */
    private function resolveQuickBooksDocNumber(
        array $data,
        bool $isRefund
    ): string {
        $provided = trim(
            (string) ($data['doc_number'] ?? '')
        );

        if ($provided !== '') {
            return mb_substr($provided, 0, 21);
        }

        return (string) (
            $isRefund
                ? QuickBooksService::generateRefundReceiptNo()
                : QuickBooksService::generateReceiptNo()
        );
    }

    private function getOrderDiscountAmount($order): float
    {
        if ((int) ($order->discount_hidation ?? 0) !== 1) {
            return 0.0;
        }

        $discount = (float) ($order->discount ?? 0);

        if ($discount <= 0) {
            return 0.0;
        }

        // This intentionally follows the existing transaction receipt calculation:
        // discount base = sub_total + artwork.
        $discountBase = (float) ($order->sub_total ?? 0)
            + (float) ($order->artwork ?? 0);

        if ((int) ($order->discountType ?? 0) === 1) {
            return round($discountBase * $discount / 100, 2);
        }

        if ((int) ($order->discountType ?? 0) === 2) {
            return round($discount, 2);
        }

        return 0.0;
    }

    private function getNormalPaymentAppliedAmount($transaction, string $type): float
    {
        $gross = (float) ($transaction->amount ?? 0);

        // Existing receipt behavior treats Card/Paypal amount as including a 3% fee.
        // The amount applied to the order is therefore 100 / 103 of the charged total.
        if (in_array($type, ['Card', 'Paypal'], true)) {
            return round($gross * 100 / 103, 2);
        }

        return round($gross, 2);
    }

    private function getNormalPaymentProcessingFee($transaction, string $type): float
    {
        if (!in_array($type, ['Card', 'Paypal'], true)) {
            return 0.0;
        }

        $gross = round((float) ($transaction->amount ?? 0), 2);
        $applied = $this->getNormalPaymentAppliedAmount($transaction, $type);

        return round(max(0, $gross - $applied), 2);
    }

    private function getStorePaymentAppliedAmount($transaction): float
    {
        return round((float) ($transaction->payment_amount ?? 0), 2);
    }

    private function applyExistingQuickBooksPreferences(array $data, ?QuickbookRecord $existingRecord, bool $isRefund = false): array
    {
        if (!$existingRecord) {
            return $data;
        }

        $preserveFields = [
            'customer_id',
            'email',
            'send_later',
            'receipt_date',
            'billing_address',
            'shipping_address',
            'ship_via',
            'shipping_date',
            'tracking_no',
            'location',
            'po_number',
            'sales_rep',
            'shipping_from',
            'payment_method_id',
            'reference_no',
        ];

        foreach ($preserveFields as $field) {
            if ($existingRecord->{$field} !== null && $existingRecord->{$field} !== '') {
                $data[$field] = $existingRecord->{$field};
            }
        }

        if ($existingRecord->deposit_account_id) {
            if ($isRefund) {
                $data['refund_from_account_id'] = $existingRecord->deposit_account_id;
            } else {
                $data['deposit_account_id'] = $existingRecord->deposit_account_id;
            }
        }

        /*
        |--------------------------------------------------------------------------
        | Restore user-edited receipt financial state
        |--------------------------------------------------------------------------
        |
        | New saves use an envelope inside the existing line_items JSON column.
        | This lets Save / AutoSync preserve edited products, rates and discount
        | type/value without requiring a database migration.
        |
        | Old legacy line_items arrays are intentionally NOT restored because some
        | older saved records contained full-order values for partial payments.
        */
        $savedFinancialState = json_decode(
            (string) ($existingRecord->line_items ?? ''),
            true
        );

        if (
            is_array($savedFinancialState)
            && ($savedFinancialState['_format'] ?? null) === 'qb_receipt_v2'
        ) {
            if (
                !empty($savedFinancialState['items'])
                && is_array($savedFinancialState['items'])
            ) {
                $data['line_items'] =
                    $savedFinancialState['items'];
            }

            foreach ([
                'discount_type',
                'discount_value',
                'discount_amount',
                'discount_percent',
                'discount_label',
                'discount_taxable',
                'discount_class',
                'tax_amount',
                'tax_percent',
                'doc_number',
            ] as $field) {
                if (
                    array_key_exists(
                        $field,
                        $savedFinancialState
                    )
                ) {
                    $data[$field] =
                        $savedFinancialState[$field];
                }
            }
        }

        $data['export_status'] = (int) ($existingRecord->export_status ?? 0);

        return $data;
    }

    private function normalizeItemsForQuickBooksRequest(array $items): array
    {
        foreach ($items as $key => $item) {
            if (!empty($item['tax'])) {
                $items[$key]['tax'] = 'on';
            } else {
                unset($items[$key]['tax']);
            }
        }

        return $items;
    }

    private function buildNormalReceiptData(
        $order,
        $transactionRecord,
        string $type,
        $customers,
        $paymentMethods,
        $depositAccounts,
        ?QuickbookRecord $existingRecord = null,
        $defaultCustomerId = null,
        $defaultDepositAccountId = null
    ): array {
        $customerId = $this->findQuickBooksCustomerId(
            $customers,
            $order->organizationDetails->organization_name ?? '',
            $defaultCustomerId
        );

        $paymentMethodId = $this->findQuickBooksPaymentMethodId(
            $paymentMethods,
            $type,
            43
        );

        $depositAccountId = $this->findQuickBooksAccountId(
            $depositAccounts,
            '12000 Undiposited Funds',
            $defaultDepositAccountId
        );

        $paymentApplied = $this->getNormalPaymentAppliedAmount(
            $transactionRecord,
            $type
        );

        $orderTotal = (float) ($order->order_total ?? 0);
        $paymentRatio = $orderTotal > 0
            ? ($paymentApplied / $orderTotal)
            : 1;

        $discountTotal = $this->getOrderDiscountAmount($order);
        $discountAmount = round(
            $discountTotal * $paymentRatio,
            2
        );

        $taxAmount = round(
            (float) ($order->sales_tax ?? 0)
            * $paymentRatio,
            2
        );

        $discountType = (int) ($order->discountType ?? 0) === 1
            ? 'percent'
            : 'amount';

        $discountPercent = $discountType === 'percent'
            ? round((float) ($order->discount ?? 0), 4)
            : null;

        $discountLabel = $discountType === 'percent'
            ? 'Order Discount (' . rtrim(
                rtrim(
                    number_format(
                        (float) ($order->discount ?? 0),
                        2
                    ),
                    '0'
                ),
                '.'
            ) . '%)'
            : 'Order Discount';

        $data = [
            'payment_type' => $type,
            'record_id' => $transactionRecord->id,
            'order_id' => $order->id,
            'customer_id' => $customerId,
            'email' => $order->contactDetails->email ?? '',
            'send_later' => 1,
            'receipt_date' => date('Y-m-d', strtotime($transactionRecord->created_at)),
            'billing_address' => $this->formatBillingAddress($order),
            'shipping_address' => $this->formatShippingAddress($order),
            'ship_via' => '',
            'shipping_date' => null,
            'tracking_no' => '',
            'location' => '',
            'po_number' => '',
            'sales_rep' => $order->userDetails->name ?? '',
            'shipping_from' => '891 4th St, San Rafael, CA 94901-3242',
            'payment_method_id' => $paymentMethodId,
            'reference_no' => $order->order_no,
            'deposit_account_id' => $depositAccountId,
            'from_tsr_module' => 0,

            // Keep discount separate from Product / Service rows.
            // importSalesReceipt() sends it as native QBO DiscountLineDetail.
            'discount_amount' => $discountAmount,
            'discount_type' => $discountType,
            'discount_value' => $discountType === 'percent'
                ? $discountPercent
                : $discountAmount,
            'discount_percent' => $discountPercent,
            'discount_label' => $discountLabel,
            'discount_taxable' => 1,
            'discount_class' => 'Encore Clothing:Team Sales',

            // Source payment's allocated sales tax. This is authoritative.
            'tax_amount' => $taxAmount,

            'line_items' => $this->generateDefaultLineItems(
                $order,
                $transactionRecord,
                $type
            ),

            // Save the amount actually applied to the order.
            'amount' => $paymentApplied,
            'export_status' => 0,
            'is_refund' => 0,
            'transaction_created_at' => $transactionRecord->created_at,
        ];

        return $this->applyExistingQuickBooksPreferences($data, $existingRecord, false);
    }

    private function buildStoreReceiptData(
        $storeOrder,
        $storeCardPayment,
        $customers,
        $paymentMethods,
        $depositAccounts,
        $refundFromAccounts,
        ?QuickbookRecord $existingRecord = null,
        $defaultCustomerId = null,
        $defaultAccountId = null
    ): array {
        $isRefund = (int) ($storeCardPayment->is_refund ?? 0);

        $customerId = $this->findQuickBooksCustomerId(
            $customers,
            $storeOrder->storeDetails->organizationDetails->organization_name ?? '',
            $defaultCustomerId
        );

        $paymentMethodId = $this->findQuickBooksPaymentMethodId(
            $paymentMethods,
            'Card',
            43
        );

        $depositAccountId = null;
        $refundFromAccountId = null;

        if ($isRefund === 1) {
            $refundFromAccountId = $this->findQuickBooksAccountId(
                $refundFromAccounts,
                '12000 Undiposited Funds',
                $defaultAccountId
            );
        } else {
            $depositAccountId = $this->findQuickBooksAccountId(
                $depositAccounts,
                '12000 Undiposited Funds',
                $defaultAccountId
            );
        }

        $lineItems = $isRefund === 1
            ? $this->generateStoreRefundDefaultLineItems($storeOrder, $storeCardPayment)
            : $this->generateStoreDefaultLineItems($storeOrder, $storeCardPayment);

        $amount = $isRefund === 1
            ? round((float) ($storeCardPayment->total_amount ?? (
                (float) ($storeCardPayment->payment_amount ?? 0)
                + (float) ($storeCardPayment->processing_fee ?? 0)
            )), 2)
            : $this->getStorePaymentAppliedAmount($storeCardPayment);

        $storeOrderTotal = (float) ($storeOrder->total ?? 0);

        $storePaymentRatio = (
            $isRefund === 0
            && $storeOrderTotal > 0
        )
            ? ($amount / $storeOrderTotal)
            : 0;

        $storeDiscountTotal = max(
            0,
            (float) ($storeOrder->discount ?? 0)
        );

        $storeDiscountAmount = $isRefund === 0
            ? round(
                $storeDiscountTotal * $storePaymentRatio,
                2
            )
            : 0.0;

        $storeTaxAmount = $isRefund === 0
            ? round(
                (float) ($storeOrder->sales_tax ?? 0)
                * $storePaymentRatio,
                2
            )
            : 0.0;

        $data = [
            'payment_type' => 'Card',
            'record_id' => $storeCardPayment->id,
            'order_id' => $storeOrder->id,
            'customer_id' => $customerId,
            'email' => $storeOrder->storeCustomer->email ?? '',
            'send_later' => 1,
            'receipt_date' => date('Y-m-d', strtotime($storeCardPayment->created_at)),
            'billing_address' => $this->formatStoreBillingAddress($storeOrder),
            'shipping_address' => $this->formatStoreShippingAddress($storeOrder),
            'ship_via' => '',
            'shipping_date' => null,
            'tracking_no' => '',
            'location' => '',
            'po_number' => '',
            'sales_rep' => $storeOrder->storeDetails->userDetails->name ?? '',
            'shipping_from' => '891 4th St, San Rafael, CA 94901-3242',
            'payment_method_id' => $paymentMethodId,
            'reference_no' => $storeOrder->order_no,
            'deposit_account_id' => $depositAccountId,
            'refund_from_account_id' => $refundFromAccountId,
            'from_tsr_module' => 1,

            // StoreOrder discount is currently a fixed amount.
            'discount_amount' => $storeDiscountAmount,
            'discount_type' => 'amount',
            'discount_value' => $storeDiscountAmount,
            'discount_percent' => null,
            'discount_label' => 'Order Discount',
            'discount_taxable' => 1,
            'discount_class' => 'Encore Clothing:Team Sales',

            // Source StoreOrder payment's allocated sales tax.
            'tax_amount' => $storeTaxAmount,

            'line_items' => $lineItems,
            'amount' => $amount,
            'export_status' => 0,
            'is_refund' => $isRefund,
            'transaction_created_at' => $storeCardPayment->created_at,
        ];

        return $this->applyExistingQuickBooksPreferences($data, $existingRecord, $isRefund === 1);
    }

    /* ======================================
       LOAD IMPORT PAGE
    ====================================== */

    public function importToQuickBooks(Request $request)
    {
        if (!session()->has('quickbooks.access_token')) {
            return redirect('/quickbooks/connect');
        }

        $transactions = collect(json_decode($request->input('transactions', '[]'), true) ?: [])
            ->filter(fn ($item) => isset($item['id'], $item['type'], $item['auto_generated']))
            ->unique(fn ($item) => (int) $item['auto_generated'] . '|' . $item['type'] . '|' . (int) $item['id'])
            ->values();

        $storeTransactions = collect(json_decode($request->input('store_transactions', '[]'), true) ?: [])
            ->filter(fn ($item) => isset($item['id'], $item['parentId']))
            ->unique(fn ($item) => (int) $item['parentId'] . '|' . (int) $item['id'])
            ->values();

        $salesReceiptDataList = collect();
        $alreadySynced = 0;

        $customers = collect(QuickBooksService::getCustomers());
        $paymentMethods = collect(QuickBooksService::getPaymentMethods());
        $depositAccounts = collect(QuickBooksService::getDepositAccounts());
        $refundFromAccounts = collect(QuickBooksService::getRefundAccounts());
        $locations = collect(QuickBooksService::getLocations());
        $lines = collect(QuickBooksService::getItems());

        /*
        |--------------------------------------------------------------------------
        | Manual-page defaults
        |--------------------------------------------------------------------------
        | These are the same defaults your automatic sync was already using.
        | They are applied only when those IDs actually exist in the current
        | QuickBooks company.
        */
        $defaultCustomerId = $this->validQuickBooksDefaultId(
            $customers,
            config('services.qbo.default_customer_id', 8853)
        );

        $defaultDepositAccountId = $this->validQuickBooksDefaultId(
            $depositAccounts,
            config('services.qbo.default_deposit_account_id', 148)
        );

        $defaultRefundAccountId = $this->validQuickBooksDefaultId(
            $refundFromAccounts,
            config(
                'services.qbo.default_refund_account_id',
                config('services.qbo.default_deposit_account_id', 148)
            )
        );

        foreach ($transactions as $transaction) {
            $isAutoGenerated = (int) $transaction['auto_generated'] === 1;

            if (!$isAutoGenerated) {
                $transactionRecord = $this->findPaymentRecord(
                    (string) $transaction['type'],
                    (int) $transaction['id']
                );

                if (!$transactionRecord) {
                    continue;
                }

                $order = Order::with(
                    'organizationDetails',
                    'contactDetails',
                    'userDetails'
                )->find($transactionRecord->order_id);

                if (!$order) {
                    continue;
                }

                $type = (string) $transaction['type'];

                $existingRecord = $this->quickbookRecordQuery(
                    $order->id,
                    $transactionRecord->id,
                    $type,
                    0,
                    0
                )->first();

                if ($existingRecord && (int) $existingRecord->export_status === 1) {
                    $alreadySynced++;
                    continue;
                }

                // Regenerate financial lines for unsynced/saved/failed records so
                // old full-order line items are not reused for a partial payment.
                $salesReceiptData = $this->buildNormalReceiptData(
                    $order,
                    $transactionRecord,
                    $type,
                    $customers,
                    $paymentMethods,
                    $depositAccounts,
                    $existingRecord,
                    $defaultCustomerId,
                    $defaultDepositAccountId
                );

                $salesReceiptDataList->push($salesReceiptData);
                continue;
            }

            $storeRecordIds = $storeTransactions
                ->where('parentId', $transaction['id'])
                ->pluck('id')
                ->map(fn ($id) => (int) $id)
                ->unique()
                ->values();

            if ($storeRecordIds->isEmpty()) {
                continue;
            }

            $storeCardPayments = StoreCardPayment::whereIn('id', $storeRecordIds)->get();

            foreach ($storeCardPayments as $storeCardPayment) {
                $storeOrder = StoreOrder::with(
                    'storeDetails.organizationDetails',
                    'storeDetails.userDetails',
                    'storeCustomer'
                )
                    ->where('order_no', $storeCardPayment->store_order_no)
                    ->first();

                if (!$storeOrder) {
                    continue;
                }

                $isRefund = (int) ($storeCardPayment->is_refund ?? 0);

                $existingRecord = $this->quickbookRecordQuery(
                    $storeOrder->id,
                    $storeCardPayment->id,
                    'Card',
                    1,
                    $isRefund
                )->first();

                if ($existingRecord && (int) $existingRecord->export_status === 1) {
                    $alreadySynced++;
                    continue;
                }

                $salesReceiptData = $this->buildStoreReceiptData(
                    $storeOrder,
                    $storeCardPayment,
                    $customers,
                    $paymentMethods,
                    $depositAccounts,
                    $refundFromAccounts,
                    $existingRecord,
                    $defaultCustomerId,
                    $isRefund === 1
                        ? $defaultRefundAccountId
                        : $defaultDepositAccountId
                );

                $salesReceiptDataList->push($salesReceiptData);
            }
        }

        if ($salesReceiptDataList->isEmpty() && $alreadySynced > 0) {
            return redirect()
                ->route('allTransactions')
                ->with('warning', 'The selected payment record(s) are already synced to QuickBooks.');
        }

        return view('pages.accounting.quickbooks.index', [
            'salesReceiptDataList' => $salesReceiptDataList,
            'customers' => $customers,
            'paymentMethods' => $paymentMethods,
            'depositAccounts' => $depositAccounts,
            'refundFromAccounts' => $refundFromAccounts,
            'locations' => $locations,
            'lines' => $lines,
            'receipt_no' => QuickBooksService::generateReceiptNo(),
            'refund_receipt_no' => QuickBooksService::generateRefundReceiptNo(),
            'alreadySyncedCount' => $alreadySynced,
        ]);
    }

    private function generateDefaultLineItems($order, $transaction, $type)
    {
        $paymentApplied = $this->getNormalPaymentAppliedAmount($transaction, $type);

        if ($paymentApplied <= 0) {
            return [];
        }

        $orderTotal = (float) ($order->order_total ?? 0);
        $ratio = $orderTotal > 0 ? ($paymentApplied / $orderTotal) : 1;

        $discountTotal = $this->getOrderDiscountAmount($order);
        $discountShare = round($discountTotal * $ratio, 2);
        $shippingShare = round((float) ($order->shipping ?? 0) * $ratio, 2);
        $taxShare = round((float) ($order->sales_tax ?? 0) * $ratio, 2);

        // order_total is authoritative. The merchandise line absorbs rounding so:
        // merchandise - discount + shipping + allocated tax = this payment amount.
        $merchandiseShare = round(
            $paymentApplied - $taxShare - $shippingShare + $discountShare,
            2
        );

        $returnArray = [];

        if (abs($merchandiseShare) >= 0.005) {
            $returnArray[] = [
                'product' => 'Team Sales Item',
                'sku' => '',
                'description' => 'Order #' . $order->order_no . ' - payment allocation',
                'qty' => 1,
                'rate' => $merchandiseShare,
                'amount' => $merchandiseShare,
                'tax' => $taxShare > 0 ? 1 : 0,
                'class' => 'Encore Clothing:Team Sales',
            ];
        }

        // Discount is intentionally not added to line_items.
        // It is sent later as QBO DiscountLineDetail.

        if (abs($shippingShare) >= 0.005) {
            $returnArray[] = [
                'product' => 'Shipping',
                'sku' => '',
                'description' => 'Shipping - Order #' . $order->order_no,
                'qty' => 1,
                'rate' => $shippingShare,
                'amount' => $shippingShare,
                'tax' => 0,
                'class' => 'Encore Clothing:Team Sales',
            ];
        }

        $processingFee = $this->getNormalPaymentProcessingFee($transaction, $type);

        if ($processingFee > 0 && $type === 'Card') {
            $returnArray[] = [
                'product' => 'Credit Card Processing Fee',
                'sku' => '',
                'description' => 'PLEASE DISREGARD AND PAY ONLY IF PAYING BY CASH OR CHECK',
                'qty' => 1,
                'rate' => $processingFee,
                'amount' => $processingFee,
                'tax' => 0,
                'class' => 'Encore Clothing:Team Sales',
            ];

            $returnArray[] = [
                'product' => 'Authorize.Net Fee',
                'sku' => '',
                'description' => 'Authorize.Net Fee',
                'qty' => 1,
                'rate' => -$processingFee,
                'amount' => -$processingFee,
                'tax' => 0,
                'class' => 'Encore Clothing:Team Sales',
            ];
        } elseif ($processingFee > 0 && $type === 'Paypal') {
            $returnArray[] = [
                'product' => 'Paypal fee',
                'sku' => '',
                'description' => 'PLEASE DISREGARD AND PAY ONLY IF PAYING BY CASH OR CHECK',
                'qty' => 1,
                'rate' => $processingFee,
                'amount' => $processingFee,
                'tax' => 0,
                'class' => 'Encore Clothing:Team Sales',
            ];

            $returnArray[] = [
                'product' => 'Authorize.Net Fee',
                'sku' => '',
                'description' => 'Authorize.Net Fee',
                'qty' => 1,
                'rate' => -$processingFee,
                'amount' => -$processingFee,
                'tax' => 0,
                'class' => 'Encore Clothing:Team Sales',
            ];
        }

        return $returnArray;
    }

    private function generateStoreDefaultLineItems($order, $transaction)
    {
        $paymentApplied = $this->getStorePaymentAppliedAmount($transaction);

        if ($paymentApplied <= 0) {
            return [];
        }

        $orderTotal = (float) ($order->total ?? 0);
        $ratio = $orderTotal > 0 ? ($paymentApplied / $orderTotal) : 1;

        $discountTotal = max(0, (float) ($order->discount ?? 0));
        $discountShare = round($discountTotal * $ratio, 2);
        $shippingShare = round((float) ($order->shipping ?? 0) * $ratio, 2);
        $taxShare = round((float) ($order->sales_tax ?? 0) * $ratio, 2);

        $merchandiseShare = round(
            $paymentApplied - $taxShare - $shippingShare + $discountShare,
            2
        );

        $returnArray = [];

        if (abs($merchandiseShare) >= 0.005) {
            $returnArray[] = [
                'product' => 'Team Sales Item',
                'sku' => '',
                'description' => $order->order_no . ' - payment allocation',
                'qty' => 1,
                'rate' => $merchandiseShare,
                'amount' => $merchandiseShare,
                'tax' => $taxShare > 0 ? 1 : 0,
                'class' => 'Encore Clothing:Team Sales',
            ];
        }

        // Discount is intentionally not added to line_items.
        // It is sent later as QBO DiscountLineDetail.

        if (abs($shippingShare) >= 0.005) {
            $returnArray[] = [
                'product' => 'Shipping',
                'sku' => '',
                'description' => 'Shipping - ' . $order->order_no,
                'qty' => 1,
                'rate' => $shippingShare,
                'amount' => $shippingShare,
                'tax' => 0,
                'class' => 'Encore Clothing:Team Sales',
            ];
        }

        $processingFee = round((float) ($transaction->processing_fee ?? 0), 2);

        if ($processingFee > 0) {
            $returnArray[] = [
                'product' => 'Credit Card Processing Fee',
                'sku' => '',
                'description' => 'PLEASE DISREGARD AND PAY ONLY IF PAYING BY CASH OR CHECK',
                'qty' => 1,
                'rate' => $processingFee,
                'amount' => $processingFee,
                'tax' => 0,
                'class' => 'Encore Clothing:Team Sales',
            ];

            $returnArray[] = [
                'product' => 'Authorize.Net Fee',
                'sku' => '',
                'description' => 'Authorize.Net Fee',
                'qty' => 1,
                'rate' => -$processingFee,
                'amount' => -$processingFee,
                'tax' => 0,
                'class' => 'Encore Clothing:Team Sales',
            ];
        }

        return $returnArray;
    }

    private function generateStoreRefundDefaultLineItems($order, $transaction)
    {
        return [
            [
                'product' => 'Team Sales Item',
                'sku' => '',
                'description' => $order->order_no . ' - REFUND ($' . number_format($transaction->payment_amount, 2) . ')',
                'qty' => 1,
                'rate' => $transaction->payment_amount,
                'amount' => $transaction->payment_amount,
                'tax' => 1,
                'class' => 'Encore Clothing:Team Sales',
            ],
            [
                'product' => 'Authorize.Net Fee',
                'sku' => '',
                'description' => 'Authorize.Net Fee',
                'qty' => 1,
                'rate' => ($transaction->processing_fee),
                'amount' => ($transaction->processing_fee),
                'tax' => 0,
                'class' => 'Encore Clothing:Team Sales',
            ]
        ];
    }

    private function formatBillingAddress($order)
    {
        $c = $order->contactDetails;

        return implode("\n", array_filter([
            trim($c->first_name . ' ' . $c->last_name),
            $c->shipping_street,
            trim($c->shipping_city . ', ' . $c->shipping_state . ' ' . $c->shipping_zip),
            $c->shipping_country,
        ]));
    }

    private function formatShippingAddress($order)
    {
        $c = $order->contactDetails;

        return implode("\n", array_filter([
            trim($c->first_name . ' ' . $c->last_name),
            $order->street,
            trim($order->city . ', ' . $order->state . ' ' . $order->postal_code),
            $order->country,
        ]));
    }

    private function formatStoreBillingAddress($order)
    {
        $c = $order->storeCustomer;

        return implode("\n", array_filter([
            trim($c->first_name . ' ' . $c->last_name),
            $c->street,
            trim($c->city . ', ' . $c->state . ' ' . $c->postal_code),
            $c->country,
        ]));
    }

    private function formatStoreShippingAddress($order)
    {
        return implode("\n", array_filter([
            trim($order->first_name . ' ' . $order->last_name),
            $order->street,
            trim($order->city . ', ' . $order->state . ' ' . $order->postal_code),
            $order->country,
        ]));
    }

    /* ======================================
       EXPORT SALES RECEIPT
    ====================================== */

    public function importSalesReceipt(Request $request)
    {
        $data = $request->all();

        $exportStatus = (int) ($data['export_status'] ?? 0);
        $isRefund = (int) ($data['is_refund'] ?? 0);
        $fromTsrModule = (int) ($data['from_tsr_module'] ?? 0);
        $paymentType = (string) ($data['payment_type'] ?? '');

        $recordKey = [
            'order_id' => (string) ($data['order_id'] ?? ''),
            'record_id' => (int) ($data['record_id'] ?? 0),
            'payment_type' => $paymentType,
            'from_tsr_module' => $fromTsrModule,
            'is_refund' => $isRefund,
        ];

        if ($recordKey['order_id'] === '' || $recordKey['record_id'] <= 0 || $paymentType === '') {
            return response()->json([
                'success' => false,
                'error' => 'Invalid QuickBooks payment identity.',
            ], 422);
        }

        $accountId = $isRefund === 1
            ? ($data['refund_from_account_id'] ?? null)
            : ($data['deposit_account_id'] ?? null);

        $existingRecord = $this->quickbookRecordQuery(
            $recordKey['order_id'],
            $recordKey['record_id'],
            $recordKey['payment_type'],
            $recordKey['from_tsr_module'],
            $recordKey['is_refund']
        )->first();

        // Never downgrade or overwrite an already exported payment.
        if ($existingRecord && (int) $existingRecord->export_status === 1) {
            return response()->json([
                'success' => true,
                'already_exported' => true,
                'message' => 'This exact payment record is already synced to QuickBooks.',
                'receipt' => json_decode($existingRecord->qb_raw_response ?? '[]', true),
            ]);
        }

        $persistRecord = function () use (
            $data,
            $recordKey,
            $accountId,
            $exportStatus
        ) {
            return QuickbookRecord::updateOrCreate(
                $recordKey,
                [
                    'transaction_created_at' => $data['transaction_created_at'] ?? null,
                    'customer_id' => $data['customer_id'] ?? null,
                    'email' => $data['email'] ?? null,
                    'send_later' => $data['send_later'] ?? 1,
                    'receipt_date' => $data['receipt_date'] ?? null,
                    'billing_address' => $data['billing_address'] ?? null,
                    'shipping_address' => $data['shipping_address'] ?? null,
                    'ship_via' => $data['ship_via'] ?? null,
                    'shipping_date' => $data['shipping_date'] ?? null,
                    'tracking_no' => $data['tracking_no'] ?? null,
                    'location' => $data['location'] ?? null,
                    'po_number' => $data['po_number'] ?? null,
                    'sales_rep' => $data['sales_rep'] ?? null,
                    'shipping_from' => $data['shipping_from'] ?? null,
                    'payment_method_id' => $data['payment_method_id'] ?? null,
                    'reference_no' => $data['reference_no'] ?? null,
                    // Existing schema stores the selected sales/refund account here.
                    'deposit_account_id' => $accountId,

                    /*
                     * Preserve the editable QBO-style receipt exactly as the user
                     * saved it, including percent/value discount selection.
                     */
                    'line_items' => json_encode([
                        '_format' => 'qb_receipt_v2',
                        'items' => array_values(
                            $data['items'] ?? []
                        ),
                        'discount_type' =>
                            ($data['discount_type'] ?? 'amount') === 'percent'
                                ? 'percent'
                                : 'amount',
                        'discount_value' => round(
                            max(
                                0,
                                (float) (
                                    $data['discount_value']
                                    ?? (
                                        ($data['discount_type'] ?? 'amount') === 'percent'
                                            ? ($data['discount_percent'] ?? 0)
                                            : ($data['discount_amount'] ?? 0)
                                    )
                                )
                            ),
                            4
                        ),
                        'discount_amount' => round(
                            max(
                                0,
                                (float) ($data['discount_amount'] ?? 0)
                            ),
                            2
                        ),
                        'discount_percent' => (
                            ($data['discount_type'] ?? 'amount') === 'percent'
                                ? round(
                                    max(
                                        0,
                                        (float) ($data['discount_percent'] ?? 0)
                                    ),
                                    4
                                )
                                : null
                        ),
                        'discount_label' =>
                            $data['discount_label']
                            ?? 'Order Discount',
                        'discount_taxable' =>
                            !empty($data['discount_taxable'])
                                ? 1
                                : 0,
                        'discount_class' =>
                            $data['discount_class']
                            ?? 'Encore Clothing:Team Sales',

                        'tax_amount' => round(
                            max(
                                0,
                                (float) (
                                    $data['tax_amount']
                                    ?? 0
                                )
                            ),
                            2
                        ),

                        'tax_percent' => (
                            isset($data['tax_percent'])
                            && $data['tax_percent'] !== ''
                                ? round(
                                    max(
                                        0,
                                        (float) $data['tax_percent']
                                    ),
                                    6
                                )
                                : null
                        ),

                        'doc_number' =>
                            $data['doc_number']
                            ?? null,
                    ]),
                    'amount' => round((float) ($data['amount'] ?? 0), 2),
                    // Do not mark as exported until QuickBooks confirms success.
                    'export_status' => 0,
                ]
            );
        };

        if ($exportStatus === 0) {
            $quickbookRecord = $persistRecord();

            return response()->json([
                'success' => true,
                'message' => $isRefund === 1
                    ? 'Refund receipt data saved successfully'
                    : 'Sales receipt data saved successfully',
                'record_id' => $quickbookRecord->id,
            ]);
        }

        $lockKey = implode(':', [
            'quickbooks-export',
            $fromTsrModule,
            $recordKey['order_id'],
            strtolower($paymentType),
            $recordKey['record_id'],
            $isRefund,
        ]);

        $lock = Cache::lock($lockKey, 120);

        if (!$lock->get()) {
            return response()->json([
                'success' => false,
                'error' => 'This payment is already being synced to QuickBooks. Please wait.',
            ], 423);
        }

        try {
            // Re-check inside the lock to prevent a double-click/concurrent request
            // from creating a second QuickBooks transaction.
            $existingRecord = $this->quickbookRecordQuery(
                $recordKey['order_id'],
                $recordKey['record_id'],
                $recordKey['payment_type'],
                $recordKey['from_tsr_module'],
                $recordKey['is_refund']
            )->first();

            if ($existingRecord && (int) $existingRecord->export_status === 1) {
                return response()->json([
                    'success' => true,
                    'already_exported' => true,
                    'message' => 'This exact payment record is already synced to QuickBooks.',
                    'receipt' => json_decode($existingRecord->qb_raw_response ?? '[]', true),
                ]);
            }

            $quickbookRecord = $persistRecord();

            if (empty($data['items']) || !is_array($data['items'])) {
                throw new \Exception('No line items found.');
            }

            if (empty($data['customer_id'])) {
                throw new \Exception('Customer ID is required.');
            }

            if (empty($accountId)) {
                throw new \Exception(
                    $isRefund === 1
                        ? 'Refund From Account ID is required.'
                        : 'Deposit Account ID is required.'
                );
            }

            $qbItems = QuickBooksService::getItems();
            $qbClasses = QuickBooksService::getLocations();

            $discountAccountId =
                $this->getQuickBooksDiscountAccountId();

            $docNumber = $this->resolveQuickBooksDocNumber(
                $data,
                $isRefund === 1
            );

            /*
            |--------------------------------------------------------------------------
            | Product / Service lines
            |--------------------------------------------------------------------------
            |
            | Discount is NOT a Product / Service item. Keep merchandise before
            | the native QuickBooks discount, and keep shipping/fees after it.
            */

            $preDiscountLineItems = [];
            $postDiscountLineItems = [];

            $postDiscountProducts = [
                'shipping',
                'credit card processing fee',
                'paypal fee',
                'authorize.net fee',
            ];

            foreach ($data['items'] as $item) {
                $productName = trim(
                    strtolower($item['product'] ?? '')
                );

                if ($productName === '') {
                    throw new \Exception(
                        'Product name is required for each line item.'
                    );
                }

                $itemId = null;

                foreach ($qbItems as $qbItem) {
                    if (
                        trim(
                            strtolower(
                                (string) ($qbItem['Name'] ?? '')
                            )
                        ) === $productName
                    ) {
                        $itemId = $qbItem['Id'];
                        break;
                    }
                }

                if (!$itemId) {
                    throw new \Exception(
                        "Item '{$item['product']}' not found in QuickBooks."
                    );
                }

                $classId = null;

                if (!empty($item['class'])) {
                    foreach ($qbClasses as $class) {
                        if (
                            stripos(
                                $item['class'],
                                $class->name
                            ) !== false
                        ) {
                            $classId = $class->id;
                            break;
                        }
                    }
                }

                $qty = (float) ($item['qty'] ?? 1);

                $amount = round(
                    (float) ($item['amount'] ?? 0),
                    2
                );

                $rate = (
                    isset($item['rate'])
                    && $item['rate'] !== ''
                )
                    ? round((float) $item['rate'], 2)
                    : $amount;

                if ($qty <= 0) {
                    $qty = 1;
                }

                $taxValue = $item['tax'] ?? null;

                $isTaxable = in_array(
                    $taxValue,
                    ['on', '1', 1, true],
                    true
                );

                $detail = [
                    'ItemRef' => [
                        'value' => $itemId,
                    ],
                    'UnitPrice' => $rate,
                    'Qty' => $qty,
                    'TaxCodeRef' => [
                        'value' => $isTaxable
                            ? 'TAX'
                            : 'NON',
                    ],
                ];

                if ($classId) {
                    $detail['ClassRef'] = [
                        'value' => $classId,
                    ];
                }

                $lineItem = [
                    'DetailType' => 'SalesItemLineDetail',
                    'Amount' => $amount,
                    'SalesItemLineDetail' => $detail,
                ];

                if (!empty($item['description'])) {
                    $lineItem['Description'] =
                        $item['description'];
                }

                if (
                    in_array(
                        $productName,
                        $postDiscountProducts,
                        true
                    )
                ) {
                    $postDiscountLineItems[] = $lineItem;
                } else {
                    $preDiscountLineItems[] = $lineItem;
                }
            }

            /*
            |--------------------------------------------------------------------------
            | Native QuickBooks discount
            |--------------------------------------------------------------------------
            |
            | IMPORTANT:
            | DiscountLineDetail Amount is POSITIVE. QBO subtracts it because the
            | DetailType itself is a discount.
            */

            /*
             * The visible page lets the user choose the same two discount modes
             * QuickBooks exposes: Discount percent or Discount value.
             *
             * Never trust the browser's calculated discount_amount for a
             * percentage. Recalculate it from the actual pre-discount QBO lines.
             */
            $discountBase = round(
                array_reduce(
                    $preDiscountLineItems,
                    function ($total, $line) {
                        return $total
                            + (float) ($line['Amount'] ?? 0);
                    },
                    0.0
                ),
                2
            );

            $discountType = (
                ($data['discount_type'] ?? 'amount')
                === 'percent'
            )
                ? 'percent'
                : 'amount';

            $discountValue = max(
                0,
                (float) (
                    $data['discount_value']
                    ?? (
                        $discountType === 'percent'
                            ? ($data['discount_percent'] ?? 0)
                            : ($data['discount_amount'] ?? 0)
                    )
                )
            );

            $discountPercent = null;
            $discountAmount = 0.0;

            if (
                $isRefund !== 1
                && $discountValue > 0
            ) {
                if ($discountType === 'percent') {
                    if ($discountValue > 100) {
                        throw new \Exception(
                            'Discount percent cannot be greater than 100%.'
                        );
                    }

                    $discountPercent = round(
                        $discountValue,
                        4
                    );

                    $discountAmount = round(
                        $discountBase
                        * $discountPercent
                        / 100,
                        2
                    );
                } else {
                    $discountAmount = round(
                        $discountValue,
                        2
                    );

                    if (
                        $discountBase > 0
                        && $discountAmount > $discountBase
                    ) {
                        throw new \Exception(
                            'Discount value cannot be greater than the discountable subtotal of $'
                            . number_format($discountBase, 2)
                            . '.'
                        );
                    }
                }
            }

            $discountLabel =
                $discountType === 'percent'
                && $discountPercent !== null
                    ? 'Order Discount ('
                        . rtrim(
                            rtrim(
                                number_format(
                                    $discountPercent,
                                    4
                                ),
                                '0'
                            ),
                            '.'
                        )
                        . '%)'
                    : 'Order Discount';

            $discountLine = null;

            if (
                $isRefund !== 1
                && $discountAmount > 0
            ) {
                $discountDetail = [
                    'PercentBased' =>
                        $discountType === 'percent',

                    'TaxCodeRef' => [
                        'value' =>
                            !empty($data['discount_taxable'])
                                ? 'TAX'
                                : 'NON',
                    ],
                ];

                if (
                    $discountType === 'percent'
                    && $discountPercent !== null
                    && $discountPercent > 0
                ) {
                    $discountDetail['DiscountPercent'] =
                        $discountPercent;
                }

                $discountClassId = null;

                $discountClassName = trim(
                    (string) (
                        $data['discount_class']
                        ?? ''
                    )
                );

                if ($discountClassName !== '') {
                    foreach ($qbClasses as $class) {
                        if (
                            stripos(
                                $discountClassName,
                                $class->name
                            ) !== false
                        ) {
                            $discountClassId = $class->id;
                            break;
                        }
                    }
                }

                if ($discountClassId) {
                    $discountDetail['ClassRef'] = [
                        'value' => $discountClassId,
                    ];
                }

                if ($discountAccountId) {
                    $discountDetail['DiscountAccountRef'] = [
                        'value' => (string) $discountAccountId,
                    ];
                }

                $discountLine = [
                    'DetailType' => 'DiscountLineDetail',

                    // Positive value; QuickBooks treats it as a reduction.
                    'Amount' => $discountAmount,

                    'Description' => $discountLabel,

                    'DiscountLineDetail' => $discountDetail,
                ];
            }

            $lineItems = $preDiscountLineItems;

            if ($discountLine) {
                $lineItems[] = $discountLine;
            }

            $lineItems = array_merge(
                $lineItems,
                $postDiscountLineItems
            );

            /*
            |--------------------------------------------------------------------------
            | Source sales tax
            |--------------------------------------------------------------------------
            |
            | The previous implementation displayed the source tax in the Blade
            | but did not send TxnTaxDetail. QBO therefore returned TotalTax=0
            | for some receipts even when a line had TaxCodeRef=TAX.
            |
            | Build the exact taxable base from checked line items, reduce it by
            | the taxable discount, then map the source tax to an actual QBO tax
            | code/rate.
            */
            $taxablePreDiscountSubtotal = 0.0;
            $taxablePostDiscountSubtotal = 0.0;

            foreach ($preDiscountLineItems as $line) {
                $taxCode = data_get(
                    $line,
                    'SalesItemLineDetail.TaxCodeRef.value'
                );

                if ($taxCode === 'TAX') {
                    $taxablePreDiscountSubtotal +=
                        (float) ($line['Amount'] ?? 0);
                }
            }

            foreach ($postDiscountLineItems as $line) {
                $taxCode = data_get(
                    $line,
                    'SalesItemLineDetail.TaxCodeRef.value'
                );

                if ($taxCode === 'TAX') {
                    $taxablePostDiscountSubtotal +=
                        (float) ($line['Amount'] ?? 0);
                }
            }

            $taxableDiscountAmount = (
                !empty($data['discount_taxable'])
                && $discountAmount > 0
            )
                ? min(
                    $discountAmount,
                    max(
                        0,
                        $taxablePreDiscountSubtotal
                    )
                )
                : 0.0;

            $taxableBase = round(
                max(
                    0,
                    $taxablePreDiscountSubtotal
                    - $taxableDiscountAmount
                )
                + max(
                    0,
                    $taxablePostDiscountSubtotal
                ),
                2
            );

            $sourceTaxAmount = round(
                max(
                    0,
                    (float) (
                        $data['tax_amount']
                        ?? 0
                    )
                ),
                2
            );

            $sourceTaxPercent = (
                $sourceTaxAmount > 0
                && $taxableBase > 0
            )
                ? round(
                    ($sourceTaxAmount / $taxableBase)
                    * 100,
                    6
                )
                : 0.0;

            $txnTaxDetail = null;

            if (
                $isRefund !== 1
                && $sourceTaxAmount > 0
            ) {
                $txnTaxDetail =
                    $this->buildQuickBooksTxnTaxDetail(
                        $taxableBase,
                        $sourceTaxAmount
                    );
            }

            $commonPayload = [
                'CustomerRef' => [
                    'value' => (string) $data['customer_id'],
                ],

                'TxnDate' => $data['receipt_date'],

                'Line' => $lineItems,

                // A discount reduces the taxable base in the source order.
                'ApplyTaxAfterDiscount' => $discountAmount > 0,

                'PrivateNote' =>
                    "Order ID: {$data['order_id']}, Payment Record: {$data['record_id']}, "
                    . "Module: " . ($fromTsrModule ? 'StoreOrder' : 'Order')
                    . ", Payment Type: {$paymentType}"
                    . ", Email: " . ($data['email'] ?? ''),
            ];

            /*
             * If source tax is zero, explicitly mark the transaction as having
             * no tax intent by leaving TxnTaxDetail out. If source tax is
             * positive, send the exact source amount and the matched QBO rate.
             */
            if ($txnTaxDetail) {
                $commonPayload['TxnTaxDetail'] =
                    $txnTaxDetail;

                $commonPayload['GlobalTaxCalculation'] =
                    'TaxExcluded';
            }

            if (!empty($data['reference_no'])) {
                $commonPayload['PaymentRefNum'] =
                    mb_substr(
                        (string) $data['reference_no'],
                        0,
                        21
                    );
            }

            if (!empty($data['po_number'])) {
                $commonPayload['PONumber'] =
                    mb_substr(
                        (string) $data['po_number'],
                        0,
                        15
                    );
            }

            if (!empty($data['email']) && filter_var($data['email'], FILTER_VALIDATE_EMAIL)) {
                $commonPayload['BillEmail'] = [
                    'Address' => mb_substr(
                        (string) $data['email'],
                        0,
                        100
                    ),
                ];
            }

            $billAddress = $this->quickBooksAddressFromText(
                $data['billing_address'] ?? null
            );

            if ($billAddress) {
                $commonPayload['BillAddr'] = $billAddress;
            }

            $shipAddress = $this->quickBooksAddressFromText(
                $data['shipping_address'] ?? null
            );

            if ($shipAddress) {
                $commonPayload['ShipAddr'] = $shipAddress;
            }

            $shipFromAddress = $this->quickBooksAddressFromText(
                $data['shipping_from'] ?? null
            );

            if ($shipFromAddress) {
                $commonPayload['ShipFromAddr'] =
                    $shipFromAddress;
            }

            if (!empty($data['shipping_date'])) {
                $commonPayload['ShipDate'] =
                    $data['shipping_date'];
            }

            if (!empty($data['tracking_no'])) {
                $commonPayload['TrackingNum'] =
                    mb_substr(
                        (string) $data['tracking_no'],
                        0,
                        31
                    );
            }

            if ($isRefund === 1) {
                $receiptPayload = array_merge(
                    $commonPayload,
                    [
                        'DepositToAccountRef' => [
                            'value' => (string) $data['refund_from_account_id'],
                        ],

                        'PaymentMethodRef' => [
                            'value' => (string) $data['payment_method_id'],
                        ],

                        'DocNumber' => $docNumber,
                        'AutoDocNumber' => false,
                    ]
                );

                \Log::info('QBO RefundReceipt Payload', $receiptPayload);

                // TEST ONLY:
                // Uncomment the next line to inspect the exact payload WITHOUT syncing.
                // dd($receiptPayload);

                $receipt = QuickBooksService::createRefundReceipt(
                    $receiptPayload
                );

                if ($faultMessage = $this->quickBooksFaultMessage($receipt)) {
                    throw new \Exception($faultMessage);
                }

                $qbTxn = $receipt['RefundReceipt'] ?? [];
                $successMessage = 'Refund receipt imported successfully';
            } else {
                $receiptPayload = array_merge($commonPayload, [
                    'DepositToAccountRef' => [
                        'value' => (string) $accountId,
                    ],
                    'PaymentMethodRef' => [
                        'value' => (string) $data['payment_method_id'],
                    ],
                    'DocNumber' => $docNumber,
                    'AutoDocNumber' => false,
                ]);

                \Log::info(
                    'QBO SalesReceipt Payload',
                    [
                        'payload' => $receiptPayload,
                        'source_tax_amount' => $sourceTaxAmount,
                        'source_tax_percent' => $sourceTaxPercent,
                        'taxable_base' => $taxableBase,
                    ]
                );

                // TEST ONLY:
                // Uncomment the next line to inspect the exact payload WITHOUT syncing.
                // dd($receiptPayload);

                $receipt = QuickBooksService::createSalesReceipt(
                    $receiptPayload
                );

                if ($faultMessage = $this->quickBooksFaultMessage($receipt)) {
                    throw new \Exception($faultMessage);
                }

                $qbTxn = $receipt['SalesReceipt'] ?? [];
                $successMessage = 'Sales receipt imported successfully';
            }

            if (empty($qbTxn['Id'])) {
                throw new \Exception('QuickBooks did not return a transaction ID.');
            }

            $quickbookRecord->update([
                'export_status' => 1,
                'sales_receipt_id' => $qbTxn['Id'],
                'qb_doc_number' => $qbTxn['DocNumber'] ?? null,
                'qb_sync_token' => $qbTxn['SyncToken'] ?? null,
                'qb_raw_response' => json_encode($receipt),
                'error_message' => null,
            ]);

            $expectedAmount = round(
                (float) ($data['amount'] ?? 0),
                2
            );

            $quickBooksAmount = isset($qbTxn['TotalAmt'])
                ? round((float) $qbTxn['TotalAmt'], 2)
                : null;

            $amountMismatch = (
                $quickBooksAmount !== null
                && abs($quickBooksAmount - $expectedAmount) >= 0.02
            );

            if ($amountMismatch) {
                \Log::warning(
                    'QuickBooks receipt total differs from payment amount',
                    [
                        'key' => $recordKey,
                        'expected_amount' => $expectedAmount,
                        'quickbooks_amount' => $quickBooksAmount,
                        'sales_receipt_id' => $qbTxn['Id'],
                    ]
                );
            }

            return response()->json([
                'success' => true,
                'already_exported' => false,
                'message' => $successMessage,
                'receipt' => $receipt,
                'expected_amount' => $expectedAmount,
                'quickbooks_amount' => $quickBooksAmount,
                'amount_mismatch' => $amountMismatch,
                'source_tax_amount' => $sourceTaxAmount,
                'source_tax_percent' => $sourceTaxPercent,
                'quickbooks_tax_amount' => isset($qbTxn['TxnTaxDetail']['TotalTax'])
                    ? round(
                        (float) $qbTxn['TxnTaxDetail']['TotalTax'],
                        2
                    )
                    : null,
            ]);
        } catch (\Throwable $e) {
            if (isset($quickbookRecord)) {
                $quickbookRecord->update([
                    'export_status' => 2,
                    'error_message' => $e->getMessage(),
                ]);
            }

            \Log::error('QuickBooks import failed', [
                'key' => $recordKey,
                'error' => $e->getMessage(),
            ]);

            return response()->json([
                'success' => false,
                'error' => $e->getMessage(),
            ], 422);
        } finally {
            optional($lock)->release();
        }
    }

    public function AutoSyncToQuickbook()
    {
        $fromDate = '2026-01-01 00:00:00';

        $exportedRecords = [];
        $scanned = 0;
        $imported = 0;
        $skipped = 0;
        $failed = 0;

        $customers = collect(QuickBooksService::getCustomers());
        $paymentMethods = collect(QuickBooksService::getPaymentMethods());
        $depositAccounts = collect(QuickBooksService::getDepositAccounts());
        $refundFromAccounts = collect(QuickBooksService::getRefundAccounts());

        /*
        |--------------------------------------------------------------------------
        | ORDER MODULE PAYMENTS
        |--------------------------------------------------------------------------
        | auto_generated PaymentLog rows are parent/summary rows for StoreOrder
        | payments. Do NOT import them as Order payments; the underlying
        | StoreCardPayment rows are imported separately below.
        */

        $normalTransactions = collect();

        PaymentLog::where('created_at', '>=', $fromDate)
            ->where('response_code', '1')
            ->where(function ($query) {
                $query->whereNull('auto_generated')
                    ->orWhere('auto_generated', 0);
            })
            ->get()
            ->each(fn ($payment) => $normalTransactions->push([
                'type' => 'Card',
                'record' => $payment,
            ]));

        CheckPayment::where('created_at', '>=', $fromDate)
            ->where('is_approved', 1)
            ->get()
            ->each(fn ($payment) => $normalTransactions->push([
                'type' => 'Check',
                'record' => $payment,
            ]));

        VenmoPayment::where('created_at', '>=', $fromDate)
            ->where('is_approved', 1)
            ->get()
            ->each(fn ($payment) => $normalTransactions->push([
                'type' => 'Venmo',
                'record' => $payment,
            ]));

        PaypalPayment::where('created_at', '>=', $fromDate)
            ->where('is_approved', 1)
            ->get()
            ->each(fn ($payment) => $normalTransactions->push([
                'type' => 'Paypal',
                'record' => $payment,
            ]));

        OtherPayment::where('created_at', '>=', $fromDate)
            ->where('is_approved', 1)
            ->get()
            ->each(fn ($payment) => $normalTransactions->push([
                'type' => 'Other',
                'record' => $payment,
            ]));

        foreach ($normalTransactions as $transaction) {
            $scanned++;

            try {
                $type = $transaction['type'];
                $transactionRecord = $transaction['record'];

                $order = Order::with(
                    'organizationDetails',
                    'contactDetails',
                    'userDetails'
                )->find($transactionRecord->order_id);

                if (!$order) {
                    $failed++;
                    continue;
                }

                $existingRecord = $this->quickbookRecordQuery(
                    $order->id,
                    $transactionRecord->id,
                    $type,
                    0,
                    0
                )->first();

                if ($existingRecord && (int) $existingRecord->export_status === 1) {
                    $skipped++;
                    continue;
                }

                $data = $this->buildNormalReceiptData(
                    $order,
                    $transactionRecord,
                    $type,
                    $customers,
                    $paymentMethods,
                    $depositAccounts,
                    $existingRecord,
                    config('services.qbo.default_customer_id', 8853),
                    config('services.qbo.default_deposit_account_id', 148)
                );

                $data['items'] = $this->normalizeItemsForQuickBooksRequest(
                    $data['line_items']
                );
                unset($data['line_items']);
                $data['export_status'] = 1;
                $data['doc_number'] = (string) QuickBooksService::generateReceiptNo();

                $internalRequest = Request::create(
                    '/quickbooks/import-sales-receipt',
                    'POST',
                    $data
                );

                $response = $this->importSalesReceipt($internalRequest);
                $result = $response->getData(true);

                if (!($result['success'] ?? false)) {
                    $failed++;
                    continue;
                }

                if ($result['already_exported'] ?? false) {
                    $skipped++;
                    continue;
                }

                $imported++;

                $quickbookRecord = $this->quickbookRecordQuery(
                    $order->id,
                    $transactionRecord->id,
                    $type,
                    0,
                    0
                )->first();

                $viewTransactions = [[
                    'id' => $transactionRecord->id,
                    'type' => $type,
                    'auto_generated' => 0,
                ]];

                $viewLink = url('/import-to-quickbooks') . '?' . http_build_query([
                    'transactions' => json_encode($viewTransactions),
                    'store_transactions' => json_encode([]),
                ]);

                $exportedRecords[] = [
                    'order_id' => $order->id,
                    'order_no' => $order->order_no,
                    'organization_name' =>
                        $order->organizationDetails->organization_name ?? '-',
                    'record_id' => $transactionRecord->id,
                    'payment_type' => $type,
                    'receipt_type' => 'Sales Receipt',
                    'amount' => $data['amount'] ?? 0,
                    'receipt_date' => $data['receipt_date'] ?? '',
                    'qb_doc_number' => $quickbookRecord->qb_doc_number ?? '-',
                    'qb_transaction_id' => $quickbookRecord->sales_receipt_id ?? '-',
                    'view_link' => $viewLink,
                ];
            } catch (\Throwable $exception) {
                $failed++;
                report($exception);

                \Log::error('QuickBooks automatic Order payment sync exception', [
                    'type' => $transaction['type'] ?? null,
                    'record_id' => data_get($transaction, 'record.id'),
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        /*
        |--------------------------------------------------------------------------
        | STOREORDER MODULE PAYMENTS / REFUNDS
        |--------------------------------------------------------------------------
        */

        $storePayments = StoreCardPayment::where('created_at', '>=', $fromDate)
            ->where('is_success', 1)
            ->get();

        foreach ($storePayments as $storeCardPayment) {
            $scanned++;

            try {
                $storeOrder = StoreOrder::with(
                    'storeDetails.organizationDetails',
                    'storeDetails.userDetails',
                    'storeCustomer'
                )
                    ->where('order_no', $storeCardPayment->store_order_no)
                    ->first();

                if (!$storeOrder) {
                    $failed++;
                    continue;
                }

                $isRefund = (int) ($storeCardPayment->is_refund ?? 0);

                $existingRecord = $this->quickbookRecordQuery(
                    $storeOrder->id,
                    $storeCardPayment->id,
                    'Card',
                    1,
                    $isRefund
                )->first();

                if ($existingRecord && (int) $existingRecord->export_status === 1) {
                    $skipped++;
                    continue;
                }

                $data = $this->buildStoreReceiptData(
                    $storeOrder,
                    $storeCardPayment,
                    $customers,
                    $paymentMethods,
                    $depositAccounts,
                    $refundFromAccounts,
                    $existingRecord,
                    config('services.qbo.default_customer_id', 8853),
                    $isRefund === 1
                        ? config(
                            'services.qbo.default_refund_account_id',
                            config('services.qbo.default_deposit_account_id', 148)
                        )
                        : config('services.qbo.default_deposit_account_id', 148)
                );

                $data['items'] = $this->normalizeItemsForQuickBooksRequest(
                    $data['line_items']
                );
                unset($data['line_items']);
                $data['export_status'] = 1;
                $data['doc_number'] = (string) (
                    $isRefund === 1
                        ? QuickBooksService::generateRefundReceiptNo()
                        : QuickBooksService::generateReceiptNo()
                );

                $internalRequest = Request::create(
                    '/quickbooks/import-sales-receipt',
                    'POST',
                    $data
                );

                $response = $this->importSalesReceipt($internalRequest);
                $result = $response->getData(true);

                if (!($result['success'] ?? false)) {
                    $failed++;
                    continue;
                }

                if ($result['already_exported'] ?? false) {
                    $skipped++;
                    continue;
                }

                $imported++;

                $quickbookRecord = $this->quickbookRecordQuery(
                    $storeOrder->id,
                    $storeCardPayment->id,
                    'Card',
                    1,
                    $isRefund
                )->first();

                $viewTransactions = [[
                    'id' => $storeCardPayment->id,
                    'type' => 'Card',
                    'auto_generated' => 1,
                ]];

                $viewStoreTransactions = [[
                    'id' => $storeCardPayment->id,
                    'parentId' => $storeCardPayment->id,
                ]];

                $viewLink = url('/import-to-quickbooks') . '?' . http_build_query([
                    'transactions' => json_encode($viewTransactions),
                    'store_transactions' => json_encode($viewStoreTransactions),
                ]);

                $exportedRecords[] = [
                    'order_id' => $storeOrder->id,
                    'order_no' => $storeOrder->order_no,
                    'organization_name' =>
                        $storeOrder->storeDetails->organizationDetails->organization_name ?? '-',
                    'record_id' => $storeCardPayment->id,
                    'payment_type' => 'Card',
                    'receipt_type' => $isRefund === 1
                        ? 'Refund Receipt'
                        : 'Sales Receipt',
                    'amount' => $data['amount'] ?? 0,
                    'receipt_date' => $data['receipt_date'] ?? '',
                    'qb_doc_number' => $quickbookRecord->qb_doc_number ?? '-',
                    'qb_transaction_id' => $quickbookRecord->sales_receipt_id ?? '-',
                    'view_link' => $viewLink,
                ];
            } catch (\Throwable $exception) {
                $failed++;
                report($exception);

                \Log::error('QuickBooks automatic StoreOrder payment sync exception', [
                    'record_id' => $storeCardPayment->id,
                    'store_order_no' => $storeCardPayment->store_order_no,
                    'is_refund' => $storeCardPayment->is_refund ?? 0,
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        if (count($exportedRecords) > 0) {
            try {
                email_Notify()->sendEmailFromTemplate(
                    'key_email_quickbooks_auto_sync_report',
                    [
                        'sync_date' => now()->format('m/d/Y h:i A'),
                        'scanned_count' => $scanned,
                        'exported_count' => count($exportedRecords),
                        'imported_count' => $imported,
                        'skipped_count' => $skipped,
                        'failed_count' => $failed,
                        'exported_records' => $exportedRecords,
                    ]
                );
            } catch (\Throwable $exception) {
                report($exception);

                \Log::error('QuickBooks auto-sync report email failed', [
                    'error' => $exception->getMessage(),
                ]);
            }
        }

        return [
            'scanned' => $scanned,
            'imported' => $imported,
            'skipped' => $skipped,
            'failed' => $failed,
        ];
    }

}
