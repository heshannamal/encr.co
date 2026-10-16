<?php

namespace App\Http\Controllers;

use App\Models\Order;
use App\Models\Price;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\Product;
use App\Models\OrderItem;
use App\Models\Organization;
use Illuminate\Http\Request;
use App\Models\FactoryInvoice;
use App\Models\InvoiceProduct;
use App\Models\AdditionPayment;
use App\Models\EmbellishmentType;
use App\Models\FactoryBankDetail;
use App\Models\InvoiceTransaction;
use App\Models\FinacialYearDate;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\FactoryInvoiceAddition;
use App\Models\DebitAccountRecord;
use App\Models\InvoicesOnTransaction;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;
use PDF;
use ZipArchive;
use Illuminate\Support\Facades\Response;
use Illuminate\Support\Facades\Storage;

class GenerateInvoiceController extends Controller
{
    public function index(Request $request) {

        if(auth()->user()->can('manage generate invoice')){

            $maxId = FactoryInvoice::max('id');
            $productNo = 'INV'.str_pad(($maxId+1), 4, "0", STR_PAD_LEFT);

            $newInvoicetNo = $maxId+1;
            $this->userGroupFactories();
            $oderSearch = $this->oderSearch;
            $factoryIds = $this->factoryIds;

            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

            $factoriesQuery = Factory::select('id', 'factory_code');

            $orders = $orderQuery
                    ->where('active', 1)
                    ->with('orderItems.factoryDetails')
                    ->get()
                    ->map(function ($order) {
                        $order->embellishment = $order->orderItems
                            ->whereIn('embellishment_type_id', [3, 19, 2, 4])
                            ->isNotEmpty()
                                ? 'yes'
                                : 'no';

                        return $order;
                    });
            $organizations = Organization::where('active', 1)->get();
            $factories = $factoriesQuery->where('active', 1)->orderBy('id')->get();
            $additionPayements = AdditionPayment::select('id', 'addition_type_name')->where('active', 1)->get();
            // $invoices = FactoryInvoice::where('active', 1)->where('status', 0)->orderBy('id', 'desc')->get();
            $invoices = FactoryInvoice::where('active', 1)
                    ->where('status', 0)
                    ->whereHas('orderDetails', function ($query) {
                        $query->where('organization_id', '!=', 2890);
                    })
                    ->with('orderDetails')
                    ->orderBy('id', 'desc')
                    ->get();

            return view('pages.accounting.generate_invoice.index', ['orders'=>$orders, 'additionPayements'=>$additionPayements, 'invoices'=>$invoices, 'organizations'=>$organizations,
                        'newInvoicetNo'=>$newInvoicetNo, 'productNo'=>$productNo, 'factories'=>$factories]);

        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }
    public function AllInvoicesIndex(Request $request){
        $maxId = FactoryInvoice::max('id');
        $productNo = 'INV'.str_pad(($maxId+1), 4, "0", STR_PAD_LEFT);
        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');
        $invoces = FactoryInvoice::where('active', 1)->orderBy('id', 'desc')->get();
        $factoryinvoices = FactoryInvoice::where('active', 1)->with('orderDetails')->whereIn('status', [0 ,1, 2, 3])->orderBy('id', 'desc')->get();
        $factoriesQuery = Factory::select('id', 'factory_code');
        $orders = $orderQuery->where('active', 1)->with('orderItems.factoryDetails')->get();
        $factories = $factoriesQuery->where('active', 1)->orderBy('id')->get();
        $additionPayements = AdditionPayment::select('id', 'addition_type_name')->where('active', 1)->get();
        return view('pages.accounting.all_invoice.index',['additionPayements'=>$additionPayements,'productNo'=>$productNo,'orders'=>$orders,'invoces'=>$invoces,'factoryinvoices'=>$factoryinvoices,'factories'=>$factories]);

    }
    public function AllInvoices_data(Request $request)
    {

        $query = FactoryInvoice::where('active', 1)
            ->with('orderDetails')
            ->orderBy('id', 'desc');

        // Apply invoice status filter
        if ($request->has('invoice_filter') && $request->invoice_filter !== 'all') {
            if ($request->invoice_filter == 'Generated') {
                $query->where('status', 0);
            } elseif ($request->invoice_filter == 'Payble') {
                $query->whereIn('status', [1, 2]);
            } elseif ($request->invoice_filter == 'Paid') {
                $query->where('status', 3);
            }
        }

        // Apply date filters if provided
        $startDate = $request->start_date ? \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d') : null;
        $endDate = $request->end_date ? \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d') : null;

        if ($startDate && $endDate) {
            $query->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);
        } elseif ($startDate) {
            $query->whereDate('created_at', '>=', $startDate);
        } elseif ($endDate) {
            $query->whereDate('created_at', '<=', $endDate);
        }

        // Fetch results
        $factoryinvoices = $query->get();

        return response()->json([
            'factoryinvoices' => $factoryinvoices,
        ]);
    }

