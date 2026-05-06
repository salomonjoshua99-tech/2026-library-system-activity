<?php
require_once "DatabaseConnection.php";

class LibraryReport {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->connect();
    }

    public function getStats() {
        return [
            "books" => $this->conn->query("SELECT COUNT(*) c FROM books")->fetch_assoc()['c'],
            "borrowed" => $this->conn->query("SELECT COUNT(*) c FROM borrow_records WHERE status='borrowed'")->fetch_assoc()['c'],
            "returned" => $this->conn->query("SELECT COUNT(*) c FROM borrow_records WHERE status='returned'")->fetch_assoc()['c'],
            "fines" => $this->conn->query("SELECT SUM(fine_amount) s FROM borrow_records")->fetch_assoc()['s']
        ];
    }
}
?>