<?php

namespace App\Http\Controllers;

use Carbon\Carbon;
use Illuminate\Http\Request;
use App\Models\SubProduct;
use App\Models\SubProductPrice;
use App\Models\FactoryPriceUserFilter;
use Illuminate\Support\Facades\DB;
use App\Exports\FactoryPriceListExport;
use Illuminate\Support\Facades\Auth;

class FactoryPriceListController extends Controller
{
    public function factoryPriceList()
    {
        $factoryPriceFilter = FactoryPriceUserFilter::where('user_id', Auth::id())->first();

        // Base query
        $subProductQuery = SubProduct::with(['prices']);

        if ($factoryPriceFilter) {
            $searchValue   = $factoryPriceFilter->search_value;
            $activeStatus  = $factoryPriceFilter->product_status;
            $pricingStatus = $factoryPriceFilter->pricing;
            $pricetype     = $factoryPriceFilter->pricetype;

            // Search filter
            if (!empty($searchValue)) {
                $subProductQuery->where(function ($query) use ($searchValue) {
                    $query->where('product_name', 'LIKE', "%{$searchValue}%")
                        ->orWhere('sub_product_no', 'LIKE', "%{$searchValue}%");
                });
            }

            // Active/inactive filter
            if (!is_null($activeStatus)) {
                $subProductQuery->where('active', $activeStatus);
            }

            // Pricing status filter
            if (!is_null($pricingStatus)) {
                if ($pricingStatus == 1) { // has pricing
                    $subProductQuery->whereHas('prices');
                } elseif ($pricingStatus == 2) { // no pricing
                    $subProductQuery->whereDoesntHave('prices');
                }
            }

            // Load with prices
            $subProduct = $subProductQuery->get();

            // Map prices into attributes like General, Silver, Gold...
            $subProduct = $subProduct->map(function ($sub) use ($pricetype) {
                $priceMap = [
                    1 => 'General_price',
                    2 => 'Silver_price',
                    3 => 'Gold_price',
                    4 => 'Platinum_price',
                    5 => 'price',
                ];

                foreach ($priceMap as $type => $column) {
                    $sub->{$column} = optional(
                        $sub->prices->where('price_type', $type)->first()
                    )->price;
                }

                // If filtering by a single price type
                if (!is_null($pricetype)) {
                    $sub->prices = $sub->prices->where('price_type', $pricetype);
                }

                return $sub;
            });

            // Sort by sub_product_no parts (like your DB::raw logic)
            $subProduct = $subProduct->sortBy(function ($sub) {
                $parts = preg_split('/[-.]/', $sub->sub_product_no);
                return [(int)($parts[1] ?? 0), (int)($parts[2] ?? 0)];
            })->values();

            return view('pages.masters.factory_price_list.index', [
                'subProduct'        => $subProduct,
                'factoryPriceFilter'=> $factoryPriceFilter,
                'activeStatus'      => $activeStatus,
                'pricingStatus'     => $pricingStatus,
                'searchValue'       => $searchValue,
                'pricetype'         => $pricetype,
            ]);
        }

        // Default when no filter is saved
        $subProduct = SubProduct::with(['prices'])->get();

        $subProduct = $subProduct->map(function ($sub) {
            $priceMap = [
                1 => 'General_price',
                2 => 'Silver_price',
                3 => 'Gold_price',
                4 => 'Platinum_price',
                5 => 'price',
            ];
            foreach ($priceMap as $type => $column) {
                $sub->{$column} = optional(
                    $sub->prices->where('price_type', $type)->first()
                )->price;
            }
            return $sub;
        });

        $subProduct = $subProduct->sortBy(function ($sub) {
            $parts = preg_split('/[-.]/', $sub->sub_product_no);
            return [(int)($parts[1] ?? 0), (int)($parts[2] ?? 0)];
        })->values();

        return view('pages.masters.factory_price_list.index', [
            'subProduct'    => $subProduct,
            'activeStatus'  => null,
            'pricingStatus' => null,
            'pricetype'     => null,
            'searchValue'   => ''
        ]);
    }


    public function manufacturerPrice(Request $request)
    {
        $changes = $request->input('changes', []);
        $currentDate = Carbon::now();

        foreach ($changes as $change) {

            $sub_product_no = $change['sub_product_no'];
            if (array_key_exists('weight', $change)) {

                $subProduct = SubProduct::where(
                    'sub_product_no',
                    $sub_product_no
                )->first();

                if ($subProduct) {
                    $subProduct->weight = $change['weight'];
                    $subProduct->save();
                }
            }
            $priceTypes = [
                'Manufacturer_price' => 5,
                'Platinum_price'     => 4,
                'Gold_price'         => 3,
                'Silver_price'       => 2,
                'General_price'      => 1,
            ];

            foreach ($priceTypes as $priceKey => $priceType) {

                if (!array_key_exists($priceKey, $change)) {
                    continue;
                }

                $price = $change[$priceKey];
                $subProductPrice = SubProductPrice::where('active', 1)
                    ->where('price_type', $priceType)
                    ->where('sub_product_no', $sub_product_no)
                    ->first();

                if ($subProductPrice) {
                    $subProductPrice->active = 0;
                    $subProductPrice->save();
                }

                $newSubProductPrice = new SubProductPrice();
                $newSubProductPrice->sub_product_no = $sub_product_no;
                $newSubProductPrice->price = $price;
                $newSubProductPrice->price_type = $priceType;
                $newSubProductPrice->active = 1;
                $newSubProductPrice->start_date = $currentDate->format('Y-m-d');
                $newSubProductPrice->save();
            }
        }

        return response()->json([
            'message' => 'Prices and weight updated successfully'
        ]);
    }



