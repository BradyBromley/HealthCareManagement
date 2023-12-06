<?php
require_once 'config.php';


$email = $password = '';
$emailError = $passwordError = '';

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    
    // Validate email
    if (empty(trim($_POST['email']))) {
        $emailError = 'Please enter an email.';
    } else if (!filter_var(trim($_POST['email']), FILTER_VALIDATE_EMAIL)) {
        $emailError = 'Invalid email format.';
    } else {
        // Check if the email has already been used
        $sql = 'SELECT ID FROM Users WHERE Email = ?';
        $stmt = $mysqli->prepare($sql);
        $stmt->bind_param('s', trim($_POST['email']));
        if ($stmt->execute()) {
            $stmt->store_result();
            if ($stmt->num_rows == 1) {
                $emailError = 'This email is already in use.';
            } else {
                $email = trim($_POST['email']);
            }
        }

        $stmt->close();
    }
    // Validate password
    if (empty(trim($_POST['password']))) {
        $passwordError = 'Please enter a password.';
    } else if (strlen(trim($_POST['password'])) < 8) {
        $passwordError = 'Password must have at least 8 characters.';
    } else {
        $password = trim($_POST['password']);
    }
    

    // Insert into database
    if (empty($emailError) && empty($passwordError)) {
        
        $sql = 'INSERT INTO Users (Email, PasswordHash, Salt, FirstName, LastName) VALUES (?, ?, ?, ?, ?)';
        $stmt = $mysqli->prepare($sql);
        
        $salt = 'Salt Test';
        $first = 'First Test';
        $last = 'Last Test';
        $stmt->bind_param('sssss', $email, $password, $salt, $first, $last);
        if ($stmt->execute()) {
            header('location: login.php');
        } else {
            echo 'SOMETHING WENT WRONG';
            echo $mysqli->error;
        }

        $stmt->close();
    }

    echo "\n" . $emailError;
    echo "\n" . $passwordError;

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
                <label for='email'>Email</label>
                <input id='email1' name='email' type='email' class='form-control <?php echo (!empty($emailError)) ? 'is-invalid' : ''; ?>' value='<?php echo $email; ?>' placeholder='Enter email' required>
            </div>

            <div class='form-group'>
                <label for='password'>Password</label>
                <input id='password1' name='password' type='password' class='form-control' placeholder='Enter password' required>
            </div>

            <div class='form-group'>
                <label for='confirmPassword'>Confirm Password</label>
                <input id='confirmPassword1' name='confirmPassword' type='password' class='form-control' placeholder='Confirm password' required>
            </div>

            <button id='Submit' type='submit' class='btn btn-primary'>Submit</button>
        </form>
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>
    </body>
</html>