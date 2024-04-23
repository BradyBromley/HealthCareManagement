<?php
require_once '../../config.php';
require_once '../../controller/appointmentController.php';

// If the physician already has a set availability, then use that as the default
$appointmentController = new AppointmentController($mysqli);
if ($availability = $appointmentController->getAvailability($_POST['physicianID'])) {
    $firstStartTime = $availability[0];
    // The end time is 30 minutes after the last available time
    $endTime = strtotime($availability[array_key_last($availability)]);
    $endTime = date('H:i:s', strtotime('+30 minutes', $endTime));
} else {
    $firstStartTime = '00:00:00';
    $endTime = '00:30:00';
}

$result = [];

// Create the startTime select list
$startTimeHTML = "
<label for='startTime'>Start Time</label>
<select class='form-select' id='startTime' name='startTime'>
    " . $appointmentController->getTimeList('00:00:00', $firstStartTime) . "
</select>
";
$result['startTimeHTML'] = $startTimeHTML;

// Create the endTime select list
$secondStartTime = strtotime('+30 minutes', strtotime($firstStartTime));

$endTimeHTML = "
<label for='endTime'>End Time</label>
<select class='form-select' id='endTime' name='endTime'>
    " . $appointmentController->getTimeList(date('H:i:s', $secondStartTime), $endTime) . "
</select>
";
$result['endTimeHTML'] = $endTimeHTML;

echo json_encode($result);

?>