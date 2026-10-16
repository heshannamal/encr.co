<?php

namespace App\Http\Controllers;
use App\Models\Order;
use App\Models\User;
use App\Models\Sport;
use App\Models\LeadSource;
use App\Models\Factory;
use App\Models\Organization;
use Maatwebsite\Excel\Facades\Excel;
use App\Exports\SalesRepOrdersExport;
use App\Exports\SportOrdersExport;
use App\Exports\LeadOrdersExport;
use App\Exports\FactoryOrdersExport;
use App\Exports\OtherCountryOrdersExport;
use App\Exports\USOrdersByStateExport;
use Illuminate\Support\Facades\Log;
use ZipArchive;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;

class AnalyticalSummaryReportController extends Controller
{
    public function index()
    {

        return view('pages.reports.analytical_summary_report.index');
    }


    private function getTestOrgId()
    {
        // Fetch organization IDs using case-insensitive 'like'
        $orgs = Organization::where('organization_name', 'like', 'Test')
            ->orWhere('organization_name', 'like', 'TEST')
            ->orWhere('organization_name', 'like', 'test')
            ->pluck('id', 'organization_name'); // Optionally retrieve names too

        return $orgs;
    }
    public function isNewOrder($order , $startDate , $endDate)
    {
        // Get the startDate date for two months ago and the endDate date for today
        // $startDate = now()->subMonths(2)->startDateOfMonth(); // startDate of the month, two months ago
        // $endDate = now(); // Today (current date)

        // Get orders for the organization of this order that are outside the last two months
        $oldOrdersCount = Order::where('organization_id', $order->organization_id)
            ->where(function ($query) use ($startDate, $endDate) {
                // Orders created outside the last two months
                $query->whereRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') NOT BETWEEN ? AND ?", [$startDate, $endDate]);
            })
            ->count(); // Get the count of orders outside the valid date range

        // If there are any old orders, it's not a new order
        if ($oldOrdersCount > 0) {
            return false;
        }

        // If there are no orders outside the last two months and the order status is 'new' (1), return true
        return true; // Return true only if order status is 'new' (1)
    }
    public function getSalesRepOrders(Request $request)
    {

        $testOrganizationIdSet = $this->getTestOrgId();
        $filterColumn = $request->selectedColumn;
        $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
        $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');
        $internal_status = filter_var($request->Internal_status, FILTER_VALIDATE_BOOLEAN); // Convert to boolean

        // Fetch orders within the date range and status
        $orders = Order::whereIn('order_status_id', [3, 4, 8])
            ->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
            ->whereNotNull($filterColumn)
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->where('organization_id', '!=', 1377)
            ->with(['userDetails', 'organizationDetails', 'orderItems', 'statusDetails']) // Load related data
            ->get();
        if (!empty($request->order_types) ) {
            $orders = $orders->filter(function ($order) use ($request) {
                foreach ($request->order_types as $type) {
                    if ($type == 'all'  && $order->organizationDetails->internal_team == 0) {
                        return true;
                    }
                    if ($type == 'Bulk' && strpos($order->order_no, 'TSR' ) !== 0  && $order->plorder == 0 && $order->organizationDetails->internal_team == 0) {
                        return true;
                    }
                    if ($type == 'TSR' && strpos($order->order_no, 'TSR') === 0 && $order->organizationDetails->internal_team == 0) {
                        return true;
                    }
                    if ($type == 'Wl' && $order->plorder == 1 && $order->organizationDetails->internal_team == 0) {
                        return true;
                    }
                    if ($type == 'ITO' && $order->organizationDetails->internal_team == 1) {
                        return true;
                    }
                }
                return false;
            })->values();;
        }

        // Group orders by sales rep (user_id)
        $groupedOrders = $orders->groupBy('user_id');

        // Overall totals
        $overallTotalOrders = $orders->count();
        $overallTotalRevenue = $orders->sum('order_total');

        // Calculate results per sales rep
        $salesRepResults = $groupedOrders->map(function ($repOrders, $userId) use ($overallTotalRevenue,$startDate, $endDate) {
            $user = User::find($userId); // Get sales rep details


            $teamStoreOrders = $repOrders->filter(function ($order) {
                return str_contains($order->order_no, 'TSR') && $order->plorder == 0 && $order->organizationDetails->internal_team == 0;
            });

            $bulkOrders = $repOrders->reject(function ($order) {
                return str_contains($order->order_no, 'TSR') || $order->plorder == 1 || $order->organizationDetails->internal_team == 1;
            });

            $WlOrders = $repOrders->filter(function ($order) {
                return $order->plorder == 1;
            });
            $InternalOrders = $repOrders->filter(function ($order) {
                return $order->organizationDetails->internal_team == 1;
            });


            $newOrders = 0;
            foreach ($repOrders as $order) {
                if ($this->isNewOrder($order, $startDate, $endDate)) {
                    $newOrders++; // Increment new orders count if the order is new
                }
            }

            $totalRevenue = $repOrders->sum('order_total');

            return [
                'sales_rep' => $user->name ?? 'Unknown',
                'team_store_orders_count' => $teamStoreOrders->count(),
                'bulk_orders_count' => $bulkOrders->count(),
                'wl_orders_count' => $WlOrders->count(),
                'int_orders_count' => $InternalOrders->count(),
                'total_orders' => $repOrders->count(),
                'new_orders_count' => $newOrders,
                'total_revenue' => $totalRevenue,
                'revenue_percentage' => $overallTotalRevenue > 0
                    ? round(($totalRevenue / $overallTotalRevenue) * 100, 2)
                    : 0,
                'order_details' => $repOrders->map(function ($order) {
                    return [
                        'order_id' => $order->id,
                        'order_no' => $order->order_no,
                        'org_name' => $order->organizationDetails->organization_name ?? 'N/A',
                        'org_id' => $order->organizationDetails->id ?? 'N/A',
                        'inhand_due_date' => $order->due_date ?? 'N/A',
                        'number_of_items' => $order->orderItems->count(),
                        'order_amount' => $order->order_total,
                        'order_status' => $order->statusDetails->status_name,
                    ];
                }),
            ];
        });

        // Sort and get the top 3 sales reps by revenue
        $top3SalesReps = $salesRepResults->sortByDesc('total_revenue')->take(3);
        $salesRepResults = $salesRepResults->sortByDesc('total_revenue');

        // Final response
        $response = [
            'overall' => [
                'total_orders' => $overallTotalOrders,
                'total_revenue' => $overallTotalRevenue,
            ],
            'sales_reps' => $salesRepResults->values(),
            'top_3_sales_reps' => $top3SalesReps->values(),
        ];

        return response()->json($response);
    }

