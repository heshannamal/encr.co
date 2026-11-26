<?php

namespace App\Services;

use App\Models\Organization;
use Illuminate\Support\Facades\Http;

class ShippingCountyLookup
{
    public function lookup(Organization $organization): ?string
    {
        $city = trim(trim((string) $organization->shipping_city), " \t\n\r\0\x0B,");
        $state = trim(trim((string) $organization->shipping_state), " \t\n\r\0\x0B,");
        $zip = trim(trim((string) $organization->shipping_postal_code), " \t\n\r\0\x0B,");
        $country = strtoupper(trim((string) $organization->shipping_country));
        if (!in_array($country, ['', 'US', 'USA', 'UNITED STATES', 'UNITED STATES OF AMERICA'], true)) {
            return null;
        }
        $cityCounty = (new CityCountyLookup)->lookup($city, $state);
        if (!trim((string) $organization->shipping_street)
            || ($zip === '' && ($city === '' || $state === ''))) {
            return $cityCounty;
        }

        try {
            $response = Http::withOptions(['connect_timeout' => 5])->timeout(15)
            ->retry(3, 1000, function ($exception) {
                if ($exception instanceof \Illuminate\Http\Client\RequestException) {
                    return in_array($exception->response->status(), [500, 502, 503, 504], true);
                }
                if ($exception instanceof \GuzzleHttp\Exception\RequestException && $exception->hasResponse()) {
                    return in_array($exception->getResponse()->getStatusCode(), [500, 502, 503, 504], true);
                }
                return false;
            })->get(
            'https://geocoding.geo.census.gov/geocoder/geographies/address',
            [
                'street' => trim((string) $organization->shipping_street),
                'city' => $city,
                'state' => $state,
                'zip' => $zip,
                'benchmark' => 'Public_AR_Current',
                'vintage' => 'Current_Current',
                'layers' => 'Counties',
                'format' => 'json',
            ]
        )->throw();
        } catch (\Illuminate\Http\Client\RequestException | \Illuminate\Http\Client\ConnectionException | \GuzzleHttp\Exception\TransferException $exception) {
            // A unique official city/county mapping remains usable when the
            // street-address service is unavailable or rejects the request.
            if ($cityCounty !== null) {
                return $cityCounty;
            }
            throw $exception;
        }

        $matches = $response->json('result.addressMatches');
        if (!is_array($matches)) {
            throw new \RuntimeException('Unexpected Census geocoder response.');
        }
        if (count($matches) !== 1) {
            return $cityCounty;
        }
        $counties = $matches[0]['geographies']['Counties'] ?? [];
        if (count($counties) !== 1) {
            return $cityCounty;
        }
        $county = trim((string) ($counties[0]['NAME'] ?? ''));
        return $county !== '' ? $county : $cityCounty;
    }
}
