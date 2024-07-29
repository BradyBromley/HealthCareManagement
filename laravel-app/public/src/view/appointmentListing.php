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

        <!-- Import for modals -->
        <script src='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/js/bootstrap.bundle.min.js' integrity='sha384-C6RzsynM9kWDrMNeT87bh95OGNyZPhcTNXj1NW7RuBCsyN/o0jlpcV8Qyq46cDfL' crossorigin='anonymous'></script>

        <!-- Import js -->
        <script src='https://www.kryogenix.org/code/browser/sorttable/sorttable.js'></script>

        <!-- Import jquery -->
        <script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>

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
                <table class='table table-striped table-bordered sortable appointmentListing'>
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

                            <th>Start Time</th>
                            <th>End Time</th>
                            <th>Reason</th>
                            <th>Status</th>

                        <?php if (($role['roleName'] == 'admin') || ($role['roleName'] == 'physician')) { ?>
                            <th class='sorttable_nosort'>Change Status</th>
                        <?php } ?>
                            <th class='sorttable_nosort'>Cancel Appointment</th>
                        </tr>

                    </thead>
                    <tbody>
                    <?php foreach ($appointments as $appointment) { ?>
                        
                        <tr class='status<?php echo $appointment['status'] ?>'>
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

                            <td sorttable_customkey='<?php echo $appointment['startTimeTableKey'] ?>'><?php echo $appointment['startTime'] ?></td>
                            <td sorttable_customkey='<?php echo $appointment['endTimeTableKey'] ?>'><?php echo $appointment['endTime'] ?></td>
                            <td><?php echo $appointment['reason'] ?></td>
                            <td><?php echo $appointment['status'] ?></td>

                        <!-- Admins and physicians can change appointment status -->
                        <?php if (($role['roleName'] == 'admin') || ($role['roleName'] == 'physician')) { ?>
                            <td><a type='button' class='btn btn-secondary' data-bs-toggle='modal' href='#changeStatusModal' data-bs-id='<?php echo $appointment['ID']; ?>'><i class='fa-solid fa-pen-to-square'></i></a></td>
                        <?php } ?>

                        <?php if (strtotime($appointment['startTime']) > time()) { ?>
                            <td><a type='button' class='btn btn-danger' data-bs-toggle='modal' href='#cancelAppointmentModal' data-bs-id='<?php echo $appointment['ID']; ?>'><i class='fa-solid fa-ban'></i></a></td>
                        <?php } else {?>
                            <td></td>
                        <?php } ?>
                        </tr>

                    <?php } ?>
                    </tbody>
                </table>
            <?php } else { ?>
                <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
            <?php } ?>

            <!-- Complete Appointment Modal -->
            <div class='modal fade' id='changeStatusModal' tabindex='-1' aria-labelledby='changeStatusModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='changeStatusModalLabel'>Change Status</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            <select class='form-select'  id='status' name='status'>
                                <option value='Scheduled'>Scheduled</option>
                                <option value='No-Show'>No-Show</option>
                                <option value='Finished'>Finished</option>
                            </select>
                        </div>
                        <div class='modal-footer'>
                            <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</a>
                            <a type='button' id='changeStatusButton' class='btn btn-success'>Change Status</a>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Cancel Appointment Modal -->
            <div class='modal fade' id='cancelAppointmentModal' tabindex='-1' aria-labelledby='cancelAppointmentModalLabel' aria-hidden='true'>
                <div class='modal-dialog'>
                    <div class='modal-content'>
                        <div class='modal-header'>
                            <h1 class='modal-title fs-5' id='cancelAppointmentModalLabel'>Cancel Appointment</h1>
                            <button type='button' class='btn-close' data-bs-dismiss='modal' aria-label='Close'></button>
                        </div>
                        <div class='modal-body'>
                            Are you sure you want to cancel this appointment?
                        </div>
                        <div class='modal-footer'>
                            <a type='button' class='btn btn-secondary' data-bs-dismiss='modal'>Close</a>
                            <a type='button' id='cancelAppointmentButton' class='btn btn-danger'>Cancel Appointment</a>
                        </div>
                    </div>
                </div>
            </div>
            <script src='/js/appointmentListing.js'></script>

        </div>
    </body>
</html>

<?php
$mysqli->close();
?>