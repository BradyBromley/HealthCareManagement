<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
        <link rel='stylesheet' href={{ asset('css/style.css') }}>
        

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
                        <li class='navbarLink'><a href='/index.php'>Home</a></li>
                        <li class='navbarLink'><a href='/src/view/bookAppointment.php'>Book Appointment</a></li>
                        <li class='navbarLink'><a href='/src/view/appointmentListing.php'>Appointments</a></li>
                        <li class='navbarLink'><a href='/src/view/userListing.php'>Patients</a></li>
                        <li class='navbarLink'><a href='/src/view/userListing.php'>Users</a></li>
                    </ul>
        
                    <!-- User dropdown -->
                    <ul class='navbarRight'>
                        <li class='navbarLink dropdown'>
                            <button class='dropdownButton'>
                                {{ Auth::user()->full_name }}
                                <i class='fa fa-caret-down'></i>
                            </button>
                            <div class='dropdownContent'>
                                <a href='/src/view/profile.php'>Profile</a>
                                <a href='{{ route('logout') }}' onclick='event.preventDefault(); document.getElementById("logout-form").submit();'>Logout</a>
                            </div>

                            <form id="logout-form" action="{{ route('logout') }}" method="POST" style="display: none;">
                                {{ csrf_field() }}
                            </form>
                        </li>
                    </ul>
                </div>
            </div>
        </header>
        <main>

