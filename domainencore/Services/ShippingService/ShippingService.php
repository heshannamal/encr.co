<?php

namespace domainencore\Services\ShippingService;

use App\Models\Notification;
use App\Models\Order;
use App\Models\ShippingOrderDetails;
use App\Models\User;
use App\Models\OrderItem;
use App\Services\EmailNotificationBuilderService;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use App\Services\NotificationBuilderService;

class ShippingService
{
    protected $notification;
    protected $shippingDetail;
    protected $order;
    protected $user;

    public function __construct()
    {
        $this->notification = new Notification();
        $this->shippingDetail = new ShippingOrderDetails();
        $this->order = new Order();
        $this->user = new User();
    }

    public function get($orderId, $orderItemId, $orderItemDetailId, $sizeId, $hasBlank, $hasBlankName, $seqNumber, $seqName, $searchField)
    {
        $shippingDetailQry = $this->shippingDetail->select($searchField)
                                            ->where('order_id', $orderId)
                                            ->where('order_item_id', $orderItemId)
                                            ->where('order_item_detail_id', $orderItemDetailId)
                                            ->where('size_id', $sizeId)
                                            ->where('seq_number', $seqNumber);
        if($hasBlank == 'yes'){
            $shippingDetailQry->where('has_blank_qty', 'yes');
        } else {
            $shippingDetailQry->where('seq_number', $seqNumber);
        }

        if($hasBlankName == 'yes'){
            $shippingDetailQry->where('has_blank_name', 'yes');
            $shippingDetailQry->where('seq_name', $seqName);
        } else {
            $shippingDetailQry->where('has_blank_name', 'no');
        }

        $shippingField = $shippingDetailQry->first();
        if($shippingField){
            return $shippingField->$searchField;
        }
    }

    public function getBackOrderedShipping($orderId, $orderItemId, $orderItemDetailId, $sizeId, $hasBlank, $seqNumber)
    {
        $shippingDetailQry = $this->shippingDetail->where('order_id', $orderId)
                                            ->where('order_item_id', $orderItemId)
                                            ->where('order_item_detail_id', $orderItemDetailId)
                                            ->where('size_id', $sizeId)
                                            ->where('is_back_ordered', 1);
        if($hasBlank == 'yes'){
            $shippingDetailQry->where('has_blank_qty', 'yes');
        } else {
            $shippingDetailQry->where('seq_number', $seqNumber);
        }
        $shippingDetail = $shippingDetailQry->get();
        return $shippingDetail;
    }

    public function getMainShipQty($orderId, $orderItemId)
    {
        return $this->shippingDetail->where('order_id', $orderId)->where('order_item_id', $orderItemId)->get()->sum('shipped_qty');
    }

    public function getNotifiedBy($orderId, $orderItemId, $orderItemDetailId, $sizeId, $hasBlank, $hasBlankName, $seqNumber, $seqName)
    {
        $shippingDetailQry = $this->shippingDetail->select('notified_by')
                                            ->where('order_id', $orderId)
                                            ->where('order_item_id', $orderItemId)
                                            ->where('order_item_detail_id', $orderItemDetailId)
                                            ->where('size_id', $sizeId)
                                            ->where('seq_number', $seqNumber);
        if($hasBlank == 'yes'){
            $shippingDetailQry->where('has_blank_qty', 'yes');
        } else {
            $shippingDetailQry->where('seq_number', $seqNumber);
        }

        if($hasBlankName == 'yes'){
            $shippingDetailQry->where('has_blank_name', 'yes');
            $shippingDetailQry->where('seq_name', $seqName);
        } else {
            $shippingDetailQry->where('has_blank_name', 'no');
        }

        $shippingField = $shippingDetailQry->first();
        if($shippingField){
            $notifyUser = User::find($shippingField->notified_by);
            if($notifyUser){
                return $notifyUser->name;
            } else {
                return null;
            }
        }
    }

    public function getNotifiedByBackOrdered($shippingItemDetailId)
    {
        $shippingField = $this->shippingDetail::find($shippingItemDetailId);
        if($shippingField){
            $notifyUser = User::find($shippingField->notified_by);
            if($notifyUser){
                return $notifyUser->name;
            } else {
                return null;
            }
        }
    }

