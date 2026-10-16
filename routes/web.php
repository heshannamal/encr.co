<?php

use Illuminate\Support\Facades\Route;
use App\Events\SupportMessageSent;
use App\Models\SupportMessage;
use App\Exports\SalesTaxReportExport;
use Maatwebsite\Excel\Facades\Excel;
use App\Http\Controllers\O365Controller;
/*
|--------------------------------------------------------------------------
| Web Routes
|--------------------------------------------------------------------------
|
| Here is where you can register web routes for your application. These
| routes are loaded by the RouteServiceProvider within a group which
| contains the "web" middleware group. Now create something great!
|
*/
Route::get('/env-pusher-test', function () {
    return response()->json([
        'id' => env('PUSHER_APP_ID'),
        'key' => env('PUSHER_APP_KEY'),
        'secret' => env('PUSHER_APP_SECRET'),
    ]);
});
Route::get('/web-broadcast-test', function () {
    try {
        $message = SupportMessage::latest()->first();

        if (!$message) {
            return response()->json([
                'status' => false,
                'message' => 'No support message found',
            ]);
        }

        event(new SupportMessageSent($message));

        return response()->json([
            'status' => true,
            'message' => 'Broadcast OK from web request',
        ]);
    } catch (\Throwable $e) {
        return response()->json([
            'status' => false,
            'error' => $e->getMessage(),
            'file' => $e->getFile(),
            'line' => $e->getLine(),
        ], 500);
    }
});
Route::get('/web-broadcast-config', function () {
    return response()->json([
        'default' => config('broadcasting.default'),
        'pusher' => config('broadcasting.connections.pusher'),
    ]);
});
Route::get('/', function () {
    return view('auth/login');
})->name('login');

Auth::routes();
Route::get('/home', [App\Http\Controllers\HomeController::class, 'index'])->name('home');

Route::get('roster/{orderId}', [App\Http\Controllers\RosterController::class, 'index'])->name('roster', 'orderId');
Route::post('roster/update', [App\Http\Controllers\RosterController::class, 'update'])->name('roster.update');
Route::post('roster/request', [App\Http\Controllers\RosterController::class, 'request'])->name('roster.request');
Route::get('roster/complete/{id}', [App\Http\Controllers\RosterController::class, 'complete']);
Route::get('roster/print_order_item/{id}', [App\Http\Controllers\RosterController::class, 'printOrderItem']);
Route::post('roster/new_address', [App\Http\Controllers\RosterController::class, 'newAddress'])->name('roster.new_address');
Route::get('customer_payment', [App\Http\Controllers\PaymentController::class, 'customerPayment'])->name('customer_payment');
Route::post('/customer_payment/online', [App\Http\Controllers\PaymentController::class, 'handleCustomerOnlinePay'])->name('customer_payment.online');
// Route::post('customer_payment/check', [App\Http\Controllers\PaymentController::class, 'customerPaymentCheck'])->name('customer_payment.check');
Route::get('customer_payment_download/check', [App\Http\Controllers\PaymentController::class, 'customerPaymentDownloadCheck'])->name('customer_payment_download.check');
Route::get('customer_payment_download/venmo', [App\Http\Controllers\PaymentController::class, 'customerPaymentDownloadVenmo'])->name('customer_payment_download.venmo');
Route::get('customer_payment_download/po', [App\Http\Controllers\PurchaseOrderController::class, 'customerPaymentDownloadpo'])->name('customer_payment_download.po');
Route::get('Approve/po/{id}', [App\Http\Controllers\PurchaseOrderController::class, 'approvepo'])->name('approve.po');
Route::post('customer_payment/check', [App\Http\Controllers\ChequePaymentController::class, 'customerPaymentCheck'])->name('customer_payment.check');
Route::post('customer_payment/venmo', [App\Http\Controllers\VenmoPaymentController::class, 'customerPaymentVenmo'])->name('customer_payment.venmo');
Route::post('customer_payment/Purchase-Order', [App\Http\Controllers\PurchaseOrderController::class, 'customerPaymentPurchaseOrder'])->name('customer_payment.PO');
Route::post('customer_payment/paypal', [App\Http\Controllers\PaypalPaymentController::class, 'customerPaymentPaypal'])->name('customer_payment.paypal');
Route::post('do_pay_multiple_orders', [App\Http\Controllers\PaymentController::class, 'do_pay_multiple_orders'])->name('do_pay_multiple_orders');
Route::post('roster/paste_roster', [App\Http\Controllers\RosterController::class, 'pasteRoster'])->name('roster.paste_roster');
Route::post('po_approve_or_reject', [App\Http\Controllers\PurchaseOrderController::class, 'poApproveRejectByPaymentPage'])->name('po_approve_reject_payment');
Route::post('po_approve_reject', [App\Http\Controllers\PurchaseOrderController::class, 'poApproveReject'])->name('poApproveReject');

//password reset routes
Route::group(['middleware' => 'user_password_reset'], function () {
    Route::get('forgot-password', [App\Http\Controllers\Auth\PasswordController::class, 'index'])->name('forgot-password');
    Route::post('forgot-password/reset-mail', [App\Http\Controllers\Auth\PasswordController::class, 'sentResetMail'])->name('forgot-password.reset-mail');
    Route::get('forgot-password/reset-password/{token}/{email}', [App\Http\Controllers\Auth\PasswordController::class, 'resetPassword'])->name('forgot-password.reset-password');
    Route::post('forgot-password/reset-password-submit', [App\Http\Controllers\Auth\PasswordController::class, 'resetPasswordSubmit'])->name('forgot-password.reset-password-submit');
});
// Customer Portal shipmet summery view without Auth
Route::get('customer_portal/shipment_summary_view/{id}', [App\Http\Controllers\NewCustomerPortalController::class, 'shipment_summary_view'])->name('customer_portal.shipment_summary_view');
Route::get('customer_portal/shipment_summary/{id}', [App\Http\Controllers\NewCustomerPortalController::class, 'shipment_summary_view_ajax'])->name('customer_portal.shipment_summary_view_ajax');
Route::get('customer_portal/shipment_summary_view/pdf/{id}', [App\Http\Controllers\NewCustomerPortalController::class, 'shipment_summary_exportPdf'])->name('customer_portal.shipment_summary.pdf');
// Secret route that only works in maintenance mode
Route::get('/verify-admin', function () {
    return view('auth.secret-login'); // A blade file that asks for admin password
})->name('secret.login');
Route::post('/verify-admin', function (\Illuminate\Http\Request $request) {

    // Option 2: check real admin user (example for id=1)
    $admin = \App\Models\User::find(1);
    if ($admin && \Illuminate\Support\Facades\Hash::check($request->password, $admin->password)) {

        return redirect()->intended('/verify-admin-pw');
    }

    return back()->withErrors(['password' => 'Invalid password']);
})->name('secret.unlock');

Route::get('/pdt/dxf/{file}', function ($file) {

    $path = public_path('pdt/dxf/' . $file);

    abort_unless(file_exists($path), 404);

    return response()->file($path, [
        'Access-Control-Allow-Origin' => 'https://dev.encr.co',
        'Access-Control-Allow-Methods' => 'GET',
    ]);

});
Route::get('/pdt/models/{file}', function ($file) {

    $path = public_path('pdt/models/' . $file);

    abort_unless(file_exists($path), 404);

    return response()->file($path, [
        'Access-Control-Allow-Origin' => 'https://dev.encr.co',
        'Access-Control-Allow-Methods' => 'GET',
    ]);

});

