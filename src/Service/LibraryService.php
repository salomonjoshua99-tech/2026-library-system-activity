<?php
declare(strict_types=1);

namespace App\Library\Service;

use App\Library\Repository\BorrowRepository;
use App\Library\Config\LibraryConfig;

class LibraryService
{
    private BorrowRepository $borrowRepo;

    public function __construct()
    {
        $this->borrowRepo = new BorrowRepository();
    }

    public function borrowBook(int $sid, int $bid, int $days): bool
    {
        $borrowDate = date('Y-m-d');
        $dueDate = date('Y-m-d', strtotime('+' . $days . ' days'));

        return $this->borrowRepo->borrow($sid, $bid, $borrowDate, $dueDate);
    }

    public function returnBook(int $rid): float
    {
        $record = $this->borrowRepo->get($rid);

        $due = strtotime($record['due_date']);
        $today = strtotime(date('Y-m-d'));

        $daysLate = max(0, ($today - $due) / 86400);
        $fine = $daysLate * LibraryConfig::FINE_RATE;

        $this->borrowRepo->returnBook($rid, date('Y-m-d'), $fine);

        return $fine;
    }
}