<?php

namespace Tests\Feature;

use App\Models\Organization;
use App\Services\CaliforniaSalesTax;
use Illuminate\Support\Facades\Http;
use Illuminate\Validation\ValidationException;
use Tests\TestCase;

class CaliforniaSalesTaxTest extends TestCase
{
    public function test_api_fraction_is_converted_to_percentage_and_zip_plus_four_is_supported()
    {
        Http::fake(['services.maps.cdtfa.ca.gov/*' => Http::response([
            'taxRateInfo' => [['rate' => 0.0875]],
            'geocodeInfo' => ['confidence' => 'High'],
        ])]);
        $organization = new Organization([
            'shipping_street' => '450 N St', 'shipping_city' => 'Sacramento',
            'shipping_state' => 'CA', 'shipping_postal_code' => '95814-1234',
        ]);

        $this->assertSame(8.75, app(CaliforniaSalesTax::class)->rateFor($organization));
        Http::assertSent(function ($request) {
            return $request['zip'] === '95814';
        });
    }

    public function test_ambiguous_results_are_rejected()
    {
        Http::fake(['services.maps.cdtfa.ca.gov/*' => Http::response([
            'taxRateInfo' => [['rate' => 0.0875], ['rate' => 0.095]],
            'geocodeInfo' => ['confidence' => 'High'],
        ])]);
        $organization = new Organization([
            'shipping_street' => '450 N St', 'shipping_city' => 'Sacramento',
            'shipping_postal_code' => '95814',
        ]);

        $this->expectException(ValidationException::class);
        app(CaliforniaSalesTax::class)->rateFor($organization);
    }

    public function test_manual_changes_to_california_tax_are_overridden()
    {
        Http::fake();
        $organization = new Organization();
        $organization->setRawAttributes([
            'shipping_state' => 'California', 'shipping_country' => 'USA',
            'sales_tax' => '8.75', 'sales_tax_active' => 1,
        ], true);
        $organization->exists = true;
        $organization->sales_tax = 2;
        $organization->sales_tax_active = 0;

        Organization::getEventDispatcher()->dispatch('eloquent.saving: '.Organization::class, [$organization]);

        $this->assertSame('8.75', $organization->sales_tax);
        $this->assertSame(1, $organization->sales_tax_active);
        Http::assertNothingSent();
    }

    public function test_other_states_keep_manual_tax_values()
    {
        Http::fake();
        $organization = new Organization(['shipping_state' => 'NY', 'sales_tax' => 5, 'sales_tax_active' => 0]);

        Organization::getEventDispatcher()->dispatch('eloquent.saving: '.Organization::class, [$organization]);

        $this->assertSame(5, $organization->sales_tax);
        $this->assertSame(0, $organization->sales_tax_active);
        Http::assertNothingSent();
    }

    public function test_address_updates_do_not_refresh_the_tax_rate()
    {
        Http::fake(['services.maps.cdtfa.ca.gov/*' => Http::response([
            'taxRateInfo' => [['rate' => 0.0925]],
            'geocodeInfo' => ['confidence' => 'High'],
        ])]);
        $organization = new Organization();
        $organization->setRawAttributes([
            'shipping_street' => 'Old street', 'shipping_city' => 'Sacramento',
            'shipping_state' => 'CA', 'shipping_postal_code' => '95814',
            'sales_tax' => '2.2', 'sales_tax_active' => 1,
        ], true);
        $organization->exists = true;
        $organization->shipping_street = '450 N St';
        $organization->sales_tax = 3;

        Organization::getEventDispatcher()->dispatch('eloquent.saving: '.Organization::class, [$organization]);

        $this->assertSame('2.2', $organization->sales_tax);
        $this->assertNull($organization->cdtfa_updated_at);
        Http::assertNothingSent();
    }

    public function test_failed_lookup_leaves_existing_tax_values_intact()
    {
        Http::fake(['services.maps.cdtfa.ca.gov/*' => Http::response([], 503)]);
        $organization = new Organization([
            'shipping_street' => '450 N St', 'shipping_city' => 'Sacramento',
            'shipping_state' => 'CA', 'shipping_postal_code' => '95814',
            'sales_tax' => 8.75, 'sales_tax_active' => 1,
        ]);

        try {
            $organization->refreshCaliforniaSalesTax();
            $this->fail('Expected a validation error for the unavailable service.');
        } catch (ValidationException $exception) {
            $this->assertSame(8.75, $organization->sales_tax);
            $this->assertSame(1, $organization->sales_tax_active);
        }
    }
}
