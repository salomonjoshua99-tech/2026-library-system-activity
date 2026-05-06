<?php

declare(strict_types=1);

namespace App\Library;

class LibraryReport
{
    public function __construct(private DatabaseConnection $db)
    {
    }

    public function generate(): array
    {
        $conn = $this->db->getConnection();

        return [
            'totalBooks' => $conn->query("SELECT COUNT(*) as c FROM books")->fetch_assoc()['c'],
            'borrowed' => $conn->query("SELECT COUNT(*) as c FROM borrow_records WHERE status='borrowed'")->fetch_assoc()['c'],
            'returned' => $conn->query("SELECT COUNT(*) as c FROM borrow_records WHERE status='returned'")->fetch_assoc()['c'],
            'fines' => $conn->query("SELECT SUM(fine_amount) as s FROM borrow_records")->fetch_assoc()['s'],
        ];
    }
}