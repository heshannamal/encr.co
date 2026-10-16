<?php

namespace App\Http\Controllers;

use App\Exports\OrderRosterTemplateExport;
use App\Exports\RosterSizesWithNamesExport;
use App\Imports\RosterSizesWithNamesImport;
use App\Exports\RosterSizesWithNumbersExport;
use App\Imports\RosterSizesWithNumbersImport;
use App\Exports\RosterSizesWithNumberNamesExport;
use App\Imports\RosterSizesWithNumberNamesImport;
use App\Http\Controllers\Controller;
use App\Imports\OrderRosterImport;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use App\Models\Contact;
use App\Models\LeadSource;
use App\Models\Order;
use App\Models\PaymentLog;
use App\Models\CheckPayment;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\Organization;
use App\Models\OrderStatus;
use App\Models\User;
use App\Models\Product;
use App\Models\SubProduct;
use App\Models\ContactOrganization;
use App\Models\SummaryAtPayment;
use App\Models\ProductCategory;
use App\Models\ProductCategoryList;
use App\Models\ProductSport;
use App\Models\Fabric;
use App\Models\Factory;
use App\Models\ExFactory;
use App\Models\ShippedOrders;
use App\Models\OrderItem;
use App\Models\OrderItemsDetailPlayerName;
use App\Models\Sport;
use App\Models\Size;
use App\Models\OrderItemsDetail;
use App\Models\OrderItemAttribute;
use App\Models\OrderItemFile;
use App\Models\EmbellishmentType;
use App\Models\PurchaseorderReceipt;
use App\Models\Notification;
use App\Models\ProductionApprovalDetail;
use App\Models\OtherPayment;
use Illuminate\Support\MessageBag;
use Illuminate\Support\Facades\Session;
use Illuminate\Support\Facades\Auth;
use domainencore\Facades\ShippingFacade\ShippingFacade;
use Maatwebsite\Excel\Facades\Excel;
use PDF;
use Mail;
use App\Models\AccountsLog;
use App\Services\NotificationBuilderService;
use Carbon\Carbon;
use App\Models\BulkInvoice;
use App\Models\ShippingOrderDetails;



class NewCustomerPortalController extends Controller
{
    private $smtpEncryption = 'SSL';
    private $smtpPort = '465';
    private $smtpHost = 'server.encr.co';
    private $mailUsername = 'info@encr.co';
    private $mailPassword = 'Encr.co@ec123';

    public function common(){

            return redirect()->route('customer_portal.orders');

    }
    public function login(){

        return view('pages.customer_portal.auth.login');
    }
    public function portal_login(Request $request){

        $errors = new MessageBag();

        if ($request->has('email')) {

            $contact = Contact::where('email' , $request->email)->where('active' , 1)->first();

            if($contact){
                $contact_organization = ContactOrganization::where('contact_id' , $contact->id)->pluck('organization_id')->toArray();
                $organizations = Organization::whereIn('id' , $contact_organization)->get();
                if($organizations){
                    foreach ($organizations as $organization) {
                        $passwordMatch = Hash::check($request->password, $organization->unique_password);
                        if ($passwordMatch) {
                            // Normal customer login: clear any previous system-user portal context.
                            Session::forget([
                                'customer_portal_admin',
                                'portal_notice_acknowledged',
                            ]);

                            Auth::logout();

                            Session::put('customer_portal_user', [$contact->id , $organization->id]);
                            Session::put('customer_portal_org_image', [$organization->organization_logo]);
                            Session::put('customer_portal_org_name', [$organization->organization_name]);
                            // return redirect()->route('customer_portal.orders');
                            // return redirect()->intended(route('customer_portal.orders'));
                            $intendedUrl = session()->get('url.intended', route('customer_portal.orders'));
                            return redirect()->to($intendedUrl);
                        }
                    }

                    $errors->add('password', 'Incorrect password');

                }else{
                    $errors->add('email', 'No organization available for your email');
                }
            }else{
                $errors->add('email', 'The email you have entered not found');
            }
        }else{
            $errors->add('email', 'Email is not valid');
        }


        if(!empty($errors)){
            return view('pages.customer_portal.auth.login' , compact('errors'));
        }
    }

    public function auth_check()
    {
        /*
        |--------------------------------------------------------------------------
        | Normal customer
        |--------------------------------------------------------------------------
        */
        if (Session::has('customer_portal_user')) {
            return true;
        }

        /*
        |--------------------------------------------------------------------------
        | System/Admin user
        |--------------------------------------------------------------------------
        */
        if (Auth::check() && Session::has('customer_portal_admin')) {
            $portalAdmin = Session::get('customer_portal_admin');

            if (
                isset($portalAdmin['user_id'], $portalAdmin['organization_id']) &&
                (int) $portalAdmin['user_id'] === (int) Auth::id() &&
                !empty($portalAdmin['organization_id'])
            ) {
                return true;
            }

            // Stale or invalid system-user portal context.
            Session::forget('customer_portal_admin');
        }

        return false;
    }

    public function logout()
    {
        /*
        |--------------------------------------------------------------------------
        | System/Admin user exits portal but stays logged into back office
        |--------------------------------------------------------------------------
        */
        if ($this->portalIsAdmin()) {
            $orgId = $this->portalOrganizationId();

            Session::forget([
                'customer_portal_admin',
                'customer_portal_org_image',
                'customer_portal_org_name',
                'portal_notice_acknowledged',
            ]);

            if ($orgId) {
                return redirect()->route('organizations.info', $orgId);
            }

            return redirect()->route('home');
        }

        /*
        |--------------------------------------------------------------------------
        | Normal customer logout
        |--------------------------------------------------------------------------
        */
        Session::forget([
            'customer_portal_user',
            'customer_portal_org_image',
            'customer_portal_org_name',
            'portal_notice_acknowledged',
        ]);

        return redirect()->route('customer_portal.login');
    }

    public function acknowledgeOrderNotice()
    {
        if (!$this->auth_check()) {
            return response()->json(['success' => false, 'message' => 'Unauthorized'], 401);
        }
        Session::put('portal_notice_acknowledged', true);
        return response()->json(['success' => true]);
    }

