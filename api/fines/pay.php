<?php

header("Content-Type: application/json");

require_once("../../config/Database.php");

$database = new Database();

$conn = $database->OpenCon();

$fine_id = $_POST['fine_id'];

$sql = "UPDATE fines
        SET is_paid=1
        WHERE id='$fine_id'";

if(mysqli_query($conn, $sql)) {

    echo json_encode([
        "success" => true
    ]);

} else {

    echo json_encode([
        "success" => false
    ]);
}
?>