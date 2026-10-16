<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Carbon\Carbon;
use App\Models\Order;
use App\Models\User;
use App\Models\Sport;
use App\Models\Product;
use App\Models\LeadSource;
use App\Models\Organization;
use App\Models\CheckPayment;
use App\Models\OtherPayment;
use App\Models\VenmoPayment;
use App\Models\PaypalPayment;
use App\Models\PaymentLog;
use App\Models\SavedReport;
use App\Exports\ReportSalesLeadExport;
use App\Exports\ReportSalesLeadMonthExport;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\View;
use Illuminate\Support\Facades\DB;
use Illuminate\Database\Eloquent\Builder;
use PhpOffice\PhpSpreadsheet\Spreadsheet;
use PhpOffice\PhpSpreadsheet\Writer\Xlsx;
use PhpOffice\PhpSpreadsheet\Style\Alignment;
use Spatie\Permission\Models\Role;
use PhpOffice\PhpSpreadsheet\Style\Color;
use PhpOffice\PhpSpreadsheet\Style\Font;

class ReportController extends Controller
{
    private function getTestOrgId()
    {
        // Fetch organization IDs using case-insensitive 'like'
        $orgs = Organization::where('organization_name', 'like', 'Test')
            ->orWhere('organization_name', 'like', 'TEST')
            ->orWhere('organization_name', 'like', 'test')
            ->pluck('id', 'organization_name'); // Optionally retrieve names too
        return $orgs;
    }
    public function index(){

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                            ->where('active', 1);

            if($oderSearch == 'factory'){
                $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                $qry->with('factoryDetails')
                                    ->whereIn('factory_id', $factoryIds)
                                    ->where('order_status_id', 3);
                            }]);
                $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                $qr->whereIn('factory_id', $factoryIds)
                                   ->where('order_status_id', 3);
                            });
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }

            $orders = $orderQuery->where('active', 1)->get();

            $currentYear = Carbon::now()->year;
            $currentMonth = Carbon::now()->month;

            // January
            $ordersJanEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumJanu = $ordersJanEmail->sum('order_total');

            $ordersJanwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumJanu = $ordersJanwalking->sum('order_total');

            $ordersJanonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumJanu = $ordersJanonline->sum('order_total');

            $ordersJanreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumJanu = $ordersJanreferral->sum('order_total');

            $ordersJanOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumJanu = $ordersJanOther->sum('order_total');
            // End January

            // February
            $ordersFebEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumFebu = $ordersFebEmail->sum('order_total');

            $ordersFebwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumFebu = $ordersFebwalking->sum('order_total');

            $ordersFebonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumFebu = $ordersFebonline->sum('order_total');

            $ordersFebreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumFebu = $ordersFebreferral->sum('order_total');

            $ordersfebOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumfebu = $ordersfebOther->sum('order_total');
            // End February

            // March
            $ordersMarchEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumMarchu = $ordersMarchEmail->sum('order_total');

            $ordersMarchwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumMarchu = $ordersMarchwalking->sum('order_total');

            $ordersMarchonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumMarchu = $ordersMarchonline->sum('order_total');

            $ordersMarchreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumMarchu = $ordersMarchreferral->sum('order_total');

            $ordersMarchOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumMarchu = $ordersMarchOther->sum('order_total');
            // End March

            // April
            $ordersAprEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumApru = $ordersAprEmail->sum('order_total');

            $ordersAprwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumApru = $ordersAprwalking->sum('order_total');

            $ordersApronline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumApru = $ordersApronline->sum('order_total');

            $ordersAprreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumApru = $ordersAprreferral->sum('order_total');

            $ordersAprOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumApru = $ordersAprOther->sum('order_total');
            // End April

            // May
            $ordersMayEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumMayu = $ordersMayEmail->sum('order_total');

            $ordersMaywalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumMayu = $ordersMaywalking->sum('order_total');

            $ordersMayonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumMayu = $ordersMayonline->sum('order_total');

            $ordersMayreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumMayu = $ordersMayreferral->sum('order_total');

            $ordersMayOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumMayu = $ordersMayOther->sum('order_total');
            // End May

            // June
            $ordersJunEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumJunu = $ordersJunEmail->sum('order_total');

            $ordersJunwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumJunu = $ordersJunwalking->sum('order_total');

            $ordersJunonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumJunu = $ordersJunonline->sum('order_total');

            $ordersJunreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumJunu = $ordersJunreferral->sum('order_total');

            $ordersJunOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumJunu = $ordersJunOther->sum('order_total');
            // End June

            // July
            $ordersJulEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumJulu = $ordersJulEmail->sum('order_total');

            $ordersJulwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumJulu = $ordersJulwalking->sum('order_total');

            $ordersJulonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumJulu = $ordersJulonline->sum('order_total');

            $ordersJulreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumJulu = $ordersJulreferral->sum('order_total');

            $ordersJulOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumJulu = $ordersJulOther->sum('order_total');
            // End July

            // Augast
            $ordersAugEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumAugu = $ordersAugEmail->sum('order_total');

            $ordersAugwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumAugu = $ordersAugwalking->sum('order_total');

            $ordersAugonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumAugu = $ordersAugonline->sum('order_total');

            $ordersAugreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumAugu = $ordersAugreferral->sum('order_total');

            $ordersAugOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumAugu = $ordersAugOther->sum('order_total');
            // End Augast

            // September
            $ordersSepEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumSepu = $ordersSepEmail->sum('order_total');

            $ordersSepwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumSepu = $ordersSepwalking->sum('order_total');

            $ordersSeponline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumSepu = $ordersSeponline->sum('order_total');

            $ordersSepreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumSepu = $ordersSepreferral->sum('order_total');
            $ordersSepOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumSepu = $ordersSepOther->sum('order_total');
            // End September

            // October
            $ordersOctEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumOctu = $ordersOctEmail->sum('order_total');

            $ordersOctwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumOctu = $ordersOctwalking->sum('order_total');

            $ordersOctonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumOctu = $ordersOctonline->sum('order_total');

            $ordersOctreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumOctu = $ordersOctreferral->sum('order_total');

            $ordersOctOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumOctu = $ordersOctOther->sum('order_total');
            // End October

            // November
            $ordersNovEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumNovu = $ordersNovEmail->sum('order_total');

            $ordersNovwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumNovu = $ordersNovwalking->sum('order_total');

            $ordersNovonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumNovu = $ordersNovonline->sum('order_total');

            $ordersNovreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumNovu = $ordersNovreferral->sum('order_total');

            $ordersNovOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumNovu = $ordersNovOther->sum('order_total');
            // End November

            // December
            $ordersDecEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumDecu = $ordersDecEmail->sum('order_total');

            $ordersDecwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumDecu = $ordersDecwalking->sum('order_total');

            $ordersDeconline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumDecu = $ordersDeconline->sum('order_total');

            $ordersDecreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumDecu = $ordersDecreferral->sum('order_total');

            $ordersDecOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumDecu = $ordersDecOther->sum('order_total');
            // End December


            // Sales Summary Table
            $emailOrder = $orders->filter(function ($order) use ($currentYear, $currentMonth) {
                return $order->created_at->year == $currentYear &&
                    $order->created_at->month == $currentMonth &&
                    $order->organizationDetails->lead_source == 1;
            });

            $emailOrders = $emailOrder->take(5)->all();;
            // End Sales Summary Table

            //Pie Chart details
            $emailOrderPie = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear &&
                    $order->organizationDetails->lead_source == 1;
            });
            $currentEmailTotal = $emailOrderPie->sum('order_total');
            $currentEmailTotal2 = number_format($currentEmailTotal, 2);
            $emailOrderPieCount = $emailOrderPie->count();

            $walkOrderPie = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear &&
                    $order->organizationDetails->lead_source == 2;
            });
            $currentWalkTotal = $walkOrderPie->sum('order_total');
            $currentWalkTotal2 = number_format($currentWalkTotal, 2);
            $walkOrderPieCount = $walkOrderPie->count();

            $onlineOrderPie = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear &&
                    $order->organizationDetails->lead_source == 3;
            });
            $currentOnlineTotal = $onlineOrderPie->sum('order_total');
            $currentOnlineTotal2 = number_format($currentOnlineTotal, 2);
            $onlineOrderPieCount = $onlineOrderPie->count();


            $referralOrderPie = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear &&
                    $order->organizationDetails->lead_source == 6;
            });
            $currentReferralTotal = $referralOrderPie->sum('order_total');
            $currentReferralTotal2 = number_format($currentReferralTotal, 2);
            $referralOrderPieCount = $referralOrderPie->count();


            $otherOrderPie = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear &&
                    !in_array($order->organizationDetails->lead_source, [1, 2, 3, 6]);
            });

            $currentOtherTotal = $otherOrderPie->sum('order_total');
            $currentOtherotal2 = number_format($currentOtherTotal, 2);
            $otherOrderPieCount = $otherOrderPie->count();


            $currentTotalSale = $currentEmailTotal + $currentWalkTotal + $currentOnlineTotal + $currentReferralTotal + $currentOtherTotal;
            $currentTotalSale2 = number_format($currentTotalSale, 2);

            if ($currentTotalSale != 0) {
                $emailPercentage = number_format(($currentEmailTotal * 100) / $currentTotalSale, 2);
                $walkPercentage = number_format(($currentWalkTotal * 100) / $currentTotalSale, 2);
                $onlinePercentage = number_format(($currentOnlineTotal * 100) / $currentTotalSale, 2);
                $referralPercentage = number_format(($currentReferralTotal * 100) / $currentTotalSale, 2);
                $otherPercentage = number_format(($currentOtherTotal * 100) / $currentTotalSale, 2);
            } else {
                $emailPercentage = 0;
                $walkPercentage = 0;
                $onlinePercentage = 0;
                $referralPercentage = 0;
                $otherPercentage = 0;
            }


            //End Pie Chart Details

        // dd($referralPercentage);

        return view('pages.reports.sales_lead.index', ['orderEmailSumJanu'=>$orderEmailSumJanu, 'orderwalkingSumJanu'=>$orderwalkingSumJanu, 'orderreferralSumJanu'=>$orderreferralSumJanu, 'orderOtherSumJanu'=>$orderOtherSumJanu,
                    'orderonlineSumJanu'=>$orderonlineSumJanu, 'orderEmailSumFebu'=>$orderEmailSumFebu, 'orderwalkingSumFebu'=>$orderwalkingSumFebu, 'orderreferralSumFebu'=>$orderreferralSumFebu, 'orderOtherSumfebu'=>$orderOtherSumfebu,
                    'orderonlineSumFebu'=>$orderonlineSumFebu,'orderEmailSumMarchu'=>$orderEmailSumMarchu, 'orderwalkingSumMarchu'=>$orderwalkingSumMarchu, 'orderreferralSumMarchu'=>$orderreferralSumMarchu, 'orderOtherSumMarchu'=>$orderOtherSumMarchu,
                    'orderonlineSumMarchu'=>$orderonlineSumMarchu, 'orderEmailSumApru'=>$orderEmailSumApru, 'orderwalkingSumApru'=>$orderwalkingSumApru, 'orderreferralSumApru'=>$orderreferralSumApru, 'orderOtherSumApru'=>$orderOtherSumApru,
                    'orderonlineSumApru'=>$orderonlineSumApru, 'orderEmailSumMayu'=>$orderEmailSumMayu, 'orderwalkingSumMayu'=>$orderwalkingSumMayu, 'orderreferralSumMayu'=>$orderreferralSumMayu, 'orderOtherSumMayu'=>$orderOtherSumMayu,
                    'orderonlineSumMayu'=>$orderonlineSumMayu, 'orderEmailSumJunu'=>$orderEmailSumJunu, 'orderwalkingSumJunu'=>$orderwalkingSumJunu, 'orderreferralSumJunu'=>$orderreferralSumJunu, 'orderOtherSumJunu'=>$orderOtherSumJunu,
                    'orderonlineSumJunu'=>$orderonlineSumJunu, 'orderEmailSumJulu'=>$orderEmailSumJulu, 'orderwalkingSumJulu'=>$orderwalkingSumJulu, 'orderreferralSumJulu'=>$orderreferralSumJulu, 'orderOtherSumJulu'=>$orderOtherSumJulu,
                    'orderonlineSumJulu'=>$orderonlineSumJulu, 'orderEmailSumAugu'=>$orderEmailSumAugu, 'orderwalkingSumAugu'=>$orderwalkingSumAugu, 'orderreferralSumAugu'=>$orderreferralSumAugu, 'orderOtherSumAugu'=>$orderOtherSumAugu,
                    'orderonlineSumAugu'=>$orderonlineSumAugu, 'orderEmailSumSepu'=>$orderEmailSumSepu, 'orderwalkingSumSepu'=>$orderwalkingSumSepu, 'orderreferralSumSepu'=>$orderreferralSumSepu, 'orderOtherSumSepu'=>$orderOtherSumSepu,
                    'orderonlineSumSepu'=>$orderonlineSumSepu, 'orderEmailSumOctu'=>$orderEmailSumOctu, 'orderwalkingSumOctu'=>$orderwalkingSumOctu, 'orderreferralSumOctu'=>$orderreferralSumOctu, 'orderOtherSumOctu'=>$orderOtherSumOctu,
                    'orderonlineSumOctu'=>$orderonlineSumOctu, 'orderEmailSumNovu'=>$orderEmailSumNovu, 'orderwalkingSumNovu'=>$orderwalkingSumNovu, 'orderreferralSumNovu'=>$orderreferralSumNovu, 'orderOtherSumNovu'=>$orderOtherSumNovu,
                    'orderonlineSumNovu'=>$orderonlineSumNovu, 'orderEmailSumDecu'=>$orderEmailSumDecu, 'orderwalkingSumDecu'=>$orderwalkingSumDecu, 'orderreferralSumDecu'=>$orderreferralSumDecu, 'orderOtherSumDecu'=>$orderOtherSumDecu,
                    'orderonlineSumDecu'=>$orderonlineSumDecu, 'emailOrders'=>$emailOrders, 'emailPercentage'=>$emailPercentage, 'walkPercentage'=>$walkPercentage, 'otherPercentage'=>$otherPercentage,
                    'onlinePercentage'=>$onlinePercentage, 'referralPercentage'=>$referralPercentage, 'currentEmailTotal2'=>$currentEmailTotal2, 'currentWalkTotal2'=>$currentWalkTotal2,
                    'currentOnlineTotal2'=>$currentOnlineTotal2, 'currentReferralTotal2'=>$currentReferralTotal2, 'emailOrderPieCount'=>$emailOrderPieCount, 'walkOrderPieCount'=>$walkOrderPieCount,
                    'onlineOrderPieCount'=>$onlineOrderPieCount, 'referralOrderPieCount'=>$referralOrderPieCount, 'currentTotalSale2'=>$currentTotalSale2, 'currentOtherotal2'=>$currentOtherotal2, 'otherOrderPieCount'=>$otherOrderPieCount]);
    }
    public function sales_summary(){

        $users = User::where('role_id', 'like', '%"3"%')->get();
        $sports = Sport::where('active', 1)->get();
        $products = Product::where('active', 1)->get();
        $lead_sources = LeadSource::where('active', 1)->get();
        $organization_countries = Organization::where('active',1)->pluck('shipping_country')->toArray();

        $uppercase_countries = array_map(function($country) {return strtoupper(trim($country));}, $organization_countries);

        $unique_uppercase_countries = array_unique($uppercase_countries);

        $organization_countries = $unique_uppercase_countries;

        return view('pages.reports.sales_summary.index', ['users' => $users, 'sports' => $sports, 'products'=>$products, 'lead_sources'=>$lead_sources, 'organization_countries'=>$organization_countries]);
    }
    public function exportCsv(Request $request)
    {
        $data = $this->get_summary_report_data($request);

        // Extract data if it's a JsonResponse
        if ($data instanceof \Illuminate\Http\JsonResponse) {
            $data = $data->getData(true); // Convert JSON response to an array
        }

        $fileName = $request->report_name . '.xlsx';

        // Create a new Spreadsheet object
        $spreadsheet = new Spreadsheet();

        // Create a new worksheet for the summary report
        $mainSheet = $spreadsheet->getActiveSheet();
        $mainSheet->setTitle('Report Summary');

                // Add heading with underline to the summary sheet
        $mainSheet->setCellValue('A1', 'Summary of Data');
        $mainSheet->mergeCells('A1:B1'); // Merge cells for the heading
        $mainSheet->getStyle('A1')->getFont()->setBold(true)->setUnderline(true)->setSize(14);
        $mainSheet->getStyle('A1')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_CENTER);

        // Add summary table data
        $mainSheet->setCellValue('A3', 'Number of Sales');
        $mainSheet->setCellValue('B3', count($data['orders']));
        $mainSheet->setCellValue('A4', 'Total Sales ($)');
        $mainSheet->setCellValue('B4', array_sum(array_column($data['orders'], 'order_total')));
        $mainSheet->setCellValue('A5', 'Date Range');
        $dateFilterText = '';
        switch ($request->dateFilter) {
            case 'thisYear':
                $dateFilterText = 'This year';
                break;
            case 'thisMonth':
                $dateFilterText = 'This month';
                break;
            case 'lastMonth':
                $dateFilterText = 'Last month';
                break;
            case 'lastYearToday':
                $dateFilterText = 'Last year to date';
                break;
            case 'thisQuarter':
                $dateFilterText = 'This quarter';
                break;
            default:
                $dateFilterText = $request->start_date . ' - ' . $request->end_date;
                break;
        }
        $mainSheet->setCellValue('B5', $dateFilterText);
        $mainSheet->setCellValue('A6', 'User');
        $user_name = User::find($request->user_filter);
        $mainSheet->setCellValue('B6', $user_name ? $user_name->name : $request->user_filter);
        $mainSheet->setCellValue('A7', 'Order Processing Rep');
        $rep_name = User::find($request->order_processing_rep);
        $mainSheet->setCellValue('B7', $rep_name ? $rep_name->name : $request->order_processing_rep);
        $mainSheet->setCellValue('A8', 'Sport');
        $mainSheet->setCellValue('B8', $request->sport_filter);
        $mainSheet->setCellValue('A9', 'Lead Source');
        $lead_source_name = LeadSource::find($request->lead_source_filter);
        $mainSheet->setCellValue('B9', $lead_source_name ? $lead_source_name->lead_source_name : $request->lead_source_filter);
        $mainSheet->setCellValue('A10', 'Sale Type');

        if ($request->sale_type_filter == 'all') {
            $saleType = 'all';
        } elseif ($request->sale_type_filter == 1) {
            $saleType = 'Return sale';
        } elseif ($request->sale_type_filter == 0) {
            $saleType = 'New sale';
        }

        $mainSheet->setCellValue('B10', $saleType);
        $mainSheet->setCellValue('A11', 'Location');
        $mainSheet->setCellValue('B11', $request->location_filter);
        $mainSheet->setCellValue('A12', 'Product');
        $product_name = Product::find($request->product_filter);
        $mainSheet->setCellValue('B12', $product_name ? $product_name->product_name : $request->product_filter);
        $mainSheet->setCellValue('A13', 'Order Type');
        $mainSheet->setCellValue('B13', $request->order_type);

        // Apply borders to the table
        $tableRange = 'A3:B13';
        $mainSheet->getStyle($tableRange)->getBorders()->getAllBorders()->setBorderStyle(\PhpOffice\PhpSpreadsheet\Style\Border::BORDER_THIN);

        // Adjust column widths
        $mainSheet->getColumnDimension('A')->setWidth(20);
        $mainSheet->getColumnDimension('B')->setWidth(50);

        // Set alignment for the summary table
        $mainSheet->getStyle('A3:A13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);
        $mainSheet->getStyle('B3:B13')->getAlignment()->setHorizontal(Alignment::HORIZONTAL_LEFT);


        // Define columns for the main data sheet
        $columns = [
            'Order No', 'Organization Name', 'Sales Lead', 'Item Qty', 'Total ($)', 'Created Date',
            'Production Date', 'In Hand Due Date', 'Status', 'Order Description', 'Sub Total ($)',
            'Sales Tax ($)', 'Shipping ($)', 'Artwork ($)', 'Processing Fee ($)'
        ];

        $summarySheet = $spreadsheet->createSheet();
        $summarySheet->setTitle('Detail Report');

        // Set column headers for the main data sheet
        $colIndex = 1;
        foreach ($columns as $column) {
            $summarySheet->setCellValueByColumnAndRow($colIndex, 1, $column);
            $colIndex++;
        }

        // Add data rows to the main data sheet
        $rowIndex = 2;
        foreach ($data['orders'] as $order) {
            $summarySheet->setCellValueByColumnAndRow(1, $rowIndex, $order['order_no']);
            $summarySheet->setCellValueByColumnAndRow(2, $rowIndex, $order['organization_details']['organization_name']);
            $summarySheet->setCellValueByColumnAndRow(3, $rowIndex, $order['user_details']['name']);
            $summarySheet->setCellValueByColumnAndRow(4, $rowIndex, array_reduce($order['order_items'], fn($sum, $item) => $sum + $item['qty'], 0));
            $summarySheet->setCellValueByColumnAndRow(5, $rowIndex, number_format((float)$order['order_total'], 2, '.', ','));
            $summarySheet->setCellValueByColumnAndRow(6, $rowIndex, $order['open_date']);
            $summarySheet->setCellValueByColumnAndRow(7, $rowIndex, $order['production_date']);
            $summarySheet->setCellValueByColumnAndRow(8, $rowIndex, $order['due_date']);
            $summarySheet->setCellValueByColumnAndRow(9, $rowIndex, $order['status_details']['status_name']);
            $summarySheet->setCellValueByColumnAndRow(10, $rowIndex, $order['order_description']);
            $summarySheet->setCellValueByColumnAndRow(11, $rowIndex, number_format((float)$order['sub_total'], 2, '.', ','));
            $summarySheet->setCellValueByColumnAndRow(12, $rowIndex, number_format((float)$order['sales_tax'], 2, '.', ','));
            $summarySheet->setCellValueByColumnAndRow(13, $rowIndex, number_format((float)$order['shipping'], 2, '.', ','));
            $summarySheet->setCellValueByColumnAndRow(14, $rowIndex, number_format((float)$order['artwork'], 2, '.', ','));
            $summarySheet->setCellValueByColumnAndRow(15, $rowIndex, number_format((float)$order['processing_fee'], 2, '.', ','));
            $rowIndex++;
        }


        $spreadsheet->setActiveSheetIndex(0);

        // Set headers for download
        header('Content-Type: application/vnd.openxmlformats-officedocument.spreadsheetml.sheet');
        header("Content-Disposition: attachment; filename=\"$fileName\"");

        // Write and save the file to output
        $writer = new Xlsx($spreadsheet);
        $writer->save('php://output');
        exit;
    }

    public function get_summary_report_data(Request $request){
        // dd($request);

        $testOrganizationIdSet = $this->getTestOrgId();
                $filterColumn = $request->filterColumn;
                $orders = Order::whereNotNull($filterColumn)
            ->where(function ($query) {
                $query->whereNull('order_description')
                    ->orWhereRaw(
                        'LOWER(order_description) NOT LIKE ?',
                        ['%remake%']
                    );
            })
            ->where('active', 1)
            ->whereNotIn('organization_id', $testOrganizationIdSet)
            ->whereIn('order_status_id', [3, 4, 8])
            ->where('write_off_order', 0)
            ->where('organization_id', '!=', 1377)
            ->with([
                'organizationDetails',
                'userDetails',
                'contactDetails',
                'statusDetails',
                'teamStoreDetails',
                'orderItems',
            ]);

        $all_orders = $orders;

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
            $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

            $orders = $orders->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate]);

        }

        if (!empty($request->user_filter) && $request->user_filter != 'all') {
            $orders = $orders->where('user_id', $request->user_filter);
        }
        if (!empty($request->order_processing_rep) && $request->order_processing_rep != 'all') {
            $orders = $orders->where('order_procesing_user_id', $request->order_processing_rep);
        }

        if (!empty($request->sport_filter) && $request->sport_filter != 'all') {
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('sport', $request->sport_filter);
            });
        }

        if (!empty($request->lead_source_filter) && $request->lead_source_filter != 'all') {
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('lead_source', $request->lead_source_filter);
            });
        }

        $searchText = strtolower(trim($request->search_query ?? ''));

        if (!empty($searchText)) {
            $orders = $orders->where(function ($query) use ($searchText) {
                $query->whereRaw('LOWER(order_no) LIKE ?', ["%{$searchText}%"])
                    ->orWhereHas('organizationDetails', function ($q) use ($searchText) {
                        $q->whereRaw('LOWER(organization_name) LIKE ?', ["%{$searchText}%"]);
                    });
            });
        }

        if (!empty($request->location_filter) && $request->location_filter != 'all') {
            $locationFilter = strtoupper(trim($request->location_filter));
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($locationFilter) {
                $query->whereRaw("UPPER(TRIM(shipping_country)) = ?", [$locationFilter]);
            });
        }
        if (!empty($request->product_filter) && $request->product_filter != 'all') {
            $productFilter = $request->product_filter;

            $orders = $orders->whereHas('orderItems', function ($query) use ($productFilter) {
                $query->where('active', 1)
                      ->whereNull('deleted_at')
                      ->where('product_id', $productFilter);
            });
        }


        $orders = $orders->get();
         // Now apply 'order_types' filter on the collection after fetching the orders
        if (!empty($request->order_types)) {
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

        if (!empty($request->sale_type_filter) && $request->sale_type_filter != 'all') {

            if ($request->sale_type_filter == 1) {
                $filteredOrders = $orders->filter(function ($order) use ($all_orders) {
                    $matchingOrders = $all_orders->filter(function ($otherOrder) use ($order) {
                        return $otherOrder->organization_id == $order->organization_id &&
                               $otherOrder->created_at < $order->created_at;
                    });

                    return $matchingOrders->count() > 1;
                });

                $orders = $filteredOrders->values();
            }
            if ($request->sale_type_filter == 0) {
                $filteredOrders = $orders->filter(function ($order) use ($all_orders) {
                    $matchingOrders = $all_orders->filter(function ($otherOrder) use ($order) {
                        return $otherOrder->organization_id == $order->organization_id &&
                               $otherOrder->created_at < $order->created_at;
                    });

                    return $matchingOrders->isEmpty() || ($matchingOrders->count() == 1 && $order->created_at->diffInMonths($matchingOrders->first()->created_at) < 6);
                });

                $orders = $filteredOrders->values();
            }
        }

        $total_sale = $orders->sum('order_total');
        $number_of_sale = $orders->count();

        return response()->json(['orders'=>$orders, 'total_sale'=>$total_sale, 'number_of_sale'=>$number_of_sale]);
    }

    public function UpdateBarChartLead($selectedYear) {


        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                            ->where('active', 1);

            if($oderSearch == 'factory'){
                $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                $qry->with('factoryDetails')
                                    ->whereIn('factory_id', $factoryIds)
                                    ->where('order_status_id', 3);
                            }]);
                $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                $qr->whereIn('factory_id', $factoryIds)
                                   ->where('order_status_id', 3);
                            });
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }

            $orders = $orderQuery->where('active', 1)->get();

            $currentYear = $selectedYear;

            // January
            $ordersJanEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumJanu = $ordersJanEmail->sum('order_total');

            $ordersJanwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumJanu = $ordersJanwalking->sum('order_total');

            $ordersJanonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumJanu = $ordersJanonline->sum('order_total');

            $ordersJanreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumJanu = $ordersJanreferral->sum('order_total');

            $ordersJanOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 1 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumJanu = $ordersJanOther->sum('order_total');
            // End January

            // February
            $ordersFebEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumFebu = $ordersFebEmail->sum('order_total');

            $ordersFebwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumFebu = $ordersFebwalking->sum('order_total');

            $ordersFebonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumFebu = $ordersFebonline->sum('order_total');

            $ordersFebreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumFebu = $ordersFebreferral->sum('order_total');

            $ordersfebOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 2 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumfebu = $ordersfebOther->sum('order_total');
            // End February

            // March
            $ordersMarchEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumMarchu = $ordersMarchEmail->sum('order_total');

            $ordersMarchwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumMarchu = $ordersMarchwalking->sum('order_total');

            $ordersMarchonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumMarchu = $ordersMarchonline->sum('order_total');

            $ordersMarchreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumMarchu = $ordersMarchreferral->sum('order_total');

            $ordersMarchOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 3 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumMarchu = $ordersMarchOther->sum('order_total');
            // End March

            // April
            $ordersAprEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumApru = $ordersAprEmail->sum('order_total');

            $ordersAprwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumApru = $ordersAprwalking->sum('order_total');

            $ordersApronline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumApru = $ordersApronline->sum('order_total');

            $ordersAprreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumApru = $ordersAprreferral->sum('order_total');

            $ordersAprOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 4 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumApru = $ordersAprOther->sum('order_total');
            // End April

            // May
            $ordersMayEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumMayu = $ordersMayEmail->sum('order_total');

            $ordersMaywalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumMayu = $ordersMaywalking->sum('order_total');

            $ordersMayonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumMayu = $ordersMayonline->sum('order_total');

            $ordersMayreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumMayu = $ordersMayreferral->sum('order_total');

            $ordersMayOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 5 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumMayu = $ordersMayOther->sum('order_total');
            // End May

            // June
            $ordersJunEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumJunu = $ordersJunEmail->sum('order_total');

            $ordersJunwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumJunu = $ordersJunwalking->sum('order_total');

            $ordersJunonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumJunu = $ordersJunonline->sum('order_total');

            $ordersJunreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumJunu = $ordersJunreferral->sum('order_total');

            $ordersJunOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 6 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumJunu = $ordersJunOther->sum('order_total');
            // End June

            // July
            $ordersJulEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumJulu = $ordersJulEmail->sum('order_total');

            $ordersJulwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumJulu = $ordersJulwalking->sum('order_total');

            $ordersJulonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumJulu = $ordersJulonline->sum('order_total');

            $ordersJulreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumJulu = $ordersJulreferral->sum('order_total');

            $ordersJulOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 7 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumJulu = $ordersJulOther->sum('order_total');
            // End July

            // Augast
            $ordersAugEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumAugu = $ordersAugEmail->sum('order_total');

            $ordersAugwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumAugu = $ordersAugwalking->sum('order_total');

            $ordersAugonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumAugu = $ordersAugonline->sum('order_total');

            $ordersAugreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumAugu = $ordersAugreferral->sum('order_total');

            $ordersAugOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 8 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumAugu = $ordersAugOther->sum('order_total');
            // End Augast

            // September
            $ordersSepEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumSepu = $ordersSepEmail->sum('order_total');

            $ordersSepwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumSepu = $ordersSepwalking->sum('order_total');

            $ordersSeponline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumSepu = $ordersSeponline->sum('order_total');

            $ordersSepreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumSepu = $ordersSepreferral->sum('order_total');

            $ordersSepOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 9 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumSepu = $ordersSepOther->sum('order_total');
            // End September

            // October
            $ordersOctEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumOctu = $ordersOctEmail->sum('order_total');

            $ordersOctwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumOctu = $ordersOctwalking->sum('order_total');

            $ordersOctonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumOctu = $ordersOctonline->sum('order_total');

            $ordersOctreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumOctu = $ordersOctreferral->sum('order_total');

            $ordersOctOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 10 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumOctu = $ordersOctOther->sum('order_total');
            // End October

            // November
            $ordersNovEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumNovu = $ordersNovEmail->sum('order_total');

            $ordersNovwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumNovu = $ordersNovwalking->sum('order_total');

            $ordersNovonline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumNovu = $ordersNovonline->sum('order_total');

            $ordersNovreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumNovu = $ordersNovreferral->sum('order_total');

            $ordersNovOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 11 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumNovu = $ordersNovOther->sum('order_total');
            // End November

            // December
            $ordersDecEmail = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 1;
            });

            $orderEmailSumDecu = $ordersDecEmail->sum('order_total');

            $ordersDecwalking = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 2;
            });

            $orderwalkingSumDecu = $ordersDecwalking->sum('order_total');

            $ordersDeconline = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 3;
            });

            $orderonlineSumDecu = $ordersDeconline->sum('order_total');

            $ordersDecreferral = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && $order->organizationDetails->lead_source == 6;
            });

            $orderreferralSumDecu = $ordersDecreferral->sum('order_total');

            $ordersDecOther = $orders->filter(function ($order) use ($currentYear) {
                return $order->created_at->year == $currentYear && $order->created_at->month == 12 && !in_array($order->organizationDetails->lead_source, ['1', '2', '3', '6']);
            });

            $orderOtherSumDecu = $ordersDecOther->sum('order_total');

            return response()->json(['orderEmailSumJanu'=>$orderEmailSumJanu, 'orderwalkingSumJanu'=>$orderwalkingSumJanu, 'orderreferralSumJanu'=>$orderreferralSumJanu, 'orderOtherSumJanu'=>$orderOtherSumJanu,
            'orderonlineSumJanu'=>$orderonlineSumJanu, 'orderEmailSumFebu'=>$orderEmailSumFebu, 'orderwalkingSumFebu'=>$orderwalkingSumFebu, 'orderreferralSumFebu'=>$orderreferralSumFebu, 'orderOtherSumfebu'=>$orderOtherSumfebu,
            'orderonlineSumFebu'=>$orderonlineSumFebu,'orderEmailSumMarchu'=>$orderEmailSumMarchu, 'orderwalkingSumMarchu'=>$orderwalkingSumMarchu, 'orderreferralSumMarchu'=>$orderreferralSumMarchu, 'orderOtherSumMarchu'=>$orderOtherSumMarchu,
            'orderonlineSumMarchu'=>$orderonlineSumMarchu, 'orderEmailSumApru'=>$orderEmailSumApru, 'orderwalkingSumApru'=>$orderwalkingSumApru, 'orderreferralSumApru'=>$orderreferralSumApru, 'orderOtherSumApru'=>$orderOtherSumApru,
            'orderonlineSumApru'=>$orderonlineSumApru, 'orderEmailSumMayu'=>$orderEmailSumMayu, 'orderwalkingSumMayu'=>$orderwalkingSumMayu, 'orderreferralSumMayu'=>$orderreferralSumMayu, 'orderOtherSumMayu'=>$orderOtherSumMayu,
            'orderonlineSumMayu'=>$orderonlineSumMayu, 'orderEmailSumJunu'=>$orderEmailSumJunu, 'orderwalkingSumJunu'=>$orderwalkingSumJunu, 'orderreferralSumJunu'=>$orderreferralSumJunu, 'orderOtherSumJunu'=>$orderOtherSumJunu,
            'orderonlineSumJunu'=>$orderonlineSumJunu, 'orderEmailSumJulu'=>$orderEmailSumJulu, 'orderwalkingSumJulu'=>$orderwalkingSumJulu, 'orderreferralSumJulu'=>$orderreferralSumJulu, 'orderOtherSumJulu'=>$orderOtherSumJulu,
            'orderonlineSumJulu'=>$orderonlineSumJulu, 'orderEmailSumAugu'=>$orderEmailSumAugu, 'orderwalkingSumAugu'=>$orderwalkingSumAugu, 'orderreferralSumAugu'=>$orderreferralSumAugu, 'orderOtherSumAugu'=>$orderOtherSumAugu,
            'orderonlineSumAugu'=>$orderonlineSumAugu, 'orderEmailSumSepu'=>$orderEmailSumSepu, 'orderwalkingSumSepu'=>$orderwalkingSumSepu, 'orderreferralSumSepu'=>$orderreferralSumSepu, 'orderOtherSumSepu'=>$orderOtherSumSepu,
            'orderonlineSumSepu'=>$orderonlineSumSepu, 'orderEmailSumOctu'=>$orderEmailSumOctu, 'orderwalkingSumOctu'=>$orderwalkingSumOctu, 'orderreferralSumOctu'=>$orderreferralSumOctu, 'orderOtherSumOctu'=>$orderOtherSumOctu,
            'orderonlineSumOctu'=>$orderonlineSumOctu, 'orderEmailSumNovu'=>$orderEmailSumNovu, 'orderwalkingSumNovu'=>$orderwalkingSumNovu, 'orderreferralSumNovu'=>$orderreferralSumNovu, 'orderOtherSumNovu'=>$orderOtherSumNovu,
            'orderonlineSumNovu'=>$orderonlineSumNovu, 'orderEmailSumDecu'=>$orderEmailSumDecu, 'orderwalkingSumDecu'=>$orderwalkingSumDecu, 'orderreferralSumDecu'=>$orderreferralSumDecu, 'orderOtherSumDecu'=>$orderOtherSumDecu,
            'orderonlineSumDecu'=>$orderonlineSumDecu]);
    }

    public function leadRepostTable(Request $request){

        $Selectedyear = $request->input('year');
        $Selectedmonth = $request->input('month');
        $Selectedcategory = $request->input('category');

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                            ->where('active', 1);

            if($oderSearch == 'factory'){
                $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                $qry->with('factoryDetails')
                                    ->whereIn('factory_id', $factoryIds)
                                    ->where('order_status_id', 3);
                            }]);
                $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                $qr->whereIn('factory_id', $factoryIds)
                                   ->where('order_status_id', 3);
                            });
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }

            $orders = $orderQuery->where('active', 1)->get();

            $emailOrders = $orders->filter(function ($order) use ($Selectedyear, $Selectedmonth, $Selectedcategory) {
                if ($Selectedcategory == 'other') {
                    return $order->created_at->year == $Selectedyear &&
                           $order->created_at->month == $Selectedmonth &&
                           !in_array($order->organizationDetails->lead_source, [1, 2, 3, 6]);
                } else {
                    return $order->created_at->year == $Selectedyear &&
                           $order->created_at->month == $Selectedmonth &&
                           $order->organizationDetails->lead_source == $Selectedcategory;
                }
            });


        return response()->json(['emailOrders'=>$emailOrders]);
    }

    public function UpdatePieChartLead($selectedYear){

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                            ->where('active', 1);

            if($oderSearch == 'factory'){
                $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                $qry->with('factoryDetails')
                                    ->whereIn('factory_id', $factoryIds)
                                    ->where('order_status_id', 3);
                            }]);
                $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                                $qr->whereIn('factory_id', $factoryIds)
                                   ->where('order_status_id', 3);
                            });
            } else {
                $orderQuery->with('orderItems.factoryDetails');
            }

            $orders = $orderQuery->where('active', 1)->get();

        //Pie Chart details
        $emailOrderPie = $orders->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear &&
                $order->organizationDetails->lead_source == 1;
        });
        $currentEmailTotal = $emailOrderPie->sum('order_total');
        $currentEmailTotal2 = number_format($currentEmailTotal, 2);
        $emailOrderPieCount = $emailOrderPie->count();

        $walkOrderPie = $orders->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear &&
                $order->organizationDetails->lead_source == 2;
        });
        $currentWalkTotal = $walkOrderPie->sum('order_total');
        $currentWalkTotal2 = number_format($currentWalkTotal, 2);
        $walkOrderPieCount = $walkOrderPie->count();

        $onlineOrderPie = $orders->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear &&
                $order->organizationDetails->lead_source == 3;
        });
        $currentOnlineTotal = $onlineOrderPie->sum('order_total');
        $currentOnlineTotal2 = number_format($currentOnlineTotal, 2);
        $onlineOrderPieCount = $onlineOrderPie->count();


        $referralOrderPie = $orders->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear &&
                $order->organizationDetails->lead_source == 6;
        });
        $currentReferralTotal = $referralOrderPie->sum('order_total');
        $currentReferralTotal2 = number_format($currentReferralTotal, 2);
        $referralOrderPieCount = $referralOrderPie->count();

        $otherOrderPie = $orders->filter(function ($order) use ($selectedYear) {
            return $order->created_at->year == $selectedYear &&
                !in_array($order->organizationDetails->lead_source, [1, 2, 3, 6]);
        });

        $currentOtherTotal = $otherOrderPie->sum('order_total');
        $currentOtherTotal2 = number_format($currentOtherTotal, 2);
        $otherOrderPieCount = $otherOrderPie->count();

        $currentTotalSale = $currentEmailTotal + $currentWalkTotal + $currentOnlineTotal + $currentReferralTotal + $currentOtherTotal;
        $currentTotalSale2 = number_format($currentTotalSale, 2);

        $emailPercentage = number_format(($currentEmailTotal * 100) / $currentTotalSale, 2);
        $walkPercentage = number_format(($currentWalkTotal * 100) / $currentTotalSale, 2);
        $onlinePercentage = number_format(($currentOnlineTotal * 100) / $currentTotalSale, 2);
        $referralPercentage = number_format(($currentReferralTotal * 100) / $currentTotalSale, 2);
        $otherPercentage = number_format(($currentOtherTotal * 100) / $currentTotalSale, 2);

        //End Pie Chart Details

        return response()->json(['emailPercentage'=>$emailPercentage, 'walkPercentage'=>$walkPercentage,
                        'onlinePercentage'=>$onlinePercentage, 'referralPercentage'=>$referralPercentage, 'currentEmailTotal2'=>$currentEmailTotal2, 'currentWalkTotal2'=>$currentWalkTotal2,
                        'currentOnlineTotal2'=>$currentOnlineTotal2, 'currentReferralTotal2'=>$currentReferralTotal2, 'emailOrderPieCount'=>$emailOrderPieCount, 'walkOrderPieCount'=>$walkOrderPieCount,
                        'onlineOrderPieCount'=>$onlineOrderPieCount, 'referralOrderPieCount'=>$referralOrderPieCount, 'currentTotalSale2'=>$currentTotalSale2,
                        'currentOtherTotal2'=>$currentOtherTotal2, 'otherOrderPieCount'=>$otherOrderPieCount, 'otherPercentage'=>$otherPercentage]);
    }

    public function viewOrder(Request $request){
        $Selectedyear = $request->input('year');
        $Selectedcategory = $request->input('category');

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'contactDetails', 'statusDetails', 'teamStoreDetails')
                            ->where('active', 1);

        if($oderSearch == 'factory'){
            $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                            $qry->with('factoryDetails')
                                ->whereIn('factory_id', $factoryIds)
                                ->where('order_status_id', 3);
                        }]);
            $orderQuery->whereHas('orderItems', function($qr) use($factoryIds){
                            $qr->whereIn('factory_id', $factoryIds)
                               ->where('order_status_id', 3);
                        });
        } else {
            $orderQuery->with('orderItems.factoryDetails');
        }

        $orders = $orderQuery->where('active', 1)->get();

        // $viewOrders = $orders->filter(function ($order) use ($Selectedyear, $Selectedcategory) {
        //     return $order->created_at->year == $Selectedyear && $order->organizationDetails->lead_source == $Selectedcategory;
        // });

        $viewOrders = $orders->filter(function ($order) use ($Selectedyear, $Selectedcategory) {
            if ($Selectedcategory == 'other') {
                return $order->created_at->year == $Selectedyear &&
                       !in_array($order->organizationDetails->lead_source, [1, 2, 3, 6]);
            } else {
                return $order->created_at->year == $Selectedyear &&
                       $order->organizationDetails->lead_source == $Selectedcategory;
            }
        });

        if($Selectedcategory == 1){
            $categoryName = 'Email Campaign';
        } else if ($Selectedcategory == 2) {
            $categoryName = 'Store Walk in';
        } else if ($Selectedcategory == 3) {
            $categoryName = 'Online Enquiries';
        } else if ($Selectedcategory == 6) {
            $categoryName = 'Referral';
        } else {
            $categoryName = 'Other';
        }
    // dd($viewOrders);
        return view('pages.reports.sales_lead.view_orders', ['viewOrders'=>$viewOrders, 'Selectedyear'=>$Selectedyear, 'Selectedcategory'=>$categoryName ]);
    }

    public function csvReport($selectedYear, $selectedCategory)
    {
        return (new ReportSalesLeadExport($selectedYear, $selectedCategory))->download('Report_' . $selectedCategory . '_' . $selectedYear . '.xlsx');
    }

    public function csvReportIndex($selectedYear, $selectedCategory, $selectedMonth)
    {
        return (new ReportSalesLeadMonthExport($selectedYear, $selectedCategory, $selectedMonth))->download('Report_' . $selectedCategory . '_' . $selectedYear. '_' . $selectedMonth . '.xlsx');
    }


    public function userGroupFactories(){
        $user = Auth::user();
        $factoryIds = [];
        if($user->hasRole([1, 2, 3, 4, 10])){
            $oderSearch = 'all';
        } else {
            $oderSearch = 'factory';
            foreach($user->roles as $userRole){
                if($userRole->id == 5){     // PBS Factory
                    $factoryIds[] = 2;  // PBS
                }
                if($userRole->id == 6){     // WDC Factory
                    $factoryIds[] = 1;  // WDC
                }
                if($userRole->id == 7){     // BII Factory
                    $factoryIds[] = 3;  // BII
                }
                if($userRole->id == 8){     // UET Factory
                    $factoryIds[] = 7;  // UET
                }
                if($userRole->id == 11){     // ZYS Factory
                    $factoryIds[] = 10;  // ZYS
                }
                if($userRole->id == 12){     // Test Factory
                    $factoryIds[] = 16;  // Test
                }
            }
        }

        $this->oderSearch = $oderSearch;
        $this->factoryIds = $factoryIds;

        return $this;
    }

    public function AR_Reports(){
        $users = User::where('active', 1)->where('role_id', 'like', '%"3"%')->get();
        $sports = Sport::where('active', 1)->get();
        $products = Product::where('active', 1)->get();
        $lead_sources = LeadSource::where('active', 1)->get();
        $organization_countries = Organization::where('active',1)->pluck('shipping_country')->toArray();

        $uppercase_countries = array_map(function($country) {return strtoupper(trim($country));}, $organization_countries);

        $unique_uppercase_countries = array_unique($uppercase_countries);

        $organization_countries = $unique_uppercase_countries;

        return view('pages.reports.account_receivable_report.index', ['users' => $users, 'sports' => $sports, 'products'=>$products, 'lead_sources'=>$lead_sources, 'organization_countries'=>$organization_countries]);
    }

    public function get_ar_report_data(Request $request){

        $orders = Order::where('active', 1)->where('organization_id', '!=', 1377)->with('organizationDetails', 'userDetails', 'orderItems');
        $orders->where(function ($query) {
            $query->where('order_no', 'NOT LIKE', 'TSR%')
                ->orWhere(function ($subQuery) {
                    $subQuery->where('order_no', 'LIKE', 'TSR%')
                             ->where('collect_payment_via_ec', 1);
                });
        });
        $orders->whereNotIn('order_status_id', [7, 1]);

        $all_orders = $orders->get();

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
            $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

            $orders = $orders->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate]);

        }

        if (!empty($request->user_filter) && $request->user_filter != 'all') {
            $orders = $orders->where('user_id', $request->user_filter);
        }
        if (!empty($request->order_processing_rep) && $request->order_processing_rep != 'all') {
            $orders = $orders->where('order_procesing_user_id', $request->order_processing_rep);
        }

        if (!empty($request->sport_filter) && $request->sport_filter != 'all') {
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('sport', $request->sport_filter);
            });
        }

        if (isset($request->team_type_filter) && $request->team_type_filter === '0') {
            $orders = $orders->whereHas('organizationDetails', function ($query) {
                $query->where('internal_team', 0);
            });
        }

        if (!empty($request->lead_source_filter) && $request->lead_source_filter != 'all') {
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('lead_source', $request->lead_source_filter);
            });
        }

        if (!empty($request->location_filter) && $request->location_filter != 'all') {
            $locationFilter = strtoupper(trim($request->location_filter));
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($locationFilter) {
                $query->whereRaw("UPPER(TRIM(shipping_country)) = ?", [$locationFilter]);
            });
        }
        if (!empty($request->product_filter) && $request->product_filter != 'all') {
            $productFilter = $request->product_filter;

            $orders = $orders->whereHas('orderItems', function ($query) use ($productFilter) {
                $query->where('active', 1)
                      ->whereNull('deleted_at')
                      ->where('product_id', $productFilter);
            });
        }


        $orders = $orders->get();
        // Filter orders and add balance to be paid
        $filteredOrders = $orders->map(function($order) {
            $cardPayment = PaymentLog::where('order_id', $order->id)->sum('amount');
            $checkPayment = CheckPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
            $otherPayment = OtherPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
            $paypalPayement = PaypalPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
            $venmoPayment = VenmoPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');

            $payment = 0;
            if($cardPayment > 0 && $paypalPayement > 0){
                $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

            } else if ($cardPayment > 0 && $paypalPayement == 0) {
                $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

            } else if ($cardPayment == 0 && $paypalPayement > 0) {
                $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

            } else {
                $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
            }

            $processingFee = 0;
            $orderTotal = $order->order_total;
            $balnceToBePaid = $orderTotal;
            $totalPayment = $payment;

            if ($payment == 0) {
                $paymentStatus = 0; // Pending

            } else if ($payment < round($order->order_total, 2) && $payment > 0) {
                $paymentStatus = 1; // Partial
                $balnceToBePaid = $order->order_total - $payment;
                $processingFee = round(($cardPayment + $venmoPayment)*3/103 , 2);

            } else {
                $paymentStatus = 2; // Paid
                if($totalPayment > 0 && $totalPayment > $orderTotal){
                    $balnceToBePaid = 0;
                    $processingFee = round(($cardPayment + $venmoPayment)*3/103 , 2);

                }
            }
            if($orderTotal == 0){
                $balnceToBePaid = 0;
                $paymentStatus = 2;
            }
            $orderTotal = $orderTotal + $processingFee;
            $order->order_total = $orderTotal ;
            $order->balance_to_be_paid = $balnceToBePaid ;
            $order->Received_totalPayment = $totalPayment;
            $order->payment_status = $paymentStatus;
            // Return the modified order object
            return $order;
        });

        // Filter the orders to only keep those with Pending or Partial payments
        $filteredOrders = $filteredOrders->filter(function($order) {
            return $order->payment_status === 0 || $order->payment_status === 1;
        });

        $filteredOrders = $filteredOrders->filter(function($order) {
            return round($order->balance_to_be_paid, 2) > 0;
        });

        $orders = $filteredOrders;

        if (!empty($request->sale_type_filter) && $request->sale_type_filter != 'all') {

            if ($request->sale_type_filter == 1) {
                $filteredOrders = $orders->filter(function ($order) use ($all_orders) {
                    $matchingOrders = $all_orders->filter(function ($otherOrder) use ($order) {
                        return $otherOrder->organization_id == $order->organization_id &&
                               $otherOrder->created_at < $order->created_at;
                    });

                    return $matchingOrders->count() > 1;
                });

                $orders = $filteredOrders->values();
            }
            if ($request->sale_type_filter == 0) {
                $filteredOrders = $orders->filter(function ($order) use ($all_orders) {
                    $matchingOrders = $all_orders->filter(function ($otherOrder) use ($order) {
                        return $otherOrder->organization_id == $order->organization_id &&
                               $otherOrder->created_at < $order->created_at;
                    });

                    return $matchingOrders->isEmpty() || ($matchingOrders->count() == 1 && $order->created_at->diffInMonths($matchingOrders->first()->created_at) < 6);
                });

                $orders = $filteredOrders->values();
            }
        }

        $total_sale = $orders->sum('balance_to_be_paid');
        $number_of_sale = $orders->count();

        return response()->json(['orders'=>$orders, 'total_sale'=>$total_sale, 'number_of_sale'=>$number_of_sale]);
    }

    public function cu_sales_summary(){
        $users = User::where('active', 1)->where('role_id', 'like', '%"3"%')->get();
        $sports = Sport::where('active', 1)->get();
        $products = Product::where('active', 1)->get();
        $lead_sources = LeadSource::where('active', 1)->get();
        $organization_countries = Organization::where('active',1)->pluck('shipping_country')->toArray();

        $uppercase_countries = array_map(function($country) {return strtoupper(trim($country));}, $organization_countries);

        $unique_uppercase_countries = array_unique($uppercase_countries);

        $organization_countries = $unique_uppercase_countries;

        return view('pages.reports.customer_sales_summary.index', ['users' => $users, 'sports' => $sports, 'products'=>$products, 'lead_sources'=>$lead_sources, 'organization_countries'=>$organization_countries]);
    }

    public function get_cu_sales_summary_data(Request $request){
        $filterColumn = $request->filtercolumn;
        $internal_team_status = filter_var($request->Internal_team_status, FILTER_VALIDATE_BOOLEAN);
        $orders = Order::whereNotNull($filterColumn)->where('active', 1)
                        ->where('organization_id', '!=', 1377)
                        ->when(!$internal_team_status, function ($query) {
                            $query->whereDoesntHave('organizationDetails', function ($q) {
                                $q->where('internal_team', 1);
                            });
                        })
                        ->with('organizationDetails', 'userDetails', 'orderItems');
        $orders->whereDoesntHave('orderItems', function ($query) {
                    $query->where('has_remake_item', 1);
                });
        $orders->whereNotIn('order_status_id', [7, 1]);




        $all_orders = $orders->get();

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
            $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

            $orders = $orders->whereRaw("STR_TO_DATE($filterColumn, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate]);

        }



        $orders = $orders->get();
        // Filter orders and add balance to be paid
        $filteredOrders = $orders->map(function($order) {
            $cardPayment = PaymentLog::where('order_id', $order->id)->sum('amount');
            $checkPayment = CheckPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
            $otherPayment = OtherPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
            $paypalPayement = PaypalPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');
            $venmoPayment = VenmoPayment::where('order_id', $order->id)->where('is_approved' , 1)->sum('amount');

            $payment = 0;
            if($cardPayment > 0 && $paypalPayement > 0){
                $payment = round(((($cardPayment + $paypalPayement) * 100)/103),2) + $checkPayment + $venmoPayment + $otherPayment;

            } else if ($cardPayment > 0 && $paypalPayement == 0) {
                $payment = round(($cardPayment * 100)/103,2) + $checkPayment + $venmoPayment + $otherPayment;

            } else if ($cardPayment == 0 && $paypalPayement > 0) {
                $payment = $checkPayment + round((($paypalPayement * 100)/103),2) + $venmoPayment + $otherPayment;

            } else {
                $payment = round(($cardPayment + $checkPayment + $paypalPayement + $venmoPayment + $otherPayment),2);
            }

            $processingFee = 0;
            $orderTotal = $order->order_total;
            $balnceToBePaid = $orderTotal;
            $totalPayment = $payment;

            if( strpos($order->order_no, 'TSR') === 0){
                $totalPayment = $orderTotal;
                $paymentStatus = 2; // Paid
                $balnceToBePaid = 0;
            }else {

                if ($payment == 0) {
                    $paymentStatus = 0; // Pending

                } else if ($payment < round($order->order_total, 2) && $payment > 0) {
                    $paymentStatus = 1; // Partial
                    $balnceToBePaid = $order->order_total - $payment;
                    $processingFee = round(($cardPayment + $venmoPayment)*3/103 , 2);

                } else {
                    $paymentStatus = 2; // Paid
                    if($totalPayment > 0 && $totalPayment > $orderTotal){
                        $balnceToBePaid = 0;
                        $processingFee = round(($cardPayment + $venmoPayment)*3/103 , 2);

                    }
                }
            }
            $orderTotal = $orderTotal + $processingFee;
            $order->order_total = $orderTotal ;
            $order->balance_to_be_paid = $balnceToBePaid ;
            $order->Received_totalPayment = $totalPayment;
            $order->payment_status = $paymentStatus;
            // $order->order_procesing_user = $order->userDetails->name;
            // Return the modified order object
            return $order;
        });

        // Filter the orders to only keep those with Pending or Partial payments
        // $filteredOrders = $filteredOrders->filter(function($order) {
        //     return $order->payment_status === 0 || $order->payment_status === 1;
        // });

        // $orders = $filteredOrders;



        $total_sale = $orders->sum('balance_to_be_paid');
        $number_of_sale = $orders->count();

        $groupedOrders = $orders->groupBy('organization_id');
// dd($groupedOrders);
        // New array to hold the summarized data
        $summaryData = [];

        foreach ($groupedOrders as $orgId => $ordersGroup) {
            // dd($ordersGroup);
            $organization = $ordersGroup->first()->organizationDetails;
            $orgName = $organization->organization_name; // Assuming the organization name is `orgname`
            $orgId = $organization->id; // Assuming the organization name is `orgname`
            $salesLead = $organization->userDetails->name; // Assuming sales lead is stored in `lead_source`
            $totalItemQty = $ordersGroup->sum(function($order) {
                return count($order->orderItems);
            });

            $numberOfOrders = $ordersGroup->count();

            $totalamount = $ordersGroup->sum('order_total');

            $totalPaid = $ordersGroup->sum('Received_totalPayment');

            $balanceToBePaid = $totalamount - $totalPaid;
            // $balanceToBePaid = $ordersGroup->sum('balance_to_be_paid');

            // Add this organization's data to the summary array
            $summaryData[] = [
                'orgname' => $orgName,
                'orgid' => $orgId,
                'sales_lead' => $salesLead,
                'total_item_qty' => $totalItemQty,
                'number_of_orders' => $numberOfOrders,
                'totalamount' => $totalamount,
                'total_paid' => $totalPaid,
                'balance' => $balanceToBePaid,
            ];
        }
        // dd($summaryData);
        $sortedSummaryData = collect($summaryData)->sortByDesc('totalamount')->values()->toArray();
        return response()->json(['orders'=>$sortedSummaryData, 'total_sale'=>$total_sale, 'number_of_sale'=>$number_of_sale]);
    }


    public function canceled_order_report(){
        $users = User::where('active', 1)->where('role_id', 'like', '%"3"%')->get();
        $sports = Sport::where('active', 1)->get();
        $products = Product::where('active', 1)->get();
        $lead_sources = LeadSource::where('active', 1)->get();
        $organization_countries = Organization::where('active',1)->pluck('shipping_country')->toArray();

        $uppercase_countries = array_map(function($country) {return strtoupper(trim($country));}, $organization_countries);

        $unique_uppercase_countries = array_unique($uppercase_countries);

        $organization_countries = $unique_uppercase_countries;

        return view('pages.reports.canceled_order_report.index', ['users' => $users, 'sports' => $sports, 'products'=>$products, 'lead_sources'=>$lead_sources, 'organization_countries'=>$organization_countries]);
    }

    public function get_canceled_order_report_data(Request $request){
        $internal_team_status = filter_var($request->Internal_team_status, FILTER_VALIDATE_BOOLEAN);
        $orders = Order::where('active', 1)
                        ->where('organization_id', '!=', 1377)
                        ->when(!$internal_team_status, function ($query) {
                            $query->whereDoesntHave('organizationDetails', function ($q) {
                                $q->where('internal_team', 1);
                            });
                        })
                        ->with('organizationDetails', 'userDetails', 'orderItems');
        $orders->where('order_no', 'not like', 'TSR%');
        $orders->where('order_status_id', 7);

        if (!empty($request->start_date) && !empty($request->end_date)) {
            $startDate = \DateTime::createFromFormat('m/d/Y', $request->start_date)->format('Y-m-d');
            $endDate = \DateTime::createFromFormat('m/d/Y', $request->end_date)->format('Y-m-d');

            // $orders = $orders->whereRaw("STR_TO_DATE(created_at, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate]);
            $orders = $orders->whereBetween('created_at', [$startDate . ' 00:00:00', $endDate . ' 23:59:59']);

        }

        if (!empty($request->user_filter) && $request->user_filter != 'all') {
            $orders = $orders->where('user_id', $request->user_filter);
        }
        if (!empty($request->order_processing_rep) && $request->order_processing_rep != 'all') {
            $orders = $orders->where('order_procesing_user_id', $request->order_processing_rep);
        }

        if (!empty($request->sport_filter) && $request->sport_filter != 'all') {
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('sport', $request->sport_filter);
            });
        }

        if (!empty($request->lead_source_filter) && $request->lead_source_filter != 'all') {
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($request) {
                $query->where('lead_source', $request->lead_source_filter);
            });
        }

        if (!empty($request->location_filter) && $request->location_filter != 'all') {
            $locationFilter = strtoupper(trim($request->location_filter));
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($locationFilter) {
                $query->whereRaw("UPPER(TRIM(shipping_country)) = ?", [$locationFilter]);
            });
        }
        if (!empty($request->product_filter) && $request->product_filter != 'all') {
            $productFilter = $request->product_filter;

            $orders = $orders->whereHas('orderItems', function ($query) use ($productFilter) {
                $query->where('active', 1)
                      ->whereNull('deleted_at')
                      ->where('product_id', $productFilter);
            });
        }


        $orders = $orders->orderBy('id', 'desc')->get();
        // Filter orders and add balance to be paid

        $orders = $orders->sortByDesc('id');

        // Filter the orders to only keep those with Pending or Partial payments

        $total_sale = $orders->sum('balance_to_be_paid');
        $number_of_sale = $orders->count();

        return response()->json(['orders'=>$orders, 'total_sale'=>$total_sale, 'number_of_sale'=>$number_of_sale]);
    }

    public function save_ar_report_data(Request $request){
        dd($request);
        return response()->json(['success'=>true,'message' => 'Report saved successfully']);
    }

    public function save_summary_report_data(Request $request){

        $report = new SavedReport();

        // Assign data from the request to the model
        $report->type = 1;
        $report->name = $request['report_name'];
        $report->start_date = $request['start_date'];
        $report->end_date = $request['end_date'];
        $report->rep_id = $request['user_filter'];
        $report->processing_rep_id = $request['order_processing_rep'];
        $report->sport = $request['sport_filter'];
        $report->lead_type_id = $request['lead_source_filter'];
        $report->sale_type = $request['sale_type_filter'];
        $report->location = $request['location_filter'];
        $report->product_id = $request['product_filter'];

        $report->order_type = implode(',', $request->input('order_types', []));

        // Save the report to the database
        $report->save();
        return response()->json(['success'=>true,'message' => 'Report saved successfully']);
    }

    public function compared_Reports(){
        $users = User::where('active', 1)->where('role_id', 'like', '%"3"%')->get();
        $SavedReports = SavedReport::where('active', 1)->where('type', 1)->get();
        $products = Product::where('active', 1)->get();
        $lead_sources = LeadSource::where('active', 1)->get();
        $organization_countries = Organization::where('active',1)->pluck('shipping_country')->toArray();

        $uppercase_countries = array_map(function($country) {return strtoupper(trim($country));}, $organization_countries);

        $unique_uppercase_countries = array_unique($uppercase_countries);

        $organization_countries = $unique_uppercase_countries;

        return view('pages.reports.compared_Report.index', ['users' => $users, 'SavedReports' => $SavedReports, 'products'=>$products, 'lead_sources'=>$lead_sources, 'organization_countries'=>$organization_countries]);
    }
    private function cal_summary_report($report_filter){
        $filters = SavedReport::where('id', $report_filter)->first();

        $order_types = explode(',', $filters->order_type);
        $start_date =$filters->start_date ;
        $end_date =$filters->end_date ;
        $user_filter =$filters->rep_id ;
        $order_processing_rep =$filters->processing_rep_id ;
        $sport_filter =$filters->sport ;
        $lead_source_filter =$filters->lead_type_id ;
        $location_filter =$filters->location ;
        $product_filter =$filters->product_id ;
        $sale_type_filter =$filters->sale_type ;

        $orders = Order::whereNotNull('production_date')->where('active', 1)->where('organization_id', '!=', 1377)->with('organizationDetails', 'userDetails', 'orderItems');

        $all_orders = $orders->get();

        $total_sale_of_all_orders = $all_orders->sum('order_total');
        $number_of_sale_of_all_orders  = $all_orders->count();

        // Now apply 'order_types' filter on the collection after fetching the orders

        if (!empty($order_types) && !in_array('all', $order_types)) {
            $orders = $orders->where(function ($q) use ($order_types) {
                foreach ($order_types as $type) {
                    if ($type === 'Bulk') {
                        $q->orWhere(function ($sub) {
                            $sub->where('order_no', 'not like', 'TSR%')
                                ->where('plorder', 0)
                                ->whereHas('organizationDetails', function ($org) {
                                    $org->where('internal_team', 0);
                                });
                        });
                    }

                    if ($type === 'TSR') {
                        $q->orWhere(function ($sub) {
                            $sub->where('order_no', 'like', 'TSR%')
                                ->whereHas('organizationDetails', function ($org) {
                                    $org->where('internal_team', 0);
                                });
                        });
                    }

                    if ($type === 'Wl') {
                        $q->orWhere(function ($sub) {
                            $sub->where('plorder', 1)
                                ->whereHas('organizationDetails', function ($org) {
                                    $org->where('internal_team', 0);
                                });
                        });
                    }

                    if ($type === 'ITO') {
                        $q->orWhereHas('organizationDetails', function ($org) {
                            $org->where('internal_team', 1);
                        });
                    }
                }
            });
        }

        if (!empty($start_date) && !empty($end_date)) {
            $startDate = \DateTime::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
            $endDate = \DateTime::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');

            $orders = $orders->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?", [$startDate, $endDate]);

        }
        if (!empty($user_filter) && $user_filter != 0) {
            $orders = $orders->where('user_id', $user_filter);
        }
        if (!empty($order_processing_rep) && $order_processing_rep != 0) {
            $orders = $orders->where('order_procesing_user_id', $order_processing_rep);
        }

        if (!empty($sport_filter) && $sport_filter != 'all') {
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($sport_filter) {
                $query->where('sport',$sport_filter);
            });
        }

        if (!empty($lead_source_filter) && $lead_source_filter != 0) {
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($lead_source_filter) {
                $query->where('lead_source', $lead_source_filter);
            });
        }

        if (!empty($location_filter) && $location_filter != 'all') {
            $locationFilter = strtoupper(trim($location_filter));
            $orders = $orders->whereHas('organizationDetails', function ($query) use ($locationFilter) {
                $query->whereRaw("UPPER(TRIM(shipping_country)) = ?", [$locationFilter]);
            });
        }
        if (!empty($product_filter) && $product_filter != 0) {
            $productFilter = $product_filter;

            $orders = $orders->whereHas('orderItems', function ($query) use ($productFilter) {
                $query->where('active', 1)
                      ->whereNull('deleted_at')
                      ->where('product_id', $productFilter);
            });
        }


        $orders = $orders->get();



        if (!empty($sale_type_filter) && $sale_type_filter != 'all') {

            if ($sale_type_filter == 1) {
                $filteredOrders = $orders->filter(function ($order) use ($all_orders) {
                    $matchingOrders = $all_orders->filter(function ($otherOrder) use ($order) {
                        return $otherOrder->organization_id == $order->organization_id &&
                               $otherOrder->created_at < $order->created_at;
                    });

                    return $matchingOrders->count() > 1;
                });

                $orders = $filteredOrders->values();
            }
            if ($sale_type_filter == 0) {
                $filteredOrders = $orders->filter(function ($order) use ($all_orders) {
                    $matchingOrders = $all_orders->filter(function ($otherOrder) use ($order) {
                        return $otherOrder->organization_id == $order->organization_id &&
                               $otherOrder->created_at < $order->created_at;
                    });

                    return $matchingOrders->isEmpty() || ($matchingOrders->count() == 1 && $order->created_at->diffInMonths($matchingOrders->first()->created_at) < 6);
                });

                $orders = $filteredOrders->values();
            }
        }
        // Group orders by production month
        $orders_by_month = $orders->groupBy(function ($order) {
            return \Carbon\Carbon::parse($order->production_date)->format('Y-m'); // Group by Year-Month
        });

        // Initialize an array for all 12 months
        $order_count_by_month = array_fill(0, 12, 0); // [Jan, Feb, ..., Dec]
        $order_sale_by_month = array_fill(0, 12, 0); // [Jan, Feb, ..., Dec]

        foreach ($orders_by_month as $month => $orders_group) {
            $month_number = (int) \Carbon\Carbon::parse($month)->format('n'); // Get month number (1 for Jan, 12 for Dec)
            $order_count_by_month[$month_number - 1] = $orders_group->count(); // Subtract 1 to align with array index
            $order_sale_by_month[$month_number - 1] = $orders_group->sum('order_total'); // Subtract 1 to align with array index
        }

        $total_sale = $orders->sum('order_total');
        $number_of_sale = $orders->count();

        return ['report_name'=>$filters->name,'orders'=>$orders, 'total_sale'=>$total_sale, 'number_of_sale'=>$number_of_sale,'order_count_by_month' => $order_count_by_month, 'order_sale_by_month'=>$order_sale_by_month, 'total_sale_of_all_orders'=>$total_sale_of_all_orders, 'number_of_sale_of_all_orders'=>$number_of_sale_of_all_orders  ];
    }
    public function generateReportText($firstFilter, $secondFilter)
    {
        // Extracting data from first filter (assuming $firstFilter is an array)
        $firstReportName = $firstFilter['report_name'] ?? 'First Report';
        $firstNumberOfSales = $firstFilter['number_of_sale'] ?? 'N/A';
        $firstTotalSale = $firstFilter['total_sale'] ?? 0;
        $firstOrderCountByMonth = isset($firstFilter['order_count_by_month']) ? implode(', ', $firstFilter['order_count_by_month']) : 'N/A';
        $firstOrderSaleByMonth = isset($firstFilter['order_sale_by_month']) ? implode(', ', array_map(function($sale) {
            return number_format($sale, 2); // Format sale amount to 2 decimal places
        }, $firstFilter['order_sale_by_month'])) : 'N/A';

        // Extracting data from second filter (assuming $secondFilter is an array)
        $secondReportName = $secondFilter['report_name'] ?? 'Second Report';
        $secondNumberOfSales = $secondFilter['number_of_sale'] ?? 'N/A';
        $secondTotalSale = $secondFilter['total_sale'] ?? 0;
        $secondOrderCountByMonth = isset($secondFilter['order_count_by_month']) ? implode(', ', $secondFilter['order_count_by_month']) : 'N/A';
        $secondOrderSaleByMonth = isset($secondFilter['order_sale_by_month']) ? implode(', ', array_map(function($sale) {
            return number_format($sale, 2); // Format sale amount to 2 decimal places
        }, $secondFilter['order_sale_by_month'])) : 'N/A';

        // Generating report text with HTML formatting
        $reportText = "<h3>Detailed Report Summary</h3>";

        // First report details with descriptions
        $reportText .= "<h4>$firstReportName</h4>";
        $reportText .= "<ul>";
        $reportText .= "<li><strong>Number of Sales:</strong> This report includes a total of $firstNumberOfSales sales, representing all orders processed within the specified period.</li>";
        $reportText .= "<li><strong>Total Sales Value:</strong> The total revenue generated from these sales is $" . number_format($firstTotalSale, 2) . ", giving a clear indication of the overall sales performance.</li>";
        $reportText .= "<li><strong>Orders Count by Month:</strong> The monthly breakdown of the number of orders processed is as follows: [$firstOrderCountByMonth]. This gives insight into sales trends and seasonality over the year.</li>";
        $reportText .= "<li><strong>Sales Value by Month:</strong> The corresponding sales revenue for each month is: [$firstOrderSaleByMonth], showing how sales value fluctuated across different periods.</li>";
        $reportText .= "</ul>";

        // Second report details with descriptions
        $reportText .= "<h4>$secondReportName</h4>";
        $reportText .= "<ul>";
        $reportText .= "<li><strong>Number of Sales:</strong> In this report, there were $secondNumberOfSales sales made, providing another view of the performance for the selected period.</li>";
        $reportText .= "<li><strong>Total Sales Value:</strong> The total revenue from these sales was $" . number_format($secondTotalSale, 2) . ", helping to compare and evaluate against the first report.</li>";
        $reportText .= "<li><strong>Orders Count by Month:</strong> The number of orders per month is displayed here: [$secondOrderCountByMonth], giving an idea of how orders were distributed throughout the year.</li>";
        $reportText .= "<li><strong>Sales Value by Month:</strong> The revenue generated each month is as follows: [$secondOrderSaleByMonth]. This allows for a direct comparison of monthly sales performance between the two reports.</li>";
        $reportText .= "</ul>";

        return $reportText;
    }

    private function sales_rep_performance($repId1, $repId2, $second_filter_orders, $first_filter_orders)
    {
        // Combine the two orders collections
        $orders = collect($first_filter_orders)->merge($second_filter_orders);

        // Initialize an empty results array
        $results = [];

        // Check if either repId is 0 (indicating all reps)
        if ($repId1 == 0 || $repId2 == 0) {
            // Group the orders by 'user_id' and calculate the number of sales, total sales amount, and get the user name for each user
            $results = $orders->groupBy('user_id')->map(function ($userOrders) {
                $firstOrder = $userOrders->first(); // Get the first order to extract user details
                return [
                    'user_id' => $firstOrder->user_id,  // Get 'user_id' from the first order in the group
                    'user_name' => $firstOrder->userDetails->name,  // Assuming userDetails relationship contains the user's name
                    'number_of_sales' => $userOrders->count(),   // Count the number of orders
                    'total_sales_amount' => $userOrders->sum('order_total'),  // Sum the 'order_total' for the user
                ];
            })->values();  // Use values() to reset array keys
        } else {
            // Get orders for the specific sales reps (user_id = repId1 or repId2)
            $filteredOrders = $orders->whereIn('user_id', [$repId1, $repId2]);

            // Group by 'user_id' and calculate the number of sales and total sales amount for each rep
            $results = $filteredOrders->groupBy('user_id')->map(function ($userOrders) {
                $firstOrder = $userOrders->first(); // Get the first order to extract user details
                return [
                    'user_id' => $firstOrder->user_id,  // Get 'user_id' from the first order in the group
                    'user_name' => $firstOrder->userDetails->name,  // Assuming userDetails relationship contains the user's name
                    'number_of_sales' => $userOrders->count(),   // Count the number of orders
                    'total_sales_amount' => $userOrders->sum('order_total'),  // Sum the 'order_total' for the user
                ];
            })->values();
        }

        return $results;
    }


    private function compare_sales_performance($reportOne, $reportTwo, $reportOneName, $reportTwoName)
    {
        // Initialize variables for storing the performance comparison
        $salesComparison = [
            'report_one' => [],
            'report_two' => [],
            'conclusion' => ''
        ];

        // Function to find the top sales rep in a report
        $findTopRep = function($report) {
            $topRep = null;
            $highestSales = 0;

            foreach ($report as $rep) {
                if ($rep['total_sales_amount'] > $highestSales) {
                    $highestSales = $rep['total_sales_amount'];
                    $topRep = $rep;
                }
            }

            return $topRep;
        };

        // Assign sales data for all reps in report one
        foreach ($reportOne as $rep) {
            $salesComparison['report_one'][$rep['user_id']] = [
                'name' => $rep['user_name'],
                'total_sales' => $rep['total_sales_amount']
            ];
        }

        // Assign sales data for all reps in report two
        foreach ($reportTwo as $rep) {
            $salesComparison['report_two'][$rep['user_id']] = [
                'name' => $rep['user_name'],
                'total_sales' => $rep['total_sales_amount']
            ];
        }

        // Initialize HTML for the conclusion
        $conclusionHtml = '<div style="font-family: Arial, sans-serif; font-size: 16px; color: #333;">';
        $conclusionHtml .= '<h2><u>Sales Performance Comparison</u></h2>';

        // Find top sales reps for both reports
        $topRepOne = $findTopRep($reportOne);
        $topRepTwo = $findTopRep($reportTwo);

        // Conclusion about top sales reps
        if ($topRepOne) {
            $conclusionHtml .= "<div style='margin-bottom: 10px;'><span style='font-weight: bold;'>{$topRepOne['user_name']}</span> made the most sales in <span style='color: #007bff;'>$reportOneName</span> with <span style='font-weight: bold;'>$" . number_format($topRepOne['total_sales_amount'], 2) . "</span>.</div>";
        }

        if ($topRepTwo) {
            $conclusionHtml .= "<div style='margin-bottom: 10px;'>In <span style='color: #28a745;'>$reportTwoName</span>, <span style='font-weight: bold;'>{$topRepTwo['user_name']}</span> performed better with a total of <span style='font-weight: bold;'>$" . number_format($topRepTwo['total_sales_amount'], 2) . "</span>.</div>";
        }

        // Compare the sales for reps that appear in both reports
        foreach ($salesComparison['report_one'] as $userId => $repOne) {
            if (isset($salesComparison['report_two'][$userId])) {
                $repTwo = $salesComparison['report_two'][$userId];

                if ($repOne['total_sales'] > $repTwo['total_sales']) {
                    $conclusionHtml .= "<div style='margin-bottom: 10px;'><span style='font-weight: bold;'>{$repOne['name']}</span> made more sales in <span style='color: #007bff;'>$reportOneName</span> with <span style='font-weight: bold;'>$" . number_format($repOne['total_sales'], 2) . "</span> compared to <span style='font-weight: bold;'>$" . number_format($repTwo['total_sales'], 2) . "</span> in <span style='color: #28a745;'>$reportTwoName</span>.</div>";
                } elseif ($repOne['total_sales'] < $repTwo['total_sales']) {
                    $conclusionHtml .= "<div style='margin-bottom: 10px;'><span style='font-weight: bold;'>{$repOne['name']}</span> made more sales in <span style='color: #28a745;'>$reportTwoName</span> with <span style='font-weight: bold;'>$" . number_format($repTwo['total_sales'], 2) . "</span> compared to <span style='font-weight: bold;'>$" . number_format($repOne['total_sales'], 2) . "</span> in <span style='color: #007bff;'>$reportOneName</span>.</div>";
                } else {
                    $conclusionHtml .= "<div style='margin-bottom: 10px;'><span style='font-weight: bold;'>{$repOne['name']}</span> had the same sales in both reports, with <span style='font-weight: bold;'>$" . number_format($repOne['total_sales'], 2) . "</span>.</div>";
                }
            }
        }

        // Close the conclusion HTML div
        $conclusionHtml .= '</div>';

        // Add the styled conclusion to the comparison array
        $salesComparison['conclusion'] = $conclusionHtml;

        return $salesComparison;
    }




    public function make_compare_report(Request $request){
        $first_filter = $this->cal_summary_report($request->first_report_filter);
        $second_filter = $this->cal_summary_report($request->second_report_filter);
        $reportText =  $this->generateReportText($first_filter, $second_filter);

        $filters1 = SavedReport::where('id', $request->first_report_filter)->first();
        $filters2 = SavedReport::where('id', $request->second_report_filter)->first();
        $user_filter1 =$filters1->rep_id ;
        $user_filter2 =$filters2->rep_id ;
        // $sales_rep_performance =  $this->sales_rep_performance($user_filter,$first_filter['orders'],NULL);
        $sales_rep_performance =  $this->sales_rep_performance($user_filter1,$user_filter2,$first_filter['orders'],$second_filter['orders']);
        $sales_rep_performance_report_one =  $this->sales_rep_performance($user_filter1,$user_filter2,$first_filter['orders'],NULL);
        $sales_rep_performance_report_two =  $this->sales_rep_performance($user_filter1,$user_filter2,NULL,$second_filter['orders']);


        $salesComparison = $this->compare_sales_performance($sales_rep_performance_report_one, $sales_rep_performance_report_two,$filters1->name,$filters2->name);



        return response()->json(['first_filter'=>$first_filter, 'second_filter'=>$second_filter,'report_title'=>$request->title, 'reportText'=>$reportText, 'sales_rep_performance'=>$sales_rep_performance, 'salesComparison'=>$salesComparison]);
    }

    public function sales_activity_report(Request $request){
        $roleId = Role::where('name', 'Activity Users')->value('id');
        $users = User::select('id', 'name')
            ->where('active', 1)
            ->whereJsonContains('role_id', (string) $roleId)
            ->orderBy('name')
            ->get();
        return view('pages.reports.sales_activity_report.index',['users'=>$users]);
    }
   public function filter_sales_activity(Request $request)
{
    $users = $request->input('users'); // array of user IDs
    $task = $request->input('task');   // 0 = all, 1 = overdue, 2 = pending, 3 = completed
    $activityFilter = $request->input('activity_filter'); // 2 = today, 4 = tomorrow, 5 = this week, 6 = next week, 3 = selected period

    $query = \App\Models\Activity::query();

    // Filter by users
    if (!empty($users)) {
        $query->whereIn('assigned_to', $users);
    }

    // Combine task + activity filter
    $query->where(function($q) use ($task, $activityFilter, $request) {



        // Activity date filter
        if (!empty($activityFilter)) {
            switch ($activityFilter) {
                case 2: // Today
                    $q->whereDate('start_date', today());
                    break;
                case 4: // Tomorrow
                    $q->whereDate('start_date', today()->addDay());
                    break;
                case 5: // This Week
                    $q->whereBetween('start_date', [now()->startOfWeek(), now()->endOfWeek()]);
                    break;
                case 6: // Next Week
                    $q->whereBetween('start_date', [now()->addWeek()->startOfWeek(), now()->addWeek()->endOfWeek()]);
                    break;
                case 3: // Selected Period
                    if ($request->filled('from_date') && $request->filled('to_date')) {
                        $from = \Carbon\Carbon::createFromFormat('m/d/Y', $request->from_date)->startOfDay();
                        $to   = \Carbon\Carbon::createFromFormat('m/d/Y', $request->to_date)->endOfDay();
                        $q->whereBetween('start_date', [$from, $to]);
                    }
                    break;
                default:
                    break;
            }
        }
        // Task filter
        if (!empty($task)) {
            switch ($task) {
                case 1: // Overdue
                    $q->where('is_done', 0)->where('start_date', '<', now());
                    break;
                case 2: // Pending
                    $q->where('is_done', 0)->where('start_date', '>', now());
                    break;
                case 3: // Completed
                    $q->where('is_done', 1);
                    break;
                default: // all, no filter
                    break;
            }
        }

    });

    $activities = $query->with([
        'orderDetails',
        'organizationDetails',
        'contactDetails',
        'assigneeDetails',
        'userDetails'
    ])->get();

    return response()->json(['data' => $activities]);
}
    public function Sales_Tax_Report()
    {

        return view('pages.reports.sales_tax_report.index');

    }

