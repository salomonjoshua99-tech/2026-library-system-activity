<?php
declare(strict_types=1);

namespace App\Library\Entity;

class Book
{
    public ?int $id;
    public string $title;
    public string $author;
    public int $year;
    public string $genre;

    public function __construct(string $title, string $author, int $year, string $genre, ?int $id = null)
    {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->genre = $genre;
    }
}