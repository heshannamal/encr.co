<?php

namespace App\Http\Controllers;

use App\Models\EMCustomer;
use App\Models\EMCustomerChild;
use App\Models\EMCustomerCredit;
use App\Models\EMCustomerCreditLog;
use App\Models\EMCustomerPackageCart;
use App\Models\EMPackage;
use App\Models\EMPackageOrder;
use App\Models\EMPackageOrderItem;
use App\Models\EMSessionBooking;
use App\Models\EMSessionEvent;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;
use App\Models\EMPackagePaymentLog;
use net\authorize\api\contract\v1 as AnetAPI;
use net\authorize\api\controller as AnetController;

class EMCustomerController extends Controller
{
    private function customer()
    {
        $customerId = session('em_customer_id');

        if (!$customerId) {
            return null;
        }

        return EMCustomer::find($customerId);
    }

    private function cartCount()
    {
        $customer = $this->customer();
        if (!$customer) return 0;
        return EMCustomerPackageCart::where('customer_id', $customer->id)->sum('quantity');
    }

    private function shellData()
    {
        return [
            'customer' => $this->customer(),
            'cartCount' => $this->cartCount(),
        ];
    }

    public function login()
    {
        if (session('em_customer_id')){
            if(request()->has('redirect')){
                return redirect(request()->get('redirect'));
            }
            return redirect()->route('em.customer.dashboard');
        }

        return view('pages.customer_sessions.auth', ['mode' => 'login', 'redirect' => request()->get('redirect')]);
    }

    public function register()
    {
        if (session('em_customer_id')){
            if(request()->has('redirect')){
                return redirect(request()->get('redirect'));
            }
            return redirect()->route('em.customer.dashboard');
        }
        return view('pages.customer_sessions.auth', ['mode' => 'register', 'redirect' => request()->get('redirect')]);
    }

    public function landingIndex()
    {
        $customer = $this->customer();

        $packages = EMPackage::active()
            ->latest()
            ->limit(6)
            ->get();

        $sessions = EMSessionEvent::where('is_active', 1)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->limit(9)
            ->get();

        $cartCount = 0;
        $children = collect();
        $remainingCredits = 0;
        $usedCredits = 0;
        $bookingsCount = 0;

        if ($customer) {
            $cartCount = $this->cartCount();

            $children = EMCustomerChild::where('customer_id', $customer->id)
                ->where('is_active', 1)
                ->orderBy('player_first')
                ->get();

            $remainingCredits = EMCustomerCredit::where('customer_id', $customer->id)
                ->where('status', 'active')
                ->sum('remaining_classes');

            $usedCredits = EMCustomerCredit::where('customer_id', $customer->id)
                ->sum('used_classes');

            $bookingsCount = EMSessionBooking::where('customer_id', $customer->id)
                ->whereIn('status', ['booked', 'completed'])
                ->count();
        }

        return view('pages.customer_sessions.landing.index', compact(
            'customer',
            'packages',
            'sessions',
            'cartCount',
            'children',
            'remainingCredits',
            'usedCredits',
            'bookingsCount'
        ));
    }

    public function landingPackages()
    {
        $packages = EMPackage::active()
            ->latest()
            ->get();

        return view(
            'pages.customer_sessions.landing.packages',
            array_merge($this->shellData(), compact('packages'))
        );
    }

    public function landingPackageDetails($id)
    {
        $package = EMPackage::active()->findOrFail($id);

        return view(
            'pages.customer_sessions.landing.package-details',
            array_merge($this->shellData(), compact('package'))
        );
    }

    public function landingAddToCart(Request $request, $id)
    {
        $customer = $this->customer();
        $package = EMPackage::active()->findOrFail($id);
        $qty = max(1, (int) $request->get('quantity', 1));

        $cart = EMCustomerPackageCart::firstOrNew([
            'customer_id' => $customer->id,
            'package_id' => $package->id,
        ]);

        $cart->quantity = (int) $cart->quantity + $qty;
        $cart->unit_price = $package->package_price;
        $cart->total_price = $cart->quantity * $cart->unit_price;
        $cart->save();

        return redirect()
            ->route('em.customer.landing.cart')
            ->with('success', 'Package added to cart.');
    }

    public function landingCart()
    {
        $customer = $this->customer();

        $items = EMCustomerPackageCart::with('package')
            ->where('customer_id', $customer->id)
            ->get();

        $subtotal = $items->sum('total_price');

        return view(
            'pages.customer_sessions.landing.cart',
            array_merge($this->shellData(), compact('items', 'subtotal'))
        );
    }

    public function landingUpdateCart(Request $request, $id)
    {
        $item = EMCustomerPackageCart::where('customer_id', $this->customer()->id)
            ->findOrFail($id);

        $qty = max(1, (int) $request->get('quantity', 1));

        $item->quantity = $qty;
        $item->total_price = $qty * $item->unit_price;
        $item->save();

        return back()->with('success', 'Cart updated.');
    }

    public function landingRemoveCart($id)
    {
        EMCustomerPackageCart::where('customer_id', $this->customer()->id)
            ->where('id', $id)
            ->delete();

        return back()->with('success', 'Item removed.');
    }

