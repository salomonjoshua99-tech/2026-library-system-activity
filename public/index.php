<?php
declare(strict_types=1);

use App\Library\Repository\BookRepository;
use App\Library\Service\LibraryService;
use App\Library\Service\LibraryReport;
use App\Library\View\HtmlRenderer;

require_once __DIR__ . '/../src/Repository/BookRepository.php';
require_once __DIR__ . '/../src/Service/LibraryService.php';
require_once __DIR__ . '/../src/Service/LibraryReport.php';
require_once __DIR__ . '/../src/View/HtmlRenderer.php';

$bookRepo = new BookRepository();
$service = new LibraryService();
$report = new LibraryReport();

$act = $_GET['act'] ?? '';

if ($act === 'list') {
    $books = $bookRepo->getAll();

    HtmlRenderer::render('book_list', ['books' => $books]);
}

elseif ($act === 'borrow_form') {
    HtmlRenderer::render('borrow_form');
}

elseif ($act === 'borrow') {
    $service->borrowBook((int) $_POST['sid'], (int) $_POST['bid'], (int) $_POST['days']);

    echo 'Borrowed successfully';
}

elseif ($act === 'return') {
    $fine = $service->returnBook((int) $_POST['rid']);

    echo 'Fine: ' . $fine;
}

elseif ($act === 'report') {
    $stats = $report->getStats();

    HtmlRenderer::render('report_view', ['stats' => $stats]);
}