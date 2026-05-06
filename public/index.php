<?php

declare(strict_types=1);

use App\Library\DatabaseConnection;
use App\Library\Book;
use App\Library\BookRepository;

require 'vendor/autoload.php';

$db = new DatabaseConnection();
$db->connect();

$bookRepo = new BookRepository($db);

if ($_GET['act'] ?? '' === 'add') {
    $book = new Book(
        null,
        $_POST['t'],
        $_POST['a'],
        (int) $_POST['y'],
        $_POST['g']
    );

    $bookRepo->addBook($book);
}