public function OrganizationsWithOrders(Request $request)
{
    $start_date = $request->start_date ?? NULL;
    $end_date = $request->end_date ?? NULL;

    if($start_date && $end_date){
        $start_date = \DateTime::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
        $end_date = \DateTime::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');
    }

    $ordersQuery = Order::query()
            ->where('active', 1)
            ->where('organization_id', '!=', 1377)->where('order_status_id', '!=', 7)->where('order_status_id', '!=', 1)
            ->whereNotNull('production_date')->where('production_date', '!=', '')
            ->with('organizationDetails');

    if ($start_date && $end_date) {
        $ordersQuery->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?", [$start_date, $end_date]);
    }

    $orders = $ordersQuery->get();

    $organizationIds = $orders->pluck('organization_id')->unique();

    $organizationsWithOrders = Organization::with('orders', 'leadSourceDetails', 'userDetails')->whereIn('id', $organizationIds)->where('active', 1)->get();

    return view('pages.reports.organizations_with_orders.index', compact('start_date', 'end_date', 'organizationsWithOrders'));
}

public function OrganizationsWithOrdersExport(Request $request)
{
    $start_date = $request->start_date ?? NULL;
    $end_date = $request->end_date ?? NULL;

    if($start_date && $end_date){
        $start_date = \DateTime::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
        $end_date = \DateTime::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');
    }

    $headers = [
        'Content-Type' => 'text/csv',
        'Content-Disposition' => 'attachment; filename="organizations_with_orders.csv"',
    ];
    $callback = function() use ($start_date, $end_date) {
        $file = fopen('php://output', 'w');
        fputcsv($file, ['ORGANIZATION NAME', 'LEAD SOURCE', 'NUM OF ORDES', 'SALES LEAD', 'TOTAL SALE']);

        $ordersQuery = Order::query()
            ->where('active', 1)
            ->where('organization_id', '!=', 1377)->where('order_status_id', '!=', 7)->where('order_status_id', '!=', 1)
            ->whereNotNull('production_date')->where('production_date', '!=', '')
            ->with('organizationDetails');

        if ($start_date && $end_date) {
            $ordersQuery->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?", [$start_date, $end_date]);
        }

        $orders = $ordersQuery->get();

        $organizationIds = $orders->pluck('organization_id')->unique();

        $organizationsWithOrders = Organization::with('orders', 'leadSourceDetails', 'userDetails')->whereIn('id', $organizationIds)->where('active', 1)->get();

        foreach ($organizationsWithOrders as $organization) {
            $filteredOrders = $orders->where('organization_id', $organization->id)->where('active', 1)->where('organization_id', '!=', 1377)->where('order_status_id', '!=', 7)->where('order_status_id', '!=', 1)->whereNotNull('production_date')->where('production_date', '!=', '');
            fputcsv($file, [
                $organization->organization_name,
                $organization->leadSourceDetails ? $organization->leadSourceDetails->lead_source_name : 'N/A',
                $filteredOrders->count(),
                $organization->userDetails ? $organization->userDetails->name : '-',
                number_format($filteredOrders->sum('order_total'), 2)
            ]);
        }

        fclose($file);
    };
    return response()->stream($callback, 200, $headers);
}

