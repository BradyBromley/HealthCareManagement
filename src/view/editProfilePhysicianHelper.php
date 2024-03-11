<?php
require_once '../config.php';
require_once '../controller/appointmentController.php';

// If the physician already has a set availability, then use that as the default
$appointmentController = new AppointmentController($mysqli);
$physicianHours = $appointmentController->getAvailability($_POST['physicianID']);
$startTime = $physicianHours ? $physicianHours[0] : '00:00:00';
$endTime = $physicianHours ? $physicianHours[1] : '00:30:00';
?>

<div id='startTimeHTML' class='form-group formInput'>
    <label for='startTime'>Start Time</label>
    <select class='form-select' id='startTime' name='startTime'>
        <?php echo $appointmentController->getTimeList('00:00:00', '23:30:00', $startTime); ?>
    </select>
</div>

<div id='endTimeHTML' class='form-group formInput'>
    <label for='endTime'>End Time</label>
    <select class='form-select' id='endTime' name='endTime'>
        <?php echo $appointmentController->getTimeList('00:30:00', '24:00:00', $endTime); ?>
    </select>
</div>