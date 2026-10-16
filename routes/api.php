<?php

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Route;
use App\Http\Controllers\Api\OrderApiController;
use App\Http\Controllers\Api\SubscribersApiController;
use App\Http\Controllers\EMCustomerController;

/*
|--------------------------------------------------------------------------
| API Routes
|--------------------------------------------------------------------------
|
| Here is where you can register API routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| is assigned the "api" middleware group. Enjoy building your API!
|
*/

Route::middleware('auth:api')->get('/user', function (Request $request) {
    return $request->user();
});

Route::middleware('api.token.auth:DWC_ORDER')->group(function () {
    Route::get('/dwc_orders', [OrderApiController::class, 'getAllDWCOrders']);
});
Route::middleware('api.token.auth:SUBSCRIBERS')->group(function () {
    Route::post('/save-subcriptions', [SubscribersApiController::class, 'create']);
});

// Health check endpoint (no authentication required)
Route::get('/health', function () {
    return response()->json([
        'status' => 'ok',
        'timestamp' => now()->toISOString(),
        'version' => '1.0.0'
    ]);
});
Route::middleware('api.token.auth:BMS_API')->group(function () {
    Route::prefix('bms')->name('api.bms.')->group(function () {
        Route::get('/health', [EMCustomerController::class, 'apiHealth'])
            ->name('health');

        Route::get('/packages', [EMCustomerController::class, 'apiPackages'])
            ->name('packages');

        Route::get('/packages/{id}', [EMCustomerController::class, 'apiPackageDetails'])
            ->name('package.details');

        Route::get('/sessions', [EMCustomerController::class, 'apiSessions'])
            ->name('sessions');

        Route::get('/sessions/{id}', [EMCustomerController::class, 'apiSessionDetails'])
            ->name('session.details');
    });
});