public function OrganizationsWithOrdersExportYearly(Request $request)
{
    $start_date = $request->start_date ?? NULL;
    $end_date = $request->end_date ?? NULL;

    if($start_date && $end_date){
        $start_date = \DateTime::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
        $end_date = \DateTime::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');
    }

    $ordersQuery = Order::query()
            ->where('active', 1)
            ->where('organization_id', '!=', 1377)->where('order_status_id', '!=', 7)->where('order_status_id', '!=', 1)
            ->whereNotNull('production_date')->where('production_date', '!=', '')
            ->with('organizationDetails');

    if ($start_date && $end_date) {
        $ordersQuery->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?", [$start_date, $end_date]);
    }

    $orders = $ordersQuery->get();

    $ordersByYear = $orders->groupBy(function ($order) {
        try {
            return \Carbon\Carbon::createFromFormat('m/d/Y', trim($order->production_date))->format('Y');
        } catch (\Exception $e) {
            return 'Invalid';
        }
    });

    $spreadsheet = new Spreadsheet();
    $sheetIndex = 0;

    foreach ($ordersByYear as $year => $yearOrders) {

        $sheet = $sheetIndex === 0
            ? $spreadsheet->getActiveSheet()
            : $spreadsheet->createSheet();

        $cleanTitle = preg_replace('/[\\\\\\/\\?\\*\\[\\]:]/', '', $year);
        $cleanTitle = substr(trim($cleanTitle), 0, 31);
        if (empty($cleanTitle)) {
            $cleanTitle = 'Sheet_' . $sheetIndex;
        }

        $sheet->setTitle($cleanTitle);

        $sheet->fromArray([
            ['ORGANIZATION NAME', 'LEAD SOURCE', 'NUM OF ORDERS', 'SALES LEAD', 'TOTAL SALE']
        ], null, 'A1');

        $organizationIds = $yearOrders->pluck('organization_id')->unique();

        $organizations = Organization::with(['leadSourceDetails', 'userDetails'])
            ->whereIn('id', $organizationIds)
            ->where('active', 1)
            ->get()
            ->keyBy('id');

        $row = 2;

        $ordersByOrg = $yearOrders->groupBy('organization_id');

        foreach ($ordersByOrg as $orgId => $orgOrders) {

            $organization = $organizations->get($orgId);

            if (!$organization) {
                continue;
            }

            $sheet->fromArray([
                [
                    $organization->organization_name,
                    optional($organization->leadSourceDetails)->lead_source_name ?? 'N/A',
                    $orgOrders->count(),
                    optional($organization->userDetails)->name ?? '-',
                    number_format($orgOrders->sum('order_total'), 2)
                ]
            ], null, 'A' . $row);

            $row++;
        }

        $sheetIndex++;
    }

    $spreadsheet->setActiveSheetIndex(0);

    $fileName = 'organizations_with_orders.xlsx';
    $writer = new Xlsx($spreadsheet);

    return response()->stream(function () use ($writer) {
        $writer->save('php://output');
    }, 200, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
        'Content-Disposition' => "attachment; filename=\"$fileName\"",
    ]);
}
public function order_embellishments_report(Request $request)
{
    $embellishmentTypeIds = [3, 19, 2, 4];

    $orders = Order::with([
            'organizationDetails',
            'userDetails',
            'contactDetails',
            'statusDetails',

            'orderItems' => function ($query) use ($embellishmentTypeIds) {
                $query->whereIn(
                    'embellishment_type_id',
                    $embellishmentTypeIds
                )->with('factoryDetails');
            },
        ])
        ->where('active', 1)
        ->where('order_status_id', 3)
        ->whereHas('orderItems', function ($query) use ($embellishmentTypeIds) {
            $query->whereIn(
                'embellishment_type_id',
                $embellishmentTypeIds
            );
        })
        ->orderBy('orders.id', 'desc')
        ->get();

    return view(
        'pages.reports.order_embellishments_report.index',
        compact('orders')
    );
}
public function org_wise_product_report(Request $request)
{
    $start_date = $request->start_date ?? NULL;
    $end_date = $request->end_date ?? NULL;
    $organizationID = $request->organization_id ?? 'all';

    $start_date_f = null;
    $end_date_f = null;

    if($start_date){
        $start_date_f = Carbon::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
    }
    if($end_date){
        $end_date_f = Carbon::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');
    }

    $ordersQuery = Order::query()
            ->with('orderItems.subProduct')
            ->where('active', 1)
            ->where('organization_id', '!=', 1377)->whereIn('order_status_id', [3,4])
            ->whereNotNull('production_date')->where('production_date', '!=', '');
    if ($organizationID !== 'all') {
        $ordersQuery->where('organization_id', $organizationID);
    }

    if ($start_date && $end_date) {
        $ordersQuery->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?", [$start_date_f, $end_date_f]);
    }elseif($start_date && !$end_date){
        $ordersQuery->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') >= ?", [$start_date_f]);
    }elseif(!$start_date && $end_date){
        $ordersQuery->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') <= ?", [$end_date_f]);
    }

    $orders = $ordersQuery->get();

    $productList= [];

    foreach($orders as $order){
        foreach($order->orderItems as $item){
            if($item->subProduct){
                $productNo = $item->subProduct->sub_product_no ?? 'N/A';
                $productName = $item->subProduct->product_name;
                if(isset($productList[$productNo])){
                    $productList[$productNo]['qty'] += $item->qty;
                    $productList[$productNo]['orders'][] = $order->id;
                }else{
                    $productList[$productNo] = [
                        'product' => $item->subProduct,
                        'qty' => $item->qty,
                        'orders' => [$order->id]
                    ];
                }
            }
        }
    }

    $productList = collect($productList)->sortByDesc('qty')->values()->all();

    $organizations = Organization::where('active', 1)->get();

    return view('pages.reports.org_wise_product_report.index', compact('start_date', 'end_date', 'organizations', 'productList'));
}

