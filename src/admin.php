<?php
require_once 'config.php';
require_once 'authController.php';

session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location:  http://healthcaremanagement/src/login.php');
}
$auth = new authController($mysqli);

if (!$auth->access('admin')) {
    header('location: http://healthcaremanagement/index.php');
}

if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    if ($_POST['logout']) {
        $auth->logout();
    }
}
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Admin Page</title>
    </head>
    <body>
        <?php echo '<p>Hello Admin</p>'; ?>
        <form id='logoutForm' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
            <input id='logout' name='logout' type='submit' value='Logout'>
        </form>
    </body>
</html>

<?php
$mysqli->close();
?>