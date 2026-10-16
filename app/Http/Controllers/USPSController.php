<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;

use Illuminate\Http\Request;

use App\Models\StoreOrder;

use App\Models\StoreCart;

use App\Models\Store;

use App\Models\StoreCustomer;

use App\Services\USPSService;

use App\Models\StoreShipment;
use App\Models\UspsShipmentProfile;
use App\Models\UspsLabelAttempt;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Log;

use PhpOffice\PhpSpreadsheet\IOFactory;

class USPSController extends Controller

{

    protected $uspsService;

    protected $mailClass = 'USPS_GROUND_ADVANTAGE';

    protected $shippingRateMultiplier = 1.5;


    // Label editing requires labels to be created with suppressPostage=true.
    // These sender values are intentionally kept in the controller so your
    // existing config/services.php USPS block stays unchanged.
    protected $uspsOriginTimezone = 'America/Los_Angeles';
    protected $uspsSender = [
        'firstName' => 'Encore',
        'lastName' => 'Custom',
        'firm' => 'Encore Custom',
        'streetAddress' => '891 4th St.',
        'city' => 'San Rafael',
        'state' => 'CA',
        'country' => 'US',
        'phone' => '+18885014999',
        'email' => 'info@encorecustom.com',
    ];

    public function __construct(USPSService $uspsService)

    {

        $this->uspsService = $uspsService;

    }

    public function get_order_shipping_fee(Request $request)
    {
        $storeOrder = StoreOrder::with('ShipmentDetails', 'OrderItems')
            ->where('order_no', $request->order_no)
            ->first();

        if (!$storeOrder) {
            return response()->json([
                'success' => false,
                'message' => 'Order not found.'
            ], 404);
        }

        if ($storeOrder->shipping_method == 3 || $storeOrder->shipping_method == 2) {
            return $this->freeShippingResponse();
        }

        $storeCustomer = StoreCustomer::where('id', $storeOrder->store_customer_id)->first();

        if (!$storeCustomer) {
            return response()->json([
                'success' => false,
                'message' => 'Customer not found.'
            ], 404);
        }

        $totalWeightOz = (float) ($request->total_weight ?? 0);
        $totalAmount = (float) ($request->total_price ?? 0);
        if ($totalWeightOz <= 0) {
            return response()->json([
                'success' => false,
                'message' => 'Invalid weight for shipping fee calculation.'
            ], 400);
        }

        if (empty($storeOrder->postal_code)) {
            return response()->json([
                'success' => false,
                'message' => 'Destination ZIP code is required.'
            ], 400);
        }

        try {
            $totalWeightLb = $this->convertOzToLb($totalWeightOz);

            $payload = $this->buildUspsPayload(
                $storeOrder->postal_code,
                $totalWeightLb
            );

            $result = $this->uspsService->getDomesticRates($payload);

            $rates = $this->formatUspsRates($result, $this->mailClass);

            if ($rates->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No USPS shipping rates available.',
                    'details' => $result,
                ], 400);
            }

            $rates = $this->applyShippingRateMultiplier($rates);

            $cheapestRate = $rates->first();

            return response()->json([
                'success' => true,
                'rate' => $cheapestRate,
                'weight_oz' => $totalWeightOz,
                'weight_lb' => $totalWeightLb,
                'usps_payload' => $payload,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    public function get_shipping_fee(Request $request)
    {
        $uniqueSessionId = session()->get('unique_session_id');

        $storeCartItems = StoreCart::where('store_id', $request->store_id)
            ->where('session_id', $uniqueSessionId)
            ->with('StoreCartItems', 'storeProduct.priceAdditions')
            ->get();

        $store = Store::with('contactCoachesDetails')->find($request->store_id);

        if (!$store) {
            return response()->json([
                'success' => false,
                'message' => 'Store not found.'
            ]);
        }

        $shippingMethod = $request->shipping_method ?? 1;

        $storeCustomer = StoreCustomer::where('store_id', $request->store_id)
            ->where('session_id', $uniqueSessionId)
            ->first();

        if (!$storeCustomer) {
            return response()->json([
                'success' => false,
                'message' => 'Please fill your details for shipping.'
            ]);
        }

        if ($storeCartItems->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Cart is empty.'
            ]);
        }

        if ($shippingMethod != 1) {
            return $this->freeShippingResponse();
        }

        $totalWeightOz = 0;
        $totalAmount = 0;
        $totalQty = 0;

        foreach ($storeCartItems as $cart) {
            if (!$cart->storeProduct) {
                return response()->json([
                    'success' => false,
                    'message' => 'Product not found in cart.'
                ]);
            }

            $product = $cart->storeProduct;

            // shipping_weight is stored as OZ
            $productWeightOz = (float) ($product->shipping_weight ?: 5);

            $productPrice = (float) (
                $product->default_price + $product->priceAdditions->sum('addition_amount')
            );

            $totalWeightOz += $productWeightOz * $cart->qty;
            $totalAmount += $productPrice * $cart->qty;
            $totalQty += $cart->qty;
        }

        $totalAmount += $totalAmount * $store->sales_tax / 100;
        $totalAmount = round($totalAmount, 2);
        $totalWeightOz = round($totalWeightOz > 0 ? $totalWeightOz : 1, 2);

        if (
            empty($storeCustomer->street) ||
            empty($storeCustomer->city) ||
            empty($storeCustomer->state) ||
            empty($storeCustomer->postal_code) ||
            empty($storeCustomer->country)
        ) {
            return response()->json([
                'success' => false,
                'message' => 'Incomplete shipping address — please provide full address details.'
            ]);
        }

        try {
            $totalWeightLb = $this->convertOzToLb($totalWeightOz);

            $payload = $this->buildUspsPayload(
                $storeCustomer->postal_code,
                $totalWeightLb
            );

            $result = $this->uspsService->getDomesticRates($payload);

            $rates = $this->formatUspsRates($result, $this->mailClass);

            if ($rates->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No USPS shipping rates available.',
                    'details' => $result,
                ]);
            }

            $rates = $this->applyShippingRateMultiplier($rates);

            $cheapestRate = $rates->first();

