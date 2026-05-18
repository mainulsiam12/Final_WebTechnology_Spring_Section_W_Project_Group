<?php
session_start();
include 'config/database.php';

$member_id = $_SESSION['member_id'];
$book_id = $_GET['book_id'];

$check_sql = "
SELECT books.total_copies,
COUNT(CASE WHEN borrow_records.status='Active' THEN 1 END) AS active_count

FROM books

LEFT JOIN borrow_records
ON books.id = borrow_records.book_id

WHERE books.id=?

GROUP BY books.id
";

$check = $conn->prepare($check_sql);
$check->execute([$book_id]);

$data = $check->fetch(PDO::FETCH_ASSOC);

$available = $data['total_copies'] - $data['active_count'];

if($available <= 0){
    die("No copies available");
}

$sql = "
INSERT INTO borrow_records
(member_id, book_id, status, borrow_date, due_date)

VALUES
(?, ?, 'Pending', CURDATE(), DATE_ADD(CURDATE(), INTERVAL 14 DAY))
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    $member_id,
    $book_id
]);

echo "Borrow Request Sent";
?>