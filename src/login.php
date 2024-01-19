<?php
require_once 'config.php';
require_once 'controllers/authController.php';

// Redirect if user is logged in
session_start();
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

// Login
$authController = new AuthController($mysqli);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $authController->login();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='/css/style.css'>

        <meta charset='utf-8'>
        <title>Login - Health Care Management</title>
    </head>
    <body>
        <h1>Login</h1>
        <form id='loginForm' class='needs-validation' action='<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>' method='post'>
            <div class='form-group formInput'>
                <label for='email'>Email</label>
                <input id='email' name='email' type='email' class='form-control <?php echo (!empty($authController->emailError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['email']; ?>' placeholder='Enter email'>
                <div class='invalid-feedback'><?php echo $authController->emailError; ?></div>
            </div>

            <div class='form-group formInput'>
                <label for='password'>Password</label>
                <input id='password' name='password' type='password' class='form-control <?php echo (!empty($authController->passwordError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['password']; ?>' placeholder='Enter password'>
                <div class='invalid-feedback'><?php echo $authController->passwordError; ?></div>
            </div>

            <button id='submit' type='submit' class='btn btn-primary'>Submit</button>

            <p>Don't have an account? <a href='/src/register.php'>Sign up now.</a></p>
        </form>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
    </body>
</html>

<?php
$mysqli->close();
?>