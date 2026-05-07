<?php

declare(strict_types=1);

namespace App\Library\Repository;

use mysqli;
use App\Library\Config\DatabaseConnection;

class BorrowRepository
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = DatabaseConnection::connect();
    }

    public function borrow(int $studentid, int $bookid, string $borrowDate, string $dueDate): bool
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO borrow_records (student_id, book_id, borrow_date, due_date, status)
             VALUES (?, ?, ?, ?, "borrowed")'
        );

        $stmt->bind_param('iiss', $studentid, $bookid, $borrowDate, $dueDate);

        return $stmt->execute();
    }

    public function get(int $id): array
    {
        $result = $this->conn->query('SELECT * FROM borrow_records WHERE record_id = ' . $id);

        return $result->fetch_assoc();
    }

    public function returnBook(int $id, string $date, float $fine): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE borrow_records SET return_date = ?, fine_amount = ?, status = "returned"
             WHERE record_id = ?'
        );

        $stmt->bind_param('sdi', $date, $fine, $id);

        return $stmt->execute();
    }
    public function getOverdue(): array
    {
        $today = date('Y-m-d');
        $sql = 'SELECT * FROM borrow_records WHERE due_date < ? AND status = "borrowed"';
        $stmt = $this->conn->prepare($sql);
        $stmt->bind_param('s', $today);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }
}