Route::group(['middleware' => 'auth'], function () {

    //PDT
    Route::get('/pdt',  [App\Http\Controllers\PdtController::class, 'index'])->name('pdt.index');
    Route::post('/pdt/save',  [App\Http\Controllers\PdtController::class, 'store'])->name('pdt.store');
    // Route::get('/pdt/{id}/edit', [App\Http\Controllers\PdtController::class, 'edit'])->name('pdt.edit');
    Route::post('/pdt/update', [App\Http\Controllers\PdtController::class, 'update'])->name('pdt.update');

    // Route for initiating Azure AD login
    Route::get('/login/azure', 'App\Http\Controllers\AzureLoginController@redirectToAzure')->name('azure.logging');

    // Route for handling Azure AD callback and user creation
    Route::get('/auth/azure/callback', 'App\Http\Controllers\AzureLoginController@handleAzureCallback');
    Route::get('/auth/azure/logout', 'App\Http\Controllers\AzureLoginController@logout')->name('azure.logout');

// Dashboard
	Route::get('/', [App\Http\Controllers\HomeController::class, 'index'])->name('home');
	Route::post('change_flag', [App\Http\Controllers\HomeController::class, 'changeFlag'])->name('change_flag');
	Route::get('under_contruction', [App\Http\Controllers\HomeController::class, 'underContruction'])->name('under_contruction');

	Route::resource('user', 'App\Http\Controllers\UserController', ['except' => ['show']]);
	// Route::get('profile', ['as' => 'profile.edit', 'uses' => 'App\Http\Controllers\ProfileController@edit']);
	Route::put('profile', ['as' => 'profile.update', 'uses' => 'App\Http\Controllers\ProfileController@update']);
	Route::get('upgrade', function () {return view('pages.upgrade');})->name('upgrade');
	Route::get('map', function () {return view('pages.maps');})->name('map');
	Route::get('icons', function () {return view('pages.icons');})->name('icons');
	Route::get('table-list', function () {return view('pages.tables');})->name('table');
	Route::put('profile/password', ['as' => 'profile.password', 'uses' => 'App\Http\Controllers\ProfileController@password']);

	/*addOrdes*/
	Route::post('/invoice/create', 'App\Http\Controllers\OrderController@addOrders')->name('invoice.create');
	Route::get('/order_items/get_order_items_by_id/{orderId}', 'App\Http\Controllers\OrderController@getOrders');
    // Route::get('profile/edit}', 'App\Http\Controllers\NewOrderController@viewInvoice')->name('profile.edit');

    //profile edit
    Route::get('profile/edit', [App\Http\Controllers\ProfileController::class, 'index'])->name('profile.edit'); // this is user profile edit by himself
    Route::get('get/Timezones', [App\Http\Controllers\ProfileController::class, 'getTimezones'])->name('getTimezones');
    Route::post('/update-profile', [App\Http\Controllers\ProfileController::class, 'updateprofile'])->name('profile_update');
    Route::post('/update-profile-picture', [App\Http\Controllers\ProfileController::class, 'updateProfilePicture'])->name('updateProfilePicture');
    Route::post('/change-password', [App\Http\Controllers\ProfileController::class, 'changePassword'])->name('password.change');
    Route::post('/user-change-password', [App\Http\Controllers\ProfileController::class, 'userchangePassword'])->name('userpassword.change');
    Route::get('/leave-Manage', [App\Http\Controllers\ProfileController::class, 'LeaveManage'])->name('leave.manage');
    Route::post('/leave-Manage/create', [App\Http\Controllers\ProfileController::class, 'LeaveCreate'])->name('leave.create');
    Route::put('/leave-Manage/update/{id}', [App\Http\Controllers\ProfileController::class, 'LeaveUpdate'])->name('leave.update');
    Route::patch('/leave-Manage/withdraw/{id}', [App\Http\Controllers\ProfileController::class, 'LeaveWithdraw'])->name('leave.withdraw');
    Route::post('/leave-Manage/type/create', [App\Http\Controllers\ProfileController::class, 'LeaveTypeCreate'])->name('leavetype.create');
    Route::put('/leave-Manage/type/update', [App\Http\Controllers\ProfileController::class, 'updateLeaveType'])->name('leavetype.update');
    Route::delete('/leave-type/delete/{id}', [App\Http\Controllers\ProfileController::class, 'deleteLeaveType'])->name('leavetype.delete');
    Route::get('/leave-Manage/get/{status_id}/{u_id}', [App\Http\Controllers\ProfileController::class, 'GetTableData'])->name('leave.GetTableData');
    Route::get('/leave-Manage/getrequests', [App\Http\Controllers\ProfileController::class, 'GetTableDataAll'])->name('leave.GetTableDataAll');
    Route::get('/leave-Manage/getLeaveRequestDetails', [App\Http\Controllers\ProfileController::class, 'getLeaveRequestDetails'])->name('leave.getLeaveRequestDetails');
    Route::post('/leave-Manage/updateLeaveStatus', [App\Http\Controllers\ProfileController::class, 'updateLeaveStatus'])->name('leave.updateLeaveStatus');
    Route::get('/check-leave-conflict', [App\Http\Controllers\ProfileController::class, 'checkLeaveConflict'])->name('checkLeaveConflict');

    // Order Management
	// Inventory Orders
    Route::get('inventory_orders', [App\Http\Controllers\InventoryOrderController::class, 'index'])->name('inventory_orders');
    Route::get('inventory_orders/get_orders', [App\Http\Controllers\InventoryOrderController::class, 'getOrders']);
    Route::post('inventory_orders/filter_table', [App\Http\Controllers\InventoryOrderController::class, 'filterTable']);
    Route::get('inventory_orders/sort_by_alphabet/{id}', [App\Http\Controllers\InventoryOrderController::class, 'sortByAlphabet']);

    Route::post('inventory_orders/layout', [App\Http\Controllers\InventoryOrderController::class, 'layout'])->name('inventory_orders.layout');
    Route::post('inventory_orders/show_column', [App\Http\Controllers\InventoryOrderController::class, 'showColumn'])->name('inventory_orders.show_column');
    Route::post('inventory_orders/hide_column', [App\Http\Controllers\InventoryOrderController::class, 'hideColumn'])->name('inventory_orders.hide_column');
    Route::post('inventory_orders/column_layout', [App\Http\Controllers\InventoryOrderController::class, 'columnLayout'])->name('inventory_orders.column_layout');

    Route::get('inventory_orders/export_csv', [App\Http\Controllers\InventoryOrderController::class, 'exportCsv'])->name('inventory_orders.export_csv');

    Route::get('inventory_orders/get_order_with_inventory_detail/{id}', [App\Http\Controllers\InventoryOrderController::class, 'getOrderWithInventoryDetail'])->name('inventory_orders.get_order_with_inventory_detail');
    Route::post('inventory_orders/add_to_inventory', [App\Http\Controllers\InventoryOrderController::class, 'addToInventory'])->name('inventory_orders.add_to_inventory');
    Route::get('inventory_orders/cancel_adding_order_to_inventory/{id}', [App\Http\Controllers\InventoryOrderController::class, 'cancelAddingOrderToInventory'])->name('inventory_orders.cancel_adding_order_to_inventory');

    // New Inventory Orders
	Route::get('new_inventory_orders', [App\Http\Controllers\NewInventoryOrderController::class, 'index'])->name('new_inventory_orders');
	Route::get('new_inventory_orders/{id}', [App\Http\Controllers\NewInventoryOrderController::class, 'newOrdersFromOrganization']);
    Route::get('new_inventory_orders/address/{customerId}', [App\Http\Controllers\NewInventoryOrderController::class, 'address'])->name('new_inventory_orders.address');
    Route::get('new_inventory_orders/product/{productId}', [App\Http\Controllers\NewInventoryOrderController::class, 'product'])->name('new_inventory_orders.product');
    Route::get('new_inventory_orders/status/{statusId}', [App\Http\Controllers\NewInventoryOrderController::class, 'status'])->name('new_inventory_orders.status');
    Route::post('new_inventory_orders/create', [App\Http\Controllers\NewInventoryOrderController::class, 'create'])->name('new_inventory_orders.create');
    Route::get('new_inventory_orders/product_filter/{sport}/{gender}/{category}', [App\Http\Controllers\NewInventoryOrderController::class, 'productFilter']);
    Route::get('get_product_style_details', [App\Http\Controllers\NewInventoryOrderController::class, 'getProductStyleDetails']);

    Route::get('products/setStatus/{id}/{status}', [App\Http\Controllers\ProductController::class, 'setStatus']);
    Route::get('new_inventory_orders/customers/{organizationId}', [App\Http\Controllers\NewInventoryOrderController::class, 'customers'])->name('new_inventory_orders.customers');

    // Re Inventory Orders
    Route::post('new_inventory_orders/create_re_order', [App\Http\Controllers\NewInventoryOrderController::class, 'createReOrder'])->name('new_inventory_orders.create_re_order');

    // Route::get('inventory_order_details', [App\Http\Controllers\OrderDetailsController::class, 'index'])->name('inventory_order_details');
	// Route::get('inventory_order_details/edit/{id}', [App\Http\Controllers\OrderDetailsController::class, 'edit']);
	// Route::get('inventory_order_details/edit/{id}/{type}', [App\Http\Controllers\OrderDetailsController::class, 'edit']);


	// New Orders
	Route::get('new_orders', [App\Http\Controllers\NewOrderController::class, 'index'])->name('new_orders');
	Route::get('new_orders/{id}', [App\Http\Controllers\NewOrderController::class, 'newOrdersFromOrganization']);
    Route::get('new_orders/address/{customerId}', [App\Http\Controllers\NewOrderController::class, 'address'])->name('new_orders.address');
    Route::get('new_orders/product/{productId}', [App\Http\Controllers\NewOrderController::class, 'product'])->name('new_orders.product');
    Route::get('new_orders/status/{statusId}', [App\Http\Controllers\NewOrderController::class, 'status'])->name('new_orders.status');
    Route::post('new_orders/create', [App\Http\Controllers\NewOrderController::class, 'create'])->name('new_orders.create');
    Route::get('new_orders/product_filter/{sport}/{gender}/{category}', [App\Http\Controllers\NewOrderController::class, 'productFilter']);
    Route::post('get_product_style_details', [App\Http\Controllers\NewOrderController::class, 'getProductStyleDetails']);

    Route::get('products/setStatus/{id}/{status}', [App\Http\Controllers\ProductController::class, 'setStatus']);
    Route::get('new_orders/customers/{organizationId}', [App\Http\Controllers\NewOrderController::class, 'customers'])->name('new_orders.customers');

    // Re Orders
    Route::post('new_orders/create_re_order', [App\Http\Controllers\NewOrderController::class, 'createReOrder'])->name('new_orders.create_re_order');
    Route::get('missing-products-reorder', [App\Http\Controllers\NewOrderController::class, 'missing_products'])->name('missing_reorder.products');
    Route::post('missing-products-update-reorder', [App\Http\Controllers\NewOrderController::class, 'missing_products_update'])->name('missing_reorder.products_update');

	// Order Management
    Route::get('orders', [App\Http\Controllers\OrderController::class, 'index'])->name('orders');
    Route::get('plorders', [App\Http\Controllers\OrderController::class, 'pl_index'])->name('plorders');
    Route::get('order/changeUpcoming/{order_id}/{status}', [App\Http\Controllers\OrderController::class, 'ChangeUpcomingStatus'])->name('ChangeUpcomingStatus');
    Route::get('orders/invoice/{id}', [App\Http\Controllers\OrderController::class, 'invoice'])->name('invoice_Download');
    Route::get('orders/quote/{id}', [App\Http\Controllers\OrderController::class, 'quote'])->name('quotePDF_Download');
    Route::get('orders/edit/{id}', [App\Http\Controllers\OrderController::class, 'edit']);
	Route::post('orders/cancel', [App\Http\Controllers\OrderController::class, 'cancel_order'])->name('cancel_order');
	Route::get('orders/delete/{id}', [App\Http\Controllers\OrderController::class, 'delete'])->name('deleteOrder');
	Route::get('orders/deleteMainOrder/{id}', [App\Http\Controllers\OrderController::class, 'deleteMainOrder']);
    Route::get('orders/change_flag/{orderId}/{flagColor}', [App\Http\Controllers\OrderController::class, 'changeFlag']);
    Route::post('orders/update', [App\Http\Controllers\OrderController::class, 'update'])->name('orders.update');
    Route::get('orders/export_csv', [App\Http\Controllers\OrderController::class, 'exportCsv'])->name('orders.export_csv');
    Route::get('orders/sort_by_alphabet/{id}', [App\Http\Controllers\OrderController::class, 'sortByAlphabet']);
    Route::post('get_multiple_order_details', [App\Http\Controllers\OrderController::class, 'get_multiple_order_details'])->name('get_multiple_order_details');
    Route::post('orders/saved_order_item_update', [App\Http\Controllers\OrderController::class, 'saved_order_item_update'])->name('saved_order_item_update');
    Route::post('orders/delete_saved_item', [App\Http\Controllers\OrderController::class, 'delete_saved_item'])->name('delete_saved_item');

    Route::get('orders/fulfill_order', [App\Http\Controllers\OrderController::class, 'fullfill_order'])->name('fulfill_order');

    // Route::get('orders/filter_table/{factoryId}/{statusId}/{paginateNo}', [App\Http\Controllers\OrderController::class, 'filterTable']);
    Route::post('orders/filter_table', [App\Http\Controllers\OrderController::class, 'filterTable']);
    Route::post('orders/plorders/filter_table', [App\Http\Controllers\OrderController::class, 'pl_filterTable']);

    Route::get('orders/get_orders', [App\Http\Controllers\OrderController::class, 'getOrders']);
    Route::get('orders/product/{productId}', [App\Http\Controllers\OrderController::class, 'product'])->name('orders.product');
    Route::get('orders/product_filter/{sport}/{gender}/{category}', [App\Http\Controllers\OrderController::class, 'productFilter']);
    Route::post('orders/layout', [App\Http\Controllers\OrderController::class, 'layout'])->name('orders.layout');
    Route::post('orders/show_column', [App\Http\Controllers\OrderController::class, 'showColumn'])->name('orders.show_column');
    Route::post('orders/hide_column', [App\Http\Controllers\OrderController::class, 'hideColumn'])->name('orders.hide_column');
    Route::post('orders/column_layout', [App\Http\Controllers\OrderController::class, 'columnLayout'])->name('orders.column_layout');

    Route::get('orders/filter_sub_products', [App\Http\Controllers\OrderController::class, 'filter_sub_products'])->name('filter_sub_products');

    Route::get('orders/order_item_table_option', [App\Http\Controllers\OrderController::class, 'order_item_table_option'])->name('order_item_table_option');
    Route::get('orders/sub_product_creating', [App\Http\Controllers\OrderController::class, 'sub_product_creating'])->name('sub_product_creating');
    Route::get('orders/fabricID_update', [App\Http\Controllers\OrderController::class, 'fabricID_update'])->name('fabricID_update');
    Route::post('orders/approve-production', [App\Http\Controllers\OrderController::class, 'approveProduction'])->name('approve.production');

	Route::get('order_details', [App\Http\Controllers\OrderDetailsController::class, 'index'])->name('order_details');
	Route::get('order_details/edit/{id}', [App\Http\Controllers\OrderDetailsController::class, 'edit']);
	Route::get('order_details/edit/{id}/{type}', [App\Http\Controllers\OrderDetailsController::class, 'edit'])->name('orders.info');
	Route::get('order_details/item/view/{orderid}/{orderItemId}', [App\Http\Controllers\OrderDetailsController::class, 'orderItemview'])->name('orderitem.info');
	Route::post('order_details/mention_users', [App\Http\Controllers\OrderDetailsController::class, 'mentionUsers']);
	Route::post('order_sequence/update', [App\Http\Controllers\OrderDetailsController::class, 'update'])->name('order_sequence.update');
	Route::post('order_details/reorder_items', [App\Http\Controllers\OrderDetailsController::class, 'reorderItems'])->name('order_details.reorder_items');
	Route::post('order_details/paste_roster', [App\Http\Controllers\OrderDetailsController::class, 'pasteRoster'])->name('order_details.paste_roster');
    Route::get('orders/addQuation/{id}', [App\Http\Controllers\OrderDetailsController::class, 'addQuotaion']);
    Route::get('order_details/accept_request/{id}', [App\Http\Controllers\OrderDetailsController::class, 'acceptRequest']);
    Route::get('order_details/print_order_item/{id}', [App\Http\Controllers\OrderDetailsController::class, 'printOrderItem']);
	Route::post('order/shippingsave', [App\Http\Controllers\OrderDetailsController::class, 'shippingsave']);
	Route::post('order/shippingupdate', [App\Http\Controllers\OrderDetailsController::class, 'shippingupdate']);
	Route::post('order/mistaken_shipping_updates', [App\Http\Controllers\OrderDetailsController::class, 'mistaken_shipping_updates']);
	Route::post('order/shippingnotification', [App\Http\Controllers\OrderDetailsController::class, 'sendMailNotification']);
	Route::post('order/shippingnotification_saveDraft', [App\Http\Controllers\OrderDetailsController::class, 'saveDraftNotification']);
	Route::get('orders/pdf/{id}', [App\Http\Controllers\OrderController::class, 'pdf'])->name('PDF_Download');
	Route::post('order/itemNotesSave', [App\Http\Controllers\OrderDetailsController::class, 'itemNoteSave']);
    Route::post('order_details/change_due_date', [App\Http\Controllers\OrderDetailsController::class, 'changeDueDate']);
    Route::post('order_details/change_ex_factory_date', [App\Http\Controllers\OrderDetailsController::class, 'changeExFactoryDate']);
    Route::post('order_details/shipping_details', [App\Http\Controllers\OrderDetailsController::class, 'shippingDetails']);
    Route::post('order_details/shipping_summery', [App\Http\Controllers\OrderDetailsController::class, 'shippingSummery']);
    Route::post('order_details/update_item_attributes', [App\Http\Controllers\OrderDetailsController::class, 'updateItemAttributes']);
    Route::get('order_details/get_sales_team/{orderId}', [App\Http\Controllers\OrderDetailsController::class, 'getSalesTeam']);
    Route::get('order_details/drafted_shipping_details/{orderId}', [App\Http\Controllers\OrderDetailsController::class, 'getdraftedShippingDetails']);
    Route::post('order_details/commentFileUpload', [App\Http\Controllers\OrderDetailsController::class, 'commentFileUpload'])->name('order_details.commentFileUpload');
    Route::post('order_details/authenticate', [App\Http\Controllers\OrderDetailsController::class, 'authenticate'])->name('order_details.authenticate');
    Route::post('order_details/ex_factory_authenticate', [App\Http\Controllers\OrderDetailsController::class, 'exFactoryAuthenticate'])->name('order_details.ex_factory_authenticate');
	Route::get('orders/items_design/{id}', [App\Http\Controllers\OrderController::class, 'initiateFolderCreation'])->name('DownloadOrderItemDesign');
	Route::post('orders/items_design/add-files-to-zip/{order_id}/{id}', [App\Http\Controllers\OrderController::class, 'addFilesToFolder'])->name('addFilesToZip');
	Route::get('/download-folder', [App\Http\Controllers\OrderController::class, 'downloadFolder'])->name('downloadFolder');
    Route::post('order_details/update_credentials', [App\Http\Controllers\OrderDetailsController::class, 'update_credentials'])->name('order.update_credentials');
    Route::post('order_details/get_pattern_code', [App\Http\Controllers\OrderDetailsController::class, 'get_pattern_code'])->name('order.get_pattern_code');
    Route::get('order_details/get_customers_with_orders', [App\Http\Controllers\OrderDetailsController::class, 'get_customers_with_orders'])->name('order.get_customers_with_orders');
    Route::get('order_details/report/{orderId}/download', [App\Http\Controllers\OrderDetailsController::class, 'downloadTrackingReport'])->name('order.report.download');


	Route::post('orders/reject_or_confirm_order_directly', [App\Http\Controllers\OrderDetailsController::class, 'reject_or_confirm_order_directly'])->name('reject_or_confirm_order_directly');
	Route::post('orders/reject_or_confirm_factory_suggest', [App\Http\Controllers\OrderDetailsController::class, 'reject_or_confirm_factory_suggest'])->name('reject_or_confirm_factory_suggest');

    Route::get('orders/attributes_update', [App\Http\Controllers\OrderDetailsController::class, 'attributes_update'])->name('attributes_update');

	Route::post('orders/auto_update_fullfill_status', [App\Http\Controllers\OrderDetailsController::class, 'auto_update_fullfill_status'])->name('auto_update_fullfill_status');
	Route::get('orders/DownloadTestPrint/{id}', [App\Http\Controllers\OrderDetailsController::class, 'DownloadTestPrint'])->name('DownloadTestPrint');

    Route::get('orders/export_order_roster_template/{orderId}', [App\Http\Controllers\NewCustomerPortalController::class, 'exportOrderRosterTemplate'])->name('orders.export_order_roster_template');
    Route::post('orders/import_order_roster', [App\Http\Controllers\NewCustomerPortalController::class, 'importOrderRoster'])->name('orders.import_order_roster');
Route::post(
    'organizations/{id}/open-customer-portal',
    [App\Http\Controllers\NewCustomerPortalController::class, 'adminOpenCustomerPortal']
)->name('organizations.open_customer_portal');
    // remake orders
    Route::post('order/add_to_remake_list', [App\Http\Controllers\OrderRemakeController::class, 'add_to_remake_list'])->name('order.add_to_remake_list');
    Route::post('order/remake_items', [App\Http\Controllers\OrderRemakeController::class, 'remake_items'])->name('order.remake_items');
    Route::post('order/remake_studio_item', [App\Http\Controllers\OrderRemakeController::class, 'remake_studio_item'])->name('order.remake_studio_item');
    Route::get('order/view_remake_list/{id}', [App\Http\Controllers\OrderRemakeController::class, 'view_remake_list'])->name('order.view_remake_list');
    Route::get('order/count_remake_items/{id}', [App\Http\Controllers\OrderRemakeController::class, 'count_remake_items'])->name('order.count_remake_items');
    Route::get('order/remove_remake_items/{id}', [App\Http\Controllers\OrderRemakeController::class, 'remove_remake_items'])->name('order.remove_remake_items');
    Route::post('order/remake/update/order_qty', [App\Http\Controllers\OrderRemakeController::class, 'update_remake_qty'])->name('order.update_remake_qty');
    Route::post('order/remake/update/order_reason', [App\Http\Controllers\OrderRemakeController::class, 'update_remake_reason'])->name('order.update_remake_reason');
    Route::post('order/remake/update/order_est_delivery_date', [App\Http\Controllers\OrderRemakeController::class, 'update_remake_est_delivery_date'])->name('order.update_remake_est_delivery_date');
    Route::post('order/remake/update/order_ex_factory_date', [App\Http\Controllers\OrderRemakeController::class, 'update_remake_ex_factory_date'])->name('order.update_remake_ex_factory_date');

    Route::get('orders/organization_without_activities', [App\Http\Controllers\OrderController::class, 'organization_without_activities'])->name('orders.organization_without_activities');
    Route::get('orders/organization_without_activities_export', [App\Http\Controllers\OrderController::class, 'organization_without_activities_export'])->name('orders.organization_without_activities_export');



	Route::get('email', [App\Http\Controllers\AppsController::class, 'TestIndexEmails']);

	Route::get('orders/csv/{id}', [App\Http\Controllers\OrderController::class, 'csv'])->name('quoteCSV_Download');
    Route::get('/download-excel/{id}', [App\Http\Controllers\OrderController::class, 'downloadExcel'])->name('download.excel');

	//Route::get('order/ship', [App\Http\Controllers\OrderDetailsController::class, 'sendMailNotification']);

    // delete images & files
    Route::post('order_details/file_delete/{orderId}', [App\Http\Controllers\FileUploadController::class, 'fileDelete']);
    Route::post('order_details/file_upload/{itemId}/{orderId}', [App\Http\Controllers\FileUploadController::class, 'fileUpload']);

	// Invoice
	Route::get('invoice', [App\Http\Controllers\InvoiceController::class, 'index'])->name('invoice');
	Route::get('invoice/search/{id}', [App\Http\Controllers\InvoiceController::class, 'search']);
    Route::get('orders/addInvoice/{id}', [App\Http\Controllers\InvoiceController::class, 'addInvoice']);
    Route::get('invoice/info/{id}', [App\Http\Controllers\InvoiceController::class, 'info']);
    Route::get('invoice/delete/{id}', [App\Http\Controllers\InvoiceController::class, 'delete']);

    // Team Store

    Route::get('team_store1', [App\Http\Controllers\TeamStoreController::class, 'index'])->name('team_store');
    Route::post('team_store1/create', [App\Http\Controllers\TeamStoreController::class, 'create'])->name('team_store.create');
    Route::post('team_store1/GenerateOrderItem', [App\Http\Controllers\TeamStoreController::class, 'GenerateOrderItem'])->name('team_store.GenerateOrderItem');
    Route::post('team_store1/DeleteOrder', [App\Http\Controllers\TeamStoreController::class, 'team_storeDeleteOrder'])->name('team_store.DeleteOrder');
    Route::post('team_store1/TotalCalPart', [App\Http\Controllers\TeamStoreController::class, 'TotalCalPart'])->name('team_store.TotalCalPart');
    Route::get('/job-status', [App\Http\Controllers\TeamStoreController::class, 'check_status'])->name('team_store.check_status');
    Route::get('team_store1/get_team_store_report/{id}', [App\Http\Controllers\TeamStoreController::class, 'getTeamStoreReport']);
    Route::get('missing-products', [App\Http\Controllers\TeamStoreController::class, 'missing_products'])->name('missing.products');
    Route::post('missing-products-update', [App\Http\Controllers\TeamStoreController::class, 'missing_products_update'])->name('missing.products_update');

// Contacts
	// People
	Route::get('people', [App\Http\Controllers\PeopleController::class, 'index'])->name('people');
	Route::get('people/get_organization_list', [App\Http\Controllers\PeopleController::class, 'getOrganizationList'])->name('people.get_organization_list');
	Route::get('people/add', [App\Http\Controllers\PeopleController::class, 'peopleAdd'])->name('people.add');
	Route::post('people/create', [App\Http\Controllers\PeopleController::class, 'create'])->name('people.create');
	Route::post('people/create_json', [App\Http\Controllers\PeopleController::class, 'createJson'])->name('people.create_json');
	Route::post('people/create_contanct_without_org', [App\Http\Controllers\PeopleController::class, 'createContactWithoutOrganizationRel'])->name('people.create_contanct_without_org');
    Route::get('people/info/{id}', [App\Http\Controllers\PeopleController::class, 'info'])->name('people.info');
	Route::get('people/export_csv', [App\Http\Controllers\PeopleController::class, 'exportCsv'])->name('people.export_csv');
	Route::get('people/search', [App\Http\Controllers\PeopleController::class, 'search'])->name('people.search');
	Route::get('people/by_alphabet/{id}', [App\Http\Controllers\PeopleController::class, 'sortApphabet'])->name('people.by_alphabet');
	Route::get('people/edit/{peopleId}', [App\Http\Controllers\PeopleController::class, 'edit']);
	Route::post('people/update', [App\Http\Controllers\PeopleController::class, 'update'])->name('people.update');
	Route::get('people/delete/{peopleId}', [App\Http\Controllers\PeopleController::class, 'delete'])->name('people.delete');
	Route::post('people/layout', [App\Http\Controllers\PeopleController::class, 'layout'])->name('people.layout');
    Route::post('people/checkemailexists', [App\Http\Controllers\PeopleController::class, 'checkEmailExists'])->name('people.checkmail');
    Route::post('people/update/address', [App\Http\Controllers\PeopleController::class, 'SavePeopleAddress'])->name('people.SavePeopleAddress');

	// Organizations

	Route::get('organizations/{type?}', [App\Http\Controllers\OrganizationController::class, 'index'])->name('organizations');
	Route::get('OrganizationExport', [App\Http\Controllers\OrganizationController::class, 'OrganizationExport'])->name('organizations.OrganizationExport');
	Route::get('organizations/get_people_list', [App\Http\Controllers\OrganizationController::class, 'getPeopleList'])->name('organizations.get_people_list');
	Route::post('organizations/edit_contacts', [App\Http\Controllers\OrganizationController::class, 'editContacts'])->name('organizations.edit_contacts');
	Route::get('organizations/add', [App\Http\Controllers\OrganizationController::class, 'organizationsAdd'])->name('organizations.add');
	Route::post('organizations/create', [App\Http\Controllers\OrganizationController::class, 'create'])->name('organizations.create');
    Route::post('organizations/create_json', [App\Http\Controllers\OrganizationController::class, 'createJson'])->name('organizations.create_json');
    Route::get('organizations/info/{id}', [App\Http\Controllers\OrganizationController::class, 'info'])->name('organizations.info');
    Route::post('organizations/{id}/sample-shipment', [App\Http\Controllers\OrganizationController::class, 'saveSampleShipment'])->name('organizations.sample_shipment.save');
    Route::post('organizations/{id}/sample-shipment/deliver', [App\Http\Controllers\OrganizationController::class, 'markSampleShipmentDelivered'])->name('organizations.sample_shipment.deliver');
    Route::post('organizations/{id}/sample-shipment/upload-image', [App\Http\Controllers\OrganizationController::class, 'uploadSampleShipmentImage'])->name('organizations.sample_shipment.upload_image');
	Route::get('organizations/sort_by_alphabet/{id}', [App\Http\Controllers\OrganizationController::class, 'sortByAlphabet']);
	Route::get('organizations/edit/{organizationId}', [App\Http\Controllers\OrganizationController::class, 'edit']);
	Route::post('organizations/update', [App\Http\Controllers\OrganizationController::class, 'update'])->name('organizations.update');
	Route::get('organizations/delete/{organizationId}', [App\Http\Controllers\OrganizationController::class, 'delete'])->name('organizations.delete');
	Route::get('organizations/export/export_csv', [App\Http\Controllers\OrganizationController::class, 'exportCsv'])->name('organizations.export_csv');
	Route::post('organizations/layout', [App\Http\Controllers\OrganizationController::class, 'layout'])->name('organizations.layout');

    Route::get('organizations/address/{organizationId}', [App\Http\Controllers\OrganizationController::class, 'address'])->name('organizations.address');
    Route::get('organizations/is_done/{id}/{status}', [App\Http\Controllers\OrganizationController::class, 'isDone'])->name('organizations.is_done');
    Route::post('organizations/Get_Payments_info', [App\Http\Controllers\OrganizationController::class, 'Get_Payments_info'])->name('Organization.get_payment_table_data');
    Route::post('organizations/Get_Payments_staements', [App\Http\Controllers\OrganizationController::class, 'Get_Payments_statement'])->name('Organization.get_statement_table_data');
    Route::post('organizations/order/payments', [App\Http\Controllers\OrganizationController::class, 'get_order_payments'])->name('order.get_payment_info');
    Route::get('organizations/order/view_invoice', [App\Http\Controllers\OrganizationController::class, 'get_order_invoice'])->name('order.get_order_invoice');
    Route::get('export_Payments_staements', [App\Http\Controllers\OrganizationController::class, 'exportAccountStatment'])->name('organizations.exportAccountStatment');
    Route::get('export_Payments_statements_pdf', [App\Http\Controllers\OrganizationController::class, 'exportAccountStatmentPDF'])->name('organizations.exportAccountStatmentPDF');
    // Route::get('fill/summary_at_payment_data', [App\Http\Controllers\OrganizationController::class, 'fill_Payments_statement_data']);

    Route::get('fill/migrateOrganizationSampleShipments', [App\Http\Controllers\OrganizationController::class, 'migrateOldSampleShipments'])->name('organizations.samples.migrate_old');
    Route::get('fill/unpaid_invoice_record', [App\Http\Controllers\OrganizationController::class, 'unpaid_invoice_record']);
    // Route::get('fill/updateBulkPayments', [App\Http\Controllers\OrganizationController::class, 'updateBulkPayments']);
    Route::get('fill/updateTSRPayments', [App\Http\Controllers\OrganizationController::class, 'updateTSRPayments']);
    // Route::get('fill/updateDebitEntry', [App\Http\Controllers\OrganizationController::class, 'updateDebitEntry']);
    Route::get('fill/getOutstandingInvoiceDates', [App\Http\Controllers\OrganizationController::class, 'getOutstandingInvoiceDates']);

    // Route::get('fill/fix_data', [App\Http\Controllers\OrganizationController::class, 'summarizeBulkOtherPayments']);
    // Route::get('fill/fix_data/org_id_fill', [App\Http\Controllers\OrganizationController::class, 'fill_orgId']);

    Route::post('statement/show_column', [App\Http\Controllers\OrganizationController::class, 'statementshowColumn'])->name('statement.show_column');
    Route::post('statement/hide_column', [App\Http\Controllers\OrganizationController::class, 'statementhideColumn'])->name('statement.hide_column');



//stores

    Route::get('stores', [App\Http\Controllers\StoreController::class, 'index'])->name('stores');
    Route::post('stores/get_all_stores', [App\Http\Controllers\StoreController::class, 'get_all_stores'])->name('stores.get_all_stores');
    Route::post('stores/get_all_urls', [App\Http\Controllers\StoreController::class, 'get_all_urls'])->name('stores.get_all_urls');
    Route::get('store/create_store', [App\Http\Controllers\StoreController::class, 'create_store'])->name('create_store');
    Route::post('store/create', [App\Http\Controllers\StoreController::class, 'create'])->name('store.create');
    Route::post('store/delete', [App\Http\Controllers\StoreController::class, 'delete'])->name('store.delete_store');
    Route::get('store/edit/{id}', [App\Http\Controllers\StoreController::class, 'edit'])->name('store.edit');
    Route::get('store/copy/{id}', [App\Http\Controllers\StoreController::class, 'copy'])->name('store.copy');
    Route::post('store/save_as_template', [App\Http\Controllers\StoreController::class, 'save_as_template'])->name('store.save_as_template');
    Route::post('store/archive_store', [App\Http\Controllers\StoreController::class, 'archive_store'])->name('store.archive_store');
    Route::post('store/unarchive_store', [App\Http\Controllers\StoreController::class, 'unarchive_store'])->name('store.unarchive_store');
    Route::post('store/close_store', [App\Http\Controllers\StoreController::class, 'close_store'])->name('store.close_store');
    Route::post('store/emailToCucstomer', [App\Http\Controllers\StoreController::class, 'emailToCucstomer'])->name('store.emailToCucstomer');
    Route::get('store/getEmailTemplates', [App\Http\Controllers\StoreController::class, 'getEmailTemplates'])->name('store.getEmailTemplates');
    Route::post('store/saveEmailTemplate', [App\Http\Controllers\StoreController::class, 'saveEmailTemplate'])->name('store.saveEmailTemplate');
    Route::post('store/createTSR', [App\Http\Controllers\StoreController::class, 'createTSR'])->name('store.createTSR');
    Route::post('store/updateTSR', [App\Http\Controllers\StoreController::class, 'updateTSR'])->name('store.updateTSR');
    Route::get('store/update_store_payment_record', [App\Http\Controllers\StoreController::class, 'updateStoreRecords'])->name('store.update_store_payment_record');

    Route::post('store/save_shipping_details', [App\Http\Controllers\StoreController::class, 'save_shipping_details'])->name('store.save_shipping_details');
    Route::get('store/download_order_receipt_all', [App\Http\Controllers\StoreController::class, 'download_order_receipt_all'])->name('store.download_order_receipt_all');

    Route::get('store/overview/{id}', [App\Http\Controllers\StoreController::class, 'overview'])->name('store.overview');
    Route::get('store/email_customer/{id}', [App\Http\Controllers\StoreController::class, 'email_customer'])->name('store.email_customer');
    Route::get('store/flyer/{id}', [App\Http\Controllers\StoreController::class, 'flyer'])->name('store.flyer');
    Route::get('store/manage_group/{id}', [App\Http\Controllers\StoreController::class, 'manage_group'])->name('store.manage_group');
    Route::get('store/manage_orders/{id}', [App\Http\Controllers\StoreController::class, 'manage_orders'])->name('store.manage_orders');
    Route::get('store/product_report/{id}', [App\Http\Controllers\StoreController::class, 'product_report'])->name('store.product_report');
    Route::get('store/player_report/{id}', [App\Http\Controllers\StoreController::class, 'player_report'])->name('store.player_report');
    Route::get('store/packing_slip/{id}', [App\Http\Controllers\StoreController::class, 'packing_slip'])->name('store.packing_slip');
    Route::get('store/store_shipping/{id}', [App\Http\Controllers\StoreController::class, 'store_shipping'])->name('store.store_shipping');
    Route::get('store/name_not_for_printing/{id}', [App\Http\Controllers\StoreController::class, 'name_not_for_printing'])->name('store.name_not_for_printing');
    Route::post('store/save_name_not_for_printing', [App\Http\Controllers\StoreController::class, 'save_name_not_for_printing'])->name('store.save_name_not_for_printing');
    Route::get('store/accounting_report/{id}', [App\Http\Controllers\StoreController::class, 'accounting_report'])->name('store.accounting_report');
    Route::get('store/fundraising_report/{id}', [App\Http\Controllers\StoreController::class, 'fundraising_report'])->name('store.fundraising_report');
    Route::get('store/receipts/{id}', [App\Http\Controllers\StoreController::class, 'receipts'])->name('store.receipts');
    Route::get('store/generateStoreCSV/{id}', [App\Http\Controllers\StoreController::class, 'generateStoreCSV'])->name('store.generatePlayerCSV');
    Route::get('store/generateStorePlayerReportCSV', [App\Http\Controllers\StoreController::class, 'generateStorePlayerReportCSV'])->name('store.generateStorePlayerReportCSV');
    Route::get('/store/player-report/download-csv/{store}', [App\Http\Controllers\StoreController::class, 'downloadPlayerCSV'])->name('store.player_report.download_csv');
    Route::post('/store/player-report/upload-csv', [App\Http\Controllers\StoreController::class, 'uploadPlayerCSV'])->name('store.player_report.upload_csv');
    Route::post('store/save_new_order', [App\Http\Controllers\StoreController::class, 'save_new_order'])->name('store.save_new_order');
    Route::post('store/export_shippo_csv', [App\Http\Controllers\StoreController::class, 'export_shippo_csv'])->name('store.export_shippo_csv');
    Route::get('store/get_order_no', [App\Http\Controllers\StoreController::class, 'get_order_no'])->name('store.product_report.get_order_no');
    Route::get('/orders/global-search', [App\Http\Controllers\StoreController::class, 'globalSearch'])->name('store_orders.global.search');

    Route::get('store/get_store_orders', [App\Http\Controllers\StoreController::class, 'get_store_orders'])->name('store.get_store_orders');
    Route::get('store/get_store_payments', [App\Http\Controllers\StoreController::class, 'get_store_payments'])->name('store.get_store_payments');
    Route::get('store/get_filtered_store_orders', [App\Http\Controllers\StoreController::class, 'get_filtered_store_orders'])->name('store.get_filtered_store_orders');
    Route::get('store/get_store_orders_for_packing_slip', [App\Http\Controllers\StoreController::class, 'get_store_orders_for_packing_slip'])->name('store.get_store_orders_for_packing_slip');

    Route::get('store/individual_player/{id}', [App\Http\Controllers\StoreController::class, 'individual_player'])->name('store.individual_player');
    Route::post('store/refund_exess', [App\Http\Controllers\TeamStorePaymentController::class, 'refundTransaction'])->name('store.refund_exess');
    // Route::get('store/individual_item/{id}', [App\Http\Controllers\StoreController::class, 'individual_item'])->name('store.individual_item');
    Route::get('store/product-report-download', [App\Http\Controllers\StoreController::class, 'downloadProductReport'])->name('store.product_report.download');
    Route::get('store/product-report-pdf', [App\Http\Controllers\StoreController::class, 'downloadProductReportPDF'])->name('store.product_report.pdf');
    Route::post('store/save-shipping-details-ajax', [App\Http\Controllers\TeamStorePaymentController::class, 'save_shipping_details_ajax'])->name('store.save_shipping_details_ajax');

    Route::get('update_store_order_no', [App\Http\Controllers\StoreController::class, 'update_store_order_no'])->name('store.update_store_order_no');

    Route::post('store/save_store_flyer', [App\Http\Controllers\StoreController::class, 'save_store_flyer'])->name('store.save_store_flyer');
    Route::post('store/add_user_group_access', [App\Http\Controllers\StoreController::class, 'add_user_group_access'])->name('store.add_user_group_access');
    Route::post('store/remove_user_group_access', [App\Http\Controllers\StoreController::class, 'remove_user_group_access'])->name('store.remove_user_group_access');

    Route::get('store/messaging', [App\Http\Controllers\StoreController::class, 'messaging'])->name('store.messaging');
    Route::get('store/taxes_and_fees', [App\Http\Controllers\StoreController::class, 'taxes_and_fees'])->name('store.taxes_and_fees');

    Route::get('store/get_store_products', [App\Http\Controllers\StoreController::class, 'get_store_products'])->name('store.get_store_products');
    Route::get('store/get_store_search_products', [App\Http\Controllers\StoreController::class, 'get_store_search_products'])->name('store.get_store_search_products');
    Route::get('store/get_store_sub_products', [App\Http\Controllers\StoreController::class, 'get_store_sub_products'])->name('store.get_store_sub_products');
    Route::post('store/save_store_products', [App\Http\Controllers\StoreController::class, 'save_store_products'])->name('store.save_store_products');
    Route::post('store/upload_product_images', [App\Http\Controllers\StoreController::class, 'upload_product_images'])->name('store.upload_product_images');
    Route::post('store/save_store_products_all', [App\Http\Controllers\StoreController::class, 'save_store_products_all'])->name('store.save_store_products_all');
    Route::get('store/get_store_product_by_id', [App\Http\Controllers\StoreController::class, 'get_store_product_by_id'])->name('store.get_store_product_by_id');
    Route::get('store/get_store_product_images', [App\Http\Controllers\StoreController::class, 'get_store_product_images'])->name('store.get_store_product_images');
    Route::get('store/get_store_coupons', [App\Http\Controllers\StoreController::class, 'get_store_coupons'])->name('store.get_store_coupons');
    Route::get('store/get_store_taxes', [App\Http\Controllers\StoreController::class, 'get_store_taxes'])->name('store.get_store_taxes');
    Route::get('store/get_store_custom_informations', [App\Http\Controllers\StoreController::class, 'get_store_custom_informations'])->name('store.get_store_custom_informations');
    Route::get('store/get_sizes', [App\Http\Controllers\StoreController::class, 'get_sizes'])->name('store.get_sizes');
    Route::post('store/update_extra_size_name', [App\Http\Controllers\StoreController::class, 'update_extra_size_name'])->name('store.update_extra_size_name');
    Route::get('store/get_product_categories', [App\Http\Controllers\StoreController::class, 'get_product_categories'])->name('store.get_product_categories');
    Route::post('store/update_store_category_order', [App\Http\Controllers\StoreController::class, 'update_store_category_order'])->name('store.update_store_category_order');
    Route::get('store/get_product_variants', [App\Http\Controllers\StoreController::class, 'get_product_variants'])->name('store.get_product_variants');
    Route::get('store/get_store_product_price_additions', [App\Http\Controllers\StoreController::class, 'get_store_product_price_additions'])->name('store.get_store_product_price_additions');
    Route::get('store/product_price_addition', [App\Http\Controllers\StoreController::class, 'product_price_addition'])->name('store.product_price_addition');
    Route::post('store/save_price_addition', [App\Http\Controllers\StoreController::class, 'save_price_addition'])->name('store.save_price_addition');
    Route::post('store/save_bulk_price_addition', [App\Http\Controllers\StoreController::class, 'save_bulk_price_addition'])->name('store.save_bulk_price_addition');
    Route::post('store/delete_price_addition', [App\Http\Controllers\StoreController::class, 'delete_price_addition'])->name('store.delete_price_addition');
    Route::post('store/delete_store_product', [App\Http\Controllers\StoreController::class, 'delete_store_product'])->name('store.delete_store_product');
    Route::post('store/clone_store_product', [App\Http\Controllers\StoreController::class, 'clone_store_product'])->name('store.clone_store_product');
    Route::post('store/bulk_delete_store_product', [App\Http\Controllers\StoreController::class, 'bulk_delete_store_product'])->name('store.bulk_delete_store_product');
    Route::post('store/bulk_clone_store_product', [App\Http\Controllers\StoreController::class, 'bulk_clone_store_product'])->name('store.bulk_clone_store_product');
    Route::post('store/bulk_change_category_action', [App\Http\Controllers\StoreController::class, 'bulk_change_category_action'])->name('store.bulk_change_category_action');
    Route::post('store/bulk_active_product', [App\Http\Controllers\StoreController::class, 'bulk_active_product'])->name('store.bulk_active_product');
    Route::post('store/update_product_order', [App\Http\Controllers\StoreController::class, 'update_product_order'])->name('store.update_product_order');
    Route::post('store/remove_bundle', [App\Http\Controllers\StoreController::class, 'remove_bundle'])->name('store.remove_bundle');
    Route::post('store/make_bundle', [App\Http\Controllers\StoreController::class, 'make_bundle'])->name('store.make_bundle');
    Route::post('store/required_bundle', [App\Http\Controllers\StoreController::class, 'required_bundle'])->name('store.required_bundle');
    Route::post('store/not_required_bundle', [App\Http\Controllers\StoreController::class, 'not_required_bundle'])->name('store.not_required_bundle');
    Route::get('store/get_product_embellishment_options', [App\Http\Controllers\StoreController::class, 'get_product_embellishment_options'])->name('store.get_product_embellishment_options');
    Route::post('store/save_custom_information_template', [App\Http\Controllers\StoreController::class, 'save_custom_information_template'])->name('store.save_custom_information_template');
    Route::post('store/load_custom_information_template', [App\Http\Controllers\StoreController::class, 'load_custom_information_template'])->name('store.load_custom_information_template');


    Route::post('store/add_coupon', [App\Http\Controllers\StoreController::class, 'add_coupon'])->name('store.add_coupon');
    Route::post('store/remove_coupon', [App\Http\Controllers\StoreController::class, 'remove_coupon'])->name('store.remove_coupon');
    Route::post('store/delete_coupon', [App\Http\Controllers\StoreController::class, 'delete_coupon'])->name('store.delete_coupon');
    Route::post('store/add_tax', [App\Http\Controllers\StoreController::class, 'add_tax'])->name('store.add_tax');
    Route::post('store/remove_tax', [App\Http\Controllers\StoreController::class, 'remove_tax'])->name('store.remove_tax');
    Route::post('store/add_variant', [App\Http\Controllers\StoreController::class, 'add_variant'])->name('store.add_variant');
    Route::post('store/remove_variant', [App\Http\Controllers\StoreController::class, 'remove_variant'])->name('store.remove_variant');
    Route::post('store/add_custom_information', [App\Http\Controllers\StoreController::class, 'add_custom_information'])->name('store.add_custom_information');
    Route::post('store/delete_custom_information', [App\Http\Controllers\StoreController::class, 'delete_custom_information'])->name('store.delete_custom_information');
    Route::post('store/remove_custom_information', [App\Http\Controllers\StoreController::class, 'remove_custom_information'])->name('store.remove_custom_information');
    Route::post('store/add_new_custom_information', [App\Http\Controllers\StoreController::class, 'add_new_custom_information'])->name('store.add_new_custom_information');
    Route::post('store/add_new_product_category', [App\Http\Controllers\StoreController::class, 'add_new_product_category'])->name('store.add_new_product_category');
    Route::post('store/delete_product_category', [App\Http\Controllers\StoreController::class, 'delete_product_category'])->name('store.delete_product_category');
    Route::post('store/product_category_onchange', [App\Http\Controllers\StoreController::class, 'product_category_onchange'])->name('store.product_category_onchange');
    Route::post('store/dragging_product', [App\Http\Controllers\StoreController::class, 'dragging_product'])->name('store.dragging_product');
    Route::post('store/add_new_product_variant', [App\Http\Controllers\StoreController::class, 'add_new_product_variant'])->name('store.add_new_product_variant');
    Route::post('store/edit_product_image', [App\Http\Controllers\StoreController::class, 'edit_product_image'])->name('store.edit_product_image');
    Route::post('store/copy_product_image', [App\Http\Controllers\StoreController::class, 'copy_product_image'])->name('store.copy_product_image');
    Route::post('store/delete_product_image', [App\Http\Controllers\StoreController::class, 'delete_product_image'])->name('store.delete_product_image');
    Route::post('store/add_new_coupon', [App\Http\Controllers\StoreController::class, 'add_new_coupon'])->name('store.add_new_coupon');

    Route::post('store/updateStoreStatusEmailSettings', [App\Http\Controllers\StoreController::class, 'updateStoreStatusEmailSettings'])->name('store.updateStoreStatusEmailSettings');

    Route::post('store/update_store_theme', [App\Http\Controllers\StoreController::class, 'update_store_theme'])->name('store.update_store_theme');
    Route::get('store/get_theme_settings', [App\Http\Controllers\StoreController::class, 'get_theme_settings'])->name('store.get_theme_settings');

    Route::get('store/test_store_notifications', [App\Http\Controllers\StoreController::class, 'testStoreNotification'])->name('store.test_store_notifications');
    Route::get('store/showCartItems', [App\Http\Controllers\CustomerTeamStoreController::class, 'showCartItems'])->name('store.showCartItems');

    Route::get('shippo/create_shipment/{order_no}', [App\Http\Controllers\ShippoController::class, 'createShipment'])->name('shippo.create_shipment');
    Route::post('shippo/create_shipments', [App\Http\Controllers\ShippoController::class, 'createShipmentsBulk'])->name('shippo.create_shipments_bulk');
    Route::get('shippo/create_label/{order_no}', [App\Http\Controllers\ShippoController::class, 'create_label'])->name('shippo.create_label');
    Route::get('shippo/create_lable', [App\Http\Controllers\ShippoController::class, 'create_lable'])->name('shippo.create_lable');
    Route::get('shippo/download_packing_slips', [App\Http\Controllers\ShippoController::class, 'download_packing_slips'])->name('shippo.download_packing_slips');

    // USPS shipment creation
    Route::get('usps/create_shipment/{order_no}', [App\Http\Controllers\USPSController::class, 'createShipment'])->name('usps.create_shipment');

    Route::post('usps/create_shipments', [App\Http\Controllers\USPSController::class, 'createShipmentsBulk'])->name('usps.create_shipments_bulk');

    // USPS import
    Route::get('/admin/import-usps-labels', [App\Http\Controllers\USPSController::class, 'showImportForm'])->name('admin.usps-labels.import');

    Route::post('/admin/usps-labels/import', [App\Http\Controllers\USPSController::class, 'import'])->name('admin.usps-labels.import.store');

    // USPS label management
    // IMPORTANT: label purchase is POST only.
    Route::post('usps/create_lable', [App\Http\Controllers\USPSController::class, 'create_lable'])->name('usps.create_lable');

    Route::get('usps/labels/{id}/manager-data', [App\Http\Controllers\USPSController::class, 'labelManagerData'])->name('usps.label.manager-data');

    Route::post('usps/labels/{id}/save-draft', [App\Http\Controllers\USPSController::class, 'saveDraftLabel'])->name('usps.label.save-draft');

    Route::get('usps/labels/{id}/view', [App\Http\Controllers\USPSController::class, 'viewLabel'])->name('usps.label.view');

    Route::get('usps/labels/{id}/download', [App\Http\Controllers\USPSController::class, 'downloadLabel'])->name('usps.label.download');

    Route::get('usps/labels/{id}/print', [App\Http\Controllers\USPSController::class, 'printLabel'])->name('usps.label.print');

    Route::post('usps/labels/{id}/edit', [App\Http\Controllers\USPSController::class, 'editPurchasedLabel'])->name('usps.label.edit');

    Route::post('usps/labels/{id}/reprint', [App\Http\Controllers\USPSController::class, 'reprintLabel'])->name('usps.label.reprint');

    Route::post('usps/labels/{id}/cancel-refund', [App\Http\Controllers\USPSController::class, 'cancelOrRefundLabel'])->name('usps.label.cancel-refund');

    Route::post('usps/labels/{id}/replace', [App\Http\Controllers\USPSController::class, 'prepareReplacementLabel'])->name('usps.label.replace');

    Route::post('usps/labels/bulk-create', [App\Http\Controllers\USPSController::class, 'bulkCreateLabels'])->name('usps.label.bulk-create');

    Route::post('usps/labels/bulk-download', [App\Http\Controllers\USPSController::class, 'bulkDownloadLabels'])->name('usps.label.bulk-download');

    Route::post('usps/labels/bulk-print', [App\Http\Controllers\USPSController::class, 'bulkPrintLabels'])->name('usps.label.bulk-print');

    Route::get('usps/labels/{id}/manage', [App\Http\Controllers\USPSController::class,'labelManagerPage'])->name('usps.label.manage');

    Route::get('usps/labels/manage-selected', [App\Http\Controllers\USPSController::class,'bulkLabelManagerPage'])->name('usps.label.bulk-manage');

    Route::post('usps/labels/{id}/quote', [App\Http\Controllers\USPSController::class,'quoteLabelPostage'])->name('usps.label.quote');

//email templates
    Route::get('email/templates', [App\Http\Controllers\EmailTemplateController::class, 'index'])->name('email.templates');
    Route::post('email/templates/store', [App\Http\Controllers\EmailTemplateController::class, 'store'])->name('email.templates.store');
    Route::get('email/templates/edit/{id}', [App\Http\Controllers\EmailTemplateController::class, 'edit'])->name('email.templates.edit');
    Route::get('email/templates/pick/{id}', [App\Http\Controllers\EmailTemplateController::class, 'pick'])->name('email.templates.pick');
    Route::post('email/templates/update', [App\Http\Controllers\EmailTemplateController::class, 'update'])->name('email.templates.update');
    Route::get('email/templates/add/{id}', [App\Http\Controllers\EmailTemplateController::class, 'add'])->name('email.templates.add');
    Route::post('email/templates/add-email-template-by-notifi', [App\Http\Controllers\EmailTemplateController::class, 'addEmailTemplate'])->name('add.email.templates.notifi');
    Route::get('email/templates/remove/{id}', [App\Http\Controllers\EmailTemplateController::class, 'remove'])->name('email.templates.remove');
    Route::get('email/my/templates/remove/{id}', [App\Http\Controllers\EmailTemplateController::class, 'destroy'])->name('email.templates.destroy');
    Route::get('email/templates/getAllTableData', [App\Http\Controllers\EmailTemplateController::class, 'getAllTableData'])->name('email.templates.getAllTableData');
    Route::post('email/templates/getSearchTableData', [App\Http\Controllers\EmailTemplateController::class, 'getSearchTableData'])->name('email.templates.getSearchTableData');
    Route::post('email/templates/do_with_selected', [App\Http\Controllers\EmailTemplateController::class, 'do_with_selected'])->name('email.templates.do_with_selected');
    Route::get('email/get_next_activity', [App\Http\Controllers\EmailController::class, 'get_next_activity'])->name('email.destget_next_activityroy');
    // Route::get('email/update_html_to_quill', [App\Http\Controllers\EmailController::class, 'update_html_to_quill'])->name('email.update_html_to_quill');
//Hr Module
    Route::get('/Employee/Managment', [App\Http\Controllers\HRController::class, 'Employee_Managment'])->name('HR.Employee_Managment');
    Route::get('/Attendance/Managment', [App\Http\Controllers\HRController::class, 'Attendance_Managment'])->name('HR.Attendance_Managment');
    Route::get('/Recruitment/Onboard', [App\Http\Controllers\HRController::class, 'Leave_managment'])->name('HR.Leave_managment');
    // Route::get('/Leave_Manage/leave-groups', [App\Http\Controllers\HRController::class, 'Leave_groups'])->name('HR.Leave_groups');
    Route::get('/Leave_Manage/leave-types', [App\Http\Controllers\HRController::class, 'Leave_types'])->name('HR.Leave_types');
    // Route::get('/Leave_Manage/leave-type', [App\Http\Controllers\HRController::class, 'Leave_type'])->name('HR.Leave_type');
    Route::get('/get/employee/data', [App\Http\Controllers\HRController::class, 'employee_summary_table_data'])->name('HR.employee_summary_table_data');
    Route::get('/view/employee/{id}', [App\Http\Controllers\HRController::class, 'employee_view'])->name('HR.employee_view');
    Route::get('/view/employee/profile/{id}', [App\Http\Controllers\HRController::class, 'employee_view_project'])->name('HR.employee_view_project');
    Route::get('/view/employee/edit/{id}', [App\Http\Controllers\HRController::class, 'employee_edit'])->name('HR.employee_edit');
    Route::post('employee/upload-files', [App\Http\Controllers\HRController::class, 'uploadFiles'])->name('HR.employee_fileUpload');
    // Route::get('/get-user-files/{id}', [App\Http\Controllers\HRController::class, 'getUserFiles'])->name('HR.employee_getFile'); // old route
    Route::get('/get-user-files/{userId}/{docType}', [App\Http\Controllers\HRController::class, 'getUserFiles'])->name('HR.employee_getFile');  // updated route with docType parameter
    Route::post('employee/delete-file', [App\Http\Controllers\HRController::class, 'deleteFile'])->name('HR.employee_fileDelete');
    Route::post('employee/get/groups', [App\Http\Controllers\HRController::class, 'get_groups'])->name('HR.get_groups');
    Route::get('view/user/account/{id}', [App\Http\Controllers\UserController::class,'impersonateUser'])->name('user_loggin.view');
    Route::get('/impersonate/revert', [App\Http\Controllers\UserController::class, 'revertImpersonation'])->name('impersonate.revert');
    Route::post('/update-user-status', [App\Http\Controllers\UserController::class, 'updateUserStatus'])->name('HR.updateUserStatus');
    Route::get('/hr-dashboard', [App\Http\Controllers\HRController::class, 'HR_dashboard'])->name('HR.Dashboard');
    Route::get('/systemadmin-dashboard', [App\Http\Controllers\HomeController::class, 'systemAdminDashboard'])->name('systemadmin.dashboard');
    Route::get('/leave-Manage/getLeaveBalance/{userId}', [App\Http\Controllers\HRController::class, 'getLeaveBalance'])->name('HR.getLeaveBalance');

    // Leave Type Routes
    Route::get('/Leave_Manage/leave-type', [App\Http\Controllers\HRController::class, 'Leave_types'])->name('HR.Leave_type');
    Route::post('/leave-Manage/mastertype/create', [App\Http\Controllers\LeaveTypeController::class, 'storeMasterLeaveType'])->name('masterleavetype.create');
    Route::put('/leave-Manage/mastertype/update', [App\Http\Controllers\LeaveTypeController::class, 'updateMasterLeaveType'])->name('masterleavetype.update');
    Route::delete('/leave-Manage/mastertype/delete/{id}', [App\Http\Controllers\LeaveTypeController::class, 'deleteMasterLeaveType'])->name('masterleavetype.delete');

    // Leave Group Routes
    Route::get('/Leave_Manage/leave-groups', [App\Http\Controllers\HRController::class, 'Leave_groups'])->name('HR.Leave_groups');
    Route::post('/leave-Manage/leavegroups/create', [App\Http\Controllers\LeaveGroupController::class, 'groupStore'])->name('leavegroup.create');
    Route::put('/leave-Manage/leavegroups/update', [App\Http\Controllers\LeaveGroupController::class, 'groupUpdate'])->name('leavegroup.update');
    Route::delete('/leave-Manage/leavegroups/delete/{id}', [App\Http\Controllers\LeaveGroupController::class, 'groupDelete'])->name('leavegroup.delete');
    Route::get('/admin-leave/get-employees', [App\Http\Controllers\HRAdminLeaveController::class, 'getEmployees']);
    Route::get('/admin-leave/get-user-leave-types', [App\Http\Controllers\HRAdminLeaveController::class, 'getUserLeaveTypes']);
    Route::post('/admin-leave/store',[App\Http\Controllers\HRAdminLeaveController::class, 'store']);

// Settings
    // Activity
    Route::get('activities', [App\Http\Controllers\ActivityController::class, 'index'])->name('activities');
    Route::get('activities/get_activities/{user_id}/{filter}/{from_date}/{to_date}', [App\Http\Controllers\ActivityController::class, 'getActivities']);
    Route::get('activities/get_all_data/{activity_id}', [App\Http\Controllers\ActivityController::class, 'getAllData']);
    Route::get('activities/get_organizations', [App\Http\Controllers\ActivityController::class, 'getOrganizations']);
    Route::get('activities/get_orders_people_by_organiation/{organization_id}', [App\Http\Controllers\ActivityController::class, 'getOrdersPeopleByOrganiation']);
    Route::get('activities/get_activity_by_id/{id}', [App\Http\Controllers\ActivityController::class, 'getActivityById']);
    Route::get('activities/get_activities_by_organization/{organization_id}', [App\Http\Controllers\ActivityController::class, 'getActivitiesByOrganization']);
    Route::get('activities/get_organization_email_body/{email_id}', [App\Http\Controllers\ActivityController::class, 'getOrganizationEmailBody']);
    Route::get('activities/get_activities_by_date/{user_id}/{due_date}', [App\Http\Controllers\ActivityController::class, 'getActivitiesByDate']);
    Route::get('activities/get_activities_by_due_date/{due_date}', [App\Http\Controllers\ActivityController::class, 'getActivitiesByDueDate']);
    Route::post('activities/create', [App\Http\Controllers\ActivityController::class, 'create'])->name('activities.create');
    Route::post('activities/create_on_email', [App\Http\Controllers\ActivityController::class, 'createOnEmail'])->name('activities.create_on_email');
    Route::post('activities/update', [App\Http\Controllers\ActivityController::class, 'update'])->name('activities.update');
    Route::get('activities/update_act_note/{userID}', [App\Http\Controllers\ActivityController::class, 'update_act_note']);
    Route::post('activities/mark_as_done', [App\Http\Controllers\ActivityController::class, 'markAsDone'])->name('activities.mark_as_done');
    Route::post('activities/mark_as_delete', [App\Http\Controllers\ActivityController::class, 'mark_as_delete'])->name('activities.mark_as_delete');
    Route::post('activities/bulk_options', [App\Http\Controllers\ActivityController::class, 'bulk_options'])->name('activities.bulk_options');
    Route::post('activities/mark_as_todo', [App\Http\Controllers\ActivityController::class, 'markAsTodo'])->name('activities.mark_as_todo');
    Route::post('activities/show_column', [App\Http\Controllers\ActivityController::class, 'showColumn'])->name('activities.show_column');
    Route::post('activities/hide_column', [App\Http\Controllers\ActivityController::class, 'hideColumn'])->name('activities.hide_column');
    Route::post('activities/column_layout', [App\Http\Controllers\ActivityController::class, 'columnLayout'])->name('activities.column_layout');
    Route::get('activities/filter_search_data', [App\Http\Controllers\ActivityController::class, 'filter_search_data'])->name('activities.filter_search_data');

    Route::get('activities/add', [App\Http\Controllers\ActivityController::class, 'add'])->name('activities.add');
    Route::get('activities/filter_by_order/{id}', [App\Http\Controllers\ActivityController::class, 'filterByOrder']);
    Route::get('activities/filter_by_organization/{id}', [App\Http\Controllers\ActivityController::class, 'filterByOrganization']);
	Route::get('activities/filter_by_contact/{id}', [App\Http\Controllers\ActivityController::class, 'filterByContact']);
	Route::get('activities/edit_by_organization/{activityId}/{organizationId}', [App\Http\Controllers\ActivityController::class, 'editByOrganization']);
	Route::get('activities/edit/{activityId}', [App\Http\Controllers\ActivityController::class, 'edit']);
	Route::post('activities/update', [App\Http\Controllers\ActivityController::class, 'update'])->name('activities.update');
	Route::get('activities/delete/{activityId}', [App\Http\Controllers\ActivityController::class, 'delete'])->name('activities.delete');
	Route::post('activities/done', [App\Http\Controllers\ActivityController::class, 'done'])->name('activities.done');
	Route::get('activity/by_alphabet/{id}', [App\Http\Controllers\ActivityController::class, 'sortApphabet'])->name('activity.by_alphabet');
    Route::get('activities/filter_reset', [App\Http\Controllers\ActivityController::class, 'filterReset']);
	Route::post('activities/get_by_date', [App\Http\Controllers\ActivityController::class, 'getByDate']);
    Route::get('activities/get_by_user/{userId}', [App\Http\Controllers\ActivityController::class, 'getByUser']);
    Route::post('activities/export_csv', [App\Http\Controllers\ActivityController::class, 'exportCsv'])->name('activities.export_csv');

    // Notifications
    // Route::get('notifications', [App\Http\Controllers\NotificationController::class, 'index'])->name('notifications');
    Route::get('notifications/unread_count', [App\Http\Controllers\NotificationController::class, 'unreadCount'])->name('notifications.unread_count');
    Route::get('activities/read_notification/{id}', [App\Http\Controllers\NotificationController::class, 'readNotification']);
    Route::get('notifications/get_details/{id}', [App\Http\Controllers\NotificationController::class, 'getDetails']);
    Route::post('activities/check_approve', [App\Http\Controllers\NotificationController::class, 'checkApprove'])->name('activities.check_approve');
    Route::get('notifications/delete/{id}', [App\Http\Controllers\NotificationController::class, 'delete']);
    Route::get('notifications/unread/{id}', [App\Http\Controllers\NotificationController::class, 'unread']);
    Route::get('urgent_order_reject', [App\Http\Controllers\NotificationController::class, 'reject'])->name('urgent_order_reject');
    Route::get('factory_order_reject', [App\Http\Controllers\NotificationController::class, 'factory_reject'])->name('factory_order_reject');
    Route::get('urgent_order_confirm', [App\Http\Controllers\NotificationController::class, 'confirm'])->name('urgent_order_confirm');
    Route::get('factory_order_confirm', [App\Http\Controllers\NotificationController::class, 'factory_confirm'])->name('factory_order_confirm');

    Route::post('notifications/mark_as_read', [App\Http\Controllers\NotificationController::class, 'markAsRead']);
    Route::post('notifications/mark_as_unread', [App\Http\Controllers\NotificationController::class, 'markAsUnRead']);


    // new-notifications
    Route::post('/notifications/mark-as-read', [App\Http\Controllers\NewNotificationController::class, 'markAsReadNotification'])->name('notifications.mark.read');
    Route::post('/notifications/mark-as-unread', [App\Http\Controllers\NewNotificationController::class, 'markAsUnreadNotification'])->name('notifications.mark.unread');
    Route::post('/notifications/{id}/toggle-star', [App\Http\Controllers\NewNotificationController::class, 'toggleStar'])->name('notifications.toggle.star');
    Route::get('get-notification-data/{id}', [App\Http\Controllers\NewNotificationController::class, 'getNotificationData'])->name('get.notification.data');

    // payment approve
    Route::post('payment/check_approve_ajax', [App\Http\Controllers\NewNotificationController::class, 'checkApproveAjax'])->name('payment.check_approve_ajax');
    Route::post('payment/venmo_approve_ajax', [App\Http\Controllers\NewNotificationController::class, 'venmoApproveAjax'])->name('payment.venmo_approve_ajax');
    Route::post('payment/paypal_approve_ajax', [App\Http\Controllers\NewNotificationController::class, 'paypalApproveAjax'])->name('payment.paypal_approve_ajax');

    Route::post('new-urgent_order_confirm', [App\Http\Controllers\NewNotificationController::class, 'new_urgent_confirm'])->name('new.urgent.order.confirm');
    Route::post('new-urgent_order_reject', [App\Http\Controllers\NewNotificationController::class, 'new_urgent_reject'])->name('new.urgent.order.reject');

    Route::post('new-factory_order_confirm', [App\Http\Controllers\NewNotificationController::class, 'new_factory_confirm'])->name('new.factory_order_confirm');
    Route::post('new-factory_order_reject', [App\Http\Controllers\NewNotificationController::class, 'new_factory_reject'])->name('new.factory_order_reject');

    Route::post('new-reject_or_confirm_order_directly', [App\Http\Controllers\NewNotificationController::class, 'reject_or_confirm_order_directly'])->name('new.reject_or_confirm_order_directly');
    Route::post('new-reject_or_confirm_factory_suggest', [App\Http\Controllers\NewNotificationController::class, 'reject_or_confirm_factory_suggest'])->name('new.reject_or_confirm_factory_suggest');


    Route::get('notifications', [App\Http\Controllers\NewNotificationController::class, 'index2'])->name('notifications');
    Route::get('get-all-notifications2', [App\Http\Controllers\NewNotificationController::class, 'getAllNotifications2'])->name('get.all.notifications2');
    Route::get('get-all-unread-notifications2', [App\Http\Controllers\NewNotificationController::class, 'getAllUnreadNotifications2'])->name('get.all.unread.notifications2');
    Route::get('get-all-mention-notifications2', [App\Http\Controllers\NewNotificationController::class, 'getAllMentionNotifications2'])->name('get.all.mention.notifications2');
    Route::get('get-all-marked-notifications2', [App\Http\Controllers\NewNotificationController::class, 'getAllMarkedNotifications2'])->name('get.all.marked.notifications2');
    Route::get('initial-count', [App\Http\Controllers\NewNotificationController::class, 'initialCount'])->name('get.initial.count');





    Route::get('notifications/settings', [App\Http\Controllers\NotificationController::class, 'settings_index'])->name('Notification.Settings');
    Route::post('notifications/new_template', [App\Http\Controllers\NotificationController::class, 'notification_templates_store'])->name('notification_templates.store');
    Route::post('notifications/template/change_status', [App\Http\Controllers\NotificationController::class, 'notification_templates_change_status'])->name('notification_templates.change_status');
    Route::post('notification_templates/update/{id}', [App\Http\Controllers\NotificationController::class, 'notification_templates_update'])->name('notification_templates.update');
    Route::get('notification_template/users/{id}', [App\Http\Controllers\NotificationController::class, 'get_notification_template_users'])->name('notification_templates.get_users');
    Route::post('notification_template/users/toggle', [App\Http\Controllers\NotificationController::class, 'toggleUser'])->name('notification_template.toggleUser');

    Route::get('notification_templates/edit/{id}', [App\Http\Controllers\NotificationController::class, 'notification_templates_edit'])->name('notification_templates.edit');
    Route::get('notifications/get_templates', [App\Http\Controllers\NotificationController::class, 'get_table_data'])->name('notification.get_table_data');
    //system configuration

    Route::get('configuration/dashboard', [App\Http\Controllers\ConfigurationController::class, 'get_dashboard_data'])->name('configuration.get_dashboard_data');
    Route::post('configuration/system/toggleMaintenance', [App\Http\Controllers\ConfigurationController::class, 'toggleMaintenance'])->name('configuration.toggleMaintenance');
    Route::get('configuration/database', [App\Http\Controllers\ConfigurationController::class, 'get_database_data'])->name('configuration.get_database_data');
    Route::post('configuration/database/password/change', [App\Http\Controllers\ConfigurationController::class, 'changeDatabaseWithPassword'])->name('configuration.database.password.change');
    Route::get('configuration/database/change/{id}', [App\Http\Controllers\ConfigurationController::class, 'change_database_data'])->name('configuration.change_database_data');
    Route::get('configuration/payment_gateway', [App\Http\Controllers\ConfigurationController::class, 'showPaymentMode'])->name('configuration.get_gateway_data');
    Route::post('configuration/payment_gateway/update', [App\Http\Controllers\ConfigurationController::class, 'updatePaymentMode'])->name('configuration.updatePaymentMode');
    Route::get('/storage-structure', [App\Http\Controllers\ConfigurationController::class, 'getFolderStructure'])->name('configuration.getFolderStructure');
    Route::get('/storage-file/open', [App\Http\Controllers\ConfigurationController::class, 'openStorageFile'])->name('configuration.openStorageFile');
    Route::get('notifications/email/settings', [App\Http\Controllers\NotificationController::class, 'email_settings_index'])->name('NotificationEmail.Settings');
    Route::get('notifications/email/get_templates', [App\Http\Controllers\NotificationController::class, 'email_get_table_data'])->name('NotificationEmail.get_table_data');
    Route::post('notifications/email/new_template', [App\Http\Controllers\NotificationController::class, 'notification_email_templates_store'])->name('NotificationEmail.store');
    Route::post('notifications/email/template/change_status', [App\Http\Controllers\NotificationController::class, 'notification_email_templates_change_status'])->name('notification_templatesEmail.change_status');
    Route::post('notification_template/email/users/toggle', [App\Http\Controllers\NotificationController::class, 'email_toggleUser'])->name('NotificationEmail.toggleUser');
    Route::get('notification_template/email/users/{id}', [App\Http\Controllers\NotificationController::class, 'get_email_notification_template_users'])->name('NotificationEmail.get_users');
    Route::get('notification_templates/email/edit/{id}', [App\Http\Controllers\NotificationController::class, 'email_notification_templates_edit'])->name('NotificationEmail.edit');
    Route::post('notification_templates/email/update/{id}', [App\Http\Controllers\NotificationController::class, 'email_notification_templates_update'])->name('NotificationEmail.update');

    Route::get(
    '/email-notifications/organizations/search',
    [App\Http\Controllers\NotificationController::class, 'searchOrganizations']
)->name('admin.email-notifications.organizations.search');

Route::get(
    '/email-notifications/organizations/{organization}/customers',
    [App\Http\Controllers\NotificationController::class, 'organizationCustomers']
)->name('admin.email-notifications.organization-customers');

	// Ex-Factory
	Route::post('ex_factory/create', [App\Http\Controllers\ExFactoryController::class, 'create'])->name('ex_factory.create');
	Route::post('item/ex_factory/create', [App\Http\Controllers\ExFactoryController::class, 'createInItempage'])->name('itemex_factory.create');
	Route::get('ex_factory/get_all_addresses', [App\Http\Controllers\ExFactoryController::class, 'getAllAddresses'])->name('ex_factory.get_all_addresses');
	Route::get('ex_factory/get_address/{itemId}/{exFactoryId}', [App\Http\Controllers\ExFactoryController::class, 'getAddress']);

// Masters
	//Fabrics
	Route::get('fabrics', [App\Http\Controllers\FabricController::class, 'index'])->name('fabrics');
    // Route::get('fabrics/add', [App\Http\Controllers\FabricController::class, 'add'])->name('fabrics.add');
	Route::post('fabrics/create', [App\Http\Controllers\FabricController::class, 'create'])->name('fabrics.create');
	Route::get('fabrics/delete/{id}', [App\Http\Controllers\FabricController::class, 'delete']);
	Route::get('fabrics/active/{id}', [App\Http\Controllers\FabricController::class, 'active']);
	Route::get('fabrics/edit/{id}', [App\Http\Controllers\FabricController::class, 'edit']);
    Route::post('fabrics/update', [App\Http\Controllers\FabricController::class, 'update'])->name('fabrics.update');
    Route::get('sort_fabric/by_alphabet/{id}', [App\Http\Controllers\FabricController::class, 'sortApphabet']);
    Route::post('fabrics/layout', [App\Http\Controllers\FabricController::class, 'layout'])->name('fabrics.layout');

    //Lead Sources

    Route::get('lead_sources', [App\Http\Controllers\LeadSourceController::class, 'index'])->name('lead_sources');
	Route::post('lead_sources/create', [App\Http\Controllers\LeadSourceController::class, 'create'])->name('lead_sources.create');
	Route::get('lead_sources/delete/{id}', [App\Http\Controllers\LeadSourceController::class, 'delete'])->name('lead_sources.delete');
	Route::get('lead_sources/edit/{id}', [App\Http\Controllers\LeadSourceController::class, 'edit']);
    Route::post('lead_sources/update', [App\Http\Controllers\LeadSourceController::class, 'update'])->name('lead_sources.update');
    Route::get('lead_sources/update_organization_source', [App\Http\Controllers\LeadSourceController::class, 'update_organization_source'])->name('lead_sources.update_organization_source');
    Route::post('lead_sources/update_organization', [App\Http\Controllers\LeadSourceController::class, 'update_organization'])->name('lead_sources.update_organization');

	// Products
	Route::get('products', [App\Http\Controllers\ProductController::class, 'index'])->name('products');
	Route::post('products/create', [App\Http\Controllers\ProductController::class, 'create'])->name('products.create');
	Route::get('products/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete']);
	Route::get('products/active/{id}', [App\Http\Controllers\ProductController::class, 'active']);
	Route::get('products/edit/{id}', [App\Http\Controllers\ProductController::class, 'edit'])->name('products.edit');
	Route::get('products/delete/{id}', [App\Http\Controllers\ProductController::class, 'delete'])->name('products.delete');
	Route::post('products/update', [App\Http\Controllers\ProductController::class, 'update'])->name('products.update');
	Route::get('products/by_alphabet/{id}', [App\Http\Controllers\ProductController::class, 'sortApphabet']);
	// Route::get('products/add', [App\Http\Controllers\ProductController::class, 'productAdd'])->name('products.add');
	Route::post('products/layout', [App\Http\Controllers\ProductController::class, 'layout'])->name('products.layout');
	Route::get('products/setStatus/{id}/{status}', [App\Http\Controllers\ProductController::class, 'setStatus']);
	Route::get('products/main_product/{id}', [App\Http\Controllers\ProductController::class, 'edit_product'])->name('edit_product');
	Route::post('products/create_product', [App\Http\Controllers\ProductController::class, 'create_product'])->name('create_product');
    Route::post('products/create_product_temp', [App\Http\Controllers\ProductController::class, 'create_product_temp'])->name('create_product_temp');
    Route::post('products/produt_move/{id}', [App\Http\Controllers\ProductController::class, 'product_move'])->name('product_move');
    Route::get('products/process/{currentId}/{newId}/{level}', [App\Http\Controllers\ProductController::class, 'product_process'])->name('product_process');
    Route::view('loading-product','pages.redirect.loading')->name('loading_page');

    Route::post('products/remove_images', [App\Http\Controllers\ProductController::class, 'removeImages'])->name('products.removeImages');
    Route::post('products/remove_images_temp', [App\Http\Controllers\ProductController::class, 'removeImagesTemp'])->name('products.removeImagesTemp');


    Route::get('products/view_product_sports', [App\Http\Controllers\ProductController::class, 'view_product_sports'])->name('products.view_product_sports');
    Route::post('products/update-product-sports', [App\Http\Controllers\ProductController::class, 'updateProductSports'])->name('update.product.sports');
    Route::get('products/export-csv-product-sports', [App\Http\Controllers\ProductController::class, 'exportCsvProductSports'])->name('export.product.sports.csv');

	Route::get('getImageCaption', [App\Http\Controllers\ProductController::class, 'getImageCaption'])->name('getImageCaption');
	Route::get('getImageCaptionTemp', [App\Http\Controllers\ProductController::class, 'getImageCaptionTemp'])->name('getImageCaptionTemp');
	Route::post('saveProductImageCaption', [App\Http\Controllers\ProductController::class, 'saveProductImageCaption'])->name('saveProductImageCaption');
	Route::post('saveProductImageCaptionTemp', [App\Http\Controllers\ProductController::class, 'saveProductImageCaptionTemp'])->name('saveProductImageCaptionTemp');
	Route::post('deleteProductImageCaption', [App\Http\Controllers\ProductController::class, 'deleteProductImageCaption'])->name('deleteProductImageCaption');
	Route::post('deleteProductImageCaptionTemp', [App\Http\Controllers\ProductController::class, 'deleteProductImageCaptionTemp'])->name('deleteProductImageCaptionTemp');
	Route::get('getOtherImageCaption', [App\Http\Controllers\ProductController::class, 'getOtherImageCaption'])->name('getOtherImageCaption');
	Route::get('getOtherImageCaptionTemp', [App\Http\Controllers\ProductController::class, 'getOtherImageCaptionTemp'])->name('getOtherImageCaptionTemp');

	Route::post('saveOtherImageCaption', [App\Http\Controllers\ProductController::class, 'saveOtherImageCaption'])->name('saveOtherImageCaption');
	Route::post('saveOtherImageCaptionTemp', [App\Http\Controllers\ProductController::class, 'saveOtherImageCaptionTemp'])->name('saveOtherImageCaptionTemp');
	Route::post('deleteOtherImageCaption', [App\Http\Controllers\ProductController::class, 'deleteOtherImageCaption'])->name('deleteOtherImageCaption');
    Route::post('deleteOtherImageCaptionTemp', [App\Http\Controllers\ProductController::class, 'deleteOtherImageCaptionTemp'])->name('deleteOtherImageCaptionTemp');

    //Organizations
    Route::get('master_all_organizations', [App\Http\Controllers\OrganizationController::class, 'master_index'])->name('master_organizations');
	Route::get('organization/get_all_organizations', [App\Http\Controllers\OrganizationController::class, 'get_all_organizations'])->name('organization.get_all_organizations');
	Route::get('organization/update_lead_source', [App\Http\Controllers\OrganizationController::class, 'update_lead_source'])->name('organization.update_lead_source');

    //Sub products
    Route::get('sub_products/{id?}', [App\Http\Controllers\SubProductController::class, 'index'])->name('sub_products.index');
    Route::post('sub_products/create', [App\Http\Controllers\SubProductController::class, 'create'])->name('sub_products.create');
    Route::get('sub_products/edit/{id}', [App\Http\Controllers\SubProductController::class, 'edit'])->name('sub_products.edit');
    Route::get('sub_products/delete/{id}', [App\Http\Controllers\SubProductController::class, 'delete'])->name('sub_products.delete');
    Route::get('products/comment_search', [App\Http\Controllers\ProductCatlogController::class, 'commentSearch'])->name('products.comment_search');
    Route::post('sub_products/images_upload', [App\Http\Controllers\SubProductController::class, 'uploadImages'])->name('sub_products.uploadImages');
    Route::post('sub_products/remove_images', [App\Http\Controllers\SubProductController::class, 'removeImages'])->name('sub_products.removeImages');
    Route::get('sub_product/gold_price', [App\Http\Controllers\SubProductController::class, 'gold_price'])->name('sub_products.gold_price');
    Route::get('subProductEmbellishmentUpdate', [App\Http\Controllers\SubProductController::class, 'subProductEmbellishmentUpdate'])->name('sub_products.subProductEmbellishmentUpdate');

	Route::post('products/upload_image', [App\Http\Controllers\ProductController::class, 'uploadImage'])->name('products.upload_image');
    Route::post('products/upload_image_temp', [App\Http\Controllers\ProductController::class, 'uploadImage_temp'])->name('products.upload_image.temp');
    Route::get('products/export_csv', [App\Http\Controllers\ProductController::class, 'exportCsv'])->name('products.export_csv');
	// Product Categories
    Route::get('product_categories', [App\Http\Controllers\ProductCategoryController::class, 'index'])->name('product_categories');
	// Route::get('product_categories/add', [App\Http\Controllers\ProductCategoryController::class, 'add'])->name('product_categories.add');
	Route::post('product_category/create', [App\Http\Controllers\ProductCategoryController::class, 'create'])->name('product_category.create');
    Route::get('product_categories/delete/{id}', [App\Http\Controllers\ProductCategoryController::class, 'delete'])->name('product_categories.delete');
	Route::get('product_categories/edit/{id}', [App\Http\Controllers\ProductCategoryController::class, 'edit'])->name('product_categories.edit');
	Route::post('product_categories/update', [App\Http\Controllers\ProductCategoryController::class, 'update'])->name('product_categories.update');
	Route::get('sort_product_category/by_alphabet/{id}', [App\Http\Controllers\ProductCategoryController::class, 'sortApphabet']);
	Route::post('product_categories/layout', [App\Http\Controllers\ProductCategoryController::class, 'layout'])->name('product_categories.layout');

	// Embellishment Types
	Route::get('embellishment_types', [App\Http\Controllers\EmbellishmentTypesController::class, 'index'])->name('embellishment_types');
	// Route::get('embellishment_types/add', [App\Http\Controllers\EmbellishmentTypesController::class, 'add'])->name('embellishment_types.add');
	Route::post('embellishment_types/create', [App\Http\Controllers\EmbellishmentTypesController::class, 'create'])->name('embellishment_types.create');
	Route::get('embellishment_types/delete/{id}', [App\Http\Controllers\EmbellishmentTypesController::class, 'delete'])->name('embellishment_types.delete');
	Route::get('embellishment_types/edit/{id}', [App\Http\Controllers\EmbellishmentTypesController::class, 'edit'])->name('embellishment_types.edit');
	Route::post('embellishment_types/update', [App\Http\Controllers\EmbellishmentTypesController::class, 'update'])->name('embellishment_types.update');
	Route::get('sort_emblishment/by_alphabet/{id}', [App\Http\Controllers\EmbellishmentTypesController::class, 'sortApphabet']);
	Route::post('embellishment_types/layout', [App\Http\Controllers\EmbellishmentTypesController::class, 'layout'])->name('embellishment_types.layout');

    //Product Tagline
	Route::get('product_tagline', [App\Http\Controllers\ProductTaglineController::class, 'index'])->name('product_tagline');
	Route::post('product_tagline/create', [App\Http\Controllers\ProductTaglineController::class, 'create'])->name('product_tagline.create');
	Route::post('product_tagline/update', [App\Http\Controllers\ProductTaglineController::class, 'update'])->name('product_tagline.update');
	Route::get('product_tagline/edit/{id}', [App\Http\Controllers\ProductTaglineController::class, 'edit'])->name('product_tagline.edit');
	Route::get('product_tagline/delete', [App\Http\Controllers\ProductTaglineController::class, 'delete'])->name('product_tagline.delete');

	// Factories
    Route::get('factories', [App\Http\Controllers\FactoryController::class, 'index'])->name('factories');
    // Route::get('factories/add', [App\Http\Controllers\FactoryController::class, 'add'])->name('factories.add');
	Route::get('factories/delete/{id}', [App\Http\Controllers\FactoryController::class, 'delete'])->name('factories.delete');
	Route::get('factories/edit/{id}', [App\Http\Controllers\FactoryController::class, 'edit'])->name('factories.edit');
    Route::post('factories/update', [App\Http\Controllers\FactoryController::class, 'update'])->name('factories.update');
    Route::post('factories/create', [App\Http\Controllers\FactoryController::class, 'create'])->name('factories.create');
    Route::get('sort_factory/by_alphabet/{id}', [App\Http\Controllers\FactoryController::class, 'sortApphabet']);
    Route::post('factories/layout', [App\Http\Controllers\FactoryController::class, 'layout'])->name('factories.layout');

	// Sizes
	Route::get('sizes', [App\Http\Controllers\SizeController::class, 'index'])->name('sizes');
	// Route::get('sizes/add', [App\Http\Controllers\SizeController::class, 'add'])->name('sizes.add');
	Route::post('sizes/create', [App\Http\Controllers\SizeController::class, 'create'])->name('sizes.create');
	Route::get('sizes/delete/{id}', [App\Http\Controllers\SizeController::class, 'delete'])->name('sizes.delete');
	Route::get('sizes/edit/{id}', [App\Http\Controllers\SizeController::class, 'edit'])->name('sizes.edit');
	Route::post('sizes/update', [App\Http\Controllers\SizeController::class, 'update'])->name('sizes.update');
	Route::get('sort_size/by_alphabet/{id}', [App\Http\Controllers\SizeController::class, 'sortApphabet']);
	Route::post('sizes/layout', [App\Http\Controllers\SizeController::class, 'layout'])->name('sizes.layout');

	// Attributes
    Route::get('attributes', [App\Http\Controllers\AttributesController::class, 'index'])->name('attributes');
    Route::post('attributes/create', [App\Http\Controllers\AttributesController::class, 'create'])->name('attributes.create');
    Route::get('attributes/edit/{id}', [App\Http\Controllers\AttributesController::class, 'edit'])->name('attributes.edit');
    Route::post('attributes/update', [App\Http\Controllers\AttributesController::class, 'update'])->name('attributes.update');
    Route::get('attributes/delete/{id}', [App\Http\Controllers\AttributesController::class, 'delete'])->name('attributes.delete');
    Route::post('attributes/layout', [App\Http\Controllers\AttributesController::class, 'layout'])->name('attributes.layout');

    // Attribute Groups
    Route::get('attribute_groups', [App\Http\Controllers\AttributeGroupsController::class, 'index'])->name('attribute_groups');
    Route::post('attribute_groups/create', [App\Http\Controllers\AttributeGroupsController::class, 'create'])->name('attribute_groups.create');
    Route::get('attribute_groups/edit/{id}', [App\Http\Controllers\AttributeGroupsController::class, 'edit'])->name('attribute_groups.edit');
    Route::post('attribute_groups/update/{id}', [App\Http\Controllers\AttributeGroupsController::class, 'update'])->name('attribute_groups.update');
    Route::get('attribute_groups/delete/{id}', [App\Http\Controllers\AttributeGroupsController::class, 'delete'])->name('attribute_groups.delete');
    Route::post('attribute_groups/layout', [App\Http\Controllers\AttributeGroupsController::class, 'layout'])->name('attribute_groups.layout');

    // Pattern Codes
    Route::get('pattern_codes', [App\Http\Controllers\PatternCodeController::class, 'index'])->name('pattern_codes');
    Route::post('pattern_codes/create', [App\Http\Controllers\PatternCodeController::class, 'create'])->name('pattern_codes.create');
    Route::get('pattern_codes/get_attributes/{subProductId}', [App\Http\Controllers\PatternCodeController::class, 'getAttributes'])->name('pattern_codes.get_attributes');
    Route::get('pattern_codes/edit/{id}', [App\Http\Controllers\PatternCodeController::class, 'edit'])->name('pattern_codes.edit');
    Route::post('pattern_codes/update/{id}', [App\Http\Controllers\PatternCodeController::class, 'update'])->name('pattern_codes.update');
    Route::get('pattern_codes/delete/{id}', [App\Http\Controllers\PatternCodeController::class, 'delete'])->name('pattern_codes.delete');
    Route::post('pattern_codes/layout', [App\Http\Controllers\PatternCodeController::class, 'layout'])->name('pattern_codes.layout');

// Users
	// Users Roles
    Route::get('user_roles', [App\Http\Controllers\UserRoleController::class, 'index'])->name('user_roles');
    // Route::get('user_roles/add', [App\Http\Controllers\UserRoleController::class, 'add'])->name('user_roles.add');
    Route::post('user_roles/create', [App\Http\Controllers\UserRoleController::class, 'create'])->name('user_roles.create');
    // Route::get('user_roles/sort_by_alphabet/{id}', [App\Http\Controllers\UserRoleController::class, 'sortByAlphabet']);
    Route::get('user_roles/delete/{id}', [App\Http\Controllers\UserRoleController::class, 'delete'])->name('user_roles.delete');
    Route::get('user_roles/edit/{userRoleId}', [App\Http\Controllers\UserRoleController::class, 'edit']);
    Route::post('user_roles/update', [App\Http\Controllers\UserRoleController::class, 'update'])->name('user_roles.update');
    Route::post('user_roles/layout', [App\Http\Controllers\UserRoleController::class, 'layout'])->name('user_roles.layout');
    Route::get('user_roles/detail/{id}', [App\Http\Controllers\UserRoleController::class, 'detail'])->name('user_roles.detail');

    // Users Groups
    Route::get('user_groups', [App\Http\Controllers\UserGroupController::class, 'index'])->name('user_groups');
    // Route::get('user_groups/add', [App\Http\Controllers\UserGroupController::class, 'add'])->name('user_groups.add');
    Route::post('user_groups/create', [App\Http\Controllers\UserGroupController::class, 'create'])->name('user_groups.create');
    // Route::get('user_groups/sort_by_alphabet/{id}', [App\Http\Controllers\UserGroupController::class, 'sortByAlphabet']);
    Route::get('user_groups/delete/{id}', [App\Http\Controllers\UserGroupController::class, 'delete'])->name('user_groups.delete');
    Route::get('user_groups/edit/{userGroupId}', [App\Http\Controllers\UserGroupController::class, 'edit']);
    Route::get('user_groups/userGroupPermissionList', [App\Http\Controllers\UserGroupController::class, 'userGroupPermissionList']);
    Route::post('user_groups/update', [App\Http\Controllers\UserGroupController::class, 'update'])->name('user_groups.update');
    Route::post('user_groups/layout', [App\Http\Controllers\UserGroupController::class, 'layout'])->name('user_groups.layout');

    Route::get('user_groups/get_members/{userGroupId}', [App\Http\Controllers\UserGroupController::class, 'getMember'])->name('user_groups.get_members');
    Route::post('user_groups/update_members', [App\Http\Controllers\UserGroupController::class, 'updateMember'])->name('user_groups.update_members');
    Route::post('user_groups/update_members/add', [App\Http\Controllers\UserGroupController::class, 'addMember'])->name('user_groups.addMember');
    Route::post('user_groups/update_members/delete', [App\Http\Controllers\UserGroupController::class, 'deleteMember'])->name('user_groups.deleteMember');

	// Users
    Route::get('users', [App\Http\Controllers\UserManagementController::class, 'index'])->name('users');
	Route::post('users/create', [App\Http\Controllers\UserManagementController::class, 'create'])->name('users.create');
	Route::get('users/delete/{id}', [App\Http\Controllers\UserManagementController::class, 'delete'])->name('users.delete');
	Route::get('users/edit/{userId}', [App\Http\Controllers\UserManagementController::class, 'edit']);
	Route::post('users/update', [App\Http\Controllers\UserManagementController::class, 'update'])->name('users.update');
	Route::post('Employee/users/layout', [App\Http\Controllers\UserManagementController::class, 'layout'])->name('users.layout');
    Route::get('/employee/new', [App\Http\Controllers\UserManagementController::class, 'newemployee'])->name('newemployee');
    Route::post('/employee/store', [App\Http\Controllers\UserManagementController::class, 'employee_store'])->name('HR.employee_store');
    Route::get('/employee/permission/{id}', [App\Http\Controllers\UserManagementController::class, 'employee_permission'])->name('HR.employee_permission');

//mail
    // Route::get('mailLite', [App\Http\Controllers\MailController::class, 'index'])->name('mailLite');
    Route::get('mail', [App\Http\Controllers\MailController::class, 'index'])->name('mailLite');
    Route::get('webmailsetup', [App\Http\Controllers\MailController::class, 'returnMmail'])->name('webmailsetup');

    Route::post('datatable/column_order', [App\Http\Controllers\DatatableController::class, 'columnOrder'])->name('datatable.column_order');
    Route::get('datatable/get_column_order/{interfaceId}', [App\Http\Controllers\DatatableController::class, 'getColumnOrder']);

    Route::get('mail/compose', [App\Http\Controllers\MailController::class, 'compose'])->name('mail.compose');
    Route::get('mail/inbox', [App\Http\Controllers\MailController::class, 'inbox'])->name('mail.inbox');
    Route::get('mail/important', [App\Http\Controllers\MailController::class, 'important'])->name('mail.important');
    Route::get('mail/sent', [App\Http\Controllers\MailController::class, 'sent'])->name('mail.sent');
    Route::get('mail/view', [App\Http\Controllers\MailController::class, 'view'])->name('mail.view');

    // File Management
    Route::get('file_management', function () {return view('pages.file_management.html.rtl.vertical-menu-template.index');})->name('file_management');
    Route::get('file_management/oms', [App\Http\Controllers\FileManagementController::class, 'oms'])->name('file_management.oms');
    Route::post('file_management/oms/folders', [App\Http\Controllers\FileManagementController::class, 'omsFolders'])->name('file_management.oms.folders');
    Route::post('file_management/oms/files', [App\Http\Controllers\FileManagementController::class, 'omsFiles'])->name('file_management.oms.files');
	Route::get('file_management/my_drive', [App\Http\Controllers\FileManagementController::class, 'myDrive'])->name('file_management.my_drive');
	Route::post('file_management/my_drive/folders', [App\Http\Controllers\FileManagementController::class, 'myDriveFolders'])->name('file_management.my_drive.folders');
    Route::post('file_management/create_folder', [App\Http\Controllers\FileManagementController::class, 'createFolder'])->name('file_management.create_folder');
    Route::post('file_management/rename_folder', [App\Http\Controllers\FileManagementController::class, 'renameFolder'])->name('file_management.rename_folder');
    Route::post('file_management/create_file', [App\Http\Controllers\FileManagementController::class, 'createFile'])->name('file_management.create_file');
    Route::post('file_management/rename_file', [App\Http\Controllers\FileManagementController::class, 'renameFile'])->name('file_management.rename_file');

    Route::get('file_management/file_share', [App\Http\Controllers\FileManagementController::class, 'fileShare'])->name('file_management.file_share');
    Route::post('file_management/share', [App\Http\Controllers\FileManagementController::class, 'share'])->name('file_management.share');
    Route::post('file_management/share/folders', [App\Http\Controllers\FileManagementController::class, 'shareFolders'])->name('file_management.share.folders');

	Route::post('file_management/file_share/folders', [App\Http\Controllers\FileManagementController::class, 'fileShareFolders'])->name('file_management.file_share.folders');
    Route::post('file_management/folder_hierarchy', [App\Http\Controllers\FileManagementController::class, 'folderHierarchy'])->name('file_management/folder_hierarchy');

    Route::post('file_management/rename', [App\Http\Controllers\FileManagementController::class, 'rename'])->name('file_management.rename');

    Route::post('file_management/move_to_my_drive_file', [App\Http\Controllers\FileManagementController::class, 'moveToMyDriveFile'])->name('file_management.move_to_my_drive_file');
    Route::post('file_management/move_to_my_drive_folder', [App\Http\Controllers\FileManagementController::class, 'moveToMyDriveFolder'])->name('file_management.move_to_my_drive_folder');
    Route::post('file_management/move_to_file', [App\Http\Controllers\FileManagementController::class, 'moveToFile'])->name('file_management.move_to_file');
    Route::post('file_management/move_to_folder', [App\Http\Controllers\FileManagementController::class, 'moveToFolder'])->name('file_management.move_to_folder');

    Route::get('file_management/recents', [App\Http\Controllers\FileManagementController::class, 'recents'])->name('file_management.recents');
    Route::get('file_management/important', [App\Http\Controllers\FileManagementController::class, 'important'])->name('file_management.important');

    Route::get('file_management/trash', [App\Http\Controllers\FileManagementController::class, 'trash'])->name('file_management.trash');
    Route::post('file_management/trash/folders', [App\Http\Controllers\FileManagementController::class, 'trashFolders'])->name('file_management.trash.folders');
    Route::post('file_management/remove_shared_item', [App\Http\Controllers\FileManagementController::class, 'removeSharedItem'])->name('file_management.remove_shared_item');
    Route::post('file_management/remove_file', [App\Http\Controllers\FileManagementController::class, 'removeFile'])->name('file_management.remove_file');
    Route::post('file_management/remove_folder', [App\Http\Controllers\FileManagementController::class, 'removeFolder'])->name('file_management.remove_folder');
    Route::post('file_management/delete_file', [App\Http\Controllers\FileManagementController::class, 'deleteFile'])->name('file_management.delete_file');
    Route::post('file_management/delete_folder', [App\Http\Controllers\FileManagementController::class, 'deleteFolder'])->name('file_management.delete_folder');
    Route::post('file_management/empty_trash', [App\Http\Controllers\FileManagementController::class, 'emptyTrash'])->name('file_management.empty_trash');
    Route::post('file_management/restore_file', [App\Http\Controllers\FileManagementController::class, 'restoreFile'])->name('file_management.restore_file');
    Route::post('file_management/restore_folder', [App\Http\Controllers\FileManagementController::class, 'restoreFolder'])->name('file_management.restore_folder');

    Route::get('file_management/documents', [App\Http\Controllers\FileManagementController::class, 'documents'])->name('file_management.documents');
    Route::get('file_management/images', [App\Http\Controllers\FileManagementController::class, 'images'])->name('file_management.images');
    Route::get('file_management/videos', [App\Http\Controllers\FileManagementController::class, 'videos'])->name('file_management.videos');
    Route::get('file_management/audio', [App\Http\Controllers\FileManagementController::class, 'audio'])->name('file_management.audio');
    Route::get('file_management/zip_files', [App\Http\Controllers\FileManagementController::class, 'zipFiles'])->name('file_management.zip_files');
    Route::get('file_management/images/download/{fileId}', [App\Http\Controllers\FileManagementController::class, 'download']);
    Route::post('file_management/images/upload', [App\Http\Controllers\FileManagementController::class, 'upload'])->name('file_management.images.upload');
    Route::post('file_management/all_files/create_folder', [App\Http\Controllers\FileManagementController::class, 'createFolder'])->name('file_management.all_files.create_folder');

    // Payment
    Route::get('payment', [App\Http\Controllers\PaymentController::class, 'index'])->name('payment');
    Route::post('/dopay/online', [App\Http\Controllers\PaymentController::class, 'handleonlinepay'])->name('dopay.online');
    // Route::post('payment/check', [App\Http\Controllers\PaymentController::class, 'check'])->name('payment.check');

    // Cheque Payment
    Route::post('payment/check', [App\Http\Controllers\ChequePaymentController::class, 'check'])->name('payment.check');
    Route::post('payment/check_approve', [App\Http\Controllers\ChequePaymentController::class, 'checkApprove'])->name('payment.check_approve');

    // COther Payment
    Route::post('payment/other', [App\Http\Controllers\OtherPaymentController::class, 'other'])->name('payment.other');
    Route::post('order_mark_as_paid', [App\Http\Controllers\OtherPaymentController::class, 'order_mark_as_paid'])->name('order_mark_as_paid');

    // Venmo Payment
    Route::post('payment/venmo', [App\Http\Controllers\VenmoPaymentController::class, 'venmo'])->name('payment.venmo');
    Route::post('payment/venmo_approve', [App\Http\Controllers\VenmoPaymentController::class, 'venmoApprove'])->name('payment.venmo_approve');

    // Paypal Payment
    Route::post('payment/paypal', [App\Http\Controllers\PaypalPaymentController::class, 'paypal'])->name('payment.paypal');
    Route::post('payment/paypal_approve', [App\Http\Controllers\PaypalPaymentController::class, 'paypalApprove'])->name('payment.paypal_approve');


    // OMG

	Route::get('OMG/stores', [App\Http\Controllers\OrderPlaceController::class, 'allStores'])->name('pages.order_place.all_stores');//all stores view page
	Route::get('OMG/store/{id}/products', [App\Http\Controllers\OrderPlaceController::class, 'allStoreproducts'])->name('pages.order_place.all_store_products');//all stores view page


	Route::get('OMG/store/add', [App\Http\Controllers\OrderPlaceController::class, 'index'])->name('pages.order_place.index');//add new store view page
	Route::get('OMG/store/edit/{id}', [App\Http\Controllers\OrderPlaceController::class, 'editStore']);// edit store view page

	Route::post('addOrganizationStore', [App\Http\Controllers\OrderPlaceController::class, 'addOrganizationStore']);//add new store - controller
	Route::post('editOrganizationStore', [App\Http\Controllers\OrderPlaceController::class, 'editOrganizationStore']);// edit store - controller

	Route::get('OMG/store/product/add/{id}', [App\Http\Controllers\OrderPlaceController::class, 'addStoreProduct']);// add productview page
	Route::get('OMG/store/product/edit/{id}', [App\Http\Controllers\OrderPlaceController::class, 'editProduct']);// edit store product view page

	Route::post('addOrganizationStoreProduct', [App\Http\Controllers\OrderPlaceController::class, 'addOrganizationStoreProduct']);//add new store product - controller
	Route::post('editOrganizationStoreProduct', [App\Http\Controllers\OrderPlaceController::class, 'editOrganizationStoreProduct']);//edit store product - controller

	Route::post('organization/store/getproductnames', [App\Http\Controllers\OrderPlaceController::class, 'getProductNames']);// get the product name,id from gender category selected
	//Route::post('addOrganizationStoreProduct', [App\Http\Controllers\OrderPlaceController::class, 'addOrganizationStoreProduct']);//add new store product - controller
	Route::post('OMG/store/delete', [App\Http\Controllers\OrderPlaceController::class, 'deleteStore']);
	Route::post('OMG/store/product/delete', [App\Http\Controllers\OrderPlaceController::class, 'deleteStoreProduct']);


	Route::get('/callbackmail/{messageId?}', [App\Http\Controllers\EmailController::class, 'test12'])->name('indexemail');
    Route::get('/searchcontacts', [App\Http\Controllers\EmailController::class, 'searchcontact']);
    Route::get('view/message/{mailbox_id}/{message_Id}', [App\Http\Controllers\EmailController::class, 'viewMessage']);
    Route::post('get/message/messagedetails', [App\Http\Controllers\EmailController::class, 'getMessageBody']);
    Route::get('get/message/{message_Id}', [App\Http\Controllers\EmailController::class, 'getMessage']);
    Route::get('get/message/attachments/{message_Id}', [App\Http\Controllers\EmailController::class, 'getMessageAttachments']);
    Route::get('get/conversation/message/{message_Id}', [App\Http\Controllers\EmailController::class, 'getConversation']);
    Route::get('get_organization_act/{messageNo}/{email}', [App\Http\Controllers\EmailController::class, 'get_organization_act']);
    Route::get('/get/maiibox/chat', [App\Http\Controllers\EmailController::class, 'GetMailboxChat']);
    Route::get('/maiibox/action', [App\Http\Controllers\EmailController::class, 'mailActions']);
    Route::get('/get/email/signature', [App\Http\Controllers\EmailController::class, 'getEmailsignature']);
    Route::get('/search/email', [App\Http\Controllers\EmailController::class, 'SearchEmail']);
    Route::post('/save-signature', [App\Http\Controllers\EmailController::class, 'savesignature'])->name('save.signature');
    Route::post('/maiibox/delete_draft', [App\Http\Controllers\EmailController::class, 'DeleteDraftDirect'])->name('delete.draft');

    Route::post('/mailSend', [App\Http\Controllers\EmailController::class, 'mailSend'])->name('mailSend');
    Route::post('/forwardreply',[App\Http\Controllers\EmailController::class, 'forwardReply'] )->name('send.forward');
    Route::post('/Draftforwardreply',[App\Http\Controllers\EmailController::class, 'draftforwardReply'] )->name('DraftForward');
    Route::post('/sendreply',[App\Http\Controllers\EmailController::class, 'sendReply'] )->name('send.reply');
    Route::post('/Draftreply',[App\Http\Controllers\EmailController::class, 'DraftReply'] )->name('saveDraftReply');
    Route::get('/get-sidebar-items',[App\Http\Controllers\EmailController::class, 'getSidebarItems'] );
    Route::get('/sidebar-counts', [App\Http\Controllers\EmailController::class, 'getSidebarCounts']);
    Route::get('/save-filter/{id}', [App\Http\Controllers\EmailController::class, 'saveFilter'])->name('filter.save');
    Route::get('syncing/{Msgid}/{count}/{OrgId}', [App\Http\Controllers\EmailController::class, 'syncingMailToOrg'])->name('syncing.mailToOrg');
    Route::get('/email-updates-count', [App\Http\Controllers\EmailController::class, 'emailUpdatesCount']);



	Route::post('/emails', [App\Http\Controllers\EmailController::class, 'getEmails'])->name('getEmails');
	Route::get('emails/{type}/{uID}/{id}', [App\Http\Controllers\EmailController::class, 'getMessageView'])->name('getMessageView');

    // Link organization
	Route::post('email/link_organization', [App\Http\Controllers\EmailController::class, 'linkOrganization']);
	Route::post('email/add_organization', [App\Http\Controllers\EmailController::class, 'addOrganization']);
	Route::post('email/linkNewOrganizationEmail', [App\Http\Controllers\EmailController::class, 'linkNewOrganizationEmail'])->name('email.linkNewOrganizationEmail');
	Route::post('email/linkExistOrganizationEmail', [App\Http\Controllers\EmailController::class, 'linkExistOrganizationEmail'])->name('email.linkExistOrganizationEmail');
	Route::post('email/linkExistOrganizationInfo', [App\Http\Controllers\EmailController::class, 'linkExistOrganizationInfo'])->name('email.linkExistOrganizationInfo');
	Route::post('email/unlinkExistOrganizationInfo', [App\Http\Controllers\EmailController::class, 'unlinkExistOrganizationInfo'])->name('email.unlinkExistOrganizationInfo');
	Route::post('check/email/organization', [App\Http\Controllers\EmailController::class, 'checkEmailOrganization'])->name('email.checkEmailOrganization');

    //test route heshan remove this after done works
Route::get('email/info-debugg/{id?}', [App\Http\Controllers\EmailController::class, 'testfunction'])->name('email.testfunction');


	Route::post('sendemail', [App\Http\Controllers\EmailController::class, 'TestSendEmails'])->name('sendemail');
    Route::post('sendreplyemail', [App\Http\Controllers\EmailController::class, 'TestSendReplyEmails'])->name('sendreplyemail');
	Route::post('savedraft', [App\Http\Controllers\EmailController::class, 'saveDraft'])->name('saveDraft');
	Route::post('updateDraft', [App\Http\Controllers\EmailController::class, 'updateDraft'])->name('updateDraft');
	Route::post('viewDraft', [App\Http\Controllers\EmailController::class, 'viewDraft'])->name('viewdraft');

    // Route::get('/oauth/callback', 'O365Controller@callback');
	Route::get('/oauth/authorize', [App\Http\Controllers\O365Controller::class, 'oauthAuthorize'])->name('authorize');
	Route::get('/oauth/callback', [App\Http\Controllers\O365Controller::class, 'oauthCallback'])->name('callback');

    // Route::get('/oauth/authorize', 'O365Controller@authorize');
    // Route::get('/oauth/callback', 'O365Controller@callback');

	Route::get('/emaillogin', [App\Http\Controllers\EmailController::class, 'emaillogin'])->name('emaillogin');
	Route::post('/saveEmailAccount', [App\Http\Controllers\EmailController::class, 'saveEmailAccount'])->name('saveEmailAccount');
	Route::get('emaillogout', [App\Http\Controllers\EmailController::class, 'logoutUserEmail'])->name('emaillogout');


	Route::get('transactions', [App\Http\Controllers\TransactionController::class, 'allTransactionPayments'])->name('allTransactions');
	Route::post('transaction/refund_excess', [App\Http\Controllers\TransactionController::class, 'refund_excess'])->name('transaction.refund_excess');
    Route::get('transaction/refund_details', [App\Http\Controllers\TransactionController::class,'refund_details'])->name('transaction.refund_details');
	Route::get('transaction/payments/invoice/{id}', [App\Http\Controllers\PaymentController::class, 'printPaymentRecept']);
	Route::get('tax_report', [App\Http\Controllers\TransactionController::class, 'tax_report'])->name('tax_report');
	Route::post('tax_report/export', [App\Http\Controllers\TransactionController::class, 'export'])->name('tax_report.export');

	Route::get('transaction/get_order_payments', [App\Http\Controllers\TransactionController::class, 'get_order_payments']);
	Route::get('transaction/get_payment_receipt_data', [App\Http\Controllers\TransactionController::class, 'get_payment_receipt_data']);
	Route::get('transaction/get_store_payment_log_details', [App\Http\Controllers\TransactionController::class, 'get_store_payment_log_details'])->name('transaction.store_payment_log_details');
    Route::get('/transaction/search-store-payment-logs',[App\Http\Controllers\TransactionController::class, 'search_store_payment_logs'])->name('transaction.search_store_payment_logs');

    Route::get('/quickbooks/connect', [App\Http\Controllers\QuickBooksController::class, 'connect']);
    Route::get('/quickbooks/callback', [App\Http\Controllers\QuickBooksController::class, 'callback']);
    Route::get('/import-to-quickbooks', [App\Http\Controllers\QuickBooksController::class, 'importToQuickBooks'])->name('quickbooks.import_to_quickbooks');
    Route::post('/quickbooks/import-sales-receipt', [App\Http\Controllers\QuickBooksController::class, 'importSalesReceipt'])->name('quickbooks.import_sales_receipt');


		//fileserver proccess
	Route::get('/fileserver', [App\Http\Controllers\FileserverController::class, 'viewFileServer']);
	Route::post('/fileserver/createfolder', [App\Http\Controllers\FileserverController::class, 'createFolder']);
	Route::post('/fileserver/reanmefolder', [App\Http\Controllers\FileserverController::class, 'renameFolder']);
	Route::post('/fileserver/changecolorfolder', [App\Http\Controllers\FileserverController::class, 'changeColorFolder']);
	Route::get('/fileserver/folders/{folderRandName}', [App\Http\Controllers\FileserverController::class, 'viewFolderDetails']);

	Route::post('encore_packing_date', [App\Http\Controllers\NewOrderController::class, 'encorePackingDate']);
    Route::post('order_details/change_encore_packing_date', [App\Http\Controllers\OrderDetailsController::class, 'changeEncorePackingDate']);
	Route::post('ex_factory_date/due_date', [App\Http\Controllers\NewOrderController::class, 'exFactoryDate']);
	Route::post('due_date/ex_factory_date', [App\Http\Controllers\NewOrderController::class, 'dueDate']);

    Route::get('permissions', [App\Http\Controllers\UserRoleController::class, 'permissions']);
    Route::post('user_permission/create', [App\Http\Controllers\UserRoleController::class, 'createPermissions'])->name('user_permission.create');
    Route::get('permission/edit/{id}', [App\Http\Controllers\UserRoleController::class, 'editPermissions']);
    Route::post('user_permission/update', [App\Http\Controllers\UserRoleController::class, 'updatePermissions'])->name('user_permission.update');
    Route::get('permission/delete/{id}', [App\Http\Controllers\UserRoleController::class, 'deletePermissions']);

    // Pipedrive
    Route::get('pipedrive/organizations', [App\Http\Controllers\PipedriveController::class, 'organizations'])->name('pipedrive.organizations');
    Route::post('pipedrive/organizations_upload', [App\Http\Controllers\PipedriveController::class, 'organizationsUpload'])->name('pipedrive.organizations_upload');
    Route::post('pipedrive/organizations_sync', [App\Http\Controllers\PipedriveController::class, 'organizationsSync'])->name('pipedrive.organizations_sync');
    Route::get('pipedrive/people', [App\Http\Controllers\PipedriveController::class, 'people'])->name('pipedrive.people');
    Route::post('pipedrive/people_upload', [App\Http\Controllers\PipedriveController::class, 'peopleUpload'])->name('pipedrive.people_upload');
    Route::post('pipedrive/people_sync', [App\Http\Controllers\PipedriveController::class, 'peopleSync'])->name('pipedrive.people_sync');
    Route::get('pipedrive/activities', [App\Http\Controllers\PipedriveController::class, 'activities'])->name('pipedrive.activities');
    Route::post('pipedrive/activities_upload', [App\Http\Controllers\PipedriveController::class, 'activitiesUpload'])->name('pipedrive.activities_upload');
    Route::post('pipedrive/activities_sync', [App\Http\Controllers\PipedriveController::class, 'activitiesSync'])->name('pipedrive.activities_sync');
    Route::get('/pipedrive/searchorganizations', [App\Http\Controllers\PipedriveController::class, 'pipedrivesearch']);
    Route::post('/pipedrive/createorganization', [App\Http\Controllers\PipedriveController::class, 'createorganization']);
    Route::post('/pipedrive/linkorganization', [App\Http\Controllers\PipedriveController::class, 'linkorganization']);

    //Project Management
    Route::get('projects/home', [App\Http\Controllers\ProjectController::class, 'project_home'])->name('projects.home');
    Route::get('projects/delete/{id}', [App\Http\Controllers\ProjectController::class, 'project_delete'])->name('projects.delete');
    Route::get('projects/delete/new/{id}', [App\Http\Controllers\ProjectController::class, 'project_delete_new'])->name('projects.delete.new');
    Route::get('projects/list', [App\Http\Controllers\ProjectController::class, 'project_list'])->name('projects.list');
    Route::get('projects/inbox', [App\Http\Controllers\ProjectController::class, 'project_inbox'])->name('projects.inbox');
    Route::get('projects/my_tasks', [App\Http\Controllers\ProjectController::class, 'project_my_tasks'])->name('projects.my_tasks');
    // Route::get('projects/project_board', [App\Http\Controllers\ProjectController::class, 'project_board'])->name('project_board');
    // Route::get('projects/inner', [App\Http\Controllers\ProjectController::class, 'project_inner'])->name('projects.inner');
    Route::get('projects/view/{id}', [App\Http\Controllers\ProjectController::class, 'project_inner'])->name('projects.view');
    Route::get('projects/view-temp/{id}', [App\Http\Controllers\ProjectController::class, 'project_inner_temp'])->name('projects.view.temp');
    Route::get('projects/project_overview', [App\Http\Controllers\ProjectController::class, 'project_overview'])->name('project_overview');
    Route::get('projects', [App\Http\Controllers\ProjectController::class, 'index'])->name('projects');
    Route::get('projects/get_projects', [App\Http\Controllers\ProjectController::class, 'getProjects']);
    Route::get('projects/get_paginated_projects', [App\Http\Controllers\ProjectController::class, 'getPaginatedProjects'])->name('projects.get_paginated_projects');
    Route::get('projects/get_collaborators_count', [App\Http\Controllers\ProjectController::class, 'getCollaboratorsCount'])->name('projects.get_collaborators_count');
    Route::get('projects/get_projects_collaborators', [App\Http\Controllers\ProjectController::class, 'getProjectsCollaborators'])->name('projects.get_projects_collaborators');
    Route::get('projects/get_completed_task_count', [App\Http\Controllers\ProjectController::class, 'getCompletedTaskCount'])->name('projects.get_completed_task_count');
    Route::get('projects/get_my_tasks', [App\Http\Controllers\ProjectController::class, 'getMyTasks'])->name('projects.get_my_tasks');
    Route::get('projects/get_my_all_tasks', [App\Http\Controllers\ProjectController::class, 'getPaginatedMyAllTasks'])->name('projects.get_my_all_tasks');
    Route::get('projects/get_my_all_tasks_list', [App\Http\Controllers\ProjectController::class, 'getMyAllTasks'])->name('projects.get_my_all_tasks_list');
    Route::get('projects/get_my_task_sections', [App\Http\Controllers\ProjectController::class, 'getMyTaskSections'])->name('projects.get_my_task_sections');
    Route::get('projects/get_my_task_section_by_id/{sectionId}', [App\Http\Controllers\ProjectController::class, 'getMyTaskSectionById'])->name('projects.get_my_task_section_by_id');
    Route::get('projects/get_my_task_calendar', [App\Http\Controllers\ProjectController::class, 'getMyTasksForCalendar'])->name('projects.get_my_task_calendar');
    Route::get('projects/change_my_task_complete_status/{taskId}', [App\Http\Controllers\ProjectController::class, 'changeMyTaskCompleteStatus'])->name('projects.change_my_task_complete_status');
    Route::get('project_details/edit/{id}', [App\Http\Controllers\ProjectController::class, 'edit'])->name('project_details');
    Route::post('projects/update', [App\Http\Controllers\ProjectController::class, 'update'])->name('projects.update');
    Route::post('projects/update-stage-status', [App\Http\Controllers\ProjectController::class, 'updateStageStatus'])->name('projects.updateStageStatus');
    Route::get('projects/filter_search_data', [App\Http\Controllers\ProjectController::class, 'filter_search_data'])->name('projects.filter_search_data');

    Route::post('projects/add_assignee', [App\Http\Controllers\ProjectController::class, 'addAssignee']);
    Route::get('projects/get_assignees/{id}', [App\Http\Controllers\ProjectController::class, 'getAssignees']);
    Route::post('projects/delete_assignee', [App\Http\Controllers\ProjectController::class, 'deleteAssignee']);

    Route::get('projects/change_flag/{projectId}/{flagColor}', [App\Http\Controllers\ProjectController::class, 'changeFlag']);
    Route::get('projects/change_status/{projectId}/{statusId}', [App\Http\Controllers\ProjectController::class, 'changeStatus']);

    //New Project
    Route::get('new_projects', [App\Http\Controllers\NewProjectController::class, 'index'])->name('new_projects');
    Route::post('new_projects/create', [App\Http\Controllers\NewProjectController::class, 'create'])->name('new_projects.create');
    Route::post('new_projects/create_temp', [App\Http\Controllers\NewProjectController::class, 'create_temp'])->name('new_projects.create_temp');


    Route::get('project_icons/index', [App\Http\Controllers\ProjectController::class, 'project_icons'])->name('project_icons.index');
    Route::get('get_project_icon_by_id/{id}', [App\Http\Controllers\ProjectController::class, 'get_project_icon_by_id'])->name('get_project_icon_by_id');
    Route::post('project_icons/create', [App\Http\Controllers\ProjectController::class, 'project_icons_create'])->name('project_icons.create');
    Route::post('project_icons/update', [App\Http\Controllers\ProjectController::class, 'project_icons_update'])->name('project_icons.update');
    Route::get('project_icons/delete/{id}', [App\Http\Controllers\ProjectController::class, 'project_icons_delete'])->name('project_icons.delete');

    //Project Type
    Route::get('project_type', [App\Http\Controllers\ProjectTypeController::class, 'index'])->name('project_type');
    Route::post('project_type.create', [App\Http\Controllers\ProjectTypeController::class, 'create'])->name('project_type.create');
    Route::post('project_type.update', [App\Http\Controllers\ProjectTypeController::class, 'update'])->name('project_type.update');
	Route::get('projectType/delete/{id}', [App\Http\Controllers\ProjectTypeController::class, 'delete'])->name('projectType.delete');

    //Project Section
    Route::get('get_project_management/{id}', [App\Http\Controllers\ProjectController::class, 'getProjectManagement'])->name('get_project_management');
    Route::get('get_project_management_all', [App\Http\Controllers\ProjectController::class, 'getProjectManagementAll'])->name('get_project_management_all');
    Route::get('get_project_management_section_by_id/{id}', [App\Http\Controllers\ProjectController::class, 'getProjectManagementSectionById'])->name('get_project_management_section_by_id');
    Route::post('project_management_section/store', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionStore'])->name('project_management_section.store');
    Route::post('project_management_section/update/{id}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionUpdate'])->name('project_management_section.update');
    Route::get('project_management_section/delete/{id}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectiondelete'])->name('project_management_section.delete');

    //Project Section Discussion
    Route::get('get_project_management_section_discussion_by_id/{id}', [App\Http\Controllers\ProjectController::class, 'getprojectManagementSectionDiscussionById'])->name('get_project_management_section_discussions');
    Route::post('project_management_section_discussion/store', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionStore'])->name('project_management_section_discussion.store');
    Route::post('project_management_section_discussion/update/{id}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionUpdate'])->name('project_management_section_discussion.update');
    Route::get('project_management_section_discussion/delete/{id}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionDelete'])->name('project_management_section_discussion.delete');

    Route::get('get_project_management_sub_section_discussion_count_by_id/{id}/{discussionId}', [App\Http\Controllers\ProjectController::class, 'getSubSectionDiscussionCountById'])->name('sub_section_discussion.count');
    Route::get('get_project_management_sub_section_discussion_comment_count_by_id/{id}/{discussionId}', [App\Http\Controllers\ProjectController::class, 'getSubSectionDiscussionCommentCountById'])->name('sub_section_discussion.commentCount');
    Route::post('comment/toggle-reaction/{commentId}', [App\Http\Controllers\ProjectController::class, 'toggleReaction'])->name('comment.toggle-reaction');

    //Project Section Sub Discussion
    Route::get('get_project_management_section_sub_discussion_by_discussion_id/{id}', [App\Http\Controllers\ProjectController::class, 'getprojectManagementSectionSubDiscussionByDiscussionId'])->name('get_project_management_section_sub_discussion_by_discussion_id');
    Route::get('get_project_management_my_task_sub_discussion_by_discussion_id/{id}', [App\Http\Controllers\ProjectController::class, 'getprojectManagementMyTaskSubDiscussionByDiscussionId'])->name('get_project_management_my_task_sub_discussion_by_discussion_id');
    Route::get('get_project_management_section_sub_discussion_by_id/{id}', [App\Http\Controllers\ProjectController::class, 'getprojectManagementSectionSubDiscussionById'])->name('get_project_management_section_sub_discussion_by_id');
    Route::post('project_management_section_sub_discussion/store', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionSubDiscussionStore'])->name('project_management_section_sub_discussion.store');
    Route::post('project_management_section_sub_discussion/update/{id}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionSubDiscussionUpdate'])->name('project_management_section_sub_discussion.update');
    Route::get('project_management_section_sub_discussion/delete/{id}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionSubDiscussionDelete'])->name('project_management_section_sub_discussion.delete');

    Route::get('get_project_management_section_assignees_by_id/{id}', [App\Http\Controllers\ProjectController::class, 'getProjectManagementSectionAssigneesById'])->name('get_project_management_section_assignees_by_id');

    //Project Section Discussion Comment
    Route::post('project_management_section_discussion_comment/store', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionCommentStore'])->name('project_management_section_discussion_comment.store');
    Route::post('project_management_section_discussion_comment/save_draft', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionCommentSaveDraft'])->name('project_management_section_discussion_comment.save_draft');
    Route::get('project_management_section_discussion_comment/get_draft/{discussion_id}/{discussion_type}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionCommentGetDraft'])->name('project_management_section_discussion_comment.get_draft');
    Route::post('project_management_section_discussion_comment/update/{id}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionCommentUpdate'])->name('project_management_section_discussion_comment.update');
    Route::get('project_management_section_discussion_comment/delete/{id}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionCommentDelete'])->name('project_management_section_discussion_comment.delete');
    Route::post('project_management_section_discussion_comment/file_upload', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionCommentFileUpload'])->name('project_management_section_discussion_comment.file_upload');
    Route::post('project_management_section_discussion_comment_temp/file_upload', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionCommentFileUploadTemp'])->name('project_management_section_discussion_comment.file_upload.temp');
    Route::get('section_comment_count/{id}', [App\Http\Controllers\ProjectController::class, 'sectionCommentCount']);
    Route::get('discussion_count/{id}', [App\Http\Controllers\ProjectController::class, 'discussionCount']);
    Route::post('/comment/toggle-pin/{id}', [App\Http\Controllers\ProjectController::class, 'projectManagementSectionDiscussionCommentTogglePin'])->name('comment.toggle.pin');


    //Project Management Drag and Drop Reordering
    Route::post('project_management_sections/reorder', [App\Http\Controllers\ProjectController::class, 'reorderSections'])->name('project_management_sections.reorder');
    Route::post('project_management_discussions/reorder', [App\Http\Controllers\ProjectController::class, 'reorderDiscussions'])->name('project_management_discussions.reorder');
    Route::post('project_management_sub_discussions/reorder', [App\Http\Controllers\ProjectController::class, 'reorderSubDiscussions'])->name('project_management_sub_discussions.reorder');

    //Sports
    Route::get('sports', [App\Http\Controllers\SportController::class, 'index'])->name('sports');
    Route::post('sports/create', [App\Http\Controllers\SportController::class, 'create'])->name('sports.create');
	Route::get('sports/edit/{sportId}', [App\Http\Controllers\SportController::class, 'edit']);
	Route::post('sports/update', [App\Http\Controllers\SportController::class, 'update'])->name('sports.update');
	Route::get('sports/delete', [App\Http\Controllers\SportController::class, 'delete'])->name('sports.delete');
	Route::get('sports/delete/{id}', [App\Http\Controllers\SportController::class, 'delete'])->name('sports.delete');

    //Size Type
    Route::get('size_type', [App\Http\Controllers\SizeTypeController::class, 'index'])->name('size_type');
    Route::post('sizeType/create', [App\Http\Controllers\SizeTypeController::class, 'create'])->name('sizeType.create');
	Route::get('sizeType/edit/{id}', [App\Http\Controllers\SizeTypeController::class, 'edit'])->name('sizeType.edit');
    Route::post('sizeType/update', [App\Http\Controllers\SizeTypeController::class, 'update'])->name('sizeType.update');
	Route::get('sizeType/delete/{id}', [App\Http\Controllers\SizeTypeController::class, 'delete'])->name('sizeType.delete');

    // Customer supports
    Route::get('/admin/support', [App\Http\Controllers\AdminSupportController::class, 'index'])->name('customer_supports');
    Route::get('/admin/support/messages/{conversation}', [App\Http\Controllers\AdminSupportController::class, 'getMessages'])->name('admin.support.messages');
    Route::post('/admin/support/send-message', [App\Http\Controllers\AdminSupportController::class, 'sendMessage'])->name('admin.support.send-message');
    Route::get('/admin/support/poll-messages', [App\Http\Controllers\AdminSupportController::class, 'pollMessages'])->name('admin.support.poll-messages');
    Route::get('/admin/support/sidebar-list', [App\Http\Controllers\AdminSupportController::class, 'sidebarList'])->name('admin.support.sidebar-list');
    Route::post('/admin/support/close-conversation', [App\Http\Controllers\AdminSupportController::class, 'closeConversation'])->name('admin.support.close-conversation');
    Route::post('/admin/support/transfer', [App\Http\Controllers\AdminSupportController::class, 'transfer'])->name('admin.support.transfer');
    Route::post('/admin/support/mark-read', [App\Http\Controllers\AdminSupportController::class, 'markRead'])->name('admin.support.mark-read');
    Route::post('/admin/support/delete-conversation', [App\Http\Controllers\AdminSupportController::class, 'deleteConversation'])->name('admin.support.delete-conversation');

    // Activity Logs
    Route::get('activity_logs', [App\Http\Controllers\ActivityLogsController::class, 'index'])->name('activity_logs');

    // User Logs
    Route::get('user_log/index', [App\Http\Controllers\UserController::class,'user_log'])->name('user_log.index');
    Route::get('user_log/get_detail/{id}/{type}', [App\Http\Controllers\UserController::class,'getLogDetail'])->name('user_log.get_detail');
    Route::post('user_log/delete', [App\Http\Controllers\UserController::class,'deleteLogDetail'])->name('user_log.delete');
    Route::post('user_log/export', [App\Http\Controllers\UserController::class,'user_log_export'])->name('user_log.export');

    // Accounting - Generate Invoice
    Route::get('generate_invoice', [App\Http\Controllers\GenerateInvoiceController::class, 'index'])->name('generate_invoice');
    Route::get('payment_ledger', [App\Http\Controllers\GenerateInvoiceController::class, 'legerPaymentsIndex'])->name('payment_ledger');
    Route::get('all_invoices', [App\Http\Controllers\GenerateInvoiceController::class, 'AllInvoicesIndex'])->name('all_invoices');
    Route::post('get/all_invoices', [App\Http\Controllers\GenerateInvoiceController::class, 'AllInvoices_data'])->name('get_all_invoice_data');
    Route::get('get-order-details', [App\Http\Controllers\GenerateInvoiceController::class, 'getOrderDetails'])->name('get-order-details');
    Route::post('create_factory_invoice', [App\Http\Controllers\GenerateInvoiceController::class, 'create_invoice'])->name('create_factory_invoice');
    Route::get('invoice/edit/{id}', [App\Http\Controllers\GenerateInvoiceController::class, 'edit'])->name('invoice_edit');
    Route::get('invoice/delete/{id}', [App\Http\Controllers\GenerateInvoiceController::class, 'delete'])->name('invoice.delete');
    Route::get('invoice/sendApproval/{id}', [App\Http\Controllers\GenerateInvoiceController::class, 'sendApproval'])->name('invoice.sendApproval');
    Route::get('get-order-details2', [App\Http\Controllers\GenerateInvoiceController::class, 'getOrderDetails2'])->name('get-order-details2');
    Route::post('group_approval', [App\Http\Controllers\GenerateInvoiceController::class, 'groupApproval'])->name('group_approval');
    Route::post('get_multiple_invoice_details', [App\Http\Controllers\GenerateInvoiceController::class, 'get_multiple_invoice_details'])->name('get_multiple_invoice_details');
    Route::post('do_pay_multiple_invoice', [App\Http\Controllers\GenerateInvoiceController::class, 'do_pay_multiple_invoice'])->name('do_pay_multiple_invoice');
    Route::post('request_multiple_invoice', [App\Http\Controllers\GenerateInvoiceController::class, 'request_multiple_invoice'])->name('request_multiple_invoice');
    Route::get('download_multiple_invoices', [App\Http\Controllers\GenerateInvoiceController::class, 'download_multiple_invoices'])->name('download_multiple_invoices');

    Route::get('chart_of_accounts/debit_account', [App\Http\Controllers\AccountingController::class, 'debit_account'])->name('chart_of_accounts.debit_account');
    Route::get('chart_of_accounts/finacial_year', [App\Http\Controllers\AccountingController::class, 'finacial_year'])->name('chart_of_accounts.finacial_year');
    Route::get('bulk_invoices', [App\Http\Controllers\AccountingController::class, 'bulk_invoices'])->name('bulk_invoices');
    Route::post('chart_of_accounts/save_debit_record', [App\Http\Controllers\AccountingController::class, 'save_debit_record'])->name('chart_of_accounts.save_debit_record');

    Route::post('chart_of_accounts/save_finacial_year', [App\Http\Controllers\AccountingController::class, 'save_finacial_year'])->name('chart_of_accounts.save_finacial_year');
    Route::get('createInvoice', [App\Http\Controllers\AccountingController::class, 'createInvoice']);

    Route::post('create_bulk_invoice', [App\Http\Controllers\AccountingController::class, 'create_bulk_invoice'])->name('create_bulk_invoice');
    Route::post('pay_bulk_invoice', [App\Http\Controllers\AccountingController::class, 'pay_bulk_invoice'])->name('pay_bulk_invoice');
    Route::get('get_bulk_invoice_details', [App\Http\Controllers\AccountingController::class, 'get_bulk_invoice_details'])->name('get_bulk_invoice_details');

    Route::get('terms', function () {return view('pages.accounting.agreements.terms');});
    Route::get('privacy', function() {return view('pages.accounting.agreements.privacy');});


    // Accounting - Generate Invoice
    Route::get('payable_invoice', [App\Http\Controllers\PayableInvoiceController::class, 'index'])->name('payable_invoice');
    Route::post('invoice/approve/{id}', [App\Http\Controllers\PayableInvoiceController::class, 'approve'])->name('invoice_approve');

    Route::get('invoice/payed/{id}', [App\Http\Controllers\PayableInvoiceController::class, 'payed'])->name('invoice.payed');
    Route::post('invoice/reject/{invoiceId}', [App\Http\Controllers\PayableInvoiceController::class, 'reject'])->name('invoice.reject');
    Route::get('invoice/group/{groupId}', [App\Http\Controllers\PayableInvoiceController::class, 'invoiceGroup'])->name('invoiceGroup');
    Route::get('group_approve', [App\Http\Controllers\PayableInvoiceController::class, 'groupApprove'])->name('group_approve');
    Route::post('invoice/groupReject/{invoiceGroupId}', [App\Http\Controllers\PayableInvoiceController::class, 'groupReject'])->name('invoice.groupReject');
    Route::get('invoice/groupPayed/{groupId}', [App\Http\Controllers\PayableInvoiceController::class, 'groupPayed'])->name('invoice.groupPayed');


    //Additional Payments
    Route::get('additional_payment', [App\Http\Controllers\AdditionalPaymentController::class, 'index'])->name('additional_payment');
    Route::post('additional_payment/create', [App\Http\Controllers\AdditionalPaymentController::class, 'create'])->name('additional_payment.create');
    Route::post('additional_payment/edit', [App\Http\Controllers\AdditionalPaymentController::class, 'edit'])->name('additional_payment.edit');
    Route::get('additionPayment/delete/{id}', [App\Http\Controllers\AdditionalPaymentController::class, 'delete'])->name('additionPayment.delete');

    //Admin Product Catalog
    Route::get('admin_product_catalog', [App\Http\Controllers\CustomerPortalController::class, 'portal'])->name('admin_product_catlog');
    Route::get('admin_product_catalog/products/{id}/{type}', [App\Http\Controllers\CustomerPortalController::class, 'portal_product'])->name('portal_product');
    Route::match(['get', 'post'],'adminProductFilter', [App\Http\Controllers\CustomerPortalController::class, 'adminProductFilter'])->name('adminProductFilter');
    Route::get('productSearchAdminCatalog/search', [App\Http\Controllers\CustomerPortalController::class, 'productSearchAdminCatalog'])->name('productSearchAdminCatalog');

    Route::get('superadmin/enquiries-data', [App\Http\Controllers\HomeController::class, 'getEnquiriesData'])->name('superadmin.enquiries.data');
    Route::get('superadmin/dashboard-emails', [App\Http\Controllers\HomeController::class, 'getDashboardEmails'])->name('superadmin.dashboard.emails');
    Route::get('superadmin/orders-production-data', [App\Http\Controllers\HomeController::class, 'getOrdersInProductionData'])->name('superadmin.orders-production.data');
    Route::get('/superadmin/dashboard/meetings', [App\Http\Controllers\HomeController::class, 'getDashboardMeetings'])->name('superadmin.dashboard.meetings');

    //customer enquiries
    Route::get('customer_enquiries', [App\Http\Controllers\CustomerEnquiryController::class, 'customer_enquiries'])->name('customer_enquiries');
    Route::get('customer_enquiries/getData', [App\Http\Controllers\CustomerEnquiryController::class, 'getData'])->name('getData');

    //customer catalog enquiries
    Route::get('enquiries', [App\Http\Controllers\EnquiryController::class, 'enquiries'])->name('enquiries');
    Route::get('subscribers', [App\Http\Controllers\EnquiryController::class, 'subscribers'])->name('subscribers');
    Route::get('/enquiries/{id}', [App\Http\Controllers\EnquiryController::class, 'getEnquiry'])->name('enquiries.get');

    //Reports
    Route::get('reports', [App\Http\Controllers\ReportController::class, 'index'])->name('reports');
    Route::get('sales_summary', [App\Http\Controllers\ReportController::class, 'sales_summary'])->name('reports.sales_summary');
    Route::get('barChartLead/{selectedYear}', [App\Http\Controllers\ReportController::class, 'UpdateBarChartLead'])->name('barChartLead');
    Route::get('pieChartLead/{selectedYear}', [App\Http\Controllers\ReportController::class, 'UpdatePieChartLead'])->name('pieChartLead');
    Route::get('leadRepostTable', [App\Http\Controllers\ReportController::class, 'leadRepostTable'])->name('leadRepostTable');
    Route::get('/viewOrder_pdf', [App\Http\Controllers\ReportController::class, 'viewOrder'])->name('viewOrder_pdf');
	Route::get('reportCSV_Download/{selectedYear}/{selectedcategory}', [App\Http\Controllers\ReportController::class, 'csvReport'])->name('reportCSV_Download');
	Route::get('reportCSV_Download_withMonth/{selectedYear}/{selectedCategory}/{selectedMonth}', [App\Http\Controllers\ReportController::class, 'csvReportIndex'])->name('reportCSV_Download_withMonth');
    Route::get('account_receivable_report', [App\Http\Controllers\ReportController::class, 'AR_Reports'])->name('reports.ar_report');
    Route::post('get_ar_report_data', [App\Http\Controllers\ReportController::class, 'get_ar_report_data'])->name('get_ar_report_data');
    Route::get('canceled_order_report', [App\Http\Controllers\ReportController::class, 'canceled_order_report'])->name('reports.canceled_order_report');
    Route::post('get_canceled_order_report', [App\Http\Controllers\ReportController::class, 'get_canceled_order_report_data'])->name('get_canceled_order_report_data');
    Route::get('customer_sales', [App\Http\Controllers\ReportController::class, 'cu_sales_summary'])->name('reports.cu_sales_summary');
    Route::post('get_cu_sales_summary_data', [App\Http\Controllers\ReportController::class, 'get_cu_sales_summary_data'])->name('get_cu_sales_summary_data');
    Route::get('compared_Reports', [App\Http\Controllers\ReportController::class, 'compared_Reports'])->name('reports.compared_Reports');
    Route::post('get_summary_report_data', [App\Http\Controllers\ReportController::class, 'get_summary_report_data'])->name('get_summary_report_data');
    Route::post('make_compare_report', [App\Http\Controllers\ReportController::class, 'make_compare_report'])->name('make_compare_report');

    Route::post('/sales-tax/export', function (\Illuminate\Http\Request $request) {
        $fileName = 'Sales_Tax_Report_'.date('Y-m-d_H-i-s').'.xlsx';
        return Excel::download(new SalesTaxReportExport($request->start_date, $request->end_date), $fileName);
    })->name('sales.tax.export');

	Route::get('Sales_Tax_Report', [App\Http\Controllers\ReportController::class, 'Sales_Tax_Report'])->name('reports.Sales_Tax_Report');
    Route::get('report/organizations_with_orders', [App\Http\Controllers\ReportController::class, 'OrganizationsWithOrders'])->name('reports.organizations_with_orders');
    Route::get('report/organizations_with_orders_export', [App\Http\Controllers\ReportController::class, 'OrganizationsWithOrdersExport'])->name('reports.organizations_with_orders_export');
    Route::get('report/organizations_with_orders_export_yearly', [App\Http\Controllers\ReportController::class, 'OrganizationsWithOrdersExportYearly'])->name('reports.organizations_with_orders_export_yearly');
    Route::get('report/org_wise_product_report', [App\Http\Controllers\ReportController::class, 'org_wise_product_report'])->name('reports.org_wise_product_report');
    Route::get('report/order_embellishments_report', [App\Http\Controllers\ReportController::class, 'order_embellishments_report'])->name('reports.order_embellishments_report');
    Route::get('report/org_wise_product_report_export', [App\Http\Controllers\ReportController::class, 'org_wise_product_report_export'])->name('reports.org_wise_product_report_export');
    Route::post('sales-tax-report/data', [App\Http\Controllers\ReportController::class, 'Sales_Tax_Report_getData']) ->name('sales.tax.report.data');

    Route::get('sales_activity_report', [App\Http\Controllers\ReportController::class, 'sales_activity_report'])->name('reports.sales_activity_report.index');
    Route::post('/sales-activity/filter', [App\Http\Controllers\ReportController::class, 'filter_sales_activity'])->name('sales.activity.filter');
    Route::post('sales_summary/exportCsv', [App\Http\Controllers\ReportController::class, 'exportCsv'])->name('reports.exportCsv');

    //Analytical Summary Report
    Route::get('analytical_summary_report', [App\Http\Controllers\AnalyticalSummaryReportController::class, 'index'])->name('reports.analytical_summary_report.index');
    Route::get('get/rep_summary_table_data', [App\Http\Controllers\AnalyticalSummaryReportController::class, 'getSalesRepOrders'])->name('reports.rep_summary_table_data');
    Route::get('get/sports_summary_table_data', [App\Http\Controllers\AnalyticalSummaryReportController::class, 'getOrdersGroupedBySport'])->name('reports.sports_summary_table_data');
    Route::get('get/leadSource_summary_table_data', [App\Http\Controllers\AnalyticalSummaryReportController::class, 'getOrdersGroupedByLeadSource'])->name('reports.lead_summary_table_data');
    Route::get('get/factory_summary_table_data', [App\Http\Controllers\AnalyticalSummaryReportController::class, 'getOrdersGroupedByFactory'])->name('reports.factory_summary_table_data');
    Route::get('get/tsvsbulk_summary_table_data', [App\Http\Controllers\AnalyticalSummaryReportController::class, 'getOrdersSummary'])->name('reports.tsvsbulk_summary_table_data');
    Route::get('get/newvsrepeated_cu_summary_table_data', [App\Http\Controllers\AnalyticalSummaryReportController::class, 'getOrdersByOrganizations'])->name('reports.newvsrepeated_cu_summary_table_data');
    Route::get('get/country_summary_table_data', [App\Http\Controllers\AnalyticalSummaryReportController::class, 'getOrdersGroupedByCountry'])->name('reports.country_summary_table_data');
    Route::get('get/exportReport', [App\Http\Controllers\AnalyticalSummaryReportController::class, 'exportReport'])->name('reports.exportReport');


    Route::post('save_summary_report_data', [App\Http\Controllers\ReportController::class, 'save_summary_report_data'])->name('save_summary_report_data');
    Route::post('save_ar_report_data', [App\Http\Controllers\ReportController::class, 'save_ar_report_data'])->name('save_ar_report_data');

    //Customer Payment Summary
    Route::get('customerPayment', [App\Http\Controllers\ReportCustomerPaymentController::class, 'index'])->name('customerPayment');
    Route::get('filterCustomerPayment', [App\Http\Controllers\ReportCustomerPaymentController::class, 'filterCustomerPayment'])->name('filterCustomerPayment');
	Route::get('customerPayment_CSV_download/{startDate}/{endDate}/{paymentType}/{SelectedPaymentStatus}', [App\Http\Controllers\ReportCustomerPaymentController::class, 'customerPayment_CSV_download'])->name('customerPayment_CSV_download');

    //Sales Invoice Summary
    Route::get('salesInvoice', [App\Http\Controllers\ReportSalesInvoiceController::class, 'index'])->name('salesInvoice');
    Route::get('filterSalesInvoice', [App\Http\Controllers\ReportSalesInvoiceController::class, 'filterSalesInvoice'])->name('filterSalesInvoice');
	Route::get('salesInvoice_CSV_download/{startDate}/{endDate}/{paymentType}/{paymentStatus}', [App\Http\Controllers\ReportSalesInvoiceController::class, 'salesInvoice_CSV_download'])->name('salesInvoice_CSV_download');


    //Order Summary
    Route::get('orderSummary', [App\Http\Controllers\ReportOrderSummaryController::class, 'index'])->name('orderSummary');
    Route::get('filterOrderSummary', [App\Http\Controllers\ReportOrderSummaryController::class, 'filterOrderSummary'])->name('filterOrderSummary');
    Route::post('orderSummarySearchOrder', [App\Http\Controllers\ReportOrderSummaryController::class, 'orderSummarySearchOrder'])->name('orderSummarySearchOrder');
	Route::get('orderSummary_CSV_download/{dateType}/{startDate1}/{endDate1}/{filterFactory}/{orderStatus}/{testPrint}/{paymentStatus1}', [App\Http\Controllers\ReportOrderSummaryController::class, 'orderSummary_CSV_download'])->name('orderSummary_CSV_download');

    //Encore Order Shedule Sheet
    Route::get('orderSheduleSheet', [App\Http\Controllers\ReportOrderSheduleSheetController::class, 'index'])->name('orderSheduleSheet');
    Route::get('filterOrdershedule', [App\Http\Controllers\ReportOrderSheduleSheetController::class, 'filterOrderShedule'])->name('filterOrdershedule');
    Route::post('orderSheduleColor', [App\Http\Controllers\ReportOrderSheduleSheetController::class, 'orderSheduleColor'])->name('orderSheduleColor');
    Route::post('/saveSpecialComment', [App\Http\Controllers\ReportOrderSheduleSheetController::class, 'saveSpecialComment'])->name('saveSpecialComment');
	Route::get('orderShedule_CSV_download/{selectedYear}/{selectedMonth}', [App\Http\Controllers\ReportOrderSheduleSheetController::class, 'orderShedule_CSV_download'])->name('orderShedule_CSV_download');
    Route::post('sheduleSearchOrder', [App\Http\Controllers\ReportOrderSheduleSheetController::class, 'sheduleSearchOrder'])->name('sheduleSearchOrder');

    // Dashboard Update
    Route::get('dashboard/overview-data', [App\Http\Controllers\HomeController::class, 'dashboardOverviewData'])->name('dashboard.overview-data');
    Route::get('barChartUpdateDashboard/{selectedYear}', [App\Http\Controllers\HomeController::class, 'barChartUpdateDashboard'])->name('barChartUpdateDashboard');
    Route::get('filterTotalOrders', [App\Http\Controllers\HomeController::class, 'filterTotalOrders'])->name('filterTotalOrders');
    Route::post('orderSearchOrder', [App\Http\Controllers\HomeController::class, 'orderSearchOrder'])->name('orderSearchOrder');
    Route::get('dashboardPayment', [App\Http\Controllers\HomeController::class, 'dashboardPayment'])->name('dashboardPayment');
    Route::get('dashboardInvoice', [App\Http\Controllers\HomeController::class, 'dashboardInvoice'])->name('dashboardInvoice');
    Route::get('filterActivities', [App\Http\Controllers\HomeController::class, 'filterActivities'])->name('filterActivities');
    Route::get('filterOrdersFactoryDashboard', [App\Http\Controllers\HomeController::class, 'filterOrdersFactoryDashboard'])->name('filterOrdersFactoryDashboard');
    Route::get('newOrdersFactoryDashboard', [App\Http\Controllers\HomeController::class, 'newOrdersFactoryDashboard'])->name('newOrdersFactoryDashboard');
    Route::get('urgentOrdersFactoryDashboard', [App\Http\Controllers\HomeController::class, 'urgentOrdersFactoryDashboard'])->name('urgentOrdersFactoryDashboard');
    Route::get('productionOrdersFactoryDashboard', [App\Http\Controllers\HomeController::class, 'productionOrdersFactoryDashboard'])->name('productionOrdersFactoryDashboard');
    Route::get('fulfiledOrdersFactoryDashboard', [App\Http\Controllers\HomeController::class, 'fulfiledOrdersFactoryDashboard'])->name('fulfiledOrdersFactoryDashboard');
    Route::get('PendingShipOrdersFactoryDashboard', [App\Http\Controllers\HomeController::class, 'PendingShipOrdersFactoryDashboard'])->name('PendingShipOrdersFactoryDashboard');
    Route::get('upcomingOrdersGet', [App\Http\Controllers\HomeController::class, 'upcomingOrdersGet'])->name('upcomingOrdersGet');
    Route::get('getupcomingorderdetails', [App\Http\Controllers\HomeController::class, 'getupcomingorderdetails'])->name('getupcomingorderdetails');
    Route::get('/chart-data', [App\Http\Controllers\HomeController::class, 'getChartData'])->name('chart.data');
    Route::get('/transactionsDetails/{id}', [App\Http\Controllers\HomeController::class, 'transactionsDetails'])->name('transactionsDetails');
    Route::get('/lineChartData', [App\Http\Controllers\HomeController::class, 'lineChartData'])->name('lineChartData');
    Route::get('/sales-month-details', [App\Http\Controllers\HomeController::class, 'salesMonthDetails'])->name('sales.month.details');

    //Seles Rep Dashboard
    Route::get('repDashboard/filter_search_data', [App\Http\Controllers\HomeController::class, 'filter_search_data'])->name('repDashboard.filter_search_data');
    Route::get('newOrdersRepDashboard', [App\Http\Controllers\HomeController::class, 'newOrdersRepDashboard'])->name('newOrdersRepDashboard');
    Route::get('productionOrdersRepDashboard', [App\Http\Controllers\HomeController::class, 'productionOrdersRepDashboard'])->name('productionOrdersRepDashboard');
    Route::get('fulfiledOrdersRepDashboard', [App\Http\Controllers\HomeController::class, 'fulfiledOrdersRepDashboard'])->name('fulfiledOrdersRepDashboard');
    Route::get('PendingShipOrdersRepDashboard', [App\Http\Controllers\HomeController::class, 'PendingShipOrdersRepDashboard'])->name('PendingShipOrdersRepDashboard');
    Route::get('emailLoadFromDashboard/{messageId}', [App\Http\Controllers\HomeController::class, 'emailLoadFromDashboard'])->name('emailLoadFromDashboard');
    Route::post('activities/createMeeting', [App\Http\Controllers\HomeController::class, 'createMeeting'])->name('activities.createMeeting');
    Route::post('activities/updateMeeting', [App\Http\Controllers\HomeController::class, 'updateMeeting'])->name('activities.updateMeeting');
    Route::get('meetings/get_meetings_by_date/{user_id}/{due_date}', [App\Http\Controllers\HomeController::class, 'getMeetingsByDate']);


    Route::get('teamStoreInfo', [App\Http\Controllers\TeamStoreInfoController::class, 'flyer']);

    Route::get('factory_priceList', [App\Http\Controllers\FactoryPriceListController::class, 'factoryPriceList'])->name('factory_priceList');
    Route::post('manufacturerPrice', [App\Http\Controllers\FactoryPriceListController::class, 'manufacturerPrice'])->name('manufacturerPrice');
    Route::post('subProductSearch', [App\Http\Controllers\FactoryPriceListController::class, 'subProductSearch'])->name('subProductSearch');

	Route::get('factoryPriceList_CSV_download/{activeInactive}/{pricingOrNot}/{inputValue}/{pricetype}', [App\Http\Controllers\FactoryPriceListController::class, 'factoryPriceList_CSV_download'])->name('factoryPriceList_CSV_download');
    Route::post('saveFactoryPriceFilter', [App\Http\Controllers\FactoryPriceListController::class, 'saveFactoryPriceFilter'])->name('saveFactoryPriceFilter');

    Route::get('sizing_fit', [App\Http\Controllers\SizingFitController::class, 'sizing_fit'])->name('sizing_fit');
    Route::post('saveMenSizes', [App\Http\Controllers\SizingFitController::class, 'saveMenSizes'])->name('saveMenSizes');
    Route::post('saveBoySizes', [App\Http\Controllers\SizingFitController::class, 'saveBoySizes'])->name('saveBoySizes');
    Route::post('saveWomenSizes', [App\Http\Controllers\SizingFitController::class, 'saveWomenSizes'])->name('saveWomenSizes');
    Route::post('saveGirlSizes', [App\Http\Controllers\SizingFitController::class, 'saveGirlSizes'])->name('saveGirlSizes');
    Route::post('saveMenShoeSizes', [App\Http\Controllers\SizingFitController::class, 'saveMenShoeSizes'])->name('saveMenShoeSizes');
    Route::post('saveWomenShoeSizes', [App\Http\Controllers\SizingFitController::class, 'saveWomenShoeSizes'])->name('saveWomenShoeSizes');

    Route::get('fits', [App\Http\Controllers\FitController::class, 'fits'])->name('fits');
	Route::post('fit/create', [App\Http\Controllers\FitController::class, 'create'])->name('fit.create');
    Route::post('master_fit/update', [App\Http\Controllers\FitController::class, 'update'])->name('master_fit.update');
	Route::get('master_fit/edit/{id}', [App\Http\Controllers\FitController::class, 'edit'])->name('master_fit.edit');
	Route::get('master_fit/delete', [App\Http\Controllers\FitController::class, 'delete'])->name('master_fit.delete');

    Route::get('theme_setting', [App\Http\Controllers\ThemeSettingController::class, 'index'])->name('theme_setting');
	Route::post('theme_setting/create', [App\Http\Controllers\ThemeSettingController::class, 'create'])->name('theme_setting.create');
    Route::post('theme_setting/update', [App\Http\Controllers\ThemeSettingController::class, 'update'])->name('theme_setting.update');
	Route::get('theme_setting/edit/{id}', [App\Http\Controllers\ThemeSettingController::class, 'edit'])->name('theme_setting.edit');
	Route::get('theme_setting/delete', [App\Http\Controllers\ThemeSettingController::class, 'delete'])->name('theme_setting.delete');

    Route::get('catalog_categories', [App\Http\Controllers\MainCategoryController::class, 'index'])->name('catalog_categories');
	Route::post('catalog_category/create', [App\Http\Controllers\MainCategoryController::class, 'create'])->name('catalog_category.create');
	Route::post('catalog_category/update', [App\Http\Controllers\MainCategoryController::class, 'update'])->name('catalog_category.update');
	Route::get('catalog_category/edit/{id}', [App\Http\Controllers\MainCategoryController::class, 'edit'])->name('catalog_category.edit');
	Route::get('catalog_category/delete/{id}', [App\Http\Controllers\MainCategoryController::class, 'delete'])->name('catalog_category.delete');

    Route::get('master_gender', [App\Http\Controllers\GenderController::class, 'index'])->name('master_gender');
	Route::post('gender/create', [App\Http\Controllers\GenderController::class, 'create'])->name('gender.create');
	Route::post('gender/update', [App\Http\Controllers\GenderController::class, 'update'])->name('gender.update');
	Route::get('gender/edit/{id}', [App\Http\Controllers\GenderController::class, 'edit'])->name('gender.edit');
	Route::get('gender/delete/{id}', [App\Http\Controllers\GenderController::class, 'delete'])->name('gender.delete');

    Route::get('system_api/index', [App\Http\Controllers\SystemAPIController::class, 'index'])->name('system_api.index');
    Route::get('system_api/get_table_data', [App\Http\Controllers\SystemAPIController::class, 'get_table_data'])->name('system_api.get_table_data');
    Route::post('system_api/store', [App\Http\Controllers\SystemAPIController::class, 'store'])->name('system_api.store');
    Route::get('system_api/edit/{id}', [App\Http\Controllers\SystemAPIController::class, 'edit'])->name('system_api.edit');
    Route::post('system_api/update/{id}', [App\Http\Controllers\SystemAPIController::class, 'update'])->name('system_api.update');
    Route::post('system_api/change_status', [App\Http\Controllers\SystemAPIController::class, 'update'])->name('system_api.change_status');
    Route::get('system_api/delete/{id}', [App\Http\Controllers\SystemAPIController::class, 'delete'])->name('system_api.delete');

    // normal user dashboard
    Route::get('/user-dashboard', [App\Http\Controllers\UserDashboardController::class, 'index'])->name('user.dashbord');
    Route::get('/get-user-projects', [App\Http\Controllers\UserDashboardController::class, 'getProjects'])->name('user.projects');
    Route::get('/task/list', [App\Http\Controllers\UserDashboardController::class, 'getTasks'])->name('task.list');
    Route::get('/my-leaves', [App\Http\Controllers\UserDashboardController::class, 'myLeaves'])->name('my-leaves');
    Route::get('/my-leaves-pending', [App\Http\Controllers\UserDashboardController::class, 'myLeavesPending'])->name('my-leaves-pending');
    Route::get('/others-leaves', [App\Http\Controllers\UserDashboardController::class, 'othersLeaves'])->name('others-leaves');
    Route::get('/my-meetings', [App\Http\Controllers\UserDashboardController::class, 'myMeetings'])->name('my-meetings');

});