    public function dashboard(){

        $org_id = $this->portalOrganizationId();

        abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

        $organization = Organization::where('id' , $org_id)->firstOrFail();

        // For system-user mode this is only display/customer-data context.
        // The authenticated actor remains Auth::user().
        $contact = $this->portalContact();

        $orders = Order::where('organization_id' , $org_id)->where('active' , 1)->orderBy('id', 'desc')->get();

        $users = User::where('active' , 1)->get();

        $orderStatuses = OrderStatus::where('active' , 1)->get();

        $order_ids = Order::where('organization_id' , $org_id)->where('active' , 1)->pluck('id')->toArray();

        $payments = [];
        $totalOutstanding = 0.00;
        foreach ($order_ids as $order_id) {
            $orderDetail = Order::findOrFail($order_id);

            $cardAmount = PaymentLog::where('order_id', $order_id)->sum('amount');
            $checkAmount = CheckPayment::where('order_id', $order_id)->where('is_approved', 1)->sum('amount');
            $venmoAmount = VenmoPayment::where('order_id', $order_id)->where('is_approved', 1)->sum('amount');
            $paypalAmount = PaypalPayment::where('order_id', $order_id)->where('is_approved', 1)->sum('amount');

            $payment = 0;
            if ($cardAmount > 0 && $paypalAmount > 0) {
                $payment = round(((($cardAmount + $paypalAmount) * 100) / 103), 2) + $checkAmount + $venmoAmount;
            } elseif ($cardAmount > 0 && $paypalAmount == 0) {
                $payment = round(($cardAmount * 100) / 103, 2) + $checkAmount + $venmoAmount;
            } elseif ($cardAmount == 0 && $paypalAmount > 0) {
                $payment = $checkAmount + round((($paypalAmount * 100) / 103), 2) + $venmoAmount;
            } else {
                $payment = $cardAmount + $checkAmount + $paypalAmount + $venmoAmount;
            }

            $balanceToBePaid = 0;
            if ($payment == 0 && $orderDetail->order_total > 0) {
                $paymentStatus = 0; // Pending
            } elseif ($payment < $orderDetail->order_total && $payment > 0) {
                $paymentStatus = 1; // Partial
                $balanceToBePaid = $orderDetail->order_total - $payment;
            } else {
                $paymentStatus = 2; // Paid
            }

            // ❌ Skip fully paid orders
            if ($paymentStatus == 2) {
                continue;
            }
            $totalOutstanding = $totalOutstanding + $balanceToBePaid;

            $payments[$order_id] = [
                'orderDetail' => $orderDetail,
                'balanceToBePaid' => $balanceToBePaid,
                'paymentStatus' => $paymentStatus
            ];


        }
        // Current month
        $currentMonthOrders = Order::where('organization_id', $org_id)
            ->where('active', 1)
            ->whereMonth('created_at', Carbon::now()->month)
            ->whereYear('created_at', Carbon::now()->year)
            ->count();

        // Last month
        $lastMonthOrders = Order::where('organization_id', $org_id)
            ->where('active', 1)
            ->whereMonth('created_at', Carbon::now()->subMonth()->month)
            ->whereYear('created_at', Carbon::now()->subMonth()->year)
            ->count();

        if ($lastMonthOrders > 0) {
            $percentageChange = (($currentMonthOrders - $lastMonthOrders) / $lastMonthOrders) * 100;
        } else {
            $percentageChange = $currentMonthOrders > 0 ? 100 : 0;
        }

        // Round nicely
        $percentageChange = round($percentageChange, 2); // e.g., 12.35
        // or formatted with a % sign
        $percentageChangeFormatted = number_format($percentageChange, 2) . '%'; // e.g., "12.35%"
        if ($percentageChange > 0) {
            $changeClass = 'text-success'; // green
        } elseif ($percentageChange < 0) {
            $changeClass = 'text-danger'; // red
        } else {
            $changeClass = 'text-muted'; // gray for no change
        }

        $resentOrders = Order::where('organization_id', $org_id)
                            ->with('userDetails')
                            ->where('active', 1)
                            ->orderBy('id', 'desc')
                            ->take(4)
                            ->get()
                            ->transform(function ($order) {
                                $order->payment_status = app(\App\Services\PaymentService::class)
                                    ->getPaymentStatus($order->id);
                                return $order;
                            });


                // Get all orders with payment status calculated
        $ordersWithStatus = Order::with('userDetails')
            ->where('organization_id', $org_id)
            ->where('active', 1)
            ->orderBy('id', 'desc')
            ->get()
            ->transform(function ($order) {
                $order->payment_status = app(\App\Services\PaymentService::class)->getPaymentStatus($order->id);
                return $order;
            });
        $totalBalanceToPay = $ordersWithStatus->sum(function ($order) {
            return $order->payment_status['balance_to_be_paid'] ?? 0;
        });

        // Filter and get 4 most recent unpaid orders (payment_status = 0)
        $unpaidOrders = $ordersWithStatus->filter(function ($order) {
            return in_array($order->payment_status['payment_status'], [0, 1]);
        })->take(4);
        $CompleteorderCount = Order::where('organization_id', $org_id)
            ->where('active', 1)
            ->where('order_status_id', 3)
            ->count();
        // dd($resentOrders);
        return view('pages.customer_portal.dashboard', ['CompleteorderCount'=>$CompleteorderCount ,'totalOutstanding'=>$totalBalanceToPay ,'unpaidOrders'=>$unpaidOrders ,'resentOrders'=>$resentOrders ,'organization'=>$organization ,'percentageChangeFormatted'=>$percentageChangeFormatted ,'changeClass'=>$changeClass ,'orders'=>$orders ,'currentMonthOrders'=>$currentMonthOrders , 'contact'=>$contact , 'users'=>$users , 'orderStatuses'=>$orderStatuses , 'payments'=>$payments]);

    }
// public function getOrderTrackingChartData(Request $request)
// {
//     $month = $request->query('month')?: now()->format('Y-m');; // Expects "2025-08"
//     $startDate = \Carbon\Carbon::parse($month . '-01');
//     $endDate = $startDate->copy()->endOfMonth();
//     $org_id = Session::get('customer_portal_user')[1];
//     // Fetch orders with status and date filtering
//     $orders = \App\Models\Order::where('organization_id' , $org_id)->where('active', 1)->whereBetween('created_at', [$startDate, $endDate])
//         ->orderBy('created_at', 'asc')
//         ->get();

//     $paidData = [];
//     $unpaidData = [];

//     $currentPaidStatus = null;
//     $currentUnpaidStatus = null;

//     $current = $startDate->copy();
//     while ($current <= $endDate) {
//         $dayStr = $current->format('Y-m-d');

//         // Filter orders for this specific day
//         $dayOrders = $orders->filter(fn($o) => $o->created_at->format('Y-m-d') === $dayStr);

//         if ($dayOrders->isNotEmpty()) {
//             foreach ($dayOrders as $order) {
//                 /** * Convert DB IDs to Chart Indices:
//                  * DB ID 1 (Quote)      -> Chart 0
//                  * DB ID 2 (Production) -> Chart 1
//                  * DB ID 3 (Shipping)   -> Chart 2
//                  * DB ID 4 (Fulfilled)  -> Chart 3
//                  */
//                 $statusVal = (int)$order->order_status_id - 1;

//                 $payment = app(\App\Services\PaymentService::class)->getPaymentStatus($order->id);

//                 if ($payment['payment_status'] == 2) {
//                     $currentPaidStatus = max($currentPaidStatus ?? 0, $statusVal);
//                 } else {
//                     $currentUnpaidStatus = max($currentUnpaidStatus ?? 0, $statusVal);
//                 }
//             }
//         }

//         // Add coordinates {x: day, y: status}
//         // If status is null, we don't push anything to avoid lines starting at 0 incorrectly
//         if ($currentPaidStatus !== null) {
//             $paidData[] = ['x' => (int)$current->format('j'), 'y' => $currentPaidStatus];
//         }
//         if ($currentUnpaidStatus !== null) {
//             $unpaidData[] = ['x' => (int)$current->format('j'), 'y' => $currentUnpaidStatus];
//         }

//         $current->addDay();
//     }

//     return response()->json([
//         'paid' => $paidData,
//         'unpaid' => $unpaidData,
//         'daysInMonth' => $startDate->daysInMonth,
//         'monthName' => $startDate->format('F Y')
//     ]);
// }
public function getOrderSummaryChart(Request $request)
{
    $year = $request->query('year', now()->year);
    $orgId = $this->portalOrganizationId();

    abort_if(!$orgId, 403, 'Invalid customer portal organization context.');

    $orders = \App\Models\Order::where('organization_id', $orgId)
        ->where('active', 1)
        ->whereYear('created_at', $year)
        ->get();

    /*
    |--------------------------------------------------------------------------
    | PIE CHART TOTALS
    |--------------------------------------------------------------------------
    */
    $orderStatusCounts = [
        'quote'       => 0,
        'production'  => 0,
        'shipping'    => 0,
        'fulfilled'   => 0,
    ];

    $paymentAmounts = [
        'paid_amount'     => 0,
        'partial_amount'  => 0,
        'unpaid_amount'   => 0,
    ];

    /*
    |--------------------------------------------------------------------------
    | LINE CHART MONTHLY DATA (12 months)
    |--------------------------------------------------------------------------
    */
    $orderStatusMonthly = [
        'quote'       => array_fill(0, 12, 0),
        'production'  => array_fill(0, 12, 0),
        'shipping'    => array_fill(0, 12, 0),
        'fulfilled'   => array_fill(0, 12, 0),
    ];

    $paymentStatusMonthly = [
        'paid'     => array_fill(0, 12, 0),
        'partial'  => array_fill(0, 12, 0),
        'unpaid'   => array_fill(0, 12, 0),
    ];

    foreach ($orders as $order) {

        $monthIndex = $order->created_at->month - 1;

        /* -----------------------------
         | ORDER STATUS
         |-----------------------------*/
        switch ($order->order_status_id) {
            case 1:
                $orderStatusCounts['quote']++;
                $orderStatusMonthly['quote'][$monthIndex]++;
                break;

            case 3:
                $orderStatusCounts['production']++;
                $orderStatusMonthly['production'][$monthIndex]++;
                break;

            case 5:
                $orderStatusCounts['shipping']++;
                $orderStatusMonthly['shipping'][$monthIndex]++;
                break;

            case 4:
                $orderStatusCounts['fulfilled']++;
                $orderStatusMonthly['fulfilled'][$monthIndex]++;
                break;
        }

        /* -----------------------------
         | PAYMENT STATUS
         |-----------------------------*/
        $payment = app(\App\Services\PaymentService::class)
            ->getPaymentStatus($order->id);

        if ($payment['payment_status'] == 2) {
            // Paid
            $paymentAmounts['paid_amount'] += $payment['total_payment'];
            $paymentStatusMonthly['paid'][$monthIndex] += $payment['total_payment'];

        } elseif ($payment['payment_status'] == 1) {
            // Partial
            $paymentAmounts['partial_amount'] += $payment['total_payment'];
            $paymentAmounts['unpaid_amount'] += $payment['balance_to_be_paid'];

            $paymentStatusMonthly['partial'][$monthIndex] += $payment['total_payment'];
            $paymentStatusMonthly['unpaid'][$monthIndex] += $payment['balance_to_be_paid'];

        } else {
            // Unpaid
            $paymentAmounts['unpaid_amount'] += $payment['balance_to_be_paid'];
            $paymentStatusMonthly['unpaid'][$monthIndex] += $payment['balance_to_be_paid'];
        }
    }

    return response()->json([
        'year' => $year,

        // PIE
        'order_status' => $orderStatusCounts,
        'payment_status' => $paymentAmounts,

        // LINE
        'order_status_monthly' => $orderStatusMonthly,
        'payment_status_monthly' => $paymentStatusMonthly,
    ]);
}


    // public function getOrderTrackingChartData(Request $request)
    // {
    //     $org_id = Session::get('customer_portal_user')[1];

    //     // Current month (you can customize)
    //     $year  = now()->year;
    //     $month = now()->month;

    //     $daysInMonth = cal_days_in_month(CAL_GREGORIAN, $month, $year);

    //     // Initialize arrays
    //     $paidData   = [];
    //     $unpaidData = [];
    //     $statusData = []; // If you want each order’s status history later

    //     // Loop through each day of the month
    //     for ($day = 1; $day <= $daysInMonth; $day++) {

    //         $date = Carbon::create($year, $month, $day)->format('Y-m-d');

    //         // ----- Get ORDERS created on this day -----
    //         $orders = Order::where('organization_id', $org_id)
    //             ->whereDate('created_at', $date)
    //             ->get();

    //         // Count Paid / Unpaid
    //         $paidCount = 0;
    //         $unpaidCount = 0;

    //         foreach ($orders as $order) {
    //             $paymentStatus = app(\App\Services\PaymentService::class)->getPaymentStatus($order->id);

    //             if ($paymentStatus['payment_status'] == 2) {
    //                 $paidCount++;
    //             } else {
    //                 $unpaidCount++;
    //             }
    //         }

    //         $paidData[]   = $paidCount ?: null;
    //         $unpaidData[] = $unpaidCount ?: null;
    //     }

    //     return response()->json([
    //         'labels' => range(1, $daysInMonth),
    //         'paid'   => $paidData,
    //         'unpaid' => $unpaidData
    //     ]);
    // }

    public function customer_support(){

            $contact = $this->portalContact();

            return view('pages.customer_portal.customer_support', ['contact'=>$contact]);

    }

    public function orders(){


            $org_id = $this->portalOrganizationId();

            abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

            $contact = $this->portalContact();

            $orders = Order::where('organization_id' , $org_id)->where('active' , 1)->whereNotIn('order_status_id', [7])->orderBy('id', 'desc')->get();

            $users = User::where('active' , 1)->get();

            $orderStatuses = OrderStatus::where('active' , 1)->get();

            $order_ids = Order::where('organization_id' , $org_id)->where('active' , 1)->pluck('id')->toArray();

            $payments = [];

            foreach ($order_ids as $order_id) {
                $orderDetail = Order::findOrFail($order_id);

                $cardAmount = PaymentLog::where('order_id', $order_id)->sum('amount');
                $checkAmount = CheckPayment::where('order_id', $order_id)->where('is_approved', 1)->sum('amount');
                $venmoAmount = VenmoPayment::where('order_id', $order_id)->where('is_approved', 1)->sum('amount');
                $paypalAmount = PaypalPayment::where('order_id', $order_id)->where('is_approved', 1)->sum('amount');
                $otherAmount = OtherPayment::where('order_id', $order_id)->sum('amount');
                $purchaseorderAmount = PurchaseorderReceipt::where('order_id', $order_id)->where('is_approved', 1)->first()->amount ?? 0.00;

                $payment = 0;
                if ($cardAmount > 0 && $paypalAmount > 0) {
                    $payment = round(((($cardAmount + $paypalAmount) * 100) / 103), 2) + $checkAmount + $venmoAmount + $otherAmount + $purchaseorderAmount;
                } elseif ($cardAmount > 0 && $paypalAmount == 0) {
                    $payment = round(($cardAmount * 100) / 103, 2) + $checkAmount + $venmoAmount + $otherAmount + $purchaseorderAmount;
                } elseif ($cardAmount == 0 && $paypalAmount > 0) {
                    $payment = $checkAmount + round((($paypalAmount * 100) / 103), 2) + $venmoAmount + $otherAmount + $purchaseorderAmount;
                } else {
                    $payment = $cardAmount + $checkAmount + $paypalAmount + $venmoAmount + $otherAmount + $purchaseorderAmount;
                }

                $balanceToBePaid = 0;
                if ($payment == 0 && $orderDetail->order_total > 0) {
                    $paymentStatus = 0; // Pending
                } elseif ($payment < $orderDetail->order_total && $payment > 0) {
                    $paymentStatus = 1; // Partial
                    $balanceToBePaid = $orderDetail->order_total - $payment;
                } else {
                    $paymentStatus = 2; // Paid
                }

                if (str_starts_with($orderDetail->order_no, 'TSR')) {
                    $balanceToBePaid = 0;
                    $paymentStatus = 2;
                }

                $payments[$order_id] = [
                    'orderDetail' => $orderDetail,
                    'balanceToBePaid' => $balanceToBePaid,
                    'paymentStatus' => $paymentStatus
                    ];
                }
                // ---------- ORDER STATUS COUNTS ----------
                $statusCounts = [
                    'all'        => $orders->count(),
                    'quote'      => $orders->where('order_status_id', 1)->count(),
                    'invoice'    => $orders->where('order_status_id', 2)->count(),
                    'production' => $orders->where('order_status_id', 3)->count(),
                    'fulfilled'  => $orders->where('order_status_id', 4)->count(),
                    'failed'     => $orders->where('order_status_id', 0)->count(), // If you use 0 for canceled/failed
                ];


                // ---------- PAYMENT STATUS COUNTS ----------
                $pendingPaymentCount = 0;
                $partialPaymentCount = 0;

                foreach ($payments as $pay) {
                    if ($pay['paymentStatus'] == 0) {
                        $pendingPaymentCount++;
                    } elseif ($pay['paymentStatus'] == 1) {
                        $partialPaymentCount++;
                    }
                }

                $paymentCounts = [
                    'pending' => $pendingPaymentCount,
                    'partial' => $partialPaymentCount,
                ];


            return view('pages.customer_portal.my_orders', ['orders'=>$orders , 'contact'=>$contact , 'users'=>$users , 'orderStatuses'=>$orderStatuses , 'payments'=>$payments,'statusCounts' => $statusCounts,
    'paymentCounts' => $paymentCounts,]);


    }
    public function showDetails($orderId)
    {
        $org_id = $this->portalOrganizationId();

        abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

        $order = Order::where('id', $orderId)
            ->where('organization_id', $org_id)
            ->with([
                'contactDetails',
                'organizationDetails',
                'orderItems' => function ($query) {
                    // $query->select('id', 'order_id', 'sub_product_no','display_name', 'item_description','order_status_id','qty')
                    $query->select('id', 'order_id', 'sub_product_no', 'display_name', 'item_description', 'order_status_id', 'qty', 'sort_order', 'item_no')
                        ->ordered()
                        ->with([
                            'subProduct' => function ($subQuery) {
                                $subQuery->select('sub_product_no', 'product_name');
                            },
                            'statusDetails'
                        ]);
                },
            ])
            ->first();
        if ($order) {
            $order->payment_status = app(\App\Services\PaymentService::class)
                ->getPaymentStatus($order->id);
        }
        $contacts = Contact::where('active', 1)->get();
        $cardAmount = PaymentLog::where('order_id', $orderId)->sum('amount');
        $checkAmount = CheckPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $venmoAmount = VenmoPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $paypalAmount = PaypalPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        $purchaseorderAmount = PurchaseorderReceipt::where('order_id', $orderId)->where('is_approved' , 1)->first()->amount ?? 0.00;
        $otherAmount = OtherPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');

        return view('pages.customer_portal.order.includes.order_detail', compact('order', 'contacts', 'cardAmount', 'checkAmount', 'venmoAmount', 'paypalAmount', 'otherAmount', 'purchaseorderAmount'));
    }

