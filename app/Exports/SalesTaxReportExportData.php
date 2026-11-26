<?php

namespace App\Exports;

use App\Models\Organization;
use App\Services\SalesTaxReportDataService;
use Illuminate\Support\Str;

class SalesTaxReportExportData
{
    public static function build(
        $startDate = null,
        $endDate = null,
        $county = null,
        $city = null
    ) {
        $service = app(SalesTaxReportDataService::class);

        $county = trim((string) $county);
        $city = trim((string) $city);

        $dateRows = collect(
            $service->rows(
                $startDate,
                $endDate
            )
        )->map(function ($row) {
            $cityKey = Str::slug(
                trim((string) ($row['city'] ?? ''))
            );

            $orderNo = trim(
                (string) ($row['order_no'] ?? '')
            );

            if (
                $cityKey === 'san-rafael'
                && stripos($orderNo, 'TSR') === 0
            ) {
                $useTax = (float) ($row['use_tax'] ?? 0);

                if ($useTax > 0) {
                    $row['sales_tax'] = round(
                        (float) ($row['sales_tax'] ?? 0)
                        + $useTax,
                        2
                    );

                    $row['use_tax'] = 0.00;
                }
            }

            return $row;
        });

        $rows = $service->filterRows(
            $dateRows,
            $county,
            $city
        );

        $summary = $service->summary($rows);

        $hierarchy = collect(
            $service->countyHierarchy($rows)
        );

        $organizationIds = $hierarchy
            ->pluck('cities')
            ->flatten(1)
            ->pluck('orders')
            ->flatten(1)
            ->pluck('organization_id')
            ->filter()
            ->map(function ($id) {
                return (int) $id;
            })
            ->unique()
            ->values();

        $organizationTaxRates = Organization::query()
            ->whereIn('id', $organizationIds)
            ->pluck('sales_tax', 'id');

        $hierarchy = $hierarchy
            ->map(function ($countyGroup) use ($organizationTaxRates) {
                $countyGroup['cities'] = collect(
                    $countyGroup['cities'] ?? []
                )->map(function ($cityGroup) use ($organizationTaxRates) {
                    $taxRate = $cityGroup['tax_rate'] ?? null;

                    if (
                        $taxRate === null
                        || $taxRate === ''
                        || (float) $taxRate <= 0
                    ) {
                        $taxRate = collect(
                            $cityGroup['orders'] ?? []
                        )
                            ->map(function ($order) use ($organizationTaxRates) {
                                $organizationId = (int) (
                                    $order['organization_id'] ?? 0
                                );

                                if (
                                    $organizationId <= 0
                                    || !$organizationTaxRates->has($organizationId)
                                ) {
                                    return null;
                                }

                                $rate = (float) $organizationTaxRates->get(
                                    $organizationId
                                );

                                return $rate > 0
                                    ? $rate
                                    : null;
                            })
                            ->filter(function ($rate) {
                                return $rate !== null;
                            })
                            ->first();
                    }

                    $cityGroup['tax_rate'] = $taxRate;

                    return $cityGroup;
                })->values()->all();

                return $countyGroup;
            })
            ->values();

        $marin = $hierarchy->filter(
            function ($countyGroup) {
                return strcasecmp(
                    trim((string) ($countyGroup['name'] ?? '')),
                    'Marin County'
                ) === 0;
            }
        );

        $others = $hierarchy->reject(
            function ($countyGroup) {
                return strcasecmp(
                    trim((string) ($countyGroup['name'] ?? '')),
                    'Marin County'
                ) === 0;
            }
        );

        $hierarchy = $marin
            ->concat($others)
            ->values();

        return [
            'date_rows' => $dateRows,
            'rows' => $rows,
            'summary' => $summary,
            'hierarchy' => $hierarchy,
            'county' => $county,
            'city' => $city,
            'start_date' => $startDate,
            'end_date' => $endDate,
        ];
    }
}
