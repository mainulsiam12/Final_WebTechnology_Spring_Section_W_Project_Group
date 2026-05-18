<?php

include 'config/database.php';

$id = $_GET['id'];

$sql = "
UPDATE borrow_records
SET status='Returned',
return_date=NOW()
WHERE id=?
";

$stmt = $conn->prepare($sql);

$stmt->execute([$id]);

echo "Book Returned Successfully";
?>