    public function get_order_tracking(Request $request){
        $orderNumber = $request->order_number;
        $org_id = $this->portalOrganizationId();

        abort_if(!$org_id, 403, 'Invalid customer portal organization context.');
        // Remove possible prefixes like ORD, #, Order-, order_, etc.
        $cleanOrderNumber = preg_replace('/[^0-9]/', '', $orderNumber);
        $order = Order::where('id', $cleanOrderNumber)
            ->with([
                'contactDetails',
                'organizationDetails',
            ])
            ->first();
         //  1. Order not found
        if (!$order) {
            return response()->json([
                'success' => false,
                'message' => 'No order found with this number.'
            ], 404);
        }

        //  2. Organization mismatch
        if ($order->organization_id != $org_id) {
            return response()->json([
                'success' => false,
                'message' => 'This order does not belong to your organization.'
            ], 403);
        }
        // dd($order);
        if($order->is_new_shipping_address == 1){

            $shippingAddress = collect([
                $order->apartment,
                $order->street,
                $order->city,
                $order->state,
                $order->postal_code,
                $order->country,
            ])
            ->filter() // removes null/empty values
            ->implode(",\n");
        }elseif($order->is_new_shipping_address == 3){
            $shippingAddress = collect([
                $order->contactDetails->apartment2,
                $order->contactDetails->shipping_street_2,
                $order->contactDetails->shipping_city_2,
                $order->contactDetails->shipping_state_2,
                $order->contactDetails->shipping_zip_2,
                $order->contactDetails->shipping_country_2,
            ])
            ->filter() // removes null/empty values
            ->implode(",\n");
        }else{
            $shippingAddress = collect([
                $order->contactDetails->apartment,
                $order->contactDetails->shipping_street,
                $order->contactDetails->shipping_city,
                $order->contactDetails->shipping_state,
                $order->contactDetails->shipping_zip,
                $order->contactDetails->shipping_country,
            ])
            ->filter() // removes null/empty values
            ->implode(",\n");
        }
        $shippingTrackings = ShippingOrderDetails::where('order_id', $order->id)
                            ->where('notify_status', 1)
                            ->whereNotNull('tracking_no')
                            ->get()
                            ->groupBy('tracking_no')
                            ->map(function ($group) {
                                $first = $group->first();

                                return [
                                    'tracking_no' => $first->tracking_no,
                                    'CourierService' => $first->CourierService,
                                    'tracking_link' => $first->tracking_link,
                                    'customer_received' => $first->customer_received,
                                    'est_delivery_date' => $group->max('est_delivery_date'),
                                ];
                            })
                            ->values();


        return response()->json([
            'success' => true,
            'order_details' => $order,
            'shippingAddress' => $shippingAddress,
            'shipping_tracking' => $shippingTrackings
        ]);


    }
    public function order_view(Request $request, $orderId){

            $org_id = $this->portalOrganizationId();

            abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

            $contact = $this->portalContact();

            $order = Order::where('id', $orderId)
                    ->where('organization_id', $org_id)
                    ->with([
                        'contactDetails',
                        'organizationDetails',

                        'orderItems' => function ($query) {
                            // $query->select('id', 'order_id', 'sub_product_no','display_name', 'item_description','order_status_id','qty')
                            $query->select('id', 'order_id', 'sub_product_no', 'display_name', 'item_description', 'order_status_id', 'qty', 'sort_order', 'item_no')
                                ->where('is_studio_item', 0)
                                ->ordered()
                                ->with([
                                    'subProduct' => function ($subQuery) {
                                        $subQuery->select('sub_product_no', 'product_name'); // select only what you need;
                                    },
                                    'statusDetails'
                                ]);
                        },
                    ])
                    ->first();

            if (!$order) {
                return redirect()->back();
            }

            $order->payment_status = app(\App\Services\PaymentService::class)
                ->getPaymentStatus($order->id);

            $contacts = Contact::where('active' , 1)->get();
            $cardAmount = PaymentLog::where('order_id', $orderId)->sum('amount');
            $checkAmount = CheckPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
            $venmoAmount = VenmoPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
            $paypalAmount = PaypalPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
            $purchaseorderAmount = PurchaseorderReceipt::where('order_id', $orderId)->where('is_approved' , 1)->first()->amount ?? 0.00;
            $otherAmount = OtherPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
                return view('pages.customer_portal.order.order_edit', [
                    'order'=>$order,
                    'contacts'=>$contacts,
                    'cardAmount'=>$cardAmount,
                    'checkAmount'=>$checkAmount,
                    'venmoAmount'=>$venmoAmount,
                    'paypalAmount'=>$paypalAmount,
                    'purchaseorderAmount'=>$purchaseorderAmount,
                    'otherAmount'=>$otherAmount,
                ]);

    }
    public function individual_payment(Request $request){

    }
    public function bulk_payment(Request $request){

    }
    public function orderItemview(Request $request){
        $orderitemId = $request->item_id;
        $orderId = $request->orderId;
        $org_id = $this->portalOrganizationId();

        abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

        $orderDetailsQuery = Order::with('organizationDetails', 'contactDetails');


        $rosterOrderItems = OrderItem::where('order_id' , $orderId)->where('id' , $request->item_id)->get();
        $orderItemAttributes = OrderItemAttribute::where('order_item_id', $request->item_id)->get();
// dd($orderItemAttributes);

        $ordersQuery = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails', 'contactOrganizations.contacts');
        $orderDetailsQuery = Order::with([
            // Basic order relationships
            'organizationDetails.contactOrganizations.contacts',
            'contactDetails',
            'userDetails',
            'statusDetails',
            'contactOrganizations.contacts',

            // Order items with condition for specific orderItemId
            'orderItems' => function($query) use ($orderitemId) {
                $query->where('id', $orderitemId);
            },
            'orderItems.subProduct' => function ($query) {
                $query->select('sub_product_no', 'product_name'); // load sub product name
            },

            // Nested relationships for the filtered order item
            'orderItems.orderItemDetails.playerDetails',
            'orderItems.orderItemDetails.sizeDetails',
            'orderItems.productDetails.productFactories.factory',
            'orderItems.embellishmentDetails',
            'orderItems.factoryDetails',
            'orderItems.exFactoryDetails',
            'orderItems.orderItemFiles',
            'orderItems.productAttributes.attributes',
            'orderItems.orderItemAttributes.attribute',
            'orderItems.fabricDetails',
            'orderItems.subProduct.embellishmentTypes',
            'orderItems.productEmbellishmentTypes.embellishmentTypes',
            'orderItems.statusDetails',
            'orderItems.notifiedUser'
        ]);

        $order = $orderDetailsQuery
            ->where('orders.id', $orderId)
            ->where('orders.organization_id', $org_id)
            ->first();

        abort_if(!$order, 404, 'Order not found.');

        $contacts = Contact::where('active' , 1)->get();
        // dd($order->orderItems->first()->orderItemAttributess->attribute);
        return view('pages.customer_portal.order.includes.order_item_detail',['order'=>$order, 'contacts'=>$contacts, 'orderItemAttributes'=>$orderItemAttributes]);
        // $this->userGroupFactories();

        // // $orders = $ordersQuery->where('id', $orderId)->first();

        // $order_item_id_array = OrderItem::where('order_id', $orderId)->where('active', 1)->pluck('id')->toArray();

        // $test_print_due_date_arr = [];

        // foreach ($order_item_id_array as $order_item_id) {
        //     $item = OrderItem::where('id', $order_item_id)->first();
        //     if (!empty($item->test_print_due_date)) {
        //         $test_print_due_date_arr[] = Carbon::createFromFormat('m/d/Y', $item->test_print_due_date);
        //     }
        // }

        // if (count($test_print_due_date_arr) > 0) {
        //     usort($test_print_due_date_arr, function($a, $b) {
        //         return $b <=> $a;
        //     });
        //     $most_recent_date = $test_print_due_date_arr[0];
        //     $Order_test_print_due_date = $most_recent_date->format('m/d/Y');
        // } else {
        //     $Order_test_print_due_date = 'No available';
        // }

        // $organizationQuery = Organization::select('id', 'organization_name');
        //     if($this->isInventoryOrder($orders->organization_id)){
        //         $organizationQuery->whereIn('id', $this->inventoryOrgIds);
        //     } else {
        //         $organizationQuery->whereNotIn('id', $this->inventoryOrgIds);
        //     }

        // $orderStatuses = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();

        // $activeUserGroups = Role::whereNotIn('id', [1])->where('active','1')->orderBy('name')->get();

        // $subProducts = SubProduct::orderBy('product_name')->where('active' , 1)->get();

        // $factories = Factory::where('active', 1)->orderBy('factory_name')->get();

        // $fabrics = Fabric::where('active', 1)->orderBy('fabric_name')->get();

        // $attributes = Attribute::where('active', 1)->where('is_sub_attribute', 0)->orderBy('id')->get();

        // $attributeGroups = AttributeGroup::with('groupAttributes')->where('active', 1)->orderBy('id')->get();

        // $subAttributes = Attribute::where('active', 1)->where('is_sub_attribute', 1)->orderBy('id')->get();

        // $clouser_types = ClouserType::where('active', 1)->orderBy('clouser_name')->get();

        // $embellishmentTypes = EmbellishmentType::where('active', 1)->orderBy('embellishment_name')->get();

        // // $exFactories = ExFactory::where('order_item_id',$orderitemId)->where('active', 1)->orderBy('ex_factory_name')->get();
        // // Initialize the results array
        // $results = [];

        // // Fetch all contacts from the order's organizationDetails
        // if ($orders && $orders->organizationDetails) {
        //     foreach ($orders->organizationDetails->contactOrganizations as $contactOrganization) {
        //         foreach ($contactOrganization->contacts as $contact) {
        //             $results[] = [
        //                 'id' => 'con_' . $contact->id,  // Prefix 'con_' for contacts
        //                 'name' => $contact->first_name . ' ' . $contact->last_name,
        //                 'type' => 'contact',  // Adding 'type' to specify it's a contact
        //                 'table_id' => $contact->id,  // Adding 'table_id' for contact
        //             ];
        //         }
        //     }
        // }
        // // Fetch all active ex-factories based on the order item
        // $exFactories = ExFactory::where('order_item_id', $orderitemId)
        //     ->where('active', 1)
        //     ->orderBy('ex_factory_name')
        //     ->get(['id', 'contact_id', 'ex_factory_name']);

        // // Merge exFactories while excluding duplicates based on contact_id
        // foreach ($exFactories as $exFactory) {
        //     // Check if the contact_id already exists in the results
        //     $contactKey = $exFactory->contact_id ? $exFactory->contact_id : null;
        //     $isDuplicate = $contactKey && in_array($contactKey, array_column($results, 'table_id'));

        //     // If a duplicate contact exists, remove the contact entry before adding the exFactory
        //     if ($isDuplicate) {
        //         // Remove the contact entry from results by filtering out the contact with the same contact_id
        //         $results = array_filter($results, function($result) use ($contactKey) {
        //             return !($result['type'] == 'contact' && $result['table_id'] == $contactKey);
        //         });
        //     }

        //     // Only add exFactory if contact_id is not present in the results
        //     $results[] = [
        //         'id' => 'ex_' . $exFactory->id,  // Prefix 'ex_' for exFactories
        //         'name' => $exFactory->ex_factory_name,
        //         'type' => 'exFactory',  // Adding 'type' to specify it's an exFactory
        //         'table_id' => $exFactory->id,  // Adding 'table_id' for exFactory
        //     ];
        // }
        // $exFactories = ExFactory::where('order_item_id', $orderitemId)
        //     ->where('active', 1)
        //     ->orderBy('ex_factory_name')
        //     ->get();
        // $arrayPlayerNames = [];
        // $arrayPlayerNamesPattern = array();
        // //$mainArrayString = "";
        // $orderItemsDetailIds = OrderItemsDetailPlayerName::select('order_items_detail_id')->where('order_id',$orderId)->where('active',1)->distinct()->get();
        // foreach($orderItemsDetailIds as $orderItemsDetailId)
        // {
        //     $subArrayString = "";
        //     $orderItemsDetailIdAllDetails = OrderItemsDetailPlayerName::where('order_items_detail_id',$orderItemsDetailId->order_items_detail_id)->where('active',1)->get();
        //     foreach($orderItemsDetailIdAllDetails as $orderItemsDetailIdAllDetail)
        //     {
        //         if($subArrayString == "")
        //         {
        //             $subArrayString = "\"num$orderItemsDetailIdAllDetail->number_sequence\":\"$orderItemsDetailIdAllDetail->name\"";
        //         }
        //         else
        //         {
        //             $subArrayString = $subArrayString . ", \"num$orderItemsDetailIdAllDetail->number_sequence\":\"$orderItemsDetailIdAllDetail->name\"";
        //         }
        //     }


        //     $arrayElemnts = "{".$subArrayString."}";
        //     array_push($arrayPlayerNames,json_decode($arrayElemnts));
        //     array_push($arrayPlayerNamesPattern,$orderItemsDetailId->order_items_detail_id);
        //     //$arrayPlayerNamesPattern
        // }
        // $cardPayment = PaymentLog::where('order_id', $orderId)->sum('amount');
        // $checkPayment = CheckPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        // $otherPayment = OtherPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        // $paypalPayement = PaypalPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
        // $venmoPayment = VenmoPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');

        // $payment = 0;

        // if($cardPayment > 0 && $paypalPayement > 0){
        //     $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

        // } else if ($cardPayment > 0 && $paypalPayement == 0) {
        //     $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

        // } else if ($cardPayment == 0 && $paypalPayement > 0) {
        //     $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

        // } else {
        //     $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
        // }

        // $balnceToBePaid = 0;
        // $processingFee = 0;
        // $orderTotal = $orders->sum('order_total');
        // $totalPayment = round($cardPayment, 2) + round($paypalPayement, 2);

        // if ($payment == 0 && $orderTotal > 0) {
        //     $paymentStatus = 0; // Pending


        // } else if ($payment < round($orders->order_total, 2) && $payment > 0) {
        //     $paymentStatus = 1; // Partial
        //     $balnceToBePaid = $orders->order_total - $payment;
        //     $processingFee = round(($cardPayment + $venmoPayment)*3/103 , 2);

        // } else {
        //     $paymentStatus = 2; // Paid
        //     if($totalPayment > 0 && $totalPayment > $orderTotal){
        //         // $processingFee = $totalPayment - $orderTotal;
        //         $processingFee = round(($cardPayment + $venmoPayment)*3/103 , 2);

        //     }
        // }
        // if($orderTotal == 0){
        //     $balnceToBePaid = 0;
        //     $paymentStatus = 2;
        // }
        // $orderTrait = $this;
        // $bulk_invoice = BulkInvoice::whereRaw('FIND_IN_SET(?, order_ids)', [$orderId])
        //                    ->where('active', 1)
        //                    ->first();
        // if($bulk_invoice && $bulk_invoice->payment_status == 0 && $paymentStatus == 2){
        //     $bulk_invoice->payment_status = 2;
        //     $bulk_invoice->save();
        // }
        // $blade = 'orderItemDetails';

        //     return view('pages.order_management.orders.view_orderitem', [
        //                 // 'organizations'=>$organizations,
        //                 'order'=>$orders,
        //                 'orderStatuses'=>$orderStatuses,
        //                  'fabrics'=>$fabrics,
        //                  'embellishmentTypes'=>$embellishmentTypes,
        //                 'factories'=>$factories,
        //                 'exFactories'=>$results,
        //                 'exFactoriesData'=>$exFactories,
        //                 'arrayPlayerNamesPattern'=>$arrayPlayerNamesPattern,
        //                 'orderTrait'=>$orderTrait,
        //                 'subProducts'=>$subProducts ,
        //                 'clouser_types'=>$clouser_types ,
        //                 'attributes'=>$attributes,
        //                 'attributeGroups'=>$attributeGroups,

        //     ]);


    }
    public function roster_update(Request $request){

        $orders = $request->order;
        $players = $request->players;

        $sequences =
            [ 'one' ,'two' ,'three' ,'four' ,'five', 'six' ,'seven' ,'eight' ,'nine' ,'ten',

            'eleven' ,'twelve' ,'thirteen' ,'fourteen' ,'fifteen' , 'sixteen' ,'seventeen' ,'eighteen' ,'nineteen' ,'twenty' ,

            'twenty_one' ,'twenty_two' ,'twenty_three' ,'twenty_four' ,'twenty_five','twenty_six' ,'twenty_seven' ,'twenty_eight' ,'twenty_nine' ,'thirty' ,

            'thirty_one' ,'thirty_two' ,'thirty_three' ,'thirty_four' ,'thirty_five' ,'thirty_six' ,'thirty_seven' ,'thirty_eight' ,'thirty_nine' ,'forty',

            'forty_one' ,'forty_two' ,'forty_three' ,'forty_four' ,'forty_five' ,'forty_six' ,'forty_seven' ,'forty_eight' ,'forty_nine' ,'fifty',

            'fifty_one' ,'fifty_two' ,'fifty_three' ,'fifty_four' ,'fifty_five' ,'fifty_six' ,'fifty_seven' ,'fifty_eight' ,'fifty_nine' ,'sixty' ,

            'sixty_one' ,'sixty_two' ,'sixty_three' ,'sixty_four' ,'sixty_five' ,'sixty_six' ,'sixty_seven' ,'sixty_eight' ,'sixty_nine' ,'seventy',

            'seventy_one' ,'seventy_two' ,'seventy_three' ,'seventy_four' ,'seventy_five','seventy_six' ,'seventy_seven' ,'seventy_eight' ,'seventy_nine' ,'eighty',

            'eighty_one' ,'eighty_two' ,'eighty_three' ,'eighty_four' ,'eighty_five' ,'eighty_six' ,'eighty_seven' ,'eighty_eight' ,'eighty_nine' ,'ninety',

            'ninety_one' ,'ninety_two' ,'ninety_three' ,'ninety_four' ,'ninety_five' ,'ninety_six' ,'ninety_seven' ,'ninety_eight' ,'ninety_nine' ,'hundred',

            'hundred_one' ,'hundred_two' ,'hundred_three' ,'hundred_four' ,'hundred_five', 'hundred_six' ,'hundred_seven' ,'hundred_eight' ,'hundred_nine' ,'hundred_ten',

            'hundred_eleven' ,'hundred_twelve' ,'hundred_thirteen' ,'hundred_fourteen' ,'hundred_fifteen' , 'hundred_sixteen' ,'hundred_seventeen' ,'hundred_eighteen' ,'hundred_nineteen' ,'hundred_twenty' ,

            'hundred_twenty_one' ,'hundred_twenty_two' ,'hundred_twenty_three' ,'hundred_twenty_four' ,'hundred_twenty_five','hundred_twenty_six' ,'hundred_twenty_seven' ,'hundred_twenty_eight' ,'hundred_twenty_nine' ,'hundred_thirty' ,

            'hundred_thirty_one' ,'hundred_thirty_two' ,'hundred_thirty_three' ,'hundred_thirty_four' ,'hundred_thirty_five' ,'hundred_thirty_six' ,'hundred_thirty_seven' ,'hundred_thirty_eight' ,'hundred_thirty_nine' ,'hundred_forty',

            'hundred_forty_one' ,'hundred_forty_two' ,'hundred_forty_three' ,'hundred_forty_four' ,'hundred_forty_five' ,'hundred_forty_six' ,'hundred_forty_seven' ,'hundred_forty_eight' ,'hundred_forty_nine' ,'hundred_fifty'];


    if($orders){

        foreach ($orders as $orderID => $OrderItems){

            $order = Order::find($orderID);
            // $OrderItems = OrderItem::where('order_id' , $orderID)->get();

            // if(!empty($OrderItems)){

                foreach ($OrderItems as $OrderItemID =>  $OrderItem){

                    $uniqueOrderItemQty = 0;
                    $uniqueOrderItem = OrderItem::find($OrderItemID);

                    $uniqueOrderItem->individual_no = 0;

                    $orderItemAttributes = OrderItemAttribute::where('order_item_id', $OrderItemID)->get();

                    foreach ($orderItemAttributes as $orderItemAttribute){
                        if ($orderItemAttribute->attribute_id == 1){
                            $uniqueOrderItem->individual_no = 1;
                        }
                    }



                    if($uniqueOrderItem->individual_no == 1){
                        if(isset($OrderItem['num-qty'])){
                            $uniqueOrderItem->qty = $OrderItem['num-qty'];
                            $uniqueOrderItemQty = $OrderItem['num-qty'];
                        }
                    }else{
                        if(isset($OrderItem['blank-qty'])){
                            $uniqueOrderItem->qty = $OrderItem['blank-qty'];
                            $uniqueOrderItemQty = $OrderItem['blank-qty'];
                        }
                    }

                    if($uniqueOrderItem->individual_no == 1){

                        if(isset($OrderItem['extra_size-num'])){
                            $uniqueOrderItem->extra_size = $OrderItem['extra_size-num'];
                        }
                        if(isset($OrderItem['extra_size_two-num'])){
                            $uniqueOrderItem->extra_size_two = $OrderItem['extra_size_two-num'];
                        }
                        if(isset($OrderItem['extra_size_three-num'])){
                            $uniqueOrderItem->extra_size_three = $OrderItem['extra_size_three-num'];
                        }


                    }else{

                        if(isset($OrderItem['extra_size'])){
                            $uniqueOrderItem->extra_size = $OrderItem['extra_size'];
                        }
                        if(isset($OrderItem['extra_size_two'])){
                            $uniqueOrderItem->extra_size_two = $OrderItem['extra_size_two'];
                        }
                        if(isset($OrderItem['extra_size_three'])){
                            $uniqueOrderItem->extra_size_three = $OrderItem['extra_size_three'];
                        }
                    }


                    $uniqueOrderItem->total =  $uniqueOrderItem->unit_price * $uniqueOrderItemQty;

                    $uniqueOrderItem->save();


                    $OrderItemDetails = OrderItemsDetail::where('order_item_id' , $OrderItemID)->get();

                    if(!empty($OrderItemDetails)){

                        foreach($OrderItemDetails as $OrderItemDetail){

                            $UniqueOrderItemDetail = OrderItemsDetail::find($OrderItemDetail->id);
                            $UniqueplayerDetail = OrderItemsDetailPlayerName::where('order_items_detail_id' , $OrderItemDetail->id)->first();

                            if(isset($OrderItem[$OrderItemDetail->id]) && isset($OrderItem[$OrderItemDetail->id]['qty'])){
                                $UniqueOrderItemDetail->qty = $OrderItem[$OrderItemDetail->id]['qty'];
                            }else{
                                $UniqueOrderItemDetail->qty = null;
                            }
                            if(isset($OrderItem[$OrderItemDetail->id]) && isset($OrderItem[$OrderItemDetail->id]['blanks'])){
                                $UniqueOrderItemDetail->blanks = $OrderItem[$OrderItemDetail->id]['blanks'];
                            }else{
                                $UniqueOrderItemDetail->blanks = null;
                            }

                            if($UniqueplayerDetail && isset($players[$orderID]) && isset($players[$orderID][$OrderItemID]) && $uniqueOrderItem->individual_name == 1 && $UniqueOrderItemDetail->blanks > 0){
                                $playersArray = $players[$orderID][$OrderItemID];
                                $transformedArray = [];


                                if(isset($playersArray[$OrderItemDetail->id]) && count($playersArray[$OrderItemDetail->id]) > 0){

                                    $transformedArray = [];

                                    foreach ($playersArray[$OrderItemDetail->id] as $value) {
                                        if ($value !== null) {
                                            $transformedArray[] = $value;
                                        } else {
                                            $transformedArray[] = "";
                                        }
                                    }

                                    $UniqueplayerDetail->blank_player_names = array_merge(...$transformedArray);
                                    $UniqueplayerDetail->save();

                                }

                            }

                            $countSeq = 0;

                            foreach ($sequences as $sequence){

                                if(isset($OrderItem[$OrderItemDetail->id]) && isset($OrderItem[$OrderItemDetail->id]['numseq_'.$sequence]) && $OrderItem[$OrderItemDetail->id]['numseq_'.$sequence] !== ''){
                                    $UniqueOrderItemDetail->{'numseq_'.$sequence} = $OrderItem[$OrderItemDetail->id]['numseq_'.$sequence];
                                }else if($UniqueOrderItemDetail->{'numseq_'.$sequence} != null){
                                    $UniqueOrderItemDetail->{'numseq_'.$sequence} = null;
                                }

                                if($UniqueplayerDetail){
                                    if(isset($players[$orderID][$OrderItemID][$OrderItemDetail->id]['player_'.$sequence]) && !empty($players[$orderID][$OrderItemID][$OrderItemDetail->id]['player_'.$sequence])){
                                        $UniqueplayerDetail->{'player_'.$sequence} = $players[$orderID][$OrderItemID][$OrderItemDetail->id]['player_'.$sequence];
                                    }else if($UniqueplayerDetail->{'player_'.$sequence} != null){
                                        $UniqueplayerDetail->{'player_'.$sequence} = null;
                                    }
                                }

                                $countSeq++;

                                // newly added optimization

                                if($UniqueOrderItemDetail->qty + $UniqueOrderItemDetail->blanks < $countSeq){
                                    break;
                                }
                            }


                            $UniqueOrderItemDetail->save();
                            if($UniqueplayerDetail){

                                $UniqueplayerDetail->save();
                            }

                        }
                    }


                }
            // }

            $organization = Organization::find($order->organization_id);
            $orderSubTotal = OrderItem::where('order_id', $orderID)->sum('total');
            if ($organization->sales_tax_active == 1) {
                $salesTax = $organization->sales_tax;
            } else {
                $salesTax = 0;
            }
            $orderSalesTax = ($orderSubTotal / 100) * $salesTax;
            $orderShipping = $order->shipping ?? '';
            $orderArtwork = $order->artwork ?? '';
            $orderProcessingFee = $order->processing_fee ?? '';
            $orderFeesTotal = $orderSalesTax + $orderShipping + $orderArtwork + $orderProcessingFee;

            $order->sub_total = $orderSubTotal;
            $order->order_total = $orderSubTotal + $orderFeesTotal;
            $order->sales_tax = $orderSalesTax;
            $order->save();

            $this->setShippingFee($order->id);

            // salse tax calculation

        $order_update = Order::find($order->id);

        $subtotal = $order_update->sub_total;
        $orderSalesTax = $order_update->sales_tax ?? 0.00;

        $organization = Organization::find($order_update->organization_id);
        if ($organization->sales_tax_active == 1) {
            $salesTax = $organization->sales_tax;
        } else {
            $salesTax = 0;
        }

        $orderShipping = $order_update->shipping ?? 0.00;
        $orderArtwork = $order_update->artwork ?? 0.00;

        $order_total_amount = $subtotal + $orderArtwork;

        if($order_update->discount_hidation == 1 ){

            if($order_update->discountType == 1){

                $discountAmount = ($order_total_amount / 100) * $order_update->discount;

            } elseif($order_update->discountType == 2) {

                $discountAmount = $order_update->discount;
            }

        }else{
            $discountAmount = 0.00;
        }

        $orderSalesTax = (($order_total_amount - $discountAmount) / 100) * $salesTax;

        $order_update->sub_total = $subtotal;
        $order_update->order_total = $order_total_amount + $orderSalesTax - $discountAmount + $orderShipping;
        $order_update->sales_tax = $orderSalesTax;
        $order_update->save();

        AccountsLog::where('order_id', $order_update->id)->where('type', 0)->where('status', 1)->where('note', 'Outstanding Invoice')->update(
            [
                'amount' => $order_update->order_total,
                'debit_balance' => $order_update->order_total,
            ]
        );

        }
    }

        return redirect()->back();

    }
    public function order_tracking(Request $request){
        return view('pages.customer_portal.order.order_tracking');
    }
    public function receiver_address_update(Request $request){

        $org_id = $this->portalOrganizationId();

        abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

        $order = Order::with('organizationDetails')
            ->where('organization_id', $org_id)
            ->findOrFail($request->order_id);

        if($request->new_shipping_address){
            $order->is_new_shipping_address = 1;

            $order->wl_receiver_name = $request->wl_receiver_name;
            $order->apartment = $request->new_Apartment;
            $order->street = $request->new_street;
            $order->city = $request->new_city;
            $order->state = $request->new_state;
            $order->postal_code = $request->new_postal_code;
            $order->country = $request->new_country;
            $order->phone_no = $request->new_phone_no;
            $order->email = $request->new_email;
            $order->save();
        }

        $users = User::whereIn('id', [1, 62, 75, $order->user_id, $order->order_procesing_user_id, ])->where('active', 1)->get();

        $order_items = OrderItem::where('order_id', $order->id)->where('active', 1)->get();

        $is_dwc_available = false;

        foreach ($order_items as $order_item) {
            if(!$is_dwc_available){
                $is_dwc_available = $order_item->factory_id == 1;
            }
        }

        // foreach ($users as $user) {
        //     $notification = new Notification();
        //     $notification->notification_title = 'New shipping details for Order - #' . $order->order_no. ' has been updated.';
        //     $notification->notification_message = 'Shipping details for Order - #'.$order->order_no.' have been updated by the customer.<br><br>
        //                                             <strong>New Address:</strong><br>
        //                                             '.$order->wl_receiver_name.', '.$order->apartment.', '.$order->street.',<br>
        //                                             '.$order->city.', '.$order->state.', '.$order->postal_code.'<br><br>
        //                                             <strong>Contact Details:</strong><br>
        //                                             '.$order->phone_no.'<br>
        //                                             '.$order->email.'';
        //     $notification->user_id = $user->id;
        //     $notification->order_id = $order->id;
        //     $notification->save();
        // }
        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_receiver_address_update', [
            '{Order_number}' => $order->order_no,
            '{receiver_name}' => $order->wl_receiver_name,
            '{apartment}' => $order->apartment,
            '{street}' => $order->street,
            '{city}' => $order->city,
            '{state}' => $order->state,
            '{postal_code}' => $order->postal_code,
            '{phone_no}' => $order->phone_no,
            '{email}' => $order->email,
        ], [

            'order_id' => $order->id,
        ]);
        email_Notify()->sendEmailFromTemplate('ket_email_receiver_address_update', [
                'orderId' => $order->id,
                'orderNo' => $order->order_no,
                'customer_name' => $order->wl_receiver_name,
                'customer_apartment' => $order->apartment,
                'customer_street' => $order->street,
                'customer_city' => $order->city,
                'customer_state' => $order->state,
                'customer_phone_no' => $order->phone_no,
                'customer_email' => $order->email,
                'customer_postal_code' => $order->postal_code,

            ]);

        // if($is_dwc_available){

        //     foreach ($users as $user) {

        //         config([
        //             'mail.mailers.smtp.host' => $this->smtpHost,
        //             'mail.mailers.smtp.port' => $this->smtpPort,
        //             'mail.mailers.smtp.encryption' => $this->smtpEncryption,
        //             'mail.mailers.smtp.username' => $this->mailUsername,
        //             'mail.mailers.smtp.password' => $this->mailPassword,
        //             'mail.from.address' => $this->mailUsername,
        //             'mail.from.name' => 'Encore Custom',
        //         ]);

        //         $data = [
        //             'to' => $user->email,
        //             'subject' => 'New shipping details for Order - #' . $order->order_no . ' has been updated.',
        //             'body' => "
        //                 Shipping details for Order - #{$order->order_no} have been updated by the customer.<br><br>
        //                 <strong>New Address:</strong><br>
        //                 {$order->wl_receiver_name}, {$order->apartment}, {$order->street},<br>
        //                 {$order->city}, {$order->state}, {$order->postal_code}<br><br>
        //                 <strong>Contact Details:</strong><br>
        //                 {$order->phone_no}<br>
        //                 {$order->email}
        //             "
        //         ];

        //         Mail::send('emailNotification.customer_details_on_change', $data, function ($message) use ($data) {
        //             $message->to($data["to"]);
        //             $message->subject($data["subject"]);
        //         });
        //     }
        // }


        return response()->json([
            'success' => true,
            'message' => 'Address updated successfully!',
            'order' => $order,
        ]);

    }
    public function markAsReceived(Request $request)
    {
        // dd($request->all());
        $request->validate([
            'tracking_no' => 'required|exists:shipping_order_details,tracking_no'
        ]);

        // Find records by tracking number
        $records = ShippingOrderDetails::where('tracking_no', $request->tracking_no)
            ->get();

        if ($records->isEmpty()) {
            return response()->json([
                'success' => false,
                'message' => 'Record not found'
            ]);
        }

        // Check if already received
        if ($records->first()->customer_received) {
            return response()->json([
                'success' => false,
                'message' => 'Already marked as received'
            ]);
        }

        $now = Carbon::now();

        // Update all matched records
        ShippingOrderDetails::where('tracking_no', $request->tracking_no)
            ->update([
                'customer_received' => $now
            ]);

        return response()->json([
            'success' => true,
            'received_at' => $now->format('Y-m-d H:i:s')
        ]);
    }


    public function setShippingFee($orderId){
        $order = Order::find($orderId);
        $orderTotal = $order->order_total;
        $orderTotal = $orderTotal - $order->shipping;
        $orderQty = OrderItem::where('order_id', $orderId)->get()->sum('qty');
        if($orderQty > 70){
            $shippingFee = 0.5 * $orderQty;
        } else if($orderQty == 0){
            $shippingFee = 0;
        } else {
            $shippingFee = 35;
        }
        $order->shipping = $shippingFee;
        $order->order_total = $orderTotal + $shippingFee;
        $order->update();
    }

    public function payments(){

            $org_id = $this->portalOrganizationId();

            abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

            $orders = Order::with('userDetails')
                            ->where('organization_id', $org_id)
                            ->where('active', 1)
                            ->whereNotIn('order_status_id', [7])
                            ->get()
                            ->transform(function ($order) {
                                $order->payment_status = app(\App\Services\PaymentService::class)->getPaymentStatus($order->id);
                                return $order;
                            });


            return view('pages.customer_portal.payments.individual_payment', ['orders'=>$orders ]);

    }
    // public function bulk_invoices(){
    //     $org_id = Session::get('customer_portal_user')[1];
    //     $bulk_invoice_details = [];

    //     $bulk_invoices = BulkInvoice::with('organizationDetails')->get();

    //     $bulk_invoices = BulkInvoice::where('organization_id',$org_id)->with('organizationDetails')
    //         ->where('active', 1)
    //         ->get();

    //     foreach ($bulk_invoices as $bulk_invoice) {

    //         $order_ids = explode(',', trim($bulk_invoice->order_ids, ','));

    //         $order_ids = array_filter($order_ids);

    //         $orders = Order::whereIn('id', $order_ids)
    //             ->with('organizationDetails', 'userDetails', 'contactDetails', 'orderItems', 'invoiceDetails')
    //             ->get();

    //         $order_details = [];

    //         foreach ($orders as $order) {

    //             $cardPayment = PaymentLog::where('order_id', $order->id)->sum('amount');
    //             $checkPayment = CheckPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
    //             $otherPayment = OtherPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
    //             $paypalPayement = PaypalPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
    //             $venmoPayment = VenmoPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');

    //             if($cardPayment > 0 && $paypalPayement > 0){
    //                 $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

    //             } else if ($cardPayment > 0 && $paypalPayement == 0) {
    //                 $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

    //             } else if ($cardPayment == 0 && $paypalPayement > 0) {
    //                 $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

    //             } else {
    //                 $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
    //             }

    //             $order_details[$order->id]['order'] = $order;
    //             $order_details[$order->id]['paid_amount'] = $payment;
    //         }

    //         $bulk_invoice_details[$bulk_invoice->id]['invoice'] = $bulk_invoice;
    //         $bulk_invoice_details[$bulk_invoice->id]['order'] = $order_details;
    //     }


    //     return view('pages.customer_portal.payments.bulk_payment',['bulk_invoices' => $bulk_invoice_details]);
    // }

    public function payment_edit(Request $request){

        if($request->has('orderId')){

            $orderId = $request->orderId;
            $org_id = $this->portalOrganizationId();

            abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

            $orderDetails = Order::with('contactDetails', 'organizationDetails')
                ->where('organization_id', $org_id)
                ->find($orderId);

            if (!$orderDetails) {
                return redirect()->route('customer_portal.payments')
                    ->with('error', 'Order not found for this organization.');
            }

            if($orderDetails->organizationDetails && ($orderDetails->organizationDetails->sales_tax == null || $orderDetails->organizationDetails->sales_tax == 0.00) && $orderDetails->organizationDetails->shipping_state == 'CA' && $orderDetails->organizationDetails->sales_tax_active == 1  )
            {

               
                $builder = new NotificationBuilderService();

                $builder->sendNotification('key_payment_edit', 
                [
                    '{order_no}'          => $orderDetails->order_no,
                    '{organization_name}' => $orderDetails->organizationDetails->organization_name ?? '',
                    '{organization_link}' => url("organizations/info/{$orderDetails->organization_id}"),
                ],
                [
                    'target_notification_field'  => 'key_payment_edit',
                    'new_notification'           => 1,
                    'order_id' => $orderId,
                ]);

                return back()->with("error", "Payment cannot proceed due to missing sales tax on your order. Please contact your sales representative for assistance. We apologize for any inconvenience.");
                // exit();
            }

            $contact = $this->portalContact();

            $months = array(1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 7 => '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12');

            $cardPayments = PaymentLog::where('order_id', $orderId)->get();
            $checkPayments = CheckPayment::where('order_id', $orderId)->get();
            $venmoPayments = VenmoPayment::where('order_id', $orderId)->get();
            $paypalPayments = PaypalPayment::where('order_id', $orderId)->get();
            $PurchaseorderReceipts = PurchaseorderReceipt::where('order_id', $orderDetails->id)->orderByDesc('created_at')->first();
            $otherPayments = OtherPayment::where('order_id', $orderId)->get();

            $cardAmount = PaymentLog::where('order_id', $orderId)->sum('amount');
            $checkAmount = CheckPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
            $venmoAmount = VenmoPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
            $paypalAmount = PaypalPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');
            $purchaseorderAmount = PurchaseorderReceipt::where('order_id', $orderId)->where('is_approved' , 1)->first()->amount ?? 0.00;
            $otherAmount = OtherPayment::where('order_id', $orderId)->where('is_approved' , 1)->sum('amount');

            $payment = 0;
            if($cardAmount > 0 && $paypalAmount > 0){
                $payment = round(((($cardAmount + $paypalAmount) * 100)/103),2) + $checkAmount + $venmoAmount + $otherAmount + $purchaseorderAmount;

            } else if ($cardAmount > 0 && $paypalAmount == 0) {
                $payment = round(($cardAmount * 100)/103,2) + $checkAmount + $venmoAmount + $otherAmount + $purchaseorderAmount;

            } else if ($cardAmount == 0 && $paypalAmount > 0) {
                $payment = $checkAmount + round((($paypalAmount * 100)/103),2) + $venmoAmount + $otherAmount + $purchaseorderAmount;

            } else {
                $payment = $cardAmount + $checkAmount + $paypalAmount + $venmoAmount + $otherAmount + $purchaseorderAmount;
            }

            $balnceToBePaid = 0;
            if ($payment == 0 && $orderDetails->order_total > 0) {
                $paymentStatus = 0; // Pending

            } else if ($payment < $orderDetails->order_total && $payment > 0) {
                $paymentStatus = 1; // Partial
                $balnceToBePaid = $orderDetails->order_total - $payment;

            } else {
                $paymentStatus = 2; // Paid
            }

            // $totalItemQty = $request->query('totalItemQty');
            // $sub_total = $request->query('sub_total');
            // $shipping = $request->query('shipping');
            // $salesTax = $request->query('salesTax');
            // $artwork = $request->query('artwork');
            // $processingFee = $request->query('processingFee');
            // $orderTotal = $request->query('orderTotal');
            // $balancePayment = $balnceToBePaid;
             $totalItemQty =1;
            $sub_total = 1;
            $shipping = 1;
            $salesTax = 1;
            $artwork = 1;
            $processingFee = 1;
            $orderTotal = 1;
            $balancePayment = $balnceToBePaid;

            return view('pages.customer_portal.payments.payment_edit', [
                'contact'=>$contact ,'months'=>$months, 'orderDetails'=>$orderDetails, 'cardPayments'=>$cardPayments, 'cardAmount'=>$cardAmount, 'checkAmount'=>$checkAmount, 'venmoAmount'=>$venmoAmount, 'paypalAmount'=>$paypalAmount, 'otherAmount'=>$otherAmount, 'purchaseorderAmount' => $purchaseorderAmount,
                'payment'=>$payment, 'paymentStatus'=>$paymentStatus, 'checkPayments'=>$checkPayments, 'venmoPayments'=>$venmoPayments, 'paypalPayments'=>$paypalPayments, 'otherPayments'=>$otherPayments, 'PurchaseorderReceipts' => $PurchaseorderReceipts,
                'totalItemQty' => $totalItemQty, 'sub_total' => $sub_total, 'shipping'=>$shipping, 'salesTax'=>$salesTax, 'artwork'=>$artwork, 'processingFee'=>$processingFee,
                'orderTotal'=>$orderTotal, 'balancePayment'=>$balancePayment,
            ]);
        }else{
            return redirect()->route('customer_portal.payments');
        }
    }

    public function shipping(){

            $contact = $this->portalContact();

            return view('pages.customer_portal.shipping', ['contact'=>$contact]);

    }

    public function settings(){

            $org_id = $this->portalOrganizationId();

            abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

            $contact = $this->portalContact();
            $organization = Organization::where('id' , $org_id)->with('contactOrganizations')->firstOrFail();
            $sports = Sport::where('active', 1)->orderBy('sport_name')->get();
            $lead_sources = LeadSource::where('active', 1)->get();
            return view('pages.customer_portal.settings', ['contact'=>$contact, 'organization'=>$organization, 'sports'=>$sports, 'lead_sources'=>$lead_sources]);

    }
    public function Org_update(Request $request, $id)
    {
        $org_id = $this->portalOrganizationId();

        abort_if(!$org_id || (int) $org_id !== (int) $id, 403, 'Unauthorized organization access.');

        $organization = Organization::findOrFail($id);

        $request->validate([
            'website' => 'nullable',
            'sport_id' => 'required|exists:sports,id',
            'size_of_club' => 'nullable|string',
            'shipping_country' => 'nullable|string',
            'shipping_state' => 'nullable|string',
            'shipping_street' => 'nullable|string',
            'shipping_city' => 'nullable|string',
            'shipping_postal_code' => 'nullable|string',
            'organization_note' => 'nullable|string',
        ]);

        $sameAsShipping = $request->has('same_as_shipping') ? 1 : 0;

        $organization->update([
            'website' => $request->website,
            'sport' => $request->sport_id,
            'size_of_club' => $request->size_of_club,
            'lead_source' => $request->lead_source_id,

            'shipping_country' => $request->shipping_country,
            'shipping_state' => $request->shipping_state,
            'shipping_street' => $request->shipping_street,
            'shipping_city' => $request->shipping_city,
            'shipping_postal_code' => $request->shipping_postal_code,

            'same_as_shipping' => $sameAsShipping,

            'billing_country' => $sameAsShipping ? $request->shipping_country : $request->billing_country,
            'billing_state' => $sameAsShipping ? $request->shipping_state : $request->billing_state,
            'billing_street' => $sameAsShipping ? $request->shipping_street : $request->billing_street,
            'billing_city' => $sameAsShipping ? $request->shipping_city : $request->billing_city,
            'billing_postal_code' => $sameAsShipping ? $request->shipping_postal_code : $request->billing_postal_code,

            'organization_note' => $request->organization_note,
        ]);

        return response()->json(['success' => true]);
    }

    public function updateLogo(Request $request, $id)
    {
        $org_id = $this->portalOrganizationId();

        abort_if(!$org_id || (int) $org_id !== (int) $id, 403, 'Unauthorized organization access.');

        $organization = Organization::findOrFail($id);

        if ($request->hasFile('organization_logo')) {
            $logoImagePath = self::uploadOrganizationLogo($request);
        } else {
            $logoImagePath = $organization->organization_logo ?? "assets/img/organization/default.png";
        }

        $organization->organization_logo = $logoImagePath;
        $organization->save();

        // Update session header logo
        session(['customer_portal_org_image' => [$logoImagePath]]);

        return response()->json([
            'success' => true,
            'logo_path' => $logoImagePath,
            'logo_url' => asset($logoImagePath) . '?v=' . time(),
        ]);
    }
    public function uploadOrganizationLogo(Request $request) {
        $file = $request->file('organization_logo');

        $destinationPath = 'assets/img/organization';

        $file->move($destinationPath, $file->getClientOriginalName());

        return $destinationPath.'/'.$file->getClientOriginalName();
    }
    public function payMultipleOrders(Request $request)
    {
        $orderIds = explode(',', $request->order_ids);
        $org_id = $this->portalOrganizationId();

        abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

        $contact = $this->portalContact();
        $organization = Organization::where('id' , $org_id)->with('contactOrganizations')->firstOrFail();

        $orders = Order::whereIn('id', $orderIds)
            ->where('organization_id', $org_id)
            ->with('contactDetails', 'organizationDetails')
            ->get();

        foreach ($orders as $orderDetails) {
            if (
                $orderDetails->organizationDetails
                && ($orderDetails->organizationDetails->sales_tax == null || $orderDetails->organizationDetails->sales_tax == 0.00)
                && $orderDetails->organizationDetails->shipping_state == 'CA'
                && $orderDetails->organizationDetails->sales_tax_active == 1
            ) {
                $builder = new NotificationBuilderService();

                $builder->sendNotification('key_payment_edit', 
                [
                    '{order_no}'          => $orderDetails->order_no,
                    '{organization_name}' => $orderDetails->organizationDetails->organization_name ?? '',
                    '{organization_link}' => url("organizations/info/{$orderDetails->organization_id}"),
                ],
                [
                    'target_notification_field'  => 'key_payment_edit',
                    'new_notification'           => 1,
                    'order_id' => $request->order_ids,
                ]);
                return back()->with("error", "Payment cannot proceed due to missing sales tax on your order. Please contact your sales representative for assistance. We apologize for any inconvenience.");
            }
        }

        $orders = Order::whereIn('id', $orderIds)
            ->get()
            ->transform(function ($order) {
                $order->payment_status = app(\App\Services\PaymentService::class)
                    ->getPaymentStatus($order->id);
                $order->total_item_qty = $order->orderItems->sum('qty');
                return $order;
            });

        $totalAmountToPay = $orders->sum(function ($order) {
            return $order->payment_status['balance_to_be_paid'] ?? 0;
        });
        $months = array(1 => '01', 2 => '02', 3 => '03', 4 => '04', 5 => '05', 6 => '06', 7 => '07', 8 => '08', 9 => '09', 10 => '10', 11 => '11', 12 => '12');
        return view('pages.customer_portal.payments.bulk_payment',compact('orders', 'totalAmountToPay','contact','organization','months'));
    }

    public function techpackCheck($orderId)
    {
        $order = Order::with([
            'contactDetails',
            'orderItems' => function ($query) {
                $query->with(['subProduct', 'statusDetails', 'orderItemFiles'])->where('is_studio_item', 0);
            }
        ])->findOrFail($orderId);

        if ($order->is_new_shipping_address == 1) {
            // New shipping address saved in orders table
            $shippingAddress = collect([
                $order->apartment ?? null,
                $order->street ?? null,
                $order->city ?? null,
                $order->state ?? null,
                $order->postal_code ?? null,
                $order->country ?? null,
            ])->filter()->implode(', ');

        } elseif ($order->is_new_shipping_address == 2) {
            // Contact shipping address 1
            $shippingAddress = collect([
                optional($order->contactDetails)->apartment,
                optional($order->contactDetails)->shipping_street,
                optional($order->contactDetails)->shipping_city,
                optional($order->contactDetails)->shipping_state,
                optional($order->contactDetails)->shipping_zip,
                optional($order->contactDetails)->shipping_country,
            ])->filter()->implode(', ');

        } else {
            // Contact shipping address 2
            $shippingAddress = collect([
                optional($order->contactDetails)->apartment2,
                optional($order->contactDetails)->shipping_street_2,
                optional($order->contactDetails)->shipping_city_2,
                optional($order->contactDetails)->shipping_state_2,
                optional($order->contactDetails)->shipping_zip_2,
                optional($order->contactDetails)->shipping_country_2,
            ])->filter()->implode(', ');
        }

        $items = $order->orderItems->map(function ($item) {
            $techPack = optional(
                optional($item->orderItemFiles)->whereNotNull('tech_pack_images')->first()
            )->tech_pack_images;

            return [
                'id' => $item->id,
                'name' => ($item->display_name ?? optional($item->subProduct)->product_name) . ' - ' . $item->item_description,
                'qty' => $item->qty,
                'status' => optional($item->statusDetails)->status_name ?? '-',
                'tech_pack' => $techPack,
            ];
        });

        return response()->json([
            'status' => true,
            'shipping_address' => $shippingAddress ?: 'No shipping address found',
            'items' => $items,
        ]);
    }



    public function shipment_summary_view($order_id){
        $shippingDetails = [];
        $shippingDetails['orderItems'] = ShippingFacade::getShipmentSummery($order_id);
        $shippingDetails['sub_products'] = SubProduct::get();

        return view('pages.customer_portal.shipment_summary_view', compact('shippingDetails','order_id'));


    }
    public function shipment_summary_view_ajax($orderId)
    {
        $records = ShippingOrderDetails::with('orderItems.subProduct')
            ->where('order_id', $orderId)
            ->where('notify_status', 1)
            ->whereNotNull('tracking_no')
            ->get();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No shipment found'], 404);
        }

        // ✅ GROUP BY tracking_no
        $shipments = $records
            ->groupBy('tracking_no')
            ->map(function ($shipmentGroup, $trackingNo) {

                $first = $shipmentGroup->first();

                // ✅ GROUP ITEMS inside each tracking by order_item_id + size
                $items = $shipmentGroup
                    ->groupBy(function ($row) {
                        return $row->order_item_id . '_' . strtolower(trim($row->size_name));
                    })
                    ->map(function ($group) {

                        $firstItem = $group->first();

                        return [
                            'order_item_id' => $firstItem->order_item_id,
                            'name'          => $firstItem->orderItems->subProduct->product_name,
                            'size'          => $firstItem->size_name,
                            'ordered_qty'   => (int) $group->sum('order_qty'),
                            'shipped_qty'   => (int) $group->sum('shipped_qty'),
                        ];
                    })
                    ->values();

                return [
                    'tracking_no'     => $trackingNo,
                    'tracking_link'   => $first->tracking_link,
                    'Courier_Service' => $first->CourierService,

                    'received_at' => $first->customer_received
                        ? \Carbon\Carbon::parse($first->customer_received)
                            ->format('M d, Y, h:i A')
                        : null,

                    'items' => $items
                ];
            })
            ->values();

        return response()->json([
            'order_id'  => $orderId,
            'shipments' => $shipments
        ]);
    }

    public function shipment_summary_exportPdf($order_id){
        $shippingDetails = [];
        $shippingDetails['orderItems'] = ShippingFacade::getShipmentSummery($order_id);
        $shippingDetails['sub_products'] = SubProduct::get();

        // $pdf = PDF::loadView('pages.customer_portal.shipment_summary_pdf', compact('shippingDetails'));
        // $pdf = PDF::loadView('pages.customer_portal.shipment_summary_pdf', compact('shippingDetails'))->setOptions(['defaultFont' => 'sans-serif']);
        $pdf = PDF::loadView('pages.customer_portal.shipment_summary_pdf', compact('shippingDetails'))->setOptions([
            'defaultFont' => 'https://fonts.googleapis.com/css2?family=Roboto'
        ]);
        // Return the PDF as a download
        return $pdf->download('shipment_summary.pdf');


    }

    public function exportOrderRosterTemplate($orderId)
    {
        $order = Order::find($orderId);
        $fileName = 'Roster_Template_'.$order->order_no.'.xlsx';
        return Excel::download(new OrderRosterTemplateExport($orderId), $fileName);
    }

    public function importOrderRoster(Request $request)
    {
        try {
            $orderId = $request->order_id;
            Excel::import(new OrderRosterImport($orderId), $request->file('import_file'));
            return json_encode(array('response'=>'success', 'message' => 'Order Roster Import Successfull!'));
        } catch (\Throwable $th) {
            return json_encode(array('response'=>'error', 'message' => $th->getMessage()));
        }
    }

    public function exportNumberRosterTemplate($orderItemId)
    {
        return Excel::download(new RosterSizesWithNumbersExport($orderItemId), 'Number_Roster_Template.xlsx');
    }

    public function importNumberRoster(Request $request)
    {
        try {
            $orderItemId = $request->order_item_id;
            Excel::import(new RosterSizesWithNumbersImport($orderItemId), $request->file('import_file'));
            return json_encode(array('response'=>'success', 'message' => 'Player Numbers Import Successfull!'));
        } catch (\Throwable $th) {
            return json_encode(array('response'=>'error', 'message' => $th->getMessage()));
        }
    }

    public function exportNameRosterTemplate($orderItemId)
    {
        $productSizes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28, 29];

        $productItemDetails = OrderItemsDetail::where('order_item_id', $orderItemId)
            ->whereNotNull('blanks')
            ->where('blanks', '>', 0)
            ->get();

        $sortedProductItemDetails = $productItemDetails->sortBy(function ($item) use ($productSizes) {
            return array_search($item->size_id, $productSizes);
        });

        return Excel::download(new RosterSizesWithNamesExport($sortedProductItemDetails, $orderItemId), 'Name_Roster_Template.xlsx');
    }

    public function importNameRoster(Request $request)
    {
        try {
            $orderItemId = $request->order_item_id;
            Excel::import(new RosterSizesWithNamesImport($orderItemId), $request->file('import_file'));
            return json_encode(array('response'=>'success', 'message' => 'Player Names Import Successfull!'));
        } catch (\Throwable $th) {
            return json_encode(array('response'=>'error', 'message' => $th->getMessage()));
        }
    }

    public function exportNumberWithNameRosterTemplate($orderItemId)
    {
        $productSizes = [1, 2, 3, 4, 5, 6, 7, 8, 9, 26, 17, 18, 19, 11, 12, 13, 14, 15, 20, 21, 22, 23, 24, 25, 16, 28, 29];

        $productItemDetails = OrderItemsDetail::where('order_item_id', $orderItemId)
            ->whereNotNull('qty')
            ->where('qty', '>', 0)
            ->get();

        $sortedProductItemDetails = $productItemDetails->sortBy(function ($item) use ($productSizes) {
            return array_search($item->size_id, $productSizes);
        });

        return Excel::download(new RosterSizesWithNumberNamesExport($sortedProductItemDetails, $orderItemId), 'Player_Names_For_Number_Roster_Template.xlsx');
    }

    public function importNumberWithNameRoster(Request $request)
    {
        try {
            $orderItemId = $request->order_item_id;
            Excel::import(new RosterSizesWithNumberNamesImport($orderItemId), $request->file('import_file'));
            return json_encode(array('response'=>'success', 'message' => 'Player Names Import Successfull!'));
        } catch (\Throwable $th) {
            return json_encode(array('response'=>'error', 'message' => $th->getMessage()));
        }
    }
    public function approveProduction(Request $request)
    {
        $ipAddress = $request->json('ip_address');
        $order_id = $request->json('order_id');

        $order = Order::with('organizationDetails')->find($order_id);

        if (!$order) {
            return response()->json(['message' => 'Order not found.'], 404);
        }

        if ($order->plorder == 0) {
            return response()->json(['message' => 'You don\'t have access to approve this order for production.'], 403);
        }

        $existingApproval = ProductionApprovalDetail::where('order_id', $order_id)->first();

        if ($existingApproval) {
            return response()->json(['message' => 'You have already approved this order for production.'], 400);
        }

        $ProductionApprovalDetail = new ProductionApprovalDetail();
        $ProductionApprovalDetail->order_id = $order_id;
        $ProductionApprovalDetail->ip_address = $ipAddress;
        $ProductionApprovalDetail->save();

        $orderItems = OrderItem::where('order_id', $order_id)
            ->where('remake_status', 0)
            ->get();

        $itemsListHtml = '';
        foreach ($orderItems as $orderItem) {
            $itemsListHtml .= '<div style="display:flex;align-items:center;gap:10px;padding:12px 16px;font-size:13.5px;color:#1f2937;border-bottom:1px solid #f3f4f6">
                <span style="width:6px;height:6px;border-radius:50%;background:#10b981;flex-shrink:0"></span>
                <span style="font-weight:600;color:#111827">' . e($orderItem->display_name) . '</span>
                <span style="margin-left:auto;background:#f3f4f6;border-radius:12px;padding:3px 10px;font-size:11px;font-weight:600;color:#6b7280">Qty - ' . e($orderItem->qty ?? 0) . '</span>
            </div>';
        }

        $orderLink = url("order_details/edit/{$order_id}/order") . '?active_tab=order';

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_customer_approved', [
            '{order_no}'           => $order->order_no,
            '{order_link}'         => $orderLink,
            '{ex_factory_date}'    => $order->ex_factory_date,
            '{in_hand_due_date}'   => $order->due_date,
            '{organization_name}'  => optional($order->organizationDetails)->organization_name ?? '',
            '{order_description}'  => $order->order_description ?? '',
            '{order_items_list}'   => $itemsListHtml,
        ], [
            'order_id'                   => $order_id,
            'target_notification_field'  => 'key_customer_approved',
            'new_notification'           => 1,
        ]);

        return response()->json(['message' => 'Approved successfully!', 'ip' => $ipAddress]);
    }

    public function sendShipmentEnquiry(Request $request)
    {
        $org_id = $this->portalOrganizationId();

        abort_if(!$org_id, 403, 'Invalid customer portal organization context.');

        $contact = $this->portalContact();

        $request->validate([
            'tracking_no'   => 'required',
            'order_id'      => 'required',
            'order_no'      => 'required',
            'message'       => 'required'
        ]);

        $order = Order::where('id', $request->order_id)
            ->where('organization_id', $org_id)
            ->firstOrFail();

        email_Notify()->sendEmailFromTemplate('customer_inquiry_email', [
            'orderId' => $order->id,
            'order_no' => $order->order_no,
            'courierService' => $request->courier,
            'trackingNo' => $request->tracking_no,
            'trackingLink' => $request->tracking_link,
            'message' => $request->message,
            'customerName' => $this->portalActorName($contact),
            'customerEmail' => $this->portalActorEmail($contact),
        ]);

        return response()->json(['success' => true]);
    }

    public function Shippingdetails($trackingNo)
    {
        $records = ShippingOrderDetails::with('orderItems.subProduct')
                                        ->where('tracking_no', $trackingNo)
                                        ->where('notify_status', 1)
                                        ->whereNotNull('tracking_no')
                                        ->get();

        if ($records->isEmpty()) {
            return response()->json(['message' => 'No shipment found'], 404);
        }

        $first = $records->first();
        // ✅ GROUP BY size_name
        $items = $records
                ->groupBy(function ($row) {
                    return $row->order_item_id . '_' . strtolower(trim($row->size_name));
                })
                ->map(function ($group) {

                    $firstitem = $group->first();

                    return [
                        'order_item_id' => $firstitem->order_item_id,
                        'name'          => $firstitem->orderItems->subProduct->product_name,
                        'size'          => $firstitem->size_name,
                        'ordered_qty'   => (int) $group->sum('order_qty'),
                        'shipped_qty'   => (int) $group->sum('shipped_qty'),
                    ];
                })
                ->values();


        return response()->json([
            'tracking_no'    => $trackingNo,
            'tracking_link'  => $first->tracking_link,
            'Courier_Service' => $first->CourierService,

            'received_at' => $first->customer_received
                ? \Carbon\Carbon::parse($first->customer_received)
                    ->format('M d, Y, h:i A')
                : null,

            'items' => $items
        ]);
    }


