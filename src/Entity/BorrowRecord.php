<?php
declare(strict_types=1);

namespace App\Library\Entity;

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