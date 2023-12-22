<?php
require_once 'config.php';
require_once 'controllers/authController.php';
require_once 'controllers/userController.php';

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

$userController = new UserController($mysqli);
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='<?php $_SERVER['DOCUMENT_ROOT'] ?>/css/style.css'>

        <title>Admin Page</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/header.php') ?>

        <!-- User Table -->
        <?php
        $result = $userController->listUsers();
        if ($result) {
        ?>
            <table class='table table-striped table-bordered'>
                <thead>
                    <tr>
                        <th>ID</th>
                        <th>First Name</th>
                        <th>Last Name</th>
                        <th>Email</th>
                        <th>Role</th>
                    </tr>
                </thead>
                <tbody>
        <?php
            while ($row = $result->fetch_row()) {
                echo '<tr><td>' . $row[0] . '</td><td>' . $row[1] . '</td><td>'
                . $row[2] . '</td><td>' . $row[3] . '</td><td>' . $row[4] . '</td></tr>';
            }
        ?>
                </tbody>
            </table>
        <?php
        } else {
            echo 'Oops! Something went wrong. Please try again later.';
        }
        ?>

        <form id='logoutForm' action='<?php echo htmlspecialchars($_SERVER['PHP_SELF']); ?>' method='post'>
            <input id='logout' name='logout' type='submit' value='Logout'>
        </form>
    </body>
</html>

<?php
$mysqli->close();
?>