    public function store($subItem)
    {
        try{
            if(isset($subItem['shipping_order_detail_id'])){
                $shippingDetailCheck = $this->shippingDetail::find($subItem['shipping_order_detail_id']);
            } else {
                $shippingDetailQry = $this->shippingDetail->where('order_id', $subItem['order_id'])
                                                ->where('order_item_id', $subItem['order_item_id'])
                                                ->where('order_item_detail_id', $subItem['order_item_detail_id'])
                                                ->where('size_id', $subItem['size_id']);
                if($subItem['has_blank_qty'] == 'yes'){
                    $shippingDetailQry->where('has_blank_qty', 'yes');
                } else {
                    $shippingDetailQry->where('seq_number', $subItem['seq_number']);
                }

                if(isset($subItem['has_blank_name']) && $subItem['has_blank_name'] == 'yes'){
                    $shippingDetailQry->where('has_blank_name', 'yes');
                    $shippingDetailQry->where('seq_name', $subItem['seq_name']);
                } else {
                    $shippingDetailQry->where('has_blank_name', 'no');
                }

                $shippingDetailCheck = $shippingDetailQry->first();
            }

            if($shippingDetailCheck){
                $response = 'updated';

                if($subItem['save_type'] == 'notify_save'){
                    $shipIdsArr = json_decode($subItem['selected_shipping_detail_ids']);
                    if (in_array($shippingDetailCheck->id, $shipIdsArr)) {
                        $shippingDetailCheck->update( $this->edit($shippingDetailCheck, $subItem) );
                        $shippingDetailCheck->update(['is_saved' => 1]);

                        if($subItem['back_ordered_qty'] != '' && $subItem['back_ordered_qty'] != null && $subItem['back_ordered_qty'] > 0){
                            $this->createNewRowBackorder($shippingDetailCheck);
                        }
                        $response = 'stored';
                    }
                }
            } else {
                $this->shippingDetail->create($subItem);
                $response = 'stored';
            }
            return $response;
        } catch(\Throwable $th) {
            return $th->getMessage();
        }
    }

    public function createNewRowBackorder($orderShippningItem){
        $newOrderShippningItem = $orderShippningItem->toArray();
        $newOrderShippningItem['id'] = null;
        $newOrderShippningItem['order_qty'] = $orderShippningItem->back_ordered_qty;
        $newOrderShippningItem['shipped_qty'] = null;
        $newOrderShippningItem['back_ordered_qty'] = null;
        $newOrderShippningItem['is_back_ordered'] = 1;
        $newOrderShippningItem['initail_order_qty'] = $orderShippningItem->back_ordered_qty;
        $newOrderShippningItem['est_delivery_date'] = null;
        $newOrderShippningItem['tracking_no'] = null;
        $newOrderShippningItem['tracking_link'] = null;
        $newOrderShippningItem['is_saved'] = 0;
        $this->create($newOrderShippningItem);

        $orderShippningItem->initail_order_qty = $orderShippningItem->order_qty;
        $orderShippningItem->order_qty = $orderShippningItem->shipped_qty;
        $orderShippningItem->back_ordered_qty = null;
        $orderShippningItem->update();
    }

    public function create($newOrderShippningItem){
        $this->shippingDetail->create($newOrderShippningItem);
    }

    protected function edit(ShippingOrderDetails $shippingDetail, $subItem)
    {
        return array_merge($shippingDetail->toArray(), $subItem);
    }

    public function shippingOrderDetailTableStatus($orderId, $orderDetails)
    {
        $countStatus = 'not_have';
        foreach($orderDetails as $orderDetail){
            if(count($orderDetail->orderItems) > 0){
                $countStatus = 'have';
            }
        }
        if($countStatus == 'have'){
            $shippingTblStatus = $this->shippingDetail->where('order_id', $orderId)->get();
            if(count($shippingTblStatus) > 0){
                return 'yes';
            } else {
                return 'no';
            }
        } else {
            return 'yes';
        }

    }