    public function getOrdersGroupedBySport(Request $request)
    {
        $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
        $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');
        $testOrganizationIdSet = $this->getTestOrgId();
        $filterColumn = $request->selectedColumn;
        // Fetch orders within the date range and status
        $orders = Order::whereIn('order_status_id', [3, 4, 8])
            ->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
            ->whereNotNull($filterColumn)
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->where('organization_id', '!=', 1377)
            ->with(['userDetails', 'organizationDetails', 'orderItems','statusDetails']) // Load related data
            ->get();
            if (!empty($request->order_types) ) {
                $orders = $orders->filter(function ($order) use ($request) {
                    foreach ($request->order_types as $type) {
                        if ($type == 'all'  && $order->organizationDetails->internal_team == 0) {
                            return true;
                        }
                        if ($type == 'Bulk' && strpos($order->order_no, 'TSR' ) !== 0  && $order->plorder == 0 && $order->organizationDetails->internal_team == 0) {
                            return true;
                        }
                        if ($type == 'TSR' && strpos($order->order_no, 'TSR') === 0 && $order->organizationDetails->internal_team == 0) {
                            return true;
                        }
                        if ($type == 'Wl' && $order->plorder == 1 && $order->organizationDetails->internal_team == 0) {
                            return true;
                        }
                        if ($type == 'ITO' && $order->organizationDetails->internal_team == 1) {
                            return true;
                        }
                    }
                    return false;
                })->values();;
            }

        // Group orders by sales rep (user_id)
        $groupedOrders = $orders->groupBy(function ($order) {
            return $order->organizationDetails->sport ?? 'Unknown Sport';
        });

        // Overall totals
        $overallTotalOrders = $orders->count();
        $overallTotalRevenue = $orders->sum('order_total');

        // Calculate results per sales rep
        $soprtOrders = $groupedOrders->map(function ($repOrders, $sport) use ($overallTotalRevenue,$startDate, $endDate) {
            $sport = Sport::where('sport_name', $sport)->first();
            $teamStoreOrders = $repOrders->filter(function ($order) {
                return str_contains($order->order_no, 'TSR') && $order->plorder == 0 && $order->organizationDetails->internal_team == 0;
            });

            $bulkOrders = $repOrders->reject(function ($order) {
                return str_contains($order->order_no, 'TSR') || $order->plorder == 1 || $order->organizationDetails->internal_team == 1;
            });

            $WlOrders = $repOrders->filter(function ($order) {
                return $order->plorder == 1;
            });
            $InternalOrders = $repOrders->filter(function ($order) {
                return $order->organizationDetails->internal_team == 1;
            });

            $newOrders = 0;
            foreach ($repOrders as $order) {
                if ($this->isNewOrder($order,$startDate,$endDate)) {
                    $newOrders++; // Increment new orders count if the order is new
                }
            }

            $totalRevenue = $repOrders->sum('order_total');

            return [
                'sport' => $sport->sport_name ?? 'Unknown',
                'team_store_orders_count' => $teamStoreOrders->count(),
                'bulk_orders_count' => $bulkOrders->count(),
                'wl_orders_count' => $WlOrders->count(),
                'int_orders_count' => $InternalOrders->count(),
                'total_orders' => $repOrders->count(),
                'new_orders_count' => $newOrders,
                'total_revenue' => $totalRevenue,
                'revenue_percentage' => $overallTotalRevenue > 0
                    ? round(($totalRevenue / $overallTotalRevenue) * 100, 2)
                    : 0,
                'order_details' => $repOrders->map(function ($order) {
                    return [
                        'order_id' => $order->id,
                        'order_no' => $order->order_no,
                        'org_name' => $order->organizationDetails->organization_name ?? 'N/A',
                        'org_id' => $order->organizationDetails->id ?? 'N/A',
                        'inhand_due_date' => $order->due_date ?? 'N/A',
                        'number_of_items' => $order->orderItems->count(),
                        'order_amount' => $order->order_total,
                        'order_status' => $order->statusDetails->status_name,
                    ];
                }),
            ];
        });
        // Sort and get the top 3 sales reps by revenue
        $top3SalesReps = $soprtOrders->sortByDesc('total_revenue')->take(3);
        $soprtOrders = $soprtOrders->sortByDesc('total_revenue');

        // Final response
        $response = [
            'overall' => [
                'total_orders' => $overallTotalOrders,
                'total_revenue' => $overallTotalRevenue,
            ],
            'sports' => $soprtOrders->values(),
            'top_3_sports' => $top3SalesReps->values(),
        ];

        return response()->json($response);
    }
    public function getOrdersGroupedByLeadSource(Request $request)
    {
        $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
        $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');
        $testOrganizationIdSet = $this->getTestOrgId();
        $internal_status = filter_var($request->Internal_status, FILTER_VALIDATE_BOOLEAN); // Convert to boolean
        $filterColumn = $request->selectedColumn;
        // Fetch orders within the date range and status
        $orders = Order::whereIn('order_status_id', [3, 4, 8])
            ->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
            ->whereNotNull($filterColumn)
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->where('organization_id', '!=', 1377)
            ->when(!$internal_status, function ($query) {
                $query->whereDoesntHave('organizationDetails', function ($q) {
                    $q->where('internal_team', 1);
                });
            })
            ->with(['userDetails', 'organizationDetails', 'orderItems','statusDetails']) // Load related data
            ->get();
        if (!empty($request->order_types) ) {
            $orders = $orders->filter(function ($order) use ($request) {
                foreach ($request->order_types as $type) {
                    if ($type == 'all'  && $order->organizationDetails->internal_team == 0) {
                        return true;
                    }
                    if ($type == 'Bulk' && strpos($order->order_no, 'TSR' ) !== 0  && $order->plorder == 0 && $order->organizationDetails->internal_team == 0) {
                        return true;
                    }
                    if ($type == 'TSR' && strpos($order->order_no, 'TSR') === 0 && $order->organizationDetails->internal_team == 0) {
                        return true;
                    }
                    if ($type == 'Wl' && $order->plorder == 1 && $order->organizationDetails->internal_team == 0) {
                        return true;
                    }
                    if ($type == 'ITO' && $order->organizationDetails->internal_team == 1) {
                        return true;
                    }
                }
                return false;
            })->values();;
        }

        // Group orders by sales rep (user_id)
        $groupedOrders = $orders->groupBy(function ($order) {
            return $order->organizationDetails->lead_source ?? 'Unknown Lead Source';
        });

        // Overall totals
        $overallTotalOrders = $orders->count();
        $overallTotalRevenue = $orders->sum('order_total');

        // Calculate results per sales rep
        $LeadOrders = $groupedOrders->map(function ($repOrders, $LeadID) use ($overallTotalRevenue,$startDate, $endDate) {
            $LeadSource = LeadSource::find($LeadID);
            $teamStoreOrders = $repOrders->filter(function ($order) {
                return str_contains($order->order_no, 'TSR');
            });

            $bulkOrders = $repOrders->reject(function ($order) {
                return str_contains($order->order_no, 'TSR');
            });
            $WlOrders = $repOrders->filter(function ($order) {
                return $order->plorder == 1;
            });
            $InternalOrders = $repOrders->filter(function ($order) {
                return $order->organizationDetails->internal_team == 1;
            });

            $newOrders = 0;
            foreach ($repOrders as $order) {
                if ($this->isNewOrder($order, $startDate, $endDate)) {
                    $newOrders++; // Increment new orders count if the order is new
                }
            }

            $totalRevenue = $repOrders->sum('order_total');

            return [
                'leadSource' => $LeadSource->lead_source_name ?? 'Unknown',
                'team_store_orders_count' => $teamStoreOrders->count(),
                'bulk_orders_count' => $bulkOrders->count(),
                'wl_orders_count' => $WlOrders->count(),
                'int_orders_count' => $InternalOrders->count(),
                'total_orders' => $repOrders->count(),
                'new_orders_count' => $newOrders,
                'total_revenue' => $totalRevenue,
                'revenue_percentage' => $overallTotalRevenue > 0
                    ? round(($totalRevenue / $overallTotalRevenue) * 100, 2)
                    : 0,
                'order_details' => $repOrders->map(function ($order) {
                    return [
                        'order_id' => $order->id,
                        'order_no' => $order->order_no,
                        'org_name' => $order->organizationDetails->organization_name ?? 'N/A',
                        'org_id' => $order->organizationDetails->id ?? 'N/A',
                        'inhand_due_date' => $order->due_date ?? 'N/A',
                        'number_of_items' => $order->orderItems->count(),
                        'order_amount' => $order->order_total,
                        'order_status' => $order->statusDetails->status_name,
                    ];
                }),
            ];
        });
        // Sort and get the top 3 sales reps by revenue
        $top3SalesReps = $LeadOrders->sortByDesc('total_revenue')->take(3);
        $LeadOrders = $LeadOrders->sortByDesc('total_revenue');

        // Final response
        $response = [
            'overall' => [
                'total_orders' => $overallTotalOrders,
                'total_revenue' => $overallTotalRevenue,
            ],
            'lead' => $LeadOrders->values(),
            'top_3_sports' => $top3SalesReps->values(),
        ];

        return response()->json($response);
    }