    public function registerSubmit(Request $request)
    {
        $data = $request->validate([
            'first_name' => 'required|string|max:190',
            'last_name' => 'nullable|string|max:190',
            'email' => 'required|email|max:190|unique:em_customers,email',
            'phone' => 'nullable|string|max:80',
            'password' => 'required|string|min:6|confirmed',
        ], [
            'first_name.required' => 'Full name is required.',
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'email.unique' => 'This email is already registered.',
            'password.required' => 'Password is required.',
            'password.min' => 'Password must be at least 6 characters.',
            'password.confirmed' => 'Password confirmation does not match.',
        ]);

        $customer = EMCustomer::create([
            'first_name' => $data['first_name'],
            'last_name' => $data['last_name'],
            'email' => $data['email'],
            'phone' => isset($data['phone']) ? $data['phone'] : null,
            'password' => Hash::make($data['password']),
            'active' => 1,
        ]);

        session(['em_customer_id' => $customer->id]);

        $redirectUrl = $request->get('redirect') ?? null;

        if ($redirectUrl) {
            return redirect($redirectUrl)->with('success', 'Logged in successfully.');
        }
        return redirect()->route('em.customer.dashboard')->with('success', 'Account created successfully.');
    }

    public function loginSubmit(Request $request)
    {
        $data = $request->validate([
            'email' => 'required|email',
            'password' => 'required|string',
        ], [
            'email.required' => 'Email is required.',
            'email.email' => 'Please enter a valid email address.',
            'password.required' => 'Password is required.',
        ]);

        $customer = EMCustomer::where('email', $data['email'])->first();

        if (!$customer || !Hash::check($data['password'], $customer->password)) {
            return back()->withErrors(['email' => 'Invalid email or password.'])->withInput();
        }

        if (isset($customer->is_active) && !$customer->is_active) {
            return back()->withErrors(['email' => 'Your account is inactive.'])->withInput();
        }

        session(['em_customer_id' => $customer->id]);

        $redirectUrl = $request->get('redirect') ?? null;

        if ($redirectUrl) {
            return redirect($redirectUrl)->with('success', 'Logged in successfully.');
        }

        return redirect()->route('em.customer.dashboard')->with('success', 'Logged in successfully.');
    }

    public function logout()
    {
        session()->forget('em_customer_id');
        $redirectUrl = route('em.customer.index');

        if ($redirectUrl) {
            return redirect($redirectUrl)->with('success', 'Logged in successfully.');
        }
        return redirect()->route('em.customer.login')->with('success', 'Logged out successfully.');
    }

    public function googleRedirect()
    {
        $query = http_build_query([
            'client_id' => config('services.google.client_id'),
            'redirect_uri' => config('services.google.redirect'),
            'response_type' => 'code',
            'scope' => 'openid email profile',
            'access_type' => 'online',
            'prompt' => 'select_account',
        ]);

        return redirect(
            'https://accounts.google.com/o/oauth2/v2/auth?' . $query
        );
    }

    public function googleCallback(Request $request)
    {
        if (!$request->filled('code')) {
            return redirect()
                ->route('em.customer.login')
                ->with('error', 'Google login was cancelled or failed.');
        }

        $token = Http::asForm()->post(
            'https://oauth2.googleapis.com/token',
            [
                'client_id' => config('services.google.client_id'),
                'client_secret' => config('services.google.client_secret'),
                'redirect_uri' => config('services.google.redirect'),
                'grant_type' => 'authorization_code',
                'code' => $request->get('code'),
            ]
        );

        if (!$token->successful()) {
            return redirect()
                ->route('em.customer.login')
                ->with('error', 'Google authentication failed.');
        }

        $accessToken = $token->json('access_token');

        $profile = Http::withToken($accessToken)
            ->get('https://www.googleapis.com/oauth2/v2/userinfo');

        if (!$profile->successful()) {
            return redirect()
                ->route('em.customer.login')
                ->with('error', 'Unable to retrieve your Google profile.');
        }

        $google = $profile->json();

        $customer = EMCustomer::updateOrCreate(
            [
                'email' => $google['email'],
            ],
            [
                'name' => isset($google['name'])
                    ? $google['name']
                    : $google['email'],

                'google_id' => isset($google['id'])
                    ? $google['id']
                    : null,

                'profile_photo' => isset($google['picture'])
                    ? $google['picture']
                    : null,

                'email_verified_at' => now(),
                'active' => 1,
            ]
        );

        session()->regenerate();
        session(['em_customer_id' => $customer->id]);

        return redirect()
            ->route('em.customer.dashboard')
            ->with('success', 'Logged in successfully with Google.');
    }