    public function getNotifiedProduct($orderItemArr){
        $mainArr = [];
        $orderItems = $this->shippingDetail->select('est_delivery_date', 'tracking_no', 'tracking_link','CourierService')->whereIn('id', $orderItemArr)->groupBy('est_delivery_date', 'tracking_no', 'tracking_link','CourierService')->get();
        foreach($orderItems as $orderItem){
            if($orderItem->est_delivery_date){
                $orderItem['display_est_delivery_date'] = Carbon::parse($orderItem->est_delivery_date)->format('m/d/Y');
            } else {
                $orderItem['display_est_delivery_date'] = '';
            }
            $orderItemProduct = $this->shippingDetail->select('order_item_id', 'order_item_detail_id', 'size_name', DB::raw('SUM(order_qty) AS order_qty'), DB::raw('SUM(shipped_qty) AS shipped_qty'))
                                                        ->with('orderItems.productDetails', 'orderItemDetailQtys')
                                                        ->where('est_delivery_date', $orderItem->est_delivery_date)
                                                        ->where('tracking_no', $orderItem->tracking_no)
                                                        ->where('tracking_link', $orderItem->tracking_link)
                                                        ->whereIn('id', $orderItemArr)
                                                        ->groupBy('order_item_id', 'order_item_detail_id', 'size_name')
                                                        ->get();
            $orderItem['products'] = $orderItemProduct;
            $mainArr[] = $orderItem;
        }
        return $mainArr;
    }

    public function getShipmentSummery($orderId){
        $mainArr = [];
        $orderItems = $this->shippingDetail->select('est_delivery_date', 'tracking_no', 'tracking_link','customer_received')->where('order_id', $orderId)->groupBy('est_delivery_date', 'tracking_no', 'tracking_link')->get();
        foreach($orderItems as $orderItem){
            if($orderItem->est_delivery_date){
                $orderItem['display_est_delivery_date'] = Carbon::parse($orderItem->est_delivery_date)->format('m/d/Y');
            } else {
                $orderItem['display_est_delivery_date'] = '';
            }
            $orderItemProduct = $this->shippingDetail->select( 'order_item_id', 'order_item_detail_id', 'size_name', DB::raw('SUM(initail_order_qty) AS order_qty'), DB::raw('SUM(shipped_qty) AS shipped_qty') )
                                                        ->with('orderItems.productDetails', 'orderItemDetailQtys')
                                                        ->where('est_delivery_date', $orderItem->est_delivery_date)
                                                        ->where('tracking_no', $orderItem->tracking_no)
                                                        ->where('tracking_link', $orderItem->tracking_link)
                                                        ->where('order_id', $orderId)
                                                        ->whereIn('notify_status', [1, 2])
                                                        ->groupBy('order_item_id', 'order_item_detail_id', 'size_name')
                                                        ->get();
            $orderItem['products'] = $orderItemProduct;

            if(isset($orderItemProduct) && count($orderItemProduct) > 0){
                $mainArr[] = $orderItem;
            }
        }
        return $mainArr;
    }