public function org_wise_product_report_export(Request $request)
{
    $start_date = $request->start_date ?? NULL;
    $end_date = $request->end_date ?? NULL;
    $organizationID = $request->organization_id ?? 'all';

    $start_date_f = null;
    $end_date_f = null;

    if($start_date && $end_date){
        $start_date_f = \DateTime::createFromFormat('m/d/Y', $start_date)->format('Y-m-d');
        $end_date_f = \DateTime::createFromFormat('m/d/Y', $end_date)->format('Y-m-d');
    }

    $ordersQuery = Order::query()
            ->with('orderItems.subProduct')
            ->where('active', 1)
            ->where('organization_id', '!=', 1377)->whereIn('order_status_id', [3,4])
            ->whereNotNull('production_date')->where('production_date', '!=', '');

    if ($organizationID !== 'all') {
        $ordersQuery->where('organization_id', $organizationID);
    }

    if ($start_date && $end_date) {
        $ordersQuery->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?", [$start_date_f, $end_date_f]);
    }elseif($start_date && !$end_date){
        $ordersQuery->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') >= ?", [$start_date_f]);
    }elseif(!$start_date && $end_date){
        $ordersQuery->whereRaw("STR_TO_DATE(production_date, '%m/%d/%Y') <= ?", [$end_date_f]);
    }

    $orders = $ordersQuery->get();

    $productList= [];

    foreach($orders as $order){
        foreach($order->orderItems as $item){
            if($item->subProduct){
                $productNo = $item->subProduct->sub_product_no ?? 'N/A';
                $productName = $item->subProduct->product_name;
                if(isset($productList[$productNo])){
                    $productList[$productNo]['qty'] += $item->qty;
                    $productList[$productNo]['orders'][] = $order->id;
                }else{
                    $productList[$productNo] = [
                        'product' => $item->subProduct,
                        'qty' => $item->qty,
                        'orders' => [$order->id]
                    ];
                }
            }
        }
    }

    $productList = collect($productList)->sortByDesc('qty')->values()->all();
    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();
    $sheet->fromArray([
        ['Product No', 'Product Name', 'Total Quantity', 'Order IDs']
    ], null, 'A1');
    $row = 2;
    foreach($productList as $productData){
        $sheet->fromArray([
            $productData['product']->sub_product_no ?? 'N/A',
            $productData['product']->product_name,
            $productData['qty'],
            implode(', ', $productData['orders'])
        ], null, 'A' . $row);
        $row++;
    }
    $fileName = 'org_wise_product_report.xlsx';
    $writer = new Xlsx($spreadsheet);
    $writer->save($fileName);

    return response()->download($fileName)->deleteFileAfterSend(true);
}



