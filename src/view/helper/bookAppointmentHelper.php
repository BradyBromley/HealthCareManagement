<?php
require_once '../../config.php';
require_once '../../controller/appointmentController.php';

// Update the appointment time based on the date and physician chosen
$appointmentController = new AppointmentController($mysqli);
$output = $appointmentController->getAvailableTimes($_POST['date'], $_POST['physicianID']);

$result = [];

if ($output) {
    $appointmentTimeHTML = "
        <div class='form-group formInput'>
            <label for='appointmentTime'>Appointment time</label>
            <select class='form-select' id='appointmentTime' name='appointmentTime'>
                " . $output . "
            </select>
        </div>
    ";

    $result['appointmentTimeHTML'] = $appointmentTimeHTML;
} else {
    $result['appointmentTimeHTML'] = '';
}
echo json_encode($result);
?>