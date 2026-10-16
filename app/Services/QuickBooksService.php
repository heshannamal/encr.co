<?php

namespace App\Services;

use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Cache;
use Illuminate\Support\Facades\Log;

class QuickBooksService
{
    /**
     * Base API URL depending on environment
     */
    protected static function getBaseUrl(): string
    {
        $env = config('services.qbo.environment', 'sandbox');
        return $env === 'sandbox'
            ? 'https://sandbox-quickbooks.api.intuit.com'
            : 'https://quickbooks.api.intuit.com';
    }

    /**
     * Full URL including realm ID
     */
    private static function baseUrl(): string
    {
        $realmId = session('quickbooks.realm_id');
        if (!$realmId) {
            throw new \Exception('QuickBooks realm_id not set in session.');
        }

        $base = self::getBaseUrl();
        return "{$base}/v3/company/{$realmId}/";
    }

    /**
     * Get access token from session
     */
    private static function accessToken(): string
    {
        $token = session('quickbooks.access_token');
        if (!$token) {
            throw new \Exception('QuickBooks access_token not found in session.');
        }
        return $token;
    }

    /**
     * Generic request handler with auto-refresh
     */
    private static function request(string $method, string $endpoint, array $body = null)
    {
        $url = self::baseUrl() . $endpoint;

        $options = $body ? ['json' => $body] : [];

        $response = Http::withToken(self::accessToken())
            ->acceptJson()
            ->send($method, $url, $options);

        // Refresh token if unauthorized
        if ($response->status() === 401) {
            $newToken = self::refreshAccessToken();
            if (!$newToken) {
                throw new \Exception('QuickBooks token refresh failed.');
            }
            $response = Http::withToken($newToken)
                ->acceptJson()
                ->send($method, $url, $options);
        }

        if ($response->failed()) {
            throw new \Exception($response->body());
        }

        return $response->json();
    }

    /**
     * Refresh access token using refresh token
     */
    public static function refreshAccessToken()
    {
        $refreshToken = session('quickbooks.refresh_token');
        if (!$refreshToken) return false;

        $response = Http::withBasicAuth(
            config('services.qbo.client_id'),
            config('services.qbo.client_secret')
        )->asForm()->post('https://oauth.platform.intuit.com/oauth2/v1/tokens/bearer', [
            'grant_type' => 'refresh_token',
            'refresh_token' => $refreshToken,
        ]);

        if (!$response->successful()) return false;

        $data = $response->json();

        session([
            'quickbooks.access_token'  => $data['access_token'],
            'quickbooks.refresh_token' => $data['refresh_token'],
        ]);

        return $data['access_token'];
    }

    /**
     * Helper for QuickBooks SQL-like queries
     */
    private static function query(string $sql)
    {
        $endpoint = '/query?query=' . urlencode($sql);
        return self::request('GET', $endpoint);
    }

    /**
     * Generate next Sales Receipt number
     */
    public static function generateReceiptNo(): int
    {
        $response = self::query(
            "SELECT DocNumber, MetaData.CreateTime
            FROM SalesReceipt
            ORDER BY MetaData.CreateTime DESC
            MAXRESULTS 50"
        );

        $receipts = $response['QueryResponse']['SalesReceipt'] ?? [];

        $max = 0;

        foreach ($receipts as $receipt) {
            $doc = $receipt['DocNumber'] ?? null;

            if ($doc && preg_match('/^\d+$/', $doc)) {
                $num = (int) $doc;
                if ($num > $max) {
                    $max = $num;
                }
            }
        }

        return $max > 0 ? $max + 1 : 1000;
    }

    public static function getItems(): array
    {
        $sql = "SELECT Id, Name, Type FROM Item WHERE Active = true AND Type IN ('Inventory','NonInventory','Service') MAXRESULTS 1000";

        $response = self::query($sql);

        return $response['QueryResponse']['Item'] ?? [];
    }

