<?php
require_once __DIR__ . '/../core/database.php';
require_once __DIR__ . '/../models/user.php';
require_once __DIR__ . '/../helpers/SessionHelper.php';

class AuthController
{
    private $db;
    private $userModel;

    public function __construct()
    {
        $this->db = (new Database())->connect();
        $this->userModel = new user();
    }

    /**
     * Register a new user
     * @param string $username
     * @param string $email
     * @param string $password
     * @return bool|string - Returns true on success, or error message on failure
     */
    public function register($username, $email, $password)
    {
        try {
            // Validate inputs
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
                return "Email already registered. Please use a different email.";
            }

            // Hash the password
            $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

            // Insert user into database
            $sql = "INSERT INTO users (name, email, password, created_at) 
                    VALUES (:username, :email, :password, :created_at)";
            
            $stmt = $this->db->prepare($sql);
            $stmt->bindValue(':username', $username, PDO::PARAM_STR);
            $stmt->bindValue(':email', $email, PDO::PARAM_STR);
            $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
            $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);

            if ($stmt->execute()) {
                return true; // Registration successful
            } else {
                return "Registration failed. Please try again.";
            }

        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Login a user
     * @param string $email
     * @param string $password
     * @return bool|string - Returns true on success, or error message on failure
     */
    public function login($email, $password)
    {
        try {
            if (empty($email) || empty($password)) {
                return "Email and password are required.";
            }

            // Get user by email
            $user = $this->userModel->getUserByEmail($email);
            
            if (!$user) {
                return "Invalid email or password.";
            }

            // Verify password
            if (password_verify($password, $user['password'])) {
                // Set session using SessionHelper
                SessionHelper::setUserSession($user['id'], $user['name'], $user['email']);
                
                return true;
            } else {
                return "Invalid email or password.";
            }

        } catch (Exception $e) {
            return "Error: " . $e->getMessage();
        }
    }

    /**
     * Logout user
     */
    public function logout()
    {
        SessionHelper::clearSession();
        return true;
    }
}
?>