<?php
require_once '../config.php';
require_once '../controller/userController.php';
require_once '../controller/appointmentController.php';

// Redirect if user is not logged in
session_start();
if (!isset($_SESSION['loggedIn']) || !$_SESSION['loggedIn']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/view/auth/login.php');
}

// Redirect if user does not have access to this page
$userController = new UserController($mysqli);
if (!$userController->access('bookAppointment')) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/index.php');
}

// Book Appointment
$appointmentController = new AppointmentController($mysqli);
if ($_SERVER['REQUEST_METHOD'] == 'POST') {
    $result = $appointmentController->bookAppointment();
}
?>

<!DOCTYPE html>
<html>
    <head>
        <!-- Import css -->
        <link rel='stylesheet' href='https://cdn.jsdelivr.net/npm/bootstrap@5.3.2/dist/css/bootstrap.min.css' integrity='sha384-T3c6CoIi6uLrA9TneNEoa7RxnatzjcDSCmG1MXxSR1GAsXEV/Dwwykc2MPK8M2HN' crossorigin='anonymous'>
        <link rel='stylesheet' href='/css/style.css'>

        <!-- Import jquery -->
        <script src='https://code.jquery.com/jquery-3.7.1.min.js' integrity='sha256-/JqT3SQfawRcv/BIHPThkBvs0OEvtFFmqPF/lYI/Cxo=' crossorigin='anonymous'></script>
        
        <meta charset='utf-8'>
        <title>Book Appointment</title>
    </head>
    <body>
        <?php include_once($_SERVER['DOCUMENT_ROOT'] . '/src/view/header.php') ?>

        <!-- Book Appointment -->
        <div class='content'>
        <h2>Book Appointment</h2>
        <form id='bookAppointmentForm' class='needs-validation' action='<?php echo htmlspecialchars($_SERVER['REQUEST_URI']); ?>' method='post'>

        <?php
            // Physician List
            $physicians = $userController->listUsers('physician');
            if ($physicians) {
                $defaultPhysician = $physicians->fetch_row();
        ?>
                <div class='form-group formInput'>
                    <label for='physician'>Physician</label>
                    <select class='form-select' id='physician' name='physician'>
                        <option value='<?php echo $defaultPhysician[0]; ?>'><?php echo $defaultPhysician[1] . ' ' . $defaultPhysician[2]; ?></option>
                    <?php while ($physicianRow = $physicians->fetch_row()) { ?>
                        <option value='<?php echo $physicianRow[0]; ?>'><?php echo $physicianRow[1] . ' ' . $physicianRow[2]; ?></option>
                    <?php } ?>
                    </select>
                </div>

                <!-- Calendar input for selecting appointment date -->
                <div class='form-group formInput'>
                    <label for='appointmentDate'>Appointment date</label>
                    <input id='appointmentDate' name='appointmentDate' type='date' class='form-control' required/>
                </div>

                <!-- Dropdown input for selecting appointment time -->
                <div id='appointmentTimeHTML'>
                    <div class='form-group formInput'>
                        <label for='appointmentTime'>Appointment time</label>
                        <select class='form-select' id='appointmentTime' name='appointmentTime'>
                            <?php echo $appointmentController->getAvailableTimes(date('Y-m-d', strtotime('tomorrow')), $defaultPhysician[0]); ?>
                        </select>
                    </div>
                </div>

                <div class='form-group formTextArea'>
                    <label for='reason'>Reason for appointment</label>
                    <textarea id='reason' name='reason' rows='3' class='form-control' placeholder='Enter reason'></textarea>
                </div>

                <div id='submitHTML'>
                    <button id='submit' type='submit' class='btn btn-success'>Submit</button>
                </div>
        <?php } else { ?>
                <div class='banner alert alert-danger'>Oops! Something went wrong. Please try again later.</div>
        <?php } ?>

        </form>

        <?php if ($result) { ?>
            <div class='banner alert alert-success'>Updated Successfully!</div>
        <?php } ?>

        <script src='/js/bookAppointment.js'></script>
        </div>
    </body>
</html>

<?php
$mysqli->close();
?>