// use App\Http\Controllers\EMController;

// Route::get('/schedules', [EMController::class, 'index'])->name('schedules.index');

// Route::get('/schedules/packages/create', [EMController::class, 'createPackage'])->name('em.packages.create');
// Route::post('/schedules/packages', [EMController::class, 'storePackage'])->name('em.packages.store');
// Route::get('/schedules/packages/{id}/edit', [EMController::class, 'editPackage'])->name('em.packages.edit');
// Route::put('/schedules/packages/{id}', [EMController::class, 'updatePackage'])->name('em.packages.update');
// Route::delete('/schedules/packages/{id}', [EMController::class, 'destroyPackage'])->name('em.packages.destroy');

// Route::get('/schedules/sessions/create', [EMController::class, 'createSession'])->name('em.sessions.create');
// Route::post('/schedules/sessions', [EMController::class, 'storeSession'])->name('em.sessions.store');
// Route::get('/schedules/sessions/{id}/edit', [EMController::class, 'editSession'])->name('em.sessions.edit');
// Route::put('/schedules/sessions/{id}', [EMController::class, 'updateSession'])->name('em.sessions.update');
// Route::delete('/schedules/sessions/{id}', [EMController::class, 'destroySession'])->name('em.sessions.destroy');

// Route::get('/schedules/calendar/events', [EMController::class, 'calendarEvents'])->name('em.calendar.events');

