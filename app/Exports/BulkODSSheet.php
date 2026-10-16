<?php

namespace App\Exports;

use App\Models\Order;
use App\Models\OrderItem;
use Carbon\Carbon;
use Maatwebsite\Excel\Concerns\WithTitle;
use Maatwebsite\Excel\Concerns\WithColumnWidths;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Maatwebsite\Excel\Concerns\WithStyles;
use PhpOffice\PhpSpreadsheet\Worksheet\Worksheet;
use PhpOffice\PhpSpreadsheet\Style\Alignment;

class BulkODSSheet implements WithTitle, WithColumnWidths, WithStyles, FromView
{
    private $id;

    public function __construct(int $id)
    {
        $this->id = $id;
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

    public function view(): View
    {
        $order = Order::query()->where('id', $this->id);

        $this->userGroupFactories();
        $oderSearch = $this->oderSearch;
        $factoryIds = $this->factoryIds;

        $id = $this->id;

        $orderQuery = Order::with('organizationDetails', 'userDetails', 'statusDetails', 'contactDetails');


        $orderItemQuery = OrderItem::with('productDetails', 'factoryDetails', 'exFactoryDetails', 'fabricDetails', 'secFabricDetails',
                                    'embellishmentDetails', 'orderItemDetails.sizeDetails');

        if($oderSearch == 'factory'){
            $orderQuery->with(['orderItems'=>function($qry) use($factoryIds){
                                $qry->with('productDetails', 'statusDetails')
                                    ->whereIn('factory_id', $factoryIds)
                                    ->where('order_status_id', 3);
                            }]);
            $orderItemQuery->whereIn('factory_id', $factoryIds);
        } else {
            $orderQuery->with('orderItems', 'orderItems.productDetails', 'orderItems.statusDetails');
        }

        $order = $orderQuery->where('id', $id)->first();

        $date = Carbon::now();
        $nowDate = $date->format('m-d-Y');

        if ($order->order_ref_no) {
            $orderRef = 'Repeat';
        } else {
            $orderRef = 'New';
        }

        if ($order->contactDetails->first_name) { $contact_name = $order->contactDetails->first_name.' '.$contact_name = $order->contactDetails->last_name.', '; } else { $contact_name = ''; }
        if ($order->is_new_shipping_address == 1) {
            if ($order->apartment) { $apartment = $order->apartment.', '; } else { $apartment = ''; }
            if ($order->street) { $street = $order->street.', '; } else { $street = ''; }
            if ($order->city) { $city = $order->city.', '; } else { $city = ''; }
            if ($order->state) { $state = $order->state.', '; } else { $state = ''; }
            if ($order->postal_code) { $postal_code = $order->postal_code.', '; } else { $postal_code = ''; }
            if ($order->country) { $country = $order->country.', '; } else { $country = ''; }
            if ($order->phone_no) { $phone_no = $order->phone_no.', '; } else { $phone_no = ''; }
            if ($order->email) { $email = $order->email; } else { $email = ''; }

            $address = $contact_name.$apartment.$street.$city.$state.$postal_code.$country.$phone_no.$email;

        } else if($order->is_new_shipping_address == 3){
            if ($order->contactDetails->apartment2) { $apartment2 = $order->contactDetails->apartment2.', '; } else { $apartment2 = ''; }
            if ($order->contactDetails->shipping_street_2) { $street = $order->contactDetails->shipping_street_2.', '; } else { $street = ''; }
            if ($order->contactDetails->shipping_city_2) { $city = $order->contactDetails->shipping_city_2.', '; } else { $city = ''; }
            if ($order->contactDetails->shipping_state_2) { $state = $order->contactDetails->shipping_state_2.', '; } else { $state = ''; }
            if ($order->contactDetails->shipping_zip_2) { $postal_code = $order->contactDetails->shipping_zip_2.', '; } else { $postal_code = ''; }
            if ($order->contactDetails->shipping_country_2) { $country = $order->contactDetails->shipping_country_2.', '; } else { $country = ''; }
            if ($order->contactDetails->phone_no) { $phone_no = $order->contactDetails->phone_no.', '; } else { $phone_no = ''; }
            if ($order->contactDetails->email) { $email = $order->contactDetails->email; } else { $email = ''; }

            $address = $contact_name.$apartment2.$street.$city.$state.$postal_code.$country.$phone_no.$email;
        }else {
            // if ($order->contactDetails->shipping_po_box) { $po_box = $order->contactDetails->shipping_po_box.', '; } else { $po_box = ''; }
            if ($order->contactDetails->shipping_street) { $street = $order->contactDetails->shipping_street.', '; } else { $street = ''; }
            if ($order->contactDetails->shipping_city) { $city = $order->contactDetails->shipping_city.', '; } else { $city = ''; }
            if ($order->contactDetails->shipping_state) { $state = $order->contactDetails->shipping_state.', '; } else { $state = ''; }
            if ($order->contactDetails->shipping_zip) { $postal_code = $order->contactDetails->shipping_zip.', '; } else { $postal_code = ''; }
            if ($order->contactDetails->shipping_country) { $country = $order->contactDetails->shipping_country.', '; } else { $country = ''; }
            if ($order->contactDetails->phone_no) { $phone_no = $order->contactDetails->phone_no.', '; } else { $phone_no = ''; }
            if ($order->contactDetails->email) { $email = $order->contactDetails->email; } else { $email = ''; }

            $address = $contact_name.$street.$city.$state.$postal_code.$country.$phone_no.$email;
        }

        return view('pages.order_management.exports.bulk_ods', ['order'=>$order, 'nowDate'=>$nowDate, 'orderRef'=>$orderRef, 'address'=>$address]);
    }

    public function styles(Worksheet $sheet)
    {
        return [
            '5' => [
                'alignment' => [
                    'vertical' => Alignment::VERTICAL_CENTER,
                ],
            ],
            'B5' => [
                'alignment' => [
                    'wrapText' => true,
                ],
            ]
        ];
    }

    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 40,
            'C' => 20,
            'D' => 15,
        ];
    }

    public function title(): string
    {
        return 'ODS';
    }
}
