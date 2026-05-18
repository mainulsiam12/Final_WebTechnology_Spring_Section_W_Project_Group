<?php

header('Content-Type: application/json');

include 'config/database.php';

$id = $_POST['id'];

$sql = "DELETE FROM borrow_records WHERE id=?";

$stmt = $conn->prepare($sql);

$stmt->execute([$id]);

echo json_encode([
    'success' => true
]);
?>