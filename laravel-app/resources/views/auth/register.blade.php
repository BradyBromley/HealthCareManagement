<form method='POST' action='{{ route('register_form') }}'>
    @csrf
    <input type='text' name='first_name' placeholder='First Name'>
    <input type='text' name='last_name' placeholder='Last Name'>
    <input type='email' name='email' placeholder='Email'>
    <input type='password' name='password' placeholder='Password'>
    <button type='submit'>Register</button>
</form>