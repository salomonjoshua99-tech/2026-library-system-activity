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

    public function __construct()
    {
        $this->borrowRepo = new BorrowRepository();
    }

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
