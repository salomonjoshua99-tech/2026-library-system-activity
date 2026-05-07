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

    public function borrow(int $sid, int $bid, string $borrowDate, string $dueDate): bool
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO borrow_records (student_id, book_id, borrow_date, due_date, status)
             VALUES (?, ?, ?, ?, "borrowed")'
        );

        $stmt->bind_param('iiss', $sid, $bid, $borrowDate, $dueDate);

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
}