<?php

class SessionHelper
{
    /**
     * Start session if not already started
     */
    public static function startSession()
    {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
    }

    /**
     * Check if user is logged in
     * @return bool
     */
    public static function isLoggedIn()
    {
        self::startSession();
        return isset($_SESSION['user_id']) && !empty($_SESSION['user_id']);
    }

    /**
     * Get current user ID
     * @return int|null
     */
    public static function getUserId()
    {
        self::startSession();
        return $_SESSION['user_id'] ?? null;
    }

    /**
     * Get current username
     * @return string|null
     */
    public static function getUsername()
    {
        self::startSession();
        return $_SESSION['username'] ?? null;
    }

    /**
     * Get current user email
     * @return string|null
     */
    public static function getUserEmail()
    {
        self::startSession();
        return $_SESSION['email'] ?? null;
    }

    /**
     * Set user session data
     * @param int $userId
     * @param string $username
     * @param string $email
     */
    public static function setUserSession($userId, $username, $email)
    {
        self::startSession();
        $_SESSION['user_id'] = $userId;
        $_SESSION['username'] = $username;
        $_SESSION['email'] = $email;
        $_SESSION['login_time'] = time();
    }

    /**
     * Clear user session
     */
    public static function clearSession()
    {
        self::startSession();
        $_SESSION = [];
        session_destroy();
    }

    /**
     * Redirect to login if not logged in
     * @param string $redirectUrl - Where to redirect after login
     */
    public static function requireLogin($redirectUrl = null)
    {
        if (!self::isLoggedIn()) {
            $_SESSION['redirect_after_login'] = $redirectUrl ?? $_SERVER['REQUEST_URI'];
            header('Location: login.php');
            exit();
        }
    }

    /**
     * Set error message in session
     * @param string $message
     */
    public static function setError($message)
    {
        self::startSession();
        $_SESSION['error'] = $message;
    }

    /**
     * Get and clear error message
     * @return string|null
     */
    public static function getError()
    {
        self::startSession();
        $error = $_SESSION['error'] ?? null;
        unset($_SESSION['error']);
        return $error;
    }

    /**
     * Set success message in session
     * @param string $message
     */
    public static function setSuccess($message)
    {
        self::startSession();
        $_SESSION['success'] = $message;
    }

    /**
     * Get and clear success message
     * @return string|null
     */
    public static function getSuccess()
    {
        self::startSession();
        $success = $_SESSION['success'] ?? null;
        unset($_SESSION['success']);
        return $success;
    }

    public static function isLibrarian()
    {
        self::startSession();
        return $_SESSION['email'] === 'admin@gmail.com';
    }
}
?>
