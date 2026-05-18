<?php

require_once '../config/Database.php';

class BookModel {

    private $conn;

    public function __construct() {

        $database = new Database();
        $this->conn = $database->OpenCon();
    }

    public function addBook($data) {

        $sql = "INSERT INTO books
        (
            genre_id,
            title,
            author,
            isbn,
            total_copies,
            shelf_location,
            published_year
        )

        VALUES(?,?,?,?,?,?,?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param(
            $stmt,
            "isssiss",
            $data['genre_id'],
            $data['title'],
            $data['author'],
            $data['isbn'],
            $data['total_copies'],
            $data['shelf_location'],
            $data['published_year']
        );

        return mysqli_stmt_execute($stmt);
    }

    public function getBooks() {

        $sql = "

        SELECT books.*,
        genres.name as genre_name,

        (
            books.total_copies -

            COUNT(
                CASE
                WHEN borrow_records.status = 'Active'
                THEN 1
                END
            )

        ) as available_copies

        FROM books

        LEFT JOIN genres
        ON books.genre_id = genres.id

        LEFT JOIN borrow_records
        ON books.id = borrow_records.book_id

        GROUP BY books.id
        ";

        return mysqli_query($this->conn, $sql);
    }
}
?>