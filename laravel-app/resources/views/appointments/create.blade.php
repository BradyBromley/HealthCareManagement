@extends('layouts.layout')

@section('title', 'Book Appointment')

@section('content')
    <!-- Book Appointment -->
    <div class='content'>
        <h2>Book Appointment</h2>

        <form method='POST' id='bookAppointmentForm' class='needs-validation' action='<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>' method='post'>
            @csrf

            <!-- Physician List -->
            <div class='form-group formInput'>
                <label for='physician_id'>Physician</label>
                <select class='form-select' id='physician_id' name='physician_id'>
                @foreach ($physicians as $physician_key => $physician)
                    <option value='{{ $physician->id }}'>{{ $physician->full_name }}</option>
                @endforeach
                </select>
            </div>

            <!-- Calendar input for selecting appointment date -->
            <div class='form-group formInput'>
                <label for='appointment_date'>Appointment date</label>
                <input id='appointment_date' name='appointment_date' type='date' class='form-control' required/>
            </div>

            <!-- Dropdown input for selecting appointment time -->
            <div id='appointment_time_select_list' class='form-group formInput'></div>

            <div class='form-group formTextArea'>
                <label for='reason'>Reason for appointment</label>
                <textarea id='reason' name='reason' rows='3' class='form-control' placeholder='Enter reason'></textarea>
            </div>

            <div id='submit_button'>
                <button id='submit' type='submit' class='btn btn-success'>Submit</button>
            </div>
        </form>

        <script src='/js/bookAppointment.js'></script>
    </div>
@endsection