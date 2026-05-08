<?php

declare(strict_types=1);

namespace App\Library\Repository;

/**
 * Borrow Repository
 *
 * Handles database operations for borrowing records including
 * creating new borrows, updating returns, and tracking overdue books.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */

use mysqli;
use RuntimeException;
use InvalidArgumentException;
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
        if ($studentid <= 0) {
            throw new InvalidArgumentException('Invalid student ID: ' . $studentid);
        }
        if ($bookid <= 0) {
            throw new InvalidArgumentException('Invalid book ID: ' . $bookid);
        }

        $stmt = $this->conn->prepare(
            'INSERT INTO borrow_records (student_id, book_id, borrow_date, due_date, status)
         VALUES (?, ?, ?, ?, "borrowed")'
        );

        if (!$stmt) {
            throw new RuntimeException('Failed to prepare borrow statement: ' . $this->conn->error);
        }

        $stmt->bind_param('iiss', $studentid, $bookid, $borrowDate, $dueDate);

        if (!$stmt->execute()) {
            throw new RuntimeException('Failed to create borrow record: ' . $stmt->error);
        }

        return true;
    }
    public function get(int $id): array
    {
        $stmt = $this->conn->prepare('SELECT * FROM borrow_records WHERE record_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

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
