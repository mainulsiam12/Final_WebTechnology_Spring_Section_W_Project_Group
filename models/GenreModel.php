<?php

require_once '../config/Database.php';

class GenreModel {

    private $conn;

    public function __construct() {

        $database = new Database();
        $this->conn = $database->OpenCon();
    }

    public function addGenre($name) {

        $sql = "INSERT INTO genres(name) VALUES(?)";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "s", $name);

        return mysqli_stmt_execute($stmt);
    }

    public function getGenres() {

        $sql = "SELECT * FROM genres";

        return mysqli_query($this->conn, $sql);
    }

    public function deleteGenre($id) {

        $check = "SELECT * FROM books WHERE genre_id = ?";

        $stmt = mysqli_prepare($this->conn, $check);

        mysqli_stmt_bind_param($stmt, "i", $id);

        mysqli_stmt_execute($stmt);

        $result = mysqli_stmt_get_result($stmt);

        if(mysqli_num_rows($result) > 0) {

            return "Cannot delete genre";
        }

        $sql = "DELETE FROM genres WHERE id = ?";

        $stmt = mysqli_prepare($this->conn, $sql);

        mysqli_stmt_bind_param($stmt, "i", $id);

        return mysqli_stmt_execute($stmt);
    }
}
?>