public function Sales_Tax_Report_getData(Request $request)
{
    // Base query with relationships
    $query = Order::with(['organizationDetails', 'userDetails', 'statusDetails']);

    // DATE FILTER (optional)
    if ($request->start_date && $request->end_date) {
        $start = Carbon::createFromFormat('m/d/Y', $request->start_date)->startOfDay();
        $end   = Carbon::createFromFormat('m/d/Y', $request->end_date)->endOfDay();
        $query->whereRaw(
        "STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?",
        [$start, $end]
    );
    }

    // Filter: order status, active orders, non-null & >0 order_total, organization with sales tax
    $filteredOrders = $query->whereIn('order_status_id', [3, 4, 8])
        ->where('active', 1)
        ->whereNotNull('sub_total')
        ->where('sub_total', '>', 0)
        ->whereNotNull('sales_tax')
        ->where('sales_tax', '>', 0);

    // Check TSR orders exist in store_orders
    $filteredOrders = $filteredOrders->where(function ($q) {
        $q->where('order_no', 'not like', 'TSR%') // normal orders
          ->orWhere(function ($sub) {
              $sub->where('order_no', 'like', 'TSR%')
                  ->whereExists(function ($existQuery) {
                      $existQuery->select(\DB::raw(1))
                          ->from('store_orders')
                          ->whereColumn('store_orders.system_order_no', 'orders.order_no');
                  });
          });
    });

    // Total records (for DataTables)
    $totalRecords = $filteredOrders->count();

    // Calculate total sales tax for all filtered orders
    $totalSalesTax = $filteredOrders
        ->get()
        ->sum(function ($order) {
            $rate = $order->organizationDetails->sales_tax ?? 0;
            $total = $order->sales_tax ?? 0;
            return ($total );
        });

    // Pagination parameters from DataTables
    $start  = $request->input('start', 0);
    $length = $request->input('length', 10);

    // Get paginated orders
    $orders = $filteredOrders
        ->orderBy('created_at', 'desc')
        ->skip($start)
        ->take($length)
        ->get();

    // Map orders for DataTables
    $data = $orders->map(function ($row) {
        $rate  = $row->organizationDetails->sales_tax ?? 0;
        $total = $row->sub_total ?? 0;
        $salesTax = $row->sales_tax;

        return [
            'order_no'           => $row->order_no,
            'organization_name'  => $row->organizationDetails->organization_name ?? '-',
            'state'              => $row->organizationDetails->shipping_state ?? '-',
            'sales_person'       => $row->userDetails->name ?? '-',
            'production_date'    => $row->production_date
                                    ? \Carbon\Carbon::parse($row->production_date)->format('m/d/Y')
                                    : '-',
            'order_status'       => ucfirst($row->statusDetails->status_name ?? '-'),
            'order_total'        => number_format($total, 2),
            'sales_tax_rate'     => $rate,
            'sales_tax'          => number_format($salesTax, 2),
        ];
    });

    // Return JSON for DataTables
    return response()->json([
        'draw'            => intval($request->draw),
        'recordsTotal'    => $totalRecords,
        'recordsFiltered' => $totalRecords,
        'total_sales_tax' => number_format($totalSalesTax, 2),
        'data'            => $data,
    ]);
}

