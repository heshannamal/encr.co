<?php

namespace App\Console\Commands;

use App\Models\Order;
use Illuminate\Console\Command;

class BackfillOrderSalesTax extends Command
{
    protected $signature = 'orders:backfill-sales-tax {--apply : Write the backfill to the database}';

    protected $description = 'Fill empty order sales tax snapshots from current organization settings';

    public function handle(): int
    {
        $apply = $this->option('apply');
        $checkedAt = now();
        $updated = 0;
        $skipped = 0;
        $changed = 0;

        $emptySnapshots = Order::query()
            ->where(function ($query) {
                $query->whereNull('sales_tax_rate')->orWhere('sales_tax_rate', 0);
            })
            ->whereNull('sales_tax_source')
            ->whereNull('sales_tax_checked_at')
            ->whereNull('sales_tax_address');

        (clone $emptySnapshots)->with('organizationDetails')->chunkById(500, function ($orders) use (
            $emptySnapshots, $apply, $checkedAt, &$updated, &$skipped, &$changed
        ) {
            foreach ($orders as $order) {
                $organization = $order->organizationDetails;
                if (!$organization || ($organization->sales_tax_active == 1 && !is_numeric($organization->sales_tax))) {
                    $skipped++;
                    continue;
                }

                if (!$apply) {
                    $updated++;
                    continue;
                }

                $address = [
                    'street' => $organization->shipping_street,
                    'city' => $organization->shipping_city,
                    'state' => $organization->shipping_state,
                    'zip' => $organization->shipping_postal_code,
                    'country' => $organization->shipping_country,
                    'county' => $organization->shipping_county,
                ];

                $written = (clone $emptySnapshots)->whereKey($order->id)->toBase()->update([
                    'sales_tax_rate' => $organization->sales_tax_active == 1 ? $organization->sales_tax : null,
                    'sales_tax_source' => 'organization_backfill',
                    'sales_tax_checked_at' => $checkedAt,
                    'sales_tax_address' => json_encode($address, JSON_THROW_ON_ERROR | JSON_INVALID_UTF8_SUBSTITUTE),
                ]);
                $updated += $written;
                $changed += 1 - $written;
            }
        }, 'id');

        $this->info($apply ? "Updated {$updated} orders." : "Dry run: would update {$updated} orders.");
        $this->line("Skipped {$skipped} orders with a missing organization or an enabled tax rate that is missing or invalid.");
        if ($changed > 0) {
            $this->line("Skipped {$changed} orders that changed during the backfill.");
        }

        return 0;
    }
}
