<!DOCTYPE html>
<html>
    <head>
        <title>Login</title>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    </head>
    <body>
        <div class='container'>

            <nav class='navbar navbar-inverse'>
                <div class='navbar-header'>
                    <a class='navbar-brand' href='{{ URL::to('users') }}'>user Alert</a>
                </div>
                <ul class='nav navbar-nav'>
                    <li><a href='{{ URL::to('users') }}'>View All users</a></li>
                    <li><a href='{{ URL::to('users/create') }}'>Create a user</a>
                </ul>
            </nav>

            <h1>Login</h1>
            <form method='POST' action='{{ route('login_form') }}'>
                @csrf
                <input type='email' name='email' placeholder='Email'>
                <input type='password' name='password' placeholder='Password'>
                <button type='submit'>Login</button>
            </form>
        </div>
    </body>
</html>