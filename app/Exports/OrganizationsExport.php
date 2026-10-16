<?php

namespace App\Exports;

use App\Models\Organization;
use Maatwebsite\Excel\Concerns\FromCollection;
use Maatwebsite\Excel\Concerns\WithHeadings;
use Maatwebsite\Excel\Concerns\WithMapping;

class OrganizationsExport implements FromCollection, WithHeadings, WithMapping
{
    public function collection()
    {
        return Organization::with([
                'contactOrganizations.contacts',
                'orders' => function ($query) {
                    $query->whereNotIn('order_status_id', [1, 7]);
                }
            ])
            ->where('active', 1)
            ->whereHas('orders', function ($query) {
                $query->whereNotIn('order_status_id', [1, 7]);
            }, '>', 1)
            ->get();
    }

    public function headings(): array
    {
        return [
            'Organization Name',
            'Contact Persons',
            'Number of Orders',
            'Website',
            'Address',
        ];
    }

    public function map($organization): array
    {
        $contacts = $organization->contactOrganizations
            ->flatMap(function ($co) {
                return $co->contacts;
            })
            ->pluck('first_name', 'last_name')
            ->map(function ($first, $last) {
                return trim($first . ' ' . $last);
            })
            ->implode(', ');

        $numOrders = $organization->orders->count();

        $address = trim(
            implode(', ', array_filter([
                $organization->shipping_street ?? null,
                $organization->shipping_city ?? null,
                $organization->shipping_state ?? null,
                $organization->shipping_postal_code ?? null,
                $organization->shipping_country ?? null
            ]))
        );

        return [
            $organization->organization_name ?? '',
            $contacts,
            $numOrders,
            $organization->website ?? '',
            $address
        ];
    }
}