    public function dashboard()
    {
        $customer = $this->customer();

        if (!$customer) {
            session()->forget('em_customer_id');

            return redirect()
                ->route('em.customer.login')
                ->with('error', 'Please log in to access your dashboard.');
        }

        $credits = EMCustomerCredit::with('package')
            ->where('customer_id', $customer->id)
            ->where('status', 'active')
            ->latest()
            ->get();

        $children = EMCustomerChild::where('customer_id', $customer->id)
            ->where('is_active', 1)
            ->orderBy('player_first')
            ->get();

        $sessions = EMSessionEvent::where('is_active', 1)
            ->whereDate('event_date', '>=', now()->toDateString())
            ->orderBy('event_date')
            ->orderBy('start_time')
            ->get();

        $remainingCredits = $credits->sum('remaining_classes');
        $usedCredits = EMCustomerCredit::where('customer_id', $customer->id)
            ->sum('used_classes');

        $bookings = EMSessionBooking::with([
                'sessionEvent',
                'child',
            ])
            ->where('customer_id', $customer->id)
            ->latest()
            ->get();

        return view(
            'pages.customer_sessions.dashboard',
            array_merge(
                $this->shellData(),
                compact(
                    'customer',
                    'credits',
                    'children',
                    'sessions',
                    'remainingCredits',
                    'usedCredits',
                    'bookings'
                )
            )
        );
    }

    public function packages()
    {
        $packages = EMPackage::active()->latest()->get();
        return view('pages.customer_sessions.packages', array_merge($this->shellData(), compact('packages')));
    }

    public function packageDetails($id)
    {
        $package = EMPackage::active()->findOrFail($id);
        return view('pages.customer_sessions.package-details', array_merge($this->shellData(), compact('package')));
    }

    public function addToCart(Request $request, $id)
    {
        $customer = $this->customer();
        $package = EMPackage::active()->findOrFail($id);
        $qty = max(1, (int) $request->get('quantity', 1));

        $cart = EMCustomerPackageCart::firstOrNew([
            'customer_id' => $customer->id,
            'package_id' => $package->id,
        ]);
        $cart->quantity = (int) $cart->quantity + $qty;
        $cart->unit_price = $package->package_price;
        $cart->total_price = $cart->quantity * $cart->unit_price;
        $cart->save();

        return redirect()->route('em.customer.cart')->with('success', 'Package added to cart.');
    }

    public function cart()
    {
        $items = EMCustomerPackageCart::with('package')->where('customer_id', $this->customer()->id)->get();
        $subtotal = $items->sum('total_price');
        return view('pages.customer_sessions.cart', array_merge($this->shellData(), compact('items','subtotal')));
    }

    public function updateCart(Request $request, $id)
    {
        $item = EMCustomerPackageCart::where('customer_id', $this->customer()->id)->findOrFail($id);
        $qty = max(1, (int) $request->get('quantity', 1));
        $item->quantity = $qty;
        $item->total_price = $qty * $item->unit_price;
        $item->save();
        return back()->with('success', 'Cart updated.');
    }

    public function removeCart($id)
    {
        EMCustomerPackageCart::where('customer_id', $this->customer()->id)->where('id', $id)->delete();
        return back()->with('success', 'Item removed.');
    }

    public function checkout()
    {
        $customer = $this->customer();

        if (!$customer) {
            return redirect()
                ->route('em.customer.login', ['redirect' => route('em.customer.checkout')])
                ->with('error', 'Please log in to continue checkout.');
        }

        $items = EMCustomerPackageCart::with('package')
            ->where('customer_id', $customer->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('em.customer.cart')
                ->with('error', 'Cart is empty.');
        }

        $totals = $this->landingCartTotals($items);
        $subtotal = $totals['subtotal'];

        return view(
            'pages.customer_sessions.checkout',
            array_merge(
                $this->shellData(),
                compact('items', 'subtotal', 'totals')
            )
        );
    }

    public function pay(Request $request)
    {
        $request->validate([
            'owner' => 'required|string|max:190',
            'cardNumber' => 'required|string|min:12|max:25',
            'expiration-month' => 'required|string|size:2',
            'expiration-year' => 'required|string|size:4',
            'cvv' => 'required|string|min:3|max:4',

            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:190',
            'phone' => 'nullable|string|max:50',
            'street' => 'required|string|max:190',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:30',
            'country' => 'required|string|max:100',
        ]);

        $customer = $this->customer();

        if (!$customer) {
            return redirect()
                ->route('em.customer.login', ['redirect' => route('em.customer.checkout')])
                ->with('error', 'Please log in to continue payment.');
        }

        $items = EMCustomerPackageCart::with('package')
            ->where('customer_id', $customer->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('em.customer.cart')
                ->with('error', 'Cart is empty.');
        }

        $totals = $this->landingCartTotals($items);
        $orderNo = 'ORD-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $paymentResult = $this->processLandingAuthorizePayment(
            $request,
            $customer,
            $orderNo,
            $totals['total']
        );

        if (!$paymentResult['success']) {
            return back()
                ->withInput()
                ->with('error', $paymentResult['message'] ?? 'Payment failed. Please try again.');
        }

