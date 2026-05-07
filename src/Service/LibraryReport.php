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
        return [
            'books' => $this->conn->query('SELECT COUNT(*) c FROM books')->fetch_assoc()['c'],
            'borrowed' => $this->conn->query('SELECT COUNT(*) c FROM borrow_records WHERE status = "borrowed"')->fetch_assoc()['c'],
            'returned' => $this->conn->query('SELECT COUNT(*) c FROM borrow_records WHERE status = "returned"')->fetch_assoc()['c'],
            'fines' => $this->conn->query('SELECT SUM(fine_amount) s FROM borrow_records')->fetch_assoc()['s']
        ];
    }
}