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
    public ?int $id;
    public string $title;
    public string $author;
    public int $year;
    public string $genre;

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
