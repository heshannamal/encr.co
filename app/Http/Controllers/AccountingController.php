<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\InvoiceTransaction;
use App\Models\DebitAccountRecord;
use App\Models\FinacialYearDate;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Price;
use App\Models\InvoiceProduct;
use App\Models\BulkInvoice;
use App\Models\FactoryInvoice;
use App\Models\Organization;
use App\Models\PaymentLog;
use App\Models\CheckPayment;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\OtherPayment;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Str;
use Carbon\Carbon;

class AccountingController extends Controller
{

    public function debit_account(Request $request){

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

            $DebitAccountRecords = DebitAccountRecord::whereBetween('updated_at', [$start_date, $end_date])->orderBy('created_at', 'desc')->get();
            $transactionID = 'ENCR'.str_pad((InvoiceTransaction::max('id')+1), 6, "0", STR_PAD_LEFT);
            $currentDebitValue = optional(DebitAccountRecord::orderBy('id', 'desc')->first())->current_value ?? 0.00;

            return view('pages.accounting.chart_of_accounts.debit_account.index', ['DebitAccountRecords'=>$DebitAccountRecords, 'transactionID'=>$transactionID, 'currentDebitValue'=>$currentDebitValue, 'financial_year'=>$financial_year, 'yearList'=>$yearList]);

        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }

    }
    public function finacial_year(){

        $date_element = FinacialYearDate::where('financial_year', Carbon::now()->format('Y'))->first();

        return view('pages.accounting.chart_of_accounts.finacial_year.index',['date_element'=>$date_element]);

    }
    public function save_finacial_year(Request $request){

        if ($request->has('current_year')) {
            $date_element = FinacialYearDate::where('financial_year', $request->current_year)->first();

            if(!$date_element){
                $date_element = new FinacialYearDate();
            }

            $date_element->start_date = $request->start_date;
            $date_element->end_date = $request->end_date;
            $date_element->time_zone = $request->timezone;
            $date_element->financial_year = $request->current_year;
            $date_element->save();
        } else {
            return response()->json(['message' => 'Financial year is required.'], 400);
        }

        return response()->json(['message' => 'Dates successfully saved.'], 200);

    }
    public function save_debit_record(Request $request){

        if(isset($request->amount ) && $request->amount !== 0){

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

            $debitRecord = new DebitAccountRecord();
            $debitRecord->transaction_id = $request->transaction_id;
            $debitRecord->description = $request->description;
            $debitRecord->pay_for = $request->pay_for;
            $debitRecord->image_url = $image_url;

            if ((float)$request->amount < 0) {
                $debitRecord->task = '<span style="color:red"> - ' . abs($request->amount) . '</span>';
                $debitRecord->current_value = (float)$request->current_value + (float)$request->amount; // Add because amount is already negative
            } else {
                $debitRecord->task = '<span style="color:green"> + ' . $request->amount . '</span>';
                $debitRecord->current_value = (float)$request->current_value + (float)$request->amount;
            }

            $debitRecord->save();

            return response()->json([
                'success' => true,
                'message' => 'Debit record successfully saved.',
            ], 200);
        }else{
            return response()->json([
                'success' => false,
                'message' => 'Failed to save.',
            ], 200);
        }
    }

    public function createInvoice() {
        $orders = Order::where('active', 1)
            ->whereNotNull('production_date')
            ->whereIn('order_status_id', [3, 4, 5, 6, 8])
            ->where('id', '>', 1000)
            ->get();

        foreach ($orders as $order) {
            $invoiceFound = FactoryInvoice::where('order_id', $order->id)->first();

            if (!$invoiceFound) {
                $maxId = FactoryInvoice::max('id') ?? 0;
                $newInvoiceNo = 'INV' . str_pad(($maxId + 1), 4, "0", STR_PAD_LEFT);

                $newInvoice = new FactoryInvoice();
                $newInvoice->invoice_number = $newInvoiceNo;
                $newInvoice->order_id = $order->id;
                $newInvoice->status = 0;
                $newInvoice->save();

                $orderItems = OrderItem::where('order_id', $order->id)
                    ->where('active', 1)
                    ->where('factory_id', 1)
                    ->whereIn('order_status_id', [3, 4, 5, 6, 8])
                    ->get();

                $invoiceTotal = 0.00;

                foreach ($orderItems as $orderItem) {
                    $productPrice = Price::where('product_id', $orderItem->product_id)
                        ->where('price_type', 5)
                        ->where('active', 1)
                        ->first();

                    $manufacturePrice = $productPrice ? $productPrice->price : 0.00;

                    $invoiceProduct = new InvoiceProduct([
                        'invoice_id' => $newInvoice->id,
                        'product_id' => $orderItem->product_id,
                        'qty' => $orderItem->qty,
                        'unit_price' => $manufacturePrice,
                        'total_price' => $manufacturePrice * $orderItem->qty,
                    ]);
                    $invoiceProduct->save();

                    $invoiceTotal += $manufacturePrice * $orderItem->qty;
                }

                $newInvoice->total_amount = $invoiceTotal;
                $newInvoice->sub_total = $invoiceTotal;
                $newInvoice->save();
            }

        }
    }

    public function create_bulk_invoice(Request $request) {
        $order_ids_string = $request->input('make_bulk_invoices');
        $order_ids_array = explode(',', $order_ids_string);

        $orders = [];

        if (!empty($order_ids_array) && is_array($order_ids_array)) {
            $first_order = Order::find($order_ids_array[0]);

            if ($first_order) {
                $organization_id = $first_order->organization_id;

                $organization = Organization::find($organization_id);

                $bulk_invoice = new BulkInvoice();
                $bulk_invoice->order_ids = $order_ids_string;
                $bulk_invoice->organization_id = $organization_id;
                $bulk_invoice->save();

                foreach ($order_ids_array as $id) {


                    $order = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'orderItems', 'invoiceDetails')
                                      ->where('id', $id)
                                      ->where('organization_id', $organization_id)
                                      ->first();

                    if ($order) {
                        $orders[$id]['order'] = $order;

                        $cardPayment = PaymentLog::where('order_id', $id)->sum('amount');
                        $checkPayment = CheckPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');
                        $otherPayment = OtherPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');
                        $paypalPayement = PaypalPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');
                        $venmoPayment = VenmoPayment::where('order_id', $id)->where('is_approved' , 1)->sum('amount');

                        if($cardPayment > 0 && $paypalPayement > 0){
                            $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

                        } else if ($cardPayment > 0 && $paypalPayement == 0) {
                            $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

                        } else if ($cardPayment == 0 && $paypalPayement > 0) {
                            $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

                        } else {
                            $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
                        }

                        $orders[$id]['paid_amount'] = $payment;
                    }
                }

            } else {
                return back()->with('error', 'First order not found');
            }
        } else {
            return back()->with('error', 'No orders selected');
        }

        if(!empty($orders)){

            $bulk_invoice->order_ids = $order_ids_string;
            $bulk_invoice->active = 1;
            $bulk_invoice->save();

            return view('pages.reports.account_receivable_report.invoice', [
                'orders' => $orders,
                'organization' => $organization,
                'bulk_invoice_id' => $bulk_invoice->id,
                'order_ids_string' => $order_ids_string
            ]);
        }else{
            return back()->with('error', 'Orders not found for selected');
        }


    }
    public function bulk_invoices(){

        $bulk_invoice_details = [];

        $bulk_invoices = BulkInvoice::with('organizationDetails')->get();

        $bulk_invoices = BulkInvoice::with('organizationDetails')
            ->where('active', 1)
            ->get();

        foreach ($bulk_invoices as $bulk_invoice) {

            $order_ids = explode(',', trim($bulk_invoice->order_ids, ','));

            $order_ids = array_filter($order_ids);

            $orders = Order::whereIn('id', $order_ids)
                ->with('organizationDetails', 'userDetails', 'contactDetails', 'orderItems', 'invoiceDetails')
                ->get();

            $order_details = [];

            foreach ($orders as $order) {

                $cardPayment = PaymentLog::where('order_id', $order->id)->sum('amount');
                $checkPayment = CheckPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
                $otherPayment = OtherPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
                $paypalPayement = PaypalPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
                $venmoPayment = VenmoPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');

                if($cardPayment > 0 && $paypalPayement > 0){
                    $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

                } else if ($cardPayment > 0 && $paypalPayement == 0) {
                    $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

                } else if ($cardPayment == 0 && $paypalPayement > 0) {
                    $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

                } else {
                    $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
                }

                $order_details[$order->id]['order'] = $order;
                $order_details[$order->id]['paid_amount'] = $payment;
            }

            $bulk_invoice_details[$bulk_invoice->id]['invoice'] = $bulk_invoice;
            $bulk_invoice_details[$bulk_invoice->id]['order'] = $order_details;
        }


        return view('pages.accounting.bulk_invoice.index',['bulk_invoices' => $bulk_invoice_details]);
    }
    public function get_bulk_invoice_details(Request $request)
    {
        $bulk_invoice = BulkInvoice::with('organizationDetails')
            ->where('id', $request->inv_id)->where('active', 1)
            ->first();

        if (!$bulk_invoice) {
            return response()->json(['error' => 'Bulk invoice not found'], 404);
        }

        $order_ids = explode(',', trim($bulk_invoice->order_ids, ','));

        $order_ids = array_filter($order_ids);

        $orders = Order::whereIn('id', $order_ids)
            ->with('organizationDetails', 'userDetails', 'contactDetails', 'orderItems', 'invoiceDetails')
            ->get();

        $order_details = [];

        foreach ($orders as $order) {

            $cardPayment = PaymentLog::where('order_id', $order->id)->sum('amount');
            $checkPayment = CheckPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
            $otherPayment = OtherPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
            $paypalPayement = PaypalPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
            $venmoPayment = VenmoPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');

            if($cardPayment > 0 && $paypalPayement > 0){
                $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

            } else if ($cardPayment > 0 && $paypalPayement == 0) {
                $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

            } else if ($cardPayment == 0 && $paypalPayement > 0) {
                $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

            } else {
                $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
            }

            $order_details[$order->id]['order'] = $order;
            $order_details[$order->id]['paid_amount'] = $payment;
        }

        return response()->json(['bulk_invoice' => $bulk_invoice, 'orders' => $order_details]);
    }
    public function pay_bulk_invoice(Request $request){

        $bulk_invoice = BulkInvoice::find($request->bulk_invoice_id);

        $bulk_invoice->payment_status = 1;
        $bulk_invoice->save();

        return response()->json(['success' => 'Bulk invoice paid successfully'], 200);
    }



}
