<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Models\Enquiry;
use App\Models\EmailNotification;
use App\Services\EmailNotificationBuilderService;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Log;

class PdtDesignEnquiryController extends Controller
{
    public function store(
        Request $request,
        EmailNotificationBuilderService $mailer
    ) {
        $data = $request->validate([
            'request_id' => 'required|uuid',
            'name' => 'required|string|max:150',
            'email' => 'required|email|max:254',
            'phone' => 'required|string|max:50',
            'note' => 'nullable|string|max:5000',
            'pdt_product_id' => 'required|integer|exists:pdt_products,id',
            'template_id' => 'required|integer',
            'design_url' => 'required|url|max:2048',
            'preview_url' => 'required|url|max:2048',
            'preview_image' => 'required|string|max:14000000',
        ]);

        // Validate PNG preview
        if (!preg_match(
            '/^data:image\/png;base64,(.+)$/s',
            $data['preview_image'],
            $matches
        )) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid preview image.'
            ], 422);
        }

        $image = base64_decode($matches[1], true);

        $info = $image
            ? @getimagesizefromstring($image)
            : false;

        if (
            !$info ||
            $info[2] !== IMAGETYPE_PNG ||
            strlen($image) > 10485760
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid preview image.'
            ], 422);
        }

        $keys = [
            'key_email_pdt_enquiry_sales',
            'key_email_pdt_enquiry_customer'
        ];

        // Check email templates
        foreach ($keys as $key) {
            $template = EmailNotification::where(
                'template_key',
                $key
            )->first();

            if (
                !$template ||
                (int) $template->active !== 1 ||
                (int) $template->environment !== 1
            ) {
                return response()->json([
                    'success' => false,
                    'message' => 'PDT email templates must be active and in production mode.'
                ], 503);
            }
        }

        try {
            // Get PDT product
            $product = DB::table('pdt_products')
                ->where('id', $data['pdt_product_id'])
                ->first();

            if (!$product) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found.'
                ], 404);
            }

            $productName = DB::table('products')
                ->where('id', $product->product_id)
                ->value('product_name') ?: 'Custom garment';

            // Save enquiry directly to database
            $enquiry = new Enquiry();

            $enquiry->name = $data['name'];
            $enquiry->email = $data['email'];
            $enquiry->phone_number = $data['phone'];
            $enquiry->product_id = $product->product_id;

            $enquiry->message =
                ($data['note'] ?? '') .
                "\n\nPDT design: " . $data['design_url'] .
                "\nPreview: " . $data['preview_url'];

            $enquiry->save();

            // Email template values
            $values = [
                'enquiry_id' => $enquiry->id,
                'customer_name' => $data['name'],
                'customer_email' => $data['email'],
                'customer_phone' => $data['phone'],
                'note' => $data['note'] ?? '',
                'product_name' => $productName,
                'design_url' => $data['design_url'],
                'preview_url' => $data['preview_url'],
            ];


            // Send sales team email
            $salesSent = false;

            try {
                $salesSent = (bool) $mailer->sendEmailFromTemplate(
                    $keys[0],
                    $values,
                    [
                        'reply_to' => $data['email'],
                        'reply_name' => $data['name']
                    ]
                );
            } catch (\Throwable $e) {
                Log::error('PDT sales email failed', [
                    'enquiry_id' => $enquiry->id,
                    'error' => $e->getMessage()
                ]);
            }

            // Send customer confirmation email
            $customerSent = false;

            try {
                $customerSent = (bool) $mailer->sendEmailFromTemplate(
                    $keys[1],
                    array_merge($values, [
                        'custom_email' => $data['email']
                    ]),
                    []
                );
            } catch (\Throwable $e) {
                Log::error('PDT customer email failed', [
                    'enquiry_id' => $enquiry->id,
                    'error' => $e->getMessage()
                ]);
            }

            $sent = $salesSent && $customerSent;

            return response()->json([
                'success' => $sent,
                'enquiry_id' => $enquiry->id,
                'sales_email_sent' => $salesSent,
                'customer_email_sent' => $customerSent,
                'message' => $sent
                    ? 'Enquiry submitted successfully.'
                    : 'Enquiry saved, but one or more emails could not be sent.'
            ], $sent ? 200 : 502);

        } catch (\Throwable $e) {
            Log::error('PDT enquiry failed', [
                'request_id' => $data['request_id'],
                'error' => $e->getMessage()
            ]);

            return response()->json([
                'success' => false,
                'message' => 'Unable to submit enquiry. Please try again.'
            ], 500);
        }
    }
}