    public function getOrdersGroupedByFactory(Request $request)
    {
        $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
        $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');
        $internal_status = filter_var($request->Internal_status, FILTER_VALIDATE_BOOLEAN); // Convert to boolean
        $testOrganizationIdSet = $this->getTestOrgId();
        $filterColumn = $request->selectedColumn;
        // Fetch orders with their items and factories
        $orders = Order::whereRaw("STR_TO_DATE( $filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
        ->whereNotNull( $filterColumn)
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->where('organization_id', '!=', 1377)
            ->whereIn('order_status_id', [3, 4, 8])
            ->with(['orderItems.factoryDetails']) // Load items and factories
            ->get();

        // Initialize factory grouping
        $factoriesData = [];
        $grandTotalAmount = 0;
        foreach ($orders as $order) {
            // To avoid duplicate order count, use a temporary factory tracker for this order
            $factoriesProcessed = [];

            foreach ($order->orderItems as $item) {
                $factoryId = $item->factoryDetails->id ?? 0;
                $factoryName = $item->factoryDetails->factory_name ?? 'Unknown Factory';

                // Initialize factory group if not exists
                if (!isset($factoriesData[$factoryId])) {
                    $factoriesData[$factoryId] = [
                        'factory_id' => $factoryId,
                        'factory_name' => $factoryName,
                        'order_count' => 0,
                        'new_order_count' => 0,
                        'total_revenue' => 0,
                    ];
                }

                // Avoid counting the same order more than once for this factory
                if (!in_array($factoryId, $factoriesProcessed)) {

                    $factoriesProcessed[] = $factoryId;

                    // Increment new order count only if the order is "new"
                    if ($this->isNewOrder($order, $startDate, $endDate)) {
                        $factoriesData[$factoryId]['new_order_count']++;
                    }
                }

                // Update totals
                $factoriesData[$factoryId]['order_count']++;
                $factoriesData[$factoryId]['total_revenue'] += $item->total;
                $grandTotalAmount += $item->total;
            }
        }
        // Overall totals
        $overallTotalOrders = $orders->count();
        $overallTotalRevenue = $orders->sum('order_total');
        // Convert the result to an array for response
        foreach ($factoriesData as &$factory) {
            $factory['revenue_percentage'] = $grandTotalAmount > 0
                ? round(($factory['total_revenue'] / $grandTotalAmount) * 100, 2)
                : 0;
        }
        $response = [
            'factories' => array_values($factoriesData),
            'overall' => [
                'total_orders' => $overallTotalOrders,
                'total_revenue' => $overallTotalRevenue,
            ],
        ];

        return response()->json($response);
    }

    public function getOrdersSummary(Request $request)
    {
        // Parse start and end dates
        $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
        $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');
        $testOrganizationIdSet = $this->getTestOrgId();
        $internal_team_status = filter_var(true, FILTER_VALIDATE_BOOLEAN); // Convert to boolean
        $filterColumn = $request->selectedColumn;
        // Fetch orders within the date range and required statuses
        $orders = Order::whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
            ->whereNotNull($filterColumn)
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->where('plorder', 0)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->where('organization_id', '!=', 1377)
            ->when(!$internal_team_status, function ($query) {
                // If not including internal team, exclude them
                $query->whereHas('organizationDetails', function ($subQuery) {
                    $subQuery->where('internal_team', 0);
                });
            })
            ->whereIn('order_status_id', [3, 4, 8])
            ->get();


        // Initialize counters
        $summary = [
            'team_store' => [
                'order_count' => 0,
                'total_revenue' => 0,
            ],
            'bulk_orders' => [
                'order_count' => 0,
                'total_revenue' => 0,
            ],
        ];

        // Iterate through all orders
    foreach ($orders as $order) {
        if ($order->order_type == 1 && $order->organizationDetails->internal_team == 0) {
            // Team Store Order
            $summary['team_store']['order_count']++;
            $summary['team_store']['total_revenue'] += $order->order_total;
        } elseif ($order->order_type == 0  && $order->organizationDetails->internal_team == 0) {
            // Bulk Order
            $summary['bulk_orders']['order_count']++;
            $summary['bulk_orders']['total_revenue'] += $order->order_total;
        }
    }
        // Overall totals
        $overallTotalOrders = $orders->count();
        $overallTotalRevenue = $orders->sum('order_total');
        // Return JSON response
        return response()->json([
            'summary' => $summary,
            'overall' => [
                'total_orders' => $overallTotalOrders,
                'total_revenue' => $overallTotalRevenue,
            ],
        ]);
    }

    public function getOrdersByOrganizations(Request $request)
    {
        $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
        $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');
        $testOrganizationIdSet = $this->getTestOrgId();
        $internal_status = filter_var($request->Internal_status, FILTER_VALIDATE_BOOLEAN); // Convert to boolean
        $filterColumn = $request->selectedColumn;
        // Fetch current date range orders with organizations
        $currentOrders = Order::whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
            ->whereIn('order_status_id', [3, 4,  8])
            ->whereNotNull($filterColumn)
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->where('organization_id', '!=', 1377)
            ->when(!$internal_status, function ($query) {
                $query->whereDoesntHave('organizationDetails', function ($q) {
                    $q->where('internal_team', 1);
                });
            })
            ->with('organizationDetails')
            ->get();

        // Initialize results
        $organizationsData = [
            'new_customers' => [
                'organization_count' => 0,
                'organization_percentage' => 0,
                'team_store_orders_count' => 0,
                'bulk_orders_count' => 0,
                'total_orders' => 0,
                'total_revenue' => 0,
            ],
            'repeated_customers' => [
                'organization_count' => 0,
                'organization_percentage' => 0,
                'team_store_orders_count' => 0,
                'bulk_orders_count' => 0,
                'total_orders' => 0,
                'total_revenue' => 0,
            ],
        ];

        $organizationProcessed = [];

        foreach ($currentOrders as $order) {
            $organizationId = $order->organizationDetails->id ?? null;
            $organizationName = $order->organizationDetails->organization_name ?? 'Unknown';
            $isNewCustomer = $this->isNewCustomer($organizationId, $startDate, $endDate);

            if ($organizationId) {
                // Classify organization
                $customerType = $isNewCustomer ? 'new_customers' : 'repeated_customers';

                if (!isset($organizationProcessed[$customerType][$organizationId])) {
                    $organizationProcessed[$customerType][$organizationId] = [
                        'organization_id' => $organizationId,
                        'organization_name' => $organizationName,
                        'team_store_orders' => 0,
                        'bulk_orders' => 0,
                        'total_orders' => 0,
                        'total_revenue' => 0,
                    ];

                    $organizationsData[$customerType]['organization_count']++;
                }

                // Classify order type
                if (str_contains($order->order_no, 'TSR')) {
                    $organizationProcessed[$customerType][$organizationId]['team_store_orders']++;
                    $organizationsData[$customerType]['team_store_orders_count']++;
                } else {
                    $organizationProcessed[$customerType][$organizationId]['bulk_orders']++;
                    $organizationsData[$customerType]['bulk_orders_count']++;
                }

                // Update totals
                $organizationProcessed[$customerType][$organizationId]['total_orders']++;
                $organizationProcessed[$customerType][$organizationId]['total_revenue'] += $order->order_total;

                $organizationsData[$customerType]['total_orders']++;
                $organizationsData[$customerType]['total_revenue'] += $order->order_total;
            }
        }

        // Calculate percentages
        $totalOrganizations = $organizationsData['new_customers']['organization_count'] +
                              $organizationsData['repeated_customers']['organization_count'];

        foreach (['new_customers', 'repeated_customers'] as $type) {
            if ($totalOrganizations > 0) {
                $organizationsData[$type]['organization_percentage'] = round(
                    ($organizationsData[$type]['organization_count'] / $totalOrganizations) * 100,
                    2
                );
            }
        }
        // Overall totals
        $overallTotalOrders = $currentOrders->count();
        $overallTotalRevenue = $currentOrders->sum('order_total');
        return response()->json([
            'organizations' => $organizationsData,
            'overall' => [
                'total_orders' => $overallTotalOrders,
                'total_revenue' => $overallTotalRevenue,
            ],
        ]);
    }

    /**
     * Determine if an organization is new within the given date range.
     */
    private function isNewCustomer($organizationId, $startDate, $endDate)
    {
        // Check if there are any orders for the organization before the given date range
        $previousOrders = Order::where('organization_id', $organizationId)
            ->where('created_at', '<', $startDate)
            ->exists();

        return !$previousOrders; // If no previous orders exist, it's a new customer
    }

    // public function getOrdersGroupedByCountry(Request $request)
    // {
    //     $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
    //     $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

    //     // Fetch orders within the specified date range
    //     $orders = Order::whereRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
    //         ->whereNotNull('ex_factory_date')
    //         ->where('write_off_order', 0)
    //         ->where('active', 1)->where('organization_id', '!=', 1377)
    //         ->whereHas('organizationDetails', function ($query) {
    //             $query->whereNotNull('shipping_country');
    //         })
    //         ->with(['orderItems','organizationDetails']) // Load order items for details
    //         ->get();

    //     // Group orders by country
    //     // $groupedByCountry = $orders->groupBy('organizationDetails.shipping_country');
    //     $groupedByCountry = $orders->groupBy(function ($order) {
    //         return $order->organizationDetails->shipping_country ?? 'Unknown';
    //     });
    //     // Prepare data
    //     $countriesData = $groupedByCountry->map(function ($orders, $country) {
    //         return [
    //             'country' => $country ?? 'Unknown',
    //             'order_count' => $orders->count(),
    //             'orders' => $orders->map(function ($order) {
    //                 return [
    //                     'order_id' => $order->id,
    //                     'order_no' => $order->order_no,
    //                     'order_total' => $order->order_total,
    //                     'created_at' => $order->created_at->format('Y-m-d'),
    //                     'organization_name' => $order->organizationDetails->organization_name ?? 'N/A',
    //                     'number_of_items' => $order->orderItems->count(),
    //                 ];
    //             }),
    //         ];
    //     })->values();
    //     // Overall totals
    //     $overallTotalOrders = $orders->count();
    //     $overallTotalRevenue = $orders->sum('order_total');
    //     return response()->json([
    //         'countries' => $countriesData,
    //         'overall' => [
    //             'total_orders' => $overallTotalOrders,
    //             'total_revenue' => $overallTotalRevenue,
    //         ],
    //     ]);
    // }
    protected function getStateShortForm($state)
{
    // Map of long-form states to their short-form equivalents
    $stateMapping = [
        'Alabama' => 'AL',
        'Alaska' => 'AK',
        'Arizona' => 'AZ',
        'Arkansas' => 'AR',
        'California' => 'CA',
        'Colorado' => 'CO',
        'Connecticut' => 'CT',
        'Delaware' => 'DE',
        'Florida' => 'FL',
        'Georgia' => 'GA',
        'Hawaii' => 'HI',
        'Idaho' => 'ID',
        'Illinois' => 'IL',
        'Indiana' => 'IN',
        'Iowa' => 'IA',
        'Kansas' => 'KS',
        'Kentucky' => 'KY',
        'Louisiana' => 'LA',
        'Maine' => 'ME',
        'Maryland' => 'MD',
        'Massachusetts' => 'MA',
        'Michigan' => 'MI',
        'Minnesota' => 'MN',
        'Mississippi' => 'MS',
        'Missouri' => 'MO',
        'Montana' => 'MT',
        'Nebraska' => 'NE',
        'Nevada' => 'NV',
        'New Hampshire' => 'NH',
        'New Jersey' => 'NJ',
        'New Mexico' => 'NM',
        'New York' => 'NY',
        'North Carolina' => 'NC',
        'North Dakota' => 'ND',
        'Ohio' => 'OH',
        'Oklahoma' => 'OK',
        'Oregon' => 'OR',
        'Pennsylvania' => 'PA',
        'Rhode Island' => 'RI',
        'South Carolina' => 'SC',
        'South Dakota' => 'SD',
        'Tennessee' => 'TN',
        'Texas' => 'TX',
        'Utah' => 'UT',
        'Vermont' => 'VT',
        'Virginia' => 'VA',
        'Washington' => 'WA',
        'West Virginia' => 'WV',
        'Wisconsin' => 'WI',
        'Wyoming' => 'WY',
    ];

    // Return the short form if it exists, otherwise return the state as-is
    return $stateMapping[$state] ?? $state;
}

    public function getOrdersGroupedByCountry(Request $request)
    {
        $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
        $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');
        $testOrganizationIdSet = $this->getTestOrgId();

        // Fetch orders within the date range and status
        $orders = Order::whereIn('order_status_id', [3, 4, 8])
            ->whereRaw("STR_TO_DATE(ex_factory_date, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
            ->whereNotNull('ex_factory_date')
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->where('organization_id', '!=', 1377)
            ->with(['userDetails', 'organizationDetails', 'orderItems', 'statusDetails']) // Load related data
            ->get();

        // Group orders by country
        $groupedOrders = $orders->groupBy(function ($order) {
            return $order->organizationDetails->shipping_country ?? 'Country Unknown';
        });

        // Overall totals
        $overallTotalOrders = $orders->count();
        $overallTotalRevenue = $orders->sum('order_total');

        // Process orders grouped by country and handle U.S. states separately
        $CountryOrders = $groupedOrders->map(function ($countryOrders, $country) use ($startDate, $endDate, $overallTotalRevenue) {
            if ($country === 'United States') {
                // Group U.S. orders by state
                $stateGroupedOrders = $countryOrders->groupBy(function ($order) {
                    return $this->getStateShortForm($order->organizationDetails->shipping_state ?? 'State Unknown');
                });

                // Calculate data for each state
                $stateData = $stateGroupedOrders->map(function ($stateOrders, $state) use ($startDate, $endDate, $overallTotalRevenue) {
                    return $this->calculateOrderData($stateOrders, $startDate, $endDate, $state, $overallTotalRevenue);
                });

                // Return the grouped state data for the United States
                return [
                    'group' => 'United States',
                    'total_orders' => $countryOrders->count(),
                    'total_revenue' => $countryOrders->sum('order_total'),
                    'revenue_percentage' => $overallTotalRevenue > 0
                        ? round(($countryOrders->sum('order_total') / $overallTotalRevenue) * 100, 2)
                        : 0,
                    'team_store_orders_count' => $countryOrders->filter(fn($order) => str_contains($order->order_no, 'TSR'))->count(),
                    'bulk_orders_count' => $countryOrders->reject(fn($order) => str_contains($order->order_no, 'TSR'))->count(),
                    'new_orders_count' => $countryOrders->filter(fn($order) => $this->isNewOrder($order, $startDate, $endDate))->count(),
                    'order_details' => $stateData, // State-wise data
                ];
            }

            // Calculate data for non-U.S. countries
            return $this->calculateOrderData($countryOrders, $startDate, $endDate, $country, $overallTotalRevenue);
        });

        // Final response
        $response = [
            'overall' => [
                'total_orders' => $overallTotalOrders,
                'total_revenue' => $overallTotalRevenue,
            ],
            'countries' => $CountryOrders,
        ];

        return response()->json($response);
    }

    private function calculateOrderData($orders, $startDate, $endDate, $groupKey, $overallTotalRevenue)
    {
        $teamStoreOrders = $orders->filter(function ($order) {
            return str_contains($order->order_no, 'TSR');
        });

        $bulkOrders = $orders->reject(function ($order) {
            return str_contains($order->order_no, 'TSR');
        });

        $newOrders = $orders->filter(function ($order) use ($startDate, $endDate) {
            return $this->isNewOrder($order, $startDate, $endDate);
        })->count();

        $totalRevenue = $orders->sum('order_total');

        return [
            'group' => $groupKey,
            'team_store_orders_count' => $teamStoreOrders->count(),
            'bulk_orders_count' => $bulkOrders->count(),
            'total_orders' => $orders->count(),
            'new_orders_count' => $newOrders,
            'total_revenue' => $totalRevenue,
            'revenue_percentage' => $overallTotalRevenue > 0
                ? round(($totalRevenue / $overallTotalRevenue) * 100, 2)
                : 0,
            'order_details' => $orders->map(function ($order) {
                return [
                    'order_id' => $order->id,
                    'org_name' => $order->organizationDetails->organization_name ?? 'N/A',
                    'org_id' => $order->organizationDetails->id ?? 'N/A',
                    'inhand_due_date' => $order->due_date ?? 'N/A',
                    'number_of_items' => $order->orderItems->count(),
                    'order_amount' => $order->order_total,
                    'order_status' => $order->statusDetails->status_name,
                ];
            }),
        ];
    }



    public function exportReport(Request $request)
{
    $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
    $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');
    $filterColumn = $request->selectedColumn;
    $internal_status = filter_var($request->Internal_status, FILTER_VALIDATE_BOOLEAN); // Convert to boolean
    $ReportType = $request->reportType;

    if ($ReportType == 1) {
        // Return the response from exportSalesRepOrders
        return $this->exportSalesRepOrders($startDate, $endDate, $filterColumn,$internal_status);
    }elseif($ReportType == 2){
        return $this->exportSportOrders($startDate, $endDate, $filterColumn,$internal_status);
    }elseif($ReportType == 4){
        return $this->exportLeadOrders($startDate, $endDate, $filterColumn,$internal_status);
    }
    elseif($ReportType == 3){
        return $this->exportFactoryOrders($startDate, $endDate, $filterColumn,$internal_status);
    }
    elseif($ReportType == 6){
        return $this->exportOrdersGroupedByCountry($startDate, $endDate, $filterColumn,$internal_status);
    }

    // Add handling for other report types if needed
    // Return an appropriate response
    return response()->json(['error' => 'Invalid report type'], 400);
}

public function exportSalesRepOrders($startDate, $endDate, $filterColumn,$internal_status)
{
    try {
        $testOrganizationIdSet = $this->getTestOrgId();
        // Fetch orders within the date range and status
        $orders = Order::whereIn('order_status_id', [3, 4, 8])
            ->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
            ->whereNotNull($filterColumn)
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->where('organization_id', '!=', 1377)
            ->when(!$internal_status, function ($query) {
                $query->whereDoesntHave('organizationDetails', function ($q) {
                    $q->where('internal_team', 1);
                });
            })
            ->with(['userDetails', 'organizationDetails', 'orderItems','statusDetails'])
            ->get();

        // Group orders by sales rep (user_id)
        $groupedOrders = $orders->groupBy('user_id');

        // Overall totals
        $overallTotalOrders = $orders->count();
        $overallTotalRevenue = $orders->sum('order_total');

        // Calculate results per sales rep
        $salesRepResults = $groupedOrders->map(function ($repOrders, $userId) use ($overallTotalRevenue, $startDate, $endDate) {
            $user = User::find($userId);

            $teamStoreOrders = $repOrders->filter(function ($order) {
                return str_contains($order->order_no, 'TSR');
            });

            $bulkOrders = $repOrders->reject(function ($order) {
                return str_contains($order->order_no, 'TSR');
            });

            $newOrders = 0;
            foreach ($repOrders as $order) {
                if ($this->isNewOrder($order, $startDate, $endDate)) {
                    $newOrders++;
                }
            }

            $totalRevenue = $repOrders->sum('order_total');

            return [
                'sales_rep' => $user->name ?? 'Unknown',
                'team_store_orders_count' => $teamStoreOrders->count(),
                'bulk_orders_count' => $bulkOrders->count(),
                'total_orders' => $repOrders->count(),
                'new_orders_count' => $newOrders,
                'total_revenue' => $totalRevenue,
                'revenue_percentage' => $overallTotalRevenue > 0
                    ? round(($totalRevenue / $overallTotalRevenue) * 100, 2)
                    : 0,
                'order_details' => $repOrders->map(function ($order) {
                    return [
                        'order_id' => $order->id,
                        'org_name' => $order->organizationDetails->organization_name ?? 'N/A',
                        'org_id' => $order->organizationDetails->id ?? 'N/A',
                        'inhand_due_date' => $order->due_date ?? 'N/A',
                        'number_of_items' => $order->orderItems->count(),
                        'order_amount' => $order->order_total,
                        'order_status' => $order->statusDetails->status_name,
                    ];
                }),
            ];
        });

        $salesRepResults = $salesRepResults->values(); // Ensure it's a collection for export

        // Create and export Excel
        $fileName = "Sales_Rep_Orders_{$startDate}_to_{$endDate}.xlsx";

        // Pass both arguments to the SalesRepOrdersExport constructor
        $export = new SalesRepOrdersExport($salesRepResults, $overallTotalRevenue);

        // Store the file temporarily
        $filePath = storage_path("app/exports/{$fileName}");

        // Store the file temporarily
        Excel::store($export, "exports/{$fileName}");

        // Debugging: Check if the file exists
        if (!file_exists($filePath)) {
            Log::error('File was not created at: ' . $filePath);
            return response()->json(['error' => 'File not found.'], 500);
        }

        // If file exists, return download
        return response()->download($filePath, $fileName)->deleteFileAfterSend(true);

    } catch (\Exception $e) {
        // Log error and return message
        Log::error('Error in exportSalesRepOrders: ' . $e->getMessage());
        return response()->json(['error' => 'An error occurred while generating the file.'], 500);
    }
}
    public function exportSportOrders($startDate, $endDate, $filterColumn,$internal_status)
    {
        try {
            $testOrganizationIdSet = $this->getTestOrgId();
            // Fetch orders within the date range and status
            $orders = Order::whereIn('order_status_id', [3, 4, 8])
                ->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
                ->whereNotNull($filterColumn)
                ->where('write_off_order', 0)
                ->where('active', 1)
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('organization_id', '!=', 1377)
                ->when(!$internal_status, function ($query) {
                    $query->whereDoesntHave('organizationDetails', function ($q) {
                        $q->where('internal_team', 1);
                    });
                })
                ->with(['userDetails', 'organizationDetails', 'orderItems','statusDetails']) // Load related data
                ->get();

            // Group orders by sport (organizationDetails->sport)
            $groupedOrders = $orders->groupBy(function ($order) {
                return $order->organizationDetails->sport ?? 'Unknown Sport';
            });

            // Overall totals
            $overallTotalOrders = $orders->count();
            $overallTotalRevenue = $orders->sum('order_total');

            // Calculate results per sport
            $sportResults = $groupedOrders->map(function ($sportOrders, $sport) use ($overallTotalRevenue, $startDate, $endDate) {
                $teamStoreOrders = $sportOrders->filter(function ($order) {
                    return str_contains($order->order_no, 'TSR');
                });

                $bulkOrders = $sportOrders->reject(function ($order) {
                    return str_contains($order->order_no, 'TSR');
                });

                $newOrders = 0;
                foreach ($sportOrders as $order) {
                    if ($this->isNewOrder($order, $startDate, $endDate)) {
                        $newOrders++; // Increment new orders count if the order is new
                    }
                }

                $totalRevenue = $sportOrders->sum('order_total');

                return [
                    'sport' => $sport,
                    'team_store_orders_count' => $teamStoreOrders->count(),
                    'bulk_orders_count' => $bulkOrders->count(),
                    'total_orders' => $sportOrders->count(),
                    'new_orders_count' => $newOrders,
                    'total_revenue' => $totalRevenue,
                    'revenue_percentage' => $overallTotalRevenue > 0
                        ? round(($totalRevenue / $overallTotalRevenue) * 100, 2)
                        : 0,
                    'order_details' => $sportOrders->map(function ($order) {
                        return [
                            'order_id' => $order->id,
                            'org_name' => $order->organizationDetails->organization_name ?? 'N/A',
                            'org_id' => $order->organizationDetails->id ?? 'N/A',
                            'inhand_due_date' => $order->due_date ?? 'N/A',
                            'number_of_items' => $order->orderItems->count(),
                            'order_amount' => $order->order_total,
                            'order_status' => $order->statusDetails->status_name,
                        ];
                    }),
                ];
            });

            // Ensure collection for export
            $sportResults = $sportResults->values();

            // Create and export Excel
            $fileName = "Sport_Orders_{$startDate}_to_{$endDate}.xlsx";

            // Pass the data to the SportOrdersExport constructor
            $export = new SportOrdersExport($sportResults, $overallTotalRevenue);

            // Store the file temporarily
            $filePath = storage_path("app/exports/{$fileName}");

            // Store the file temporarily
            Excel::store($export, "exports/{$fileName}");

            // Debugging: Check if the file exists
            if (!file_exists($filePath)) {
                Log::error('File was not created at: ' . $filePath);
                return response()->json(['error' => 'File not found.'], 500);
            }

            // If file exists, return download
            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            // Log error and return message
            Log::error('Error in exportSportOrders: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while generating the file.'], 500);
        }
    }
    public function exportLeadOrders($startDate, $endDate, $filterColum,$internal_status)
    {
        try {
            $testOrganizationIdSet = $this->getTestOrgId();
            // Fetch orders within the date range and status
            $orders = Order::whereIn('order_status_id', [3, 4, 8])
                ->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
                ->whereNotNull($filterColumn)
                ->where('write_off_order', 0)
                ->where('active', 1)
                ->whereNotIn('organization_id', $testOrganizationIdSet)
                ->where('organization_id', '!=', 1377)
                ->when(!$internal_status, function ($query) {
                    $query->whereDoesntHave('organizationDetails', function ($q) {
                        $q->where('internal_team', 1);
                    });
                })
                ->with(['userDetails', 'organizationDetails', 'orderItems','statusDetails']) // Load related data
                ->get();

            // Group orders by lead source (organizationDetails->lead_source)
            $groupedOrders = $orders->groupBy(function ($order) {
                return $order->organizationDetails->lead_source ?? 'Unknown Lead Source';
            });

            // Overall totals
            $overallTotalOrders = $orders->count();
            $overallTotalRevenue = $orders->sum('order_total');

            // Calculate results per lead source
            $leadResults = $groupedOrders->map(function ($leadOrders, $leadid) use ($overallTotalRevenue, $startDate, $endDate) {
                $LeadSource = LeadSource::find($leadid);
                $teamStoreOrders = $leadOrders->filter(function ($order) {
                    return str_contains($order->order_no, 'TSR');
                });

                $bulkOrders = $leadOrders->reject(function ($order) {
                    return str_contains($order->order_no, 'TSR');
                });

                $newOrders = 0;
                foreach ($leadOrders as $order) {
                    if ($this->isNewOrder($order, $startDate, $endDate)) {
                        $newOrders++; // Increment new orders count if the order is new
                    }
                }

                $totalRevenue = $leadOrders->sum('order_total');

                return [
                    'lead_source' => $LeadSource->lead_source_name ?? 'Unknown LeadSource',
                    'team_store_orders_count' => $teamStoreOrders->count(),
                    'bulk_orders_count' => $bulkOrders->count(),
                    'total_orders' => $leadOrders->count(),
                    'new_orders_count' => $newOrders,
                    'total_revenue' => $totalRevenue,
                    'revenue_percentage' => $overallTotalRevenue > 0
                        ? round(($totalRevenue / $overallTotalRevenue) * 100, 2)
                        : 0,
                    'order_details' => $leadOrders->map(function ($order) {
                        return [
                            'order_id' => $order->id,
                            'org_name' => $order->organizationDetails->organization_name ?? 'N/A',
                            'org_id' => $order->organizationDetails->id ?? 'N/A',
                            'inhand_due_date' => $order->due_date ?? 'N/A',
                            'number_of_items' => $order->orderItems->count(),
                            'order_amount' => $order->order_total,
                            'order_status' => $order->statusDetails->status_name,
                        ];
                    }),
                ];
            });

            // Ensure collection for export
            $leadResults = $leadResults->values();

            // Create and export Excel
            $fileName = "Lead_Orders_{$startDate}_to_{$endDate}.xlsx";

            // Pass the data to the LeadOrdersExport constructor
            $export = new LeadOrdersExport($leadResults, $overallTotalRevenue);

            // Store the file temporarily
            $filePath = storage_path("app/exports/{$fileName}");

            // Store the file temporarily
            Excel::store($export, "exports/{$fileName}");

            // Debugging: Check if the file exists
            if (!file_exists($filePath)) {
                Log::error('File was not created at: ' . $filePath);
                return response()->json(['error' => 'File not found.'], 500);
            }

            // If file exists, return download
            return response()->download($filePath, $fileName)->deleteFileAfterSend(true);

        } catch (\Exception $e) {
            // Log error and return message
            Log::error('Error in exportLeadOrders: ' . $e->getMessage());
            return response()->json(['error' => 'An error occurred while generating the file.'], 500);
        }
    }
    public function exportFactoryOrders($startDate, $endDate, $filterColumn,$internal_status)
    {
        $testOrganizationIdSet = $this->getTestOrgId();
        // Fetch orders with their items and factories
        $orders = Order::whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
            ->whereNotNull($filterColumn)
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->where('organization_id', '!=', 1377)
            ->when(!$internal_status, function ($query) {
                $query->whereDoesntHave('organizationDetails', function ($q) {
                    $q->where('internal_team', 1);
                });
            })
            ->whereIn('order_status_id', [3, 4, 8])
            ->with(['orderItems.factoryDetails']) // Load items and factories
            ->get();

        // Initialize factory grouping
        $factoriesData = [];
        $grandTotalAmount = 0;
        foreach ($orders as $order) {
            // To avoid duplicate order count, use a temporary factory tracker for this order
            $factoriesProcessed = [];

            foreach ($order->orderItems as $item) {
                $factoryId = $item->factoryDetails->id ?? 0;
                $factoryName = $item->factoryDetails->factory_name ?? 'Unknown Factory';

                // Initialize factory group if not exists
                if (!isset($factoriesData[$factoryId])) {
                    $factoriesData[$factoryId] = [
                        'factory_id' => $factoryId,
                        'factory_name' => $factoryName,
                        'order_count' => 0,
                        'new_order_count' => 0,
                        'total_revenue' => 0,
                    ];
                }

                // Avoid counting the same order more than once for this factory
                if (!in_array($factoryId, $factoriesProcessed)) {
                    $factoriesProcessed[] = $factoryId;

                    // Increment new order count only if the order is "new"
                    if ($this->isNewOrder($order, $startDate, $endDate)) {
                        $factoriesData[$factoryId]['new_order_count']++;
                    }
                }

                // Update totals
                $factoriesData[$factoryId]['order_count']++;
                $factoriesData[$factoryId]['total_revenue'] += $item->total;
                $grandTotalAmount += $item->total;
            }
        }



        // Convert the result to an array for response and for export
        foreach ($factoriesData as &$factory) {
            $factory['revenue_percentage'] = $grandTotalAmount > 0
                ? round(($factory['total_revenue'] / $grandTotalAmount) * 100, 2)
                : 0;
        }

        $factoriesDataArray = array_values($factoriesData);

        // Create and export Excel
        $fileName = "Factory_Orders_{$startDate}_to_{$endDate}.xlsx";

        // Create export instance
        $export = new FactoryOrdersExport($factoriesDataArray);

        // Store the file temporarily
        $filePath = storage_path("app/exports/{$fileName}");
        Excel::store($export, "exports/{$fileName}");

        // If file exists, return download
        if (!file_exists($filePath)) {
            Log::error('File was not created at: ' . $filePath);
            return response()->json(['error' => 'File not found.'], 500);
        }

        return response()->download($filePath, $fileName)->deleteFileAfterSend(true);
    }



    public function exportOrdersGroupedByCountry($startDate, $endDate, $filterColumn,$internal_status)
    {

        // Fetch orders based on the provided date range and other filters
        $orders = Order::whereIn('order_status_id', [3, 4, 8])
            ->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate])
            ->whereNotNull($filterColumn)
            ->where('write_off_order', 0)
            ->where('active', 1)
            ->whereNotIn('organization_id', $this->getTestOrgId())
            ->where('organization_id', '!=', 1377)
            ->when(!$internal_status, function ($query) {
                $query->whereDoesntHave('organizationDetails', function ($q) {
                    $q->where('internal_team', 1);
                });
            })
            ->with(['userDetails', 'organizationDetails', 'orderItems', 'statusDetails']) // Load related data
            ->get();

