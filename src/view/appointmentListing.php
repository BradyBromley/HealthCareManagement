<?php
require_once '../config.php';
require_once '../controller/userController.php';
require_once '../controller/roleController.php';
require_once '../controller/appointmentController.php';

// Redirect if user is not logged in
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/view/auth/login.php');
}

// Redirect if user does not have access
$userController = new UserController($mysqli);
if (!$userController->access('appointmentListing')) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

$roleController = new RoleController($mysqli);
$appointmentController = new AppointmentController($mysqli);
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.1/css/all.min.css'>
        <link rel='stylesheet' href='/css/style.css'>

        <!-- Import js -->
        <script src='https://www.kryogenix.org/code/browser/sorttable/sorttable.js'></script>

        <meta charset='utf-8'>
        <title>Appointments</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/view/header.php') ?>

        <!-- Appointments -->
        <div class='content'>
            <h2>Appointments</h2>
            <?php
            // List appointments for all physicians if user is admin
            if (($user = $userController->getUser($_SESSION['id'])) && 
                ($role = $roleController->getRole($user['roleID'])) && 
                ($appointments = $appointmentController->listAppointments($_SESSION['id'], $role['roleName']))) {
            ?>
                <table class='table table-striped table-bordered sortable userTable'>
                    <thead>
                        <tr>
                        <!-- Patient ID and name show up for admins and physicians -->
                        <?php if (($role['roleName'] == 'admin') || ($role['roleName'] == 'physician')) { ?>
                            <th>Patient ID</th>
                            <th>Patient Name</th>
                        <?php } ?>

                        <!-- Physician ID shows up for admins -->
                        <?php if ($role['roleName'] == 'admin') { ?>
                            <th>Physician ID</th>
                        <?php } ?>

                        <!-- Physician name shows up for admins and patients -->
                        <?php if (($role['roleName'] == 'admin') || ($role['roleName'] == 'patient')) { ?>
                            <th>Physician Name</th>
                        <?php } ?>

                        <!-- The remaining values always show -->
                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Reason</th>
                        </tr>
                    </thead>
                    <tbody>
                    <?php foreach ($appointments as $appointment) { ?>
                        <tr>
                        <!-- Patient ID and name show up for admins and physicians -->
                        <?php if (($role['roleName'] == 'admin') || ($role['roleName'] == 'physician')) { ?>
                            <td><?php echo $appointment['patientID'] ?></td>
                            <td><?php echo $appointment['patientFirstName'] . ' ' . $appointment['patientLastName'] ?></td>
                        <?php } ?>

                        <!-- Physician ID shows up for admins -->
                        <?php if ($role['roleName'] == 'admin') { ?>
                            <td><?php echo $appointment['physicianID'] ?></td>
                        <?php } ?>

                        <!-- Physician name shows up for admins and patients -->
                        <?php if (($role['roleName'] == 'admin') || ($role['roleName'] == 'patient')) { ?>
                            <td><?php echo $appointment['physicianFirstName'] . ' ' . $appointment['physicianLastName'] ?></td>
                        <?php } ?>

                        <!-- The remaining values always show -->
                            <td sorttable_customkey='<?php echo $appointment['startTimeTableKey'] ?>'><?php echo $appointment['startTime'] ?></td>
                            <td sorttable_customkey='<?php echo $appointment['endTimeTableKey'] ?>'><?php echo $appointment['endTime'] ?></td>
                            <td><?php echo $appointment['reason'] ?></td>
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