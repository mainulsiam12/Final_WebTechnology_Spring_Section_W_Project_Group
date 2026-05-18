<?php
session_start();

require_once("../../config/Database.php");
require_once("../../helpers/fine_helper.php");

generate_fines();

$database = new Database();

$conn = $database->OpenCon();

$member_id = 3;

$sql = "SELECT fines.*,
        books.title,
        borrow_records.due_date,
        borrow_records.return_date

        FROM fines

        JOIN borrow_records
        ON fines.borrow_record_id = borrow_records.id

        JOIN books
        ON borrow_records.book_id = books.id

        WHERE fines.member_id='$member_id'
        AND fines.is_paid=0";

$result = mysqli_query($conn, $sql);

$total = 0;
?>

<h2>My Fines</h2>

<table border="1" cellpadding="10">

<tr>
<th>Book</th>
<th>Due Date</th>
<th>Return Date</th>
<th>Days</th>
<th>Amount</th>
</tr>

<?php

while($row = mysqli_fetch_assoc($result)) {

$total += $row['amount'];

$due = new DateTime($row['due_date']);

$today = new DateTime();

$days = $due->diff($today)->days;

?>

<tr>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['due_date']; ?></td>

<td>

<?php

if($row['return_date']) {

echo $row['return_date'];

} else {

echo "Not Returned";
}

?>

</td>

<td><?php echo $days; ?></td>

<td><?php echo $row['amount']; ?></td>

</tr>

<?php } ?>

</table>

<h3>Total Fine:
<?php echo $total; ?>
</h3>