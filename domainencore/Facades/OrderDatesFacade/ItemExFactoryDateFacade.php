<?php

namespace domainencore\Facades\OrderDatesFacade;

use domainencore\Services\OrderDatesService\ItemExFactoryDateService;
use Illuminate\Support\Facades\Facade;

class ItemExFactoryDateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ItemExFactoryDateService::class;
    }
}
