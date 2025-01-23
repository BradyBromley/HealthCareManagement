@extends('layouts.layout')

@section('title', 'Appointments')

@section('content')
    <!-- Appointments -->
    <div class='content'>
        <h2>Appointments</h2>
        <table class='table table-striped table-bordered sortable appointment_listing'>
            <thead>
                <tr>
                    <!-- Patient ID and name show up for admins and physicians -->
                    @if (Auth::user()->hasPermissionTo('physicianAppointmentListing'))
                        <th>@sortablelink('patient_id', 'Patient ID')</th>
                        <th>@sortablelink('patient.full_name', 'Patient Name')</th>
                    @endif

                    <!-- Physician ID shows up for admins -->
                    @if (Auth::user()->hasPermissionTo('admin'))
                        <th>@sortablelink('physician_id', 'Physician ID')</th>
                    @endif

                    <!-- Physician name shows up for admins and patients -->
                    @if (Auth::user()->hasPermissionTo('patientAppointmentListing'))
                        <th>@sortablelink('physician.full_name', 'Physician Name')</th>
                    @endif
                    <th>@sortablelink('start_time', 'Start Time')</th>
                    <th>@sortablelink('end_time', 'End Time')</th>
                    <th>@sortablelink('reason', 'Reason')</th>
                    <th>@sortablelink('status', 'Status')</th>

                    <!-- Admins and physicians can change appointment status -->
                    @if (Auth::user()->hasPermissionTo('physicianAppointmentListing'))
                        <th>Change Status</th>
                    @endif

                    <th>Cancel Appointment</th>
                </tr>
            </thead>
            <tbody>
                @if ($appointments->count() == 0)
                    <tr>
                        @if (Auth::user()->hasPermissionTo('admin'))
                            <td colspan="10">No appointments to display.</td>
                        @elseif (Auth::user()->hasPermissionTo('physicianAppointmentListing'))
                            <td colspan="8">No appointments to display.</td>
                        @else
                            <td colspan="6">No appointments to display.</td>
                        @endif
                    </tr>
                @endif
                @foreach($appointments as $key => $value)
                    @if(Auth::user()->hasPermissionTo('admin') || (Auth::user()->id == $value->patient_id) || (Auth::user()->id == $value->physician_id))
                        <tr class='{{ $value->status }}'>
                            <!-- Patient ID and name show up for admins and physicians -->
                            @if (Auth::user()->hasPermissionTo('physicianAppointmentListing'))
                                <td>{{ $value->patient_id }}</td>
                                <td>{{ $value->patient->full_name }}</td>
                            @endif

                            <!-- Physician ID shows up for admins -->
                            @if (Auth::user()->hasPermissionTo('admin'))
                                <td>{{ $value->physician_id }}</td>
                            @endif

                            <!-- Physician name shows up for admins and patients -->
                            @if (Auth::user()->hasPermissionTo('patientAppointmentListing'))
                                <td>{{ $value->physician->full_name }}</td>
                            @endif

                            <td>{{ App\Common\Helpers::localDateTime($value->start_time)->format('M j Y, g:i A') }}</td>
                            <td>{{ App\Common\Helpers::localDateTime($value->end_time)->format('M j Y, g:i A') }}</td>
                            <td>{{ $value->reason }}</td>
                            <td>{{ $value->status }}</td>

                            <!-- Admins and physicians can change appointment status -->
                            @if (Auth::user()->hasPermissionTo('physicianAppointmentListing'))
                                <td><a type='button' class='btn btn-secondary' data-bs-toggle='modal' href='#change_status_modal' data-bs-id='{{ $value->id }}' data-status='{{ $value->status }}'><i class='fa-solid fa-pen-to-square'></i></a></td>
                            @endif

                            <!-- Appointments can be canceled if the time has not passed -->
                            @if (strtotime($value->start_time) > time())
                                <td><a type='button' class='btn btn-danger' data-bs-toggle='modal' href='#cancel_appointment_modal' data-bs-id='{{ $value->id }}'><i class='fa-solid fa-ban'></i></a></td>
                            @else
                                <td></td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        {{ $appointments->links('pagination::bootstrap-5') }}

        <!-- Change Status Modal -->
        <div class='modal fade' id='change_status_modal' tabindex='-1' aria-labelledby='change_status_modal_label' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='change_status_modal_label'>Change Status</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        <select class='form-select'  id='status' name='status'>
                            <option value='Scheduled'>Scheduled</option>
                            <option value='No-Show'>No-Show</option>
                            <option value='Finished'>Finished</option>
                        </select>
                    </div>
                    <div class='modal-footer'>
                        <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</a>
                        <a type='button' id='change_status_button' class='btn btn-success'>Change Status</a>
                    </div>
                </div>
            </div>
        </div>

        <!-- Cancel Appointment Modal -->
        <div class='modal fade' id='cancel_appointment_modal' tabindex='-1' aria-labelledby='cancel_appointment_modal_label' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='cancel_appointment_modal_label'>Cancel Appointment</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        Are you sure you want to cancel this appointment?
                    </div>
                    <div class='modal-footer'>
                        <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</a>
                        <form method='POST' id='cancel_appointment_form'>
                            @csrf
                            @method('DELETE')
                            <button id='submit' type='submit' class='btn btn-danger'>Cancel Appointment</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src='/js/appointments.js'></script>
    </div>
@endsection