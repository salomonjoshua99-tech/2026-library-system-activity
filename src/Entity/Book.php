<?php
class Book {
    public $id;
    public $title;
    public $author;
    public $year;
    public $genre;

    public function __construct($title, $author, $year, $genre, $id = null) {
        $this->id = $id;
        $this->title = $title;
        $this->author = $author;
        $this->year = $year;
        $this->genre = $genre;
    }
}
?>