<?php

require_once __DIR__ . '/../core/database.php';

class user
{
    private $db;

    public function __construct()
    {
        $this->db = (new Database())->connect();
    }

    /**
     * Register a new user
     * @param string $username
     * @param string $email
     * @param string $password
     * @return bool
     */
    public function register($username, $email, $password)
    {
        $sql = "INSERT INTO users (name, email, password, created_at) VALUES(:username, :email, :password, :created_at)";
        $stmt = $this->db->prepare($sql);
        $hashedPassword = password_hash($password, PASSWORD_BCRYPT);

        $stmt->bindValue(':username', $username, PDO::PARAM_STR);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->bindValue(':password', $hashedPassword, PDO::PARAM_STR);
        $stmt->bindValue(':created_at', date('Y-m-d H:i:s'), PDO::PARAM_STR);

        return $stmt->execute();
    }

    /**
     * Get user by email
     * @param string $email
     * @return array|false - Returns user data or false if not found
     */
    public function getUserByEmail($email)
    {
        $sql = "SELECT * FROM users WHERE email = :email LIMIT 1";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':email', $email, PDO::PARAM_STR);
        $stmt->execute();

        return $stmt->fetch(PDO::FETCH_ASSOC);
    }



    public function getAllUsers()
    {
        $sql = "SELECT * FROM users";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function deleteUser($id)
    {
        $sql = "DELETE FROM users WHERE id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':id', $id, PDO::PARAM_INT);
        return $stmt->execute();
    }



}
?>