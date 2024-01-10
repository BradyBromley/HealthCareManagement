<?php
require_once 'config.php';
require_once 'controllers/authController.php';

// Redirect if user is not logged in
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/login.php');
}

// Redirect if user is not an admin
$auth = new AuthController($mysqli);
if (!$auth->access('admin')) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

// Logout
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
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='/css/style.css'>

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