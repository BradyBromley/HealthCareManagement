<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('roles')->insert(
            [[
                'role_name' => 'admin'
            ],
            [
                'role_name' => 'physician'
            ],
            [
                'role_name' => 'patient'
            ],
            [
                'role_name' => 'guest'
            ]]
        );
    }
}
