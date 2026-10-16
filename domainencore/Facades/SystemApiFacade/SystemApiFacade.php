<?php

namespace domainencore\Facades\SystemApiFacade;

use domainencore\Services\SystemApiService\SystemApiService;
use Illuminate\Support\Facades\Facade;

class SystemApiFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return SystemApiService::class;
    }
}