public function adminOpenCustomerPortal($organizationId)
{
    if (!Auth::check()) {
        abort(403, 'Unauthorized');
    }

    $organization = Organization::where('id', $organizationId)
        ->firstOrFail();

    /*
    |--------------------------------------------------------------------------
    | Remove old portal context only
    |--------------------------------------------------------------------------
    */
    Session::forget([
        'customer_portal_user',
        'customer_portal_org_image',
        'customer_portal_org_name',
        'customer_portal_admin',
        'portal_notice_acknowledged',
    ]);

    /*
    |--------------------------------------------------------------------------
    | ADMIN/SYSTEM USER PORTAL CONTEXT
    |--------------------------------------------------------------------------
    |
    | Important:
    | We DO NOT create customer_portal_user.
    | We DO NOT choose a Contact.
    | We DO NOT Auth::logout().
    |
    */
    Session::put('customer_portal_admin', [
        'user_id'         => Auth::id(),
        'organization_id' => $organization->id,
        'return_url'      => route('organizations.info', $organization->id),
    ]);

    Session::put(
        'customer_portal_org_image',
        [$organization->organization_logo]
    );

    Session::put(
        'customer_portal_org_name',
        [$organization->organization_name]
    );

    return redirect()->route('customer_portal.dashboard');
}


