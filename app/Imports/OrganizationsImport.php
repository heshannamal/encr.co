<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;

class OrganizationsImport implements ToArray, WithStartRow
{
    private $data;

    public function __construct()
    {
        $this->data = [];
    }

    public function array(array $rows)
    {
        foreach ($rows as $row) {
            $this->data[] = array(
                'organization_name' => $row[0],
                'address' => $row[1],
                'website' => $row[2],
                'size_of_club' => $row[3],
                'country' => $row[4],
                'no_of_people' => $row[5],
                'no_of_closed_deals' => $row[6],
                'no_of_opened_deals' => $row[7],
                'next_activity_date' => $row[8],
                'location' => $row[9],
                'owner' => $row[10],
                'state' => $row[11],
            );
        }
    }

    public function startRow(): int
    {
        return 2;
    }

    public function getArray(): array
    {
        return $this->data;
    }
}
