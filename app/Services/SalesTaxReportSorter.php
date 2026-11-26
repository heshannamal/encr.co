<?php

namespace App\Services;

use Illuminate\Support\Collection;

class SalesTaxReportSorter
{
    public function sort(Collection $orders, array $requested): Collection
    {
        $columns = ['order_no', 'organization_name', 'state', 'city', 'county', 'sales_person',
            'production_date', 'order_status', 'order_total', 'sales_tax_rate', 'sales_tax'];
        $sorting = [];
        foreach ($requested as $item) {
            if (!is_array($item)) {
                continue;
            }
            $index = filter_var($item['column'] ?? null, FILTER_VALIDATE_INT);
            $direction = strtolower((string) ($item['dir'] ?? ''));
            if ($index !== false && isset($columns[$index]) && in_array($direction, ['asc', 'desc'], true)) {
                $sorting[] = [$columns[$index], $direction === 'desc' ? -1 : 1];
            }
        }
        if (!$sorting) {
            return $orders;
        }

        $addresses = new SalesTaxShippingAddress;
        $keys = [];
        foreach ($orders as $order) {
            $organization = $order->organizationDetails;
            $address = $addresses->resolve($organization);
            $keys[$order->id] = [
                'order_no' => $order->order_no ?? '',
                'organization_name' => $organization->organization_name ?? '-',
                'state' => $address['state'] ?: '-',
                'city' => $address['city'] ?: '-',
                'county' => $address['county'] ?: '-',
                'sales_person' => $order->userDetails->name ?? '-',
                'production_date' => $order->production_date ? (strtotime($order->production_date) ?: 0) : 0,
                'order_status' => $order->statusDetails->status_name ?? '-',
                'order_total' => (float) $order->sub_total,
                'sales_tax_rate' => (float) ($order->sales_tax_rate ?? 0),
                'sales_tax' => (float) $order->sales_tax,
            ];
        }

        return $orders->sort(function ($left, $right) use ($keys, $sorting) {
            foreach ($sorting as [$column, $direction]) {
                $a = $keys[$left->id][$column];
                $b = $keys[$right->id][$column];
                $comparison = is_float($a) || is_int($a) ? $a <=> $b : strnatcasecmp((string) $a, (string) $b);
                if ($comparison !== 0) {
                    return $comparison * $direction;
                }
            }
            // Equal values retain a deterministic order between pages.
            return $right->id <=> $left->id;
        })->values();
    }
}
