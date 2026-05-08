<?php

declare(strict_types=1);

namespace App\Library\Entity;

/**
 * Borrow Record Entity
 *
 * Represents a book borrowing transaction including student
 * information, borrow dates, due dates, and fine calculations.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */
class BorrowRecord
{
    public ?int $id = null;
    public int $studentId;
    public int $bookId;
    public string $borrowDate;
    public string $dueDate;
    public ?string $returnDate = null;
    public float $fine = 0.0;
    public string $status = 'borrowed';
}
