<?php

namespace App\Http\Controllers;

use App\Models\Order;
use Illuminate\Http\Request;
use App\Models\FactoryInvoice;
use App\Models\AdditionPayment;
use App\Models\Notification;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\Auth;
use App\Models\InvoiceTransaction;
use App\Models\DebitAccountRecord;
use App\Services\NotificationBuilderService;

class PayableInvoiceController extends Controller
{
    public function index() {

        if(auth()->user()->can('view payable')){

            if(auth()->user()->can('manage payable invoice')){
                $buttonVisibility = true;
            }else{
                $buttonVisibility = false;
            }

            $factoryinvoices = FactoryInvoice::where('active', 1)->with('orderDetails')->whereIn('status', [1, 2, 5])->orderBy('id', 'desc')->get();

            $maxId = FactoryInvoice::max('id');
            $productNo = 'INV'.str_pad(($maxId+1), 4, "0", STR_PAD_LEFT);

            $transactionID = 'ENCR'.str_pad((InvoiceTransaction::max('id')+1), 6, "0", STR_PAD_LEFT);

            $currentDebitValue = optional(DebitAccountRecord::orderBy('id', 'desc')->first())->current_value ?? 0.00;

            $orders = Order::get();
            $additionPayements = AdditionPayment::select('id', 'addition_type_name')->where('active', 1)->get();
            $invoces = FactoryInvoice::where('active', 1)->orderBy('id', 'desc')->get();
            $groupInvoices = FactoryInvoice::where('active', 1)->orderBy('id', 'desc')->get();

            return view('pages.accounting.payable.index', ['factoryinvoices'=>$factoryinvoices, 'orders'=>$orders, 'additionPayements'=>$additionPayements, 'invoces'=>$invoces,
            'productNo'=>$productNo, 'groupInvoices'=>$groupInvoices, 'transactionID'=>$transactionID, 'currentDebitValue'=>$currentDebitValue, 'buttonVisibility'=>$buttonVisibility]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function approve(Request $request){

        try {
            if($request->new_invoice_no){
                $invoice = FactoryInvoice::find($request->new_invoice_no);
                if($invoice){

                    $invoice->status = 1;
                    $invoice->update();

                    // $notification = new Notification();
                    // $notification->notification_title = 'Factory invoice for Order | Order - #' . $invoice->order_id . ' has been approved by factory.';
                    // $notification->notification_message = 'Factory invoice for Order | Order - #' . $invoice->order_id . ' has been approved by factory.
                    //                                     <ul> Invoice Number :' . $invoice->invoice_number . '.</ul>
                    //                                     <ul> Company invoice number :"' . $invoice->company_invoice . '".</ul>';
                    // $notification->user_id = 5;
                    // $notification->order_id = $invoice->order_id;
                    // $notification->save();
                    $builder = new NotificationBuilderService();

                    $builder->sendNotification('key_factory_invoice_for_order', [
                        '{order_no}' => $invoice->order_id,
                        '{Invoice_Number}' => $invoice->invoice_number,
                        '{Company_invoice_number}' => $invoice->company_invoice,
                    ], [

                        'order_id' => $invoice->order_id,
                    ]);
                }


                return redirect()->route('payable_invoice')->withSuccess('Invoice Approved Successfully!');

            } else {
                return json_encode([
                    'responce'=>'error',
                    'meessage'=>'Invalid Invoice',
                    'new_invoice_no'=>null,
                ]);
            }
        } catch (\Throwable $th) {
            return json_encode([
                'responce'=>'error',
                'meessage'=>$th->getMessage(),
                'new_invoice_no'=>null,
            ]);
        }

    }


    public function payed($id){
        try {
            $invoice = FactoryInvoice::find($id);

            if ($invoice) {
                // Update the 'active' column to '0'
                $invoice->status = 3;
                $invoice->save();

                return response()->json(['success' => 'Invoice Payed Successfully!']);
            }

        } catch (\Throwable $th) {
            return json_encode([
                'responce'=>'error',
                'meessage'=>$th->getMessage(),
                'new_invoice_no'=>null,
            ]);
        }
    }

    public function groupPayed($groupId){
        try {
            $invoices = FactoryInvoice::where('group_invoice_id', $groupId)->get();

            if ($invoices->isEmpty()) {
                return response()->json(['error' => 'No invoices found for the provided group']);
            }

            foreach ($invoices as $invoice) {
                $invoice->status = 3;
                $invoice->save();
            }

            return response()->json(['success' => 'Invoices Payed Successfully!']);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Failed to payed invoices',
                'message' => $th->getMessage(),
            ]);
        }

    }


    public function reject($invoiceId)
    {
        try {
            $invoice = FactoryInvoice::find($invoiceId);
            $reason = request()->input('reason');

            if ($invoice) {
                $invoice->status = 4;
                $invoice->reject_reason = $reason;
                $invoice->save();

                return response()->json(['success' => 'Invoice Rejected Successfully!']);
            } else {
                return response()->json(['error' => 'Invoice not found']);
            }

        } catch (\Throwable $th) {
            return response()->json([
                'response' => 'error',
                'message' => $th->getMessage(),
                'new_invoice_no' => null,
            ]);
        }
    }


    public function groupReject($invoiceGroupId)
    {
        try {
            $invoices = FactoryInvoice::where('group_invoice_id', $invoiceGroupId)->get();

            if ($invoices->isEmpty()) {
                return response()->json(['error' => 'No invoices found for the provided group']);
            }

            foreach ($invoices as $invoice) {
                $invoice->status = 4;
                $invoice->reject_reason = request()->input('reason');
                $invoice->save();
            }

            return response()->json(['success' => 'Invoices Rejected Successfully!']);

        } catch (\Throwable $th) {
            return response()->json([
                'error' => 'Failed to reject invoices',
                'message' => $th->getMessage(),
            ]);
        }
    }



    public function invoiceGroup($groupId){

        try {
            $invoiceData = FactoryInvoice::where('group_invoice_id', $groupId)->get();

            return response()->json(['invoiceData'=>$invoiceData]);

        } catch (\Exception $e) {

            return response()->json(['error' => 'Internal Server Error'], 500);

        }
    }

    public function groupApprove(Request $request) {

        $selectedInvoiceIds = $request->input('invoice_ids');
    // dd($request);
        foreach ($selectedInvoiceIds as $invoiceId) {

            $invoice = FactoryInvoice::find($invoiceId);

            $invoice->status = 1;
            $invoice->save();

        }

        return redirect()->back()->withSuccess('Invoice Approved Successfully!');
    }

}
