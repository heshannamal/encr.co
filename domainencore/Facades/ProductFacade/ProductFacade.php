<?php

namespace domainencore\Facades\ProductFacade;

use domainencore\Services\ProductService\ProductService;
use Illuminate\Support\Facades\Facade;

class ProductFacade extends Facade
{
    protected static function getFacadeAccessor()
    {
        return ProductService::class;
    }
}