        // Group orders by country
        $groupedOrders = $orders->groupBy(function ($order) {
            return $order->organizationDetails->shipping_country ?? 'Country Unknown';
        });

        // Overall totals
        $overallTotalOrders = $orders->count();
        $overallTotalRevenue = $orders->sum('order_total');

        // Process orders grouped by country and handle U.S. states separately
        $CountryOrders = $groupedOrders->map(function ($countryOrders, $country) use ($startDate, $endDate, $overallTotalRevenue) {
            if ($country === 'United States') {
                // Group U.S. orders by state
                $stateGroupedOrders = $countryOrders->groupBy(function ($order) {
                    return $this->getStateShortForm($order->organizationDetails->shipping_state ?? 'State Unknown');
                });

                // Calculate data for each state
                $stateData = $stateGroupedOrders->map(function ($stateOrders, $state) use ($startDate, $endDate, $overallTotalRevenue) {
                    return $this->calculateOrderData($stateOrders, $startDate, $endDate, $state, $overallTotalRevenue);
                });

                // Return the grouped state data for the United States
                return [
                    'group' => 'United States',
                    'total_orders' => $countryOrders->count(),
                    'total_revenue' => $countryOrders->sum('order_total'),
                    'revenue_percentage' => $overallTotalRevenue > 0
                        ? round(($countryOrders->sum('order_total') / $overallTotalRevenue) * 100, 2)
                        : 0,
                    'team_store_orders_count' => $countryOrders->filter(fn($order) => str_contains($order->order_no, 'TSR'))->count(),
                    'bulk_orders_count' => $countryOrders->reject(fn($order) => str_contains($order->order_no, 'TSR'))->count(),
                    'new_orders_count' => $countryOrders->filter(fn($order) => $this->isNewOrder($order, $startDate, $endDate))->count(),
                    'order_details' => $stateData, // State-wise data
                ];
            }

            // Calculate data for non-U.S. countries
            return $this->calculateOrderData($countryOrders, $startDate, $endDate, $country, $overallTotalRevenue);
        });

