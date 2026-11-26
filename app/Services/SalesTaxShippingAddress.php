<?php

namespace App\Services;

use App\Models\Organization;

class SalesTaxShippingAddress
{
    public function resolve(?Organization $organization): array
    {
        $address = ['street' => '', 'city' => '', 'state' => '', 'zip' => '', 'country' => '', 'county' => null, 'contact_id' => null];
        if (!$organization) {
            return $address;
        }
        // A saved organization county also applies when the visible address
        // falls back to the first contact's shipping address.
        $address['county'] = trim((string) $organization->shipping_county) ?: null;
        foreach (['street', 'city', 'state', 'country'] as $field) {
            $address[$field] = trim((string) $organization->{'shipping_'.$field});
        }
        $address['zip'] = trim((string) $organization->shipping_postal_code);
        // Country alone does not constitute an address. Keep partial organization
        // addresses intact rather than mixing fields from different locations.
        if ($address['street'] !== '' || $address['city'] !== '' || $address['state'] !== '' || $address['zip'] !== '') {
            if (!$address['county'] && $address['street'] === '' && in_array(strtoupper($address['country']), ['', 'US', 'USA', 'UNITED STATES', 'UNITED STATES OF AMERICA'], true)) {
                $address['county'] = (new CityCountyLookup)->lookup($address['city'], $address['state']);
            }
            return $address;
        }

        $link = $organization->contactOrganizations->sortBy('id')->first(function ($link) {
            return $link->contacts->isNotEmpty();
        });
        $contact = $link ? $link->contacts->sortBy('id')->first() : null;
        if (!$contact) {
            return $address;
        }
        foreach (['street', 'city', 'state', 'country'] as $field) {
            $address[$field] = trim((string) $contact->{'shipping_'.$field});
        }
        $address['zip'] = trim((string) $contact->shipping_zip);
        $address['contact_id'] = $contact->id;
        $address['county'] = $address['county'] ?: ($contact->shipping_county ?? null);
        if (!$address['county'] && $address['street'] === '' && in_array(strtoupper($address['country']), ['', 'US', 'USA', 'UNITED STATES', 'UNITED STATES OF AMERICA'], true)) {
            $address['county'] = (new CityCountyLookup)->lookup($address['city'], $address['state']);
        }
        return $address;
    }
}
