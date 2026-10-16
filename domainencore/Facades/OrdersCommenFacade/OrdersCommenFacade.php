<?php

namespace domainencore\Facades\OrdersCommenFacade;

use domainencore\Services\OrdersCommenService\OrdersCommenService;
use Illuminate\Support\Facades\Facade;

class OrdersCommenFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return OrdersCommenService::class;
    }
}
