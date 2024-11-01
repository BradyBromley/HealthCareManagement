<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class AvailabilityUserSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        \DB::table('availability_user')->insert(
            [[
                'availability_id' => 4,
                'user_id' => 2,
            ],
            [
                'availability_id' => 5,
                'user_id' => 2,
            ],
            [
                'availability_id' => 6,
                'user_id' => 2,
            ],
            [
                'availability_id' => 7,
                'user_id' => 2,
            ],
            [
                'availability_id' => 8,
                'user_id' => 2,
            ]]
        );
    }
}
