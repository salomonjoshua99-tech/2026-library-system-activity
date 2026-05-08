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
    /**
     * Searches for books by title or author keyword.
     *
     * Executes a prepared statement to find books matching the
     * keyword in either title or author fields.
     *
     * @param string $keyword The search term to match against book titles and authors
     * @return array Array of matching book records with all fields
     * @throws RuntimeException If database query fails
     */
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
    /**
     * Initializes BookRepository with database connection.
     *
     * Establishes connection to MySQL database using DatabaseConnection
     * class for consistent connection management.
     *
     * @throws RuntimeException If database connection fails
     */
    public function __construct()
    {
        $this->conn = DatabaseConnection::connect();
    }
    /**
     * Adds a new book to the library database.
     *
     * Validates book data, prepares INSERT statement, and executes
     * with proper parameter binding to prevent SQL injection.
     *
     * @param Book $book The book entity containing title, author, year, and genre
     * @return int The auto-generated ID of the newly inserted book
     * @throws RuntimeException If statement preparation or execution fails
     */
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

    /**
     * Retrieves all books from the library database.
     *
     * Executes a simple SELECT query to return complete book
     * inventory with all associated fields.
     *
     * @return array Array of all book records with full details
     * @throws RuntimeException If database query fails
     */
    public function getAll(): array
    {
        $result = $this->conn->query('SELECT * FROM books');

        if (!$result) {
            throw new RuntimeException('Failed to query books: ' . $this->conn->error);
        }

        return $result->fetch_all(MYSQLI_ASSOC);
    }
}