// use App\Http\Controllers\EMCustomerController;

// Route::prefix('book_my_sessions')->name('em.customer.')->group(function () {
//     Route::get('/packages', [EMCustomerController::class, 'packages'])->name('packages');
//     Route::get('/packages/{id}', [EMCustomerController::class, 'packageDetails'])->name('package.details');

//     Route::get('/login', [EMCustomerController::class, 'login'])->name('login');
//     Route::post('/login', [EMCustomerController::class, 'loginSubmit'])->name('login.submit');
//     Route::get('/register', [EMCustomerController::class, 'register'])->name('register');
//     Route::post('/register', [EMCustomerController::class, 'registerSubmit'])->name('register.submit');

//     // Add these if your login page / landing page has Google login button
//     Route::get('/google', [EMCustomerController::class, 'googleRedirect'])->name('google');
//     Route::get('/google/callback', [EMCustomerController::class, 'googleCallback'])->name('google.callback');

//     Route::middleware(['em.customer'])->group(function () {
//         Route::get('/', [EMCustomerController::class, 'landingIndex'])->name('index');
//         Route::get('/dashboard', [EMCustomerController::class, 'dashboard'])->name('dashboard');

//         // ✅ Missing route causing your error
//         Route::post('/logout', [EMCustomerController::class, 'logout'])->name('logout');