            return response()->json([
                'success' => true,
                'rate' => [
                    'amount' => $cheapestRate['amount'],
                    'currency' => $cheapestRate['currency'],
                    'provider' => $cheapestRate['provider'],
                    'service' => $cheapestRate['service'],
                    'estimated_days' => $cheapestRate['estimated_days'],
                ],
                'customsItem' => null,
                'weight_oz' => $totalWeightOz,
                'weight_lb' => $totalWeightLb,
                'rates' => $rates,
                'usps_payload' => $payload,
            ]);

        } catch (\Exception $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ]);
        }
    }

    private function buildUspsPayload($destinationZip, $weightLb)
    {
        return [
            'originZIPCode' => config('services.usps.origin_zip', '94901'),
            'destinationZIPCode' => substr(
                preg_replace('/\D/', '', (string) $destinationZip),
                0,
                5
            ),

            'weight' => round((float) $weightLb, 4),
            'length' => 14,
            'width' => 12,
            'height' => 4,

            'mailClass' => $this->mailClass,
            'processingCategory' => 'MACHINABLE',
            'destinationEntryFacilityType' => 'NONE',
            'rateIndicator' => 'SP',
            'priceType' => 'COMMERCIAL',

            'accountType' => config('services.usps.account_type', 'EPS'),
            'accountNumber' => config('services.usps.account_number'),
            'mailingDate' => now()->format('Y-m-d'),
        ];
    }

    private function formatUspsRates($result, $defaultMailClass)
    {
        return collect($result['rates'] ?? $result['rateOptions'] ?? $result ?? [])
            ->filter(function ($rate) {
                return isset($rate['price']) || isset($rate['totalBasePrice']) || isset($rate['amount']);
            })
            ->map(function ($rate) use ($defaultMailClass) {
                $mailClass = $rate['mailClass'] ?? $defaultMailClass;

                return [
                    'amount' => (float) ($rate['price'] ?? $rate['totalBasePrice'] ?? $rate['amount']),
                    'currency' => 'USD',
                    'provider' => 'USPS',
                    'service' => $rate['productName'] ?? $rate['description'] ?? $mailClass,
                    'mailClass' => $mailClass,
                    'estimated_days' => $this->getUspsEstimatedDays($mailClass),
                ];
            })
            ->sortBy('amount')
            ->values();
    }

    private function applyShippingRateMultiplier($rates)
    {
        return $rates->map(function ($rate) {
            $rate['amount'] = round(
                (float) ($rate['amount'] ?? 0) * $this->shippingRateMultiplier,
                2
            );

            return $rate;
        })->sortBy('amount')->values();
    }

    private function convertOzToLb($weightOz)
    {
        $weightLb = round($weightOz / 16, 2);

        if ($weightLb <= 0) {
            return 1;
        }

        return $weightLb;
    }

    private function freeShippingResponse()
    {
        return response()->json([
            'success' => true,
            'rate' => [
                'amount' => 0.00,
                'currency' => 'USD',
                'provider' => 'USPS',
                'service' => 'N/A',
                'estimated_days' => 'N/A',
            ]
        ]);
    }

    private function getUspsEstimatedDays($mailClass)
    {
        switch ($mailClass) {
            case 'PRIORITY_MAIL_EXPRESS':
                return '1-2 Days';

            case 'PRIORITY_MAIL':
                return '1-3 Days';

            case 'USPS_GROUND_ADVANTAGE':
                return '2-5 Days';

            default:
                return 'N/A';
        }
    }
    public function createShipment($order_no)
    {
        try {
            $this->createUspsShipmentRecord($order_no);

            return redirect()->back()->with('success', 'USPS shipment record created successfully.');
        } catch (\Throwable $e) {
            return redirect()->back()->with('error', $e->getMessage());
        }
    }

    /**
     * Bulk shipment creation used by the Manage Orders page.
     * Returns JSON for AJAX and redirect responses for non-AJAX callers.
     */
    public function createShipmentsBulk(Request $request)
    {
        $request->validate([
            'order_nos' => 'required|array|min:1|max:200',
            'order_nos.*' => 'required|distinct',
        ]);

        $orderNos = array_values(array_unique($request->input('order_nos', [])));
        $successCount = 0;
        $errors = [];

        foreach ($orderNos as $orderNo) {
            try {
                $this->createUspsShipmentRecord($orderNo);
                $successCount++;
            } catch (\Throwable $e) {
                $errors[] = 'Order ' . $orderNo . ': ' . $e->getMessage();
            }
        }

        $message = $successCount . ' shipment' . ($successCount === 1 ? '' : 's') . ' created successfully.';

        if (!empty($errors)) {
            $message .= ' ' . count($errors) . ' order' . (count($errors) === 1 ? '' : 's') . ' could not be processed.';
        }

        if ($request->ajax() || $request->wantsJson()) {
            $status = ($successCount === 0 && !empty($errors)) ? 422 : 200;

            return response()->json([
                'success' => $successCount > 0,
                'created_count' => $successCount,
                'failed_count' => count($errors),
                'message' => $message,
                'errors' => $errors,
            ], $status);
        }

        if (!empty($errors)) {
            return redirect()->back()
                ->with($successCount > 0 ? 'warning' : 'error', $message . ' ' . implode(' | ', $errors));
        }

        return redirect()->back()->with('success', $message);
    }

    /**
     * Shared shipment-record creation used by single and bulk endpoints.
     * No label/postage purchase occurs here.
     */
    private function createUspsShipmentRecord($orderNo)
    {
        $order = StoreOrder::with('OrderItems', 'ShipmentDetails')
            ->where('order_no', $orderNo)
            ->first();

        if (!$order) {
            throw new \RuntimeException('Order not found.');
        }

        if (!Store::find($order->store_id)) {
            throw new \RuntimeException('Store not found.');
        }

        if (StoreShipment::where('store_order_no', $orderNo)->exists()) {
            throw new \RuntimeException('Shipment already exists for this order.');
        }

        if ($order->OrderItems->isEmpty()) {
            throw new \RuntimeException('Order has no items.');
        }

        $totalWeightOz = 0.0;

        foreach ($order->OrderItems as $item) {
            $product = $item->productDetails;

            if (!$product) {
                throw new \RuntimeException('Incomplete product or item details found.');
            }

            $qty = max(1, (int) $item->qty);
            $itemWeightOz = (float) ($product->shipping_weight ?: 5);
            $totalWeightOz += $itemWeightOz * $qty;
        }

        $totalWeightOz = max(1, round($totalWeightOz, 2));
        $totalWeightLb = max(0.01, round($totalWeightOz / 16, 4));

        if ((int) $order->shipping_method === 1) {
            $shippingName = trim($this->plainUspsText($order->first_name) . ' ' . $this->plainUspsText($order->last_name));
            $destinationZip = (string) $order->postal_code;
        } else {
            $shippingName = 'Encore Custom';
            $destinationZip = (string) config('services.usps.origin_zip', '94901');
        }

        $destinationZip = substr(preg_replace('/\D/', '', $destinationZip), 0, 5);

        if (strlen($destinationZip) !== 5) {
            throw new \RuntimeException('A valid 5-digit destination ZIP code is required.');
        }

        $payload = [
            'originZIPCode' => substr(
                preg_replace('/\D/', '', (string) config('services.usps.origin_zip', '94901')),
                0,
                5
            ),
            'destinationZIPCode' => $destinationZip,
            'weight' => $totalWeightLb,
            'length' => 14,
            'width' => 12,
            'height' => 4,
            'mailClass' => $this->mailClass,
            'processingCategory' => 'MACHINABLE',
            'destinationEntryFacilityType' => 'NONE',
            'rateIndicator' => 'SP',
            'priceType' => 'COMMERCIAL',
            'accountType' => config('services.usps.account_type', 'EPS'),
            'accountNumber' => config('services.usps.account_number'),
            'mailingDate' => now()->format('Y-m-d'),
        ];

        $result = $this->uspsService->getDomesticRates($payload);
        $rates = $this->formatUspsRates($result, $this->mailClass);

        if ($rates->isEmpty()) {
            throw new \RuntimeException('No USPS shipping rates available.');
        }

        $selectedRate = $rates->first();

        $shipment = new StoreShipment();
        $shipment->store_order_no = $orderNo;
        $shipment->store_id = $order->store_id;
        $shipment->shipping_name = $shippingName;
        $shipment->carrier = 'USPS';
        $shipment->shipment_id = 'USPS-' . $orderNo . '-' . time();
        $shipment->selected_rate = $selectedRate['mailClass'];
        $shipment->rate = $selectedRate['amount'];
        $shipment->service = $selectedRate['service'];
        $shipment->estimated_days = $selectedRate['estimated_days'];
        $shipment->is_shipping_removed = $order->is_shipping_removed ?? 0;
        $shipment->save();

        return $shipment;
    }

    // ==================== USPS LABEL MANAGEMENT ONLY ====================

    private function authorizeUspsLabelManagement(Request $request)
    {
        $user = $request->user();
        if (!$user || !$user->can('usps_manage_lables')) {
            abort(403, 'You do not have permission to manage USPS labels.');
        }
    }

    private function ensureUspsLabelTables()
    {
        if (!Schema::hasTable('usps_shipment_profiles') || !Schema::hasTable('usps_label_attempts')) {
            throw new \RuntimeException('USPS label management tables are missing. Import the supplied usps_label_management.sql file first.');
        }
    }

    private function plainUspsText($value)
    {
        $value = (string) $value;
        for ($i = 0; $i < 4; $i++) {
            $decoded = html_entity_decode($value, ENT_QUOTES | ENT_HTML5, 'UTF-8');
            if ($decoded === $value) {
                break;
            }
            $value = $decoded;
        }
        return trim(preg_replace('/\s+/u', ' ', $value));
    }

    private function uspsSenderAddress()
    {
        $sender = $this->uspsSender;

        $fullName = trim(
            (isset($sender['firstName']) ? $sender['firstName'] : '') . ' ' .
            (isset($sender['lastName']) ? $sender['lastName'] : '')
        );

        $firm = isset($sender['firm'])
            ? trim((string) $sender['firm'])
            : '';

        if (
            $fullName !== '' &&
            $firm !== '' &&
            strcasecmp($fullName, $firm) === 0
        ) {
            unset($sender['firm']);
        }

        $sender['ZIPCode'] =
            (string) config('services.usps.origin_zip', '94901');

        return $sender;
    }

    private function uspsRecipientFromProfile($profile)
    {
        $zip = explode('-', (string) $profile->recipient_zip, 2);
        return array_filter([
            'firstName' => $this->plainUspsText($profile->recipient_first_name),
            'lastName' => $this->plainUspsText($profile->recipient_last_name),
            'streetAddress' => $profile->recipient_street,
            'secondaryAddress' => $profile->recipient_street2,
            'city' => $profile->recipient_city,
            'state' => strtoupper((string) $profile->recipient_state),
            'ZIPCode' => isset($zip[0]) ? $zip[0] : null,
            'ZIPPlus4' => isset($zip[1]) ? $zip[1] : null,
            'country' => 'US',
            'phone' => $profile->recipient_phone,
            'email' => $profile->recipient_email,
        ], function ($value) {
            return $value !== null && $value !== '';
        });
    }

    private function profileMetadata($profile)
    {
        if (empty($profile->label_metadata)) {
            return [];
        }

        // UspsShipmentProfile casts label_metadata to an array. Keep this
        // fallback so older rows/models still work if the cast is removed.
        if (is_array($profile->label_metadata)) {
            return $profile->label_metadata;
        }

        $decoded = json_decode($profile->label_metadata, true);
        return is_array($decoded) ? $decoded : [];
    }

    private function profileContainers($profile)
    {
        $metadata = $this->profileMetadata($profile);
        $containers = isset($metadata['_local']['containers']) ? $metadata['_local']['containers'] : [];
        return is_array($containers) ? array_values($containers) : [];
    }

    private function parseUspsContainers($value)
    {
        if (is_array($value)) {
            $items = $value;
        } else {
            $text = trim((string) $value);
            if ($text === '') {
                return [];
            }
            $decoded = json_decode($text, true);
            $items = is_array($decoded) ? $decoded : explode(',', $text);
        }

        $clean = [];
        foreach ($items as $item) {
            if (!is_scalar($item)) {
                continue;
            }
            $item = trim((string) $item);
            if ($item !== '') {
                $clean[] = $item;
            }
        }
        return array_values(array_unique($clean));
    }

    private function mergeLocalContainersIntoMetadata($profile, array $containers, array $apiMetadata = null)
    {
        $current = $this->profileMetadata($profile);
        $metadata = $apiMetadata !== null ? $apiMetadata : $current;

        if (!isset($metadata['_local']) || !is_array($metadata['_local'])) {
            $metadata['_local'] = [];
        }
        if (isset($current['_local']) && is_array($current['_local'])) {
            $metadata['_local'] = array_merge($current['_local'], $metadata['_local']);
        }

        $metadata['_local']['containers'] = array_values($containers);
        return $metadata;
    }

    private function ensureUspsLabelProfile(StoreShipment $shipment, $lockForUpdate = false)
    {
        $this->ensureUspsLabelTables();

        $query = UspsShipmentProfile::query()
            ->where('store_shipment_id', $shipment->id);

        if ($lockForUpdate) {
            $query->lockForUpdate();
        }

        $existing = $query->first();
        if ($existing) {
            return $existing;
        }

        $order = StoreOrder::with('OrderItems')
            ->where('order_no', $shipment->store_order_no)
            ->firstOrFail();

        $weightOz = 0.0;
        foreach ($order->OrderItems as $item) {
            $product = $item->productDetails;
            $qty = max(1, (int) $item->qty);
            $weightOz += (float) (($product && $product->shipping_weight) ? $product->shipping_weight : 5) * $qty;
        }

        $isTrackingOnlyLegacy = !empty($shipment->tracking_number) && !empty($shipment->label_url) &&
            ($shipment->label_url === $shipment->tracking_url || strpos((string) $shipment->label_url, 'tools.usps.com') !== false);
        $hasExistingLabel = !empty($shipment->tracking_number) || (!empty($shipment->label_url) && !$isTrackingOnlyLegacy);
        $status = $isTrackingOnlyLegacy ? 'legacy' : ($hasExistingLabel ? 'created' : 'draft');

        $profile = UspsShipmentProfile::firstOrCreate(
            ['store_shipment_id' => $shipment->id],
            [
                'status' => $status,
                'recipient_first_name' => $this->plainUspsText($order->first_name),
                'recipient_last_name' => $this->plainUspsText($order->last_name),
                'recipient_street' => $order->street,
                'recipient_street2' => isset($order->street2) ? $order->street2 : (isset($order->street_2) ? $order->street_2 : null),
                'recipient_city' => $order->city,
                'recipient_state' => strtoupper((string) $order->state),
                'recipient_zip' => $order->postal_code,
                'recipient_phone' => $order->phone,
                'recipient_email' => $order->email,
                'recipient_country' => strtoupper((string) ($order->country ?: 'US')),
                'weight_lb' => max(0.0625, round(max($weightOz, 1) / 16, 4)),
                'length_in' => 14,
                'width_in' => 12,
                'height_in' => 4,
                'rate_indicator' => 'SP',
                'processing_category' => 'MACHINABLE',
                'destination_entry_facility_type' => 'NONE',
                'mailing_date' => now($this->uspsOriginTimezone)->format('Y-m-d'),
                // Existing/legacy labels may not have been created suppressed, so never assume they are editable.
                'suppress_postage' => $status === 'draft' ? 1 : 0,
                'label_metadata' => ['_local' => ['containers' => []]],
            ]
        );

        if ($lockForUpdate) {
            return UspsShipmentProfile::query()
                ->where('store_shipment_id', $shipment->id)
                ->lockForUpdate()
                ->firstOrFail();
        }

        return $profile;
    }

    private function draftLabelRules()
    {
        return [
            'recipient_first_name' => 'required|string|max:100',
            'recipient_last_name' => 'nullable|string|max:100',
            'recipient_street' => 'required|string|max:200',
            'recipient_street2' => 'nullable|string|max:160',
            'recipient_city' => 'required|string|max:100',
            'recipient_state' => ['required', 'regex:/^[A-Za-z]{2}$/'],
            'recipient_zip' => ['required', 'regex:/^\d{5}(-\d{4})?$/'],
            'recipient_phone' => 'nullable|string|max:36',
            'recipient_email' => 'nullable|email|max:190',
            'weight_lb' => 'required|numeric|min:0.01|max:70',
            'length_in' => 'required|numeric|min:0.1|max:130',
            'width_in' => 'required|numeric|min:0.1|max:130',
            'height_in' => 'required|numeric|min:0.1|max:130',
            'mail_class' => [
                'required',
                'string',
                'in:USPS_GROUND_ADVANTAGE,PRIORITY_MAIL,PRIORITY_MAIL_EXPRESS',
            ],
            'mailing_date' => [
                'required',
                'date_format:Y-m-d',
                'after_or_equal:' . now($this->uspsOriginTimezone)->format('Y-m-d'),
            ],
        ];
    }

    private function draftLabelMessages()
    {
        return [
            'recipient_first_name.required' => 'Recipient first name is required.',
            'recipient_first_name.max' => 'Recipient first name may not be longer than 100 characters.',

            'recipient_last_name.max' => 'Recipient last name may not be longer than 100 characters.',

            'recipient_street.required' => 'Recipient street address is required.',
            'recipient_street.max' => 'Recipient street address may not be longer than 200 characters.',

            'recipient_street2.max' => 'Recipient address line 2 may not be longer than 160 characters.',

            'recipient_city.required' => 'Recipient city is required.',
            'recipient_city.max' => 'Recipient city may not be longer than 100 characters.',

            'recipient_state.required' => 'Recipient state is required.',
            'recipient_state.regex' => 'Recipient state must be exactly 2 letters, for example CA.',

            'recipient_zip.required' => 'Recipient ZIP code is required.',
            'recipient_zip.regex' => 'Recipient ZIP code must be 5 digits or ZIP+4, for example 94901 or 94901-1234.',

            'recipient_phone.max' => 'Recipient phone may not be longer than 36 characters.',

            'recipient_email.email' => 'Recipient email must be a valid email address.',
            'recipient_email.max' => 'Recipient email may not be longer than 190 characters.',

            'weight_lb.required' => 'Package weight is required.',
            'weight_lb.numeric' => 'Package weight must be a number.',
            'weight_lb.min' => 'Package weight must be at least 0.01 lb.',
            'weight_lb.max' => 'Package weight may not exceed 70 lb.',

            'length_in.required' => 'Package length is required.',
            'length_in.numeric' => 'Package length must be a number.',
            'length_in.min' => 'Package length must be at least 0.1 in.',
            'length_in.max' => 'Package length may not exceed 130 in.',

            'width_in.required' => 'Package width is required.',
            'width_in.numeric' => 'Package width must be a number.',
            'width_in.min' => 'Package width must be at least 0.1 in.',
            'width_in.max' => 'Package width may not exceed 130 in.',

            'height_in.required' => 'Package height is required.',
            'height_in.numeric' => 'Package height must be a number.',
            'height_in.min' => 'Package height must be at least 0.1 in.',
            'height_in.max' => 'Package height may not exceed 130 in.',

            'mail_class.required' => 'Please select a USPS mail class.',
            'mail_class.in' => 'Please select a supported USPS mail class.',

            'mailing_date.required' => 'Shipping date is required.',
            'mailing_date.date_format' => 'Shipping date must be a valid date.',
            'mailing_date.after_or_equal' => 'Shipping date cannot be before today.',
        ];
    }

    private function draftLabelAttributes()
    {
        return [
            'recipient_first_name' => 'recipient first name',
            'recipient_last_name' => 'recipient last name',
            'recipient_street' => 'recipient street address',
            'recipient_street2' => 'recipient address line 2',
            'recipient_city' => 'recipient city',
            'recipient_state' => 'recipient state',
            'recipient_zip' => 'recipient ZIP code',
            'recipient_phone' => 'recipient phone',
            'recipient_email' => 'recipient email',
            'weight_lb' => 'package weight',
            'length_in' => 'package length',
            'width_in' => 'package width',
            'height_in' => 'package height',
            'mail_class' => 'USPS mail class',
            'mailing_date' => 'shipping date',
        ];
    }

    private function validateDraftLabelRequest(Request $request)
    {
        return $request->validate(
            $this->draftLabelRules(),
            $this->draftLabelMessages(),
            $this->draftLabelAttributes()
        );
    }

    private function saveDraftLabelData(StoreShipment $shipment, array $data)
    {
        $profile = $this->ensureUspsLabelProfile($shipment);
        if ($profile->status !== 'draft' || !empty($shipment->tracking_number) || !empty($shipment->label_url)) {
            throw new \RuntimeException('Recipient and full package details can only be changed before purchasing the label.');
        }

$metadata = $profile->label_metadata;

        $profile->fill([
            'recipient_first_name' => $this->plainUspsText($data['recipient_first_name']),
            'recipient_last_name' => $this->plainUspsText(isset($data['recipient_last_name']) ? $data['recipient_last_name'] : ''),
            'recipient_street' => $data['recipient_street'],
            'recipient_street2' => isset($data['recipient_street2']) ? $data['recipient_street2'] : null,
            'recipient_city' => $data['recipient_city'],
            'recipient_state' => strtoupper($data['recipient_state']),
            'recipient_zip' => $data['recipient_zip'],
            'recipient_phone' => isset($data['recipient_phone']) ? $data['recipient_phone'] : null,
            'recipient_email' => isset($data['recipient_email']) ? $data['recipient_email'] : null,
            'weight_lb' => (float) $data['weight_lb'],
            'length_in' => (float) $data['length_in'],
            'width_in' => (float) $data['width_in'],
            'height_in' => (float) $data['height_in'],
            // Hidden USPS pricing defaults for Encore parcel labels.
            'processing_category' => 'MACHINABLE',
            'rate_indicator' => 'SP',
            'mailing_date' => $data['mailing_date'],
            'suppress_postage' => 1,
            'label_metadata' => $metadata,
        ]);
        $profile->save();

        // Store the user-selected mail class before postage is purchased.
        $shipment->selected_rate = strtoupper((string) $data['mail_class']);
        $shipment->save();
    }

    private function buildUspsLabelPayload(StoreShipment $shipment, $profile)
    {
        if (empty($profile->recipient_street) || empty($profile->recipient_city) || empty($profile->recipient_state) || empty($profile->recipient_zip)) {
            throw new \RuntimeException('A complete recipient address is required before purchasing the label.');
        }
        if (empty($shipment->selected_rate)) {
            throw new \RuntimeException('The USPS mail class is missing for this shipment.');
        }

        $package = [
            'mailClass' => $shipment->selected_rate,
            'rateIndicator' => $profile->rate_indicator ?: 'SP',
            'processingCategory' => $profile->processing_category ?: 'MACHINABLE',
            'weightUOM' => 'lb',
            'weight' => (float) $profile->weight_lb,
            'dimensionsUOM' => 'in',
            'length' => (float) $profile->length_in,
            'width' => (float) $profile->width_in,
            'height' => (float) $profile->height_in,
            'destinationEntryFacilityType' => $profile->destination_entry_facility_type ?: 'NONE',
            'customerReference' => [
                [
                    'referenceNumber' => (string) $shipment->store_order_no,
                    'printReferenceNumber' => true,
                ],
            ],
            'mailingDate' => $profile->mailing_date ?: now($this->uspsOriginTimezone)->format('Y-m-d'),
            'extraServices' => [],
        ];

        return [
            'imageInfo' => [
                'imageType' => 'PDF',
                'labelType' => '4X6LABEL',
                // Required so the requested post-purchase package edits are eligible.
                'suppressPostage' => true,
            ],
            'fromAddress' => $this->uspsSenderAddress(),
            'toAddress' => $this->uspsRecipientFromProfile($profile),
            'packageDescription' => $package,
        ];
    }

    private function buildUspsLabelRatePayload(StoreShipment $shipment, array $data)
    {
        if (empty($data['mail_class'])) {
            throw new \RuntimeException('Please select a USPS mail class.');
        }

        $originZip = substr(
            preg_replace('/\D/', '', (string) config('services.usps.origin_zip', '94901')),
            0,
            5
        );

        $destinationZip = substr(
            preg_replace('/\D/', '', (string) $data['recipient_zip']),
            0,
            5
        );

        if (strlen($originZip) !== 5 || strlen($destinationZip) !== 5) {
            throw new \RuntimeException('A valid origin and destination ZIP code is required.');
        }

        return [
            'originZIPCode' => $originZip,
            'destinationZIPCode' => $destinationZip,
            'weight' => round((float) $data['weight_lb'], 4),
            'length' => (float) $data['length_in'],
            'width' => (float) $data['width_in'],
            'height' => (float) $data['height_in'],
            'mailClass' => strtoupper((string) $data['mail_class']),
            'processingCategory' => 'MACHINABLE',
            'destinationEntryFacilityType' => 'NONE',
            'rateIndicator' => 'SP',
            'priceType' => 'COMMERCIAL',
            'accountType' => config('services.usps.account_type', 'EPS'),
            'accountNumber' => config('services.usps.account_number'),
            'mailingDate' => $data['mailing_date'],
        ];
    }

    public function quoteLabelPostage(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);

        $shipment = StoreShipment::findOrFail((int) $id);
        $profile = $this->ensureUspsLabelProfile($shipment);

        if ($profile->status !== 'draft' ||
            !empty($shipment->tracking_number) ||
            !empty($shipment->label_url)) {
            return response()->json([
                'success' => false,
                'message' => 'Postage can only be quoted before the USPS label is purchased.',
            ], 422);
        }

        try {
            // Use the values currently visible in the label form. This lets the
            // user see the updated postage before purchasing even before Save Draft.
            $data = $this->validateDraftLabelRequest($request);

            $payload = $this->buildUspsLabelRatePayload($shipment, $data);

            $result = $this->uspsService->getDomesticRates($payload);
            $requestedMailClass = strtoupper((string) $data['mail_class']);
            $rates = $this->formatUspsRates($result, $requestedMailClass);

            if ($rates->isEmpty()) {
                return response()->json([
                    'success' => false,
                    'message' => 'No USPS postage rate is available for these label details.',
                ], 422);
            }

            $selectedMailClass = $requestedMailClass;

            $rate = $rates->first(function ($item) use ($selectedMailClass) {
                return strtoupper((string) ($item['mailClass'] ?? '')) === $selectedMailClass;
            });

            if (!$rate) {
                $rate = $rates->first();
            }

            // IMPORTANT: do not apply the customer shipping multiplier here.
            // This is the estimated USPS postage that the label purchase may charge.
            return response()->json([
                'success' => true,
                'estimated_postage' => round((float) $rate['amount'], 2),
                'currency' => $rate['currency'] ?? 'USD',
                'service' => $rate['service'] ?? $requestedMailClass,
                'mail_class' => $rate['mailClass'] ?? $requestedMailClass,
                'estimated_days' => $rate['estimated_days'] ?? null,
            ]);
        } catch (\Illuminate\Validation\ValidationException $e) {
            $errors = $e->errors();
            $field = null;
            $message = 'Please check the label details and try again.';

            foreach ($errors as $errorField => $fieldErrors) {
                $field = $errorField;

                if (!empty($fieldErrors[0])) {
                    $message = $fieldErrors[0];
                }

                break;
            }

            return response()->json([
                'success' => false,
                'message' => $message,
                'field' => $field,
                'errors' => $errors,
            ], 422);
        } catch (\Throwable $e) {
            return response()->json([
                'success' => false,
                'message' => $e->getMessage(),
            ], 500);
        }
    }

    private function purchaseUspsLabelByShipmentId($id)
    {
        $shipment = StoreShipment::findOrFail((int) $id);
        $initialProfile = $this->ensureUspsLabelProfile($shipment);

        // Validate the current draft before changing its status to creating.
        $payload = $this->buildUspsLabelPayload($shipment, $initialProfile);
        $uuid = (string) \Illuminate\Support\Str::uuid();

        DB::transaction(function () use ($shipment, $uuid) {
            $profile = $this->ensureUspsLabelProfile($shipment, true);
            $freshShipment = StoreShipment::query()
                ->whereKey($shipment->id)
                ->lockForUpdate()
                ->firstOrFail();

            if ($profile->status !== 'draft' || !empty($freshShipment->tracking_number) || !empty($freshShipment->label_url)) {
                throw new \RuntimeException('A label already exists or a previous label purchase requires review.');
            }

            UspsLabelAttempt::create([
                'store_shipment_id' => $shipment->id,
                'request_uuid' => $uuid,
                'label_type' => 'outbound',
                'state' => 'submitting',
            ]);

            $profile->fill([
                'status' => 'creating',
                'usps_label_request_uuid' => $uuid,
                'suppress_postage' => 1,
            ]);
            $profile->save();
        });

        $profile = UspsShipmentProfile::query()
            ->where('store_shipment_id', $shipment->id)
            ->firstOrFail();

        try {
            $created = $this->uspsService->createDomesticLabel($payload, $uuid);

            if (empty($created['success'])) {
                $attempt = UspsLabelAttempt::query()
                    ->where('request_uuid', $uuid)
                    ->first();
                if ($attempt) {
                    $attempt->fill([
                        'state' => 'failed',
                        'error_code' => isset($created['httpStatus']) ? (string) $created['httpStatus'] : null,
                        'error_message' => mb_substr(isset($created['message']) ? $created['message'] : 'USPS rejected label creation.', 0, 400),
                    ]);
                    $attempt->save();
                }

                $profile->fill([
                    'status' => 'draft',
                    'usps_label_request_uuid' => null,
                ]);
                $profile->save();

                return [
                    'success' => false,
                    'message' => isset($created['message']) ? $created['message'] : 'USPS rejected label creation.',
                ];
            }

            if (empty($created['trackingNumber']) || empty($created['labelPath'])) {
                throw new \RuntimeException('USPS may have created postage but the local tracking/PDF result is incomplete. Do not retry until you verify the USPS account.');
            }

            DB::transaction(function () use ($shipment, $created, $uuid) {
                $fresh = StoreShipment::query()
                    ->whereKey($shipment->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $profile = UspsShipmentProfile::query()
                    ->where('store_shipment_id', $shipment->id)
                    ->lockForUpdate()
                    ->firstOrFail();

                $fresh->tracking_object_id = $created['trackingNumber'];
                $fresh->tracking_number = $created['trackingNumber']; // Internal USPS label identifier for edit/reprint/cancel.
                $fresh->tracking_url = null; // No tracking feature in this label-only version.
                $fresh->label_url = route('usps.label.view', ['id' => $shipment->id]);
                $fresh->save();

                $metadata = $this->mergeLocalContainersIntoMetadata(
                    $profile,
                    $this->profileContainers($profile),
                    isset($created['labelMetadata']) && is_array($created['labelMetadata']) ? $created['labelMetadata'] : []
                );

                $profile->fill([
                    'status' => 'created',
                    'label_path' => $created['labelPath'],
                    'actual_postage' => isset($created['postage']) && is_numeric($created['postage']) ? $created['postage'] : null,
                    'label_metadata' => $metadata,
                    'label_created_at' => now(),
                    'reprint_count' => 0,
                    'refund_dispute_id' => null,
                    'refund_status' => null,
                ]);
                $profile->save();

                $attempt = UspsLabelAttempt::query()
                    ->where('request_uuid', $uuid)
                    ->lockForUpdate()
                    ->first();
                if ($attempt) {
                    $attempt->fill([
                        'state' => 'succeeded',
                        'tracking_number' => $created['trackingNumber'],
                    ]);
                    $attempt->save();
                }
            });

            return ['success' => true, 'message' => 'USPS label created and PDF saved successfully.'];
        } catch (\Throwable $e) {
            $profile = UspsShipmentProfile::query()
                ->where('store_shipment_id', $shipment->id)
                ->first();
            if ($profile) {
                $profile->status = 'review_required';
                $profile->save();
            }

            $attempt = UspsLabelAttempt::query()
                ->where('request_uuid', $uuid)
                ->first();
            if ($attempt) {
                $attempt->fill([
                    'state' => 'review_required',
                    'error_message' => mb_substr($e->getMessage(), 0, 400),
                ]);
                $attempt->save();
            }

            Log::error('USPS label purchase result uncertain', [
                'store_shipment_id' => $shipment->id,
                'request_uuid' => $uuid,
                'message' => $e->getMessage(),
            ]);

            return [
                'success' => false,
                'uncertain' => true,
                'message' => 'The USPS label result could not be confirmed. Do NOT retry this shipment until you verify that USPS did not create postage. ' . $e->getMessage(),
            ];
        }
    }

    private function buildUspsLabelManagerPageRecord(StoreShipment $shipment)
    {
        $profile = $this->ensureUspsLabelProfile($shipment);
        $containers = $this->profileContainers($profile);

        $legacyLabelUrl = null;
        if (empty($profile->label_path) && !empty($shipment->label_url) &&
            $shipment->label_url !== $shipment->tracking_url &&
            strpos((string) $shipment->label_url, 'tools.usps.com') === false) {
            $legacyLabelUrl = $shipment->label_url;
        }

        $today = now($this->uspsOriginTimezone)->format('Y-m-d');
        $mailingDate = !empty($profile->mailing_date)
            ? \Carbon\Carbon::parse($profile->mailing_date)->format('Y-m-d')
            : $today;

        if ($profile->status === 'draft' && $mailingDate < $today) {
            $mailingDate = $today;
        }

        $trackingUrl = $shipment->tracking_url;
        if (empty($trackingUrl) && !empty($shipment->tracking_number)) {
            $trackingUrl = 'https://tools.usps.com/go/TrackConfirmAction?tLabels=' .
                urlencode($shipment->tracking_number);
        }

        return [
            'shipment' => $shipment,
            'profile' => $profile,
            'containers' => $containers,
            'containers_text' => implode(', ', $containers),
            'mailing_date' => $mailingDate,
            'min_mailing_date' => $today,
            'legacy_label_url' => $legacyLabelUrl,
            'tracking_url' => $trackingUrl,
            'can_edit_recipient' => $profile->status === 'draft' &&
                empty($shipment->tracking_number) &&
                empty($shipment->label_url),
            'can_edit_package' => $profile->status === 'created' &&
                !empty($shipment->tracking_number) &&
                (int) $profile->suppress_postage === 1,
            'can_reprint' => $profile->status === 'created' &&
                !empty($shipment->tracking_number) &&
                (int) $profile->reprint_count < 3,
            'can_cancel_refund' => in_array($profile->status, ['created', 'edit_review'], true) &&
                !empty($shipment->tracking_number),
            'can_replace' => in_array($profile->status, ['canceled', 'refund_requested'], true),
            'has_saved_pdf' => !empty($profile->label_path),
        ];
    }

    private function renderUspsLabelManagerPage(Request $request, array $shipmentIds, $bulkMode)
    {
        $this->authorizeUspsLabelManagement($request);

        $shipmentIds = array_values(array_unique(array_map('intval', $shipmentIds)));

        if (empty($shipmentIds)) {
            return back()->with('error', 'Select at least one shipment.');
        }

        $shipments = StoreShipment::query()
            ->whereIn('id', $shipmentIds)
            ->get()
            ->keyBy('id');

        $records = collect();

        foreach ($shipmentIds as $shipmentId) {
            if (!$shipments->has($shipmentId)) {
                continue;
            }

            $records->push(
                $this->buildUspsLabelManagerPageRecord($shipments->get($shipmentId))
            );
        }

        if ($records->isEmpty()) {
            return back()->with('error', 'No USPS shipment records were found.');
        }

        $firstRecord = $records->first();
        $store = Store::find($firstRecord['shipment']->store_id);

        if (!$store) {
            return back()->with('error', 'Store not found for the selected USPS shipment(s).');
        }

        return view('pages.stores.shipping.label_manager', [
            'store' => $store,
            'records' => $records,
            'bulkMode' => (bool) $bulkMode,
            'shipmentIds' => $records->map(function ($record) {
                return (int) $record['shipment']->id;
            })->values()->all(),
            'draftShipmentIds' => $records
                ->filter(function ($record) {
                    return $record['profile']->status === 'draft';
                })
                ->map(function ($record) {
                    return (int) $record['shipment']->id;
                })
                ->values()
                ->all(),
        ]);
    }

    public function labelManagerPage(Request $request, $id)
    {
        return $this->renderUspsLabelManagerPage(
            $request,
            [(int) $id],
            false
        );
    }

    public function bulkLabelManagerPage(Request $request)
    {
        $this->authorizeUspsLabelManagement($request);

        $data = $request->validate([
            'shipment_ids' => 'required|array|min:1|max:25',
            'shipment_ids.*' => 'required|integer|distinct|exists:store_shipments,id',
        ]);

        return $this->renderUspsLabelManagerPage(
            $request,
            $data['shipment_ids'],
            true
        );
    }

    public function labelManagerData(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);
        $shipment = StoreShipment::findOrFail((int) $id);
        $profile = $this->ensureUspsLabelProfile($shipment);
        $containers = $this->profileContainers($profile);

        $legacyLabelUrl = null;
        if (empty($profile->label_path) && !empty($shipment->label_url) &&
            $shipment->label_url !== $shipment->tracking_url && strpos((string) $shipment->label_url, 'tools.usps.com') === false) {
            $legacyLabelUrl = $shipment->label_url;
        }

        $today = now($this->uspsOriginTimezone)->format('Y-m-d');
        $mailingDate = !empty($profile->mailing_date)
            ? \Carbon\Carbon::parse($profile->mailing_date)->format('Y-m-d')
            : $today;

        // If an old draft is opened on a later day, default the selector to
        // today instead of presenting an invalid past mailing date.
        if ($profile->status === 'draft' && $mailingDate < $today) {
            $mailingDate = $today;
        }

        return response()->json([
            'id' => $shipment->id,
            'shipment_id' => $shipment->shipment_id,
            'order_no' => $shipment->store_order_no,
            'shipping_name' => $shipment->shipping_name,
            'service' => $shipment->service,
            'selected_rate' => $shipment->selected_rate,
            'quoted_rate' => $shipment->rate,
            'status' => $profile->status,
            'recipient_first_name' => $this->plainUspsText($profile->recipient_first_name),
            'recipient_last_name' => $this->plainUspsText($profile->recipient_last_name),
            'recipient_street' => $profile->recipient_street,
            'recipient_street2' => $profile->recipient_street2,
            'recipient_city' => $profile->recipient_city,
            'recipient_state' => $profile->recipient_state,
            'recipient_zip' => $profile->recipient_zip,
            'recipient_phone' => $profile->recipient_phone,
            'recipient_email' => $profile->recipient_email,
            'weight_lb' => $profile->weight_lb,
            'length_in' => $profile->length_in,
            'width_in' => $profile->width_in,
            'height_in' => $profile->height_in,
            'processing_category' => $profile->processing_category,
            'rate_indicator' => $profile->rate_indicator,
            'mailing_date' => $mailingDate,
            'min_mailing_date' => $today,
            'containers' => $containers,
            'actual_postage' => $profile->actual_postage,
            'label_created_at' => $profile->label_created_at,
            'reprint_count' => (int) $profile->reprint_count,
            'refund_status' => $profile->refund_status,
            'refund_dispute_id' => $profile->refund_dispute_id,
            'has_saved_pdf' => !empty($profile->label_path),
            'legacy_label_url' => $legacyLabelUrl,
            'can_edit_recipient' => $profile->status === 'draft' && empty($shipment->tracking_number) && empty($shipment->label_url),
            'can_edit_package' => $profile->status === 'created' && !empty($shipment->tracking_number) && (int) $profile->suppress_postage === 1,
            'can_reprint' => $profile->status === 'created' && !empty($shipment->tracking_number) && (int) $profile->reprint_count < 3,
            'can_cancel_refund' => in_array($profile->status, ['created', 'edit_review'], true) && !empty($shipment->tracking_number),
            'can_replace' => in_array($profile->status, ['canceled', 'refund_requested'], true),
            'urls' => [
                'save_draft' => route('usps.label.save-draft', ['id' => $shipment->id]),
                'create' => route('usps.create_lable'),
                'view' => route('usps.label.view', ['id' => $shipment->id]),
                'download' => route('usps.label.download', ['id' => $shipment->id]),
                'print' => route('usps.label.print', ['id' => $shipment->id]),
                'edit' => route('usps.label.edit', ['id' => $shipment->id]),
                'reprint' => route('usps.label.reprint', ['id' => $shipment->id]),
                'cancel_refund' => route('usps.label.cancel-refund', ['id' => $shipment->id]),
                'replace' => route('usps.label.replace', ['id' => $shipment->id]),
            ],
        ]);
    }

    public function saveDraftLabel(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);
        $shipment = StoreShipment::findOrFail((int) $id);
        $data = $this->validateDraftLabelRequest($request);

        try {
            $this->saveDraftLabelData($shipment, $data);

            if ($request->expectsJson()) {
                return response()->json([
                    'success' => true,
                    'message' => 'USPS label draft saved.',
                    'shipment_id' => (int) $shipment->id,
                ]);
            }

            return back()->with('success', 'USPS label recipient and package details saved.');
        } catch (\Throwable $e) {
            if ($request->expectsJson()) {
                return response()->json([
                    'success' => false,
                    'message' => $e->getMessage(),
                ], 500);
            }

            return back()->with('error', $e->getMessage());
        }
    }

    public function create_lable(Request $request)
    {
        $this->authorizeUspsLabelManagement($request);

        $shipmentId = $request->input('shipment_id');
        if (empty($shipmentId)) {
            return back()->with('error', 'Shipment ID is missing.');
        }

        $shipment = StoreShipment::where('shipment_id', $shipmentId)->first();
        if (!$shipment) {
            return back()->with('error', 'Store shipment record not found.');
        }

        try {
            $this->ensureUspsLabelProfile($shipment);

            // The dedicated label manager page can save the draft and purchase in a single submit.
            if ($request->has('recipient_first_name')) {
                $data = $this->validateDraftLabelRequest($request);
                $this->saveDraftLabelData($shipment, $data);
            }

            $result = $this->purchaseUspsLabelByShipmentId($shipment->id);
            if (!empty($result['success'])) {
                return back()->with('success', $result['message']);
            }
            return back()->with(!empty($result['uncertain']) ? 'warning' : 'error', $result['message']);
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function viewLabel(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);
        return $this->serveSavedLabel($id, false);
    }

    public function downloadLabel(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);
        return $this->serveSavedLabel($id, true);
    }

    public function printLabel(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);
        // An inline PDF lets the browser's native PDF viewer handle printing.
        return $this->serveSavedLabel($id, false);
    }

    private function serveSavedLabel($id, $download)
    {
        $shipment = StoreShipment::findOrFail((int) $id);
        $profile = $this->ensureUspsLabelProfile($shipment);
        $path = $profile->label_path;

        if (empty($path)) {
            if (!empty($shipment->label_url) && $shipment->label_url !== $shipment->tracking_url && strpos((string) $shipment->label_url, 'tools.usps.com') === false) {
                return redirect()->away($shipment->label_url);
            }
            abort(404, 'No saved USPS label PDF was found.');
        }

        if (strpos((string) $path, 'usps-labels/') !== 0 || !Storage::disk('local')->exists($path)) {
            abort(404, 'The saved USPS label PDF is unavailable.');
        }

        $absolute = Storage::disk('local')->path($path);
        $filename = 'USPS-' . preg_replace('/[^A-Za-z0-9_-]/', '', (string) $shipment->store_order_no) . '.pdf';

        if ($download) {
            return response()->download($absolute, $filename, ['Content-Type' => 'application/pdf']);
        }
        return response()->file($absolute, [
            'Content-Type' => 'application/pdf',
            'Content-Disposition' => 'inline; filename="' . $filename . '"',
        ]);
    }

    public function editPurchasedLabel(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);
        $shipment = StoreShipment::findOrFail((int) $id);
        $profile = $this->ensureUspsLabelProfile($shipment);

        if ($profile->status !== 'created' || empty($shipment->tracking_number) || (int) $profile->suppress_postage !== 1) {
            return back()->with('error', 'This label is not eligible for USPS package-attribute editing.');
        }

        $data = $request->validate([
            'weight_lb' => 'required|numeric|min:0.01|max:70',
            'length_in' => 'required|numeric|min:0.1|max:130',
            'width_in' => 'required|numeric|min:0.1|max:130',
            'height_in' => 'required|numeric|min:0.1|max:130',
        ]);

        $changes = [];

        $numberMap = [
            'weight_lb' => 'weight',
            'length_in' => 'length',
            'width_in' => 'width',
            'height_in' => 'height',
        ];
        foreach ($numberMap as $dbField => $apiField) {
            if (abs((float) $data[$dbField] - (float) $profile->{$dbField}) > 0.00001) {
                $changes[$apiField] = (float) $data[$dbField];
            }
        }

        if (empty($changes)) {
            return back()->with('warning', 'No USPS label package changes were submitted.');
        }

        try {
            $result = $this->uspsService->editDomesticLabel($shipment->tracking_number, $changes);

            $profile->fill([
                'weight_lb' => (float) $data['weight_lb'],
                'length_in' => (float) $data['length_in'],
                'width_in' => (float) $data['width_in'],
                'height_in' => (float) $data['height_in'],
                'actual_postage' => isset($result['postage']) && is_numeric($result['postage']) ? $result['postage'] : $profile->actual_postage,
                'status' => 'created',
            ]);
            $profile->save();

            return back()->with('success', 'USPS accepted the label package edits. The existing label image remains valid for eligible edits.');
        } catch (\Throwable $e) {
            $profile->status = 'edit_review';
            $profile->save();
            return back()->with('error', 'USPS label edit could not be confirmed: ' . $e->getMessage());
        }
    }

    public function reprintLabel(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);
        $shipment = StoreShipment::findOrFail((int) $id);
        $profile = $this->ensureUspsLabelProfile($shipment);

        if ($profile->status !== 'created' || empty($shipment->tracking_number)) {
            return back()->with('error', 'No active USPS label is available for API reprint.');
        }
        if ((int) $profile->reprint_count >= 3) {
            return back()->with('error', 'USPS allows a maximum of 3 API reprints. Use the saved PDF instead.');
        }
        if (!empty($profile->mailing_date) && now($this->uspsOriginTimezone)->startOfDay()->gt(\Carbon\Carbon::parse($profile->mailing_date)->startOfDay())) {
            return back()->with('error', 'USPS API reprint is no longer available after the mailing date. Use the saved PDF instead.');
        }

        try {
            $result = $this->uspsService->reprintDomesticLabel($shipment->tracking_number);
            $profile->label_path = $result['labelPath'];
            $profile->reprint_count = ((int) $profile->reprint_count) + 1;
            $profile->save();
            return back()->with('success', 'USPS label reprinted and the saved PDF was refreshed.');
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function cancelOrRefundLabel(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);
        $shipment = StoreShipment::findOrFail((int) $id);
        $profile = $this->ensureUspsLabelProfile($shipment);

        if (!in_array($profile->status, ['created', 'edit_review'], true) || empty($shipment->tracking_number)) {
            return back()->with('error', 'No active USPS label is available to cancel or request a refund.');
        }

        try {
            $reply = $this->uspsService->cancelOrRefundLabel($shipment->tracking_number);
            $uspsStatus = strtoupper((string) (isset($reply['status']) ? $reply['status'] : ''));
            $disputeId = isset($reply['disputeId']) ? (string) $reply['disputeId'] : null;

            $isCanceled = $uspsStatus === 'CANCELED';
            $status = $isCanceled ? 'canceled' : 'refund_requested';
            $refundStatus = $uspsStatus !== '' ? $uspsStatus : ($disputeId ? 'REFUND_REQUESTED' : 'USPS_ACKNOWLEDGED');

            $profile->fill([
                'status' => $status,
                'refund_status' => $refundStatus,
                'refund_dispute_id' => $disputeId,
            ]);
            $profile->save();

            return back()->with('success', $isCanceled
                ? 'USPS canceled the unused label.'
                : 'USPS accepted the refund request. Dispute ID: ' . ($disputeId ?: 'not returned'));
        } catch (\Throwable $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function prepareReplacementLabel(Request $request, $id)
    {
        $this->authorizeUspsLabelManagement($request);
        $shipment = StoreShipment::findOrFail((int) $id);
        $profile = $this->ensureUspsLabelProfile($shipment);

        if (!in_array($profile->status, ['canceled', 'refund_requested'], true)) {
            return back()->with('error', 'The existing label must be canceled or have a refund request submitted before creating a replacement.');
        }

        $metadata = $this->profileMetadata($profile);
        if (!isset($metadata['_local']) || !is_array($metadata['_local'])) {
            $metadata['_local'] = [];
        }
        if (!isset($metadata['_local']['previous_labels']) || !is_array($metadata['_local']['previous_labels'])) {
            $metadata['_local']['previous_labels'] = [];
        }
        $metadata['_local']['previous_labels'][] = [
            'tracking_number' => $shipment->tracking_number,
            'label_path' => $profile->label_path,
            'actual_postage' => $profile->actual_postage,
            'refund_status' => $profile->refund_status,
            'refund_dispute_id' => $profile->refund_dispute_id,
            'replaced_at' => now()->toDateTimeString(),
        ];

        DB::transaction(function () use ($shipment, $profile, $metadata) {
            $shipment->tracking_object_id = null;
            $shipment->tracking_number = null;
            $shipment->tracking_url = null;
            $shipment->label_url = null;
            $shipment->save();

            $lockedProfile = UspsShipmentProfile::query()
                ->where('store_shipment_id', $shipment->id)
                ->lockForUpdate()
                ->firstOrFail();

            $lockedProfile->fill([
                'status' => 'draft',
                'suppress_postage' => 1,
                'usps_label_request_uuid' => null,
                'label_path' => null,
                'actual_postage' => null,
                'label_metadata' => $metadata,
                'label_created_at' => null,
                'reprint_count' => 0,
                'refund_dispute_id' => null,
                'refund_status' => null,
                'mailing_date' => now($this->uspsOriginTimezone)->format('Y-m-d'),
            ]);
            $lockedProfile->save();
        });

        return back()->with('success', 'Replacement label draft prepared. Edit the recipient/package if needed, then create the new label.');
    }

    public function bulkCreateLabels(Request $request)
    {
        $this->authorizeUspsLabelManagement($request);

        $data = $request->validate([
            'shipment_ids' => 'required|array|min:1|max:25',
            'shipment_ids.*' => 'required|integer|distinct|exists:store_shipments,id',
            'precheck_errors' => 'nullable|array|max:25',
            'precheck_errors.*' => 'nullable|string|max:1500',
        ]);

        $success = 0;
        $failed = [];

        /*
         * Include client-side validation/quote/save errors in the final result.
         */
        if (!empty($data['precheck_errors'])) {
            foreach ($data['precheck_errors'] as $precheckError) {
                $precheckError = trim((string) $precheckError);

                if ($precheckError !== '') {
                    $failed[] = $precheckError;
                }
            }
        }

        /*
         * Attempt every submitted shipment.
         * Never return from inside this loop.
         */
        foreach ($data['shipment_ids'] as $id) {
            $shipment = StoreShipment::find((int) $id);

            $label = $shipment && !empty($shipment->store_order_no)
                ? 'Order #' . $shipment->store_order_no
                : 'Shipment #' . (int) $id;

            try {
                $result = $this->purchaseUspsLabelByShipmentId((int) $id);

                if (!empty($result['success'])) {
                    $success++;
                    continue;
                }

                $failed[] = $label . ': ' . (
                    !empty($result['message'])
                        ? $result['message']
                        : 'USPS label was not created.'
                );
            } catch (\Throwable $e) {
                $failed[] = $label . ': ' . $e->getMessage();
            }
        }

        /*
         * Only after the whole batch is complete do we return once.
         */
        return back()->with('usps_bulk_result', [
            'created' => $success,
            'failed' => count($failed),
            'errors' => $failed,
        ]);
    }

    public function bulkDownloadLabels(Request $request)
    {
        $this->authorizeUspsLabelManagement($request);

        $data = $request->validate([
            'shipment_ids' => 'required|array|min:1|max:100',
            'shipment_ids.*' => 'required|integer|distinct|exists:store_shipments,id',
        ]);

        if (!class_exists('ZipArchive')) {
            return back()->with(
                'error',
                'PHP ZipArchive extension is required for bulk label ZIP download.'
            );
        }

        $profiles = UspsShipmentProfile::with('shipment')
            ->whereIn('store_shipment_id', $data['shipment_ids'])
            ->whereNotNull('label_path')
            ->get()
            ->keyBy('store_shipment_id');

        if ($profiles->isEmpty()) {
            return back()->with(
                'error',
                'No saved label PDFs were found for the selected shipments.'
            );
        }

        $tmpDir = storage_path('app/usps-label-bulk');

        if (!is_dir($tmpDir)) {
            @mkdir($tmpDir, 0775, true);
        }

        $zipPath =
            $tmpDir .
            '/usps-labels-' .
            date('Ymd-His') .
            '.zip';

        $zip = new \ZipArchive();

        if (
            $zip->open(
                $zipPath,
                \ZipArchive::CREATE | \ZipArchive::OVERWRITE
            ) !== true
        ) {
            return back()->with(
                'error',
                'Unable to create the USPS label ZIP file.'
            );
        }

        $added = 0;

        foreach ($data['shipment_ids'] as $shipmentId) {
            $profile = $profiles->get((int) $shipmentId);

            if (!$profile) {
                continue;
            }

            if (
                strpos((string) $profile->label_path, 'usps-labels/') !== 0 ||
                !Storage::disk('local')->exists($profile->label_path)
            ) {
                continue;
            }

            $shipment = $profile->shipment;

            $orderNo = $shipment
                ? preg_replace(
                    '/[^A-Za-z0-9_-]/',
                    '',
                    (string) $shipment->store_order_no
                )
                : (string) $profile->store_shipment_id;

            $name =
                'USPS-' .
                $orderNo .
                '-' .
                (int) $profile->store_shipment_id .
                '.pdf';

            $zip->addFile(
                Storage::disk('local')->path($profile->label_path),
                $name
            );

            $added++;
        }

        $zip->close();

        if ($added === 0) {
            @unlink($zipPath);

            return back()->with(
                'error',
                'No valid saved label PDFs were available for ZIP download.'
            );
        }

        return response()
            ->download(
                $zipPath,
                'usps-labels-' . date('Ymd-His') . '.zip'
            )
            ->deleteFileAfterSend(true);
    }

    private function findExistingPdfMergeCommand($command)
    {
        if (!function_exists('exec')) {
            return null;
        }

        $output = [];
        $status = 1;

        if (DIRECTORY_SEPARATOR === '\\') {
            @exec(
                'where ' . escapeshellarg($command) . ' 2>NUL',
                $output,
                $status
            );
        } else {
            @exec(
                'command -v ' . escapeshellarg($command) . ' 2>/dev/null',
                $output,
                $status
            );
        }

        if ($status !== 0 || empty($output[0])) {
            return null;
        }

        return trim((string) $output[0]);
    }

    private function runPdfMergeCommand($command)
    {
        if (!function_exists('exec')) {
            return false;
        }

        $output = [];
        $status = 1;

        @exec($command . ' 2>&1', $output, $status);

        return $status === 0;
    }

    private function mergeExistingPdfFiles(array $pdfPaths, $outputPath)
    {
        $pdfPaths = array_values(array_filter($pdfPaths, function ($path) {
            return is_string($path) && is_file($path);
        }));

        if (empty($pdfPaths)) {
            return false;
        }

        if (count($pdfPaths) === 1) {
            return @copy($pdfPaths[0], $outputPath);
        }

        // Use an existing server command only. No Composer dependency is added.

        $pdfunite = $this->findExistingPdfMergeCommand('pdfunite');

        if ($pdfunite !== null) {
            $parts = [
                escapeshellarg($pdfunite),
            ];

            foreach ($pdfPaths as $path) {
                $parts[] = escapeshellarg($path);
            }

            $parts[] = escapeshellarg($outputPath);

            if (
                $this->runPdfMergeCommand(implode(' ', $parts)) &&
                is_file($outputPath) &&
                filesize($outputPath) > 0
            ) {
                return true;
            }
        }

        $qpdf = $this->findExistingPdfMergeCommand('qpdf');

        if ($qpdf !== null) {
            $parts = [
                escapeshellarg($qpdf),
                '--empty',
                '--pages',
            ];

            foreach ($pdfPaths as $path) {
                $parts[] = escapeshellarg($path);
                $parts[] = '1-z';
            }

            $parts[] = '--';
            $parts[] = escapeshellarg($outputPath);

            if (
                $this->runPdfMergeCommand(implode(' ', $parts)) &&
                is_file($outputPath) &&
                filesize($outputPath) > 0
            ) {
                return true;
            }
        }

        $pdftk = $this->findExistingPdfMergeCommand('pdftk');

        if ($pdftk !== null) {
            $parts = [
                escapeshellarg($pdftk),
            ];

            foreach ($pdfPaths as $path) {
                $parts[] = escapeshellarg($path);
            }

            $parts[] = 'cat';
            $parts[] = 'output';
            $parts[] = escapeshellarg($outputPath);

            if (
                $this->runPdfMergeCommand(implode(' ', $parts)) &&
                is_file($outputPath) &&
                filesize($outputPath) > 0
            ) {
                return true;
            }
        }

        $mutool = $this->findExistingPdfMergeCommand('mutool');

        if ($mutool !== null) {
            $parts = [
                escapeshellarg($mutool),
                'merge',
                '-o',
                escapeshellarg($outputPath),
            ];

            foreach ($pdfPaths as $path) {
                $parts[] = escapeshellarg($path);
            }

            if (
                $this->runPdfMergeCommand(implode(' ', $parts)) &&
                is_file($outputPath) &&
                filesize($outputPath) > 0
            ) {
                return true;
            }
        }

        $ghostscriptCommands = [
            'gswin64c',
            'gswin32c',
            'gs',
        ];

        foreach ($ghostscriptCommands as $ghostscriptCommand) {
            $gs = $this->findExistingPdfMergeCommand($ghostscriptCommand);

            if ($gs === null) {
                continue;
            }

            $parts = [
                escapeshellarg($gs),
                '-dBATCH',
                '-dNOPAUSE',
                '-q',
                '-sDEVICE=pdfwrite',
                '-sOutputFile=' . escapeshellarg($outputPath),
            ];

            foreach ($pdfPaths as $path) {
                $parts[] = escapeshellarg($path);
            }

            if (
                $this->runPdfMergeCommand(implode(' ', $parts)) &&
                is_file($outputPath) &&
                filesize($outputPath) > 0
            ) {
                return true;
            }
        }

        return false;
    }

    public function bulkPrintLabels(Request $request)
    {
        $this->authorizeUspsLabelManagement($request);

        $data = $request->validate([
            'shipment_ids' => 'required|array|min:1|max:100',
            'shipment_ids.*' => 'required|integer|distinct|exists:store_shipments,id',
        ]);

        $profiles = UspsShipmentProfile::with('shipment')
            ->whereIn('store_shipment_id', $data['shipment_ids'])
            ->whereNotNull('label_path')
            ->get()
            ->keyBy('store_shipment_id');

        if ($profiles->isEmpty()) {
            return back()->with(
                'error',
                'No saved label PDFs were found for the selected shipments.'
            );
        }

        $pdfPaths = [];

        foreach ($data['shipment_ids'] as $shipmentId) {
            $profile = $profiles->get((int) $shipmentId);

            if (!$profile) {
                continue;
            }

            if (
                strpos((string) $profile->label_path, 'usps-labels/') !== 0 ||
                !Storage::disk('local')->exists($profile->label_path)
            ) {
                continue;
            }

            $pdfPaths[] = Storage::disk('local')->path(
                $profile->label_path
            );
        }

        if (empty($pdfPaths)) {
            return back()->with(
                'error',
                'No valid saved label PDFs were available for the selected shipments.'
            );
        }

        if (count($pdfPaths) === 1) {
            return response()->download(
                $pdfPaths[0],
                'usps-label-' . date('Ymd-His') . '.pdf',
                [
                    'Content-Type' => 'application/pdf',
                ]
            );
        }

        $tmpDir = storage_path('app/usps-label-bulk');

        if (!is_dir($tmpDir)) {
            @mkdir($tmpDir, 0775, true);
        }

        $mergedPath =
            $tmpDir .
            '/usps-labels-' .
            date('Ymd-His') .
            '-' .
            uniqid() .
            '.pdf';

        if ($this->mergeExistingPdfFiles($pdfPaths, $mergedPath)) {
            return response()
                ->download(
                    $mergedPath,
                    'usps-labels-' . date('Ymd-His') . '.pdf',
                    [
                        'Content-Type' => 'application/pdf',
                    ]
                )
                ->deleteFileAfterSend(true);
        }

        /*
         * IMPORTANT:
         * Do NOT fall back to ZIP here.
         *
         * This route is the "Download Selected PDF" action, so returning the
         * ZIP response makes both top buttons download ZIP files.
         *
         * If this server has no existing PDF merge command, return to the page
         * with a clear error instead. The ZIP button continues to use
         * bulkDownloadLabels() separately.
         */
        return back()->with(
            'error',
            'Unable to merge the selected USPS labels into one PDF because no existing PDF merge command is available on this server. ZIP download is still available.'
        );
    }

    public function showImportForm()

    {

        return view('pages.stores.usps_labels.import');

    }

    public function import(Request $request)

    {

        $request->validate([

            'xlsx_file' => ['required'],

        ]);

        $errors = [];

        $successCount = 0;

        $skippedCount = 0;

        $updatedCount = 0;

        try {

            $spreadsheet = IOFactory::load($request->file('xlsx_file')->getRealPath());

            $sheet = $spreadsheet->getActiveSheet();

            $rows = $sheet->toArray(null, true, true, true);

            if (count($rows) < 2) {

                return back()->with('error', 'Excel file is empty.');

            }

            $headerRow = array_shift($rows);

            $map = [];

            foreach ($headerRow as $column => $heading) {

                $heading = trim((string) $heading);

                if ($heading !== '') {

                    $map[$heading] = $column;

                }

            }

            $requiredColumns = [

                'Reference Number',

                'Tracking Number',

                'Service Type',

                'Cost',

                'Date',

            ];

            foreach ($requiredColumns as $columnName) {

                if (!isset($map[$columnName])) {

                    return back()->with('error', "Missing required column: {$columnName}");

                }

            }

            DB::beginTransaction();

            foreach ($rows as $excelRowNumber => $row) {

                $rowNumber = $excelRowNumber + 1;

                $referenceNumber = trim((string) ($row[$map['Reference Number']] ?? ''));

                // Import only rows where Reference Number is not empty

                if ($referenceNumber == '') {

                    $skippedCount++;

                    continue;

                }

                $trackingNumber = trim((string) ($row[$map['Tracking Number']] ?? ''));

                $serviceType = trim((string) ($row[$map['Service Type']] ?? ''));

                $cost = trim((string) ($row[$map['Cost']] ?? ''));

                $shipmentID = 'USPS-' . $referenceNumber . '-' . time();

                if ($trackingNumber == '') {

                    $errors[] = "Row {$rowNumber}: Tracking Number is empty for order {$referenceNumber}.";

                    continue;

                }

                $trackingUrl = 'https://tools.usps.com/go/TrackConfirmAction?tLabels=' . urlencode($trackingNumber);

                $storeOrder = StoreOrder::with('storeDetails','storeCustomer')->where('order_no', $referenceNumber)->first();

                if (!$storeOrder) {

                    $errors[] = "Row {$rowNumber}: Order with Reference Number {$referenceNumber} not found.";

                    continue;

                }

                $shipment = StoreShipment::where('store_order_no', $storeOrder->order_no)->first();

                if ($shipment) {

                    $shipment->carrier = 'USPS';

                    $shipment->shipment_id = $shipmentID;

                    $shipment->estimated_days = '1-3 Days';

                    $shipment->selected_rate = $serviceType;

                    $shipment->service = $serviceType;

                    $shipment->rate = is_numeric($cost) ? $cost : 0;

                    $shipment->tracking_number = $trackingNumber;

                    $shipment->tracking_url = $trackingUrl;

                    if(empty($shipment->label_url)) {

                        $shipment->label_url = $trackingUrl;

                    }

                    $shipment->save();

                    $updatedCount++;

                } else {

                    $newShipment = new StoreShipment();

                    $newShipment->store_order_no = $storeOrder->order_no;

                    $newShipment->store_id = $storeOrder->store_id;

                    $newShipment->shipping_name = $storeOrder->first_name . ' ' . $storeOrder->last_name;

                    $newShipment->carrier = 'USPS';

                    $newShipment->shipment_id = $shipmentID;

                    $newShipment->estimated_days = '1-3 Days';

                    $newShipment->selected_rate = $serviceType;

                    $newShipment->service = $serviceType;

                    $newShipment->rate = is_numeric($cost) ? $cost : 0;

                    $newShipment->tracking_number = $trackingNumber;

                    $newShipment->tracking_url = $trackingUrl;

                    $newShipment->label_url = $trackingUrl; // because USPS old label PDF URL is unavailable

                    $newShipment->save();

                    $successCount++;

                }

            }

            DB::commit();

            $message = "{$successCount} created, {$updatedCount} updated, {$skippedCount} skipped because Reference Number was empty.";

            if (!empty($errors)) {

                return back()

                    ->with('warning', $message)

                    ->with('import_errors', $errors);

            }

            return back()->with('success', $message);

        } catch (\Throwable $e) {

            DB::rollBack();

            return back()->with('error', 'Import failed: ' . $e->getMessage());

        }

    }

    private function parseUspsDate(?string $date): ?string

    {

        if (!$date) {

            return null;

        }

        try {

            return \Carbon\Carbon::parse($date)->format('Y-m-d');

        } catch (\Throwable $e) {

            return null;

        }

    }

}
