<?php
require_once 'config.php';
require_once 'controllers/userController.php';

// Redirect if user is not logged in
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/login.php');
}

// Redirect if user is not an admin
$userController = new UserController($mysqli);
if (!$userController->access('admin')) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='/css/style.css'>

        <meta charset='utf-8'>
        <title>Admin</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/header.php') ?>

        <!-- Admin -->
        <div class='content'>
            <h2>Admin</h2>
            <?php echo '<p>Hello Admin</p>'; ?>
        </div>
    </body>
</html>

<?php
$mysqli->close();
?>