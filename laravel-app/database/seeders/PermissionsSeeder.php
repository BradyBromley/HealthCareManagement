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
        \DB::table('permissions')->insert(
            [[
                'permission_name' => 'admin'
            ],
            [
                'permission_name' => 'userListing'
            ],
            [
                'permission_name' => 'appointmentListing'
            ],
            [
                'permission_name' => 'physicianAppointmentListing'
            ],
            [
                'permission_name' => 'patientAppointmentListing'
            ],
            [
                'permission_name' => 'bookAppointment'
            ]]
        );
    }
}
