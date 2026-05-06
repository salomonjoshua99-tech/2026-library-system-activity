<?php

declare(strict_types=1);

namespace App\Library;

class Book
{
    public function __construct(
        private ?int $id,
        private string $title,
        private string $author,
        private int $year,
        private string $genre
    ) {
    }

    public function getTitle(): string { return $this->title; }
    public function getAuthor(): string { return $this->author; }
    public function getYear(): int { return $this->year; }
    public function getGenre(): string { return $this->genre; }
}