private function portalIsAdmin()
{
    if (!Auth::check() || !Session::has('customer_portal_admin')) {
        return false;
    }

    $portalAdmin = Session::get('customer_portal_admin');

    return isset($portalAdmin['user_id'], $portalAdmin['organization_id'])
        && (int) $portalAdmin['user_id'] === (int) Auth::id()
        && !empty($portalAdmin['organization_id']);
}


private function portalIsCustomer()
{
    return Session::has('customer_portal_user');
}


private function portalOrganizationId()
{
    /*
    |--------------------------------------------------------------------------
    | SYSTEM / ADMIN USER
    |--------------------------------------------------------------------------
    */
    if ($this->portalIsAdmin()) {
        $adminPortal = Session::get('customer_portal_admin');

        return $adminPortal['organization_id'] ?? null;
    }

    /*
    |--------------------------------------------------------------------------
    | NORMAL CUSTOMER
    |--------------------------------------------------------------------------
    */
    if ($this->portalIsCustomer()) {
        $customerPortal = Session::get('customer_portal_user');

        return $customerPortal[1] ?? null;
    }

    return null;
}


private function portalContactId()
{
    /*
    |--------------------------------------------------------------------------
    | System users are NOT authenticated as Contacts.
    |--------------------------------------------------------------------------
    */
    if ($this->portalIsAdmin()) {
        return null;
    }

    if ($this->portalIsCustomer()) {
        $customerPortal = Session::get('customer_portal_user');

        return $customerPortal[0] ?? null;
    }

    return null;
}


