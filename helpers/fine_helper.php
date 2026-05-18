<?php

require_once(__DIR__ . "/../config/Database.php");

function generate_fines() {

    $database = new Database();

    $conn = $database->OpenCon();

    $sql = "SELECT * FROM borrow_records
            WHERE status='Active'
            AND due_date < NOW()";

    $result = mysqli_query($conn, $sql);

    while($row = mysqli_fetch_assoc($result)) {

        $borrow_id = $row['id'];

        $member_id = $row['member_id'];

        $due_date = $row['due_date'];

        $today = new DateTime();

        $due = new DateTime($due_date);

        $days = $due->diff($today)->days;

        $amount = $days * 5;

        $check = "SELECT * FROM fines
                  WHERE borrow_record_id='$borrow_id'";

        $check_result = mysqli_query($conn, $check);

        if(mysqli_num_rows($check_result) > 0) {

            $update = "UPDATE fines
                       SET amount='$amount'
                       WHERE borrow_record_id='$borrow_id'";

            mysqli_query($conn, $update);

        } else {

            $insert = "INSERT INTO fines
            (borrow_record_id, member_id, amount)

            VALUES

            ('$borrow_id', '$member_id', '$amount')";

            mysqli_query($conn, $insert);
        }
    }
}

?>