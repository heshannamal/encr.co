<?php

namespace domainencore\Services\OrderDatesService;

use App\Models\ItemExFactoryDateLog;

class ItemExFactoryDateService
{
    protected $ItemexFactoryDateLogs;

    public function __construct()
    {
        $this->ItemexFactoryDateLogs = new ItemExFactoryDateLog();
    }

    public function get($orderItemId)
    {
        // return $this->exFactoryDateLogs->where('order_id', $orderId)->get();
        // return $this->ItemexFactoryDateLogs->getByOrder($orderItemId);
        return $this->ItemexFactoryDateLogs->getByOrderItem($orderItemId);
    }

    // public function getuserDetail($orderId)
    // {
    //     return $this->exFactoryDateLogs->getByOrder($orderId)[0]->userDetail;
    // }

    public function create($orderItemId, $userId, $preDate, $newDate, $reason)
    {
        $data['order_item_id'] = $orderItemId;
        $data['user_id'] = $userId;
        $data['pre_date'] = $preDate ?? '';
        $data['new_date'] = $newDate;
        $data['reason'] = $reason;

        $createdItemexFactoryDateLog = $this->ItemexFactoryDateLogs->create($data);
        return $this->ItemexFactoryDateLogs->with('orderItemDetail', 'userDetail')->where('id', $createdItemexFactoryDateLog->id)->first();
    }
}
