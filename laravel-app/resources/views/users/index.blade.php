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

        <h1>Users</h1>

        <!-- will be used to show any messages -->
        @if (Session::has('message'))
            <div class='alert alert-info'>{{ Session::get('message') }}</div>
        @endif

        <table class='table table-striped table-bordered'>
            <thead>
                <tr>
                    <td>ID</td>
                    <td>First Name</td>
                    <td>Last Name</td>
                    <td>Email</td>
                    <td>Role</td>
                    <td>View</td>
                    <td>Deactivate</td>
                </tr>
            </thead>
            <tbody>
            @foreach($users as $key => $value)
                <tr>
                    <td>{{ $value->id }}</td>
                    <td>{{ $value->first_name }}</td>
                    <td>{{ $value->last_name }}</td>
                    <td>{{ $value->email }}</td>
                    <td>{{ $value->role->role_name }}</td>

                    <!-- we will also add show, edit, and delete buttons -->
                    <td>
                        <!-- show the user (uses the show method found at GET /users/{id} -->
                        <a class='btn btn-small btn-success' href='{{ URL::to('users/' . $value->id) }}'>Show this user</a>
                    </td>
                    <td>
                        <!-- delete the user (uses the destroy method DESTROY /users/{id} -->
                        <!-- we will add this later since its a little more complicated than the other two buttons -->
                        <!-- edit this user (uses the edit method found at GET /users/{id}/edit -->
                        <a class='btn btn-small btn-info' href='{{ URL::to('users/' . $value->id . '/edit') }}'>Edit this user</a>
                    </td>
                </tr>
            @endforeach
            </tbody>
        </table>

    </div>
@endsection