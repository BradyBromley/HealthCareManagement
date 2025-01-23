@extends('layouts.authLayout')

@section('title', 'Login')

@section('content')
    <!-- Login -->
    <div class='content'>
        <h2>Login</h2>
        <form method='POST' id='loginForm' action='{{ URL::to('auth/login') }}'>
            @csrf
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

            <button id='submit' type='submit' class='btn btn-success'>Submit</button>

            <p>Don't have an account? <a href='{{ URL::to('auth/register') }}'>Sign up now.</a></p>
        </form>
    </div>
@endsection