   public function sendNotificationEmailToSales($orderId, $selectedShipIds, $est_delivery_date)
    {
        if($selectedShipIds){
            $order = $this->order->with(['organizationDetails', 'contactDetails'])->find($orderId);

            $shippingDetailsUrl = url('order_details/edit/' . $orderId . '/shipping');
            $totalOrderQty = OrderItem::where('order_id', $orderId)->where('active', 1)->sum('qty');
            $shippedQty = ShippingOrderDetails::where('order_id', $orderId)->sum('shipped_qty');

            $users = $this->user->whereIn('id', [$order->user_id, $order->order_procesing_user_id])->get();
            $shippingDetailsAll = $this->shippingDetail->with('orderItems.productDetails')->whereIn('id', json_decode($selectedShipIds))->get();
            $shippingDetails = $this->shippingDetail->with('orderItems.productDetails')->whereIn('id', json_decode($selectedShipIds))->get()->pluck('orderItems.productDetails.product_name')->toArray();

            $shippingDetailProducts = array_unique($shippingDetails);

            $itemlist = '';
            $updatedItems = [];
            $shippedThisTime = 0;
            $updatedDeliveryDates = [];

            foreach ($shippingDetailsAll as $shippingDetail) {

                $orderItem = $shippingDetail->orderItems;

                if (
                    $orderItem &&
                    (!empty($shippingDetail->tracking_no) || !empty($shippingDetail->tracking_link))
                ) {
                    $orderItemId = $shippingDetail->order_item_id;
                    $itemDetailId = $shippingDetail->order_item_detail_id;

                    $updatedItems[$orderItemId][$itemDetailId] = [
                        'product_name'  => $orderItem->display_name ?? optional($orderItem->productDetails)->product_name ??  '-',
                        'size_name'     => $shippingDetail->size_name ?? '-',
                        'player_number' => $shippingDetail->player_number ?? '-',
                        'player_name'   => $shippingDetail->player_name ?? '-',
                        'order_qty'     => $shippingDetail->order_qty ?? 0,
                        'tracking_no'   => $shippingDetail->tracking_no ?? '-',
                        'tracking_link' => $shippingDetail->tracking_link ?? '#',
                    ];

                    // Accumulate only from the records actually shown in this email
                    $shippedThisTime += (int) ($shippingDetail->shipped_qty ?? 0);

                    if (!empty($shippingDetail->est_delivery_date)) {
                        $updatedDeliveryDates[] = $shippingDetail->est_delivery_date;
                    }
                }
            }

            foreach($shippingDetailProducts as $shippingDetailProduct){
                $itemlist .= '<li>'.$shippingDetailProduct.'</li>';
            }

            // Use the latest date among the records in THIS email, falling back to the passed-in date if none found
            $latestUpdatedDeliveryDate = !empty($updatedDeliveryDates)
                ? collect($updatedDeliveryDates)->sort()->last()
                : $est_delivery_date;

            if(count($updatedItems) > 0){
                app(EmailNotificationBuilderService::class)->sendEmailFromTemplate('key_email_sales_rep_shipping_details_update', [
                    'orderId' => $orderId,
                    'customer_details' => trim(optional($order->contactDetails)->first_name . ' ' . optional($order->contactDetails)->last_name),
                    'updatedItems' => $updatedItems,
                    'organization_name' => $order->organizationDetails->organization_name ?? '',
                    'shippingDetailsUrl' => $shippingDetailsUrl,
                    'totalOrderQty' => $totalOrderQty,
                    'shippedQty' => $shippedQty,
                    'shippedThisTime' => $shippedThisTime,
                    'estimatedDeliveryDate' => Carbon::parse($latestUpdatedDeliveryDate)->format('m/d/Y'),
                ]);
            }
        }
    }

