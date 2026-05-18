<?php

class BorrowController {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

    // Borrow Book
    public function borrowBook($member_id, $book_id){

        $sql = "
        SELECT total_copies -
        COUNT(CASE WHEN status='Active' THEN 1 END) AS available

        FROM books

        LEFT JOIN borrow_records
        ON books.id = borrow_records.book_id

        WHERE books.id=?

        GROUP BY books.id
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$book_id]);

        $data = $stmt->fetch(PDO::FETCH_ASSOC);

        if($data['available'] <= 0){
            return "Book unavailable";
        }

        $sql = "
        INSERT INTO borrow_records
        (member_id, book_id, status, borrow_date, due_date)

        VALUES
        (?, ?, 'Pending', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 14 DAY))
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            $member_id,
            $book_id
        ]);

        return "Borrow Request Sent";
    }

    // Approve Borrow
    public function approveBorrow($id){

        $sql = "
        UPDATE borrow_records
        SET status='Active'
        WHERE id=?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return true;
    }

    // Reject Borrow
    public function rejectBorrow($id){

        $sql = "
        DELETE FROM borrow_records
        WHERE id=?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return true;
    }

    // Return Book
    public function returnBook($id){

        $sql = "
        UPDATE borrow_records

        SET
        status='Returned',
        return_date=NOW()

        WHERE id=?
        ";

        $stmt = $this->conn->prepare($sql);
        $stmt->execute([$id]);

        return "Book Returned";
    }

    // Get Pending Requests
    public function pendingRequests(){

        $sql = "
        SELECT borrow_records.id,
        members.name,
        books.title,
        borrow_date

        FROM borrow_records

        JOIN members
        ON borrow_records.member_id = members.id

        JOIN books
        ON borrow_records.book_id = books.id

        WHERE status='Pending'
        ";

        $stmt = $this->conn->query($sql);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    // Search Active Loans
    public function activeLoans($search = ''){

        $sql = "
        SELECT borrow_records.id,
        members.name,
        books.title,
        due_date

        FROM borrow_records

        JOIN members
        ON borrow_records.member_id = members.id

        JOIN books
        ON borrow_records.book_id = books.id

        WHERE status='Active'

        AND (
            members.name LIKE ?
            OR books.title LIKE ?
        )
        ";

        $stmt = $this->conn->prepare($sql);

        $stmt->execute([
            \"%$search%\",
            \"%$search%\"
        ]);

        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

}
?>