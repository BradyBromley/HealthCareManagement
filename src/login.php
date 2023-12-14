<?php
require_once 'config.php';
require_once 'authController.php';

session_start();
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    header('location:  http://healthcaremanagement/index.php');
}

$auth = new authController($mysqli);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth->login();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <meta charset='utf-8'>
        <title>Login - Health Care Management</title>
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
    </head>
    <body>
        <h1>Login</h1>
        <form id='loginForm' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
            <div class='form-group'>
                <label for='email'>Email</label>
                <input id='email' name='email' type='email' class='form-control <?php echo (!empty($auth->emailError)) ? 'is-invalid' : ''; ?>' value='<?php echo $auth->email; ?>' placeholder='Enter email' required>
            </div>

            <div class='form-group'>
                <label for='password'>Password</label>
                <input id='password' name='password' type='password' class='form-control <?php echo (!empty($auth->passwordError)) ? 'is-invalid' : ''; ?>' placeholder='Enter password' required>
            </div>

            <button id='submit' type='submit' class='btn btn-primary'>Submit</button>

            <p>Don't have an account? <a href='http://healthcaremanagement/src/register.php'>Sign up now.</a></p>
        </form>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
    </body>
</html>

<?php
$mysqli->close();
?>