<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class StaffSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $staffData = [
            [
                'name' => 'Loket 1',
                'active' => true,
                'service_amount' => 0,
                'total_service_time' => 0,
                'username' => 'loket1',
                'password' => Hash::make('loket1pass')
            ],
            [
                'name' => 'Loket 2',
                'active' => true,
                'service_amount' => 0,
                'total_service_time' => 0,
                'username' => 'loket2',
                'password' => Hash::make('loket2pass')
            ],
            [
                'name' => 'Loket 3',
                'active' => true,
                'service_amount' => 0,
                'total_service_time' => 0,
                'username' => 'loket3',
                'password' => Hash::make('loket3pass')
            ],
        ];

        DB::table('staff')->insert($staffData);
    }
}