public function weeklyOrderProductionSummary(Request $request)
{
    $start_date = $request->start_date;
    $end_date = $request->end_date;

    if ($start_date && $end_date) {
        $start_date = Carbon::createFromFormat('Y-m-d', $start_date)->startOfDay()->format('Y-m-d');
        $end_date = Carbon::createFromFormat('Y-m-d', $end_date)->endOfDay()->format('Y-m-d');
    }

    $ordersQuery = Order::query()
        ->where('active', 1)
        ->whereNotNull('production_date')
        ->with([
            'organizationDetails',
            'userDetails',
            'orderItems.productDetails'
        ]);

    if ($start_date && $end_date) {
        $ordersQuery->whereRaw(
            "STR_TO_DATE(production_date, '%m/%d/%Y') BETWEEN ? AND ?",
            [$start_date, $end_date]
        );
    }

    $orders = $ordersQuery->get();

    $spreadsheet = new Spreadsheet();
    $sheet = $spreadsheet->getActiveSheet();

    $headers = ['Customer Name', 'Order No', 'Production Date','Line Items'];
    $sheet->fromArray($headers, null, 'A1');

    $sheet->getStyle('A1:D1')->getAlignment()
        ->setVertical(Alignment::VERTICAL_CENTER)
        ->setHorizontal(Alignment::HORIZONTAL_CENTER);

    $rowNum = 2;

    foreach ($orders as $order) {

        $items = $order->orderItems;

        foreach ($items as $index => $item) {

            $sheet->setCellValue('A'.$rowNum, $index == 0 ? ($order->organizationDetails->organization_name ?? '-') : '');
            $sheet->setCellValue('B'.$rowNum, $index == 0 ? $order->order_no : '');
            $sheet->setCellValue(
                'C'.$rowNum,
                $index == 0 ? Carbon::createFromFormat('m/d/Y', $order->production_date)->format('m/d/Y') : ''
            );

            $productName = ($item->productDetails->product_name ?? 'N/A');
            $lineItemText = $productName . ($item->item_description ? ' - '.$item->item_description : '');

            $url = route('orderitem.info', [
                'orderid' => $order->id,
                'orderItemId' => $item->id
            ]);

            $sheet->setCellValue('D'.$rowNum, $lineItemText);
            $sheet->getCell('D'.$rowNum)->getHyperlink()->setUrl($url);

            // ✅ Style like real hyperlink (blue + underline)
            $sheet->getStyle('D'.$rowNum)->getFont()->setUnderline(Font::UNDERLINE_SINGLE)->getColor()->setARGB(Color::COLOR_BLUE);

            $sheet->getStyle('B'.$rowNum)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyle('C'.$rowNum)->getAlignment()
                ->setHorizontal(Alignment::HORIZONTAL_CENTER)
                ->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyle('A'.$rowNum)->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);

            $sheet->getStyle('D'.$rowNum)->getAlignment()
                ->setVertical(Alignment::VERTICAL_CENTER);

            $rowNum++;
        }

        $rowNum++; // empty row after each order
    }

    $writer = new Xlsx($spreadsheet);

    $fileName = 'weekly_production_orders_'.$start_date.'_to_'.$end_date.'.xlsx';

    return response()->streamDownload(function () use ($writer) {
        $writer->save('php://output');
    }, $fileName, [
        'Content-Type' => 'application/vnd.openxmlformats-officedocument.spreadsheetml.sheet',
    ]);
}
}
