<?php

namespace Database\Seeders;

use App\Models\Employee;
use App\Models\Menu;
use Illuminate\Database\Seeder;

class EmployeeSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        Employee::create([
            'username' => 'isys',
            'password' => bcrypt('isys$2024'),
        ]);
    }
}
