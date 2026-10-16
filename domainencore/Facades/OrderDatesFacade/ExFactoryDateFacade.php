<?php

namespace domainencore\Facades\OrderDatesFacade;

use domainencore\Services\OrderDatesService\ExFactoryDateService;
use Illuminate\Support\Facades\Facade;

class ExFactoryDateFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ExFactoryDateService::class;
    }
}
