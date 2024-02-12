<?php
require_once '../../config.php';
require_once '../../controller/authController.php';

// Logout
session_start();
$authController = new AuthController($mysqli);
$authController->logout();

?>