//         Route::post('/cart/add/{id}', [EMCustomerController::class, 'addToCart'])->name('cart.add');
//         Route::get('/cart', [EMCustomerController::class, 'cart'])->name('cart');
//         Route::post('/cart/{id}', [EMCustomerController::class, 'updateCart'])->name('cart.update');
//         Route::delete('/cart/{id}', [EMCustomerController::class, 'removeCart'])->name('cart.remove');

//         Route::get('/checkout', [EMCustomerController::class, 'checkout'])->name('checkout');
//         Route::post('/pay', [EMCustomerController::class, 'pay'])->name('pay');
//         Route::get('/payment-success/{orderId}', [EMCustomerController::class, 'paymentSuccess'])->name('payment.success');

//         Route::get('/my-bookings', [EMCustomerController::class, 'bookings'])->name('bookings');
//         Route::post('/booking/{id}/cancel', [EMCustomerController::class, 'cancelBooking'])->name('booking.cancel');
//         Route::post('/session/{id}/book', [EMCustomerController::class, 'bookSession'])->name('session.book');

//         Route::get('/profile', [EMCustomerController::class, 'profile'])->name('profile');
//         Route::post('/profile', [EMCustomerController::class, 'updateProfile'])->name('profile.update');

//         Route::get('/calendar-events', [EMCustomerController::class, 'calendarEvents'])->name('calendar.events');
//     });
// });

