<?php
require_once '../../config.php';
require_once '../../controller/appointmentController.php';

// If the physician already has a set availability, then use that as the default
$appointmentController = new AppointmentController($mysqli);
if ($availability = $appointmentController->getAvailability($_POST['physicianID'])) {
    $startTime = $availability[0];
    // The end time is 30 minutes after the last available time
    $endTime = strtotime($availability[array_key_last($availability)]);
    $endTime = date('H:i:s', strtotime('+30 minutes', $endTime));
} else {
    $startTime = '00:00:00';
    $endTime = '00:30:00';
}

$result = [];

// Create the Start Time and End Time fields
$availabilityHTML = "
<div class='accountField'>
    <span class='accountFieldLabel'>Start Time</span>
    <span class='accountFieldValue'>" . date('h:i A', strtotime($startTime)) . "</span>
</div>
<div class='accountField'>
    <span class='accountFieldLabel'>End Time</span>
    <span class='accountFieldValue'>" . date('h:i A', strtotime($endTime)) . "</span>
</div>
";
$result['availabilityHTML'] = $availabilityHTML;

echo json_encode($result);

?>