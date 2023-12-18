<?php
require_once 'config.php';
require_once 'authController.php';

session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/login.php');
}
$auth = new authController($mysqli);

if (!$auth->access('admin')) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
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
        <!-- Import css -->
        <link rel='stylesheet' href='<?php $_SERVER['DOCUMENT_ROOT'] ?>/css/style.css'>

        <title>Admin Page</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/header.php') ?>
        <?php echo '<p>Hello Admin</p>'; ?>
        <form id='logoutForm' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
            <input id='logout' name='logout' type='submit' value='Logout'>
        </form>
    </body>
</html>

<?php
$mysqli->close();
?>