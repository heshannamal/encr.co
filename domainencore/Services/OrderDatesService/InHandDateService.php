<?php

namespace domainencore\Services\OrderDatesService;

use App\Models\InHandDateLog;

class InHandDateService
{
    protected $inHandDateLogs;

    public function __construct()
    {
        $this->inHandDateLogs = new InHandDateLog();
    }

    public function get($orderId)
    {
        // return $this->inHandDateLogs->where('order_id', $orderId)->get();
        return $this->inHandDateLogs->getByOrder($orderId);
    }

    // public function getuserDetail($orderId)
    // {
    //     return $this->inHandDateLogs->getByOrder($orderId)[0]->userDetail;
    // }

    public function create($orderId, $userId, $preDate, $newDate, $reason)
    {
        $data['order_id'] = $orderId;
        $data['user_id'] = $userId;
        $data['pre_date'] = $preDate ?? '';
        $data['new_date'] = $newDate;
        $data['reason'] = $reason;

        return $this->inHandDateLogs->create($data);
    }
}