    public function legerPaymentsIndex(Request $request) {

        if(auth()->user()->can('manage generate invoice')){

            if ($request->has('financial_year')) {
                $date_element = FinacialYearDate::where('financial_year', $request->financial_year)->first();
                if(!$date_element){
                    return redirect()->back()->withError('Financial Year Not Found!');
                }
            } else {
                $date_element = FinacialYearDate::where('financial_year', Carbon::now()->format('Y'))->first();
            }

            $financial_year = $date_element->financial_year;
            $yearList = FinacialYearDate::pluck('financial_year')->toArray();

            $start_date = Carbon::createFromFormat('m/d/Y H:i:s', "{$date_element->start_date} 00:00:00", 'UTC')->startOfDay();
            $end_date = Carbon::createFromFormat('m/d/Y H:i:s', "{$date_element->end_date} 23:59:59", 'UTC')->endOfDay();

            $start_date = $start_date->setTimezone($date_element->time_zone);
            $end_date = $end_date->setTimezone($date_element->time_zone);

            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

            $orders = $orderQuery->where('active', 1)->with('orderItems.factoryDetails')->get();

            $additionPayements = AdditionPayment::select('id', 'addition_type_name')->where('active', 1)->get();

            $maxId = FactoryInvoice::max('id');
            $productNo = 'INV'.str_pad(($maxId+1), 4, "0", STR_PAD_LEFT);

            $Transactions = InvoiceTransaction::whereBetween('updated_at', [$start_date, $end_date])->orderBy('created_at', 'desc')->get();

            return view('pages.accounting.payment_ledger.index', ['Transactions'=>$Transactions, 'orders'=>$orders, 'additionPayements'=>$additionPayements, 'productNo'=>$productNo , 'financial_year'=>$financial_year, 'yearList'=>$yearList]);

        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function getOrderDetails(Request $request){

        try {


            $orderId1 = $request->input('order_id');

            $orders = Order::find($orderId1);
            $organizations = Organization::find($orders->organization_id);
            $orderItems = OrderItem::with('subProduct','subProduct.prices')->where('order_id', $orderId1)->get();
            $productIds = $orderItems->pluck('product_id')->toArray();
            $products = Product::whereIn('id', $productIds)->get();
            $embellishments = EmbellishmentType::get();
            $fabrics = Fabric::get();
            $factories = Factory::get();
            $price =Price::where('price_type', '5')->where('active', 1)->get();
            $bank_details = FactoryBankDetail::get();

            $invoice = FactoryInvoice::where('order_id', $orderId1)->first();
            if($invoice){
                $invoiceProducts = InvoiceProduct::where('invoice_id', $invoice->id)->get();
            } else {
                $invoiceProducts = [];
            }

            if($invoice){
                $additional = FactoryInvoiceAddition::where('invoice_id', $invoice->id)->get();
            } else {
                $additional = null;
            }
            $additionPayements = AdditionPayment::select('id', 'addition_type_name')->where('active', 1)->get();


            return response()->json(['orders' => $orders, 'organizations'=>$organizations, 'factories'=>$factories, 'orderItems'=>$orderItems,
                                    'products'=>$products, 'embellishments'=>$embellishments, 'fabrics'=>$fabrics, 'invoiceProducts'=>$invoiceProducts,
                                    'price'=>$price, 'bank_details'=>$bank_details, 'additional'=>$additional, 'additionPayements'=>$additionPayements,
                                    'invoice'=>$invoice
                                ]);

        } catch (\Exception $e) {

            return response()->json(['error' => 'Internal Server Error'], 500);

        }
    }

    public function getOrderDetails2(Request $request){

        try {

            $invoiceId = $request->input('invoice_id');

            $organizations = Organization::get();

            $products = Product::get();
            $embellishments = EmbellishmentType::get();
            $fabrics = Fabric::get();
            $factories = Factory::get();
            $invoiceProducts = InvoiceProduct::get();
            $price =Price::where('price_type', '5')->get();
            $bank_details = FactoryBankDetail::get();

            $invoice = FactoryInvoice::where('id', $invoiceId)->first();

            $invoiceId = FactoryInvoice::where('id', $invoiceId)->pluck('id')->first();

            $order = Order::where('id', $invoice->order_id)->first();

            $additional = FactoryInvoiceAddition::where('invoice_id', $invoice->id)->get();
            $additionPayements = AdditionPayment::select('id', 'addition_type_name')->where('active', 1)->get();


            return response()->json(['organizations'=>$organizations, 'factories'=>$factories, 'order'=>$order,
                                    'products'=>$products, 'embellishments'=>$embellishments, 'fabrics'=>$fabrics, 'invoiceProducts'=>$invoiceProducts,
                                'price'=>$price, 'bank_details'=>$bank_details, 'additional'=>$additional, 'additionPayements'=>$additionPayements,
                                'invoice'=>$invoice, 'invoiceId'=>$invoiceId]);

        } catch (\Exception $e) {

            return response()->json(['error' => 'Internal Server Error'], 500);

        }
    }

    public function create_invoice(Request $request){
        try {

            if(isset($request->new_invoice_no)){
                $invoice = FactoryInvoice::find($request->new_invoice_no);
                if($invoice){
                    if ($invoice->status == 0 || $invoice->status == 4 || $invoice->status == 1) {
                        //Update Invoice

                        $invoice->company_invoice = $request->company_invoice;
                        $invoice->total_amount = $request->total_value;
                        $invoice->sub_total = $request->subTotalInput;
                        $invoice->reduce_value = $request->reduce_value;
                        if($request->Issave == 1){
                            $invoice->status = 1;
                        }

                        $invoice->update();

                        $otherResonArray    = $request->input('other_reson', []);
                        $additionValueArray = $request->input('addition_value', []);

                        foreach ($additionValueArray as $id => $additionValue) {
                            $additionValue = ($additionValue === null || $additionValue === '') ? NULL : $additionValue;

                            $additions = FactoryInvoiceAddition::where('invoice_id', $request->new_invoice_no)
                                ->where('addition_payment_id', $id)
                                ->get();

                            if ($additions->count() > 0) {
                                $addition = $additions->first();

                                $additions->slice(1)->each->delete();
                            } else {
                                $addition = new FactoryInvoiceAddition();
                                $addition->invoice_id          = $request->new_invoice_no;
                                $addition->addition_payment_id = $id;
                            }

                            $addition->amount = $additionValue;
                            $addition->if_other_reson = ($id == 1 && isset($otherResonArray[$id]))
                                ? $otherResonArray[$id]
                                : null;

                            $addition->save();
                        }



                        $tableDataJSON = $request->input('table_data');
                        $tableData = json_decode($tableDataJSON, true);
                        foreach ($tableData as $rowData) {
                            if (isset($rowData['productId'])) {
                                if(!empty($rowData['invoice_id'])){
                                    $product = InvoiceProduct::find($rowData['invoice_id']);
                                }else{
                                    $product = InvoiceProduct::where('invoice_id', $request->new_invoice_no)
                                        ->where('product_id', $rowData['productId'])
                                        ->Where('order_item_id', $rowData['order_item_id'] ?? null)
                                        ->first();
                                }

                                if ($product && !auth()->user()->can('edit invoice unit price') && $product->unit_price !== 0) {
                                    return redirect()->back()->withError('Unauthorized modification detected!');
                                }else{

                                    if ($product) {
                                        $product->unit_price = (float)$rowData['unitPrice'];
                                        if(!empty($rowData['order_item_id'])){
                                            $product->order_item_id = $rowData['order_item_id'];
                                        }
                                        $product->total_price = (float)$rowData['total'];
                                        $product->update();
                                    }else{
                                        $new_product = new InvoiceProduct();
                                        $new_product->invoice_id = $request->new_invoice_no;
                                        $new_product->product_id = $rowData['productId'];
                                        $new_product->qty = $rowData['qty'];
                                        $new_product->unit_price = (float)$rowData['unitPrice'];
                                        $new_product->total_price = (float)$rowData['total'];
                                        if(!empty($rowData['order_item_id'])){
                                            $new_product->order_item_id = $rowData['order_item_id'];
                                        }
                                        $new_product->save();
                                    }
                                }

                            }
                        }


                        return redirect()->route('generate_invoice')->withSuccess('Invoice Update Successfully!');

                    } elseif ($invoice->status == 2) {
                        return redirect()->route('generate_invoice')->withErrors('You Can not Update Invoice! Because, It is on Pending Approval');
                    } else {
                        return redirect()->route('generate_invoice')->withErrors('You Can not Update Invoice! Because, It was Approved');
                    }


                } else {
                    return json_encode([
                        'responce'=>'error',
                        'meessage'=>'Invalid Invoice',
                        'new_invoice_no'=>null,
                    ]);
                }

            } else {

                //Create Invoice
                    $invoice = new FactoryInvoice();
                    $invoice->company_invoice = $request->company_invoice;
                    $invoice->invoice_number = $request->invoice_no;
                    $invoice->order_id = $request->order_number;
                    $invoice->total_amount = $request->total_value;
                    $invoice->sub_total = $request->subTotalInput;
                    $invoice->reduce_value = $request->reduce_value;
                    $invoice->status = 0;
                    $invoice->save();

                    $latestItem = FactoryInvoice::latest()->first();

                    $otherResonArray = $request->input('other_reson');
                    $additionValueArray = $request->input('addition_value');

                    foreach ($additionValueArray as $id => $additionValue) {
                        if ($additionValue!=null) {
                            $additions = new FactoryInvoiceAddition();
                            $additions->addition_payment_id = $id;
                            $additions->amount = $additionValue;
                            $additions->invoice_id = $latestItem->id;

                            if ($additions->addition_payment_id == 1) {
                                foreach ($request->other_reson as $key => $value) {
                                    $additions->if_other_reson = $value;
                                }
                            }
                            $additions->save();
                        }
                    }

                    $tableDataJSON = $request->input('table_data');
                    $tableData = json_decode($tableDataJSON, true);

                    // Loop through each row data and create a new InvoiceProduct record
                    foreach ($tableData as $rowData) {
                        $invoiceProduct = new InvoiceProduct([
                            'invoice_id'=> $latestItem->id,
                            'product_id' => $rowData['productId'],
                            'qty' => (int)$rowData['qty'],
                            'unit_price' => (float)$rowData['unitPrice'],
                            'total_price' => (float)$rowData['total'],
                        ]);
                        // Save the record to the database
                        $invoiceProduct->save();
                    }

                    return redirect()->route('generate_invoice')->withSuccess('Generate Invoice Successfully!');
                }
        } catch (\Throwable $th) {
            return json_encode([
                'responce'=>'error',
                'meessage'=>$th->getMessage(),
                'new_invoice_no'=>null,
            ]);
        }

    }

    public function edit($id){

        try {
            $invoice = FactoryInvoice::find($id)->where('id', $id)->get();
            $additional = FactoryInvoiceAddition::where('invoice_id', $id)->get();
            $invoiceProducts = InvoiceProduct::get();

            return response()->json(['invoice'=>$invoice, 'additional'=>$additional, 'invoiceProducts'=>$invoiceProducts]);

        } catch (\Exception $e) {

            return response()->json(['error' => 'Internal Server Error'], 500);

        }
    }

    public function delete($id) {
        // Check if there Approved or Not
        $hasInvoice = FactoryInvoice::find($id);

        if ($hasInvoice->status == 1) {
            return response()->json(['error' => 'You Can not Delete Invoice! Because, It was Approved']);
        } else {
            // Find the invoice in the database
            $invoice = FactoryInvoice::find($id);

            if ($invoice) {
                // Update the 'active' column to '0'
                $invoice->active = 0;
                $invoice->save();

                return response()->json(['success' => 'Invoice Deleted Successfully!']);
            }
        }

        return response()->json(['error' => 'Product deletion failed.']);
    }

    public function sendApproval($id) {
        // Check if there Approved or Not
        $hasInvoice = FactoryInvoice::find($id);

        if ($hasInvoice->status == 1) {
            return response()->json(['error' => 'You Can not Send For Approval Invoice! Because, It was Approved']);
        } else {
            // Find the invoice in the database
            $invoice = FactoryInvoice::find($id);

            if ($invoice) {
                // Update the 'active' column to '0'
                $invoice->status = 1;
                $invoice->save();

                return response()->json(['success' => 'Invoice Approved Successfully!']);
            }
        }

        return response()->json(['error' => 'Product deletion failed.']);
    }

    public function groupApproval(Request $request) {
        $highest_group_invoice_id = FactoryInvoice::max('group_invoice_id');

        // Increment it by 1
        $new_group_invoice_id = $highest_group_invoice_id + 1;

        $selectedInvoiceIds = $request->input('invoice_ids');

        foreach ($selectedInvoiceIds as $invoiceId) {
            $hasInvoice = FactoryInvoice::find($invoiceId);

            if ($hasInvoice->status == 1) {
                return redirect()->back()->withError('You Can not Send For Approval Invoice! Because, It was Approved');
            } else {

                $invoice = FactoryInvoice::find($invoiceId);

                $invoice->status = 1;
                $invoice->group_invoice_id = $new_group_invoice_id;
                $invoice->save();
            }
        }

        return redirect()->back()->withSuccess('Invoices Approved Successfully!');
    }

    public function get_multiple_invoice_details(Request $request)
    {
        $factoryInvoices = FactoryInvoice::with('orderDetails')->whereIn('id', $request->invoices)
            ->orderBy('id', 'desc')
            ->get();

        $transaction = null;

        if ($request->has('transaction_id')) {
            $transaction = InvoiceTransaction::with('paidDetails')->where('transaction_id', $request->transaction_id)->first();
        }else{
            if ($factoryInvoices->isNotEmpty() && $factoryInvoices->first()->transaction_id) {
                $transaction = InvoiceTransaction::with('paidDetails')->where('transaction_id', $factoryInvoices->first()->transaction_id)
                    ->first();
            }
        }


        return response()->json([
            'data' => $factoryInvoices,
            'transaction' => $transaction,
        ], 200);
    }
    public function do_pay_multiple_invoice(Request $request)
    {

        if ($request->has('payment_amount') && count($request->payment_amount) > 0) {
            $arrayData = $request->payment_amount;
            $invoceIDs = '';

            foreach ($arrayData as $key => $value) {
                $invoice = FactoryInvoice::find($key);

                if ($invoice) {
                    $invoice->paid_amount += $value;
                    $invoice->transaction_id = $request->transaction_id;

                    $invoceIDs .= $invoice->id . ',';

                    if ($invoice->paid_amount == $invoice->total_amount) {
                        $invoice->status = 3; // Paid in full
                    } elseif ($invoice->paid_amount < $invoice->total_amount && $invoice->paid_amount > 0) {
                        $invoice->status = 5; // Partially paid
                    } elseif ($invoice->paid_amount == 0) {
                        $invoice->status = 1; // Unpaid
                    }

                    $invoice->save();

                    $new_invoice_transaction = new InvoicesOnTransaction();
                    $new_invoice_transaction->transaction_id = $request->transaction_id;
                    $new_invoice_transaction->invoice_id = $invoice->id;
                    $new_invoice_transaction->paid_amount = $value;
                    $new_invoice_transaction->save();
                }
            }

            if ($request->hasFile('upload_image')) {
                $imagePath = public_path('Transactions/' . $request->transaction_id);

                if (!File::exists($imagePath)) {
                    File::makeDirectory($imagePath, 0777, true, true);
                }

                $image = $request->file('upload_image');
                $imageFileName = Str::uuid() . '.' . $image->getClientOriginalExtension();

                $image->move($imagePath, $imageFileName);

                $image_url = 'Transactions/' . $request->transaction_id . '/' . $imageFileName;
            } else {
                $image_url = '';
            }

            $invoice_transaction = new InvoiceTransaction();
            $invoice_transaction->transaction_id = $request->transaction_id;
            $invoice_transaction->paid_amount = $request->transaction_amount_cash + $request->transaction_amount_debit;
            $invoice_transaction->payment_description = $request->payment_reference;
            $invoice_transaction->invoice_ids = rtrim($invoceIDs, ',');
            $invoice_transaction->invoice_total = $request->total_amount;
            $invoice_transaction->cash_amount = $request->transaction_amount_cash;
            $invoice_transaction->debit_amount = $request->transaction_amount_debit;
            $invoice_transaction->image_url = $image_url;
            $invoice_transaction->save();

            if (isset($request->plus_amount_to_debit) && $request->plus_amount_to_debit > 0) {
                $debitRecord = new DebitAccountRecord();
                $debitRecord->transaction_id = $request->transaction_id;
                $debitRecord->task = '<span style="color:green"> + ' . number_format($request->plus_amount_to_debit, 2) . '</span>';
                $debitRecord->description = 'Overpay from payment #' . $request->transaction_id;
                $debitRecord->pay_for = 'DWC';
                $debitRecord->image_url = $image_url;

                $debitRecord->current_value = (float)$request->current_value + (float)$request->plus_amount_to_debit;
                $debitRecord->save();
            }

            if (isset($request->transaction_amount_debit) && $request->transaction_amount_debit > 0) {
                $debitRecord = new DebitAccountRecord();
                $debitRecord->transaction_id = $request->transaction_id;
                $debitRecord->task = '<span style="color:red"> - ' . number_format($request->transaction_amount_debit, 2) . '</span>';
                $debitRecord->description = 'Settle from debit account for payment #' . $request->transaction_id;
                $debitRecord->pay_for = 'DWC';
                $debitRecord->image_url = $image_url;

                $debitRecord->current_value = (float)$request->current_value - (float)$request->transaction_amount_debit;
                $debitRecord->save();
            }

        }

        return response()->json(['data' => 'Successfully updated'], 200);
    }

    public function request_multiple_invoice(Request $request)
    {
        if (count($request->payment_amount) > 0) {
            $arrayData = $request->payment_amount;

            foreach ($arrayData as $key => $value) {
                $invoice = FactoryInvoice::find($key);

                if ($invoice) {
                    $invoice->status = 1;
                    $invoice->save();
                }

            }
        }

        return response()->json(['data' => 'Successfully updated'], 200);
    }

    public function download_multiple_invoices(Request $request)
    {
        $additionPayements = AdditionPayment::select('id', 'addition_type_name')
            ->where('active', 1)
            ->get();
        $factory = Factory::find(1);
        $bank_details = FactoryBankDetail::find(1);

        $orderIds = $request->input('invoice_ids');
        $InvoiceDetails = [];

        $logoPath = public_path('assets/img/factory/dwc.png');

        foreach ($orderIds as $orderId) {
            $order = Order::find($orderId);
            $organization = Organization::find($order->organization_id);
            $orderItems = OrderItem::with('subProduct', 'fabricDetails', 'secFabricDetails', 'embellishmentDetails')
                ->where('order_id', $orderId)
                ->where('factory_id', 1)
                ->get();

            $invoice = FactoryInvoice::where('order_id', $orderId)->first();
            $invoiceProducts = $invoice ? InvoiceProduct::where('invoice_id', $invoice->id)->get() : collect();
            $additional = $invoice ? FactoryInvoiceAddition::where('invoice_id', $invoice->id)->get() : collect();

            $InvoiceDetails[] = [
                'order'          => $order,
                'organization'   => $organization,
                'orderItems'     => $orderItems,
                'invoice'        => $invoice,
                'invoiceProducts'=> $invoiceProducts,
                'additional'     => $additional,
            ];
        }

        return view('pages.accounting.all_invoice.invoice_pdf', [
            'InvoiceDetails' => $InvoiceDetails,
            'additionPayements' => $additionPayements,
            'factory' => $factory,
            'bank_details' => $bank_details,
        ]);


    }




    public function chart_of_accounts(){

        return view('pages.accounting.chart_of_accounts.index');

    }



    public function userGroupFactories(){
        $user = Auth::user();
        $factoryIds = [];
        $userRoleId = [];
        if($user->hasRole([1, 2, 3, 4, 10])){
            $oderSearch = 'all';
        } else {
            $oderSearch = 'factory';
            foreach($user->roles as $userRole){
                if($userRole->id == 5){     // PBS Factory
                    $factoryIds[] = 2;  // PBS
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 13){     // WDC Factory
                    $factoryIds[] = 1;  // WDC
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 7){     // BII Factory
                    $factoryIds[] = 3;  // BII
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 8){     // UET Factory
                    $factoryIds[] = 7;  // UET
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 11){     // ZYS Factory
                    $factoryIds[] = 10;  // ZYS
                    $userRoleId = $userRole->id;
                }
                if($userRole->id == 12){     // Test Factory
                    $factoryIds[] = 16;  // Test
                    $userRoleId = $userRole->id;
                }
            }
        }

        $this->oderSearch = $oderSearch;
        $this->factoryIds = $factoryIds;
        $this->userRoleId = $userRoleId;

        return $this;
    }
}
