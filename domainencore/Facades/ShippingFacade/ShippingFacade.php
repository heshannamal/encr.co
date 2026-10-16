<?php

namespace domainencore\Facades\ShippingFacade;

use domainencore\Services\ShippingService\ShippingService;
use Illuminate\Support\Facades\Facade;

class ShippingFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ShippingService::class;
    }
}
