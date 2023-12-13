<?php
require_once 'src/config.php';
require_once 'src/authController.php';

session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location:  http://healthcaremanagement/src/login.php');
}
$auth = new authController($mysqli);

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['logout']) {
        $auth->logout();
    }
}
$mysqli->close();


?>

<!DOCTYPE html>
<html>
    <head>
        <title>PHP Test</title>
    </head>
    <body>
        <?php echo '<p>Hello World</p>'; ?>
        <?php echo '<p>Hello World 2</p>'; ?>
        <form id='logoutForm' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
            <input id='logout' name='logout' type='submit' value='Logout'>
        </form>
    </body>
</html>