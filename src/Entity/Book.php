<?php

declare(strict_types=1);

namespace App\Library\Entity;

/**
 * Book Entity
 *
 * Represents a book in the library system with properties for
 * title, author, publication year, and genre. Includes input
 * validation to ensure data integrity.
 *
 * @author Joshua Salomon
 * @since 2026-05-08
 */

use InvalidArgumentException;

class Book
{
    /**
     * @var int|null The unique identifier for the book
     */
    public ?int $id;

    /**
     * @var string The title of the book
     */
    public string $title;

    /**
     * @var string The author name of the book
     */
    public string $author;

    /**
     * @var int The publication year of the book
     */
    public int $year;

    /**
     * @var string The genre category of the book
     */
    public string $genre;
    /**
     * Creates a new Book entity with validation.
     *
     * Validates title, author, year, and genre before assigning
     * properties to ensure data integrity.
     *
     * @param string $title The book title (cannot be empty)
     * @param string $author The book author (cannot be empty)
     * @param int $year Publication year (1000 to current year)
     * @param string $genre The book genre (cannot be empty)
     * @param int|null $id Optional existing book ID
     * @throws InvalidArgumentException If any field is invalid
     */
    public function __construct(string $title, string $author, int $year, string $genre, ?int $id = null)
    {
        if (empty($title)) {
            throw new InvalidArgumentException('Title cannot be empty');
        }
        if (empty($author)) {
            throw new InvalidArgumentException('Author cannot be empty');
        }
        if ($year < 1000 || $year > date('Y')) {
            throw new InvalidArgumentException('Invalid publication year: ' . $year);
        }
        if (empty($genre)) {
            throw new InvalidArgumentException('Genre cannot be empty');
        }

        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->genre = $genre;
    }
}
