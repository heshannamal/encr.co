<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ContactsImport implements ToArray, WithStartRow
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
                'contact_name' => $row[0],
                'label' => $row[1],
                'pd_organization' => $row[2],
                'email' => $row[3],
                'phone_no' => $row[4],
                'no_of_closed_deals' => $row[5],
                'no_of_opened_deals' => $row[6],
                'next_activity_date' => $row[7],
                'owner' => $row[8],
                'pd_created_date' => $row[9],
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
