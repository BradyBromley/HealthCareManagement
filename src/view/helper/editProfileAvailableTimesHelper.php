<?php
require_once '../../config.php';
require_once '../../controller/appointmentController.php';

// The end time dropdown should only show times after the start time
$appointmentController = new AppointmentController($mysqli);
$startTime = strtotime('+30 minutes', strtotime($_POST['startTime']));
$endTime = $_POST['endTime'];

$result = [];

$endTimeHTML = "
<label for='endTime'>End Time</label>
<select class='form-select' id='endTime' name='endTime'>
    " . $appointmentController->getTimeList(date('H:i:s', $startTime), $endTime) . "
</select>
";

$result['endTimeHTML'] = $endTimeHTML;

echo json_encode($result);
?>