<?php

declare(strict_types=1);

namespace App\Library\Repository;

/**
 * Book Repository
 *
 * Manages database operations for Book entities using prepared
 * statements to prevent SQL injection and ensure data consistency.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */

use mysqli;
use RuntimeException;
use App\Library\Config\DatabaseConnection;
use App\Library\Entity\Book;

class BookRepository
{
    private mysqli $conn;

    public function search(string $keyword): array
    {
        $stmt = $this->conn->prepare(
            'SELECT * FROM books WHERE title LIKE ? OR author LIKE ?'
        );
        $kw = '%' . $keyword . '%';
        $stmt->bind_param('ss', $kw, $kw);
        $stmt->execute();

        return $stmt->get_result()->fetch_all(MYSQLI_ASSOC);
    }

    public function __construct()
    {
        $this->conn = DatabaseConnection::connect();
    }

    public function add(Book $book): int
    {
        $stmt = $this->conn->prepare(
            'INSERT INTO books (title, author, year, genre) VALUES (?, ?, ?, ?)'
        );

        if (!$stmt) {
            throw new RuntimeException('Failed to prepare statement: ' . $this->conn->error);
        }

        $stmt->bind_param('ssis', $book->title, $book->author, $book->year, $book->genre);

        if (!$stmt->execute()) {
            throw new RuntimeException('Failed to insert book: ' . $stmt->error);
        }

        return $this->conn->insert_id;
    }


    public function getAll(): array
    {
        $result = $this->conn->query('SELECT * FROM books');

        if (!$result) {
            throw new RuntimeException('Failed to query books: ' . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
