<?php

namespace App\Console\Commands;

use Illuminate\Console\Command;
use App\Models\Store;
use Carbon\Carbon;
use App\Models\Notification;
use App\Http\Controllers\StoreController;

class UpdateStoreStatuses extends Command
{
    /**
     * The name and signature of the console command.
     */
    protected $signature = 'stores:update-status';

    /**
     * The console command description.
     */
    protected $description = 'Update store statuses, send closing soon and closed emails automatically';

    /**
     * Execute the console command.
     */
    public function handle()
    {
        $controller = new StoreController();

        $stores = Store::where('active', 1)->where('store_status', '!=', 3)->get();

        foreach ($stores as $store) {
            try {
                $controller->updateStoreStatus($store->id);
            } catch (\Exception $e) {
                $this->error("Failed to update store {$store->id}: " . $e->getMessage());
            }
        }

        $this->info('✅ Store statuses updated successfully at ' . now());
    }
}