        return DB::transaction(function () use ($customer, $items, $totals, $request, $orderNo, $paymentResult) {
            $cardNumber = preg_replace('/\D+/', '', $request->cardNumber);
            $cardLastFour = substr($cardNumber, -4);

            $order = new EMPackageOrder();
            $order->customer_id = $customer->id;
            $order->order_no = $orderNo;
            $order->subtotal = $totals['subtotal'];
            $order->tax = $totals['tax'];
            $order->total = $totals['total'];
            $order->payment_status = 'paid';
            $order->payment_method = 'card';
            $order->card_last_four = $cardLastFour;
            $order->paid_at = now();

            $orderTable = $order->getTable();

            if (Schema::hasColumn($orderTable, 'processing_fee')) {
                $order->processing_fee = $totals['processing_fee'];
            }

            $order->save();

            EMPackagePaymentLog::create([
                'package_order_id' => $order->id,
                'customer_id' => $customer->id,

                'gateway' => 'authorize_net',
                'environment' => is_string($paymentResult['environment'] ?? null)
                    ? $paymentResult['environment']
                    : null,
                'payment_method' => 'card',
                'status' => 'success',

                'subtotal' => $totals['subtotal'],
                'processing_fee' => $totals['processing_fee'],
                'tax' => $totals['tax'],
                'amount' => $totals['total'],

                'response_code' => $paymentResult['response_code'] ?? null,
                'transaction_id' => $paymentResult['transaction_id'] ?? null,
                'auth_id' => $paymentResult['auth_code'] ?? null,
                'message_code' => $paymentResult['message_code'] ?? null,
                'message_text' => $paymentResult['message'] ?? null,
                'ref_id' => $paymentResult['ref_id'] ?? null,

                'name_on_card' => trim($request->owner),
                'card_last_four' => $cardLastFour,

                'billing_first_name' => $request->first_name,
                'billing_last_name' => $request->last_name,
                'billing_email' => $request->email,
                'billing_phone' => $request->phone,
                'billing_street' => $request->street,
                'billing_city' => $request->city,
                'billing_state' => $request->state,
                'billing_zip' => $request->zip_code,
                'billing_country' => $request->country,

                'quantity' => 1,
                'paid_at' => now(),
            ]);

            foreach ($items as $item) {
                $package = $item->package;

                if (!$package) {
                    continue;
                }

                EMPackageOrderItem::create([
                    'order_id' => $order->id,
                    'package_id' => $package->id,
                    'package_name' => $package->package_name,
                    'quantity' => $item->quantity,
                    'classes_per_package' => $package->available_classes,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);

                $classes = (int) $package->available_classes * (int) $item->quantity;

                $credit = EMCustomerCredit::create([
                    'customer_id' => $customer->id,
                    'package_id' => $package->id,
                    'order_id' => $order->id,
                    'total_classes' => $classes,
                    'used_classes' => 0,
                    'remaining_classes' => $classes,
                    'valid_from' => now()->toDateString(),
                    'valid_until' => now()->addDays((int) ($package->valid_days ?: 30))->toDateString(),
                    'status' => 'active',
                ]);

                EMCustomerCreditLog::create([
                    'customer_id' => $customer->id,
                    'credit_id' => $credit->id,
                    'type' => 'credit',
                    'classes' => $classes,
                    'note' => 'Package purchased from customer checkout. Order #' . $order->order_no,
                ]);
            }

            EMCustomerPackageCart::where('customer_id', $customer->id)->delete();

            return redirect()
                ->route('em.customer.payment.success', $order->id)
                ->with('success', 'Payment successful.');
        });
    }

    public function paymentSuccess($orderId)
    {
        $order = EMPackageOrder::with('items')->where('customer_id', $this->customer()->id)->findOrFail($orderId);
        return view('pages.customer_sessions.payment-success', array_merge($this->shellData(), compact('order')));
    }

    public function bookings()
    {
        $bookings = EMSessionBooking::with(['sessionEvent', 'child'])->where('customer_id', $this->customer()->id)->latest()->get();
        return view('pages.customer_sessions.my-bookings', array_merge($this->shellData(), compact('bookings')));
    }

