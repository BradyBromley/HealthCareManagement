<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
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

    public function changeStatus($id, $status)
    {
        // Change the status of an appointment
        $appointment = Appointment::find($id);
        $appointment->status = /*$_REQUEST['status']*/$status;
        $appointment->save();

        return redirect('appointments');
    }

    /**
     * Show the form for creating a new resource.
     */
    //public function create()
    //{
        //
    //}

    /**
     * Store a newly created resource in storage.
     */
    //public function store(Request $request)
    //{
        //
    //}

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
