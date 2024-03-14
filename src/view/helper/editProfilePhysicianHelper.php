<?php
require_once '../../config.php';
require_once '../../controller/appointmentController.php';

// If the physician already has a set availability, then use that as the default
$appointmentController = new AppointmentController($mysqli);
$physicianHours = $appointmentController->getAvailability($_POST['physicianID']);
$startTime = $physicianHours ? $physicianHours[0] : '00:00:00';
$endTime = $physicianHours ? $physicianHours[1] : '00:30:00';

$result = [];

// Create the startTime select list
$startTimeHTML = "
<label for='startTime'>Start Time</label>
<select class='form-select' id='startTime' name='startTime'>
    " . $appointmentController->getTimeList('00:00:00', '23:30:00', $startTime) . "
</select>
";
$result['startTimeHTML'] = $startTimeHTML;

// Create the endTime select list
$earliestTime = strtotime($startTime);
$earliestTime = strtotime('+30 minutes', $earliestTime);

$endTimeHTML = "
<label for='endTime'>End Time</label>
<select class='form-select' id='endTime' name='endTime'>
    " . $appointmentController->getTimeList(date('H:i:s', $earliestTime), '24:00:00', $endTime) . "
</select>
";
$result['endTimeHTML'] = $endTimeHTML;

echo json_encode($result);

?>