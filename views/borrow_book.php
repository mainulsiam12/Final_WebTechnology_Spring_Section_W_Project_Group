<?php

session_start();

include 'controllers/BorrowController.php';

$member_id = $_SESSION['member_id'];
$book_id = $_GET['book_id'];

$borrow = new BorrowController();

$borrow->borrowBook($member_id, $book_id);

?>