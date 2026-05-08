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
    /**
     * @var int|null The unique identifier for the borrow record
     */
    public ?int $id = null;

    /**
     * @var int The ID of the student borrowing the book
     */
    public int $studentId;

    /**
     * @var int The ID of the book being borrowed
     */
    public int $bookId;

    /**
     * @var string The date when the book was borrowed (Y-m-d format)
     */
    public string $borrowDate;

    /**
     * @var string The due date for the book return (Y-m-d format)
     */
    public string $dueDate;

    /**
     * @var string|null The actual return date (Y-m-d format, null if not returned)
     */
    public ?string $returnDate = null;

    /**
     * @var float The calculated fine amount for overdue return
     */
    public float $fine = 0.0;

    /**
     * @var string The current status of the borrow record ('borrowed' or 'returned')
     */
    public string $status = 'borrowed';
}
