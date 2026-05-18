<?php

header('Content-Type: application/json');

include '../../config/database.php';

$book_id = $_GET['book_id'];

$sql = "
SELECT books.total_copies,
COUNT(CASE WHEN borrow_records.status='Active' THEN 1 END) AS active_count

FROM books

LEFT JOIN borrow_records
ON books.id = borrow_records.book_id

WHERE books.id=?

GROUP BY books.id
";

$stmt = $conn->prepare($sql);

$stmt->execute([$book_id]);

$data = $stmt->fetch(PDO::FETCH_ASSOC);

$available = $data['total_copies'] - $data['active_count'];

echo json_encode([
    'available_copies' => $available
]);
?>