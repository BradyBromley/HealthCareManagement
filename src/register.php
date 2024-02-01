<?php
require_once 'config.php';
require_once 'controllers/authController.php';

// Redirect if user is logged in
session_start();
if (isset($_SESSION['loggedIn']) && $_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

// Register
$authController = new AuthController($mysqli);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $register = $authController->register();
    if ($register) {
        header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/login.php');
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css-->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='/css/style.css'>

        <meta charset='utf-8'>
        <title>Sign Up - Health Care Management</title>
    </head>
    <body>
        <!-- Login -->
        <div class='content'>
            <h2>Sign Up</h2>
            <form id='signUpForm' class='needs-validation' action='<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>' method='post'>
                <div class='form-group formInput'>
                    <label for='firstName'>First Name</label>
                    <input id='firstName' name='firstName' type='text' class='form-control <?php echo (!empty($authController->firstNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['firstName']; ?>' placeholder='Enter first name'>
                    <div class="invalid-feedback"><?php echo $authController->firstNameError; ?></div>
                </div>
                
                <div class='form-group formInput'>
                    <label for='lastName'>Last Name</label>
                    <input id='lastName' name='lastName' type='text' class='form-control <?php echo (!empty($authController->lastNameError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['lastName']; ?>' placeholder='Enter last name'>
                    <div class="invalid-feedback"><?php echo $authController->lastNameError; ?></div>
                </div>

                <div class='form-group formInput'>
                    <label for='email'>Email</label>
                    <input id='email' name='email' type='email' class='form-control <?php echo (!empty($authController->emailError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['email']; ?>' placeholder='Enter email'>
                    <div class="invalid-feedback"><?php echo $authController->emailError; ?></div>
                </div>

                <div class='form-group formInput'>
                    <label for='password'>Password</label>
                    <input id='password' name='password' type='password' class='form-control <?php echo (!empty($authController->passwordError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['password']; ?>' placeholder='Enter password'>
                    <div class="invalid-feedback"><?php echo $authController->passwordError; ?></div>
                </div>

                <div class='form-group formInput'>
                    <label for='confirmPassword'>Confirm Password</label>
                    <input id='confirmPassword' name='confirmPassword' type='password' class='form-control <?php echo (!empty($authController->confirmPasswordError)) ? 'is-invalid' : ''; ?>' value='<?php echo $_POST['confirmPassword']; ?>' placeholder='Confirm password'>
                    <div class="invalid-feedback"><?php echo $authController->confirmPasswordError; ?></div>
                </div>

                <button id='submit' type='submit' class='btn btn-success'>Submit</button>

                <p>Already have an account? <a href='/src/login.php'>Sign in here.</a></p>
            </form>

            <?php if ($register === false) { ?>
                <div class="banner alert alert-danger">Oops! Something went wrong. Please try again later.</div>
            <?php } ?>
        </div>
    </body>
</html>

<?php
$mysqli->close();
?>