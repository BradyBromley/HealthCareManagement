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
        \DB::table('RolesToPermissions')->insert(
            // Admin Permissions
            [[
                'roleID' => 1,
                'permissionID' => 1
            ],
            [
                'roleID' => 1,
                'permissionID' => 2
            ],
            [
                'roleID' => 1,
                'permissionID' => 4
            ],
            [
                'roleID' => 1,
                'permissionID' => 5
            ],
            [
                'roleID' => 1,
                'permissionID' => 6
            ],

            // Physician Permissions
            [
                'roleID' => 2,
                'permissionID' => 3
            ],
            [
                'roleID' => 2,
                'permissionID' => 4
            ],
            [
                'roleID' => 2,
                'permissionID' => 6
            ],

            // Patient Permissions
            [
                'roleID' => 3,
                'permissionID' => 5
            ],
            [
                'roleID' => 3,
                'permissionID' => 6
            ]]
        );
    }
}
