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
        \DB::table('Roles')->insert(
            [[
                'roleName' => 'admin'
            ],
            [
                'roleName' => 'physician'
            ],
            [
                'roleName' => 'patient'
            ],
            [
                'roleName' => 'guest'
            ]]
        );
    }
}
