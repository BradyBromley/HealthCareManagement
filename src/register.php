<?php
require_once 'config.php';
require_once 'authController.php';

$auth = new authController($mysqli);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth->register();

}
$mysqli->close();

?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Sign Up</title>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    </head>
    <body>
        <h1>Sign Up</h1>
        <form id='signUpForm' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
            <div class='form-group'>
                <label for='firstName'>First Name</label>
                <input id='firstName' name='firstName' type='text' class='form-control <?php echo (!empty($auth->firstNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $auth->firstName; ?>' placeholder='Enter first name' required>
            </div>
            
            <div class='form-group'>
                <label for='lastName'>Last Name</label>
                <input id='lastName' name='lastName' type='text' class='form-control <?php echo (!empty($auth->lastNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $auth->lastName; ?>' placeholder='Enter last name' required>
            </div>

            <div class='form-group'>
                <label for='email'>Email</label>
                <input id='email' name='email' type='email' class='form-control <?php echo (!empty($auth->emailError)) ? 'is-invalid' : ''; ?>' value='<?php echo $auth->email; ?>' placeholder='Enter email' required>
            </div>

            <div class='form-group'>
                <label for='password'>Password</label>
                <input id='password' name='password' type='password' class='form-control <?php echo (!empty($auth->passwordError)) ? 'is-invalid' : ''; ?>' value='<?php echo $auth->password; ?>' placeholder='Enter password' required>
            </div>

            <div class='form-group'>
                <label for='confirmPassword'>Confirm Password</label>
                <input id='confirmPassword' name='confirmPassword' type='password' class='form-control <?php echo (!empty($auth->confirmPasswordError)) ? 'is-invalid' : ''; ?>' value='<?php echo $auth->confirmPassword; ?>' placeholder='Confirm password' required>
            </div>

            <button id='Submit' type='submit' class='btn btn-primary'>Submit</button>
        </form>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
    </body>
</html>