<?php
require_once '../config.php';
require_once '../controller/appointmentController.php';

// The end time dropdown should only show times after the start time
$appointmentController = new AppointmentController($mysqli);
$earliestTime = strtotime($_POST['startTime']);
$earliestTime = strtotime('+30 minutes', $earliestTime);
?>

<label for='endTime'>End Time</label>
<select class='form-select' id='endTime' name='endTime'>
    <?php echo $appointmentController->getTimeList(date('H:i:s', $earliestTime)); ?>
</select>