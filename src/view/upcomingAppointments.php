<?php
require_once '../config.php';
require_once '../controller/userController.php';
require_once '../controller/appointmentController.php';

// Redirect if user is not logged in
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/view/auth/login.php');
}

// Redirect if user is not an admin
$userController = new UserController($mysqli);
if (!$userController->access('patients')) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

$appointmentController = new AppointmentController($mysqli);
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
        <link rel='stylesheet' href='/css/style.css'>

        <meta charset='utf-8'>
        <title>Upcoming Appointments</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/view/header.php') ?>

        <!-- Upcoming Appointments-->
        <div class='content'>
            <h2>Upcoming Appointments</h2>
            <?php
            $result = $appointmentController->listAppointments($_SESSION['id']);
            if ($result) {
            ?>
                <table class='table table-striped table-bordered userTable'>
                    <thead>
                        <tr>
                            <th>ID</th>
                            <th>First Name</th>
                            <th>Last Name</th>
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php
                    $numCols = 6;
                    while ($row = $result->fetch_row()) {
                    ?>
                        <tr>
                        <?php for ($i = 0; $i < $numCols; $i++) { ?>
                            <td><?php echo $row[$i]?></td>
                        <?php } ?>
                        </tr>
                    <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
            <?php } ?>
        </div>
    </body>
</html>

<?php
$mysqli->close();
?>