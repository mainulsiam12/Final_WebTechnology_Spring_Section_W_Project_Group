<?php

include 'controllers/BorrowController.php';

$id = $_GET['id'];

$borrow = new BorrowController();

$borrow->returnBook($id);

?>