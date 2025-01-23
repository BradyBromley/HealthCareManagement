<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
        <link rel='stylesheet' href={{ asset('css/style.css') }}>
        
        <!-- Import for modals -->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

        <!-- Import jquery -->
        <script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>

        <meta charset='utf-8'>

        <title>@yield('title')</title>
    </head>
    <body>
        <header>
            <div id='navigation'>
        
                <h1 class='websiteHeader'>Health Care Management</h1>
                <div class='navbar'>
                    <!-- Navbar links -->
                    <ul class='navbarLeft'>
                        <li class='navbarLink'><a href='{{ URL::to('/') }}'>Home</a></li>
                        @if (Auth::user()->hasPermissionTo('bookAppointment'))
                            <li class='navbarLink'><a href='{{ URL::to('appointments/create') }}'>Book Appointment</a></li>
                        @endif
                        @if (Auth::user()->hasPermissionTo('appointmentListing'))
                            <li class='navbarLink'><a href='{{ URL::to('appointments') }}'>Appointments</a></li>
                        @endif
                        @if (Auth::user()->hasPermissionTo('userListing'))
                            <li class='navbarLink'><a href='{{ URL::to('users') }}'>Users</a></li>
                        @endif
                    </ul>
        
                    <!-- User dropdown -->
                    <ul class='navbarRight'>
                        <li class='navbarLink dropdown'>
                            <button class='dropdownButton'>
                                {{ Auth::user()->full_name }}
                                <i class='fa fa-caret-down'></i>
                            </button>
                            <div class='dropdownContent'>
                                <a href='{{ URL::to('users/' . Auth::user()->id) }}'>Profile</a>
                                <a href='{{ URL::to('auth/logout') }}' onclick='event.preventDefault(); document.getElementById("logout-form").submit();'>Logout</a>
                            </div>

                            <form id="logout-form" action="{{ URL::to('auth/logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <main>

