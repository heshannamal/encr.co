<?php

namespace App\Traits;

use App\Models\OrderStatus;

trait AuditHelper
{
    public function getOrderStatus($statusId)
    {
        if($statusId){
            $status = OrderStatus::find($statusId);
            if($status){
                return $status->status_name;
            } else {
                return null;
            }
        } else {
            return null;
        }
    }
}
