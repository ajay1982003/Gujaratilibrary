<?php
session_start();
require_once __DIR__ . '/app/controllers/AuthController.php';
require_once __DIR__ . '/app/helpers/SessionHelper.php';

// Logout the user
$authController = new AuthController();
$authController->logout();

// Redirect to login page
header('Location: login.php');
exit();
?>