// Route::prefix('book_my_sessions/landing')
//     ->name('em.customer.landing.')
//     ->group(function () {
//         Route::get('/', [EMCustomerController::class, 'landingIndex'])->name('index');

//         Route::get('/packages', [EMCustomerController::class, 'landingPackages'])->name('packages');
//         Route::get('/packages/{id}', [EMCustomerController::class, 'landingPackageDetails'])->name('package.details');

//         Route::middleware(['em.customer'])->group(function () {
//             Route::post('/cart/add/{id}', [EMCustomerController::class, 'landingAddToCart'])->name('cart.add');
//             Route::get('/cart', [EMCustomerController::class, 'landingCart'])->name('cart');
//             Route::post('/cart/{id}', [EMCustomerController::class, 'landingUpdateCart'])->name('cart.update');
//             Route::delete('/cart/{id}', [EMCustomerController::class, 'landingRemoveCart'])->name('cart.remove');

//             Route::get('/checkout', [EMCustomerController::class, 'landingCheckout'])->name('checkout');
//             Route::post('/checkout/pay', [EMCustomerController::class, 'landingPay'])->name('pay');
//             Route::get('/payment-success/{orderId}', [EMCustomerController::class, 'landingPaymentSuccess'])->name('payment.success');
//         });
//     });


