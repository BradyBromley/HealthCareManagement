@extends('layouts.layout')

@section('title', 'Users')

@section('content')
    <div class='container'>

        <nav class='navbar2 navbar-inverse'>
            <div class='navbar-header'>
                <a class='navbar-brand' href='{{ URL::to('users') }}'>user Alert</a>
            </div>
            <ul class='nav navbar-nav'>
                <li><a href='{{ URL::to('users') }}'>View All users</a></li>
                <li><a href='{{ URL::to('users/create') }}'>Create a user</a>
            </ul>
        </nav>

        <h1>Showing {{ $user->first_name }}</h1>

        <div class='jumbotron text-center'>
            <h2>{{ $user->first_name }}</h2>
            <p>
                <strong>Email:</strong> {{ $user->email }}<br>
                <strong>Last Name:</strong> {{ $user->last_name }}
            </p>
        </div>

    </div>
@endsection