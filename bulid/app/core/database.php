<?php

class Database
{
    private $host = "localhost";
    private $dbname = "gujarati_library";
    private $username = "root";
    private $password = "";

    public function connect()
    {
        return new PDO(
            "mysql:host={$this->host};dbname={$this->dbname};charset=utf8mb4",
            $this->username,
            $this->password,
            [
                PDO::ATTR_ERRMODE => PDO::ERRMODE_EXCEPTION
            ]
        );
    }
}

?>