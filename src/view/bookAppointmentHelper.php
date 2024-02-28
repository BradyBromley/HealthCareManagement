<?php
require_once '../config.php';
require_once '../controller/appointmentController.php';

$appointmentController = new AppointmentController($mysqli);
?>

<label for='appointmentTime'>Appointment time</label>
<select class='form-select' id='appointmentTime' name='appointmentTime'>
    <?php echo $appointmentController->getAvailableTimes($_POST['date'], $_POST['physicianID']); ?>
</select>