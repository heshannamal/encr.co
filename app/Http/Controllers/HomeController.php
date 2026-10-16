<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use App\Models\User;
use App\Models\Order;
use App\Models\Sport;
use App\Models\ActionLog;
use App\Models\Organization;
use App\Models\OrderStatus;
use App\Models\Factory;
use App\Models\CheckPayment;
use App\Models\PaymentLog;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\Activity;
use App\Models\ShippingOrderDetails;
use App\Models\Contact;
use Spatie\Permission\Models\Role;
use Spatie\Permission\Models\Permission;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\App;
use App\Models\SystemConfiguration;
use App\Models\NotificationTemplate;
use App\Models\EmailNotification;
use domainencore\Facades\OrdersCommenFacade\OrdersCommenFacade;
use GuzzleHttp\Client;
use domainencore\Services\GraphAPIService\GraphAPIService;
use App\Models\ColorMaster;
use App\Models\ContactOrganization;
use App\Models\EmailTemplate;
use App\Models\UserEmailTemplate;
use App\Models\LeadSource;
use Illuminate\Support\Facades\Session;
use App\Models\Notification;
use App\Models\OrderItem;
use App\Models\PurchaseorderReceipt;
use App\Services\NotificationBuilderService;
use App\Models\OtherPayment;
use App\Services\PaymentService;
use App\Services\OrderTypeTotalsService;
use App\Models\CustomerEnquiry;
use App\Models\SupportConversation;
use App\Models\OrganizationSampleShipment;
use App\Models\SubProduct;

class HomeController extends Controller
{
    /**
     * Create a new controller instance.
     *
     * @return void
     */


    // public function __construct()
    // {
    //     $this->middleware('auth');

    //     $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();


    // }

    private function getTestOrgId()
    {
        // Fetch organization IDs using case-insensitive 'like'
        $orgs = Organization::where('organization_name', 'like', 'Test')
            ->orWhere('organization_name', 'like', 'TEST')
            ->orWhere('organization_name', 'like', 'test')
            ->pluck('id', 'organization_name'); // Optionally retrieve names too
        return $orgs;
    }

    public function systemAdminDashboard(Request $request)
    {
        Permission::firstOrCreate(['name' => 'view systemadmin dashboard']);

        if (!auth()->user()->can('view systemadmin dashboard')) {
            abort(403, 'Unauthorized action.');
        }

        // $activeUsers = User::select('id', 'name')->orderBy('name')->get();
        $activeUsers = User::where('active', 1)->select('id', 'name')->orderBy('name')->get();

        $currentDatabase = DB::connection()->getDatabaseName();
        if ($currentDatabase === 'encrec_test') {
            $databaseEnvironment = 'testing';
        } elseif ($currentDatabase === 'encrec_ec') {
            $databaseEnvironment = 'live';
        } elseif ($currentDatabase === 'encrec_backup') {
            $databaseEnvironment = 'development';
        } else {
            $databaseEnvironment = 'unavailable';
        }

        $currentMode = SystemConfiguration::getValue('payment_mode', 'sandbox');
        $systemStatus = App::isDownForMaintenance() ? 'on' : 'off';

        $systemNotificationCounts = NotificationTemplate::selectRaw(
            "SUM(CASE WHEN status = 1 THEN 1 ELSE 0 END) as active_count,
            COUNT(*) as total_count"
        )->first();
        $systemNotificationsTotal = $systemNotificationCounts->total_count ?? 0;
        $systemNotificationsUnread = $systemNotificationCounts->active_count ?? 0;

        $emailNotificationCounts = EmailNotification::selectRaw(
            "SUM(CASE WHEN active = 1 THEN 1 ELSE 0 END) as active_count,
            COUNT(*) as total_count"
        )->first();
        $emailNotificationsTotal = $emailNotificationCounts->total_count ?? 0;
        $emailNotificationsUnread = $emailNotificationCounts->active_count ?? 0;

        return view('dashboards.systemAdminDashboard', compact(
            'activeUsers',
            'systemStatus',
            'databaseEnvironment',
            'currentMode',
            'systemNotificationsTotal',
            'systemNotificationsUnread',
            'emailNotificationsTotal',
            'emailNotificationsUnread'
        ));
    }

    public function getEnquiriesData(Request $request)
    {
        $date = $request->input('date');

        // 1. Customer Enquiries (limit 10)
        $enqQuery = CustomerEnquiry::where('user_id', 'like', 'TEMP-%')
            ->where('active', 1)
            ->orderByDesc('created_at');

        if ($date) {
            $enqQuery->whereDate('created_at', $date);
        }

        $enquiries = $enqQuery->take(10)->get();
        $enqRows = $enquiries->map(function ($enq) {
            $userId  = $enq->user_id ?? 'TEMP-?';
            $tempId  = str_replace('TEMP-', '', $userId);
            $name    = is_numeric($tempId) ? 'Guest #' . $tempId : $tempId;
            if (is_numeric($tempId)) {
                $initials = 'G' . $tempId;
            } else {
                $words    = preg_split('/[\s@._\-]+/', $tempId);
                $initials = strtoupper(implode('', array_map(fn($w) => $w[0] ?? '', array_slice($words, 0, 2))));
            }
            $created = $enq->created_at;
            $time    = $created->isToday() ? $created->format('h:iA') : $created->format('M d');
            $parts = [];
            if ($enq->email)       $parts[] = $enq->email;
            if ($enq->phone_no)    $parts[] = $enq->phone_no;
            if ($enq->order_no)    $parts[] = 'Order #' . $enq->order_no;
            if ($enq->order_total) $parts[] = '$' . number_format($enq->order_total, 2);
            if ($enq->city)        $parts[] = $enq->city;
            return [
                'id'        => 'enq_' . $enq->id,
                'initials'  => $initials ?: 'GU',
                'name'      => $name,
                'count'     => 1,
                'time'      => $time,
                'preview'   => count($parts) ? implode(' · ', $parts) : 'Enquiry submitted',
                'type'      => 'new',
                'source'    => 'enquiry',
                'timestamp' => $created->timestamp,
            ];
        });

        // Eager load structure for SupportConversation queries
        $convRelations = [
            'customer',
            'department',
            'assignedAgent.user',
            'messages' => function ($q) {
                $q->latest('id')->take(1);
            }
        ];

        // 2. Technical Support conversations (limit 10)
        $techQuery = SupportConversation::with($convRelations)
            ->whereHas('department', function ($q) {
                $q->where('slug', 'technical-support');
            })
            ->orderByDesc('last_message_at');
        if ($date) {
            $techQuery->whereDate('last_message_at', $date);
        }
        $techConversations = $techQuery->take(10)->get();

        // 3. Sales Support conversations (limit 10)
        $salesQuery = SupportConversation::with($convRelations)
            ->whereHas('department', function ($q) {
                $q->where('slug', 'sales-support');
            })
            ->orderByDesc('last_message_at');
        if ($date) {
            $salesQuery->whereDate('last_message_at', $date);
        }
        $salesConversations = $salesQuery->take(10)->get();

        // 4. Account Support conversations (limit 10)
        $accountQuery = SupportConversation::with($convRelations)
            ->whereHas('department', function ($q) {
                $q->where('slug', 'account-support');
            })
            ->orderByDesc('last_message_at');
        if ($date) {
            $accountQuery->whereDate('last_message_at', $date);
        }
        $accountConversations = $accountQuery->take(10)->get();

        // 5. Other Support conversations (limit 10)
        $otherQuery = SupportConversation::with($convRelations)
            ->where(function ($query) {
                $query->whereDoesntHave('department')
                    ->orWhereHas('department', function ($q) {
                        $q->whereNotIn('slug', ['technical-support', 'sales-support', 'account-support']);
                    });
            })
            ->orderByDesc('last_message_at');
        if ($date) {
            $otherQuery->whereDate('last_message_at', $date);
        }
        $otherConversations = $otherQuery->take(10)->get();

        // Helper to format conversations
        $formatConv = function ($conversations) {
            $rows = collect();
            foreach ($conversations as $conv) {
                $customerName = $conv->customer->name ?? $conv->customer->first_name ?? 'Customer';
                $nameWords = explode(' ', $customerName);
                $initials = '';
                for ($i = 0; $i < count($nameWords) && $i < 2; $i++) {
                    if (!empty($nameWords[$i])) {
                        $initials .= strtoupper($nameWords[$i][0]);
                    }
                }
                if (!$initials) $initials = 'CU';
                $lastMsg = $conv->messages->sortByDesc('id')->first();
                $preview = $lastMsg ? ($lastMsg->message ?: ($lastMsg->attachment_name ? 'Attachment: ' . $lastMsg->attachment_name : 'No messages')) : 'No messages';
                $time = $conv->last_message_at ? ($conv->last_message_at->isToday() ? $conv->last_message_at->format('h:iA') : $conv->last_message_at->format('M d')) : '';
                $departmentSlug = $conv->department->slug ?? '';
                $typeMap = ['technical-support' => 'technical', 'sales-support' => 'sales', 'account-support' => 'account'];
                $type = $typeMap[$departmentSlug] ?? 'new';
                $agentName = optional(optional($conv->assignedAgent)->user)->name;
                $rows->push([
                    'id'          => 'conv_' . $conv->id,
                    'initials'    => $initials,
                    'name'        => $customerName,
                    'count'       => 1,
                    'time'        => $time,
                    'preview'     => $preview,
                    'type'        => $type,
                    'source'      => 'conversation',
                    'conv_status' => ucfirst($conv->status),
                    'agent'       => $agentName,
                    'department'  => $conv->department->name ?? 'Support',
                    'conv_id'     => $conv->id,
                    'timestamp'   => $conv->last_message_at ? $conv->last_message_at->timestamp : 0,
                ]);
            }
            return $rows;
        };

        $techRows = $formatConv($techConversations);
        $salesRows = $formatConv($salesConversations);
        $accountRows = $formatConv($accountConversations);
        $otherRows = $formatConv($otherConversations);

        // Merge all categories together
        $allRows = $enqRows
            ->concat($otherRows)
            ->concat($techRows)
            ->concat($salesRows)
            ->concat($accountRows)
            ->sortByDesc('timestamp')
            ->values();

        // Count unread queries
        $techUnreadQuery = SupportConversation::whereHas('department', function ($q) {
            $q->where('slug', 'technical-support');
        })
            ->whereHas('messages', function ($q) {
                $q->where('sender_type', 'customer')->where('is_read', false);
            });

        $salesUnreadQuery = SupportConversation::whereHas('department', function ($q) {
            $q->where('slug', 'sales-support');
        })
            ->whereHas('messages', function ($q) {
                $q->where('sender_type', 'customer')->where('is_read', false);
            });

        $accountUnreadQuery = SupportConversation::whereHas('department', function ($q) {
            $q->where('slug', 'account-support');
        })
            ->whereHas('messages', function ($q) {
                $q->where('sender_type', 'customer')->where('is_read', false);
            });

        $otherUnreadQuery = SupportConversation::where(function ($query) {
            $query->whereDoesntHave('department')
                ->orWhereHas('department', function ($q) {
                    $q->whereNotIn('slug', ['technical-support', 'sales-support', 'account-support']);
                });
        })
            ->whereHas('messages', function ($q) {
                $q->where('sender_type', 'customer')->where('is_read', false);
            });

        $enqUnreadQuery = CustomerEnquiry::where('user_id', 'like', 'TEMP-%')
            ->where('active', 1);

        if ($date) {
            $techUnreadQuery->whereDate('last_message_at', $date);
            $salesUnreadQuery->whereDate('last_message_at', $date);
            $accountUnreadQuery->whereDate('last_message_at', $date);
            $otherUnreadQuery->whereDate('last_message_at', $date);
            $enqUnreadQuery->whereDate('created_at', $date);
        }

        $techUnreadCount = $techUnreadQuery->count();
        $salesUnreadCount = $salesUnreadQuery->count();
        $accountUnreadCount = $accountUnreadQuery->count();
        $otherUnreadCount = $otherUnreadQuery->count();
        $enqUnreadCount = $enqUnreadQuery->count();

        $counts = [
            'new'       => $enqUnreadCount + $otherUnreadCount + $techUnreadCount + $salesUnreadCount + $accountUnreadCount,
            'technical' => $techUnreadCount,
            'sales'     => $salesUnreadCount,
            'account'   => $accountUnreadCount,
        ];

        return response()->json([
            'status'    => 200,
            'counts'    => $counts,
            'enquiries' => $allRows,
        ]);
    }

    public function getOrdersInProductionData(Request $request)
    {
        // Get orders with order_status_id 3 (production)
        $query = Order::with(['orderItems.factoryDetails', 'userDetails'])
            ->where('active', 1)
            ->where('order_status_id', 3)
            ->orderBy('id', 'desc');

        // If limit is provided, use it; default to 10
        $limit = $request->input('limit', 10);
        $orders = $query->take($limit)->get();

        $rows = $orders->map(function ($order) {
            // Get unique factory codes from order items
            $factories = $order->orderItems
                ->filter(fn($item) => $item->factoryDetails)
                ->map(fn($item) => $item->factoryDetails->factory_code)
                ->unique()
                ->implode(', ');

            return [
                'id' => $order->id,
                'order_id' => $order->order_no,
                'factories' => $factories ?: 'N/A',
                'ex_factory_date' => $order->ex_factory_date ?: 'N/A',
                'sales_rep' => $order->userDetails ? $order->userDetails->name : 'N/A',
            ];
        });

        return response()->json([
            'status' => 200,
            'orders' => $rows,
        ]);
    }

    public function getDashboardEmails(Request $request)
    {
        $accessToken = session('azure_access_token') ?? null;
        $refreshToken = session('azure_refresh_token') ?? null;

        if (!$accessToken && !$refreshToken) {
            return response()->json([
                'status' => 401,
                'emails' => [],
                'message' => 'Not authenticated with Azure AD.'
            ]);
        }

        try {
            $inboxMessages = $this->graphService->getInboxMessages($accessToken, 1);

            if ($inboxMessages instanceof \Exception) {
                // Token may have expired, try refreshing
                if ($refreshToken) {
                    try {
                        $newAccessToken = $this->getAccessToken($refreshToken);
                        $inboxMessages = $this->graphService->getInboxMessages($newAccessToken, 1);
                    } catch (\Exception $e2) {
                        return response()->json([
                            'status' => 401,
                            'emails' => [],
                            'message' => 'Session expired. Please re-login.'
                        ]);
                    }
                } else {
                    return response()->json([
                        'status' => 401,
                        'emails' => [],
                        'message' => 'Session expired. Please re-login.'
                    ]);
                }
            }

            // Take only the first 5 emails for the dashboard
            $emails = array_slice($inboxMessages, 0, 5);

            $AVATAR_COLORS = ['#818cf8', '#10b981', '#f97316', '#0ea5e9', '#a78bfa', '#ef4444', '#eab308', '#4338ca'];

            $formatted = [];
            foreach ($emails as $msg) {
                $name = $msg['From'] ?: 'Unknown';
                $words = explode(' ', $name);
                $initials = '';
                for ($i = 0; $i < count($words) && $i < 2; $i++) {
                    if (!empty($words[$i])) {
                        $initials .= strtoupper($words[$i][0]);
                    }
                }
                if (!$initials) $initials = '?';

                $colorIndex = count($formatted) % count($AVATAR_COLORS);
                $color = $AVATAR_COLORS[$colorIndex];

                $subject = $msg['Subject'] ?: '(No subject)';

                // Format time
                $dateStr = $msg['Date'] ?? '';
                $time = '';
                if ($dateStr) {
                    try {
                        $dt = new \DateTime($dateStr);
                        $now = new \DateTime();
                        $diff = $now->diff($dt);
                        if ($diff->days === 0) {
                            $time = $dt->format('h:iA');
                        } elseif ($diff->days === 1) {
                            $time = 'Yesterday';
                        } else {
                            $time = $dt->format('M d');
                        }
                    } catch (\Exception $e) {
                        $time = $dateStr;
                    }
                }

                $formatted[] = [
                    'id' => $msg['Message_ID'] ?? $msg['Msgno'] ?? '',
                    'initials' => $initials,
                    'color' => $color,
                    'name' => $name,
                    'subject' => $subject,
                    'time' => $time,
                    'isNew' => !($msg['Status'] ?? true),
                ];
            }

            return response()->json([
                'status' => 200,
                'emails' => $formatted,
            ]);
        } catch (\Exception $e) {
            return response()->json([
                'status' => 500,
                'emails' => [],
                'message' => 'Failed to fetch emails: ' . $e->getMessage()
            ]);
        }
    }

    public function getDashboardMeetings(Request $request)
    {
        $schedules = \App\Models\EMSchedule::where('user_id', auth()->id())
            ->where('active', 1)
            ->where('status', 1)
            ->get();

        $events = [];
        $now = \Carbon\Carbon::now();

        foreach ($schedules as $schedule) {
            // Check if it's a recurring schedule
            $isRecurring = (bool) $schedule->is_recurring
                || strtolower((string) ($schedule->schedule_mode ?? '')) === 'recurring'
                || strtolower((string) ($schedule->scheduling_type ?? '')) === 'recurring'
                || !empty($schedule->open_available_time);

            if ($isRecurring) {
                // Get next occurrence for recurring schedules
                $availability = \App\Models\EMScheduleAvailability::where('schedule_id', $schedule->id)
                    ->where('is_available', 1)
                    ->whereNotNull('from_time')
                    ->whereNotNull('to_time')
                    ->get()
                    ->keyBy('day');

                if ($availability->isEmpty() && class_exists(\App\Models\EMUserAvailability::class)) {
                    $availability = \App\Models\EMUserAvailability::where('user_id', $schedule->user_id)
                        ->where('is_available', 1)
                        ->whereNotNull('from_time')
                        ->whereNotNull('to_time')
                        ->get()
                        ->keyBy('day');
                }

                if (!$availability->isEmpty()) {
                    $nextOccurrence = null;
                    for ($day = $now->copy()->startOfDay(); $day->lte($now->copy()->addDays(365)); $day->addDay()) {
                        $row = $availability->get($day->dayOfWeekIso);
                        if (!$row) continue;

                        $start = \Carbon\Carbon::parse($day->toDateString() . ' ' . $row->from_time, $schedule->timezone);
                        $end = \Carbon\Carbon::parse($day->toDateString() . ' ' . $row->to_time, $schedule->timezone);

                        if ($start->gte($now)) {
                            $nextOccurrence = ['start' => $start, 'end' => $end];
                            break;
                        }
                    }

                    if ($nextOccurrence) {
                        $locationData = $this->resolveDashboardScheduleLocation($schedule);
                        $events[] = [
                            'title' => $schedule->schedule_name,
                            'start' => $nextOccurrence['start']->toIso8601String(),
                            'end'   => $nextOccurrence['end']->toIso8601String(),
                            'extendedProps' => [
                                'schedule_id'    => $schedule->id,
                                'schedule_name'  => $schedule->schedule_name,
                                'description'    => $schedule->description ?? '',
                                'schedule_type'  => $schedule->type,
                                'slug' => $schedule->slug ?? '',
                                'location_value' => $locationData['location_value'],
                                'zoom_join_url'  => $locationData['zoom_join_url'],
                                'platform'       => $locationData['platform'],
                                'is_recurring'   => true,
                            ],
                        ];
                    }
                }
            } else {
                // Standard (one-time) schedules
                if ($schedule->start_at && $schedule->end_at) {
                    $start = \Carbon\Carbon::parse($schedule->start_at);
                    $end   = \Carbon\Carbon::parse($schedule->end_at);

                    if ($start->gte($now)) {
                        $locationData = $this->resolveDashboardScheduleLocation($schedule);
                        $events[] = [
                            'title' => $schedule->schedule_name,
                            'start' => $start->toIso8601String(),
                            'end'   => $end->toIso8601String(),
                            'extendedProps' => [
                                'schedule_id'    => $schedule->id,
                                'schedule_name'  => $schedule->schedule_name,
                                'description'    => $schedule->description ?? '',
                                'schedule_type'  => $schedule->type,
                                'slug' => $schedule->slug ?? '',
                                'location_value' => $locationData['location_value'],
                                'zoom_join_url'  => $locationData['zoom_join_url'],
                                'platform'       => $locationData['platform'],
                                'is_recurring'   => false,
                            ],
                        ];
                    }
                }
            }
        }

        // Include all confirmed bookings
        $bookings = \App\Models\EMBooking::with('schedule')
            ->where('status', 'confirmed')
            ->where('start_time', '>=', $now)
            ->orderBy('start_time')
            ->take(20)
            ->get();

        foreach ($bookings as $booking) {
            $schedule = $booking->schedule;
            $loc = $booking->location_value ?? '';
            if ($booking->zoom_join_url) {
                $loc = 'Zoom Meeting: ' . $booking->zoom_join_url;
            }

            $events[] = [
                'title' => optional($schedule)->schedule_name ?? 'Meeting',
                'start' => \Carbon\Carbon::parse($booking->start_time)->toIso8601String(),
                'end'   => \Carbon\Carbon::parse($booking->end_time)->toIso8601String(),
                'extendedProps' => [
                    'schedule_id'    => optional($schedule)->id,
                    'schedule_name'  => optional($schedule)->schedule_name ?? 'Meeting',
                    'description'    => optional($schedule)->description ?? '',
                    'schedule_type'  => optional($schedule)->type ?? 'meeting',
                    'location_value' => $loc,
                    'zoom_join_url'  => $booking->zoom_join_url ?? '',
                    'platform'       => optional($schedule)->platform ?? $booking->location_type ?? '',
                    'slug' => $schedule->slug ?? '',
                    'is_recurring'   => optional($schedule)->is_recurring ?? false,
                ],
            ];
        }

        // Sort by start time and limit to 20 events
        usort($events, fn($a, $b) => strcmp($a['start'], $b['start']));
        $events = array_slice($events, 0, 20);

        return response()->json($events);
    }

