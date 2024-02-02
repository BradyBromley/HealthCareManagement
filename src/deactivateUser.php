<?php
require_once 'config.php';
require_once 'controllers/userController.php';

// Logout
session_start();
$userController = new UserController($mysqli);
$userController->deactivateUser($_REQUEST['id']);

header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/users.php');


?>