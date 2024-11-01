@extends('layouts.authLayout')

@section('title', 'Register')

@section('content')
    <!-- Register -->
    <div class='content'>
        <h2>Register</h2>
        <form method='POST' id='registerForm' action='{{ URL::to('auth/register') }}'>
            @csrf
            <div class='form-group formInput'>
                <label for='first_name'>First Name</label>
                <input id='first_name' name='first_name' type='text' class='form-control @error('first_name') is-invalid @enderror' placeholder='First Name' value='{{ old('first_name') }}'>
                @error ('first_name')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>
            
            <div class='form-group formInput'>
                <label for='last_name'>Last Name</label>
                <input id='last_name' name='last_name' type='text' class='form-control @error('last_name') is-invalid @enderror' placeholder='Last Name' value='{{ old('last_name') }}'>
                @error ('last_name')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>

            <div class='form-group formInput'>
                <label for='email'>Email</label>
                <input id='email' name='email' type='text' class='form-control @error('email') is-invalid @enderror' placeholder='Email' value='{{ old('email') }}'>
                @error ('email')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>

            <div class='form-group formInput'>
                <label for='password'>Password</label>
                <input id='password' name='password' type='password' class='form-control @error('password') is-invalid @enderror' placeholder='Password'>
                @error ('password')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>

            <div class='form-group formInput'>
                <label for='confirm_password'>Confirm Password</label>
                <input id='confirm_password' name='confirm_password' type='password' class='form-control @error('confirm_password') is-invalid @enderror' placeholder='Confirm Password'>
                @error ('confirm_password')
                    <div class='invalid-feedback'>{{ $message }}</div>
                @enderror
            </div>

            <button id='submit' type='submit' class='btn btn-success'>Register</button>

            <p>Already have an account? <a href='{{ URL::to('auth/login') }}'>Sign in here.</a></p>
        </form>
    </div>
@endsection