<?php
require_once "BookRepository.php";
require_once "LibraryService.php";
require_once "LibraryReport.php";
require_once "HtmlRenderer.php";

$bookRepo = new BookRepository();
$service = new LibraryService();
$report = new LibraryReport();

$action = $_GET['act'] ?? '';

if ($action == "add") {
    $book = new Book($_POST['t'], $_POST['a'], $_POST['y'], $_POST['g']);
    $bookRepo->add($book);
    echo "Book added!";
}

elseif ($action == "list") {
    $books = $bookRepo->getAll();
    HtmlRenderer::renderBooks($books);
}

elseif ($action == "borrow") {
    $service->borrowBook($_POST['sid'], $_POST['bid'], $_POST['days']);
    echo "Book borrowed!";
}

elseif ($action == "return") {
    $fine = $service->returnBook($_POST['rid']);
    echo "Returned. Fine: $fine";
}

elseif ($action == "report") {
    $stats = $report->getStats();
    HtmlRenderer::renderReport($stats);
}
?>