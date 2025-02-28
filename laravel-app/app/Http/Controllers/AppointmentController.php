<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Models\User;
use App\Models\Role;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;
use View;
use Carbon\Carbon;

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
        // Check the values retrieved from the appointment form
        $request->validate([
            'physician_id' => 'required',
            'appointment_date' => 'required',
            'appointment_time' => 'required',
        ]);

        $date = $request->input('appointment_date');
        $time = $request->input('appointment_time');

        // Store the times in UTC
        $start_time = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time, Auth::user()->timezone);
        $start_time->setTimezone('UTC');
        $end_time = Carbon::createFromFormat('Y-m-d H:i:s', $date . ' ' . $time, Auth::user()->timezone);
        $end_time->setTimezone('UTC');
        $end_time->addMinutes(25);

        // Store
        $appointment = new Appointment;
        $appointment->patient_id = Auth::user()->id;
        $appointment->physician_id = $request->input('physician_id');
        $appointment->start_time = $start_time;
        $appointment->end_time = $end_time;
        $appointment->reason = $request->input('reason');
        $appointment->status = 'Scheduled';
        $appointment->save();

        // redirect
        return redirect('appointments/create')->with('success', 'Successfully created appointment!');
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

        $availabilities = DB::table('availabilities') // Join availabilities with users
                        ->join('availability_user', 'availabilities.id', '=', 'availability_user.availability_id')
                        ->join('users', 'availability_user.user_id', '=', 'users.id')
                        ->where('users.id', $physician->id) // Look for availability of the chosen physician
                        ->whereNotIn(DB::raw('DATE_FORMAT(CONVERT_TZ(availabilities.time, "UTC", "' . Auth::user()->timezone . '"), "' . $date . ' %H:%i:%s")'),
                        function($query) // Convert the available times and the booked appointments to the local timezone
                        {
                            $query->select(DB::raw('CONVERT_TZ(start_time, "UTC", "' . Auth::user()->timezone . '")'))
                            ->from('appointments'); // Times aren't available if appointments have already been booked on that day at those times
                        })
                        ->select('availabilities.time') // Get the resulting times
                        ->get();
        
        // Format the available appointments
        $appointment_options = '';
        foreach ($availabilities as $key => $availability)
        {
            $local_time = Carbon::createFromFormat('H:i:s', $availability->time, 'UTC');
            $local_time->setTimezone(Auth::user()->timezone);
            $appointment_options .= "<option value='" . $local_time->format('H:i:s') . "'>" . $local_time->format('h:i A') . "</option>";
        }

        $result = [];
        $result['appointment_options'] = $appointment_options;

        echo json_encode($result);
    }
}
