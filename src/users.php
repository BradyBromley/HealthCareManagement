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
                        <th></th>
                    </tr>
                </thead>
                <tbody>
        <?php
            $numCols = 5;
            while ($row = $result->fetch_row()) {
                echo '<tr>';
                for ($i = 0; $i < $numCols; $i++) {
                    echo '<td>' . $row[$i] . '</td>';
                }
                echo '<td><a href="/src/editUser.php?id=' . $row[0] . '">Edit</a></td>';
                echo '</tr>';

            }
        ?>
                </tbody>
            </table>
        <?php
        } else {
        ?>
            <div class='alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
        <?php
        }
        ?>
    </body>
</html>

<?php
$mysqli->close();
?>