Route::get('customerSizing', [App\Http\Controllers\SizingFitController::class, 'customerSizing'])->name('customerSizing');

// Store routes
Route::get('store/customer_order_view/{id}', [App\Http\Controllers\StoreController::class, 'customer_order_view'])->name('store.customer_order_view');
Route::get('store/download_order_receipt', [App\Http\Controllers\StoreController::class, 'download_order_receipt'])->name('store.download_order_receipt');


//Product catlog
Route::get('product_catalog/quote', [App\Http\Controllers\ProductCatlogController::class, 'quote'])->name('product_quote');
Route::get('product_catalog/view_user_quotes', [App\Http\Controllers\ProductCatlogController::class, 'view_user_quotes'])->name('view_user_quotes');
Route::get('product_catalog/add_to_quote', [App\Http\Controllers\ProductCatlogController::class, 'add_to_quote'])->name('product_addto_quotes');
Route::get('product_catalog/find_quote', [App\Http\Controllers\ProductCatlogController::class, 'find_quote'])->name('find_quote');
Route::get('product_catalog/remove_quote_item', [App\Http\Controllers\ProductCatlogController::class, 'remove_quote_item'])->name('product_removefrom_quotes');
Route::get('product_catalog/count_records', [App\Http\Controllers\ProductCatlogController::class, 'count_records'])->name('count_records');
Route::get('product_catalog/buttontext', [App\Http\Controllers\ProductCatlogController::class, 'buttontext'])->name('buttontext');
Route::get('product_catalog/submit_query', [App\Http\Controllers\ProductCatlogController::class, 'submit_query'])->name('submit_query');
Route::get('product_catalog', [App\Http\Controllers\ProductCatlogController::class, 'index'])->name('product_catlog');
Route::get('product_catalog/filter', [App\Http\Controllers\ProductCatlogController::class, 'filter'])->name('product_filter');
Route::get('product_catalog/search', [App\Http\Controllers\ProductCatlogController::class, 'search'])->name('product_search');
Route::get('product_catalog/{id}', [App\Http\Controllers\ProductCatlogController::class, 'show'])->name('product_view');

