<?php
require_once 'config.php';
require_once 'controllers/authController.php';

// Logout
session_start();
$authController = new AuthController($mysqli);
$authController->logout();

?>
