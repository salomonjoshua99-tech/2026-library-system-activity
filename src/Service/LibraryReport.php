<?php

declare(strict_types=1);

namespace App\Library\Service;

/**
 * Library Report Service
 *
 * Generates statistical reports for the library system including
 * book counts, borrowing statistics, and fine collection data.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */

use mysqli;
use App\Library\Config\DatabaseConnection;

class LibraryReport
{
    private mysqli $conn;
    /**
     * Initializes LibraryReport with database connection.
     *
     * Establishes connection for statistical report generation.
     *
     * @throws RuntimeException If database connection fails
     */
    public function __construct()
    {
        $this->conn = DatabaseConnection::connect();
    }
    /**
     * Generates library statistics report.
     *
     * Calculates total books, borrowed/returned counts, and fine totals.
     *
     * @return array Associative array with keys: books, borrowed, returned, fines
     * @throws RuntimeException If any database query fails
     */
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