    public function subProductSearch(Request $request)
    {
        $searchValue   = $request->input('searchValue');
        $activeStatus  = (int) $request->input('activeStatus');
        $pricingStatus = (int) $request->input('pricingStatus');
        $pricetype     = $request->input('pricetype');

        $subProductQuery = SubProduct::with(['prices' => function ($q) use ($pricetype) {
            $q->where('active', 1);

            // If a price type is selected, filter inside relation
            if (empty($pricetype) && !empty($pricetype)) {
                $q->where('price_type', $pricetype);
            }
        }]);

        // Search filter
        if (!empty($searchValue)) {
            $subProductQuery->where(function ($query) use ($searchValue) {
                $query->where('product_name', 'LIKE', "%{$searchValue}%")
                    ->orWhere('sub_product_no', 'LIKE', "%{$searchValue}%");
            });
        }

        // Active status filter
        if (isset($activeStatus) && !empty($activeStatus)) {
            $subProductQuery->where('active', $activeStatus);
        }

        // Pricing status filter
        if (isset($pricingStatus) && !empty($pricingStatus)) {
            if ($pricingStatus == 1) { // has pricing
                $subProductQuery->whereHas('prices');
            } elseif ($pricingStatus == 2) { // no pricing
                $subProductQuery->whereDoesntHave('prices');
            }
        }

        // Fetch results
        $subProducts = $subProductQuery->get();

        // Map prices into attributes like General, Silver, Gold, etc.
        $subProducts = $subProducts->map(function ($sub) use ($pricetype) {
            $priceMap = [
                1 => 'General_price',
                2 => 'Silver_price',
                3 => 'Gold_price',
                4 => 'Platinum_price',
                5 => 'price',
            ];

            foreach ($priceMap as $type => $column) {
                $sub->{$column} = optional(
                    $sub->prices->where('price_type', $type)->first()
                )->price;
            }

            // If filtering by a single price type, only keep that set
            if (!empty($pricetype)) {
                $sub->prices = $sub->prices->where('price_type', $pricetype);
            }

            return $sub;
        });

        // Sort by sub_product_no parts
        $subProducts = $subProducts->sortBy(function ($sub) {
            $parts = preg_split('/[-.]/', $sub->sub_product_no);
            return [(int)($parts[1] ?? 0), (int)($parts[2] ?? 0)];
        })->values();

        return response()->json([
            'subProducts' => $subProducts,
            'pricetype'   => $pricetype,
        ]);
    }


    public function factoryPriceList_CSV_download($activeInactive, $pricingOrNot, $inputValue, $pricetype)
    {

        $activeInactive = ($activeInactive === 'all') ? null : $activeInactive;
        $pricingOrNot = ($pricingOrNot === 'all') ? null : $pricingOrNot;
        $inputValue = ($inputValue === 'all') ? null : $inputValue;
        $pricetype = ($pricetype === 'all') ? null : $pricetype;

        return (new FactoryPriceListExport($activeInactive, $pricingOrNot, $inputValue, $pricetype))->download('product_price_list.xlsx');
    }

    public function saveFactoryPriceFilter(Request $request) {
        $searchValue = $request->input('searchValue');
        $activeStatus = $request->input('activeStatus');
        $pricingStatus = $request->input('pricingStatus');
        $pricetype = $request->input('pricetype');

        if(FactoryPriceUserFilter::where('user_id', Auth::user()->id)->first()){
            $factoryPriceFilter = FactoryPriceUserFilter::where('user_id', Auth::user()->id)->first();
            $factoryPriceFilter->product_status = $activeStatus;
            $factoryPriceFilter->pricing = $pricingStatus;
            $factoryPriceFilter->search_value = $searchValue;
            $factoryPriceFilter->pricetype = $pricetype;
            $factoryPriceFilter->update();

            $successMsg = "Updated";

        } else {
            $factoryPriceFilter = new FactoryPriceUserFilter();
            $factoryPriceFilter->user_id = Auth::user()->id;
            $factoryPriceFilter->product_status = $activeStatus;
            $factoryPriceFilter->pricing = $pricingStatus;
            $factoryPriceFilter->search_value = $searchValue;
            $factoryPriceFilter->pricetype = $pricetype;
            $factoryPriceFilter->save();

            $successMsg = "Saved";
        }

        return response()->json(['successMsg'=>$successMsg]);
    }

}
