<?php

namespace App\Observers;

use App\Models\ActivityLogs;
use Illuminate\Support\Facades\Auth;
use Spatie\Activitylog\Models\Activity;

class ActivityLogsObserver
{
    /**
     * Handle the ActivityLogs "created" event.
     *
     * @param  \App\Models\ActivityLogs  $activityLogs
     * @return void
     */
    public function created(ActivityLogs $activityLogs)
    {
        $order_id = $activityLogs->order->order_id ?? null;

        activity()
            ->causedBy(Auth::user())
            ->performedOn($activityLogs)
            ->withProperties(['order_id' => $order_id])
            ->log('created');
    }

    /**
     * Handle the ActivityLogs "updated" event.
     *
     * @param  \App\Models\ActivityLogs  $activityLogs
     * @return void
     */
    public function updated(ActivityLogs $activityLogs)
    {
        $order_id = $activityLogs->order->order_id ?? null;

        activity()
            ->causedBy(Auth::user())
            ->performedOn($activityLogs)
            ->withProperties(['order_id' => $order_id])
            ->log('updated');
    }

    /**
     * Handle the ActivityLogs "deleted" event.
     *
     * @param  \App\Models\ActivityLogs  $activityLogs
     * @return void
     */
    public function deleted(ActivityLogs $activityLogs)
    {
        $order_id = $activityLogs->order->order_id ?? null;

        activity()
            ->causedBy(Auth::user())
            ->performedOn($activityLogs)
            ->withProperties(['order_id' => $order_id])
            ->log('deleted');
    }

    /**
     * Handle the ActivityLogs "restored" event.
     *
     * @param  \App\Models\ActivityLogs  $activityLogs
     * @return void
     */
    public function restored(ActivityLogs $activityLogs)
    {
        //
    }

    /**
     * Handle the ActivityLogs "force deleted" event.
     *
     * @param  \App\Models\ActivityLogs  $activityLogs
     * @return void
     */
    public function forceDeleted(ActivityLogs $activityLogs)
    {
        //
    }
}
