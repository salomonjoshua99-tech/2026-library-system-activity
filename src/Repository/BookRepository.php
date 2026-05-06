<?php
require_once "DatabaseConnection.php";
require_once "Book.php";

class BookRepository {
    private $conn;

    public function __construct() {
        $db = new DatabaseConnection();
        $this->conn = $db->connect();
    }

    public function add(Book $book) {
        $stmt = $this->conn->prepare("INSERT INTO books(title, author, year, genre) VALUES (?, ?, ?, ?)");
        $stmt->bind_param("ssis", $book->title, $book->author, $book->year, $book->genre);
        $stmt->execute();
        return $this->conn->insert_id;
    }

    public function getAll() {
        $result = $this->conn->query("SELECT * FROM books");
        return $result->fetch_all(MYSQLI_ASSOC);
    }

    public function search($keyword) {
        $stmt = $this->conn->prepare("SELECT * FROM books WHERE title LIKE ? OR author LIKE ?");
        $kw = "%$keyword%";
        $stmt->bind_param("ss", $kw, $kw);
        $stmt->execute();
        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
?>