    public function bookSession(Request $request, $id)
    {
        $customer = $this->customer();
        $sessionEvent = EMSessionEvent::where('is_active', 1)->findOrFail($id);

        $data = $request->validate([
            'child_id' => 'nullable|integer',
            'player_first' => 'required_without:child_id|string|max:100',
            'player_last' => 'required_without:child_id|string|max:100',
            'grad_year' => 'required_without:child_id|nullable|integer|min:2020|max:2100',
            'positions' => 'required_without:child_id|array',
            'positions.*' => 'in:Attack,Middie,Defense,Goalie',
        ], [
            'player_first.required_without' => 'Player first name is required.',
            'player_last.required_without' => 'Player last name is required.',
            'grad_year.required_without' => 'Grad year is required.',
            'positions.required_without' => 'Select at least one position.',
        ]);

        $capacity = (int)($sessionEvent->capacity ?: 1);
        $booked = EMSessionBooking::where('session_event_id', $id)->whereIn('status', ['booked','completed'])->count();
        if ($booked >= $capacity) {
            return $this->bookingError($request, 'This session is full.');
        }

        $credit = EMCustomerCredit::where('customer_id', $customer->id)
            ->where('status', 'active')
            ->where('remaining_classes', '>', 0)
            ->whereDate('valid_until', '>=', now()->toDateString())
            ->orderBy('valid_until')
            ->first();

        if (!$credit) {
            return $this->bookingError($request, 'You dont have enough credits, Please buy a package', true);
        }

        return DB::transaction(function () use ($customer, $sessionEvent, $credit, $request, $data, $id) {
            $child = null;
            if (!empty($data['child_id'])) {
                $child = EMCustomerChild::where('customer_id', $customer->id)->where('id', $data['child_id'])->firstOrFail();
            } else {
                $positions = isset($data['positions']) ? $data['positions'] : [];
                $child = EMCustomerChild::create([
                    'customer_id' => $customer->id,
                    'player_first' => $data['player_first'],
                    'player_last' => $data['player_last'],
                    'grad_year' => $data['grad_year'],
                    'positions' => $positions,
                    'is_active' => 1,
                ]);
            }

            $exists = EMSessionBooking::where('customer_id', $customer->id)
                ->where('customer_child_id', $child->id)
                ->where('session_event_id', $id)
                ->where('status', 'booked')
                ->exists();

            if ($exists) {
                return $this->bookingError($request, 'This player already booked this session.');
            }

            $booking = EMSessionBooking::create([
                'customer_id' => $customer->id,
                'customer_child_id' => $child->id,
                'session_event_id' => $sessionEvent->id,
                'credit_id' => $credit->id,
                'booking_no' => 'BK-' . date('Ymd') . '-' . strtoupper(Str::random(6)),
                'player_first' => $child->player_first,
                'player_last' => $child->player_last,
                'grad_year' => $child->grad_year,
                'positions' => $child->positions,
                'status' => 'booked',
                'booked_at' => now(),
            ]);

            $credit->used_classes = (int)$credit->used_classes + 1;
            $credit->remaining_classes = max(0, (int)$credit->remaining_classes - 1);
            if ($credit->remaining_classes <= 0) $credit->status = 'used';
            $credit->save();

            EMCustomerCreditLog::create([
                'customer_id' => $customer->id,
                'credit_id' => $credit->id,
                'booking_id' => $booking->id,
                'type' => 'debit',
                'classes' => 1,
                'note' => 'Session booked for ' . $child->player_first . ' ' . $child->player_last,
            ]);

            if ($request->ajax()) {
                return response()->json(['status' => true, 'message' => 'Session booked successfully.', 'redirect' => route('em.customer.bookings')]);
            }

            return redirect()->route('em.customer.bookings')->with('success', 'Session booked successfully.');
        });
    }

    private function bookingError(Request $request, $message, $needsPackage = false)
    {
        if ($request->ajax()) {
            return response()->json([
                'status' => false,
                'message' => $message,
                'needs_package' => $needsPackage,
                'packages_url' => route('em.customer.packages'),
            ], 422);
        }
        if ($needsPackage) {
            return redirect()->route('em.customer.packages')->with('error', $message);
        }
        return back()->with('error', $message);
    }

    public function cancelBooking($id)
    {
        $booking = EMSessionBooking::with('credit')->where('customer_id', $this->customer()->id)->where('status','booked')->findOrFail($id);
        return DB::transaction(function () use ($booking) {
            $booking->status = 'cancelled';
            $booking->cancelled_at = now();
            $booking->save();
            if ($booking->credit) {
                $booking->credit->used_classes = max(0, (int)$booking->credit->used_classes - 1);
                $booking->credit->remaining_classes = (int)$booking->credit->remaining_classes + 1;
                $booking->credit->status = 'active';
                $booking->credit->save();
                EMCustomerCreditLog::create(['customer_id'=>$booking->customer_id,'credit_id'=>$booking->credit_id,'booking_id'=>$booking->id,'type'=>'refund','classes'=>1,'note'=>'Booking cancelled']);
            }
            return back()->with('success', 'Booking cancelled and credit returned.');
        });
    }

    public function calendarEvents()
    {
        $events = EMSessionBooking::with('sessionEvent')->where('customer_id', $this->customer()->id)->whereIn('status', ['booked','completed'])->get()->map(function($booking){
            $s = $booking->sessionEvent;
            return [
                'title' => $s ? $s->name : 'Session',
                'start' => $s ? $s->event_date . 'T' . $s->start_time : null,
                'end' => $s ? $s->event_date . 'T' . $s->end_time : null,
                'className' => $booking->status === 'completed' ? 'completed-event' : 'booked-event',
            ];
        });
        return response()->json($events);
    }

    public function profile()
    {
        $customer = $this->customer();
        $children = EMCustomerChild::where('customer_id', $customer->id)->where('is_active', 1)->get();
        return view('pages.customer_sessions.profile', array_merge($this->shellData(), compact('customer', 'children')));
    }

    public function updateProfile(Request $request)
    {
        $customer = $this->customer();
        $data = $request->validate([
            'first_name'=>'required|string|max:190',
            'last_name'=>'nullable|string|max:190',
            'email'=>'required|email|max:190|unique:em_customers,email,' . $customer->id,
            'phone'=>'nullable|string|max:80',
            'profile_photo'=>'nullable|image|max:2048'
        ]);
        if ($request->hasFile('profile_photo')) {
            $data['profile_photo'] = $request->file('profile_photo')->store('customer_profiles', 'public');
        }
        $customer->update($data);
        return back()->with('success', 'Profile updated.');
    }
    private function landingCartTotals($items)
    {
        $subtotal = round((float) $items->sum('total_price'), 2);
        $processingFee = round($subtotal * 0.03, 2);
        $tax = 0;
        $total = round($subtotal + $processingFee + $tax, 2);

        return [
            'subtotal' => $subtotal,
            'processing_fee' => $processingFee,
            'tax' => $tax,
            'total' => $total,
        ];
    }

