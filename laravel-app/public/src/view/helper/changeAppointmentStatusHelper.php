<?php
require_once '../../config.php';
require_once '../../controller/appointmentController.php';

session_start();
$appointmentController = new AppointmentController($mysqli);
$appointmentController->changeAppointmentStatus($_REQUEST['id'], $_REQUEST['status']);

header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/view/appointmentListing.php');

?>