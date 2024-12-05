<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Role;
use Illuminate\Http\Request;
use View;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        // Get all appointments
        $appointments = Appointment::sortable()->paginate(10);
        return View::make('appointments.index')->with('appointments', $appointments);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        // Load the create form
        $physicians = User::where('role_id', '2')->where('is_active', '1')->get();
        return View::make('appointments.create')->with('physicians', $physicians);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        //
        
    }

    /**
     * Change the status of an appointment
     *
     * @param  int  $id
     * @param  string  $status
     */
    public function changeStatus($id, $status)
    {
        // Change the status
        $appointment = Appointment::find($id);
        $appointment->status = $status;
        $appointment->save();

        return redirect('appointments');
    }

    /**
     * Update the appointment availability for the physician in real time
     *
     */
    public function updateAppointmentAvailability()
    {
        // Get the appointment availability for the chosen physician and date
        $physician = User::find($_POST['physician_id']);
        $date = $_POST['date'];
        $availabilities = $physician->availabilities()->get();

        // Format the available appointments
        $appointment_options = '';
        foreach ($availabilities as $key => $availability)
        {
            $appointment_options .= "<option value='" . $availability->id . "'>" . date('h:i A', strtotime($availability->time)) . "</option>";
        }

        $appointment_time_select_list = "
        <label for='appointment_time'>Appointment Time</label>
        <select class='form-select' id='appointment_time' name='appointment_time'>
            " . $appointment_options . "
        </select>
        ";

        $result = [];
        $result['appointment_time_select_list'] = $appointment_time_select_list;

        echo json_encode($result);
    }

    

    /**
     * Display the specified resource.
     */
    //public function show(string $id)
    //{
        //
    //}

    /**
     * Show the form for editing the specified resource.
     */
    //public function edit(string $id)
    //{
        //
    //}

    /**
     * Update the specified resource in storage.
     */
    //public function update(Request $request, string $id)
    //{
        //
    //}

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        // Delete the appointment
        $appointment = Appointment::find($id);
        $appointment->delete();

        return redirect('appointments');
    }
}
