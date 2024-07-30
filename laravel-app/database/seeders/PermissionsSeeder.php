<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class PermissionsSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run(): void
    {
        \DB::table('Permissions')->insert(
            [[
                'permissionName' => 'admin'
            ],
            [
                'permissionName' => 'userListing'
            ],
            [
                'permissionName' => 'patientListing'
            ],
            [
                'permissionName' => 'patientProfiles'
            ],
            [
                'permissionName' => 'bookAppointment'
            ],
            [
                'permissionName' => 'appointmentListing'
            ]]
        );
    }
}