Route::get('get_all_permissions', [App\Http\Controllers\CustomWorkController::class, 'get_all_permissions']);
Route::get('get_all_custom_user_permissions/{userId}', [App\Http\Controllers\CustomWorkController::class, 'get_all_custom_user_permissions']);
Route::get('get_role_has_permissions/{roleId}', [App\Http\Controllers\CustomWorkController::class, 'get_role_has_permissions']);
Route::get('get_user_role', [App\Http\Controllers\CustomWorkController::class, 'get_user_role']);
Route::get('get_permission_has_role/{id}', [App\Http\Controllers\CustomWorkController::class, 'get_permission_has_role']);
Route::get('create_role/{roleName}', [App\Http\Controllers\CustomWorkController::class, 'create_role']);
Route::get('create_permission/{permissionName}', [App\Http\Controllers\CustomWorkController::class, 'create_permission']);
Route::get('user_role_details', [App\Http\Controllers\CustomWorkController::class, 'user_role_details']);
Route::get('set_permission_to_role/{permissionName}/{roleId}', [App\Http\Controllers\CustomWorkController::class, 'set_permission_to_role']);
Route::get('set_role_to_user/{roleName}', [App\Http\Controllers\CustomWorkController::class, 'set_role_to_user']);
Route::get('remove_role_from_user/{roleName}', [App\Http\Controllers\CustomWorkController::class, 'remove_role_from_user']);
Route::get('sync_inbox_count', [App\Http\Controllers\EmailController::class, 'getNewInboxCount']);
Route::get('sync_draft_count', [App\Http\Controllers\EmailController::class, 'getNewDraftCount']);
Route::get('sync_spam_count', [App\Http\Controllers\EmailController::class, 'getNewSpamCount']);
Route::get('change_flag_by_crone_job', [App\Http\Controllers\OrderController::class, 'changeFlagByCroneJob']);

Route::get('name_all', [App\Http\Controllers\ActivityController::class, 'nameAll']);

Route::post('order_details/get_item_product_details', [App\Http\Controllers\OrderDetailsController::class, 'getItemProductDetails']);
Route::post('order_details/get_item_ExFactoryDate_log', [App\Http\Controllers\OrderDetailsController::class, 'getitem_ExFactoryDatelog']);
Route::post('order_details/add_item_ExFactoryDate_log', [App\Http\Controllers\OrderDetailsController::class, 'additem_ExFactoryDatelog']);
Route::post('order_details/get_product_mockup_images', [App\Http\Controllers\OrderDetailsController::class, 'getProductMockupImages']);

Route::get('runScript', [App\Http\Controllers\RunScript::class, 'runScriptOne']);
Route::get('runScript2', [App\Http\Controllers\RunScript::class, 'runScriptTwo']);

Route::get('get_inhanddates', [App\Http\Controllers\CustomWorkController::class, 'get_inhanddates']);
Route::get('get_password', [App\Http\Controllers\CustomWorkController::class, 'get_password']);


Route::get('customer_catalog', [App\Http\Controllers\CustomerProductCatlogController::class, 'index'])->name('customer_catlog');
Route::match(['get', 'post'],'product_filter', [App\Http\Controllers\CustomerProductCatlogController::class, 'productFilter'])->name('product_filter1');
Route::match(['get', 'post'],'productFilter', [App\Http\Controllers\CustomerProductCatlogController::class, 'product_filter'])->name('productFilter1');
Route::match(['get', 'post'], 'search', [App\Http\Controllers\CustomerProductCatlogController::class, 'productSearch'])->name('search.products');

Route::get('upload_product_images', [App\Http\Controllers\CustomerProductCatlogController::class, 'upload_product_images'])->name('upload_product_images');

Route::get('productDetails/{id}', [App\Http\Controllers\CustomerProductCatlogController::class, 'productDetails'])->name('product.show');
Route::get('filterEmbellishment', [App\Http\Controllers\CustomerProductCatlogController::class, 'filterEmbellishment'])->name('filterEmbellishment');
Route::get('getFabricDetails', [App\Http\Controllers\CustomerProductCatlogController::class, 'getFabricDetails'])->name('getFabricDetails');
Route::get('getEmbellishmentDetails', [App\Http\Controllers\CustomerProductCatlogController::class, 'getEmbellishmentDetails'])->name('getEmbellishmentDetails');
Route::get('getColorDetails', [App\Http\Controllers\CustomerProductCatlogController::class, 'getColorDetails'])->name('getColorDetails');
Route::get('getTaglineDetails', [App\Http\Controllers\CustomerProductCatlogController::class, 'getTaglineDetails'])->name('getTaglineDetails');

Route::get('check_lost_payment_orders', [App\Http\Controllers\CustomWorkController::class, 'check_lost_payment_orders']);

//Latest customer portal

// Route::get('customer_portal', [App\Http\Controllers\NewCustomerPortalController::class, 'common'])->name('customer_portal.common');
Route::get('customer_portal/login', [App\Http\Controllers\NewCustomerPortalController::class, 'login'])->name('customer_portal.login');
// Route::get('customer_portal/dashboard', [App\Http\Controllers\NewCustomerPortalController::class, 'dashboard'])->name('customer_portal.dashboard');
// Route::get('customer_portal/orders', [App\Http\Controllers\NewCustomerPortalController::class, 'orders'])->name('customer_portal.orders');
// Route::get('customer_portal/payments', [App\Http\Controllers\NewCustomerPortalController::class, 'payments'])->name('customer_portal.payments');
// Route::get('customer_portal/payment_edit', [App\Http\Controllers\NewCustomerPortalController::class, 'payment_edit'])->name('customer_portal.payment_edit');
// Route::get('customer_portal/shipping', [App\Http\Controllers\NewCustomerPortalController::class, 'shipping'])->name('customer_portal.shipping');
// Route::get('customer_portal/settings', [App\Http\Controllers\NewCustomerPortalController::class, 'settings'])->name('customer_portal.settings');
// Route::get('customer_portal/order_view/{id}', [App\Http\Controllers\NewCustomerPortalController::class, 'order_view'])->name('customer_portal.order_view');
Route::post('customer_portal/customer_roster_update', [App\Http\Controllers\NewCustomerPortalController::class, 'roster_update'])->name('customer_portal.roster_update');
Route::post('customer_portal/receiver_address_update', [App\Http\Controllers\NewCustomerPortalController::class, 'receiver_address_update'])->name('customer_portal.receiver_address_update');
// Route::get('customer_portal/orders/{order}', [App\Http\Controllers\NewCustomerPortalController::class, 'showDetails'])->name('orders.showDetails');
// Route::get('customer_portal/orders/item/details', [App\Http\Controllers\NewCustomerPortalController::class, 'orderItemview'])->name('orders.itemDetails');
// Route::get('customer_portal/payments/individual_payment', [App\Http\Controllers\NewCustomerPortalController::class, 'individual_payment'])->name('payments.individual_payment');

Route::get('new_payment_summary_update', [App\Http\Controllers\OrderDetailsController::class, 'new_payment_summary_update']);


Route::post('customer_portal/portal_login', [App\Http\Controllers\NewCustomerPortalController::class, 'portal_login'])->name('customer_portal.portal_login');
Route::get('customer_portal/logout', [App\Http\Controllers\NewCustomerPortalController::class, 'logout'])->name('customer_portal.portal_logout');

Route::group(['middleware' => 'customer.portal.auth'], function () {
    Route::post('customer_portal/acknowledge-order-notice', [App\Http\Controllers\NewCustomerPortalController::class, 'acknowledgeOrderNotice'])->name('customer_portal.acknowledge_order_notice');
    Route::get('customer_portal/order_view/{id}', [App\Http\Controllers\NewCustomerPortalController::class, 'order_view'])->name('customer_portal.order_view');
    Route::get('customer_portal/dashboard', [App\Http\Controllers\NewCustomerPortalController::class, 'dashboard'])->name('customer_portal.dashboard');
    Route::get('/dashboard/order-tracking-chart-data',[App\Http\Controllers\NewCustomerPortalController::class, 'getOrderTrackingChartData'])->name('dashboard.chart.order-tracking');
    Route::get('/dashboard/getOrderSummaryChart',[App\Http\Controllers\NewCustomerPortalController::class, 'getOrderSummaryChart'])->name('dashboard.chart.order-summary');
    Route::get('customer_portal/orders', [App\Http\Controllers\NewCustomerPortalController::class, 'orders'])->name('customer_portal.orders');
    Route::get('customer_portal/orders/{order}', [App\Http\Controllers\NewCustomerPortalController::class, 'showDetails'])->name('orders.showDetails');
    Route::get('customer_portal/order_tracking', [App\Http\Controllers\NewCustomerPortalController::class, 'order_tracking'])->name('orders.order_tracking');
    Route::get('customer_portal/get/order_tracking', [App\Http\Controllers\NewCustomerPortalController::class, 'get_order_tracking'])->name('orders.get_order_tracking');
    Route::get('/customer/orders/track', function () {return view('pages.customer_portal.order.order_tracking');})->name('customer.orders.track');

    Route::get('customer_portal/orders/item/details', [App\Http\Controllers\NewCustomerPortalController::class, 'orderItemview'])->name('orders.itemDetails');
    Route::get('customer_portal/payments/individual_payment', [App\Http\Controllers\NewCustomerPortalController::class, 'individual_payment'])->name('payments.individual_payment');
    Route::get('customer_portal/payments/bulk_invoices_payment', [App\Http\Controllers\NewCustomerPortalController::class, 'bulk_invoices'])->name('payments.bulk_invoices');
    Route::get('customer_portal/individual_payment/payments', [App\Http\Controllers\NewCustomerPortalController::class, 'payments'])->name('customer_portal.payments');
    Route::get('customer_portal/payment_edit', [App\Http\Controllers\NewCustomerPortalController::class, 'payment_edit'])->name('customer_portal.payment_edit');
    Route::get('customer_portal/order/{order}/techpack-check', [App\Http\Controllers\NewCustomerPortalController::class, 'techpackCheck'])->name('customer.order.techpack-check');
    Route::get('customer_portal/shipping', [App\Http\Controllers\NewCustomerPortalController::class, 'shipping'])->name('customer_portal.shipping');
    Route::get('customer_portal/settings', [App\Http\Controllers\NewCustomerPortalController::class, 'settings'])->name('customer_portal.settings');
    Route::post('customer_portal/organization/update/{id}', [App\Http\Controllers\NewCustomerPortalController::class, 'Org_update'])->name('customer_portal.Org_update');
    Route::post('/customer_portal/{id}/update-logo', [App\Http\Controllers\NewCustomerPortalController::class, 'updateLogo'])->name('customer_portal.updateLogo');
    Route::get('customer_portal', [App\Http\Controllers\NewCustomerPortalController::class, 'common'])->name('customer_portal.common');
    Route::get('customer_portal/customer_support', [App\Http\Controllers\NewCustomerPortalController::class, 'customer_support'])->name('customer_portal.customer_support');
    Route::get('customer_portal/export_number_roster_template/{orderItemId}', [App\Http\Controllers\NewCustomerPortalController::class, 'exportNumberRosterTemplate'])->name('customer_portal.export_number_roster_template');
    Route::post('customer_portal/import_number_roster', [App\Http\Controllers\NewCustomerPortalController::class, 'importNumberRoster'])->name('customer_portal.import_number_roster');
    Route::get('/customer-portal/pay-multiple-orders', [App\Http\Controllers\NewCustomerPortalController::class, 'payMultipleOrders'])->name('customer_portal.pay_multiple_orders');
    Route::get('customer_portal/export_name_roster_template/{orderItemId}', [App\Http\Controllers\NewCustomerPortalController::class, 'exportNameRosterTemplate'])->name('customer_portal.export_name_roster_template');
    Route::post('customer_portal/import_name_roster', [App\Http\Controllers\NewCustomerPortalController::class, 'importNameRoster'])->name('customer_portal.import_name_roster');

    Route::get('customer_portal/export_number_with_name_roster_template/{orderItemId}', [App\Http\Controllers\NewCustomerPortalController::class, 'exportNumberWithNameRosterTemplate'])->name('customer_portal.export_number_with_name_roster_template');
    Route::post('customer_portal/import_number_with_name_roster', [App\Http\Controllers\NewCustomerPortalController::class, 'importNumberWithNameRoster'])->name('customer_portal.import_number_with_name_roster');

    Route::get('customer_portal/export_order_roster_template/{orderId}', [App\Http\Controllers\NewCustomerPortalController::class, 'exportOrderRosterTemplate'])->name('customer_portal.export_order_roster_template');
    Route::post('customer_portal/import_order_roster', [App\Http\Controllers\NewCustomerPortalController::class, 'importOrderRoster'])->name('customer_portal.import_order_roster');
    Route::post('orders/approve-production', [App\Http\Controllers\NewCustomerPortalController::class, 'approveProduction'])->name('approve.production');

    Route::post('customer_portal/customer/shipment/received', [App\Http\Controllers\NewCustomerPortalController::class, 'markAsReceived'])->name('customer.markAsReceived');
    Route::post('customer_portal/customer/shipment/enquiry', [App\Http\Controllers\NewCustomerPortalController::class, 'sendShipmentEnquiry'])->name('customer.shipmentEnquiry');

    Route::get('customer_portal/shipment-details/{trackingNo}', [App\Http\Controllers\NewCustomerPortalController::class, 'Shippingdetails'])->name('customer.Shippingdetails');


    Route::post('customer_portal/payment/bulk', [App\Http\Controllers\BulkPaymentController::class, 'customer_payment_bulk'])->name('customer_payment_bulk');


    // new customer support
    Route::post('/customer/support/select-department', [App\Http\Controllers\CustomerSupportController::class, 'selectDepartment'])
    ->name('customer.support.select-department');

Route::post('/customer/support/send-message', [App\Http\Controllers\CustomerSupportController::class, 'sendMessage'])
    ->name('customer.support.send-message');

Route::get('/customer/support/messages/{conversation}', [App\Http\Controllers\CustomerSupportController::class, 'messages'])
    ->name('customer.support.messages');

Route::get('/customer/support/poll', [App\Http\Controllers\CustomerSupportController::class, 'poll'])
    ->name('customer.support.poll');


});

Route::post('store/download_store_flyer', [App\Http\Controllers\StoreController::class, 'download_store_flyer'])->name('store.download_store_flyer');
Route::get('store/downlod_store_refunds', [App\Http\Controllers\StoreController::class, 'downlod_store_refunds'])->name('store.downlod_store_refunds');

Route::get('getTransactionDetails/{transactionID}', [App\Http\Controllers\CustomerTeamStoreController::class, 'getTransactionDetails'])->name('store.getTransactionDetails');
Route::get('shippo/get_order_shipping_fee', [App\Http\Controllers\ShippoController::class, 'get_order_shipping_fee'])->name('shippo.get_order_shipping_fee');

Route::get('usps/get_order_shipping_fee', [App\Http\Controllers\USPSController::class, 'get_order_shipping_fee'])->name('usps.get_order_shipping_fee');

Route::get('manage_your_group', [App\Http\Controllers\StoreController::class, 'manage_your_group'])->name('store.manage_your_group');

Route::post('create_inquiry_catalog', [App\Http\Controllers\EnquiryController::class, 'create_inquiry_catalog'])->name('create_inquiry_catalog');

Route::get('embellishmentPage', [App\Http\Controllers\EmbellishmentPageController::class, 'embellishmentPage'])->name('embellishmentPage');
Route::get('commonFabricPage', [App\Http\Controllers\FabricPageController::class, 'commonFabricPage'])->name('commonFabricPage');

//Weekly order production report

Route::get('reports/weekly-order-production', [App\Http\Controllers\ReportController::class, 'weeklyOrderProductionSummary'])->name('reports.weekly_order_production_summary');
Route::get('/download-report/{filename}', function ($filename) {
    $path = storage_path('app/reports/' . $filename);

    if (!file_exists($path)) {
        abort(404);
    }

    return response()->download($path, $filename);
})->name('report.download');


Route::get('/php-ca-check', function () {
    $caFile = ini_get('curl.cainfo');

    return [
        'php_version'      => PHP_VERSION,
        'php_ini'          => php_ini_loaded_file(),
        'curl_cainfo'      => $caFile,
        'openssl_cafile'   => ini_get('openssl.cafile'),
        'certificate_exists' => $caFile
            ? file_exists($caFile)
            : false,
    ];
});

Route::middleware('auth')
    ->prefix('store-order-recovery')
    ->name('store-order-recovery.')
    ->group(function () {
        Route::get('/', [App\Http\Controllers\StoreOrderRecoveryController::class, 'index'])->name('index');
        Route::post('/{orderId}/restore', [App\Http\Controllers\StoreOrderRecoveryController::class, 'restore'])->name('restore');
    });
