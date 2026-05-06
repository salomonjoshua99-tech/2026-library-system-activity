<?php

declare(strict_types=1);

namespace App\Library;

class BookRepository
{
    public function __construct(private DatabaseConnection $db) {}

    public function addBook(Book $book): int
    {
        $conn = $this->db->getConnection();

        $stmt = $conn->prepare(
            "INSERT INTO books (title, author, year, genre) VALUES (?, ?, ?, ?)"
        );

        $stmt->bind_param(
            "ssis",
            $book->getTitle(),
            $book->getAuthor(),
            $book->getYear(),
            $book->getGenre()
        );

        $stmt->execute();

        return $conn->insert_id;
    }

    public function findById(int $id): ?array
    {
        $conn = $this->db->getConnection();

        $stmt = $conn->prepare(
            "SELECT * FROM books WHERE book_id = ?"
        );

        $stmt->bind_param("i", $id);
        $stmt->execute();

        $result = $stmt->get_result()->fetch_assoc();

        return $result ?: null;
    }

    public function findAll(): array
    {
        $conn = $this->db->getConnection();

        $result = $conn->query("SELECT * FROM books");

        $books = [];

        while ($row = $result->fetch_assoc()) {
            $books[] = $row;
        }

        return $books;
    }
}
