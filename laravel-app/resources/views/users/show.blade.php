@extends('layouts.layout')

@section('title', 'Profile')

@section('content')
    <!-- Profile -->
    <div class='content'>
        <h2>Profile</h2>
        <div class='accountField'>
            <span class='accountFieldLabel'>First Name</span>
            <span class='accountFieldValue'>{{ $user->first_name }}</span>
        </div>
        
        <div class='accountField'>
            <span class='accountFieldLabel'>Last Name</span>
            <span class='accountFieldValue'>{{ $user->last_name }}</span>
        </div>

        <div class='accountField'>
            <span class='accountFieldLabel'>Address</span>
            <span class='accountFieldValue'>{{ $user->address }}</span>
        </div>

        <div class='accountField'>
            <span class='accountFieldLabel'>City</span>
            <span class='accountFieldValue'>{{ $user->city }}</span>
        </div>

        <div class='accountField'>
            <span class='accountFieldLabel'>Role</span>
            <span id='role' class='accountFieldValue'>{{ $user->role->role_name }}</span>
        </div>

        <!-- Only show if the user being viewed is a physician-->
        @if ($user->role->role_name == 'physician')
            <div id='availabilityHTML'>
                <div class='accountField'>
                    <span class='accountFieldLabel'>Start Time</span>
                    <span class='accountFieldValue'>{{ date('h:i A', strtotime($user->startTime())) }}</span>
                </div>
                <div class='accountField'>
                    <span class='accountFieldLabel'>End Time</span>
                    <span class='accountFieldValue'>{{ date('h:i A', strtotime($user->endTime())) }}</span>
                </div>
            </div>
        @endif
        <a class='btn btn-secondary' href='{{ URL::to('users/' . $user->id . '/edit') }}'>Edit</a>
    </div>
@endsection