    /**
     * Fetch ALL active QuickBooks customers.
     *
     * This method paginates through QuickBooks until the final page is reached.
     * It never intentionally returns only the first 1000 customers.
     */
    public static function getCustomers(): array
    {
        $customers = [];

        $startPosition = 1;
        $maxResults = 1000;
        $page = 1;

        do {
            /*
             * Filter inactive customers at QuickBooks level and explicitly page
             * through the complete result set.
             */
            $sql =
                "SELECT * FROM Customer "
                . "WHERE Active = true "
                . "STARTPOSITION {$startPosition} "
                . "MAXRESULTS {$maxResults}";

            /*
             * Use the service's normal query/request flow instead of making a
             * separate Http call here. This keeps:
             *
             * - sandbox / production URL selection consistent
             * - automatic token refresh on HTTP 401
             * - normal API error handling
             *
             * If a later page fails, self::query() throws an exception. That is
             * safer than returning a partial customer list to AutoSync.
             */
            $response = self::query($sql);

            $rows =
                $response['QueryResponse']['Customer']
                ?? [];

            if (!is_array($rows)) {
                $rows = [];
            }

            foreach ($rows as $customer) {
                if (empty($customer['Id'])) {
                    continue;
                }

                /*
                 * The QBO query already contains WHERE Active = true, but retain
                 * this defensive check as well.
                 */
                if (
                    array_key_exists('Active', $customer)
                    && $customer['Active'] === false
                ) {
                    continue;
                }

                $name =
                    $customer['DisplayName']
                    ?? $customer['FullyQualifiedName']
                    ?? $customer['CompanyName']
                    ?? null;

                if (!$name) {
                    continue;
                }

                $customers[] = (object) [
                    'id' =>
                        $customer['Id'],

                    'name' =>
                        $name,

                    'display_name' =>
                        $customer['DisplayName']
                        ?? $name,

                    'fully_qualified_name' =>
                        $customer['FullyQualifiedName']
                        ?? $name,

                    'company_name' =>
                        $customer['CompanyName']
                        ?? null,

                    'active' =>
                        $customer['Active']
                        ?? true,

                    'sub_customer' =>
                        $customer['SubCustomer']
                        ?? false,

                    'parent_id' =>
                        data_get(
                            $customer,
                            'ParentRef.value'
                        ),

                    'primary_email' =>
                        data_get(
                            $customer,
                            'PrimaryEmailAddr.Address'
                        ),

                    'primary_phone' =>
                        data_get(
                            $customer,
                            'PrimaryPhone.FreeFormNumber'
                        ),
                ];
            }

            $returnedCount = count($rows);

            Log::info(
                'QuickBooks customer page loaded',
                [
                    'page' =>
                        $page,

                    'start_position' =>
                        $startPosition,

                    'returned' =>
                        $returnedCount,

                    'loaded_total' =>
                        count($customers),
                ]
            );

            /*
             * A short page means this is the final page.
             */
            if ($returnedCount < $maxResults) {
                break;
            }

            /*
             * Move to the next page.
             *
             * 1    -> first 1000
             * 1001 -> second 1000
             * 2001 -> third page
             * etc.
             */
            $startPosition += $returnedCount;
            $page++;

        } while (true);

        /*
         * Defensive de-duplication in case the QBO dataset changes during the
         * pagination process. Sort alphabetically for both AutoSync matching and
         * the customer dropdown.
         */
        $customers = collect($customers)
            ->unique(function ($customer) {
                return (string) $customer->id;
            })
            ->sortBy(function ($customer) {
                return mb_strtolower(
                    (string) $customer->name
                );
            })
            ->values()
            ->all();

        Log::info(
            'All active QuickBooks customers loaded',
            [
                'count' =>
                    count($customers),

                'pages' =>
                    $page,
            ]
        );

        return $customers;
    }

    /**
     * Fetch payment methods
     */
    public static function getPaymentMethods(): array
    {
        $response = self::query("SELECT Id, Name FROM PaymentMethod MAXRESULTS 1000");
        $list = [];
        foreach ($response['QueryResponse']['PaymentMethod'] ?? [] as $m) {
            $list[] = (object)[
                'id' => $m['Id'],
                'name' => $m['Name'],
            ];
        }
        return $list;
    }

    /**
     * Fetch deposit accounts (bank accounts)
     */
    public static function getDepositAccounts(): array
    {
        $response = self::query("
            SELECT Id, Name, AccountType
            FROM Account
            WHERE AccountType IN ('Bank', 'Other Current Asset')
            MAXRESULTS 1000
        ");

        $list = [];

        foreach ($response['QueryResponse']['Account'] ?? [] as $a) {
            $list[] = (object)[
                'id'   => $a['Id'],
                'name' => $a['Name'],
                'type' => $a['AccountType'], // optional
            ];
        }

        return $list;
    }

    /**
     * Fetch refund from accounts (bank accounts)
     */
    public static function getRefundAccounts(): array
    {
        $response = self::query("
            SELECT Id, Name, AccountType
            FROM Account
            WHERE AccountType IN ('Bank', 'Other Current Asset', 'Expense')
            MAXRESULTS 1000
        ");

        $list = [];

        foreach ($response['QueryResponse']['Account'] ?? [] as $a) {
            $list[] = (object)[
                'id'   => $a['Id'],
                'name' => $a['Name'],
                'type' => $a['AccountType'],
            ];
        }

        return $list;
    }

    /**
     * Fetch classes / locations
     */
    public static function getLocations(): array
    {
        $response = self::query("SELECT Id, Name FROM Class MAXRESULTS 1000");
        $list = [];
        foreach ($response['QueryResponse']['Class'] ?? [] as $l) {
            $list[] = (object)[
                'id' => $l['Id'],
                'name' => $l['Name'],
            ];
        }
        return $list;
    }

    /**
     * Get a Sales Receipt by ID
     */
    public static function getSalesReceipt($id)
    {
        if (!$id) return null;
        return self::request('GET', "/salesreceipt/{$id}");
    }

    /**
     * Create a new Sales Receipt
     */
    public static function createSalesReceipt(array $payload)
    {
        return self::request('POST', '/salesreceipt', $payload);
    }

    /**
     * Get a Refund Receipt by ID
     */
    public static function getRefundReceipt($id)
    {
        if (!$id) return null;
        return self::request('GET', "/refundreceipt/{$id}");
    }

    /**
    * Get next refund receipt number
     */
    public static function generateRefundReceiptNo(): int
    {
        $response = self::query(
            "SELECT DocNumber, MetaData.CreateTime
            FROM RefundReceipt
            ORDER BY MetaData.CreateTime DESC
            MAXRESULTS 50"
        );
        $receipts = $response['QueryResponse']['RefundReceipt'] ?? [];
        $max = 0;
        foreach ($receipts as $receipt) {
            $doc = $receipt['DocNumber'] ?? null;
            if ($doc && preg_match('/^\d+$/', $doc)) {
                $num = (int) $doc;
                if ($num > $max) {
                    $max = $num;
                }
            }
        }
        return $max > 0 ? $max + 1 : 1000;
    }

    /**
     * Create a new Refund Receipt
     */
    public static function createRefundReceipt(array $payload)
    {
        return self::request('POST', 'refundreceipt', $payload);
    }
}
