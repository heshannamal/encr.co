<?php

namespace App\Console;


use Illuminate\Console\Scheduling\Schedule;
use Illuminate\Foundation\Console\Kernel as ConsoleKernel;

class Kernel extends ConsoleKernel
{
    /**
     * The Artisan commands provided by your application.
     *
     * @var array
     */
    protected $commands = [
        \App\Console\Commands\UpdateStoreStatuses::class,
        \App\Console\Commands\SendDiscussionDueEmails::class,
        \App\Console\Commands\SendSubDiscussionDueEmails::class,
        \App\Console\Commands\CreateWeeklyNotification::class,
    ];

    /**
     * Define the application's command schedule.
     *
     * @param  \Illuminate\Console\Scheduling\Schedule  $schedule
     * @return void
     */
    protected function schedule(Schedule $schedule)
    {
        // $schedule->command('inspire')->hourly();
        $schedule->call('App\Http\Controllers\EmailController@getNewInboxCount')->everyMinute();
        $schedule->call('App\Http\Controllers\EmailController@getNewSpamCount')->everyMinute();
        $schedule->call('App\Http\Controllers\EmailController@getNewDraftCount')->everyMinute();
        $schedule->call('App\Http\Controllers\OrderController@changeFlagByCroneJob')->daily();
        $schedule->command('stores:update-status')->hourly();
        $schedule->call('App\Http\Controllers\ProjectController@notifyOverdueTasksByCroneJob')->daily();
        $schedule->command('discussion:due-email')->daily();
        $schedule->command('subdiscussion:due-email')->daily();
        $schedule->command('discussion:reminder-email')->daily();
        $schedule->command('subdiscussion:reminder-email')->daily();
        $schedule->command('discussion:assign-email')->everyMinute();
        $schedule->command('subdiscussion:assign-email')->everyMinute();
        $schedule->command('comments:send-mention-emails')->everyMinute();
        // $schedule->command('notification:create-weekly')->weeklyOn(1, '00:00')->timezone('America/Los_Angeles');
        // $schedule->command('notification:create-weekly')->everyFiveMinutes();
        $schedule->command('notification:create-weekly')->mondays()->at('00:10')->timezone('America/Los_Angeles')->withoutOverlapping();
        $schedule->command('email:customer-payment-reminder')->mondays()->at('00:10')->timezone('America/Los_Angeles')->withoutOverlapping();
        $schedule->command('email:d-hudson-payment-reminder')->mondays()->at('00:10')->timezone('America/Los_Angeles')->withoutOverlapping();
        $schedule->command('email:d-hudson-weekly-report')->fridays()->at('12:00')->timezone('America/Los_Angeles')->withoutOverlapping();
        // $schedule->command('quickbooks:auto-sync')->daily()->at('00:10')->timezone('America/Los_Angeles')->withoutOverlapping();
        $schedule->command('studio_item_order:create_billing_order')->lastDayOfMonth()->at('23:55')->timezone('America/Los_Angeles')->withoutOverlapping();
        $schedule->command('quickbooks:auto-sync')->daily()->at('00:10')->timezone('America/Los_Angeles')->withoutOverlapping();
        $schedule->command('inhandfollowup:due-date')->daily();

    }

    /**
     * Register the commands for the application.
     *
     * @return void
     */
    protected function commands()
    {
        $this->load(__DIR__.'/Commands');

        require base_path('routes/console.php');
    }
}
