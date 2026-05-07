<?php

declare(strict_types=1);

namespace App\Library\Repository;

use mysqli;
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

        $stmt->bind_param('ssis', $book->title, $book->author, $book->year, $book->genre);
        $stmt->execute();

        return $this->conn->insert_id;
    }


    public function getAll(): array
    {
        $result = $this->conn->query('SELECT * FROM books');

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
