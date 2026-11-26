<?php

namespace App\Console\Commands;

use App\Models\Organization;
use App\Services\ShippingCountyLookup;
use Illuminate\Console\Command;

class LookupShippingCounties extends Command
{
    protected $signature = 'organizations:lookup-counties {--limit=100 : Maximum addresses per run} {--retry-unmatched : Include recently checked organizations with no county} {--diagnose : Test Census with a public example address without changing the database}';
    protected $description = 'Send shipping addresses to the US Census geocoder and save matched counties';

    public function handle(ShippingCountyLookup $lookup)
    {
        // This is a CLI batch; each HTTP request still has its own 15-second timeout.
        if (PHP_SAPI === 'cli' && function_exists('set_time_limit')) {
            set_time_limit(0);
        }
        if ($this->option('diagnose')) {
            $example = new Organization([
                'shipping_street' => '4600 Silver Hill Rd',
                'shipping_city' => 'Suitland',
                'shipping_state' => 'MD',
                'shipping_postal_code' => '20746',
                'shipping_country' => 'US',
            ]);
            try {
                $county = $lookup->lookup($example);
                if (!$county) {
                    $this->error('Census responded, but the public test address did not return a county.');
                    return 1;
                }
                $this->info('Census connection OK. Public example county: '.$county);
                $this->info('No customer addresses sent and no database records changed.');
                return 0;
            } catch (\Throwable $exception) {
                $this->error($this->failureReason($exception));
                return 1;
            }
        }
        $organizations = Organization::whereNull('shipping_county')
            ->where('active', 1)
            ->whereRaw('UPPER(TRIM(shipping_state)) IN (?, ?, ?)', ['CA', 'CALIFORNIA', 'WI'])
            ->where(function ($query) {
                if ($this->option('retry-unmatched')) {
                    return;
                }
                $query->whereNull('shipping_county_checked_at')
                    ->orWhere('shipping_county_checked_at', '<', now()->subDays(30));
            })
            ->orderBy('shipping_county_checked_at')->orderBy('id')
            ->limit(max(1, (int) $this->option('limit')))->get();

        $resolved = 0;
        $failedIds = [];
        foreach ($organizations as $organization) {
            $this->line('Checking organization ID '.$organization->id.'...');
            try {
                $county = $lookup->lookup($organization);
                // Avoid saving a result for an address edited during the lookup.
                $query = Organization::whereKey($organization->id)->whereNull('shipping_county');
                foreach (['shipping_street', 'shipping_city', 'shipping_state', 'shipping_postal_code', 'shipping_country'] as $field) {
                    $query->where($field, $organization->getRawOriginal($field));
                }
                $updated = $query->update([
                    'shipping_county' => $county,
                    'shipping_county_checked_at' => now(),
                ]);
                $resolved += $updated && $county !== null ? 1 : 0;
                $this->line(!$updated ? 'Address changed; result not saved.' : ($county !== null ? 'County saved.' : 'No county match.'));
            } catch (\Throwable $exception) {
                $this->error('County lookup failed for organization ID '.$organization->id.'.');
                $this->error($this->failureReason($exception));
                $failedIds[] = $organization->id;
                continue;
            }
        }
        $this->info("Resolved {$resolved} counties from {$organizations->count()} addresses.");
        if ($failedIds) {
            $this->warn('Failed organization IDs (available for retry): '.implode(', ', $failedIds));
        }
        return $failedIds ? 1 : 0;
    }

    public function failureReason(\Throwable $exception): string
    {
        if ($exception instanceof \RuntimeException && $exception->getCode() === 7401) {
            return $exception->getMessage();
        }
        if ($exception instanceof \ErrorException) {
            return 'PHP warning in '.basename($exception->getFile()).':'.$exception->getLine()
                .'. Check this location in the server PHP log. Verify resources/data/city-counties-ca-wi.json was uploaded and is readable.';
        }
        // Older Guzzle/Laravel combinations may expose Guzzle exceptions directly.
        if ($exception instanceof \GuzzleHttp\Exception\RequestException && $exception->hasResponse()) {
            return $this->failureReason(new \Illuminate\Http\Client\RequestException(
                new \Illuminate\Http\Client\Response($exception->getResponse())
            ));
        }
        // Exception messages may contain the request URL and shipping address.
        // Report actionable diagnostics without printing customer address data.
        if ($exception instanceof \Illuminate\Http\Client\ConnectionException
            || $exception instanceof \GuzzleHttp\Exception\TransferException) {
            if (preg_match('/cURL error (\d+)/', $exception->getMessage(), $matches)) {
                $reasons = [
                    6 => 'Cannot resolve the Census hostname. Check server DNS and internet access.',
                    7 => 'Cannot connect to Census. Check outbound HTTPS access on port 443.',
                    28 => 'Census request timed out. Retry later or check the server connection.',
                    60 => 'PHP cannot verify the HTTPS certificate. Configure curl.cainfo and openssl.cafile with a trusted CA bundle in the CLI php.ini.',
                ];
                return $reasons[(int) $matches[1]] ?? 'Census connection failed (cURL error '.$matches[1].').';
            }
            return 'Cannot connect to Census. Check DNS, internet access and PHP certificate configuration.';
        }
        if ($exception instanceof \Illuminate\Http\Client\RequestException) {
            if ($exception->response->status() === 400) {
                $errors = $exception->response->json('errors');
                $details = [];
                foreach (is_array($errors) ? $errors : [] as $error) {
                    if (is_string($error)) {
                        $details[] = preg_replace('/[\x00-\x1F\x7F]/', ' ', strip_tags($error));
                    }
                }
                $reason = $details ? substr(implode('; ', $details), 0, 600) : 'No JSON validation details returned. Run with --diagnose to test the server using a public address.';
                return 'Census rejected the request (HTTP 400): '.$reason;
            }
            return 'Census returned HTTP '.$exception->response->status().'. Retry later.';
        }
        if ($exception instanceof \Illuminate\Database\QueryException) {
            return 'Could not save the county. Check database access and run the county migration.';
        }
        return 'Lookup failed ('.get_class($exception).'). Check the Census response and application configuration.';
    }
}
