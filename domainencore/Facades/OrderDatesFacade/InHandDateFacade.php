<?php

namespace domainencore\Facades\OrderDatesFacade;

use domainencore\Services\OrderDatesService\InHandDateService;
use Illuminate\Support\Facades\Facade;

class InHandDateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return InHandDateService::class;
    }
}
