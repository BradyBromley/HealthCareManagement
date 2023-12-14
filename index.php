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
?>

<!DOCTYPE html>
<html>
    <head>
        <title>Test Page</title>
    </head>
    <body>
        <?php echo '<p>Hello World</p>'; ?>
        <form id='logoutForm' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
            <input id='logout' name='logout' type='submit' value='Logout'>

            <?php if ($auth->access('admin')) { ?>
                <a href='http://healthcaremanagement/src/admin.php'>Admin Page</a>
            <?php } ?>

        </form>
    </body>
</html>

<?php
$mysqli->close();
?>