    public function landingCheckout()
    {
        $customer = $this->customer();

        if (!$customer) {
            return redirect()
                ->route('em.customer.login', ['redirect' => route('em.customer.landing.checkout')])
                ->with('error', 'Please log in to continue checkout.');
        }

        $items = EMCustomerPackageCart::with('package')
            ->where('customer_id', $customer->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('em.customer.landing.cart')
                ->with('error', 'Cart is empty.');
        }

        $totals = $this->landingCartTotals($items);

        return view(
            'pages.customer_sessions.landing.checkout',
            array_merge($this->shellData(), compact('items', 'totals'))
        );
    }

    public function landingPay(Request $request)
    {
        $request->validate([
            'owner' => 'required|string|max:190',
            'cardNumber' => 'required|string|min:12|max:25',
            'expiration-month' => 'required|string|size:2',
            'expiration-year' => 'required|string|size:4',
            'cvv' => 'required|string|min:3|max:4',

            'first_name' => 'required|string|max:100',
            'last_name' => 'nullable|string|max:100',
            'email' => 'required|email|max:190',
            'phone' => 'nullable|string|max:50',
            'street' => 'required|string|max:190',
            'city' => 'required|string|max:100',
            'state' => 'required|string|max:100',
            'zip_code' => 'required|string|max:30',
            'country' => 'required|string|max:100',
        ]);

        $customer = $this->customer();

        if (!$customer) {
            return redirect()
                ->route('em.customer.login', ['redirect' => route('em.customer.landing.checkout')])
                ->with('error', 'Please log in to continue payment.');
        }

        $items = EMCustomerPackageCart::with('package')
            ->where('customer_id', $customer->id)
            ->get();

        if ($items->isEmpty()) {
            return redirect()
                ->route('em.customer.landing.cart')
                ->with('error', 'Cart is empty.');
        }

        $totals = $this->landingCartTotals($items);
        $orderNo = 'BMS-' . date('Ymd') . '-' . strtoupper(Str::random(6));

        $paymentResult = $this->processLandingAuthorizePayment(
            $request,
            $customer,
            $orderNo,
            $totals['total']
        );

        if (!$paymentResult['success']) {
            return back()
                ->withInput()
                ->with('error', $paymentResult['message'] ?? 'Payment failed. Please try again.');
        }

        return DB::transaction(function () use ($customer, $items, $totals, $request, $orderNo, $paymentResult) {

            $cardNumber = preg_replace('/\D+/', '', $request->cardNumber);
            $cardLastFour = substr($cardNumber, -4);

            /*
            |--------------------------------------------------------------------------
            | Create Package Order
            |--------------------------------------------------------------------------
            */

            $order = new EMPackageOrder();
            $order->customer_id = $customer->id;
            $order->order_no = $orderNo;
            $order->subtotal = $totals['subtotal'];
            $order->tax = $totals['tax'];
            $order->total = $totals['total'];
            $order->payment_status = 'paid';
            $order->payment_method = 'card';
            $order->card_last_four = $cardLastFour;
            $order->paid_at = now();

            $orderTable = $order->getTable();

            if (Schema::hasColumn($orderTable, 'processing_fee')) {
                $order->processing_fee = $totals['processing_fee'];
            }

            $order->save();

            /*
            |--------------------------------------------------------------------------
            | Save Package Payment Log
            |--------------------------------------------------------------------------
            */

            EMPackagePaymentLog::create([
                'package_order_id' => $order->id,
                'customer_id' => $customer->id,

                'gateway' => 'authorize_net',
                'environment' => is_string($paymentResult['environment'] ?? null)
                    ? $paymentResult['environment']
                    : null,

                'payment_method' => 'card',
                'status' => 'success',

                'subtotal' => $totals['subtotal'],
                'processing_fee' => $totals['processing_fee'],
                'tax' => $totals['tax'],
                'amount' => $totals['total'],

                'response_code' => $paymentResult['response_code'] ?? null,
                'transaction_id' => $paymentResult['transaction_id'] ?? null,
                'auth_id' => $paymentResult['auth_code'] ?? null,
                'message_code' => $paymentResult['message_code'] ?? null,
                'message_text' => $paymentResult['message'] ?? null,
                'ref_id' => $paymentResult['ref_id'] ?? null,

                'name_on_card' => trim($request->owner),
                'card_last_four' => $cardLastFour,

                'billing_first_name' => $request->first_name,
                'billing_last_name' => $request->last_name,
                'billing_email' => $request->email,
                'billing_phone' => $request->phone,
                'billing_street' => $request->street,
                'billing_city' => $request->city,
                'billing_state' => $request->state,
                'billing_zip' => $request->zip_code,
                'billing_country' => $request->country,

                'quantity' => 1,
                'paid_at' => now(),
            ]);

            /*
            |--------------------------------------------------------------------------
            | Create Order Items + Customer Credits
            |--------------------------------------------------------------------------
            */

            foreach ($items as $item) {
                $package = $item->package;

                if (!$package) {
                    continue;
                }

                EMPackageOrderItem::create([
                    'order_id' => $order->id,
                    'package_id' => $package->id,
                    'package_name' => $package->package_name,
                    'quantity' => $item->quantity,
                    'classes_per_package' => $package->available_classes,
                    'unit_price' => $item->unit_price,
                    'total_price' => $item->total_price,
                ]);

                $classes = (int) $package->available_classes * (int) $item->quantity;

                $credit = EMCustomerCredit::create([
                    'customer_id' => $customer->id,
                    'package_id' => $package->id,
                    'order_id' => $order->id,
                    'total_classes' => $classes,
                    'used_classes' => 0,
                    'remaining_classes' => $classes,
                    'valid_from' => now()->toDateString(),
                    'valid_until' => now()->addDays((int) ($package->valid_days ?: 30))->toDateString(),
                    'status' => 'active',
                ]);

                EMCustomerCreditLog::create([
                    'customer_id' => $customer->id,
                    'credit_id' => $credit->id,
                    'type' => 'credit',
                    'classes' => $classes,
                    'note' => 'Package purchased from landing checkout. Order #' . $order->order_no,
                ]);
            }

            /*
            |--------------------------------------------------------------------------
            | Clear Cart
            |--------------------------------------------------------------------------
            */

            EMCustomerPackageCart::where('customer_id', $customer->id)->delete();

            return redirect()
                ->route('em.customer.landing.payment.success', $order->id)
                ->with('success', 'Payment successful.');
        });
    }

