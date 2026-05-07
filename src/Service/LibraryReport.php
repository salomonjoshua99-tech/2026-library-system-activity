<?php

declare(strict_types=1);

namespace App\Library\Service;

use mysqli;
use App\Library\Config\DatabaseConnection;

class LibraryReport
{
    private mysqli $conn;

    public function __construct()
    {
        $this->conn = DatabaseConnection::connect();
    }

    public function getStats(): array
{
    $stmt1 = $this->conn->prepare('SELECT COUNT(*) as total FROM books');
    $stmt1->execute();
    $books = $stmt1->get_result()->fetch_assoc()['total'];

    $stmt2 = $this->conn->prepare('SELECT COUNT(*) as total FROM borrow_records WHERE status = "borrowed"');
    $stmt2->execute();
    $borrowed = $stmt2->get_result()->fetch_assoc()['total'];

    $stmt3 = $this->conn->prepare('SELECT COUNT(*) as total FROM borrow_records WHERE status = "returned"');
    $stmt3->execute();
    $returned = $stmt3->get_result()->fetch_assoc()['total'];

    $stmt4 = $this->conn->prepare('SELECT SUM(fine_amount) as total FROM borrow_records');
    $stmt4->execute();
    $fines = $stmt4->get_result()->fetch_assoc()['total'];

    return [
        'books' => $books,
        'borrowed' => $borrowed,
        'returned' => $returned,
        'fines' => $fines
    ];
}
}
