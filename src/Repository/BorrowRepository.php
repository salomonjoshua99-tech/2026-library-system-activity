<?php
require_once "DatabaseConnection.php";

class BorrowRepository {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->connect();
    }

    public function borrow($student_id, $book_id, $borrow_date, $due_date) {
        $stmt = $this->conn->prepare(
            "INSERT INTO borrow_records(student_id, book_id, borrow_date, due_date, status) 
             VALUES (?, ?, ?, ?, 'borrowed')"
        );
        $stmt->bind_param("iiss", $student_id, $book_id, $borrow_date, $due_date);
        return $stmt->execute();
    }

    public function getRecord($id) {
        return $this->conn->query("SELECT * FROM borrow_records WHERE record_id = $id")->fetch_assoc();
    }

    public function returnBook($id, $return_date, $fine) {
        $stmt = $this->conn->prepare(
            "UPDATE borrow_records SET return_date=?, fine_amount=?, status='returned' WHERE record_id=?"
        );
        $stmt->bind_param("sdi", $return_date, $fine, $id);
        return $stmt->execute();
    }

    public function getOverdue() {
        $today = date('Y-m-d');
        $sql = "SELECT * FROM borrow_records WHERE due_date < '$today' AND status='borrowed'";
        return $this->conn->query($sql)->fetch_all(MYSQLI_ASSOC);
    }
}
?>