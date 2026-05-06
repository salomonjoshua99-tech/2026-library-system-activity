<?php

class DatabaseConnection
{
    private string $host = "localhost";
    private string $user = "root";
    private string $pass = "";
    private string $db = "library_db";

    public mysqli $conn;

    public function connect(): mysqli
    {
        $this->conn = new mysqli(
            $this->host,
            $this->user,
            $this->pass,
            $this->db
        );

        if ($this->conn->connect_error) {
            die("db error");
        }

        return $this->conn;
    }
}