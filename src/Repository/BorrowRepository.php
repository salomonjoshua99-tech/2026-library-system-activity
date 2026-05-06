<?php

declare(strict_types=1);

namespace App\Library;

class BorrowRepository
{
    public function __construct(private DatabaseConnection $db)
    {
    }

    public function borrowBook(int $studentId, int $bookId, int $days): bool
    {
        $conn = $this->db->getConnection();

        $dueDate = date('Y-m-d', strtotime("+$days days"));

        $stmt = $conn->prepare(
            "INSERT INTO borrow_records 
            (student_id, book_id, borrow_date, due_date, status) 
            VALUES (?, ?, CURDATE(), ?, 'borrowed')"
        );

        $stmt->bind_param("iis", $studentId, $bookId, $dueDate);

        return $stmt->execute();
    }
}