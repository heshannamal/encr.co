<?php

namespace domainencore\Services\OrderDatesService;

use App\Models\ExFactoryDateLog;

class ExFactoryDateService
{
    protected $exFactoryDateLogs;

    public function __construct()
    {
        $this->exFactoryDateLogs = new ExFactoryDateLog();
    }

    public function get($orderId)
    {
        // return $this->exFactoryDateLogs->where('order_id', $orderId)->get();
        return $this->exFactoryDateLogs->getByOrder($orderId);
    }

    // public function getuserDetail($orderId)
    // {
    //     return $this->exFactoryDateLogs->getByOrder($orderId)[0]->userDetail;
    // }

    public function create($orderId, $userId, $preDate, $newDate, $reason)
    {
        $data['order_id'] = $orderId;
        $data['user_id'] = $userId;
        $data['pre_date'] = $preDate ?? '';
        $data['new_date'] = $newDate;
        $data['reason'] = $reason;

        $createdexFactoryDateLog = $this->exFactoryDateLogs->create($data);
        return $this->exFactoryDateLogs->with('orderDetail', 'userDetail')->where('id', $createdexFactoryDateLog->id)->first();
    }
}
