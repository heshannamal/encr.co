<?php

namespace domainencore\Facades\PatternCodeFacade;

use domainencore\Services\PatternCodeService\PatternCodeService;
use Illuminate\Support\Facades\Facade;

class PatternCodeFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return PatternCodeService::class;
    }
}
