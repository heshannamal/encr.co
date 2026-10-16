<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Enquiry;
use App\Models\Product;
use App\Models\SubscribeLog;
use App\Services\EmailNotificationBuilderService;

class EnquiryController extends Controller
{
    public function create_inquiry_catalog(Request $request)
    {
        $enquiries = new Enquiry();
        $enquiries->email        = $request->email;
        $enquiries->phone_number = $request->phone_no;
        $enquiries->name         = $request->first_name;
        $enquiries->team_name    = $request->team_name;
        $enquiries->sport        = $request->sport;
        $enquiries->message      = $request->message;
        $enquiries->product_id   = $request->product_id;
        $enquiries->save();

        $product = Product::where('id', $enquiries->product_id)->first();

        app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_catalog_inquiry', [
            'enquiry' => $enquiries,
            'product' => $product,
        ]);
        // Redirect back with success message
        return redirect()->back()->with('success', 'Your enquiry has been submitted successfully!');
    }

    public function enquiries() {
        $enquiries = Enquiry::all();

        return view('pages.customer_product_catlog.internal_enquiries.index', [
            'enquiries' => $enquiries
        ]);
    }

    public function getEnquiry($id)
    {
        // Enquiry ekata adala data ganna
        $enquiry = Enquiry::where('id', $id)->firstOrFail();

        // E enquiry ekata adala product data ganna
        $product = Product::where('id', $enquiry->product_id)->first();

        return response()->json([
            'enquiry' => $enquiry,
            'product' => $product, // product data pass karanawa
        ]);
    }

    public function subscribers(){
        if(!auth()->user()->can('view subscribers')){
            return redirect()->back()->withError('Permission Not Granted!');
        }
        $subscribers = SubscribeLog::get();
        return view('pages.subscribers.index', [
            'subscribers' => $subscribers
        ]);
    }




}
