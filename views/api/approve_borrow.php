<?php

include '../controllers/BorrowController.php';

$id = $_POST['id'];

$borrow = new BorrowController();

$borrow->approveBorrow($id);

?>