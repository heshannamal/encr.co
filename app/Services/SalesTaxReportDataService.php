<?php

namespace App\Services;

use App\Models\Order;
use Carbon\Carbon;
use Illuminate\Support\Collection;
use Illuminate\Support\Facades\DB;

class SalesTaxReportDataService
{
    public const LOCAL_USE_TAX_CITY = 'San Rafael';

    public function rows(?string $startDate = null, ?string $endDate = null): Collection
    {
        $query = Order::with([
            'organizationDetails',
            'userDetails',
            'statusDetails',
        ]);

        if ($startDate) {
            $start = Carbon::createFromFormat('m/d/Y', $startDate)->startOfDay();
            $query->whereRaw(
                "STR_TO_DATE(production_date, '%m/%d/%Y') >= ?",
                [$start->format('Y-m-d H:i:s')]
            );
        }

        if ($endDate) {
            $end = Carbon::createFromFormat('m/d/Y', $endDate)->endOfDay();
            $query->whereRaw(
                "STR_TO_DATE(production_date, '%m/%d/%Y') <= ?",
                [$end->format('Y-m-d H:i:s')]
            );
        }

        $orders = $query
            ->whereIn('order_status_id', [3, 4, 8])
            ->where('active', 1)
            ->whereNotNull('sub_total')
            ->where('sub_total', '>', 0)
            ->whereNotNull('sales_tax')
            ->where('sales_tax', '>', 0)
            ->where(function ($q) {
                $q->where('order_no', 'not like', 'TSR%')
                    ->orWhere(function ($sub) {
                        $sub->where('order_no', 'like', 'TSR%')
                            ->whereExists(function ($existQuery) {
                                $existQuery->select(DB::raw(1))
                                    ->from('store_orders')
                                    ->whereColumn(
                                        'store_orders.system_order_no',
                                        'orders.order_no'
                                    );
                            });
                    });
            })
            ->orderBy('created_at', 'desc')
            ->orderBy('id', 'desc')
            ->get();

        $orders->load('organizationDetails.contactOrganizations.contacts');

        return $orders->map(function ($row) {
            $address = app(\App\Services\SalesTaxShippingAddress::class)
                ->resolve($row->organizationDetails);

            $state = trim((string) ($address['state'] ?? '')) ?: '-';
            $city = trim((string) ($address['city'] ?? '')) ?: '-';
            $county = trim((string) ($address['county'] ?? '')) ?: '-';

            $taxableTotal = (float) ($row->sub_total ?? 0);
            $taxAmount = (float) ($row->sales_tax ?? 0);
            $taxRate = (float) ($row->organizationDetails->sales_tax ?? 0);
            $isLocalUseTax = $this->isLocalUseTaxCity($city);

            return [
                'order_id' => $row->id,
                'organization_id' => $row->organizationDetails->id ?? null,
                'order_no' => $row->order_no,
                'organization_name' => $row->organizationDetails->organization_name ?? '-',
                'state' => $state,
                'city' => $city,
                'county' => $county,
                'sales_person' => $row->userDetails->name ?? '-',
                'production_date' => $row->production_date
                    ? Carbon::parse($row->production_date)->format('m/d/Y')
                    : '-',
                'order_status' => ucfirst($row->statusDetails->status_name ?? '-'),
                'tax_rate' => $taxRate,
                'taxable_total' => $taxableTotal,
                'sales_tax' => $isLocalUseTax ? 0.0 : $taxAmount,
                'use_tax' => $isLocalUseTax ? $taxAmount : 0.0,
                'total_tax' => $taxAmount,
                'is_local_use_tax' => $isLocalUseTax,
            ];
        })->values();
    }

    public function filterRows(Collection $rows, ?string $county = null, ?string $city = null): Collection
    {
        $county = trim((string) $county);
        $city = trim((string) $city);

        return $rows
            ->filter(function (array $row) use ($county, $city) {
                if ($county !== '' && strcasecmp($row['county'], $county) !== 0) {
                    return false;
                }

                if ($city !== '' && strcasecmp($row['city'], $city) !== 0) {
                    return false;
                }

                return true;
            })
            ->values();
    }

    public function filterOptions(Collection $dateRows, ?string $selectedCounty = null): array
    {
        $counties = $dateRows
            ->pluck('county')
            ->filter(fn ($value) => $value !== '' && $value !== '-')
            ->unique(fn ($value) => mb_strtolower($value))
            ->sort(SORT_NATURAL | SORT_FLAG_CASE)
            ->values();

        $citiesByCounty = [];

        foreach ($counties as $county) {
            $citiesByCounty[$county] = $dateRows
                ->filter(fn ($row) => strcasecmp($row['county'], $county) === 0)
                ->pluck('city')
                ->filter(fn ($value) => $value !== '' && $value !== '-')
                ->unique(fn ($value) => mb_strtolower($value))
                ->sort(SORT_NATURAL | SORT_FLAG_CASE)
                ->values()
                ->all();
        }

        $selectedCounty = trim((string) $selectedCounty);

        $cities = $selectedCounty !== '' && isset($citiesByCounty[$selectedCounty])
            ? collect($citiesByCounty[$selectedCounty])
            : $dateRows
                ->pluck('city')
                ->filter(fn ($value) => $value !== '' && $value !== '-')
                ->unique(fn ($value) => mb_strtolower($value))
                ->sort(SORT_NATURAL | SORT_FLAG_CASE)
                ->values();

        return [
            'counties' => $counties->all(),
            'cities' => collect($cities)->values()->all(),
            'cities_by_county' => $citiesByCounty,
        ];
    }

