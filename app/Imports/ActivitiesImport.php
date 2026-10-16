<?php

namespace App\Imports;

use Maatwebsite\Excel\Concerns\ToArray;
use Maatwebsite\Excel\Concerns\WithStartRow;

class ActivitiesImport implements ToArray, WithStartRow
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
                'done' => $row[0],
                'subject' => $row[1],
                'deal' => $row[2],
                'note' => $row[3],
                'contact_name' => $row[4],
                'email' => $row[5],
                'phone_no' => $row[6],
                'organization_name' => $row[7],
                'due_date' => $row[8],
                'duration' => $row[9],
                'assigned_user_name' => $row[10],
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
