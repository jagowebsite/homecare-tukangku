<?php

namespace Database\Seeders;

use App\Models\Employee;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        Employee::create([
            'service_category_id' => 1,
            'name' => 'Handoko Wijaya',
            'address' => 'Jalan timur raya',
            'number' => '(021) 253 9827',
            'is_ready' => 1,
            'status_employee' => 'active',
        ]);
    }
}
