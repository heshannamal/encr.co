<?php

namespace App\Services;

use App\Models\Organization;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;

class CaliforniaSalesTax
{
    public function rateFor(Organization $organization): float
    {
        return $this->detailsFor($organization)['rate'];
    }

    public function detailsFor(Organization $organization): array
    {
        $street = trim((string) $organization->shipping_street);
        $city = trim((string) $organization->shipping_city);
        $zip = trim((string) $organization->shipping_postal_code);
        if ($street === '' || $city === '' || !preg_match('/^(\d{5})(?:-\d{4})?$/', $zip, $matches)) {
            throw ValidationException::withMessages([
                'shipping_street' => 'California sales tax requires a shipping street, city, and valid ZIP code.',
            ]);
        }

        try {
            $response = Http::withOptions(['connect_timeout' => 5])->timeout(15)->get(
                'https://services.maps.cdtfa.ca.gov/api/taxrate/GetRateByAddress',
                ['address' => $street, 'city' => $city, 'zip' => $matches[1]]
            )->throw()->json();
        } catch (\Exception $exception) {
            throw ValidationException::withMessages([
                'sales_tax' => 'The California tax service is unavailable. Please try again.',
            ]);
        }

        $rates = $response['taxRateInfo'] ?? [];
        $rate = is_array($rates) && count($rates) === 1 ? ($rates[0]['rate'] ?? null) : null;
        if (!is_numeric($rate) || $rate <= 0 || $rate > 1
            || ($response['geocodeInfo']['confidence'] ?? '') !== 'High') {
            throw ValidationException::withMessages([
                'shipping_street' => 'The California tax service could not confirm one tax rate. Please verify the shipping address.',
            ]);
        }

        return [
            'rate' => round((float) $rate * 100, 5),
            'county' => trim((string) ($rates[0]['county'] ?? '')) ?: null,
        ];
    }
}
