<?php

declare(strict_types=1);

namespace App\Library\Service;

/**
 * Library Service
 *
 * Provides high-level library operations including book borrowing,
 * returns, and fine calculations with proper validation and
 * business logic enforcement.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */

use RuntimeException;
use InvalidArgumentException;
use App\Library\Repository\BorrowRepository;
use App\Library\Config\LibraryConfig;

class LibraryService
{
    private BorrowRepository $borrowRepo;
    /**
     * Initializes LibraryService with BorrowRepository dependency.
     *
     * Creates a new BorrowRepository instance for handling
     * borrowing operations and fine calculations.
     *
     * @throws RuntimeException If BorrowRepository instantiation fails
     */
    public function __construct()
    {
        $this->borrowRepo = new BorrowRepository();
    }
    /**
     * Borrows a book for a student with validation.
     *
     * Validates student ID, book ID, and borrowing period,
     * calculates due date, and creates borrow record.
     *
     * @param int $studentid The ID of the student borrowing the book
     * @param int $bookid The ID of the book being borrowed
     * @param int $days The borrowing period in days (1-30)
     * @return bool True if book was successfully borrowed
     * @throws InvalidArgumentException If student ID, book ID, or days are invalid
     * @throws RuntimeException If borrow record creation fails
     */
    public function borrowBook(int $studentid, int $bookid, int $days): bool
    {
        if ($studentid <= 0) {
            throw new InvalidArgumentException('Invalid student ID: ' . $studentid);
        }
        if ($bookid <= 0) {
            throw new InvalidArgumentException('Invalid book ID: ' . $bookid);
        }
        if ($days <= 0 || $days > 30) {
            throw new InvalidArgumentException('Invalid borrow period: ' . $days . ' days (must be 1-30)');
        }

        $borrowDate = date('Y-m-d');
        $dueDate = date('Y-m-d', strtotime('+' . $days . ' days'));

        return $this->borrowRepo->borrow($studentid, $bookid, $borrowDate, $dueDate);
    }
    /**
     * Returns a borrowed book and calculates fine.
     *
     * Validates record ID, checks if book is already returned,
     * calculates days late, and applies fine rate.
     *
     * @param int $recordid The ID of the borrow record to return
     * @return float The calculated fine amount (0.00 if returned on time)
     * @throws InvalidArgumentException If record ID is invalid
     * @throws RuntimeException If record not found or already returned
     */
    public function returnBook(int $recordid): float
    {
        if ($recordid <= 0) {
            throw new InvalidArgumentException('Invalid record ID: ' . $recordid);
        }

        $record = $this->borrowRepo->get($recordid);

        if (!$record) {
            throw new RuntimeException('Borrow record not found: ' . $recordid);
        }

        if ($record['status'] === 'returned') {
            throw new RuntimeException('Book already returned for record: ' . $recordid);
        }

        $due = strtotime($record['due_date']);
        $today = strtotime(date('Y-m-d'));

        $daysLate = max(0, ($today - $due) / 86400);
        $fine = $daysLate * LibraryConfig::FINE_RATE;

        $this->borrowRepo->returnBook($recordid, date('Y-m-d'), $fine);

        return $fine;
    }
}