    public function sendNotificationToSales($orderId, $selectedShipIds)
    {
        if ($selectedShipIds) {
            $order = $this->order->with('organizationDetails')->find($orderId);

            $shippingDetailsUrl   = url('order_details/edit/' . $orderId . '/shipping');
            $totalOrderQty        = OrderItem::where('order_id', $orderId)->where('active', 1)->sum('qty');
            $shippedQty           = ShippingOrderDetails::where('order_id', $orderId)->sum('shipped_qty');
            $estimatedDiliveryDate = $order->est_delivery_date
                ? Carbon::parse($order->est_delivery_date)->format('Y-m-d')
                : '-';

            $shippingDetailsAll = $this->shippingDetail
                ->with('orderItems.productDetails')
                ->whereIn('id', json_decode($selectedShipIds))
                ->get();

            $itemRows = '';
            $rowIndex = 0;

            // Self-contained copy logic, safe to inline in an onclick attribute.
            // Executes even when injected via innerHTML (unlike <script> tags).
            $copyOnClick = "(function(el){"
                . "var v=el.getAttribute('data-tracking');"
                . "if(!v||v==='-')return;"
                . "var done=function(){"
                    . "var o=el.className;"
                    . "el.classList.remove('far','fa-copy');"
                    . "el.classList.add('fas','fa-check');"
                    . "el.style.color='#0d9488';"
                    . "setTimeout(function(){el.className=o;el.style.color='#9ca3af';},1200);"
                . "};"
                . "var legacyCopy=function(){"
                    . "var t=document.createElement('textarea');"
                    . "t.value=v;t.style.position='fixed';t.style.opacity='0';"
                    . "document.body.appendChild(t);t.select();"
                    . "try{document.execCommand('copy');}catch(e){}"
                    . "document.body.removeChild(t);done();"
                . "};"
                . "if(navigator.clipboard&&window.isSecureContext){"
                    . "navigator.clipboard.writeText(v).then(done).catch(legacyCopy);"
                . "}else{legacyCopy();}"
                . "})(this)";

            foreach ($shippingDetailsAll as $shippingDetail) {
                $orderItem = $shippingDetail->orderItems;

                if ($orderItem && (!empty($shippingDetail->tracking_no) || !empty($shippingDetail->tracking_link))) {
                    $productName = optional($orderItem->productDetails)->product_name
                        ?? $orderItem->display_name
                        ?? '-';
                    $sizeName     = $shippingDetail->size_name ?? '-';
                    $trackingNo   = $shippingDetail->tracking_no ?? '-';
                    $trackingLink = $shippingDetail->tracking_link ?? '';

                    $itemLabel = $productName . ' - ' . $sizeName;

                    if (!empty($shippingDetail->player_name) || !empty($shippingDetail->player_number)) {
                        $playerBits = [];
                        if (!empty($shippingDetail->player_name)) {
                            $playerBits[] = $shippingDetail->player_name;
                        }
                        if (!empty($shippingDetail->player_number)) {
                            $playerBits[] = '#' . $shippingDetail->player_number;
                        }
                        $itemLabel .= ' (' . implode(' ', $playerBits) . ')';
                    }

                    $bg        = $rowIndex % 2 === 0 ? '#f9fafb' : '#ffffff';
                    $borderTop = $rowIndex === 0 ? '' : 'border-top:1px solid #f0f0f0;';

                    $trackingLinkIcon = '';
                    if (!empty($trackingLink)) {
                        $trackingLinkIcon = '
                            <a href="' . e($trackingLink) . '" target="_blank" rel="noopener noreferrer"
                                style="color:#9ca3af; font-size:14px; text-decoration:none; margin-left:10px; padding-left:10px; border-left:1px solid #e5e7eb;" title="Open tracking link">
                                <i class="fas fa-external-link-alt"></i>
                            </a>';
                    }

                    $copyIcon = '
                        <i class="far fa-copy js-copy-tracking"
                        data-tracking="' . e($trackingNo) . '"
                        title="Copy tracking number"
                        style="color:#9ca3af; cursor:pointer; font-size:13px;"
                        onclick="' . htmlspecialchars($copyOnClick, ENT_QUOTES) . '"></i>';

                    $itemRows .= '
                    <div style="display:flex; align-items:center; justify-content:space-between; gap:16px; padding:12px 16px; font-size:13px; color:#1f2937; background:' . $bg . '; ' . $borderTop . '">
                        <span style="display:flex; align-items:center; gap:9px;">
                            <span style="width:7px; height:7px; border-radius:50%; background:#0d9488; flex-shrink:0; display:inline-block;"></span>
                            ' . e($itemLabel) . '
                        </span>
                        <span style="display:flex; align-items:center; gap:8px; white-space:nowrap;">
                            <span style="font-weight:700; color:#111827;">' . e($trackingNo) . '</span>
                            ' . $copyIcon . '
                            ' . $trackingLinkIcon . '
                        </span>
                    </div>';

                    $rowIndex++;
                }
            }

            $urgentBadge = '';
            if (!empty($order->is_urgent)) {
                $urgentBadge = '
                    <span style="display:inline-flex; align-items:center; gap:5px; color:#dc2626; font-size:12px; font-weight:700; background-color:#FFEDEE; border-radius:10px; padding:5px 5px; margin-top:20px;">
                        <span style="width:7px; height:7px; border-radius:50%; background:#dc2626; display:inline-block; flex-shrink:0;"></span>
                        Urgent order
                    </span>';
            }

            if ($rowIndex > 0) {
                $builder = new NotificationBuilderService();

                $builder->sendNotification('key_send_Notification_To_Sales', [
                    '{order_no}'                => $order->order_no,
                    '{user_name}'               => auth()->user()->name,
                    '{shipping_details_url}'    => $shippingDetailsUrl,
                    '{organization_name}'       => $order->organizationDetails->organization_name ?? '',
                    '{item_rows}'               => $itemRows,
                    '{urgent_badge}'            => $urgentBadge,
                    '{report_file_name}'        => 'Tracking_numbers_order_' . $orderId . '.pdf',
                    '{report_file_url}'         => url('order_details/report/' . $orderId . '/download'),
                    '{total_order_qty}'         => $totalOrderQty,
                    '{shipped_qty}'             => $shippedQty,
                    '{estimated_delivery_date}' => $estimatedDiliveryDate,
                ], [
                    'order_id'                   => $orderId,
                    'target_notification_field'  => 'key_send_Notification_To_Sales',
                    'new_notification'            => 1,
                ]);
            }
        }
    }



}
