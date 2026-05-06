<?php
class DatabaseConnection {
    private $host = "localhost";
    private $user = "root";
    private $pass = "";
    private $dbname = "library_db";

    public function connect() {
        $conn = new mysqli($this->host, $this->user, $this->pass, $this->dbname);
        if ($conn->connect_error) {
            die("Database connection failed");
        }
        return $conn;
    }
}
?>