<?php

namespace App\Exports;

use App\Models\Order;
use Illuminate\Support\Facades\Auth;
use Illuminate\Contracts\View\View;
use Maatwebsite\Excel\Concerns\FromView;
use Illuminate\Support\Facades\DB;
use App\Models\SubProduct;
use Maatwebsite\Excel\Concerns\Exportable;
use Maatwebsite\Excel\Concerns\WithColumnWidths;

class FactoryPriceListExport implements FromView, WithColumnWidths
{
    use Exportable;

    protected $activeInactive1;
    protected $pricingOrNot1;
    protected $inputValue1;
    protected $pricetype1;

    public function __construct($activeInactive, $pricingOrNot, $inputValue, $pricetype)
    {
        $this->activeInactive1 = $activeInactive;
        $this->pricingOrNot1 = $pricingOrNot;
        $this->inputValue1 = $inputValue;
        $this->pricetype1 = $pricetype;
    }
    public function view(): View
    {
        $activeInactive = $this->activeInactive1;
        $pricingOrNot = $this->pricingOrNot1;
        $inputValue = $this->inputValue1;
        $pricetype = $this->pricetype1;

        $subProductQuery = SubProduct::select(
            'sub_products.*',
            DB::raw("MAX(CASE WHEN sub_product_prices.price_type = 4 THEN sub_product_prices.price END) as Platinum_price"),
            DB::raw("MAX(CASE WHEN sub_product_prices.price_type = 3 THEN sub_product_prices.price END) as Gold_price"),
            DB::raw("MAX(CASE WHEN sub_product_prices.price_type = 2 THEN sub_product_prices.price END) as Silver_price"),
            DB::raw("MAX(CASE WHEN sub_product_prices.price_type = 1 THEN sub_product_prices.price END) as General_price"),
            DB::raw("MAX(CASE WHEN sub_product_prices.price_type = 5 THEN sub_product_prices.price END) as price")
        )
            ->groupBy('sub_products.id')
            ->leftJoin('sub_product_prices', function($join) use ($pricetype) {
                $join->on('sub_products.sub_product_no', '=', 'sub_product_prices.sub_product_no')
                    ->where('sub_product_prices.active', 1);

                // Only filter by price type if it's provided
                if (!empty($pricetype)) {
                    $join->where('sub_product_prices.price_type', $pricetype);
                }
            });

        // Apply search input if provided
        if (!empty($inputValue)) {
            $subProductQuery->where(function($query) use ($inputValue) {
                $query->where('sub_products.product_name', 'LIKE', "%{$inputValue}%")
                    ->orWhere('sub_products.sub_product_no', 'LIKE', "%{$inputValue}%");
            });
        }

        // Filter by activeInactive if it's set (including 0)
        if (isset($activeInactive)) {
            $subProductQuery->where('sub_products.active', $activeInactive);
        }

        // Filter by pricing status if selected and not empty
        if (!empty($pricingOrNot)) {
            if ($pricingOrNot == 1) { // Pricing
                $subProductQuery->whereNotNull('sub_product_prices.price');
            } elseif ($pricingOrNot == 2) { // Not Pricing
                $subProductQuery->whereNull('sub_product_prices.price');
            }
        }

        // Sorting logic
        $subProducts = $subProductQuery->orderBy(DB::raw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sub_products.sub_product_no, '-', -1), '.', 1) AS UNSIGNED)")) // Sort by the first number (x)
            ->orderBy(DB::raw("CAST(SUBSTRING_INDEX(SUBSTRING_INDEX(sub_products.sub_product_no, '.', -1), '.', 1) AS UNSIGNED)")) // Sort by the second number (y)
            ->get();

        return view('pages.masters.factory_price_list.export_csv', [
            'subProducts' => $subProducts,
            'pricetype'=> $pricetype
        ]);
    }


    public function columnWidths(): array
    {
        return [
            'A' => 20,
            'B' => 60,
            'C' => 20,
            'D' => 25,
            'E' => 25,
            'F' => 25,
            'G' => 25,
            'H' => 25,
        ];
    }
}
