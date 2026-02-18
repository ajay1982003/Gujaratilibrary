<?php
require_once __DIR__ . '/app/controllers/UserController.php';

$userController = new UserController();

if (isset($_GET['user_id'])) {
    $user_id = $_GET['user_id'];

    if ($result = $userController->deleteUser($user_id)) {
        header('Location: users.php');
    }
    else {
        echo "<script>alert('Failed to delete user');</script>";
    }
}

?>