/**
 * Return a Contact object for customer-data display when a portal page needs it.
 *
 * IMPORTANT:
 * - In normal customer mode this is the authenticated customer Contact.
 * - In system/admin mode this is only a fallback organization Contact used by
 *   existing views that expect $contact. It does NOT authenticate the admin as
 *   that customer and it is never written to customer_portal_user.
 */
private function portalContact()
{
    $contactId = $this->portalContactId();

    if ($contactId) {
        return Contact::where('id', $contactId)
            ->where('active', 1)
            ->first();
    }

    if ($this->portalIsAdmin()) {
        $orgId = $this->portalOrganizationId();

        if (!$orgId) {
            return null;
        }

        $contactIds = ContactOrganization::where('organization_id', $orgId)
            ->pluck('contact_id');

        return Contact::whereIn('id', $contactIds)
            ->where('active', 1)
            ->orderBy('id')
            ->first();
    }

    return null;
}


private function portalSystemUser()
{
    return $this->portalIsAdmin()
        ? Auth::user()
        : null;
}


private function portalActorName($contact = null)
{
    if ($this->portalIsAdmin()) {
        return Auth::user()->name ?? 'System User';
    }

    $contact = $contact ?: $this->portalContact();

    if (!$contact) {
        return 'Customer';
    }

    $fullName = trim(
        ($contact->first_name ?? '') . ' ' . ($contact->last_name ?? '')
    );

    return $fullName !== ''
        ? $fullName
        : ($contact->first_name ?? 'Customer');
}


private function portalActorEmail($contact = null)
{
    if ($this->portalIsAdmin()) {
        return Auth::user()->email ?? '';
    }

    $contact = $contact ?: $this->portalContact();

    return $contact->email ?? '';
}

}