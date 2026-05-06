<?php
class BorrowRecord {
    public $id;
    public $student_id;
    public $book_id;
    public $borrow_date;
    public $due_date;
    public $return_date;
    public $fine;
    public $status;

    public function __construct($student_id, $book_id) {
        $this->student_id = $student_id;
        $this->book_id = $book_id;
    }
}
?>