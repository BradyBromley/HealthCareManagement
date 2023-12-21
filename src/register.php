<?php
require_once 'config.php';
require_once 'authController.php';

session_start();
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

$auth = new authController($mysqli);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $auth->register();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css-->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='<?php $_SERVER['DOCUMENT_ROOT'] ?>/css/style.css'>

        <meta charset='utf-8'>
        <title>Sign Up - Health Care Management</title>
    </head>
    <body>
        <h1>Sign Up</h1>
        <form id='signUpForm' class='needs-validation' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
            <div class='form-group formInput'>
                <label for='firstName'>First Name</label>
                <input id='firstName' name='firstName' type='text' class='form-control <?php echo (!empty($auth->firstNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['firstName']; ?>' placeholder='Enter first name'>
                <div class="invalid-feedback"><?php echo $auth->firstNameError; ?></div>
            </div>
            
            <div class='form-group formInput'>
                <label for='lastName'>Last Name</label>
                <input id='lastName' name='lastName' type='text' class='form-control <?php echo (!empty($auth->lastNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['lastName']; ?>' placeholder='Enter last name'>
                <div class="invalid-feedback"><?php echo $auth->lastNameError; ?></div>
            </div>

            <div class='form-group formInput'>
                <label for='email'>Email</label>
                <input id='email' name='email' type='email' class='form-control <?php echo (!empty($auth->emailError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['email']; ?>' placeholder='Enter email'>
                <div class="invalid-feedback"><?php echo $auth->emailError; ?></div>
            </div>

            <div class='form-group formInput'>
                <label for='password'>Password</label>
                <input id='password' name='password' type='password' class='form-control <?php echo (!empty($auth->passwordError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['password']; ?>' placeholder='Enter password'>
                <div class="invalid-feedback"><?php echo $auth->passwordError; ?></div>
            </div>

            <div class='form-group formInput'>
                <label for='confirmPassword'>Confirm Password</label>
                <input id='confirmPassword' name='confirmPassword' type='password' class='form-control <?php echo (!empty($auth->confirmPasswordError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['confirmPassword']; ?>' placeholder='Confirm password'>
                <div class="invalid-feedback"><?php echo $auth->confirmPasswordError; ?></div>
            </div>

            <button id='submit' type='submit' class='btn btn-primary'>Submit</button>

            <p>Already have an account? <a href='<?php $_SERVER['DOCUMENT_ROOT'] ?>/src/login.php'>Sign in here.</a></p>
        </form>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
    </body>
</html>

<?php
$mysqli->close();
?>