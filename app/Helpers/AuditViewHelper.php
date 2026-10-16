<?php

namespace App\Helpers;

use App\Traits\AuditHelper;

class AuditViewHelper
{
    use AuditHelper;

    public static function getOrderStatusName($statusId)
    {
        return (new self)->getOrderStatus($statusId);
    }
}