    protected function resolveDashboardScheduleLocation(\App\Models\EMSchedule $schedule): array
    {
        $zoomUrl = trim((string) ($schedule->zoom_join_url ?? ''));

        if ($zoomUrl === '' && class_exists(\App\Models\EMScheduleZoomMeeting::class)) {
            $zoomRow = \App\Models\EMScheduleZoomMeeting::where('schedule_id', $schedule->id)
                ->whereNotNull('zoom_join_url')
                ->orderByDesc('id')
                ->first();

            if ($zoomRow) {
                $zoomUrl = trim((string) $zoomRow->zoom_join_url);
            }
        }

        if ($zoomUrl !== '') {
            return [
                'location_value' => 'Zoom Meeting: ' . $zoomUrl,
                'zoom_join_url'  => $zoomUrl,
                'platform'       => $schedule->platform ?? 'zoom',
            ];
        }

        return [
            'location_value' => $schedule->location ?? $schedule->phone ?? '',
            'zoom_join_url'  => '',
            'platform'       => $schedule->platform ?? '',
        ];
    }

    protected $inventoryOrgIds;
    protected $PaymentService;
    protected $graphService;

    public function __construct(PaymentService $PaymentService, GraphAPIService $graphService)
    {
        $this->PaymentService = $PaymentService;
        $this->graphService = $graphService;

        $this->middleware('auth');
        $this->inventoryOrgIds = OrdersCommenFacade::getEncoreOrgIds()->toArray();
    }


    public function getAccessToken($refreshToken)
    {

        $clientId = env('AZURE_CLIENT_ID');
        $clientSecret = env('AZURE_CLIENT_SECRET');
        $tenantId = env('AZURE_TENANT_ID');
        $redirectUri = env('AZURE_REDIRECT_URI');
        $tokenEndpoint = 'https://login.microsoftonline.com' . $tenantId . '/oauth2/token';
        $client = new Client();
        $response = $client->post($tokenEndpoint, [
            'form_params' => [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'refresh_token' => $refreshToken,
                'grant_type' => 'refresh_token',
                'redirect_uri' => $redirectUri,
                'scope' => 'https://graph.microsoft.com/.default'
            ]
        ]);
        $data = json_decode($response->getBody(), true);
        session(['azure_access_token' => $data['access_token']]);
        session(['azure_refresh_token' => $data['refresh_token']]);
        return $data['access_token'];
    }

    /**
     * Show the application dashboard.
     *
     * @return \Illuminate\View\View
     */

    public function index(Request $request)
    {
        $user = Auth::user();

        if ($user->hasRole('Dashboard - System Admin')) {
            return redirect()->route('systemadmin.dashboard');
        }

        if ($user->hasRole('Super Admin Dashboard')) {
            return $this->SuperAdminDashboard($request);
        }

        if ($user->hasRole('Dashboard - Accountant')) {
            return redirect()->route('allTransactions');
        }

        if ($user->hasRole('Factory Dashboard')) {
            return $this->factoryDashboard($request);
        }

        if ($user->hasRole('Rep Dashboard')) {
            return $this->salesRepDashboard($request);
        }

        if ($user->hasRole('Dashboard - Developer')) {
            return redirect()->route('user.dashbord');
        }


        return $this->DefaultDashboard($request);


        // abort(403, 'No dashboard role assigned.');
    }


    private function DefaultDashboard(Request $request){

        $authUsers = User::where('user_role_id', 2)->get();
        $users = Auth::user();

        $userArray = array();
        foreach ($authUsers as $authUser) {
            $userArray[] = $authUser->id;
        }

        $orders = Order::with('organizationDetails')
            ->where('active', 1)
            ->whereIn('user_id', [Auth::user()->id, $userArray])
            ->orderBy('order_no', 'desc')
            ->take(12)
            ->get();

        $organizations = Organization::get(['sport', 'id']);

        $sports = Sport::where('active', 1)->get();

        return view('defaultdashboard', ['orders' => $orders, 'users' => $users, 'organizations' => $organizations, 'sports' => $sports]);


    }

