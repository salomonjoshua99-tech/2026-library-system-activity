<?php
require_once "BorrowRepository.php";

class LibraryService {
    private $borrowRepo;
    private $fineRate = 5;

    public function __construct() {
        $this->borrowRepo = new BorrowRepository();
    }

    public function borrowBook($student_id, $book_id, $days) {
        $borrow_date = date('Y-m-d');
        $due_date = date('Y-m-d', strtotime("+$days days"));
        return $this->borrowRepo->borrow($student_id, $book_id, $borrow_date, $due_date);
    }

    public function returnBook($record_id) {
        $record = $this->borrowRepo->getRecord($record_id);

        $due = strtotime($record['due_date']);
        $today = strtotime(date('Y-m-d'));

        $daysLate = max(0, ($today - $due) / 86400);
        $fine = $daysLate * $this->fineRate;

        $this->borrowRepo->returnBook($record_id, date('Y-m-d'), $fine);
        return $fine;
    }
}
?>