        // Export U.S. Orders (with states as tabs)
        $usOrdersData = $CountryOrders->firstWhere('group', 'United States')['order_details'];

        $usExport = new USOrdersByStateExport($usOrdersData,$overallTotalRevenue);
        $usFileName = "US_Orders_{$startDate}_to_{$endDate}.xlsx";
        $usFilePath = storage_path("app/exports/{$usFileName}");
        Excel::store($usExport, "exports/{$usFileName}");

        // Export Other Countries Orders (with countries as tabs)
        $otherCountriesData = $CountryOrders->filter(fn($group) => $group['group'] !== 'United States');
        $countryExport = new OtherCountryOrdersExport($otherCountriesData,$overallTotalRevenue);
        $countryFileName = "Other_Countries_Orders_{$startDate}_to_{$endDate}.xlsx";
        $countryFilePath = storage_path("app/exports/{$countryFileName}");
        Excel::store($countryExport, "exports/{$countryFileName}");

        // Create a Zip file and add both Excel files
        $zip = new ZipArchive();
        $zipFileName = "Orders_Export_{$startDate}_to_{$endDate}.zip";
        $zipFilePath = storage_path("app/exports/{$zipFileName}");

        if ($zip->open($zipFilePath, ZipArchive::CREATE) === TRUE) {
            // Add the files to the zip archive
            $zip->addFile($usFilePath, $usFileName);
            $zip->addFile($countryFilePath, $countryFileName);
            $zip->close();
        } else {
            return response()->json(['error' => 'Failed to create ZIP file'], 500);
        }

        // Delete the individual files after zipping
        unlink($usFilePath);
        unlink($countryFilePath);

        // Return the ZIP file for download and delete the file after sending
        return response()->download($zipFilePath, $zipFileName)->deleteFileAfterSend(true);
    }









}