    private function processLandingAuthorizePayment(Request $request, EMCustomer $customer, string $orderNo, float $amount): array
    {
        // $gateway = getPaymentGatewayConfig();

        $gateway = [
            "login_id" => "8pB92xhZck",
            "transaction_key" => "3473R69RQj3f3UnV",
            "environment" => "https://apitest.authorize.net",
        ];

        $merchantAuthentication = new AnetAPI\MerchantAuthenticationType();
        $merchantAuthentication->setName($gateway['login_id']);
        $merchantAuthentication->setTransactionKey($gateway['transaction_key']);

        $refId = 'bms-ref-' . time();

        $cardNumber = preg_replace('/\s+/', '', $request->cardNumber);

        $creditCard = new AnetAPI\CreditCardType();
        $creditCard->setCardNumber($cardNumber);
        $creditCard->setExpirationDate($request->input('expiration-year') . '-' . $request->input('expiration-month'));
        $creditCard->setCardCode($request->cvv);

        $paymentOne = new AnetAPI\PaymentType();
        $paymentOne->setCreditCard($creditCard);

        $order = new AnetAPI\OrderType();
        $order->setInvoiceNumber($orderNo);
        $order->setDescription('Book My Sessions package purchase');

        $customerAddress = new AnetAPI\CustomerAddressType();
        $customerAddress->setFirstName($request->first_name);
        $customerAddress->setLastName($request->last_name ?: '');
        $customerAddress->setCompany('Baddies Lacrosse');
        $customerAddress->setAddress($request->street);
        $customerAddress->setCity($request->city);
        $customerAddress->setState($request->state);
        $customerAddress->setZip($request->zip_code);
        $customerAddress->setCountry($request->country);
        $customerAddress->setPhoneNumber($request->phone ?: '');

        $customerData = new AnetAPI\CustomerDataType();
        $customerData->setType('individual');
        $customerData->setId((string) $customer->id);
        $customerData->setEmail($request->email);

        $transactionRequestType = new AnetAPI\TransactionRequestType();
        $transactionRequestType->setTransactionType('authCaptureTransaction');
        $transactionRequestType->setAmount(number_format($amount, 2, '.', ''));
        $transactionRequestType->setOrder($order);
        $transactionRequestType->setPayment($paymentOne);
        $transactionRequestType->setBillTo($customerAddress);
        $transactionRequestType->setCustomer($customerData);

        $requests = new AnetAPI\CreateTransactionRequest();
        $requests->setMerchantAuthentication($merchantAuthentication);
        $requests->setRefId($refId);
        $requests->setTransactionRequest($transactionRequestType);

        $controller = new AnetController\CreateTransactionController($requests);
        $response = $controller->executeWithApiResponse($gateway['environment']);

        if ($response === null) {
            return [
                'success' => false,
                'message' => 'No response returned from payment gateway.',
            ];
        }

        if ($response->getMessages()->getResultCode() !== 'Ok') {
            $tresponse = $response->getTransactionResponse();

            if ($tresponse && $tresponse->getErrors()) {
                $message = $tresponse->getErrors()[0]->getErrorText();
            } else {
                $message = $response->getMessages()->getMessage()[0]->getText();
            }

            return [
                'success' => false,
                'message' => $message ?: 'Payment failed. Please try again.',
            ];
        }

        $tresponse = $response->getTransactionResponse();

        if (!$tresponse || !$tresponse->getMessages()) {
            $message = 'Payment failed. Please try again.';

            if ($tresponse && $tresponse->getErrors()) {
                $message = $tresponse->getErrors()[0]->getErrorText();
            }

            return [
                'success' => false,
                'message' => $message,
            ];
        }

        return [
            'success' => true,
            'message' => $tresponse->getMessages()[0]->getDescription(),
            'transaction_id' => $tresponse->getTransId(),
            'auth_code' => $tresponse->getAuthCode(),
            'response_code' => $tresponse->getResponseCode(),
            'message_code' => $tresponse->getMessages()[0]->getCode(),
            'ref_id' => $refId,
            'environment' => $gateway['environment'] ?? null,
        ];
    }

