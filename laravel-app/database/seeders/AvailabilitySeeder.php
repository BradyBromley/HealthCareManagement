<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailabilitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('availability')->insert(
            [[
                'physician_id' => 2,
                'available_time' => '02:00:00',
            ],
            [
                'physician_id' => 2,
                'available_time' => '02:30:00',
            ],
            [
                'physician_id' => 2,
                'availabletime' => '03:00:00',
            ],
            [
                'physician_id' => 2,
                'availabletime' => '03:30:00',
            ],
            [
                'physician_id' => 2,
                'availabletime' => '04:00:00',
            ]]
        );
    }
}
