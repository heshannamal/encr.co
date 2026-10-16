<?php

use Illuminate\Support\Facades\Route;
use Illuminate\Http\Request;

Route::middleware(['web'])->group(function () {
 Route::get('TeamStoreProductDetails/{id}', [App\Http\Controllers\CustomerTeamStoreController::class, 'customerTeamStoreproductDetails'])->name('customerTeamStoreproductDetails');
 Route::get('get_available_numbers', [App\Http\Controllers\CustomerTeamStoreController::class, 'get_available_numbers'])->name('get_available_numbers');
 Route::post('validateCustomerInputNumber', [App\Http\Controllers\CustomerTeamStoreController::class, 'validateCustomerInputNumber'])->name('validateCustomerInputNumber');
 Route::post('validateCustomerInputName', [App\Http\Controllers\CustomerTeamStoreController::class, 'validateCustomerInputName'])->name('validateCustomerInputName');
 Route::get('customerTeamStoreCart/{id}', [App\Http\Controllers\CustomerTeamStoreController::class, 'customerTeamStoreCart'])->name('customerTeamStoreCart');
 Route::get('GetCustomerTeamStoreCart', [App\Http\Controllers\CustomerTeamStoreController::class, 'GetCustomerTeamStoreCart'])->name('GetCustomerTeamStoreCart');
 Route::post('cartAddStore', [App\Http\Controllers\CustomerTeamStoreController::class, 'cartAddStore'])->name('cartAddStore');
 Route::post('cartAddBundleStore', [App\Http\Controllers\CustomerTeamStoreController::class, 'cartAddBundleStore'])->name('cartAddBundleStore');
 Route::post('getProductSizes', [App\Http\Controllers\CustomerTeamStoreController::class, 'getProductSizes'])->name('getProductSizes');
 Route::post('getBundleProductSizes', [App\Http\Controllers\CustomerTeamStoreController::class, 'getBundleProductSizes'])->name('getBundleProductSizes');
 Route::post('cartDeleteStore', [App\Http\Controllers\CustomerTeamStoreController::class, 'cartDeleteStore'])->name('cartDeleteStore');
 Route::get('storeProductCategoryWise', [App\Http\Controllers\CustomerTeamStoreController::class, 'storeProductCategoryWise'])->name('storeProductCategoryWise');
 Route::get('get_cart_items', [App\Http\Controllers\CustomerTeamStoreController::class, 'get_cart_items'])->name('get_cart_items');
 Route::post('addCartFromProduct', [App\Http\Controllers\CustomerTeamStoreController::class, 'addCartFromProduct'])->name('addCartFromProduct');
 Route::post('updateCartSize', [App\Http\Controllers\CustomerTeamStoreController::class, 'updateCartSize'])->name('updateCartSize');
 Route::get('proceedToCheckout', [App\Http\Controllers\CustomerTeamStoreController::class, 'proceedToCheckout'])->name('proceedToCheckout');
 Route::post('customerTeamStorePersonalDetails', [App\Http\Controllers\CustomerTeamStoreController::class, 'customerTeamStorePersonalDetails'])->name('customerTeamStorePersonalDetails');
 Route::post('storePaymentOnline', [App\Http\Controllers\CustomerTeamStoreController::class, 'storePaymentOnline'])->name('storePaymentOnline');
 Route::get('store/get_customer_payments', [App\Http\Controllers\CustomerTeamStoreController::class, 'get_customer_payments'])->name('store.get_customer_payments');
 Route::post('store/OrderExtraPaymentOnline', [App\Http\Controllers\CustomerTeamStoreController::class, 'OrderExtraPaymentOnline'])->name('store.OrderExtraPaymentOnline');
//  Route::get('store/get_customer_payments', [App\Http\Controllers\CustomerTeamStoreController::class, 'get_customer_payments'])->name('store.get_customer_payments');


 Route::get('shippo/get_shipping_fee', [App\Http\Controllers\ShippoController::class, 'get_shipping_fee'])->name('shippo.get_shipping_fee');

 Route::get('usps/get_shipping_fee', [App\Http\Controllers\USPSController::class, 'get_shipping_fee'])->name('usps.get_shipping_fee');

 Route::get('get_coupon_details', [App\Http\Controllers\StoreController::class, 'get_coupon_details'])->name('get_coupon_details');
 Route::get('{store_url}', [App\Http\Controllers\CustomerTeamStoreController::class, 'customerTeamStore'])->name('customerTeamStore');
 // Route::post('minusProductCart', [App\Http\Controllers\CustomerTeamStoreController::class, 'minusProductCart'])->name('minusProductCart');
 // Route::post('plusProductCart', [App\Http\Controllers\CustomerTeamStoreController::class, 'plusProductCart'])->name('plusProductCart');
 // Route::get('getProductSize', [App\Http\Controllers\CustomerTeamStoreController::class, 'getProductSize'])->name('getProductSize');
 // Route::post('addCartFromCart', [App\Http\Controllers\CustomerTeamStoreController::class, 'addCartFromCart'])->name('addCartFromCart');
 // Route::post('addCartColorFromCart', [App\Http\Controllers\CustomerTeamStoreController::class, 'addCartColorFromCart'])->name('addCartColorFromCart');
});
