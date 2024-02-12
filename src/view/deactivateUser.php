<?php
require_once '../config.php';
require_once '../controller/userController.php';

// Logout
session_start();
$userController = new UserController($mysqli);
$userController->deactivateUser($_REQUEST['id']);

if ($_REQUEST['id'] == $_SESSION['id']) {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/view/auth/logout.php');
} else {
    header('location: http://' . $_SERVER['HTTP_HOST'] . '/src/view/admin/users.php');
}

?>