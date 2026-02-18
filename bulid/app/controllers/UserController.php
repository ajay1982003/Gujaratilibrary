<?php

require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../models/user.php';

class UserController
{
    private $db;
    private $userModel;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        $this->userModel = new user();
    }

    public function getAllUsers()
    {
        return $this->userModel->getAllUsers();
    }

    public function createUser($data)
    {
        $username = trim($data['username']);
        $email = trim($data['email']);
        $password = $data['password'];

        // Basic validation
        if (empty($username) || empty($email) || empty($password)) {
            return "All fields are required.";
        }

        if (strlen($username) < 3) {
            return "Username must be at least 3 characters long.";
        }

        if (strlen($password) < 6) {
            return "Password must be at least 6 characters long.";
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            return "Invalid email format.";
        }

        // Check if email already exists
        $existingUser = $this->userModel->getUserByEmail($email);
        if ($existingUser) {
            return "Email already registered.";
        }

        // Register user using the model
        if ($this->userModel->register($username, $email, $password)) {
            return true;
        }
        else {
            return "Failed to create user.";
        }
    }


    public function deleteUser($id)
    {
        if ($this->userModel->deleteUser($id)) {
            return ['success' => true, 'message' => 'User deleted successfully'];
        }
        else {
            return ['success' => false, 'message' => 'Failed to delete user'];
        }
    }
}


?>