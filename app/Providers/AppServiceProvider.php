<?php

namespace App\Providers;

use App\Models\ActivityLogs;
use App\Observers\ActivityLogsObserver;
use Illuminate\Support\ServiceProvider;
use App\Services\ShippoService;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\Session;
use App\Models\SupportConversation;
use App\Models\SupportDepartment;
use App\Models\Contact;
class AppServiceProvider extends ServiceProvider
{
    /**
     * Register any application services.
     *
     * @return void
     */
    public function register()
    {
        //
    }

    /**
     * Bootstrap any application services.
     *
     * @return void
     */
    public function boot()
    {
        ActivityLogs::observe(ActivityLogsObserver::class);

        $shippoKey = config('services.shippo.key');

        if (is_string($shippoKey) && trim($shippoKey) !== '') {
            $shippoAuth = new ShippoService();
            $shippoAuth->setApiKey($shippoKey);
        }

        View::composer('*', function ($view) {

            $departments = SupportDepartment::where('is_active', true)->get();

            $activeConversation = null;
            $showPortalNotice = false;

            $contactData = Session::get('customer_portal_user');

            if ($contactData) {
                $contact_id = $contactData[0];

                $customer = Contact::where('id', $contact_id)
                    ->where('active', 1)
                    ->first();

                if ($customer) {
                    $showPortalNotice = !Session::has('portal_notice_acknowledged');

                    $activeConversation = SupportConversation::with(['messages', 'department'])
                        ->where('customer_id', $customer->id)
                        ->whereIn('status', ['waiting', 'active'])
                        ->latest()
                        ->first();
                }
            }

            $view->with([
                'departments' => $departments,
                'activeConversation' => $activeConversation,
                'showPortalNotice' => $showPortalNotice,
            ]);
        });
    }
}