    public function summary(Collection $rows): array
    {
        return [
            'order_count' => $rows->count(),
            'taxable_total_sales' => (float) $rows->sum('taxable_total'),
            'sales_tax_total' => (float) $rows->sum('sales_tax'),
            'use_tax_total' => (float) $rows->sum('use_tax'),
            'total_sales_tax' => (float) $rows->sum('total_tax'),
        ];
    }

    public function countyHierarchy(Collection $rows): array
    {
        return $rows
            ->groupBy(fn ($row) => $this->groupLabel($row['county'] ?? null, 'County'))
            ->sortKeys(SORT_NATURAL | SORT_FLAG_CASE)
            ->map(function ($countyRows, $countyName) {
                $countyRows = collect($countyRows);

                $cities = $countyRows
                    ->groupBy(fn ($row) => $this->groupLabel($row['city'] ?? null, 'City'))
                    ->sortKeys(SORT_NATURAL | SORT_FLAG_CASE)
                    ->map(function ($cityRows, $cityName) {
                        $cityRows = collect($cityRows);
                        $summary = $this->summary($cityRows);

                        return [
                            'name' => $cityName,
                            'order_count' => $summary['order_count'],
                            'order_total' => $summary['taxable_total_sales'],
                            'tax_rate' => $this->representativeRate($cityRows),
                            'sales_tax' => $summary['sales_tax_total'],
                            'use_tax' => $summary['use_tax_total'],
                            'total_sales_tax' => $summary['total_sales_tax'],
                            'orders' => $cityRows->values()->all(),
                        ];
                    })
                    ->values()
                    ->all();

                $summary = $this->summary($countyRows);

                return [
                    'name' => $countyName,
                    'order_count' => $summary['order_count'],
                    'order_total' => $summary['taxable_total_sales'],
                    'tax_rate' => null,
                    'sales_tax' => $summary['sales_tax_total'],
                    'use_tax' => $summary['use_tax_total'],
                    'total_sales_tax' => $summary['total_sales_tax'],
                    'cities' => $cities,
                ];
            })
            ->values()
            ->all();
    }

    public function citySummaryRows(Collection $rows): Collection
    {
        return $rows
            ->groupBy(function ($row) {
                return mb_strtolower($row['county'] . '||' . $row['city']);
            })
            ->map(function ($cityRows) {
                $cityRows = collect($cityRows);
                $first = $cityRows->first();
                $summary = $this->summary($cityRows);
                $isLocal = $this->isLocalUseTaxCity($first['city'] ?? '');
                $rate = $this->representativeRate($cityRows);

                return [
                    'county' => $first['county'] ?? '-',
                    'city' => $first['city'] ?? '-',
                    'order_count' => $summary['order_count'],
                    'order_total' => $summary['taxable_total_sales'],
                    'sales_tax_rate' => $isLocal ? null : $rate,
                    'sales_tax' => $summary['sales_tax_total'],
                    'use_tax_rate' => $isLocal ? $rate : null,
                    'use_tax' => $summary['use_tax_total'],
                    'total_sales_tax' => $summary['total_sales_tax'],
                ];
            })
            ->sortBy(
                fn ($row) => mb_strtolower(($row['county'] ?? '') . '||' . ($row['city'] ?? '')),
                SORT_NATURAL
            )
            ->values();
    }

    public function countySummaryRows(Collection $rows): Collection
    {
        return $rows
            ->groupBy(fn ($row) => mb_strtolower($row['county'] ?? '-'))
            ->map(function ($countyRows) {
                $countyRows = collect($countyRows);
                $first = $countyRows->first();
                $summary = $this->summary($countyRows);

                $salesTaxRows = $countyRows->filter(fn ($row) => !$row['is_local_use_tax']);
                $useTaxRows = $countyRows->filter(fn ($row) => $row['is_local_use_tax']);

                return [
                    'county' => $first['county'] ?? '-',
                    'order_count' => $summary['order_count'],
                    'order_total' => $summary['taxable_total_sales'],
                    'sales_tax_rate' => $this->representativeRate($salesTaxRows),
                    'sales_tax' => $summary['sales_tax_total'],
                    'use_tax_rate' => $this->representativeRate($useTaxRows),
                    'use_tax' => $summary['use_tax_total'],
                    'total_sales_tax' => $summary['total_sales_tax'],
                ];
            })
            ->sortBy('county', SORT_NATURAL | SORT_FLAG_CASE)
            ->values();
    }

    public function localRows(Collection $rows): Collection
    {
        return $rows
            ->filter(fn ($row) => $row['is_local_use_tax'])
            ->values();
    }

    public function isLocalUseTaxCity(?string $city): bool
    {
        return mb_strtolower(trim((string) $city)) === mb_strtolower(self::LOCAL_USE_TAX_CITY);
    }

    protected function representativeRate(Collection $rows): ?float
    {
        if ($rows->isEmpty()) {
            return null;
        }

        $rates = $rows
            ->pluck('tax_rate')
            ->map(fn ($rate) => round((float) $rate, 6))
            ->filter(fn ($rate) => $rate > 0)
            ->unique()
            ->values();

        return $rates->count() === 1
            ? (float) $rates->first()
            : null;
    }

    protected function groupLabel($value, string $fallback): string
    {
        $value = trim((string) $value);

        return ($value === '' || $value === '-')
            ? 'Unknown ' . $fallback
            : $value;
    }
}