    private function SuperAdminDashboard(Request $request)
    {
        $typeTotals = app(OrderTypeTotalsService::class);
        $receivableBreakdown = $typeTotals->receivables($this->dashboardPaymentRows());
        $currentMonth = Carbon::now()->startOfMonth();
            $lastMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfLastMonth = $currentMonth->copy()->subDay();
            $previousYearSameMonthStart = Carbon::now()->subYear()->startOfMonth();
            $previousYearSameMonthEnd = Carbon::now()->subYear()->endOfMonth();

            $testOrganizationIdSet = $this->getTestOrgId();

            $salesBreakdown = $typeTotals->summarize(Order::where('active', 1)->where('write_off_order', 0)
                ->whereNotNull('production_date')
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7]) // match with previous logic
                ->whereIn('order_status_id', [3, 4, 8])
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth()));
            $currentMonthTotal = $salesBreakdown['total'];

            $lastMonthTotal = Order::where('active', 1)->where('write_off_order', 0)
                ->where('order_status_id', '!=', 7)
                ->where('order_status_id', '!=', 1)
                ->where('organization_id', '!=', 2890)
                ->whereBetween(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), [$lastMonth, $endOfLastMonth])
                ->sum('order_total');

            $lastYearLastMonthTotal = $typeTotals->summarize(Order::where('active', 1)->where('write_off_order', 0)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7])
                ->whereIn('order_status_id', [3, 4, 8])
                ->where('organization_id', '!=', 1377)
                ->whereBetween(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), [$previousYearSameMonthStart, $previousYearSameMonthEnd]))['total'];

            $currentMonthOrderCount = $salesBreakdown['count'];

            $percentageChange = 0;

            if ($lastYearLastMonthTotal != 0) {
                $percentageChange = (($currentMonthTotal - $lastYearLastMonthTotal) / $lastYearLastMonthTotal) * 100;
            }

            $percentageChange = round($percentageChange, 2);

            if ($percentageChange > 0) {
                $changeType = 'in';
            } elseif ($percentageChange < 0) {
                $changeType = 'de';
            } else {
                $changeType = 'no';
            }

            $newPercentageChange = abs($percentageChange);

            $quoteBreakdown = $typeTotals->summarize(Order::where('active', 1)
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('order_status_id', 1)
                ->where('organization_id', '!=', 1377)
                ->where('created_at', '>=', $currentMonth)
                ->where('created_at', '<', $currentMonth->copy()->addMonth()), ['bulk', 'wl']);
            $currentMonthQuote = $quoteBreakdown['total'];


            $lastMonthQuote = Order::whereBetween('created_at', [$lastMonth, $currentMonth])
                ->where('active', 1)
                ->where('organization_id', '!=', 2890)
                ->where('order_status_id', 1)
                ->sum('order_total');

            $lastYearLastMonthQuote = $typeTotals->summarize(Order::where('active', 1)
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('order_status_id', 1)
                ->where('organization_id', '!=', 1377)
                ->whereBetween('created_at', [$previousYearSameMonthStart, $previousYearSameMonthEnd]), ['bulk', 'wl'])['total'];

            $currentMonthQuoteCount = $quoteBreakdown['count'];

            $percentageQuote = 0;

            if ($lastYearLastMonthQuote != 0) {
                $percentageQuote = (($currentMonthQuote - $lastYearLastMonthQuote) / $lastYearLastMonthQuote) * 100;
            }

            $percentageQuote = round($percentageQuote, 2);

            if ($percentageQuote > 0) {
                $changeQuoteType = 'in';
            } elseif ($percentageQuote < 0) {
                $changeQuoteType = 'de';
            } else {
                $changeQuoteType = 'no';
            }

            $newpercentageQuote = abs($percentageQuote);

            $productionBreakdown = $typeTotals->summarize(Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7]) // match with previous logic
                ->whereIn('order_status_id', [3])
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth()));
            $currentMonthProduction = $productionBreakdown['total'];

            $currentMonthProductionCount = $productionBreakdown['count'];

            $lastMonthProduction = Order::whereBetween('created_at', [$lastMonth, $currentMonth])
                ->where('active', 1)
                ->where('organization_id', '!=', 2890)
                ->where('order_status_id', 3)
                ->sum('order_total');

            $percentageProduction = 0;

            if ($lastMonthProduction != 0) {
                $percentageProduction = (($currentMonthProduction - $lastMonthProduction) / $lastMonthProduction) * 100;
            }

            $percentageProduction = round($percentageProduction, 2);

            if ($percentageProduction > 0) {
                $changeProductionType = 'in';
            } elseif ($percentageProduction < 0) {
                $changeProductionType = 'de';
            } else {
                $changeProductionType = 'no';
            }

            $newpercentageProduction = abs($percentageProduction);

            $currentMonthShipping = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereNotNull('ex_factory_date')
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('order_status_id', 4)
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
                ->sum('order_total');

            $currentMonthShippingCount = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereNotNull('ex_factory_date')
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('order_status_id', 4)
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
                ->count();

            $lastMonthShipping = Order::where('active', 1)
                ->whereBetween(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), [$lastMonth, $endOfLastMonth])
                ->where('order_status_id', 4)
                ->sum('order_total');

            $lastYearLastMonthShipping = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7])
                ->where('order_status_id', 4)
                ->where('organization_id', '!=', 1377)
                ->whereBetween(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), [$previousYearSameMonthStart, $previousYearSameMonthEnd])
                ->sum('order_total');

            $percentageShipping = 0;

            if ($lastYearLastMonthShipping != 0) {
                $percentageShipping = (($currentMonthShipping - $lastYearLastMonthShipping) / $lastYearLastMonthShipping) * 100;
            }

            $percentageShipping = round($percentageShipping, 2);

            if ($percentageShipping > 0) {
                $changeShippingType = 'in';
            } elseif ($percentageShipping < 0) {
                $changeShippingType = 'de';
            } else {
                $changeShippingType = 'no';
            }

            $newpercentageShipping = abs($percentageShipping);

                    $users = User::select('id', 'name')->where('active', 1)->orderBy('name')->get();
        $dashboardLeadSources = LeadSource::where('active', 1)->orderBy('lead_source_name')->get(['id', 'lead_source_name']);
        return view('dashboard', compact(
            'users', 'dashboardLeadSources', 'salesBreakdown', 'quoteBreakdown', 'productionBreakdown', 'receivableBreakdown',
            'currentMonthOrderCount', 'currentMonthTotal', 'changeType', 'newPercentageChange', 'lastYearLastMonthTotal',
            'currentMonthQuoteCount', 'currentMonthQuote', 'changeQuoteType', 'newpercentageQuote', 'lastYearLastMonthQuote',
            'currentMonthProductionCount', 'currentMonthProduction',
            'currentMonthShippingCount', 'currentMonthShipping', 'changeShippingType', 'newpercentageShipping', 'lastYearLastMonthShipping'
        ));
    }
    private function factoryDashboard(Request $request)
    {
            $this->userGroupFactories();
            $oderSearch = $this->oderSearch;
            $factoryIds = $this->factoryIds;

            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');
            $orderQuery_for_upcoming = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');
            $factoriesQuery = Factory::select('id', 'factory_code');

            // Orgnnization name serach
            if ($request->org) {
                $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                    $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                    $query->whereNotIn('id', $this->inventoryOrgIds);
                });
                $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
            }
            // factory filter
            if ($request->fct) {
                $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                    $query->where('id', $request->fct);
                });
            }
            // status filter
            if ($request->sts) {
                $orderQuery->where('order_status_id', $request->sts);
            }

            if ($oderSearch == 'factory') {
                $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                    $qry->with('factoryDetails')
                        ->whereIn('factory_id', $factoryIds)
                        ->whereIn('order_status_id', [3, 4, 8]);
                }]);
                $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                    $qr->whereIn('factory_id', $factoryIds)
                        ->whereIn('order_status_id', [3, 4, 8]);
                });
                $factoriesQuery->whereIn('id', $factoryIds);
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }
            $orderQuery_for_upcoming->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds);
            }]);

            $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();
            $orders_for_upcoming = $orderQuery_for_upcoming->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

            $orderUrgent = $orders->where('is_urgent', 1)->where('order_status_id', '!=', 4)->count();
            $orderNew = $orders->where('order_status_id', 1)->count();
            $orderProduction = $orders->where('order_status_id', 3)->count();
            $orderFulfiled = $orders->where('order_status_id', 4)->count();
            $orderUpcoming = $orders_for_upcoming->where('upcoming_status', 1)->whereNotIn('order_status_id', [3, 4, 5, 6, 7])->count();

            $orderStatus = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();
            $factories = Factory::where('active', 1)->orderBy('id')->get();

            $ordersPegi = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

            $urgentOrders = $orderQuery
                ->whereNotIn('organization_id', $this->inventoryOrgIds)
                ->where('active', 1)
                ->where('is_urgent', 1)
                ->where('order_status_id', '!=', 4)
                ->orderBy('id', 'DESC')
                ->get();


            $productionOrders = $orders->filter(function ($order) {
                return $order->order_status_id == 3;
            });

            $sippingDetails = ShippingOrderDetails::orderBy('order_id', 'DESC')->where('tracking_no', '!=', null)->get();

            $groupedDetails = $sippingDetails->groupBy('order_id');

            $matches = 0;

            foreach ($productionOrders as $order) {
                if ($groupedDetails->has($order->id)) {
                    $matches++;
                }
            }

            // dd($matches);
            return view('dashboards.factory_dashboard', [
                'orderUrgent' => $orderUrgent,
                'orderNew' => $orderNew,
                'orderProduction' => $orderProduction,
                'orderFulfiled' => $orderFulfiled,
                'orderStatus' => $orderStatus,
                'factories' => $factories,
                'ordersPegi' => $ordersPegi,
                'urgentOrders' => $urgentOrders,
                'matches' => $matches,
                'orderUpcoming' => $orderUpcoming
            ]);
    }

    private function salesRepDashboard(Request $request)
    {
        $userId = Auth::id();
            $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
            $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

            $orders = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->get();

            $orderQuoteCount = $orders->where('order_status_id', 1)->count();
            $orderProductionCount = $orders->where('order_status_id', 3)->count();
            $orderFulfilledCount = $orders->where('order_status_id', 4)->count();

            $orderShipmentCount = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->whereRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') BETWEEN ? AND ?", [$startOfWeek, $endOfWeek])
                ->count();

            $orderQuoteCountOwn = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->where('order_status_id', 1)
                ->count();

            $orderProductionCountOwn = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->where('order_status_id', 3)
                ->count();

            $orderShipmentCountOwn = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->whereRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') BETWEEN ? AND ?", [$startOfWeek, $endOfWeek])
                ->count();


            $orderFulfilledCountOwn = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->where('order_status_id', 4)
                ->count();

            $all_persons = Contact::where('active', 1)->get();
            $all_organizations = Organization::where('active', 1)->get();
            $today = Carbon::today()->toDateString();

            $activities = Activity::where('assigned_to', Auth::user()->id)
                ->where('is_done', 0)
                ->with('organizationDetails')
                ->whereDate('start_date', $today)
                ->get();

            $roleId = Role::where('name', 'Activity Users')->value('id');
            $users = User::select('id', 'name')
                ->where('active', 1)
                ->whereJsonContains('role_id', (string) $roleId)
                ->orderBy('name')
                ->get();

            $this->userGroupFactories();
            $oderSearch = $this->oderSearch;
            $factoryIds = $this->factoryIds;

            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

            $factoriesQuery = Factory::select('id', 'factory_code');

            // Orgnnization name serach
            if ($request->org) {
                $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                    $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                    $query->whereNotIn('id', $this->inventoryOrgIds);
                });
                $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
            }
            // factory filter
            if ($request->fct) {
                $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                    $query->where('id', $request->fct);
                });
            }
            // status filter
            if ($request->sts) {
                $orderQuery->where('order_status_id', $request->sts);
            }

            if ($oderSearch == 'factory') {
                $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                    $qry->with('factoryDetails')
                        ->whereIn('factory_id', $factoryIds)
                        ->whereIn('order_status_id', [3, 4, 8]);
                }]);
                $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                    $qr->whereIn('factory_id', $factoryIds)
                        ->whereIn('order_status_id', [3, 4, 8]);
                });
                $factoriesQuery->whereIn('id', $factoryIds);
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }

            $urgentOrders = $orderQuery
                ->whereNotIn('organization_id', $this->inventoryOrgIds)
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->where('order_status_id', 1)
                ->orderBy('id', 'DESC')
                ->get();

            $email = $this->emailRepDashboard() ?? NULL;
            // dd($email);

            // Payment details
            $onlinePayments = PaymentLog::where('response_code', '1')->orderBy('created_at', 'DESC')->get();

            $checkPayments = CheckPayment::orderBy('created_at', 'DESC')->get();

            $venmoPayments = VenmoPayment::orderBy('created_at', 'DESC')->get();

            $paypalPayments = PaypalPayment::orderBy('created_at', 'DESC')->get();

            $PoReceipts = PurchaseorderReceipt::orderBy('created_at', 'DESC')->get();


            $TrasnsactionsArray = [];

            foreach ($PoReceipts as $PoReceipt) {
                $orderPaymentsArray = [];

                $orderDetails = Order::where('id', $PoReceipt->order_id)->with('organizationDetails')->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $payment = $PoReceipt->amount;
                $orderDetails = Order::where('id', $PoReceipt->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }
                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $balnceToBePaid = 0;
                if ($PoReceipt->is_approved == 0) {
                    $paymentStatus = "Pending Approval";
                } else if ($PoReceipt->is_approved == 1) {
                    $paymentStatus = "Approved";
                } else {
                    $paymentStatus = "Rejected";
                }
                $PoPaymentId = 'PO' . str_pad(($PoReceipt->id), 6, "0", STR_PAD_LEFT);
                $orderPaymentsArray[] = array('Method' => 'PO', 'NameonCard' => 'N/A', 'TransactionId' => $PoPaymentId, 'Amount' => $payment, 'PaymentDate' => $PoReceipt->created_at);
                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                // $TrasnsactionsArray[] = array('Order'=> $PoReceipt->order_id, 'PaymentType'=>'PO', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $paymentStatus, 'Amount'=> $payment, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> 'N/A', 'PaymentDate'=> $PoReceipt->created_at,'checkFImage'=>$PoReceipt->receipt, 'OrderPayments'=>json_encode($orderPaymentsArray));
                $TrasnsactionsArray[] = array('Order' => $PoReceipt->order_id, 'OrderNo' => $order_no, 'paymentStatus2' => $paymentStatus, 'balnceToBePaid' => $balnceToBePaid,  'processingFee' => 0, 'TotalQty' => $totalQty, 'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork, 'PaymentType' => 'PO', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $paymentStatus, 'Amount' => $payment, 'OrderStatus' => $paymentStatus, 'TransactionID' => $PoPaymentId, 'PaymentDate' => $PoReceipt->created_at, 'checkFImage' => $PoReceipt->receipt, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($onlinePayments as $onlinePayment) {
                $orderPaymentsArray = [];

                $orderDetails = Order::where('id', $onlinePayment->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }
                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $onlinePayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $onlinePayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }
                $processingFee = round(($cardPaymenttot) * 3 / 103, 2);
                $cardPaymentRecords = PaymentLog::where('order_id', $onlinePayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $onlinePayment->order_id)->where('is_approved', '1')->get();

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => 'N/A', 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $onlinePayment->order_id, 'OrderNo' => $order_no, 'paymentStatus2' => $paymentStatus2, 'balnceToBePaid' => $balnceToBePaid,  'processingFee' => $processingFee, 'TotalQty' => $totalQty, 'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork, 'PaymentType' => 'Online', 'TeamName' => $organization_name, 'NameonCard' => $onlinePayment->name_on_card, 'checkStatus' => 'Approved', 'Amount' => $onlinePayment->amount, 'OrderStatus' => $paymentStatus, 'TransactionID' => $onlinePayment->transaction_id, 'PaymentDate' => $onlinePayment->created_at, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($checkPayments as $checkPayment) {
                $orderPaymentsArray = [];
                //return $checkPayment->order_id;
                $orderDetails = Order::where('id', $checkPayment->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }

                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $checkPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $checkPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }

                if ($checkPayment->is_approved == "1") {
                    $checkStatus = "Approved";
                } elseif ($checkPayment->is_approved == "3") {
                    $checkStatus = "Rejected";
                } else {
                    $checkStatus = "Not Approved";
                }
                $processingFee = number_format(0, 2);
                $cardPaymentRecords = PaymentLog::where('order_id', $checkPayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $checkPayment->order_id)->where('is_approved', '1')->get();

                $checkPaymentId = 'CHQ' . str_pad(($checkPayment->id), 6, "0", STR_PAD_LEFT);

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => $checkPaymentId, 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $checkPayment->order_id, 'processingFee' => $processingFee, 'paymentStatus2' => $paymentStatus2,  'balnceToBePaid' => $balnceToBePaid,  'OrderNo' => $order_no, 'TotalQty' => $totalQty,  'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork,  'PaymentType' => 'Check', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $checkStatus, 'Amount' => $checkPayment->amount, 'OrderStatus' => $paymentStatus, 'TransactionID' => $checkPaymentId, 'PaymentDate' => $checkPayment->created_at, 'checkFImage' => $checkPayment->check_front, 'checkBImage' => $checkPayment->check_back, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($venmoPayments as $venmoPayment) {
                $orderPaymentsArray = [];
                //return $venmoPayment->order_id;
                $orderDetails = Order::where('id', $venmoPayment->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }

                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $venmoPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }

                if ($venmoPayment->is_approved == "1") {
                    $checkStatus = "Approved";
                } elseif ($venmoPayment->is_approved == "3") {
                    $checkStatus = "Rejected";
                } else {
                    $checkStatus = "Not Approved";
                }
                $processingFee = number_format(0, 2);
                $cardPaymentRecords = PaymentLog::where('order_id', $venmoPayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $venmoPayment->order_id)->where('is_approved', '1')->get();
                $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved', '1')->get();

                $venmoPaymentId = 'VNM' . str_pad(($venmoPayment->id), 6, "0", STR_PAD_LEFT);

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => $checkPaymentId, 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }
                foreach ($venmoPaymentRecords as $venmoPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Venmo', 'NameonCard' => 'N/A', 'TransactionId' => $venmoPaymentId, 'Amount' => $venmoPaymentRecord->amount, 'PaymentDate' => $venmoPaymentRecord->created_at);
                }

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $venmoPayment->order_id, 'OrderNo' => $order_no, 'paymentStatus2' => $paymentStatus2,  'balnceToBePaid' => $balnceToBePaid,  'processingFee' => $processingFee,  'TotalQty' => $totalQty, 'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork,  'PaymentType' => 'Venmo', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $checkStatus, 'Amount' => $venmoPayment->amount, 'OrderStatus' => $paymentStatus, 'TransactionID' => $venmoPaymentId, 'PaymentDate' => $venmoPayment->created_at, 'checkFImage' => $venmoPayment->venmo_receipt, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($paypalPayments as $paypalPayment) {
                $orderPaymentsArray = [];
                //return $paypalPayment->order_id;
                $orderDetails = Order::where('id', $paypalPayment->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }

                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $paypalPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
                $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $paypalPaymenttot = PaypalPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }

                if ($paypalPayment->is_approved == "1") {
                    $checkStatus = "Approved";
                } elseif ($paypalPayment->is_approved == "3") {
                    $checkStatus = "Rejected";
                } else {
                    $checkStatus = "Not Approved";
                }
                $processingFee = round(($paypalPaymenttot) * 3 / 103, 2);
                $cardPaymentRecords = PaymentLog::where('order_id', $paypalPayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $paypalPayment->order_id)->where('is_approved', '1')->get();
                $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved', '1')->get();
                $paypalPaymentRecords = PaypalPayment::where('order_id', $paypalPayment->order_id)->where('is_approved', '1')->get();

                $paypalPaymentId = 'VNM' . str_pad(($paypalPayment->id), 6, "0", STR_PAD_LEFT);

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => $checkPaymentId, 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }
                foreach ($venmoPaymentRecords as $venmoPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Venmo', 'NameonCard' => 'N/A', 'TransactionId' => $venmoPaymentId, 'Amount' => $venmoPaymentRecord->amount, 'PaymentDate' => $venmoPaymentRecord->created_at);
                }
                foreach ($paypalPaymentRecords as $paypalPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Paypal', 'NameonCard' => 'N/A', 'TransactionId' => $paypalPaymentId, 'Amount' => $paypalPaymentRecord->amount, 'PaymentDate' => $paypalPaymentRecord->created_at);
                }

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $paypalPayment->order_id, 'OrderNo' => $order_no,  'paymentStatus2' => $paymentStatus2, 'balnceToBePaid' => $balnceToBePaid, 'processingFee' => $processingFee,  'TotalQty' => $totalQty, 'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork,  'PaymentType' => 'Paypal', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $checkStatus, 'Amount' => $paypalPayment->amount, 'OrderStatus' => $paymentStatus, 'TransactionID' => $paypalPaymentId, 'PaymentDate' => $paypalPayment->created_at, 'checkFImage' => $paypalPayment->paypal_receipt, 'OrderPayments' => json_encode($orderPaymentsArray));
            }


            $PaymentDate  = array_column($TrasnsactionsArray, 'PaymentDate');

            array_multisort($PaymentDate, SORT_DESC,  $TrasnsactionsArray);

            // dd($TrasnsactionsArray);
            //End Payment Details

            // Production Calender

            $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

            $orderQueryProductionCalendar = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails', 'orderItems.factoryDetails');

            $productionOrdersThisMonth = $orderQueryProductionCalendar
                ->whereNotIn('organization_id', $this->inventoryOrgIds)
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->whereNotIn('order_status_id', [7, 4, 1])
                ->orderBy('id', 'DESC')
                ->get();

            $factoriesCalendar = Factory::where('active', 1)->orderBy('id')->get();

            // End Production Calender

            // Meeting calendar
            $activitiesMeetingCalendar = Activity::where('is_done', 0)
                ->where('activity_type', 2)
                ->with('organizationDetails')
                ->where(function ($query) use ($userId) {
                    $query->where('assigned_to', Auth::user()->id)
                        ->orWhere('created_by', $userId);
                })
                ->get();


            // End Meeting calendar

            return view('dashboards.rep_dashboard', [
                'orderQuoteCount' => $orderQuoteCount,
                'orderQuoteCountOwn' => $orderQuoteCountOwn,
                'orderProductionCount' => $orderProductionCount,
                'orderProductionCountOwn' => $orderProductionCountOwn,
                'orderShipmentCount' => $orderShipmentCount,
                'orderShipmentCountOwn' => $orderShipmentCountOwn,
                'orderFulfilledCount' => $orderFulfilledCount,
                'orderFulfilledCountOwn' => $orderFulfilledCountOwn,
                'all_persons' => $all_persons,
                'all_organizations' => $all_organizations,
                'activities' => $activities,
                'users' => $users,
                'urgentOrders' => $urgentOrders,
                'email' => $email,
                'TrasnsactionsArray' => $TrasnsactionsArray,
                'productionOrdersThisMonth' => $productionOrdersThisMonth,
                'factoriesCalendar' => $factoriesCalendar,
                'activitiesMeetingCalendar' => $activitiesMeetingCalendar
            ]);
    }

    public function index2(Request $request)
    {
        // Redirect user ID 1 to system admin dashboard
        if (Auth::user()->id == 1) {
            return redirect()->route('systemadmin.dashboard');
        }
        // if(Auth::user()->user_role_id != "8")
        // {
        $user = Auth::user();
        if ($user->hasRole([15])) {
            $authUsers = User::where('user_role_id', 2)->get();
            // $users = Auth::user();

            $userArray = array();
            foreach ($authUsers as $authUser) {
                $userArray[] = $authUser->id;
            }

            $orders = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->whereIn('user_id', [Auth::user()->id, $userArray])
                ->orderBy('order_no', 'desc')
                ->take(6)
                ->get();

            // Loop through each order to eager load the orderItems and factoryDetails relationship
            $orders->load(['orderItems.factoryDetails']);


            $organizations = Organization::get(['sport', 'id']);

            $sports = Sport::where('active', 1)->get();

            // $days = [];
            // $totals = [];

            // $today = Carbon::now();

            // for ($i = 0; $i < 7; $i++) {
            //     $currentDay = $today->copy()->subDays($i);

            //     $dayName = $currentDay->format('D');

            //     $days[] = $dayName;

            //     $startOfDay = $currentDay->copy()->startOfDay();
            //     $endOfDay = $currentDay->copy()->endOfDay();

            //     $orders1 = Order::whereBetween('created_at', [$startOfDay, $endOfDay])->get();

            //     $totalAmount = $orders1->sum('order_total');

            //     $totals[] = $totalAmount;
            // }

            $lastMonthStart = Carbon::now()->subMonth()->startOfMonth();
            $lastMonthEnd   = Carbon::now()->subMonth()->endOfMonth();

            $days = [];
            $totals = [];
            $categoryTotals = [];

            $currentDay = $lastMonthStart->copy();

            $testOrganizationIdSet = $this->getTestOrgId();

            while ($currentDay->lte($lastMonthEnd)) {
                $dayLabel = $currentDay->format('d M');
                $days[] = $dayLabel;

                $startOfDay = $currentDay->copy()->startOfDay();
                $endOfDay   = $currentDay->copy()->endOfDay();

                $orders = Order::where('active', 1)
                    ->whereNotNull('production_date')
                    ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                    ->whereNotIn('organization_id', $testOrganizationIdSet)
                    ->whereNotIn('order_status_id', [7])
                    ->whereIn('order_status_id', [3, 4, 8])
                    ->where('organization_id', '!=', 1377)
                    ->with('organizationDetails') // needed for internal_team
                    ->whereBetween(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), [$startOfDay, $endOfDay])
                    ->get();

                // Initialize category sums
                $bulk = $tsr = $wl = $ito = $all = 0;

                foreach ($orders as $order) {
                    if (optional($order->organizationDetails)->internal_team == 0) {
                        $all += $order->order_total;
                    }

                    if (strpos($order->order_no, 'TSR') !== 0 && $order->plorder == 0 && optional($order->organizationDetails)->internal_team == 0) {
                        $bulk += $order->order_total;
                    }

                    if (strpos($order->order_no, 'TSR') === 0 && optional($order->organizationDetails)->internal_team == 0) {
                        $tsr += $order->order_total;
                    }

                    if ($order->plorder == 1 && optional($order->organizationDetails)->internal_team == 0) {
                        $wl += $order->order_total;
                    }

                    if (optional($order->organizationDetails)->internal_team == 1) {
                        $ito += $order->order_total;
                    }
                }


                $totalAmount = $orders->sum('order_total');

                $totals[] = $totalAmount;
                $categoryTotals[] = [
                    'Bulk' => $bulk,
                    'TSR' => $tsr,
                    'WL' => $wl,
                    'ITO' => $ito,
                    'Total' => $totalAmount,
                ];

                $currentDay->addDay();
            }



            // $days = array_reverse($days);
            // $totals = array_reverse($totals);

            $monthlyTotals = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, ROUND(SUM(order_total), 2) as total24')
                ->whereYear('created_at', 2024)
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                ->get();

            $total2024 = $monthlyTotals->pluck('total24')->toArray();

            $monthlyTotals = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, ROUND(SUM(order_total), 2) as total24')
                ->whereYear('created_at', 2023)
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                ->get();

            $total2023 = $monthlyTotals->pluck('total24')->toArray();

            $monthlyTotals = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, ROUND(SUM(order_total), 2) as total24')
                ->whereYear('created_at', 2022)
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                ->get();

            $total2022 = $monthlyTotals->pluck('total24')->toArray();

            $monthlyTotals = Order::selectRaw('YEAR(created_at) as year, MONTH(created_at) as month, ROUND(SUM(order_total), 2) as total24')
                ->whereYear('created_at', 2021)
                ->groupBy(DB::raw('YEAR(created_at), MONTH(created_at)'))
                ->get();

            $total2021 = $monthlyTotals->pluck('total24')->toArray();

            $currentMonth = Carbon::now()->startOfMonth();
            $lastMonth = Carbon::now()->subMonth()->startOfMonth();
            $endOfLastMonth = $currentMonth->copy()->subDay();
            $previousYearSameMonthStart = Carbon::now()->subYear()->startOfMonth();
            $previousYearSameMonthEnd = Carbon::now()->subYear()->endOfMonth();

            // $currentMonthTotal = Order::where('active', 1)
            //         ->where('order_status_id', '!=', 7)
            //         ->where('order_status_id', '!=', 1)
            //         ->where('organization_id', '!=', 2890)
            //         ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '>=', $currentMonth)
            //         ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
            //         ->sum('order_total');

            $testOrganizationIdSet = $this->getTestOrgId();

            $currentMonthTotal = Order::where('active', 1)->where('write_off_order', 0)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7]) // match with previous logic
                ->whereIn('order_status_id', [3, 4, 8])
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
                ->sum('order_total');

            $lastMonthTotal = Order::where('active', 1)
                ->where('order_status_id', '!=', 7)
                ->where('order_status_id', '!=', 1)
                ->where('organization_id', '!=', 2890)
                ->whereBetween(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), [$lastMonth, $endOfLastMonth])
                ->sum('order_total');

            // $lastYearLastMonthTotal = Order::where('active', 1)
            //         ->where('order_status_id', '!=', 7)
            //         ->where('order_status_id', '!=', 1)
            //         ->where('organization_id', '!=', 2890)
            //         ->whereBetween(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), [$previousYearSameMonthStart, $previousYearSameMonthEnd])
            //         ->sum('order_total');

            $lastYearLastMonthTotal = Order::where('active', 1)->where('write_off_order', 0)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7])
                ->whereIn('order_status_id', [3, 4, 8])
                ->where('organization_id', '!=', 1377)
                ->whereBetween(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), [$previousYearSameMonthStart, $previousYearSameMonthEnd])
                ->sum('order_total');

            // $currentMonthOrderCount = Order::where('active', 1)
            //         ->where('order_status_id', '!=', 7)
            //         ->where('order_status_id', '!=', 1)
            //         ->where('organization_id', '!=', 2890)
            //         ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '>=', $currentMonth)
            //         ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
            //         ->count();

            $currentMonthOrderCount = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7])
                ->whereIn('order_status_id', [3, 4, 8])
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
                ->count();

            $percentageChange = 0;

            // if ($lastMonthTotal != 0) {
            //     $percentageChange = (($currentMonthTotal - $lastMonthTotal) / $lastMonthTotal) * 100;
            // }

            if ($lastYearLastMonthTotal != 0) {
                $percentageChange = (($currentMonthTotal - $lastYearLastMonthTotal) / $lastYearLastMonthTotal) * 100;
            }

            $percentageChange = round($percentageChange, 2);

            if ($percentageChange > 0) {
                $changeType = 'in';
            } elseif ($percentageChange < 0) {
                $changeType = 'de';
            } else {
                $changeType = 'no';
            }

            $newPercentageChange = abs($percentageChange);


            // $currentMonthQuote = Order::where('created_at', '>=', $currentMonth)
            //                         ->where('active', 1)
            //                         ->where('organization_id', '!=', 2890)
            //                         ->where('order_status_id', 1)
            //                         ->sum('order_total');

            $currentMonthQuote = Order::where('active', 1)
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('order_status_id', 1)
                ->where('organization_id', '!=', 1377)
                ->where('created_at', '>=', $currentMonth)
                ->where('created_at', '<', $currentMonth->copy()->addMonth())
                ->sum('order_total');


            $lastMonthQuote = Order::whereBetween('created_at', [$lastMonth, $currentMonth])
                ->where('active', 1)
                ->where('organization_id', '!=', 2890)
                ->where('order_status_id', 1)
                ->sum('order_total');

            // $lastYearLastMonthQuote = Order::whereBetween('created_at', [$previousYearSameMonthStart, $previousYearSameMonthEnd])
            //                         ->where('active', 1)
            //                         ->where('organization_id', '!=', 2890)
            //                         ->where('order_status_id', 1)
            //                         ->sum('order_total');

            $lastYearLastMonthQuote = Order::where('active', 1)
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('order_status_id', 1)
                ->where('organization_id', '!=', 1377)
                ->whereBetween('created_at', [$previousYearSameMonthStart, $previousYearSameMonthEnd])
                ->sum('order_total');

            // $currentMonthQuoteCount = Order::where('created_at', '>=', $currentMonth)
            //                         ->where('active', 1)
            //                         ->where('organization_id', '!=', 2890)
            //                         ->where('order_status_id', 1)
            //                         ->count();

            $currentMonthQuoteCount = Order::where('active', 1)
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('order_status_id', 1)
                ->where('organization_id', '!=', 1377)
                ->where('created_at', '>=', $currentMonth)
                ->where('created_at', '<', $currentMonth->copy()->addMonth())
                ->count();

            $percentageQuote = 0;

            // if ($lastMonthQuote != 0) {
            //     $percentageQuote = (($currentMonthQuote - $lastMonthQuote) / $lastMonthQuote) * 100;
            // }

            if ($lastYearLastMonthQuote != 0) {
                $percentageQuote = (($currentMonthQuote - $lastYearLastMonthQuote) / $lastYearLastMonthQuote) * 100;
            }

            $percentageQuote = round($percentageQuote, 2);

            if ($percentageQuote > 0) {
                $changeQuoteType = 'in';
            } elseif ($percentageQuote < 0) {
                $changeQuoteType = 'de';
            } else {
                $changeQuoteType = 'no';
            }

            $newpercentageQuote = abs($percentageQuote);


            // $currentMonthProduction = Order::where('active', 1)
            //                         ->where('organization_id', '!=', 2890)
            //                         ->where('order_status_id', 3)
            //                         ->sum('order_total');

            $currentMonthProduction = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7]) // match with previous logic
                ->whereIn('order_status_id', [3])
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
                ->sum('order_total');

            // $currentMonthProductionCount = Order::where('active', 1)
            //                         ->where('organization_id', '!=', 2890)
            //                         ->where('order_status_id', 3)
            //                         ->count();

            $currentMonthProductionCount = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7])
                ->whereIn('order_status_id', [3])
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
                ->count();

            $lastMonthProduction = Order::whereBetween('created_at', [$lastMonth, $currentMonth])
                ->where('active', 1)
                ->where('organization_id', '!=', 2890)
                ->where('order_status_id', 3)
                ->sum('order_total');

            $percentageProduction = 0;

            if ($lastMonthProduction != 0) {
                $percentageProduction = (($currentMonthProduction - $lastMonthProduction) / $lastMonthProduction) * 100;
            }

            $percentageProduction = round($percentageProduction, 2);

            if ($percentageProduction > 0) {
                $changeProductionType = 'in';
            } elseif ($percentageProduction < 0) {
                $changeProductionType = 'de';
            } else {
                $changeProductionType = 'no';
            }

            $newpercentageProduction = abs($percentageProduction);


            // $currentMonthShipping = Order::where('active', 1)
            //                         ->where('order_status_id', 4)
            //                         ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '>=', $currentMonth)
            //                         ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
            //                         ->sum('order_total');

            $currentMonthShipping = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereNotNull('ex_factory_date')
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('order_status_id', 4)
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
                ->sum('order_total');

            // $currentMonthShippingCount = Order::where('active', 1)
            //                         ->where('order_status_id', 4)
            //                         ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '>=', $currentMonth)
            //                         ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
            //                         ->count();

            $currentMonthShippingCount = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereNotNull('ex_factory_date')
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('order_status_id', 4)
                ->where('organization_id', '!=', 1377)
                ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '>=', $currentMonth)
                ->where(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), '<', $currentMonth->copy()->addMonth())
                ->count();

            $lastMonthShipping = Order::where('active', 1)
                ->whereBetween(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), [$lastMonth, $endOfLastMonth])
                ->where('order_status_id', 4)
                ->sum('order_total');

            // $lastYearLastMonthShipping = Order::where('active', 1)
            //                         ->whereBetween(DB::raw("STR_TO_DATE(production_date, '%m/%d/%Y')"), [$previousYearSameMonthStart, $previousYearSameMonthEnd])
            //                         ->where('order_status_id', 4)
            //                         ->sum('order_total');

            $lastYearLastMonthShipping = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereNotIn('order_status_id', [7])
                ->where('order_status_id', 4)
                ->where('organization_id', '!=', 1377)
                ->whereBetween(DB::raw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y')"), [$previousYearSameMonthStart, $previousYearSameMonthEnd])
                ->sum('order_total');

            $percentageShipping = 0;

            // if ($lastMonthShipping != 0) {
            //     $percentageShipping = (($currentMonthShipping - $lastMonthShipping) / $lastMonthShipping) * 100;
            // }

            if ($lastYearLastMonthShipping != 0) {
                $percentageShipping = (($currentMonthShipping - $lastYearLastMonthShipping) / $lastYearLastMonthShipping) * 100;
            }

            $percentageShipping = round($percentageShipping, 2);

            if ($percentageShipping > 0) {
                $changeShippingType = 'in';
            } elseif ($percentageShipping < 0) {
                $changeShippingType = 'de';
            } else {
                $changeShippingType = 'no';
            }

            $newpercentageShipping = abs($percentageShipping);

            //For bar chart
            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                ->where('active', 1);

            $orders1 = $orderQuery->where('active', 1)->get();

            $currentYear = Carbon::now()->year;
            $currentMonth = Carbon::now()->month;

            $lastYear = $currentYear - 1;

            //End For bar chart
            // dd($difJan);
            // Total Order table
            $orderStatus = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();
            $factories = Factory::where('active', 1)->orderBy('id')->get();
            $tenDaysAgo = Carbon::now()->subDays(20)->startOfDay();
            $today = Carbon::now()->endOfDay();

            $this->userGroupFactories();
            $oderSearch = $this->oderSearch;
            $factoryIds = $this->factoryIds;

            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

            // Filter orders created between 10 days ago and today
            $orderQuery->whereBetween('created_at', [$tenDaysAgo, $today]);

            $factoriesQuery = Factory::select('id', 'factory_code');

            if ($oderSearch == 'factory') {
                $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                    $qry->with('factoryDetails')
                        ->whereIn('factory_id', $factoryIds)
                        ->where('order_status_id', 3);
                }]);
                $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                    $qr->whereIn('factory_id', $factoryIds)
                        ->where('order_status_id', 3);
                });
                $factoriesQuery->whereIn('id', $factoryIds);
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }

            $totalOrders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

            $orderTotalCount = $orderQuery->count();
            $orderStatusId1Count = $orderQuery->where('order_status_id', 1)->count();
            $orderStatusId3Count = $orderQuery->where('order_status_id', 3)->count();
            $orderStatusId4Count = $orderQuery->where('order_status_id', 4)->count();
            $orderStatusId7Count = $orderQuery->where('order_status_id', 7)->count();


            // Activities in dashboard
            $roleId = Role::where('name', 'Activity Users')->value('id');

            $users = User::select('id', 'name')
                ->where('active', 1)
                ->whereJsonContains('role_id', (string) $roleId)
                ->orderBy('name')
                ->get();

            $salesUsers = User::select('id', 'name')
                ->where('active', 1)
                ->whereJsonContains('role_id', (string) 3)
                ->whereNotIn('id', [1, 2, 5, 28, 38, 63, 81, 83, 84, 96, 97, 102, 106, 108, 113, 114,])
                ->orderBy('name')
                ->get();

            $today = Carbon::today()->toDateString();

            $activities = Activity::where('assigned_to', Auth::user()->id)
                ->where('is_done', 0)
                ->with('organizationDetails')
                ->whereDate('start_date', $today)
                ->get();

            // line chart

            $roleId = 3;
            $testOrganizationIdSet = $this->getTestOrgId();

            // --- Get active sales users ---
            $users = User::select('id', 'name')
                ->where('active', 1)
                ->whereJsonContains('role_id', (string) $roleId)
                ->whereNotIn('id', [1, 2, 5, 28, 38, 63, 81, 83, 84, 96, 97, 102, 106, 108, 113, 114])
                ->orderBy('name')
                ->get();

            $currentYear = Carbon::now()->year;

            // --- Base order query ---
            $ordersQuery = Order::where('active', 1)
                ->whereNotNull('production_date')
                ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->whereIn('order_status_id', [3, 4, 8])
                ->where('organization_id', '!=', 1377)
                ->whereRaw('YEAR(STR_TO_DATE(production_date, "%m/%d/%Y")) = ?', [$currentYear])
                ->whereHas('organizationDetails', function ($query) {
                    $query->where('internal_team', 0); // ✅ Exclude internal team
                })
                ->with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails', 'orderItems');

            $orders = $ordersQuery->get();

            // if ($userId) {
            //     $ordersQuery->where('user_id', $userId);
            // }

            // --- 1️⃣ Chart data (aggregate totals per month) ---
            $ordersLinechart = (clone $ordersQuery)
                ->select(
                    'user_id',
                    DB::raw('MONTH(STR_TO_DATE(production_date, "%m/%d/%Y")) as month'),
                    DB::raw('SUM(order_total) as total')
                )
                ->groupBy('user_id', 'month')
                ->orderBy('month')
                ->get();

            // --- 2️⃣ Full filtered orders for the same year ---
            $filteredOrders = $ordersQuery
                ->orderByRaw('STR_TO_DATE(production_date, "%m/%d/%Y") ASC')
                ->get();

            // --- 3️⃣ Prepare chart structure ---
            $chartData = [];
            foreach ($users as $user) {
                $monthlyTotals = array_fill(1, 12, 0);

                foreach ($ordersLinechart->where('user_id', $user->id) as $order) {
                    if (!empty($order->month)) {
                        $monthlyTotals[$order->month] = round($order->total, 2);
                    }
                }

                $chartData[] = [
                    'user_id' => $user->id,
                    'label'   => $user->name,
                    'data'    => array_values($monthlyTotals),
                    'total'   => array_sum($monthlyTotals),
                ];
            }

            $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];


            // end line chart

            //received transactions

            $onlinePayments = PaymentLog::where('response_code', '1')->orderBy('created_at', 'DESC')->get();

            $checkPayments = CheckPayment::orderBy('created_at', 'DESC')->get();

            $venmoPayments = VenmoPayment::orderBy('created_at', 'DESC')->get();

            $paypalPayments = PaypalPayment::orderBy('created_at', 'DESC')->get();

            $PoReceipts = PurchaseorderReceipt::orderBy('created_at', 'DESC')->get();

            $otherPayments = OtherPayment::orderBy('created_at', 'DESC')->get();

            $TrasnsactionsArray = [];
            foreach ($otherPayments as $otherPayment) {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id')->where('id', $otherPayment->order_id)->with(['organizationDetails:id,organization_name,sales_tax'])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];


                $order_payment_status = $this->PaymentService->getPaymentStatus($otherPayment->order_id)['payment_status'];
                $approval = $otherPayment->is_approved == 1 ? 'Approved' : 'Not Approved';
                $PaymentIdUnique = 'OTH' . str_pad(($otherPayment->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($otherPayment->order_id);


                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $otherPayment->order_id, 'PaymentType' => 'Other', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $approval, 'Amount' => $otherPayment->amount, 'ProcessingFee' => 0, 'OrderStatus' => $order_payment_status, 'TransactionID' => $PaymentIdUnique, 'PaymentDate' => $otherPayment->created_at, 'checkFImage' => $otherPayment->document_url, 'checkBImage' => $otherPayment->document_url_back, 'OrderPayments' => json_encode($orderPaymentsArray));
            }
            foreach ($PoReceipts as $PoReceipt) {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id')->where('id', $PoReceipt->order_id)->with(['organizationDetails:id,organization_name,sales_tax'])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $order_payment_status = $this->PaymentService->getPaymentStatus($PoReceipt->order_id)['payment_status'];
                $approval = $PoReceipt->is_approved == 1 ? 'Approved' : 'Not Approved';
                $PaymentIdUnique = 'PO' . str_pad(($PoReceipt->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($PoReceipt->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $PoReceipt->order_id, 'PaymentType' => 'PO', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $approval, 'Amount' => $PoReceipt->amount, 'ProcessingFee' => 0, 'OrderStatus' => $order_payment_status, 'TransactionID' => $PaymentIdUnique, 'PaymentDate' => $PoReceipt->created_at, 'checkFImage' => $PoReceipt->receipt, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($onlinePayments as $onlinePayment) {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id')->where('id', $onlinePayment->order_id)->with(['organizationDetails:id,organization_name,sales_tax'])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $order_payment_status = $this->PaymentService->getPaymentStatus($onlinePayment->order_id)['payment_status'];

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($onlinePayment->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);
                $ProcessingFee = $onlinePayment->amount * 100 / 103;

                $TrasnsactionsArray[] = array('Order' => $onlinePayment->order_id, 'PaymentType' => 'Card', 'TeamName' => $organization_name, 'NameonCard' => $onlinePayment->name_on_card, 'checkStatus' => 'Approved', 'Amount' => $onlinePayment->amount, 'ProcessingFee' => $ProcessingFee, 'OrderStatus' => $order_payment_status, 'TransactionID' => $onlinePayment->transaction_id, 'PaymentDate' => $onlinePayment->created_at, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($checkPayments as $checkPayment) {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id')->where('id', $checkPayment->order_id)->with(['organizationDetails:id,organization_name,sales_tax'])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $order_payment_status = $this->PaymentService->getPaymentStatus($checkPayment->order_id)['payment_status'];
                $approval = $checkPayment->is_approved == 1 ? 'Approved' : 'Not Approved';
                $PaymentIdUnique = 'CHQ' . str_pad(($checkPayment->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($checkPayment->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $checkPayment->order_id, 'PaymentType' => 'Check', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $approval, 'Amount' => $checkPayment->amount, 'ProcessingFee' => 0, 'OrderStatus' => $order_payment_status, 'TransactionID' => $PaymentIdUnique, 'PaymentDate' => $checkPayment->created_at, 'checkFImage' => $checkPayment->check_front, 'checkBImage' => $checkPayment->check_back, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($venmoPayments as $venmoPayment) {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id')->where('id', $venmoPayment->order_id)->with(['organizationDetails:id,organization_name,sales_tax'])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $order_payment_status = $this->PaymentService->getPaymentStatus($venmoPayment->order_id)['payment_status'];
                $approval = $venmoPayment->is_approved == 1 ? 'Approved' : 'Not Approved';
                $PaymentIdUnique = 'VNM' . str_pad(($venmoPayment->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($venmoPayment->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $venmoPayment->order_id, 'PaymentType' => 'Venmo', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $approval, 'Amount' => $venmoPayment->amount, 'ProcessingFee' => 0, 'OrderStatus' => $order_payment_status, 'TransactionID' => $PaymentIdUnique, 'PaymentDate' => $venmoPayment->created_at, 'checkFImage' => $venmoPayment->venmo_receipt, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($paypalPayments as $paypalPayment) {
                $orderPaymentsArray = [];
                $orderDetails = Order::select('order_no', 'sub_total', 'artwork', 'discount_hidation', 'discountType', 'discount', 'sales_tax', 'shipping', 'order_total', 'organization_id')->where('id', $paypalPayment->order_id)->with(['organizationDetails:id,organization_name,sales_tax'])->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];

                $order_payment_status = $this->PaymentService->getPaymentStatus($paypalPayment->order_id)['payment_status'];
                $approval = $paypalPayment->is_approved == 1 ? 'Approved' : 'Not Approved';
                $PaymentIdUnique = 'PAYPAL' . str_pad(($paypalPayment->id), 6, "0", STR_PAD_LEFT);

                $orderPaymentsArray = $this->getAllPaymentsByOrderId($paypalPayment->order_id);

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);
                $ProcessingFee = $paypalPayment->amount * 100 / 103;

                $TrasnsactionsArray[] = array('Order' => $paypalPayment->order_id, 'PaymentType' => 'Paypal', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $approval, 'Amount' => $paypalPayment->amount, 'ProcessingFee' => $ProcessingFee, 'OrderStatus' => $order_payment_status, 'TransactionID' => $PaymentIdUnique, 'PaymentDate' => $paypalPayment->created_at, 'checkFImage' => $paypalPayment->paypal_receipt, 'OrderPayments' => json_encode($orderPaymentsArray));
            }


            $PaymentDate  = array_column($TrasnsactionsArray, 'PaymentDate');

            // Sort the data with volume descending, edition ascending
            // Add $data as the last parameter, to sort by the common key
            array_multisort($PaymentDate, SORT_DESC,  $TrasnsactionsArray);

            // end received transactions

            //Pending Payment Orders

            $orders = Order::where('order_status_id', 3)
                ->with('organizationDetails') // eager load organization
                ->get();

            $pendingOrders = $orders->filter(function ($order) {
                $paidAmount = 0;

                $paidAmount += PaymentLog::where('order_id', $order->id)
                    ->where('response_code', '1')
                    ->sum('amount');

                $paidAmount += CheckPayment::where('order_id', $order->id)->sum('amount');
                $paidAmount += VenmoPayment::where('order_id', $order->id)->sum('amount');
                $paidAmount += PaypalPayment::where('order_id', $order->id)->sum('amount');
                $paidAmount += PurchaseorderReceipt::where('order_id', $order->id)->sum('amount');
                $paidAmount += OtherPayment::where('order_id', $order->id)->sum('amount');

                $order->paid_amount = $paidAmount;
                $order->pending_amount = $order->order_total - $paidAmount;

                return $order->pending_amount > 0;
            });

            // Sort by id descending
            $pendingOrders = $pendingOrders->sortByDesc('id')->values();



            // dd($activities);
            return view('dashboard', [
                'orders' => $orders,
                'users' => $users,
                'organizations' => $organizations,
                'sports' => $sports,
                'totals' => $totals,
                'days' => $days,
                'categoryTotals' => $categoryTotals,
                'total2024' => $total2024,
                'currentMonthTotal' => $currentMonthTotal,
                'lastMonthTotal' => $lastMonthTotal,
                'percentageChange' => $percentageChange,
                'changeType' => $changeType,
                'newPercentageChange' => $newPercentageChange,
                'percentageQuote' => $percentageQuote,
                'currentMonthQuote' => $currentMonthQuote,
                'lastMonthQuote' => $lastMonthQuote,
                'changeQuoteType' => $changeQuoteType,
                'newpercentageQuote' => $newpercentageQuote,
                'percentageProduction' => $percentageProduction,
                'currentMonthProduction' => $currentMonthProduction,
                'lastMonthProduction' => $lastMonthProduction,
                'changeProductionType' => $changeProductionType,
                'newpercentageProduction' => $newpercentageProduction,
                'percentageShipping' => $percentageShipping,
                'currentMonthShipping' => $currentMonthShipping,
                'lastMonthShipping' => $lastMonthShipping,
                'changeShippingType' => $changeShippingType,
                'newpercentageShipping' => $newpercentageShipping,
                'total2023' => $total2023,
                'total2022' => $total2022,
                'total2021' => $total2021,
                'orderStatus' => $orderStatus,
                'factories' => $factories,
                'firstTenItems' => $totalOrders,
                'orderTotalCount' => $orderTotalCount,
                'orderStatusId1Count' => $orderStatusId1Count,
                'orderStatusId3Count' => $orderStatusId3Count,
                'orderStatusId4Count' => $orderStatusId4Count,
                'orderStatusId7Count' => $orderStatusId7Count,
                'activities' => $activities,
                'currentMonthOrderCount' => $currentMonthOrderCount,
                'currentMonthQuoteCount' => $currentMonthQuoteCount,
                'currentMonthProductionCount' => $currentMonthProductionCount,
                'currentMonthShippingCount' => $currentMonthShippingCount,
                'lastYearLastMonthTotal' => $lastYearLastMonthTotal,
                'lastYearLastMonthQuote' => $lastYearLastMonthQuote,
                'lastYearLastMonthShipping' => $lastYearLastMonthShipping,
                'salesUsers' => $salesUsers,
                'chartData' => $chartData,
                'labels' => $labels,
                'TrasnsactionsArray' => $TrasnsactionsArray,
                'pendingOrders' => $pendingOrders
            ]);
        } else if ($user->hasRole([10])) {
            return redirect()->route('allTransactions');
        } else if ($user->hasRole([19])) {
            // dd($user->hasRole);

            $this->userGroupFactories();
            $oderSearch = $this->oderSearch;
            $factoryIds = $this->factoryIds;

            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');
            $orderQuery_for_upcoming = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');
            $factoriesQuery = Factory::select('id', 'factory_code');

            // Orgnnization name serach
            if ($request->org) {
                $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                    $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                    $query->whereNotIn('id', $this->inventoryOrgIds);
                });
                $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
            }
            // factory filter
            if ($request->fct) {
                $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                    $query->where('id', $request->fct);
                });
            }
            // status filter
            if ($request->sts) {
                $orderQuery->where('order_status_id', $request->sts);
            }

            if ($oderSearch == 'factory') {
                $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                    $qry->with('factoryDetails')
                        ->whereIn('factory_id', $factoryIds)
                        ->whereIn('order_status_id', [3, 4, 8]);
                }]);
                $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                    $qr->whereIn('factory_id', $factoryIds)
                        ->whereIn('order_status_id', [3, 4, 8]);
                });
                $factoriesQuery->whereIn('id', $factoryIds);
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }
            $orderQuery_for_upcoming->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds);
            }]);

            $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();
            $orders_for_upcoming = $orderQuery_for_upcoming->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

            $orderUrgent = $orders->where('is_urgent', 1)->where('order_status_id', '!=', 4)->count();
            $orderNew = $orders->where('order_status_id', 1)->count();
            $orderProduction = $orders->where('order_status_id', 3)->count();
            $orderFulfiled = $orders->where('order_status_id', 4)->count();
            $orderUpcoming = $orders_for_upcoming->where('upcoming_status', 1)->whereNotIn('order_status_id', [3, 4, 5, 6, 7])->count();

            $orderStatus = OrderStatus::select('id', 'status_name')->where('active', 1)->orderBy('id')->get();
            $factories = Factory::where('active', 1)->orderBy('id')->get();

            $ordersPegi = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

            $urgentOrders = $orderQuery
                ->whereNotIn('organization_id', $this->inventoryOrgIds)
                ->where('active', 1)
                ->where('is_urgent', 1)
                ->where('order_status_id', '!=', 4)
                ->orderBy('id', 'DESC')
                ->get();


            $productionOrders = $orders->filter(function ($order) {
                return $order->order_status_id == 3;
            });

            $sippingDetails = ShippingOrderDetails::orderBy('order_id', 'DESC')->where('tracking_no', '!=', null)->get();

            $groupedDetails = $sippingDetails->groupBy('order_id');

            $matches = 0;

            foreach ($productionOrders as $order) {
                if ($groupedDetails->has($order->id)) {
                    $matches++;
                }
            }

            // dd($matches);
            return view('dashboards.factory_dashboard', [
                'orderUrgent' => $orderUrgent,
                'orderNew' => $orderNew,
                'orderProduction' => $orderProduction,
                'orderFulfiled' => $orderFulfiled,
                'orderStatus' => $orderStatus,
                'factories' => $factories,
                'ordersPegi' => $ordersPegi,
                'urgentOrders' => $urgentOrders,
                'matches' => $matches,
                'orderUpcoming' => $orderUpcoming
            ]);
        } else if ($user->hasRole([20])) {

            $userId = Auth::id();
            $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
            $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

            $orders = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->get();

            $orderQuoteCount = $orders->where('order_status_id', 1)->count();
            $orderProductionCount = $orders->where('order_status_id', 3)->count();
            $orderFulfilledCount = $orders->where('order_status_id', 4)->count();

            $orderShipmentCount = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->whereRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') BETWEEN ? AND ?", [$startOfWeek, $endOfWeek])
                ->count();

            $orderQuoteCountOwn = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->where('order_status_id', 1)
                ->count();

            $orderProductionCountOwn = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->where('order_status_id', 3)
                ->count();

            $orderShipmentCountOwn = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->whereRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') BETWEEN ? AND ?", [$startOfWeek, $endOfWeek])
                ->count();


            $orderFulfilledCountOwn = Order::with('organizationDetails', 'userDetails')
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->where('order_status_id', 4)
                ->count();

            $all_persons = Contact::where('active', 1)->get();
            $all_organizations = Organization::where('active', 1)->get();
            $today = Carbon::today()->toDateString();

            $activities = Activity::where('assigned_to', Auth::user()->id)
                ->where('is_done', 0)
                ->with('organizationDetails')
                ->whereDate('start_date', $today)
                ->get();

            $roleId = Role::where('name', 'Activity Users')->value('id');
            $users = User::select('id', 'name')
                ->where('active', 1)
                ->whereJsonContains('role_id', (string) $roleId)
                ->orderBy('name')
                ->get();

            $this->userGroupFactories();
            $oderSearch = $this->oderSearch;
            $factoryIds = $this->factoryIds;

            $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

            $factoriesQuery = Factory::select('id', 'factory_code');

            // Orgnnization name serach
            if ($request->org) {
                $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                    $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                    $query->whereNotIn('id', $this->inventoryOrgIds);
                });
                $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
            }
            // factory filter
            if ($request->fct) {
                $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                    $query->where('id', $request->fct);
                });
            }
            // status filter
            if ($request->sts) {
                $orderQuery->where('order_status_id', $request->sts);
            }

            if ($oderSearch == 'factory') {
                $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                    $qry->with('factoryDetails')
                        ->whereIn('factory_id', $factoryIds)
                        ->whereIn('order_status_id', [3, 4, 8]);
                }]);
                $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                    $qr->whereIn('factory_id', $factoryIds)
                        ->whereIn('order_status_id', [3, 4, 8]);
                });
                $factoriesQuery->whereIn('id', $factoryIds);
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }

            $urgentOrders = $orderQuery
                ->whereNotIn('organization_id', $this->inventoryOrgIds)
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->where('order_status_id', 1)
                ->orderBy('id', 'DESC')
                ->get();

            $email = $this->emailRepDashboard() ?? NULL;
            // dd($email);

            // Payment details
            $onlinePayments = PaymentLog::where('response_code', '1')->orderBy('created_at', 'DESC')->get();

            $checkPayments = CheckPayment::orderBy('created_at', 'DESC')->get();

            $venmoPayments = VenmoPayment::orderBy('created_at', 'DESC')->get();

            $paypalPayments = PaypalPayment::orderBy('created_at', 'DESC')->get();

            $PoReceipts = PurchaseorderReceipt::orderBy('created_at', 'DESC')->get();


            $TrasnsactionsArray = [];

            foreach ($PoReceipts as $PoReceipt) {
                $orderPaymentsArray = [];

                $orderDetails = Order::where('id', $PoReceipt->order_id)->with('organizationDetails')->get();
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $payment = $PoReceipt->amount;
                $orderDetails = Order::where('id', $PoReceipt->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }
                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $balnceToBePaid = 0;
                if ($PoReceipt->is_approved == 0) {
                    $paymentStatus = "Pending Approval";
                } else if ($PoReceipt->is_approved == 1) {
                    $paymentStatus = "Approved";
                } else {
                    $paymentStatus = "Rejected";
                }
                $PoPaymentId = 'PO' . str_pad(($PoReceipt->id), 6, "0", STR_PAD_LEFT);
                $orderPaymentsArray[] = array('Method' => 'PO', 'NameonCard' => 'N/A', 'TransactionId' => $PoPaymentId, 'Amount' => $payment, 'PaymentDate' => $PoReceipt->created_at);
                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                // $TrasnsactionsArray[] = array('Order'=> $PoReceipt->order_id, 'PaymentType'=>'PO', 'TeamName'=> $organization_name, 'NameonCard'=> 'N/A', 'checkStatus'=> $paymentStatus, 'Amount'=> $payment, 'OrderStatus'=> $paymentStatus, 'TransactionID'=> 'N/A', 'PaymentDate'=> $PoReceipt->created_at,'checkFImage'=>$PoReceipt->receipt, 'OrderPayments'=>json_encode($orderPaymentsArray));
                $TrasnsactionsArray[] = array('Order' => $PoReceipt->order_id, 'OrderNo' => $order_no, 'paymentStatus2' => $paymentStatus, 'balnceToBePaid' => $balnceToBePaid,  'processingFee' => 0, 'TotalQty' => $totalQty, 'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork, 'PaymentType' => 'PO', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $paymentStatus, 'Amount' => $payment, 'OrderStatus' => $paymentStatus, 'TransactionID' => $PoPaymentId, 'PaymentDate' => $PoReceipt->created_at, 'checkFImage' => $PoReceipt->receipt, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($onlinePayments as $onlinePayment) {
                $orderPaymentsArray = [];

                $orderDetails = Order::where('id', $onlinePayment->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }
                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $onlinePayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $onlinePayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }
                $processingFee = round(($cardPaymenttot) * 3 / 103, 2);
                $cardPaymentRecords = PaymentLog::where('order_id', $onlinePayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $onlinePayment->order_id)->where('is_approved', '1')->get();

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => 'N/A', 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $onlinePayment->order_id, 'OrderNo' => $order_no, 'paymentStatus2' => $paymentStatus2, 'balnceToBePaid' => $balnceToBePaid,  'processingFee' => $processingFee, 'TotalQty' => $totalQty, 'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork, 'PaymentType' => 'Online', 'TeamName' => $organization_name, 'NameonCard' => $onlinePayment->name_on_card, 'checkStatus' => 'Approved', 'Amount' => $onlinePayment->amount, 'OrderStatus' => $paymentStatus, 'TransactionID' => $onlinePayment->transaction_id, 'PaymentDate' => $onlinePayment->created_at, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($checkPayments as $checkPayment) {
                $orderPaymentsArray = [];
                //return $checkPayment->order_id;
                $orderDetails = Order::where('id', $checkPayment->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }

                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $checkPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $checkPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }

                if ($checkPayment->is_approved == "1") {
                    $checkStatus = "Approved";
                } elseif ($checkPayment->is_approved == "3") {
                    $checkStatus = "Rejected";
                } else {
                    $checkStatus = "Not Approved";
                }
                $processingFee = number_format(0, 2);
                $cardPaymentRecords = PaymentLog::where('order_id', $checkPayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $checkPayment->order_id)->where('is_approved', '1')->get();

                $checkPaymentId = 'CHQ' . str_pad(($checkPayment->id), 6, "0", STR_PAD_LEFT);

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => $checkPaymentId, 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $checkPayment->order_id, 'processingFee' => $processingFee, 'paymentStatus2' => $paymentStatus2,  'balnceToBePaid' => $balnceToBePaid,  'OrderNo' => $order_no, 'TotalQty' => $totalQty,  'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork,  'PaymentType' => 'Check', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $checkStatus, 'Amount' => $checkPayment->amount, 'OrderStatus' => $paymentStatus, 'TransactionID' => $checkPaymentId, 'PaymentDate' => $checkPayment->created_at, 'checkFImage' => $checkPayment->check_front, 'checkBImage' => $checkPayment->check_back, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($venmoPayments as $venmoPayment) {
                $orderPaymentsArray = [];
                //return $venmoPayment->order_id;
                $orderDetails = Order::where('id', $venmoPayment->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }

                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $venmoPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }

                if ($venmoPayment->is_approved == "1") {
                    $checkStatus = "Approved";
                } elseif ($venmoPayment->is_approved == "3") {
                    $checkStatus = "Rejected";
                } else {
                    $checkStatus = "Not Approved";
                }
                $processingFee = number_format(0, 2);
                $cardPaymentRecords = PaymentLog::where('order_id', $venmoPayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $venmoPayment->order_id)->where('is_approved', '1')->get();
                $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved', '1')->get();

                $venmoPaymentId = 'VNM' . str_pad(($venmoPayment->id), 6, "0", STR_PAD_LEFT);

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => $checkPaymentId, 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }
                foreach ($venmoPaymentRecords as $venmoPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Venmo', 'NameonCard' => 'N/A', 'TransactionId' => $venmoPaymentId, 'Amount' => $venmoPaymentRecord->amount, 'PaymentDate' => $venmoPaymentRecord->created_at);
                }

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $venmoPayment->order_id, 'OrderNo' => $order_no, 'paymentStatus2' => $paymentStatus2,  'balnceToBePaid' => $balnceToBePaid,  'processingFee' => $processingFee,  'TotalQty' => $totalQty, 'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork,  'PaymentType' => 'Venmo', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $checkStatus, 'Amount' => $venmoPayment->amount, 'OrderStatus' => $paymentStatus, 'TransactionID' => $venmoPaymentId, 'PaymentDate' => $venmoPayment->created_at, 'checkFImage' => $venmoPayment->venmo_receipt, 'OrderPayments' => json_encode($orderPaymentsArray));
            }

            foreach ($paypalPayments as $paypalPayment) {
                $orderPaymentsArray = [];
                //return $paypalPayment->order_id;
                $orderDetails = Order::where('id', $paypalPayment->order_id)->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })->with('organizationDetails', 'orderItems')->get();

                if ($orderDetails->isEmpty()) {
                    continue;
                }

                $order_no = $orderDetails[0]->order_no;
                $sub_total = $orderDetails[0]->sub_total;
                $shipping = $orderDetails[0]->shipping;
                $sales_tax = $orderDetails[0]->sales_tax;
                $artwork = $orderDetails[0]->artwork;
                $totalQty = $orderDetails[0]->orderItems->sum('qty');
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $paypalPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
                $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $paypalPaymenttot = PaypalPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot;

                $balnceToBePaid = 0;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                    $paymentStatus2 = 0;
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $balnceToBePaid = $orderDetails[0]->order_total - $payment;
                    $paymentStatus = "Partial";
                    $paymentStatus2 = 1;
                } else {
                    $paymentStatus = "Paid";
                    $paymentStatus2 = 2;
                }

                if ($paypalPayment->is_approved == "1") {
                    $checkStatus = "Approved";
                } elseif ($paypalPayment->is_approved == "3") {
                    $checkStatus = "Rejected";
                } else {
                    $checkStatus = "Not Approved";
                }
                $processingFee = round(($paypalPaymenttot) * 3 / 103, 2);
                $cardPaymentRecords = PaymentLog::where('order_id', $paypalPayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $paypalPayment->order_id)->where('is_approved', '1')->get();
                $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved', '1')->get();
                $paypalPaymentRecords = PaypalPayment::where('order_id', $paypalPayment->order_id)->where('is_approved', '1')->get();

                $paypalPaymentId = 'VNM' . str_pad(($paypalPayment->id), 6, "0", STR_PAD_LEFT);

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => $checkPaymentId, 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }
                foreach ($venmoPaymentRecords as $venmoPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Venmo', 'NameonCard' => 'N/A', 'TransactionId' => $venmoPaymentId, 'Amount' => $venmoPaymentRecord->amount, 'PaymentDate' => $venmoPaymentRecord->created_at);
                }
                foreach ($paypalPaymentRecords as $paypalPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Paypal', 'NameonCard' => 'N/A', 'TransactionId' => $paypalPaymentId, 'Amount' => $paypalPaymentRecord->amount, 'PaymentDate' => $paypalPaymentRecord->created_at);
                }

                $PaidDate  = array_column($orderPaymentsArray, 'PaymentDate');
                array_multisort($PaidDate, SORT_ASC,  $orderPaymentsArray);

                $TrasnsactionsArray[] = array('Order' => $paypalPayment->order_id, 'OrderNo' => $order_no,  'paymentStatus2' => $paymentStatus2, 'balnceToBePaid' => $balnceToBePaid, 'processingFee' => $processingFee,  'TotalQty' => $totalQty, 'SubTotal' => $sub_total, 'Shipping' => $shipping, 'SalesTax' => $sales_tax, 'ArtWork' => $artwork,  'PaymentType' => 'Paypal', 'TeamName' => $organization_name, 'NameonCard' => 'N/A', 'checkStatus' => $checkStatus, 'Amount' => $paypalPayment->amount, 'OrderStatus' => $paymentStatus, 'TransactionID' => $paypalPaymentId, 'PaymentDate' => $paypalPayment->created_at, 'checkFImage' => $paypalPayment->paypal_receipt, 'OrderPayments' => json_encode($orderPaymentsArray));
            }


            $PaymentDate  = array_column($TrasnsactionsArray, 'PaymentDate');

            array_multisort($PaymentDate, SORT_DESC,  $TrasnsactionsArray);

            // dd($TrasnsactionsArray);
            //End Payment Details

            // Production Calender

            $startOfMonth = Carbon::now()->startOfMonth()->format('Y-m-d');
            $endOfMonth = Carbon::now()->endOfMonth()->format('Y-m-d');

            $orderQueryProductionCalendar = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails', 'orderItems.factoryDetails');

            $productionOrdersThisMonth = $orderQueryProductionCalendar
                ->whereNotIn('organization_id', $this->inventoryOrgIds)
                ->where('active', 1)
                ->where(function ($query) use ($userId) {
                    $query->where('user_id', $userId)
                        ->orWhere('order_procesing_user_id', $userId);
                })
                ->whereNotIn('order_status_id', [7, 4, 1])
                ->orderBy('id', 'DESC')
                ->get();

            $factoriesCalendar = Factory::where('active', 1)->orderBy('id')->get();

            // End Production Calender

            // Meeting calendar
            $activitiesMeetingCalendar = Activity::where('is_done', 0)
                ->where('activity_type', 2)
                ->with('organizationDetails')
                ->where(function ($query) use ($userId) {
                    $query->where('assigned_to', Auth::user()->id)
                        ->orWhere('created_by', $userId);
                })
                ->get();


            // End Meeting calendar

            return view('dashboards.rep_dashboard', [
                'orderQuoteCount' => $orderQuoteCount,
                'orderQuoteCountOwn' => $orderQuoteCountOwn,
                'orderProductionCount' => $orderProductionCount,
                'orderProductionCountOwn' => $orderProductionCountOwn,
                'orderShipmentCount' => $orderShipmentCount,
                'orderShipmentCountOwn' => $orderShipmentCountOwn,
                'orderFulfilledCount' => $orderFulfilledCount,
                'orderFulfilledCountOwn' => $orderFulfilledCountOwn,
                'all_persons' => $all_persons,
                'all_organizations' => $all_organizations,
                'activities' => $activities,
                'users' => $users,
                'urgentOrders' => $urgentOrders,
                'email' => $email,
                'TrasnsactionsArray' => $TrasnsactionsArray,
                'productionOrdersThisMonth' => $productionOrdersThisMonth,
                'factoriesCalendar' => $factoriesCalendar,
                'activitiesMeetingCalendar' => $activitiesMeetingCalendar
            ]);
        } else if ($user->hasRole([1, 2, 3, 4])) {
            $authUsers = User::where('user_role_id', 2)->get();
            $users = Auth::user();

            $userArray = array();
            foreach ($authUsers as $authUser) {
                $userArray[] = $authUser->id;
            }

            $orders = Order::with('organizationDetails')
                ->where('active', 1)
                ->whereIn('user_id', [Auth::user()->id, $userArray])
                ->orderBy('order_no', 'desc')
                ->take(12)
                ->get();

            $organizations = Organization::get(['sport', 'id']);

            $sports = Sport::where('active', 1)->get();

            return view('defaultdashboard', ['orders' => $orders, 'users' => $users, 'organizations' => $organizations, 'sports' => $sports]);
        } else {
            return redirect()->route('orders');
        }

        // }
        // else{
        //     return redirect()->route('allTransactions');
        // }

    }

    public function getOrderOrganization()
    {
        $orderDetails = Order::where('id', 1)->with('organizationDetails')->get();
        return $orderDetails;
    }

    public function checkPayments()
    {
        $checkPayments = CheckPayment::orderBy('created_at', 'DESC')->get();

        return view('transactions.check-transactions', ['checkPayments' => $checkPayments]);
    }

    public function emailRepDashboard()
    {
        $accessToken = session('azure_access_token') ?? null;
        $refreshToken = session('azure_refresh_token') ?? null;
        if ($accessToken == null && $refreshToken == null) {
            return NULL;
        } else {
            $validresponse = $this->graphService->getUserProfile($accessToken);
        }
        if ((!$validresponse)) {
            $accessToken = $this->getAccessToken($refreshToken);
        }
        $inboxMessages = $this->graphService->getInboxMessages($accessToken, 1);

        return $inboxMessages;
    }

    public function barChartUpdateDashboard($selectedYear)
    {

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
            ->where('active', 1);

        $orders1 = $orderQuery->where('active', 1)->get();

        $currentYear = Carbon::now()->year;
        $currentMonth = Carbon::now()->month;

        $lastYear = $selectedYear - 1;


        // January
        $ordersJanEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumJanu = $ordersJanEmail->sum('order_total');

        $ordersJanwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumJanu = $ordersJanwalking->sum('order_total');

        $ordersJanonline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumJanu = $ordersJanonline->sum('order_total');

        $ordersJanreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumJanu = $ordersJanreferral->sum('order_total');

        $ordersJanreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 1 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumJanu = $ordersJanreother->sum('order_total');
        // End January

        // February
        $ordersFebEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumFebu = $ordersFebEmail->sum('order_total');

        $ordersFebwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumFebu = $ordersFebwalking->sum('order_total');

        $ordersFebonline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumFebu = $ordersFebonline->sum('order_total');

        $ordersFebreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumFebu = $ordersFebreferral->sum('order_total');

        $ordersFebreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 2 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumFebu = $ordersFebreother->sum('order_total');
        // End February

        // March
        $ordersMarchEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumMarchu = $ordersMarchEmail->sum('order_total');

        $ordersMarchwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumMarchu = $ordersMarchwalking->sum('order_total');

        $ordersMarchonline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumMarchu = $ordersMarchonline->sum('order_total');

        $ordersMarchreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumMarchu = $ordersMarchreferral->sum('order_total');

        $ordersMarchreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 3 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumMarchu = $ordersMarchreother->sum('order_total');
        // End March

        // April
        $ordersAprEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumApru = $ordersAprEmail->sum('order_total');

        $ordersAprwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumApru = $ordersAprwalking->sum('order_total');

        $ordersApronline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumApru = $ordersApronline->sum('order_total');

        $ordersAprreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumApru = $ordersAprreferral->sum('order_total');

        $ordersAprreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 4 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumApru = $ordersAprreother->sum('order_total');
        // End April

        // May
        $ordersMayEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumMayu = $ordersMayEmail->sum('order_total');

        $ordersMaywalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumMayu = $ordersMaywalking->sum('order_total');

        $ordersMayonline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumMayu = $ordersMayonline->sum('order_total');

        $ordersMayreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumMayu = $ordersMayreferral->sum('order_total');

        $ordersMayreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 5 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumMayu = $ordersMayreother->sum('order_total');
        // End May

        // June
        $ordersJunEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumJunu = $ordersJunEmail->sum('order_total');

        $ordersJunwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumJunu = $ordersJunwalking->sum('order_total');

        $ordersJunonline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumJunu = $ordersJunonline->sum('order_total');

        $ordersJunreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumJunu = $ordersJunreferral->sum('order_total');

        $ordersJunreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 6 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumJunu = $ordersJunreother->sum('order_total');
        // End June

        // July
        $ordersJulEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumJulu = $ordersJulEmail->sum('order_total');

        $ordersJulwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumJulu = $ordersJulwalking->sum('order_total');

        $ordersJulonline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumJulu = $ordersJulonline->sum('order_total');

        $ordersJulreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumJulu = $ordersJulreferral->sum('order_total');

        $ordersJulreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 7 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumJulu = $ordersJulreother->sum('order_total');
        // End July

        // Augast
        $ordersAugEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumAugu = $ordersAugEmail->sum('order_total');

        $ordersAugwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumAugu = $ordersAugwalking->sum('order_total');

        $ordersAugonline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumAugu = $ordersAugonline->sum('order_total');

        $ordersAugreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumAugu = $ordersAugreferral->sum('order_total');

        $ordersAugreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 8 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumAugu = $ordersAugreother->sum('order_total');
        // End Augast

        // September
        $ordersSepEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumSepu = $ordersSepEmail->sum('order_total');

        $ordersSepwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumSepu = $ordersSepwalking->sum('order_total');

        $ordersSeponline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumSepu = $ordersSeponline->sum('order_total');

        $ordersSepreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumSepu = $ordersSepreferral->sum('order_total');

        $ordersSepreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 9 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumSepu = $ordersSepreother->sum('order_total');
        // End September

        // October
        $ordersOctEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumOctu = $ordersOctEmail->sum('order_total');

        $ordersOctwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumOctu = $ordersOctwalking->sum('order_total');

        $ordersOctonline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumOctu = $ordersOctonline->sum('order_total');

        $ordersOctreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumOctu = $ordersOctreferral->sum('order_total');

        $ordersOctreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 10 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumOctu = $ordersOctreother->sum('order_total');
        // End October

        // November
        $ordersNovEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumNovu = $ordersNovEmail->sum('order_total');

        $ordersNovwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumNovu = $ordersNovwalking->sum('order_total');

        $ordersNovonline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumNovu = $ordersNovonline->sum('order_total');

        $ordersNovreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumNovu = $ordersNovreferral->sum('order_total');

        $ordersNovreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 11 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumNovu = $ordersNovreother->sum('order_total');
        // End November

        // December
        $ordersDecEmail = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 1;
        });

        $orderEmailSumDecu = $ordersDecEmail->sum('order_total');

        $ordersDecwalking = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 2;
        });

        $orderwalkingSumDecu = $ordersDecwalking->sum('order_total');

        $ordersDeconline = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 3;
        });

        $orderonlineSumDecu = $ordersDeconline->sum('order_total');

        $ordersDecreferral = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 6;
        });

        $orderreferralSumDecu = $ordersDecreferral->sum('order_total');

        $ordersDecreother = $orders1->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear && $order->created_at->month == 12 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
        });

        $orderreotherSumDecu = $ordersDecreother->sum('order_total');
        // End December

        //End For bar chart

        return response()->json([
            'orderEmailSumJanu' => $orderEmailSumJanu,
            'orderwalkingSumJanu' => $orderwalkingSumJanu,
            'orderreferralSumJanu' => $orderreferralSumJanu,
            'orderreotherSumJanu' => $orderreotherSumJanu,
            'orderonlineSumJanu' => $orderonlineSumJanu,
            'orderEmailSumFebu' => $orderEmailSumFebu,
            'orderwalkingSumFebu' => $orderwalkingSumFebu,
            'orderreferralSumFebu' => $orderreferralSumFebu,
            'orderreotherSumFebu' => $orderreotherSumFebu,
            'orderonlineSumFebu' => $orderonlineSumFebu,
            'orderEmailSumMarchu' => $orderEmailSumMarchu,
            'orderwalkingSumMarchu' => $orderwalkingSumMarchu,
            'orderreferralSumMarchu' => $orderreferralSumMarchu,
            'orderreotherSumMarchu' => $orderreotherSumMarchu,
            'orderonlineSumMarchu' => $orderonlineSumMarchu,
            'orderEmailSumApru' => $orderEmailSumApru,
            'orderwalkingSumApru' => $orderwalkingSumApru,
            'orderreferralSumApru' => $orderreferralSumApru,
            'orderreotherSumApru' => $orderreotherSumApru,
            'orderonlineSumApru' => $orderonlineSumApru,
            'orderEmailSumMayu' => $orderEmailSumMayu,
            'orderwalkingSumMayu' => $orderwalkingSumMayu,
            'orderreferralSumMayu' => $orderreferralSumMayu,
            'orderreotherSumMayu' => $orderreotherSumMayu,
            'orderonlineSumMayu' => $orderonlineSumMayu,
            'orderEmailSumJunu' => $orderEmailSumJunu,
            'orderwalkingSumJunu' => $orderwalkingSumJunu,
            'orderreferralSumJunu' => $orderreferralSumJunu,
            'orderreotherSumJunu' => $orderreotherSumJunu,
            'orderonlineSumJunu' => $orderonlineSumJunu,
            'orderEmailSumJulu' => $orderEmailSumJulu,
            'orderwalkingSumJulu' => $orderwalkingSumJulu,
            'orderreferralSumJulu' => $orderreferralSumJulu,
            'orderreotherSumJulu' => $orderreotherSumJulu,
            'orderonlineSumJulu' => $orderonlineSumJulu,
            'orderEmailSumAugu' => $orderEmailSumAugu,
            'orderwalkingSumAugu' => $orderwalkingSumAugu,
            'orderreferralSumAugu' => $orderreferralSumAugu,
            'orderreotherSumAugu' => $orderreotherSumAugu,
            'orderonlineSumAugu' => $orderonlineSumAugu,
            'orderEmailSumSepu' => $orderEmailSumSepu,
            'orderwalkingSumSepu' => $orderwalkingSumSepu,
            'orderreferralSumSepu' => $orderreferralSumSepu,
            'orderreotherSumSepu' => $orderreotherSumSepu,
            'orderonlineSumSepu' => $orderonlineSumSepu,
            'orderEmailSumOctu' => $orderEmailSumOctu,
            'orderwalkingSumOctu' => $orderwalkingSumOctu,
            'orderreferralSumOctu' => $orderreferralSumOctu,
            'orderreotherSumOctu' => $orderreotherSumOctu,
            'orderonlineSumOctu' => $orderonlineSumOctu,
            'orderEmailSumNovu' => $orderEmailSumNovu,
            'orderwalkingSumNovu' => $orderwalkingSumNovu,
            'orderreferralSumNovu' => $orderreferralSumNovu,
            'orderreotherSumNovu' => $orderreotherSumNovu,
            'orderonlineSumNovu' => $orderonlineSumNovu,
            'orderEmailSumDecu' => $orderEmailSumDecu,
            'orderwalkingSumDecu' => $orderwalkingSumDecu,
            'orderreferralSumDecu' => $orderreferralSumDecu,
            'orderreotherSumDecu' => $orderreotherSumDecu,
            'orderonlineSumDecu' => $orderonlineSumDecu
        ]);
    }

    public function filterTotalOrders(Request $request)
    {

        $startDate = Carbon::createFromFormat('Y-m-d', $request->input('startDate'))->format('m/d/Y');
        $endDate = Carbon::createFromFormat('Y-m-d', $request->input('endDate'))->format('m/d/Y');
        $filterFactory = $request->input('filterFactory');
        $orderStatus = $request->input('orderStatus');
        $catagoryOption = $request->input('catagoryOption');


        $startDate1 = $request->input('startDate');
        $endDate1 = $request->input('endDate');

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }

        // factory filter
        if ($filterFactory == 'all') {
            if ($request->fct) {
                $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                    $query->where('id', $request->fct);
                });
            }
        } else {

            if ($filterFactory) {
                $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($filterFactory) {
                    $query->where('id', $filterFactory);
                });
            }
        }

        // status filter
        if ($orderStatus == 'all') {
            if ($request->sts) {
                $orderQuery->where('order_status_id', $request->sts);
            }
        } else {
            if ($orderStatus) {
                $orderQuery->where('order_status_id', $orderStatus);
            }
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }

        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->whereBetween('created_at', [$startDate1, $endDate1])->orderBy('id', 'DESC')->get();

        if ($catagoryOption) {
            $orders = $orders->filter(function ($order) use ($catagoryOption) {
                return $order->organizationDetails->lead_source == $catagoryOption;
            });
            // Convert the filtered collection to an array and reset the keys
            $orders = $orders->values()->all();
        }

        $orderTotalCount = $orders->count();
        $orderStatusId1Count = $orders->where('order_status_id', 1)->count();
        $orderStatusId3Count = $orders->where('order_status_id', 3)->count();
        $orderStatusId4Count = $orders->where('order_status_id', 4)->count();
        $orderStatusId7Count = $orders->where('order_status_id', 7)->count();

        return response()->json([
            'startDate' => $startDate,
            'orders' => $orders,
            'orderTotalCount' => $orderTotalCount,
            'orderStatusId1Count' => $orderStatusId1Count,
            'orderStatusId3Count' => $orderStatusId3Count,
            'orderStatusId4Count' => $orderStatusId4Count,
            'orderStatusId7Count' => $orderStatusId7Count
        ]);
    }

    public function orderSearchOrder(Request $request)
    {
        $searchValue = $request->input('searchValue');

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        $orderQuery->where(function ($query) use ($searchValue) {
            $query->whereHas('organizationDetails', function ($query) use ($searchValue) {
                $query->where('organization_name', 'LIKE', '%' . $searchValue . '%');
            });
            $query->orWhere('order_no', 'LIKE', '%' . $searchValue . '%');
        });

        // factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }
        // status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }

        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

        $orderTotalCount = $orders->count();
        $orderStatusId1Count = $orders->where('order_status_id', 1)->count();
        $orderStatusId3Count = $orders->where('order_status_id', 3)->count();
        $orderStatusId4Count = $orders->where('order_status_id', 4)->count();
        $orderStatusId7Count = $orders->where('order_status_id', 7)->count();

        return response()->json([
            'searchValue' => $searchValue,
            'orders' => $orders,
            'orderTotalCount' => $orderTotalCount,
            'orderStatusId1Count' => $orderStatusId1Count,
            'orderStatusId3Count' => $orderStatusId3Count,
            'orderStatusId4Count' => $orderStatusId4Count,
            'orderStatusId7Count' => $orderStatusId7Count
        ]);
    }

    public function dashboardPayment(Request $request)
    {

        $startDate = $request->input('startDatePayment');
        $endDate = $request->input('endDatePayment');
        $paymentType = $request->input('paymentType');
        $SelectedPaymentStatus = $request->input('paymentStatus');


        $onlinePayments = PaymentLog::where('response_code', '1')
            ->whereBetween('created_at', [$startDate, $endDate])
            ->get();


        $checkPayments = CheckPayment::whereBetween('created_at', [$startDate, $endDate])->get();

        $venmoPayments = VenmoPayment::whereBetween('created_at', [$startDate, $endDate])->get();

        $paypalPayments = PaypalPayment::whereBetween('created_at', [$startDate, $endDate])->get();

        $TrasnsactionsArray = [];


        foreach ($onlinePayments as $onlinePayment) {
            if ($paymentType === 'Online' || $paymentType === 'all') {
                $orderPaymentsArray = [];

                $orderDetails = Order::where('id', $onlinePayment->order_id)->with('organizationDetails')->get();
                $orderNo = $orderDetails[0]->order_no;
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $onlinePayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $onlinePayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $paymentStatus = "Partial";
                } else {
                    $paymentStatus = "Paid";
                }

                $cardPaymentRecords = PaymentLog::where('order_id', $onlinePayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $onlinePayment->order_id)->where('is_approved', '1')->get();

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => 'N/A', 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }


                $payedAmount = number_format($payment, 2);

                if ($SelectedPaymentStatus === $paymentStatus || $SelectedPaymentStatus === 'all') {

                    $TrasnsactionsArray[] = array(
                        'Order' => $onlinePayment->order_id,
                        'OrderNo' => $orderNo,
                        'PaymentType' => 'Online',
                        'TeamName' => $organization_name,
                        'NameonCard' => $onlinePayment->name_on_card,
                        'checkStatus' => 'Approved',
                        'Amount' => $onlinePayment->amount,
                        'OrderStatus' => $paymentStatus,
                        'TransactionID' => $onlinePayment->transaction_id,
                        'PaymentDate' => $onlinePayment->created_at,
                        'OrderPayments' => json_encode($orderPaymentsArray),
                        'OrderTotal' => $orderDetails[0]->order_total,
                        'OpenDate' => $orderDetails[0]->open_date,
                        'DueDate' => $orderDetails[0]->due_date,
                        'payedAmount' => $payedAmount
                    );
                }
            }
        }

        foreach ($checkPayments as $checkPayment) {
            if ($paymentType === 'Check' || $paymentType === 'all') {
                $orderPaymentsArray = [];
                //return $checkPayment->order_id;
                $orderDetails = Order::where('id', $checkPayment->order_id)->with('organizationDetails')->get();
                $orderNo = $orderDetails[0]->order_no;
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $checkPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $checkPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $paymentStatus = "Partial";
                } else {
                    $paymentStatus = "Paid";
                }

                if ($checkPayment->is_approved == "1") {
                    $checkStatus = "Approved";
                } elseif ($checkPayment->is_approved == "3") {
                    $checkStatus = "Rejected";
                } else {
                    $checkStatus = "Not Approved";
                }

                $cardPaymentRecords = PaymentLog::where('order_id', $checkPayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $checkPayment->order_id)->where('is_approved', '1')->get();

                $checkPaymentId = 'CHQ' . str_pad(($checkPayment->id), 6, "0", STR_PAD_LEFT);

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => $checkPaymentId, 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }


                $payedAmount = number_format($payment, 2);

                if ($SelectedPaymentStatus === $paymentStatus || $SelectedPaymentStatus === 'all') {
                    $TrasnsactionsArray[] = array(
                        'Order' => $checkPayment->order_id,
                        'OrderNo' => $orderNo,
                        'PaymentType' => 'Check',
                        'TeamName' => $organization_name,
                        'NameonCard' => 'N/A',
                        'checkStatus' => $checkStatus,
                        'Amount' => $checkPayment->amount,
                        'OrderStatus' => $paymentStatus,
                        'TransactionID' => $checkPaymentId,
                        'PaymentDate' => $checkPayment->created_at,
                        'checkFImage' => $checkPayment->check_front,
                        'checkBImage' => $checkPayment->check_back,
                        'OrderPayments' => json_encode($orderPaymentsArray),
                        'OrderTotal' => $orderDetails[0]->order_total,
                        'OpenDate' => $orderDetails[0]->open_date,
                        'DueDate' => $orderDetails[0]->due_date,
                        'payedAmount' => $payedAmount
                    );
                }
            }
        }

        foreach ($venmoPayments as $venmoPayment) {
            if ($paymentType === 'Venmo' || $paymentType === 'all') {
                $orderPaymentsArray = [];
                //return $venmoPayment->order_id;
                $orderDetails = Order::where('id', $venmoPayment->order_id)->with('organizationDetails')->get();
                $orderNo = $orderDetails[0]->order_no;
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $venmoPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $paymentStatus = "Partial";
                } else {
                    $paymentStatus = "Paid";
                }

                if ($venmoPayment->is_approved == "1") {
                    $checkStatus = "Approved";
                } elseif ($venmoPayment->is_approved == "3") {
                    $checkStatus = "Rejected";
                } else {
                    $checkStatus = "Not Approved";
                }

                $cardPaymentRecords = PaymentLog::where('order_id', $venmoPayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $venmoPayment->order_id)->where('is_approved', '1')->get();
                $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved', '1')->get();

                $venmoPaymentId = 'VNM' . str_pad(($venmoPayment->id), 6, "0", STR_PAD_LEFT);

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => 'N/A', 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }
                foreach ($venmoPaymentRecords as $venmoPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Venmo', 'NameonCard' => 'N/A', 'TransactionId' => $venmoPaymentId, 'Amount' => $venmoPaymentRecord->amount, 'PaymentDate' => $venmoPaymentRecord->created_at);
                }


                $payedAmount = number_format($payment, 2);

                if ($SelectedPaymentStatus === $paymentStatus || $SelectedPaymentStatus === 'all') {
                    $TrasnsactionsArray[] = array(
                        'Order' => $venmoPayment->order_id,
                        'OrderNo' => $orderNo,
                        'PaymentType' => 'Venmo',
                        'TeamName' => $organization_name,
                        'NameonCard' => 'N/A',
                        'checkStatus' => $checkStatus,
                        'Amount' => $venmoPayment->amount,
                        'OrderStatus' => $paymentStatus,
                        'TransactionID' => $venmoPaymentId,
                        'PaymentDate' => $venmoPayment->created_at,
                        'checkFImage' => $venmoPayment->venmo_receipt,
                        'OrderPayments' => json_encode($orderPaymentsArray),
                        'OrderTotal' => $orderDetails[0]->order_total,
                        'OpenDate' => $orderDetails[0]->open_date,
                        'DueDate' => $orderDetails[0]->due_date,
                        'payedAmount' => $payedAmount
                    );
                }
            }
        }

        foreach ($paypalPayments as $paypalPayment) {
            if ($paymentType === 'Paypal' || $paymentType === 'all') {
                $orderPaymentsArray = [];
                //return $paypalPayment->order_id;
                $orderDetails = Order::where('id', $paypalPayment->order_id)->with('organizationDetails')->get();
                $orderNo = $orderDetails[0]->order_no;
                $organization_name =  $orderDetails[0]->organizationDetails['organization_name'];
                $cardPaymenttot = PaymentLog::where('order_id', $paypalPayment->order_id)->sum('amount');
                $checkPaymenttot = CheckPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
                $venmoPaymenttot = VenmoPayment::where('order_id', $venmoPayment->order_id)->sum('amount');
                $paypalPaymenttot = PaypalPayment::where('order_id', $paypalPayment->order_id)->sum('amount');
                $payment = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot;
                if ($payment == 0) {
                    $paymentStatus = "Pending";
                } else if ($payment < $orderDetails[0]->order_total && $payment > 0) {
                    $paymentStatus = "Partial";
                } else {
                    $paymentStatus = "Paid";
                }

                if ($paypalPayment->is_approved == "1") {
                    $checkStatus = "Approved";
                } elseif ($paypalPayment->is_approved == "3") {
                    $checkStatus = "Rejected";
                } else {
                    $checkStatus = "Not Approved";
                }

                $cardPaymentRecords = PaymentLog::where('order_id', $paypalPayment->order_id)->where('response_code', '1')->get();
                $checkPaymentRecords = CheckPayment::where('order_id', $paypalPayment->order_id)->where('is_approved', '1')->get();
                $venmoPaymentRecords = VenmoPayment::where('order_id', $venmoPayment->order_id)->where('is_approved', '1')->get();
                $paypalPaymentRecords = PaypalPayment::where('order_id', $paypalPayment->order_id)->where('is_approved', '1')->get();

                $paypalPaymentId = 'VNM' . str_pad(($paypalPayment->id), 6, "0", STR_PAD_LEFT);

                foreach ($cardPaymentRecords as $cardPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Online', 'NameonCard' => $cardPaymentRecord->name_on_card, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'PaymentDate' => $cardPaymentRecord->created_at);
                }
                foreach ($checkPaymentRecords as $checkPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Check', 'NameonCard' => 'N/A', 'TransactionId' => $checkPaymentId, 'Amount' => $checkPaymentRecord->amount, 'PaymentDate' => $checkPaymentRecord->created_at);
                }
                foreach ($venmoPaymentRecords as $venmoPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Venmo', 'NameonCard' => 'N/A', 'TransactionId' => $venmoPaymentId, 'Amount' => $venmoPaymentRecord->amount, 'PaymentDate' => $venmoPaymentRecord->created_at);
                }
                foreach ($paypalPaymentRecords as $paypalPaymentRecord) {
                    $orderPaymentsArray[] = array('Method' => 'Paypal', 'NameonCard' => 'N/A', 'TransactionId' => $paypalPaymentId, 'Amount' => $paypalPaymentRecord->amount, 'PaymentDate' => $paypalPaymentRecord->created_at);
                }

                $payedAmount = number_format($payment, 2);

                if ($SelectedPaymentStatus === $paymentStatus || $SelectedPaymentStatus === 'all') {
                    $TrasnsactionsArray[] = array(
                        'Order' => $paypalPayment->order_id,
                        'OrderNo' => $orderNo,
                        'PaymentType' => 'Paypal',
                        'TeamName' => $organization_name,
                        'NameonCard' => 'N/A',
                        'checkStatus' => $checkStatus,
                        'Amount' => $paypalPayment->amount,
                        'OrderStatus' => $paymentStatus,
                        'TransactionID' => $paypalPaymentId,
                        'PaymentDate' => $paypalPayment->created_at,
                        'checkFImage' => $paypalPayment->paypal_receipt,
                        'OrderPayments' => json_encode($orderPaymentsArray),
                        'OrderTotal' => $orderDetails[0]->order_total,
                        'OpenDate' => $orderDetails[0]->open_date,
                        'DueDate' => $orderDetails[0]->due_date,
                        'payedAmount' => $payedAmount
                    );
                }
            }
        }


        usort($TrasnsactionsArray, function ($a, $b) {
            return $b['Order'] - $a['Order'];
        });

        return response()->json(['TrasnsactionsArray' => $TrasnsactionsArray]);
    }

    public function getPaymentDetails($order)
    {
        $cardPaymenttot = PaymentLog::where('order_id', $order->id)->sum('amount');
        $checkPaymenttot = CheckPayment::where('order_id', $order->id)->sum('amount');
        $venmoPaymenttot = VenmoPayment::where('order_id', $order->id)->sum('amount');
        $paypalPaymenttot = PaypalPayment::where('order_id', $order->id)->sum('amount');

        $payment = number_format($cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot, 2);
        $paymentCal = $cardPaymenttot + $checkPaymenttot + $venmoPaymenttot + $paypalPaymenttot;
        $orderTotal = number_format($order->order_total, 2);

        $paymentStatus = 'Pending';

        if ($payment == 0) {
            $paymentStatus = "Pending";
        } else if ($payment < $orderTotal && $payment > 0) {
            $paymentStatus = "Partial";
        } else {
            $paymentStatus = "Paid";
        }

        return [
            'payment' => $payment,
            'paymentCal' => $paymentCal,
            'paymentStatus' => $paymentStatus,
            'payedAmount' => $payment,
            2,
        ];
    }

    public function getApprovalStatus($payments)
    {
        foreach ($payments as $payment) {
            if ($payment->is_approved == 1) {
                return 'Approved';
            } elseif ($payment->is_approved == 0) {
                return 'Rejected';
            }
        }

        return 'Not Approved';
    }


    public function dashboardInvoice(Request $request)
    {

        $startDate = $request->input('startDateInvoice');
        $endDate = $request->input('endDateInvoice');
        $paymentType = $request->input('invoicePaymentType');
        $SelectedPaymentStatus = $request->input('invoicePaymentStatus');

        $orderDetails = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
            ->where('active', 1)->where('order_total', '!=', 0)->whereBetween('created_at', [$startDate, $endDate])->get();

        // Filter orders based on payment type
        if ($paymentType != 'all') {
            $filteredOrders = $this->filterOrdersByPaymentType($orderDetails, $paymentType);
        } else {
            $filteredOrders = $orderDetails;
        }

        if ($SelectedPaymentStatus != 'all') {
            $filteredOrders = collect($filteredOrders)->filter(function ($order) use ($SelectedPaymentStatus) {
                $paymentDetails = $this->getPaymentDetails($order);
                return $paymentDetails['paymentStatus'] == $SelectedPaymentStatus;
            })->values();
        }



        $combinedDetails = [];

        foreach ($filteredOrders as $order) {
            $paymentDetails = $this->getPaymentDetails($order);

            $cardPayment = PaymentLog::where('order_id', $order->id)->get();
            $checkPayment = CheckPayment::where('order_id', $order->id)->get();
            $venmoPayment = VenmoPayment::where('order_id', $order->id)->get();
            $paypalPayment = PaypalPayment::where('order_id', $order->id)->get();

            $paymentTypes = [];

            // Check and add payment types to the array
            if (!$cardPayment->isEmpty()) {
                $paymentTypes[] = 'Card';
            }

            if (!$checkPayment->isEmpty()) {
                $paymentTypes[] = 'Check';
            }

            if (!$venmoPayment->isEmpty()) {
                $paymentTypes[] = 'Venmo';
            }

            if (!$paypalPayment->isEmpty()) {
                $paymentTypes[] = 'Paypal';
            }

            $details = [
                'order' => $order,
                'organization' => $order->organizationDetails,
                'user' => $order->userDetails,
                'contact' => $order->contactDetails,
                'status' => $order->statusDetails,
                'team_store' => $order->teamStoreDetails,
                'payment' => $paymentDetails['payment'],
                'paymentStatus' => $paymentDetails['paymentStatus'],
                'payedAmount' => $paymentDetails['payedAmount'],
                'paymentCal' => $paymentDetails['paymentCal'],
                'paymentTypes' => $paymentTypes,
            ];

            if (!$cardPayment->isEmpty()) {
                $details['paymentApproval'] = 'Approved';
            }

            if (!$checkPayment->isEmpty()) {
                $details['paymentApproval'] = $this->getApprovalStatus($checkPayment);
            }

            if (!$venmoPayment->isEmpty()) {
                $details['paymentApproval'] = $this->getApprovalStatus($venmoPayment);
            }

            if (!$paypalPayment->isEmpty()) {
                $details['paymentApproval'] = $this->getApprovalStatus($paypalPayment);
            }

            $combinedDetails[] = [
                'order_id' => $order->id,
                'details' => $details,
            ];
        }

        return response()->json(['startDate' => $startDate, 'combinedDetails' => $combinedDetails]);
    }

    private function filterOrdersByPaymentType($orderDetails, $paymentType)
    {
        $filteredOrders = [];

        foreach ($orderDetails as $order) {
            $cardPayment = PaymentLog::where('order_id', $order->id)->get();
            $checkPayment = CheckPayment::where('order_id', $order->id)->get();
            $venmoPayment = VenmoPayment::where('order_id', $order->id)->get();
            $paypalPayment = PaypalPayment::where('order_id', $order->id)->get();

            if ($paymentType == 'Check' && !$checkPayment->isEmpty()) {
                $filteredOrders[] = $order;
            } else if ($paymentType == 'Online' && !$cardPayment->isEmpty()) {
                $filteredOrders[] = $order;
            } else if ($paymentType == 'Venmo' && !$venmoPayment->isEmpty()) {
                $filteredOrders[] = $order;
            } else if ($paymentType == 'Paypal' && !$paypalPayment->isEmpty()) {
                $filteredOrders[] = $order;
            }
        }

        return $filteredOrders;
    }

    public function filterActivities(Request $request)
    {
        $request->validate(['date' => 'nullable|date_format:Y-m-d']);
        $userId = $request->input('userId');


        $today = $request->input('date') ?: Carbon::today()->toDateString();

        $activity = Activity::where('assigned_to', $userId)
            ->where('is_done', 0)
            ->with('organizationDetails')
            ->whereDate('start_date', $today)
            ->get();

        return response()->json(['activity' => $activity]);
    }

    public function changeFlag(Request $request)
    {
        $order = Order::find($request->orderId);
        $order->flag = '#' . $request->color_code;
        $order->update();

        $log = new ActionLog();
        $log->user_id = Auth::user()->id;
        $log->action = 'OrderID : ' . $request->orderId . ' - Changed Order Flaged';
        $log->save();

        return json_encode('Change order flag successfully!');
    }

    public function filterOrdersFactoryDashboard(Request $request)
    {

        $orderStatus = $request->input('orderStatus');

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }
        // factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }

        // status filter
        if ($orderStatus == 'all') {
            if ($request->sts) {
                $orderQuery->where('order_status_id', $request->sts);
            }
        } else {
            if ($orderStatus) {
                $orderQuery->where('order_status_id', $orderStatus);
            }
        }

        // status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }


        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

        return response()->json(['orders' => $orders]);
    }

    public function newOrdersFactoryDashboard(Request $request)
    {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Organization name search
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }

        // Factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }

        // Status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }

        // Get the initial orders
        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->orderBy('id', 'DESC')
            ->get();

        // Clone the initial query and apply specific conditions for newOrders
        $newOrdersQuery = clone $orderQuery;
        $newOrders = $newOrdersQuery->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->where('order_status_id', 1)
            ->orderByRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') ASC")
            ->get();

        return response()->json(['newOrders' => $newOrders]);
    }

    public function productionOrdersFactoryDashboard(Request $request)
    {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Organization name search
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }

        // Factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }

        // Status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }

        // Get the initial orders
        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->orderBy('id', 'DESC')
            ->get();

        // Clone the initial query and apply specific conditions for newOrders
        $newOrdersQuery = clone $orderQuery;
        $productionOrders = $newOrdersQuery->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->where('order_status_id', 3)
            ->orderByRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') ASC")
            ->get();

        return response()->json(['productionOrders' => $productionOrders]);
    }

    public function fulfiledOrdersFactoryDashboard(Request $request)
    {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Organization name search
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }

        // Factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }

        // Status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }

        // Get the initial orders
        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->orderBy('id', 'DESC')
            ->get();

        // Clone the initial query and apply specific conditions for newOrders
        $newOrdersQuery = clone $orderQuery;
        $fulfiledOrders = $newOrdersQuery->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->where('order_status_id', 4)
            ->orderByRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') ASC")
            ->get();

        return response()->json(['fulfiledOrders' => $fulfiledOrders]);
    }
    public function getupcomingorderdetails(Request $request)
    {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;
        $orderId = $request->orderId;

        // Fetch the order details using the provided order ID
        $orderDetails = OrderItem::with(['subProduct', 'orderItemAttributes.attribute'])
            ->where('order_id', $orderId)
            ->whereIn('factory_id', $factoryIds)
            ->get();
        // dd($orderDetails);
        // Check if order details were found
        if (!$orderDetails) {
            return response()->json(['error' => 'Order details not found'], 404);
        }

        // Return the order details as JSON
        return response()->json(['orderDetails' => $orderDetails], 200);
    }
    public function upcomingOrdersGet(Request $request)
    {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')->where('upcoming_status', 1);

        $orderQuery->whereNotIn('order_status_id', [3, 4, 5, 6, 7]);



        $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
            $qry->with('factoryDetails')
                ->whereIn('factory_id', $factoryIds);
        }]);
        $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
            $qr->whereIn('factory_id', $factoryIds);
        });

        $orders = $orderQuery->where('active', 1)
            ->orderBy('id', 'DESC')
            ->get();

        $productionOrders = $orders;

        $sippingDetails = ShippingOrderDetails::orderBy('order_id', 'DESC')
            ->where('tracking_no', '!=', null)
            ->get();

        $groupedDetails = $sippingDetails->groupBy('order_id');

        $commonOrders = $productionOrders->filter(function ($order) use ($groupedDetails) {
            return $groupedDetails->has($order->id);
        });

        $commonOrdersArray = $commonOrders->values()->all();

        return response()->json(['commonOrdersArray' => $productionOrders]);
    }


    public function PendingShipOrdersFactoryDashboard(Request $request)
    {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Organization name search
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }

        // Factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }

        // Status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }

        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->orderBy('id', 'DESC')
            ->get();

        $productionOrders = $orders->filter(function ($order) {
            return $order->order_status_id == 3;
        });

        $sippingDetails = ShippingOrderDetails::orderBy('order_id', 'DESC')
            ->where('tracking_no', '!=', null)
            ->get();

        $groupedDetails = $sippingDetails->groupBy('order_id');

        $commonOrders = $productionOrders->filter(function ($order) use ($groupedDetails) {
            return $groupedDetails->has($order->id);
        });

        $commonOrdersArray = $commonOrders->values()->all();

        return response()->json(['commonOrdersArray' => $commonOrdersArray]);
    }


    public function urgentOrdersFactoryDashboard(Request $request)
    {
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }
        // factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }
        // status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }


        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

        $urgentOrders = $orderQuery
            ->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->where('is_urgent', 1)
            ->where('order_status_id', '!=', 4)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json(['urgentOrders' => $urgentOrders]);
    }

    public function underContruction()
    {
        return view('pages.settings.under_contruction.index');
    }

    public function getMonthlyTotals(Request $request)
    {
        $year = $request->input('year');

        $monthlyTotals = Order::selectRaw('MONTH(created_at) as month, ROUND(SUM(order_total), 2) as total')
            ->whereYear('created_at', $year)
            ->groupBy(DB::raw('MONTH(created_at)'))
            ->get();

        $data = $monthlyTotals->pluck('total')->toArray();

        return response()->json($data);
    }

    public function userGroupFactories()
    {
        $user = Auth::user();
        $factoryIds = [];
        if ($user->hasRole([1, 2, 3, 4, 10])) {
            $oderSearch = 'all';
        } else {
            $oderSearch = 'factory';
            foreach ($user->roles as $userRole) {
                if ($userRole->id == 5) {     // PBS Factory
                    $factoryIds[] = 2;  // PBS
                }
                if ($userRole->id == 6) {     // WDC Factory
                    $factoryIds[] = 1;  // WDC
                }
                if ($userRole->id == 7) {     // BII Factory
                    $factoryIds[] = 3;  // BII
                }
                if ($userRole->id == 8) {     // UET Factory
                    $factoryIds[] = 7;  // UET
                }
                if ($userRole->id == 11) {     // ZYS Factory
                    $factoryIds[] = 10;  // ZYS
                }
                if ($userRole->id == 12) {     // Test Factory
                    $factoryIds[] = 16;  // Test
                }
            }
        }

        $this->oderSearch = $oderSearch;
        $this->factoryIds = $factoryIds;

        return $this;
    }

    public function filter_search_data(Request $request)
    {

        $input_text = $request->input('input_text');

        $activities = Activity::where('activity_subject', 'like', '%' . $input_text . '%')->get();

        $organizations = Organization::where('organization_name', 'like', '%' . $input_text . '%')->orWhere('website', 'like', '%' . $input_text . '%')->get();

        $contacts = Contact::where('first_name', 'like', '%' . $input_text . '%')->orWhere('last_name', 'like', '%' . $input_text . '%')->orWhere('email', 'like', '%' . $input_text . '%')->get();



        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        $orderQuery->where(function ($query) use ($input_text) {
            $query->whereHas('organizationDetails', function ($query) use ($input_text) {
                $query->where('organization_name', 'LIKE', '%' . $input_text . '%');
            });
            $query->orWhere('order_no', 'LIKE', '%' . $input_text . '%');
        });

        // factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }
        // status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->where('order_status_id', 3);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }

        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();


        return json_encode([$activities, $organizations, $contacts, $orders, $input_text]);
    }

    public function getActivitiesByDate($user_id, $due_date)
    {
        $activities = Activity::select('id', 'activity_subject', 'start_date')->where('assigned_to', $user_id)->whereDate('start_date', Carbon::createFromFormat('m-d-Y', $due_date)->format('Y-m-d'))->where('active', 1)->where('is_done', 0)->get();
        return json_encode($activities);
    }

    public function newOrdersRepDashboard(Request $request)
    {
        $userId = Auth::id();
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }
        // factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }
        // status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }


        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

        $urgentOrders = $orderQuery
            ->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('order_procesing_user_id', $userId);
            })
            ->where('order_status_id', 1)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json(['urgentOrders' => $urgentOrders]);
    }

    public function productionOrdersRepDashboard(Request $request)
    {
        $userId = Auth::id();
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }
        // factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }
        // status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }


        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

        $productionOrders = $orderQuery
            ->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('order_procesing_user_id', $userId);
            })
            ->where('order_status_id', 3)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json(['productionOrders' => $productionOrders]);
    }

    public function fulfiledOrdersRepDashboard(Request $request)
    {
        $userId = Auth::id();
        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }
        // factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }
        // status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }


        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

        $fulfiledOrders = $orderQuery
            ->whereNotIn('organization_id', $this->inventoryOrgIds)
            ->where('active', 1)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('order_procesing_user_id', $userId);
            })
            ->where('order_status_id', 4)
            ->orderBy('id', 'DESC')
            ->get();

        return response()->json(['fulfiledOrders' => $fulfiledOrders]);
    }

    public function PendingShipOrdersRepDashboard(Request $request)
    {

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails');

        $factoriesQuery = Factory::select('id', 'factory_code');

        // Orgnnization name serach
        if ($request->org) {
            $orderQuery->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('organization_name', 'LIKE', '%' . $request->org . '%');
                $query->whereNotIn('id', $this->inventoryOrgIds);
            });
            $orderQuery->orWhere('order_no', 'LIKE', '%' . $request->org . '%');
        }
        // factory filter
        if ($request->fct) {
            $orderQuery->whereHas('orderItems.factoryDetails', function ($query) use ($request) {
                $query->where('id', $request->fct);
            });
        }
        // status filter
        if ($request->sts) {
            $orderQuery->where('order_status_id', $request->sts);
        }

        if ($oderSearch == 'factory') {
            $orderQuery->with(['orderItems' => function ($qry) use ($factoryIds) {
                $qry->with('factoryDetails')
                    ->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            }]);
            $orderQuery->whereHas('orderItems', function ($qr) use ($factoryIds) {
                $qr->whereIn('factory_id', $factoryIds)
                    ->whereIn('order_status_id', [3, 4, 8]);
            });
            $factoriesQuery->whereIn('id', $factoryIds);
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }


        $orders = $orderQuery->whereNotIn('organization_id', $this->inventoryOrgIds)->where('active', 1)->orderBy('id', 'DESC')->get();

        $userId = Auth::id();
        $startOfWeek = Carbon::now()->startOfWeek()->format('Y-m-d');
        $endOfWeek = Carbon::now()->endOfWeek()->format('Y-m-d');

        $commonOrdersArray = $orderQuery
            ->where('active', 1)
            ->where(function ($query) use ($userId) {
                $query->where('user_id', $userId)
                    ->orWhere('order_procesing_user_id', $userId);
            })
            ->whereRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') BETWEEN ? AND ?", [$startOfWeek, $endOfWeek])
            ->get();


        return response()->json(['commonOrdersArray' => $commonOrdersArray]);
    }

    public function emailLoadFromDashboard($messageId)
    {

        session(['messageId' => $messageId]);

        return redirect()->route('indexemail', ['messageId' => $messageId]);
    }

    public function clearSession()
    {

        if (session()->has('messageId') && !empty(session('messageId'))) {

            Session::forget('messageId');
            return response()->json(['success' => 'Session cleared'], 200);
        }

        return response()->json(['error' => 'No messageId provided'], 400);
    }

    public function createMeeting(Request $request)
    {

        $start_date = Carbon::parse(str_replace('-', '/', $request->start_date))->format('Y-m-d');
        if (empty($request->start_time)) {
            $start_time = Carbon::parse('12:00 AM')->format('H:i:s');
        } else {
            $start_time = Carbon::parse($request->start_time)->format('H:i:s');
        }

        if ($request->is_done == 'on') {
            $is_done = 1;
        } else {
            $is_done = 0;
        }

        $activity = new Activity();
        $activity->activity_subject = $request->activity_subject;
        $activity->activity_note = $request->activity_note;
        if (isset($request->priority)) {
            $activity->priority = $request->priority;
        }

        $activity->assigned_to = $request->activity_user_id;
        $activity->order_id = $request->activity_order_id;
        $activity->contact_id = $request->activity_contact_id;
        $activity->organization_id = $request->activity_organization_id;
        // $activity->due_date = $due_date;
        $activity->start_date = $start_date . ' ' . $start_time;
        $activity->created_by = Auth::user()->id;
        $activity->modified_by = Auth::user()->id;
        $activity->is_done = $is_done;
        $activity->activity_type = 2;
        $activity->save();

        // $notification = new Notification();
        // $notification->notification_title = 'New Meeting - '.$request->activity_subject;
        // $notification->notification_message = Auth::user()->name.' created a new meeting';
        // $notification->is_read = 0;
        // if(!($request->activity_user_id == Auth::user()->id)){

        //     $notification->user_id = $request->activity_user_id;
        // }
        // $notification->order_id = $request->activity_order_id;
        // $notification->save();

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_new_activity_meeting', [
            '{Activity_subject}' => $request->activity_subject,
            '{User_name}' => Auth::user()->name,
        ], [

            'order_id' => $request->activity_order_id,
            'user_id' => $request->activity_user_id,
        ]);

        return redirect()->back()->withSuccess('Meeting Saved Successfully!');
    }

    public function updateMeeting(Request $request)
    {
        // $due_date = Carbon::parse(str_replace('-', '/', $request->due_date))->format('Y-m-d');
        $start_date = Carbon::parse(str_replace('-', '/', $request->start_date))->format('Y-m-d');
        if (empty($request->start_time)) {
            $start_time = Carbon::parse('12:00 AM')->format('H:i:s');
        } else {
            $start_time = Carbon::parse($request->start_time)->format('H:i:s');
        }

        if ($request->is_done == 'on') {
            $is_done = 1;
        } else {
            $is_done = 0;
        }

        $activity = Activity::find($request->activity_id);
        $activity->activity_subject = $request->activity_subject;
        if (isset($request->priority)) {
            $activity->priority = $request->priority;
        }
        $activity->activity_note = $request->activity_note;
        $activity->assigned_to = $request->activity_user_id;
        $activity->order_id = $request->activity_order_id;
        $activity->contact_id = $request->activity_contact_id;
        $activity->organization_id = $request->activity_organization_id;
        // $activity->due_date = $due_date;
        $activity->start_date = $start_date . ' ' . $start_time;
        $activity->created_by = Auth::user()->id;
        $activity->modified_by = Auth::user()->id;
        $activity->is_done = $is_done;
        $activity->update();

        // $notification = new Notification();
        // $notification->notification_title = 'Meeting - '.$request->activity_subject;
        // $notification->notification_message = Auth::user()->name.' update meeting';
        // $notification->is_read = 0;
        // if(!($request->activity_user_id == Auth::user()->id)){

        //     $notification->user_id = $request->activity_user_id;
        // }
        // $notification->order_id = $request->activity_order_id;
        // $notification->save();

        $builder = new NotificationBuilderService();

        $builder->sendNotification('key_new_activity_meeting_update', [
            '{Activity_subject}' => $request->activity_subject,
            '{User_name}' => Auth::user()->name,
        ], [

            'order_id' => $request->activity_order_id,
            'user_id' => $request->activity_user_id,
        ]);

        $order_id = $request->activity_order_id;
        $contact_id = $request->activity_contact_id;
        $organization_id = $request->activity_organization_id;

        $to_do_available_org = $request->activity_organization_id;


        $is_todo_available = Activity::where('organization_id', $request->activity_organization_id)->where('is_done', 0)->where('active', 1)->whereNull('deleted_at')->exists();

        if ($request->is_done == 'on' && !$is_todo_available) {
            return redirect()->back()->with([
                'success' => 'Meeting Status Updated Successfully!',
                'order_id' => $order_id,
                'contact_id' => $contact_id,
                'organization_id' => $organization_id,
                'to_do_available_org' => $to_do_available_org
            ]);
        } else {
            return redirect()->back()->withSuccess('Meeting Updated Successfully!');
        }
    }

    public function getMeetingsByDate($user_id, $due_date)
    {
        $activities = Activity::select('id', 'activity_subject', 'start_date')
            ->where(function ($query) use ($user_id) {
                $query->where('assigned_to', $user_id)
                    ->orWhere('created_by', $user_id);
            })
            ->whereDate('start_date', Carbon::createFromFormat('m-d-Y', $due_date)->format('Y-m-d'))
            ->where('active', 1)
            ->where('activity_type', 2)
            ->where('is_done', 0)
            ->get();

        return json_encode($activities);
    }

    public function getChartData(Request $request)
    {
        $year = $request->year ?? now()->year;
        $userId = $request->user_id;
        $roleId = 3;
        $testOrganizationIdSet = $this->getTestOrgId();

        // --- Get active sales users ---
        $users = User::select('id', 'name')
            ->where('active', 1)
            ->whereJsonContains('role_id', (string) $roleId)
            ->whereNotIn('id', [1, 2, 5, 28, 38, 63, 81, 83, 84, 96, 97, 102, 106, 108, 113, 114])
            ->when($userId, fn($q) => $q->where('id', $userId))
            ->orderBy('name')
            ->get();

        // --- Base order query ---
        $ordersQuery = Order::where('active', 1)
            ->whereNotNull('production_date')
            ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->whereIn('order_status_id', [3, 4, 8])
            ->where('organization_id', '!=', 1377)
            ->whereRaw('YEAR(STR_TO_DATE(production_date, "%m/%d/%Y")) = ?', [$year]) // ✅ Year filter added
            ->with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails', 'orderItems');

        if ($userId) {
            $ordersQuery->where('user_id', $userId);
        }

        // --- 1️⃣ Chart data (aggregate totals per month) ---
        $ordersLinechart = (clone $ordersQuery)
            ->select(
                'user_id',
                DB::raw('MONTH(STR_TO_DATE(production_date, "%m/%d/%Y")) as month'),
                DB::raw('SUM(order_total) as total')
            )
            ->groupBy('user_id', 'month')
            ->orderBy('month')
            ->get();

        // --- 2️⃣ Full filtered orders for the same year ---
        $filteredOrders = $ordersQuery
            ->orderByRaw('STR_TO_DATE(production_date, "%m/%d/%Y") ASC')
            ->get();

        // --- 3️⃣ Prepare chart structure ---
        $chartData = [];
        foreach ($users as $user) {
            $monthlyTotals = array_fill(1, 12, 0);

            foreach ($ordersLinechart->where('user_id', $user->id) as $order) {
                if (!empty($order->month)) {
                    $monthlyTotals[$order->month] = round($order->total, 2);
                }
            }

            $chartData[] = [
                'user_id' => $user->id,
                'label'   => $user->name,
                'data'    => array_values($monthlyTotals),
                'total'   => array_sum($monthlyTotals),
            ];
        }

        $labels = ['Jan', 'Feb', 'Mar', 'Apr', 'May', 'Jun', 'Jul', 'Aug', 'Sep', 'Oct', 'Nov', 'Dec'];

        // --- Return JSON for AJAX ---
        return response()->json([
            'labels'    => $labels,
            'chartData' => $chartData,
            'orders'    => $filteredOrders,
        ]);
    }



    public function getAllPaymentsByOrderId($orderID)
    {

        $cardPaymentRecords = PaymentLog::where('order_id', $orderID)->where('response_code', '1')->get();
        $checkPaymentRecords = CheckPayment::where('order_id', $orderID)->get();
        $venmoPaymentRecords = VenmoPayment::where('order_id', $orderID)->get();
        $paypalPaymentRecords = PaypalPayment::where('order_id', $orderID)->get();
        $otherPaymentRecords = OtherPayment::where('order_id', $orderID)->get();
        $PoPaymentRecords = PurchaseorderReceipt::where('order_id', $orderID)->get();

        foreach ($cardPaymentRecords as $cardPaymentRecord) {

            $payment_status = $this->PaymentService->getPaymentStatus($cardPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            } else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $orderPaymentsArray[] = array('Method' => 'Card', 'id' => $cardPaymentRecord->id, 'NameonCard' => $cardPaymentRecord->name_on_card, 'paymentStatus' => $paymentStatus, 'is_approve' => 1, 'TransactionId' => $cardPaymentRecord->transaction_id, 'Amount' => $cardPaymentRecord->amount, 'ProcessingFee' => $ProcessingFee, 'total_payment' => $total_payment, 'balance_to_be_paid' => $balance_to_be_paid, 'PaymentDate' => $cardPaymentRecord->created_at);
        }
        foreach ($checkPaymentRecords as $checkPaymentRecord) {

            $payment_status = $this->PaymentService->getPaymentStatus($checkPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            } else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $checkPaymentId = 'CHQ' . str_pad(($checkPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method' => 'Check', 'id' => $checkPaymentRecord->id, 'NameonCard' => 'N/A', 'paymentStatus' => $paymentStatus, 'is_approve' => $checkPaymentRecord->is_approved, 'TransactionId' => $checkPaymentId, 'Amount' => $checkPaymentRecord->amount, 'ProcessingFee' => $ProcessingFee, 'total_payment' => $total_payment, 'balance_to_be_paid' => $balance_to_be_paid, 'PaymentDate' => $checkPaymentRecord->created_at);
        }
        foreach ($venmoPaymentRecords as $venmoPaymentRecord) {

            $payment_status = $this->PaymentService->getPaymentStatus($venmoPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            } else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $venmoPaymentId = 'VNM' . str_pad(($venmoPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method' => 'Venmo', 'id' => $venmoPaymentRecord->id, 'NameonCard' => 'N/A', 'paymentStatus' => $paymentStatus, 'is_approve' => $venmoPaymentRecord->is_approved, 'TransactionId' => $venmoPaymentId, 'Amount' => $venmoPaymentRecord->amount, 'ProcessingFee' => $ProcessingFee, 'total_payment' => $total_payment, 'balance_to_be_paid' => $balance_to_be_paid, 'PaymentDate' => $venmoPaymentRecord->created_at);
        }
        foreach ($paypalPaymentRecords as $paypalPaymentRecord) {

            $payment_status = $this->PaymentService->getPaymentStatus($paypalPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            } else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $paypalPaymentId = 'PAYPAL' . str_pad(($paypalPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method' => 'Paypal', 'id' => $paypalPaymentRecord->id, 'NameonCard' => 'N/A', 'paymentStatus' => $paymentStatus, 'is_approve' => $paypalPaymentRecord->is_approved, 'TransactionId' => $paypalPaymentId, 'Amount' => $paypalPaymentRecord->amount, 'ProcessingFee' => $ProcessingFee, 'total_payment' => $total_payment, 'balance_to_be_paid' => $balance_to_be_paid, 'PaymentDate' => $paypalPaymentRecord->created_at);
        }
        foreach ($otherPaymentRecords as $otherPaymentRecord) {

            $payment_status = $this->PaymentService->getPaymentStatus($otherPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            } else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $otherPaymentId = 'OTH' . str_pad(($otherPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method' => 'Other', 'id' => $otherPaymentRecord->id, 'NameonCard' => 'N/A', 'paymentStatus' => $paymentStatus, 'is_approve' => $otherPaymentRecord->is_approved, 'TransactionId' => $otherPaymentId, 'Amount' => $otherPaymentRecord->amount, 'ProcessingFee' => $ProcessingFee, 'total_payment' => $total_payment, 'balance_to_be_paid' => $balance_to_be_paid, 'PaymentDate' => $otherPaymentRecord->created_at);
        }
        foreach ($PoPaymentRecords as $PoPaymentRecord) {

            $payment_status = $this->PaymentService->getPaymentStatus($PoPaymentRecord->order_id);

            if ($payment_status['payment_status'] == 0) {
                $paymentStatus = "Pending";
            } else if ($payment_status['payment_status'] == 1) {
                $paymentStatus = "Partial";
            } else if ($payment_status['payment_status'] == 2) {
                $paymentStatus = "Paid";
            } else {
                $paymentStatus = "N/A";
            }

            $ProcessingFee = $payment_status['processing_fee'];
            $total_payment = $payment_status['total_payment'];
            $balance_to_be_paid = $payment_status['balance_to_be_paid'];

            $poPaymentId = 'PO' . str_pad(($PoPaymentRecord->id), 6, "0", STR_PAD_LEFT);
            $orderPaymentsArray[] = array('Method' => 'PO', 'id' => $PoPaymentRecord->id, 'NameonCard' => 'N/A', 'paymentStatus' => $paymentStatus, 'is_approve' => $PoPaymentRecord->is_approved, 'TransactionId' => $poPaymentId, 'Amount' => $PoPaymentRecord->amount, 'ProcessingFee' => $ProcessingFee, 'total_payment' => $total_payment, 'balance_to_be_paid' => $balance_to_be_paid, 'PaymentDate' => $PoPaymentRecord->created_at);
        }

        return $orderPaymentsArray;
    }

    public function transactionsDetails($id)
    {
        // Prefix එක ගන්න (අකුරු විතරයි)
        $prefix = strtoupper(preg_replace('/[^A-Z]/', '', $id));

        // Prefix remove කරලා ඉතුරු දාගන්න
        $numericPart = preg_replace('/^[A-Z]+/', '', $id);

        // Leading zeros remove කරන්න
        $realId = ltrim($numericPart, '0');
        $realId = $realId === '' ? 0 : (int)$realId;

        $record = null;
        $method = null;

        // ==== if/elseif version ====
        if ($prefix === 'PO') {
            $record = PurchaseorderReceipt::find($realId);
            $method = 'PO';
            $image = null;
        } elseif ($prefix === 'CHQ') {
            $record = CheckPayment::find($realId);
            $method = 'Check';
            $image = $record && $record->check_front
                ? asset($record->check_front)
                : null;
        } elseif ($prefix === 'VNM') {
            $record = VenmoPayment::find($realId);
            $method = 'Venmo';
            $image = $record && $record->venmo_receipt
                ? asset($record->venmo_receipt)
                : null;
        } elseif ($prefix === 'PAYPAL') {
            $record = PaypalPayment::find($realId);
            $method = 'Paypal';
            $image = $record && $record->paypal_receipt
                ? asset($record->paypal_receipt)
                : null;
        } elseif ($prefix === 'OTH') {
            $record = OtherPayment::find($realId);
            $method = 'Other';
            $image = null;
        } else {
            // Card payments (prefix නැතිව id විතරයි)
            $record = PaymentLog::where('transaction_id', $id)->first();
            $method = 'Card';
            $image = null;
            $realId = $record ? $record->id : 0;
        }

        if (!$record) {
            return response()->json(['error' => 'Transaction not found'], 404);
        }

        return response()->json([
            'TransactionId' => $id,
            'Method'        => $method,
            'RealId'        => $realId,
            'Amount'        => $record->amount,
            'image'         => $image,
        ]);
    }

    public function lineChartData(Request $request)
    {
        $dateInput = $request->input('date');

        try {
            // Parse "12 Sep" and add current year
            $parsedDate = \Carbon\Carbon::createFromFormat('d M', $dateInput);
            $parsedDate->year = now()->year;

            // Convert to "m/d/Y" to match database
            $formattedDate = $parsedDate->format('m/d/Y');
        } catch (\Exception $e) {
            // In case parsing fails, just use input as fallback
            $formattedDate = $dateInput;
        }

        $testOrganizationIdSet = $this->getTestOrgId();

        // Now query using the formatted date
        $orders = Order::where('production_date', $formattedDate)
            ->whereNotNull('production_date')
            ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->whereNotIn('order_status_id', [7])
            ->whereIn('order_status_id', [3, 4, 8])
            ->where('organization_id', '!=', 1377)
            ->where('active', 1)

            ->with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails', 'orderItems')
            ->get();


        // Render Blade partial view to HTML
        $html = view('pages.admin_dashboard.last_month_sales_modal', compact('orders'))->render();

        return response()->json(['html' => $html]);
    }

    public function salesMonthDetails(Request $request)
    {
        $year = $request->year;
        $monthName = $request->month;
        $userName = $request->user_name;

        // Convert month name (e.g., "Sep") to month number (e.g., 9)
        $monthNumber = date('m', strtotime($monthName));

        // Find user by name
        $user = User::where('name', $userName)->first();

        if (!$user) {
            return response()->json(['html' => '<p class="text-danger text-center">User not found</p>']);
        }

        // ✅ Get test organization IDs
        $testOrganizationIdSet = $this->getTestOrgId();

        // ✅ Build the main query
        $ordersQuery = Order::where('active', 1)
            ->whereNotNull('production_date')
            ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->whereIn('order_status_id', [3, 4, 8])
            ->where('organization_id', '!=', 1377)
            // ✅ Filter by year and month (production_date stored as m/d/Y string)
            ->whereRaw('YEAR(STR_TO_DATE(production_date, "%m/%d/%Y")) = ?', [$year])
            ->whereRaw('MONTH(STR_TO_DATE(production_date, "%m/%d/%Y")) = ?', [$monthNumber])
            // ✅ Filter by selected user
            ->where('user_id', $user->id)
            // ✅ Exclude internal teams
            ->whereHas('organizationDetails', function ($query) {
                $query->where('internal_team', 0);
            })
            // ✅ Load relations
            ->with([
                'organizationDetails',
                'userDetails',
                'contactDetails',
                'statusDetails',
                'teamStoreDetails',
                'orderItems'
            ]);

        // Get filtered data
        $orders = $ordersQuery->get();

        // ✅ Render modal Blade view
        $html = view('pages.admin_dashboard.sales_month_modal', compact('orders', 'monthName', 'year', 'user'))->render();

        return response()->json(['html' => $html]);
    }
    public function dashboardOverviewData(Request $request)
    {
        abort_unless($request->user()->hasRole('Super Admin Dashboard'), 403);
        $request->validate([
            'panel' => 'required|in:leads,samples,monthly,received,pending',
            'page' => 'nullable|integer|min:1', 'source' => 'nullable|integer',
            'month' => 'nullable|integer|between:1,12', 'search' => 'nullable|string|max:100',
            'start' => 'nullable|date_format:Y-m-d', 'end' => 'nullable|date_format:Y-m-d',
        ]);
        switch ($request->panel) {
            case 'leads': return $this->dashboardLeads($request);
            case 'samples': return $this->dashboardSamples($request);
            case 'monthly': return $this->dashboardMonthly($request);
            default: return $this->dashboardPayments($request);
        }
    }

    private function dashboardLeads(Request $request)
    {
        $start = now()->startOfYear()->addMonths(((int) ($request->month ?: now()->month)) - 1);
        $page = Organization::with(['userDetails:id,name', 'leadSourceDetails:id,lead_source_name'])
            ->where('active', 1)->whereDoesntHave('orders')
            ->where('created_at', '>=', $start)->where('created_at', '<', $start->copy()->addMonth())
            ->when($request->filled('source'), fn ($query) => $query->where('lead_source', $request->source))
            ->latest('id')->paginate(5, ['id', 'organization_name', 'user_id', 'lead_source']);
        return response()->json([
            'data' => $page->getCollection()->map(fn ($lead) => [
                'organization' => $lead->organization_name, 'owner' => optional($lead->userDetails)->name ?: '—',
                'source' => optional($lead->leadSourceDetails)->lead_source_name ?: '—',
            ]), 'page' => $page->currentPage(), 'pages' => $page->lastPage(), 'total' => $page->total(),
        ]);
    }

    private function dashboardSamples(Request $request)
    {
        $start = $request->input('start', now()->startOfMonth()->toDateString());
        $end = $request->input('end', now()->endOfMonth()->toDateString());
        $query = OrganizationSampleShipment::with('organization:id,organization_name')
            ->whereHas('organization', fn ($query) => $query->where('active', 1));
        if ($start) $query->where('received_date', '>=', $start);
        if ($end) $query->where('received_date', '<', Carbon::parse($end)->addDay()->toDateString());
        $page = $query->orderByDesc('received_date')->orderByDesc('id')->paginate(5);
        $productIds = $page->getCollection()->flatMap(fn ($shipment) => collect($shipment->products ?: [])->pluck('product_id'))->filter()->unique();
        $names = SubProduct::whereIn('id', $productIds)->pluck('product_name', 'id');
        $sizes = \App\Models\Size::whereIn('id', $page->getCollection()->flatMap(fn ($shipment) => collect($shipment->products ?: [])->pluck('size_id'))->filter()->unique())->pluck('size_name', 'id');
        $fabrics = \App\Models\Fabric::whereIn('id', $page->getCollection()->flatMap(fn ($shipment) => $shipment->fabric_swatches ?: [])->filter()->unique())->pluck('fabric_name', 'id');
        return response()->json([
            'data' => $page->getCollection()->map(function ($shipment) use ($names, $sizes, $fabrics) {
                $products = collect($shipment->products ?: []);
                return ['id' => $shipment->id, 'organization' => optional($shipment->organization)->organization_name ?: '—',
                    'items' => $products->map(fn ($product) => ['product' => $names->get($product['product_id'] ?? null, 'Unknown product'), 'size' => $sizes->get($product['size_id'] ?? null, 'Not specified')])->values(),
                    'swatches' => collect($shipment->fabric_swatches ?: [])->map(fn ($id) => $fabrics->get($id, 'Unknown fabric'))->values(),
                    'date' => $shipment->received_date ? $shipment->received_date->format('n/j/Y') : '—',
                    'products' => $products->map(fn ($product) => $names->get($product['product_id'] ?? null, 'Unknown product'))->unique()->implode(', ') ?: ($shipment->fabric_swatches ? 'Fabric swatches' : 'No samples recorded'),
                    'count' => $products->count()];
            }), 'page' => $page->currentPage(), 'pages' => $page->lastPage(), 'total' => $page->total(),
        ]);
    }

    private function dashboardMonthly(Request $request)
    {
        $start = Carbon::parse($request->input('start') ?: now()->startOfMonth())->startOfDay();
        $end = Carbon::parse($request->input('end') ?: now()->endOfMonth())->startOfDay();
        abort_if($end->lt($start), 422, 'End date must be on or after start date.');
        $users = User::select('id', 'name')->where('active', 1)->whereJsonContains('role_id', '3')
            ->whereNotIn('id', [1, 2, 5, 28, 38, 63, 81, 83, 84, 96, 97, 102, 106, 108, 113, 114])->orderBy('name')->get();
        $testIds = Organization::whereRaw('LOWER(organization_name) = ?', ['test'])->pluck('id');
        $base = Order::where('active', 1)->whereNotNull('production_date')
            ->whereRaw('LOWER(order_description) NOT LIKE ?', ['%remake%'])
            ->whereNotIn('organization_id', $testIds)->where('organization_id', '!=', 1377)
            ->whereIn('order_status_id', [3, 4, 8])
            ->whereHas('organizationDetails', fn ($query) => $query->where('internal_team', 0))
            ;
        $rangeTotals = function ($from, $to) use ($base) {
            return (clone $base)
                ->whereRaw('STR_TO_DATE(production_date, "%m/%d/%Y") >= ?', [$from->toDateString()])
                ->whereRaw('STR_TO_DATE(production_date, "%m/%d/%Y") < ?', [$to->copy()->addDay()->toDateString()])
                ->selectRaw('user_id, SUM(order_total) as total')->groupBy('user_id')->pluck('total', 'user_id');
        };
        $totals = $rangeTotals($start, $end);
        $previousTotals = $rangeTotals($start->copy()->subYearNoOverflow(), $end->copy()->subYearNoOverflow());
        $rows = $users->map(function ($user) use ($totals, $previousTotals) {
            $current = (float) $totals->get($user->id, 0);
            $previous = (float) $previousTotals->get($user->id, 0);
            return ['name' => $user->name, 'current' => $current, 'previous' => $previous, 'difference' => $current - $previous];
        });
        return response()->json(['data' => $rows, 'total' => round($rows->sum('current'), 2)]);
    }

    private function dashboardPaymentRows()
    {
        // Preserve the existing dashboard's inclusion rules for all six payment sources.
        $union = null;
        foreach ([PaymentLog::class, CheckPayment::class, VenmoPayment::class, PaypalPayment::class, PurchaseorderReceipt::class, OtherPayment::class] as $model) {
            $query = DB::table((new $model)->getTable())->select('order_id', 'amount', 'created_at');
            if ($model === PaymentLog::class) $query->where('response_code', '1');
            if ($union === null) $union = $query;
            else $union->unionAll($query);
        }
        return $union;
    }

    private function dashboardPayments(Request $request)
    {
        $received = $request->panel === 'received';
        $start = $request->input('start', now()->startOfMonth()->toDateString());
        $end = $request->input('end', now()->endOfMonth()->toDateString());
        $payments = DB::query()->fromSub($this->dashboardPaymentRows(), 'payments');
        // Received totals cover receipts in the selected period; pending balances use all payments.
        if ($received) {
            if ($start) $payments->where('created_at', '>=', $start . ' 00:00:00');
            if ($end) $payments->where('created_at', '<', Carbon::parse($end)->addDay()->toDateString());
        }
        $totals = $payments->selectRaw('order_id, SUM(amount) as received_amount, MAX(created_at) as payment_date')->groupBy('order_id');
        $orders = (new Order)->getTable();
        $organizations = (new Organization)->getTable();
        $query = DB::table($orders . ' as o')->leftJoinSub($totals, 'p', 'p.order_id', '=', 'o.id')
            ->leftJoin($organizations . ' as org', 'org.id', '=', 'o.organization_id')
            ->select('o.id', 'o.order_no', 'org.id as organization_id', 'org.organization_name', 'o.order_total')
            ->selectRaw('COALESCE(p.received_amount, 0) as received_amount, o.order_total - COALESCE(p.received_amount, 0) as pending_amount');
        if ($received) $query->whereNotNull('p.order_id')->orderByDesc('p.payment_date');
        else {
            $query->where('o.order_status_id', 3)->whereRaw('o.order_total > COALESCE(p.received_amount, 0)');
            app(OrderTypeTotalsService::class)->filterReceivableOrders($query);
        }
        if (!$received) {
            if ($start) $query->where('o.created_at', '>=', $start . ' 00:00:00');
            if ($end) $query->where('o.created_at', '<', Carbon::parse($end)->addDay()->toDateString());
        }
        if ($request->filled('search')) {
            $search = '%' . $request->search . '%';
            $query->where(function ($query) use ($search) {
                $query->where('o.id', 'like', $search)->orWhere('o.order_no', 'like', $search)
                    ->orWhere('org.organization_name', 'like', $search)->orWhere('o.phone_no', 'like', $search);
            });
        }
        $total = DB::query()->fromSub((clone $query)->reorder(), 'filtered_payments')
            ->sum($received ? 'received_amount' : 'pending_amount');
        $page = $query->orderByDesc('o.id')->paginate(5);
        return response()->json(['data' => $page->items(), 'page' => $page->currentPage(), 'pages' => $page->lastPage(), 'total' => round((float) $total, 2)]);
    }
}
