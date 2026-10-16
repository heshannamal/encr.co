<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use App\Models\SupportDepartment;

class SupportDepartmentSeeder extends Seeder
{
    public function run(): void
    {
        SupportDepartment::insert([
            [
                'name' => 'Technical Support',
                'slug' => 'technical-support',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Sales Support',
                'slug' => 'sales-support',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
            [
                'name' => 'Account Support',
                'slug' => 'account-support',
                'is_active' => true,
                'created_at' => now(),
                'updated_at' => now(),
            ],
        ]);
    }
}
