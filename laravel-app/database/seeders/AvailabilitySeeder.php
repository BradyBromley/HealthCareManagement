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
        \DB::table('Availability')->insert(
            [[
                'physicianID' => 2,
                'availableTime' => '02:00:00',
            ],
            [
                'physicianID' => 2,
                'availableTime' => '02:30:00',
            ],
            [
                'physicianID' => 2,
                'availableTime' => '03:00:00',
            ],
            [
                'physicianID' => 2,
                'availableTime' => '03:30:00',
            ],
            [
                'physicianID' => 2,
                'availableTime' => '04:00:00',
            ]]
        );
    }
}
