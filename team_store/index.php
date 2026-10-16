<?php

use Illuminate\Contracts\Http\Kernel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

define('LARAVEL_START', microtime(true));

// Load the Composer autoloader
require __DIR__ . '/../vendor/autoload.php';

$app = require_once __DIR__ . '/../bootstrap/app.php';
$kernel = $app->make(Kernel::class);

$request = Request::capture();

$app->booted(function () {
    \Illuminate\Support\Facades\URL::forceRootUrl(config('app.url'));
    require __DIR__ . '/../routes/team_store.php';
});

$response = $kernel->handle($request)->send();
$kernel->terminate($request, $response);

