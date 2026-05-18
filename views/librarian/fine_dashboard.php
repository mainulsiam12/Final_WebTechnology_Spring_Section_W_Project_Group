<?php

require_once("../../config/Database.php");
require_once("../../helpers/fine_helper.php");

generate_fines();

$database = new Database();

$conn = $database->OpenCon();

$search = "";

if(isset($_GET['search'])) {
    $search = $_GET['search'];
}

$sql = "SELECT fines.id,
        fines.amount,
        members.name,
        books.title

        FROM fines

        JOIN members
        ON fines.member_id = members.id

        JOIN borrow_records
        ON fines.borrow_record_id = borrow_records.id

        JOIN books
        ON borrow_records.book_id = books.id

        WHERE fines.is_paid=0
        AND members.name LIKE '%$search%'";

$result = mysqli_query($conn, $sql);

?>

<h2>Fine Dashboard</h2>

<form>

<input type="text"
name="search"
placeholder="Search Member">

<button type="submit">
Search
</button>

</form>

<table border="1" cellpadding="10">

<tr>

<th>Member</th>
<th>Book</th>
<th>Amount</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)) { ?>

<tr id="row-<?php echo $row['id']; ?>">

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['amount']; ?></td>

<td>

<button onclick="payFine(<?php echo $row['id']; ?>)">
Mark Paid
</button>

</td>

</tr>

<?php } ?>

</table>

<script src="../../assets/js/fine.js"></script>