<?php

namespace domainencore\Facades\ProjectFacade;

use domainencore\Services\ProjectService\ProjectService;
use Illuminate\Support\Facades\Facade;

class ProjectFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ProjectService::class;
    }
}
