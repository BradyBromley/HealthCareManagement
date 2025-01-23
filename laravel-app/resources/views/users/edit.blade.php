@extends('layouts.layout')

@section('title', 'Edit Profile')

@section('content')
<!-- Edit Profile -->
<div class='content'>
    <div id='user_id' value='{{ $user->id }}'></div>
    <h2>Edit Profile</h2>
    <form method='POST' id='editProfileForm' action='{{ URL::to('users/' . $user->id) }}'>
        @csrf
        @method('PUT')
        <div class='form-group formInput'>
            <label for='first_name'>First Name</label>
            <input id='first_name' name='first_name' type='text' class='form-control @error('first_name') is-invalid @enderror' value='{{ $user->first_name }}' placeholder='First Name'>
            @error ('first_name')
                <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>
        
        <div class='form-group formInput'>
            <label for='last_name'>Last Name</label>
            <input id='last_name' name='last_name' type='text' class='form-control @error('last_name') is-invalid @enderror' value='{{ $user->last_name }}' placeholder='Last Name'>
            @error ('last_name')
                <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        <div class='form-group formInput'>
            <label for='address'>Address</label>
            <input id='address' name='address' type='text' class='form-control' value='{{ $user->address }}' placeholder='Address'>
        </div>

        <div class='form-group formInput'>
            <label for='city'>City</label>
            <input id='city' name='city' type='text' class='form-control' value='{{ $user->city }}' placeholder='City'>
        </div>

        <div class='form-group formInput'>
            <label for='timezone'>Timezone</label>
            <select class='form-select' id='timezone' name='timezone'>
                @foreach (timezone_identifiers_list() as $timezone)
                    <option value='{{ $timezone }}' {{ $timezone == $user->timezone ? ' selected' : '' }}>{{ $timezone }}</option>
                @endforeach
            </select>
            @error ('timezone')
                <div class='invalid-feedback'>{{ $message }}</div>
            @enderror
        </div>

        @if (Auth::user()->hasPermissionTo('admin'))
            <div class='form-group formInput'>
                <label for='role_id'>Role</label>
                <select class='form-select' id='role_id' name='role_id'>
                @foreach ($roles as $role_key => $role)
                    @if ($role->id === $user->role_id)
                        <option value='{{ $role->id }}' selected>{{ $role->role_name }}</option>
                    @else
                        <option value='{{ $role->id }}'>{{ $role->role_name }}</option>
                    @endif
                @endforeach
                </select>
            </div>
        @else
            <div class='form-group formInput' hidden>
                <label for='role_id'>Role</label>
                <select class='form-select' id='role_id' name='role_id'>
                    <option value='{{ $user->role_id }}' selected>{{ $user->role->role_name }}</option>
                </select>
            </div>
        @endif

        <!-- Only show if the user being edited is a physician-->
        <div id='start_time_select_list' class='form-group formInput'></div>
        <div id='end_time_select_list' class='form-group formInput'></div>

        <button id='submit' type='submit' class='btn btn-success'>Submit</button>
    </form>

    <script src='/js/editProfile.js'></script>
</div>
@endsection