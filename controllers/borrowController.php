<?php

include '../config/database.php';
include '../models/Borrow.php';

class BorrowController {

    private $borrowModel;

    public function __construct(){

        $database = new Database();
        $db = $database->OpenCon();

        $this->borrowModel = new Borrow($db);
    }

    // Borrow Book
    public function borrowBook($member_id, $book_id){

        $data = $this->borrowModel->checkBook($book_id);

        if($data['available'] <= 0){

            echo "Book Unavailable";
            return;

        }

        $this->borrowModel->borrowBook($member_id, $book_id);

        echo "Borrow Request Sent";
    }

    // Approve
    public function approveBorrow($id){

        $this->borrowModel->approveBorrow($id);

        echo json_encode([
            'success' => true
        ]);
    }

    // Reject
    public function rejectBorrow($id){

        $this->borrowModel->rejectBorrow($id);

        echo json_encode([
            'success' => true
        ]);
    }

    // Return
    public function returnBook($id){

        $this->borrowModel->returnBook($id);

        echo "Book Returned";
    }

}
?>