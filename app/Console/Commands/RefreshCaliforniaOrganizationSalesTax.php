<?php

namespace App\Console\Commands;

use App\Models\Organization;
use Illuminate\Console\Command;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\ValidationException;

class RefreshCaliforniaOrganizationSalesTax extends Command
{
    protected $signature = 'organizations:refresh-ca-sales-tax {--organization= : Refresh one organization ID}';

    protected $description = 'Update California organization sales tax rates from CDTFA';

    public function handle(): int
    {
        $updated = 0;
        $failed = 0;
        $query = Organization::query()->whereRaw("UPPER(TRIM(shipping_state)) IN ('CA', 'CALIFORNIA')");
        if ($this->option('organization')) {
            $query->whereKey($this->option('organization'));
        }

        $query->chunkById(100, function ($organizations) use (&$updated, &$failed) {
            foreach ($organizations as $organization) {
                if (!$organization->usesCaliforniaSalesTax()) {
                    continue;
                }
                try {
                    DB::transaction(function () use ($organization) {
                        $current = Organization::whereKey($organization->id)->lockForUpdate()->firstOrFail();
                        $current->refreshCaliforniaSalesTax();
                    });
                    $updated++;
                } catch (ValidationException $exception) {
                    $failed++;
                    $this->warn("Organization {$organization->id}: ".implode(' ', $exception->validator->errors()->all()));
                }
            }
        });

        $this->info("Updated {$updated} California organizations. Failed {$failed}.");

        return $failed > 0 ? 1 : 0;
    }
}