    public function landingPaymentSuccess($orderId)
    {
        $customer = $this->customer();

        if (!$customer) {
            return redirect()->route('em.customer.login');
        }

        $order = EMPackageOrder::with(['items', 'latestPaymentLog'])
            ->where('customer_id', $customer->id)
            ->findOrFail($orderId);

        return view(
            'pages.customer_sessions.landing.payment-success',
            array_merge($this->shellData(), compact('order'))
        );
    }
    public function apiHealth()
    {
        return response()->json([
            'status' => true,
            'message' => 'BMS API working.',
        ]);
    }

    public function apiPackages(Request $request)
    {
        $query = EMPackage::query()
            ->where('is_active', 1);

        if ($request->filled('ids')) {
            $ids = collect(explode(',', $request->get('ids')))
                ->map(fn ($id) => (int) trim($id))
                ->filter()
                ->unique()
                ->values()
                ->all();

            $query->whereIn('id', $ids);
        }

        $packages = $query
            ->latest()
            ->get()
            ->map(fn ($package) => $this->apiPackageResource($package))
            ->values();

        return response()->json([
            'status' => true,
            'data' => $packages,
        ]);
    }

    public function apiPackageDetails($id)
    {
        $package = EMPackage::query()
            ->where('is_active', 1)
            ->where('id', $id)
            ->first();

        if (!$package) {
            return response()->json([
                'status' => false,
                'message' => 'Package not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $this->apiPackageResource($package),
        ]);
    }

    public function apiSessions(Request $request)
    {
        $pacificNow = now('America/Los_Angeles');

        $query = EMSessionEvent::query()
            ->where('is_active', 1);

        if ($request->filled('ids')) {
            $ids = collect(explode(',', $request->string('ids')))
                ->map(fn ($id) => (int) trim($id))
                ->filter(fn ($id) => $id > 0)
                ->unique()
                ->values()
                ->all();

            if (empty($ids)) {
                return response()->json([
                    'status' => true,
                    'data' => [],
                ]);
            }

            $query->whereIn('id', $ids);
        }

        $sessions = $query
            ->orderByDesc('event_date')
            ->orderByDesc('start_time')
            ->get()
            ->map(fn ($session) => $this->apiSessionResource($session))
            ->values();

        return response()->json([
            'status' => true,
            'timezone' => 'America/Los_Angeles',
            'current_pacific_time' => $pacificNow->toDateTimeString(),
            'data' => $sessions,
        ]);
    }

    public function apiSessionDetails($id)
    {
        $session = EMSessionEvent::query()
            ->where('is_active', 1)
            ->where('id', $id)
            ->first();

        if (!$session) {
            return response()->json([
                'status' => false,
                'message' => 'Session not found.',
            ], 404);
        }

        return response()->json([
            'status' => true,
            'data' => $this->apiSessionResource($session),
        ]);
    }

    private function apiPackageResource($package)
    {
        $image = $package->package_image ?? null;

        return [
            'id' => $package->id,
            'user_id' => $package->user_id ?? null,
            'package_name' => $package->package_name,
            'package_description' => $package->package_description,
            'package_price' => (float) $package->package_price,
            'available_classes' => (int) $package->available_classes,
            'valid_days' => (int) ($package->valid_days ?: 30),
            'package_image' => $image,
            'package_image_url' => $image
                ? (Str::startsWith($image, ['http://', 'https://']) ? $image : asset('storage/' . $image))
                : null,
            'is_active' => (int) $package->is_active,
            'created_at' => optional($package->created_at)->toDateTimeString(),
            'updated_at' => optional($package->updated_at)->toDateTimeString(),
        ];
    }

    private function apiSessionResource($session)
    {
        return [
            'id' => $session->id,
            'user_id' => $session->user_id ?? null,
            'name' => $session->name ?? null,
            'training_type' => $session->training_type,
            'description' => $session->description,
            'what_to_bring' => $session->what_to_bring,
            'event_date' => $session->event_date,
            'start_time' => $session->start_time,
            'end_time' => $session->end_time,
            'instructor' => $session->instructor,
            'location' => $session->location,
            'capacity' => (int) ($session->capacity ?: 1),
            'is_active' => (int) $session->is_active,
            'created_at' => optional($session->created_at)->toDateTimeString(),
            'updated_at' => optional($session->updated_at)->toDateTimeString(),
        ];
    }
}
