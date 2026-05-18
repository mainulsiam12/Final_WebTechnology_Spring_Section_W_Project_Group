<?php

class Borrow {

    private $conn;

    public function __construct($db){
        $this->conn = $db;
    }

   
    public function checkBook($book_id){

        $sql = "
        SELECT books.total_copies -
        COUNT(CASE WHEN borrow_records.status='Active' THEN 1 END)
        AS available

        FROM books

        LEFT JOIN borrow_records
        ON books.id = borrow_records.book_id

        WHERE books.id='$book_id'

        GROUP BY books.id
        ";

        $result = mysqli_query($this->conn, $sql);

        return mysqli_fetch_assoc($result);
    }

    
    public function borrowBook($member_id, $book_id){

        $sql = "
        INSERT INTO borrow_records
        (member_id, book_id, status, borrow_date, due_date)

        VALUES
        ('$member_id', '$book_id', 'Pending',
        CURDATE(),
        DATE_ADD(CURDATE(), INTERVAL 14 DAY))
        ";

        return mysqli_query($this->conn, $sql);
    }

    
    public function pendingRequests(){

        $sql = "
        SELECT borrow_records.id,
        members.name,
        books.title,
        borrow_records.borrow_date

        FROM borrow_records

        JOIN members
        ON borrow_records.member_id = members.id

        JOIN books
        ON borrow_records.book_id = books.id

        WHERE borrow_records.status='Pending'
        ";

        $result = mysqli_query($this->conn, $sql);

        return $result;
    }

   
    public function approveBorrow($id){

        $sql = "
        UPDATE borrow_records
        SET status='Active'
        WHERE id='$id'
        ";

        return mysqli_query($this->conn, $sql);
    }

    
    public function rejectBorrow($id){

        $sql = "
        DELETE FROM borrow_records
        WHERE id='$id'
        ";

        return mysqli_query($this->conn, $sql);
    }

    
    public function activeLoans($search){

        $sql = "
        SELECT borrow_records.id,
        members.name,
        books.title,
        borrow_records.due_date

        FROM borrow_records

        JOIN members
        ON borrow_records.member_id = members.id

        JOIN books
        ON borrow_records.book_id = books.id

        WHERE borrow_records.status='Active'

        AND (
            members.name LIKE '%$search%'
            OR books.title LIKE '%$search%'
        )
        ";

        return mysqli_query($this->conn, $sql);
    }

    
    public function returnBook($id){

        $sql = "
        UPDATE borrow_records

        SET
        status='Returned',
        return_date=NOW()

        WHERE id='$id'
        ";

        return mysqli_query($this->conn, $sql);
    }

}
?>