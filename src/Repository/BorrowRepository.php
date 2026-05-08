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
    /**
     * @var mysqli The active database connection instance
     */
    private mysqli $conn;
    /**
     * Initializes BorrowRepository with database connection.
     *
     * Establishes MySQL connection for borrow record operations.
     *
     * @throws RuntimeException If database connection fails
     */
    public function __construct()
    {
        $this->conn = DatabaseConnection::connect();
    }

    /**
     * Creates a new borrow record.
     *
     * Validates IDs and creates borrow record with dates and status.
     *
     * @param int $studentid The student ID borrowing the book
     * @param int $bookid The book ID being borrowed
     * @param string $borrowDate The borrow date (Y-m-d format)
     * @param string $dueDate The due date (Y-m-d format)
     * @return bool True if borrow record created successfully
     * @throws InvalidArgumentException If student ID or book ID invalid
     * @throws RuntimeException If statement preparation or execution fails
     */
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
    /**
     * Retrieves a borrow record by ID.
     *
     * Executes prepared statement to fetch specific borrow record.
     *
     * @param int $id The borrow record ID
     * @return array|null The borrow record data or null if not found
     * @throws RuntimeException If database query fails
     */
    public function get(int $id): array
    {
        $stmt = $this->conn->prepare('SELECT * FROM borrow_records WHERE record_id = ?');
        $stmt->bind_param('i', $id);
        $stmt->execute();
        $result = $stmt->get_result();

        return $result->fetch_assoc();
    }
    /**
     * Updates borrow record when book is returned.
     *
     * Sets return date, fine amount, and status to 'returned'.
     *
     * @param int $id The borrow record ID
     * @param string $date The return date (Y-m-d format)
     * @param float $fine The calculated fine amount
     * @return bool True if update successful
     * @throws RuntimeException If update query fails
     */
    public function returnBook(int $id, string $date, float $fine): bool
    {
        $stmt = $this->conn->prepare(
            'UPDATE borrow_records SET return_date = ?, fine_amount = ?, status = "returned"
             WHERE record_id = ?'
        );

        $stmt->bind_param('sdi', $date, $fine, $id);

        return $stmt->execute();
    }
    /**
     * Retrieves all overdue borrow records.
     *
     * Finds records where due date is before today and status is 'borrowed'.
     *
     * @return array Array of overdue borrow records
     * @throws RuntimeException If database query fails
     */
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
