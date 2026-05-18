<?php

header('Content-Type: application/json');

include '../config/database.php';

$database = new Database();
$conn = $database->OpenCon();

$book_id = $_GET['book_id'];

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

$result = mysqli_query($conn, $sql);

$data = mysqli_fetch_assoc($result);

echo json_encode($data);

?>