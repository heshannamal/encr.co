<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddShippingAddressToOrganizationSampleShipmentsTable extends Migration
{
    public function up()
    {
        Schema::table('organization_sample_shipments', function (Blueprint $table) {
            $table->string('shipping_street')->nullable()->after('note');
            $table->string('shipping_city')->nullable()->after('shipping_street');
            $table->string('shipping_state')->nullable()->after('shipping_city');
            $table->string('shipping_postal_code', 100)->nullable()->after('shipping_state');
            $table->string('shipping_country')->nullable()->after('shipping_postal_code');
        });

        // Existing sample records start with the organization's current shipping address.
        DB::statement("
            UPDATE organization_sample_shipments AS sample
            INNER JOIN organizations AS organization
                ON organization.id = sample.organization_id
            SET
                sample.shipping_street = organization.shipping_street,
                sample.shipping_city = organization.shipping_city,
                sample.shipping_state = organization.shipping_state,
                sample.shipping_postal_code = organization.shipping_postal_code,
                sample.shipping_country = organization.shipping_country
            WHERE
                sample.shipping_street IS NULL
                AND sample.shipping_city IS NULL
                AND sample.shipping_state IS NULL
                AND sample.shipping_postal_code IS NULL
                AND sample.shipping_country IS NULL
        ");
    }

    public function down()
    {
        Schema::table('organization_sample_shipments', function (Blueprint $table) {
            $table->dropColumn([
                'shipping_street',
                'shipping_city',
                'shipping_state',
                'shipping_postal_code',
                'shipping_country',
            ]);
        });
    }
}
