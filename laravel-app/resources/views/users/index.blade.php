@extends('layouts.layout')

@section('title', 'Users')

@section('content')
    <!-- Users -->
    <div class='content'>
        <h2>Users</h2>
        <table class='table table-striped table-bordered sortable userListing'>
            <thead>
                <tr>
                    <th>@sortablelink('id', 'ID')</th>
                    <th>@sortablelink('first_name', 'First Name')</th>
                    <th>@sortablelink('last_name', 'Last Name')</th>
                    <th>@sortablelink('email', 'Email')</th>
                    @if (Auth::user()->hasPermissionTo('admin'))
                        <th>@sortablelink('role.role_name', 'Role')</th>
                    @endif
                    <th>View</th>
                    @if (Auth::user()->hasPermissionTo('admin'))
                        <th>Deactivate</th>
                    @endif
                </tr>
            </thead>
            <tbody>
                @if ($users->count() == 0)
                    <tr>
                        @if (Auth::user()->hasPermissionTo('admin'))
                            <td colspan="7">No users to display.</td>
                        @else
                            <td colspan="5">No users to display.</td>
                        @endif
                    </tr>
                @endif
                @foreach($users as $key => $value)
                    @if(Auth::user()->hasPermissionTo('admin') || ($value->role->role_name == 'patient'))
                        <tr>
                            <td>{{ $value->id }}</td>
                            <td>{{ $value->first_name }}</td>
                            <td>{{ $value->last_name }}</td>
                            <td>{{ $value->email }}</td>
                            @if (Auth::user()->hasPermissionTo('admin'))
                                <td>{{ $value->role->role_name }}</td>
                            @endif
                            <td><a type='button' class='btn btn-secondary' href='{{ URL::to('users/' . $value->id) }}'><i class='fa-solid fa-newspaper'></i></a></td>
                            @if (Auth::user()->hasPermissionTo('admin'))
                                <td><a type='button' class='btn btn-danger' data-bs-toggle='modal' href='#deactivateUserModal' data-bs-id='{{ $value->id }}'><i class='fa-solid fa-ban'></i></a></td>
                            @endif
                        </tr>
                    @endif
                @endforeach
            </tbody>
        </table>

        {{ $users->links('pagination::bootstrap-5') }}        

        <!-- Deactivate User Modal -->
        <div class='modal fade' id='deactivateUserModal' tabindex='-1' aria-labelledby='deactivateUserModalLabel' aria-hidden='true'>
            <div class='modal-dialog'>
                <div class='modal-content'>
                    <div class='modal-header'>
                        <h1 class='modal-title fs-5' id='deactivateUserModalLabel'>Deactivate User</h1>
                        <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                    </div>
                    <div class='modal-body'>
                        Are you sure you want to deactivate this user?
                    </div>
                    <div class='modal-footer'>
                        <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</a>
                        <form method='POST' id='deactivateUserForm'>
                            @csrf
                            @method('DELETE')
                            <button id='submit' type='submit' class='btn btn-danger'>Deactivate User</button>
                        </form>
                    </div>
                </div>
            </div>
        </div>
        <script src='/js/users.js'></script>
    </div>
@endsection