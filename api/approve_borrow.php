<?php

header('Content-Type: application/json');

include 'config/database.php';

$id = $_POST['id'];

$sql = "
UPDATE borrow_records
SET status='Active'
WHERE id=?
";

$stmt = $conn->prepare($sql);

$stmt->execute([$id]);

echo json_encode([
    'success' => true
]);
?>