<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class RolesToPermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('roles_to_permissions')->insert(
            // Admin Permissions
            [[
                'role_id' => 1,
                'permission_id' => 1
            ],
            [
                'role_id' => 1,
                'permission_id' => 2
            ],
            [
                'role_id' => 1,
                'permission_id' => 4
            ],
            [
                'role_id' => 1,
                'permission_id' => 5
            ],
            [
                'role_id' => 1,
                'permission_id' => 6
            ],

            // Physician Permissions
            [
                'role_id' => 2,
                'permission_id' => 3
            ],
            [
                'role_id' => 2,
                'permission_id' => 4
            ],
            [
                'role_id' => 2,
                'permission_id' => 6
            ],

            // Patient Permissions
            [
                'role_id' => 3,
                'permission_id' => 5
            ],
            [
                'role_id' => 3,
                'permission_id' => 6
            ]]
        );
    }
}
