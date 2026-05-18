<?php

require_once("../../config/Database.php");

$database = new Database();

$conn = $database->OpenCon();

$books_sql = "SELECT books.title,
COUNT(*) as total

FROM borrow_records

JOIN books
ON borrow_records.book_id = books.id

GROUP BY book_id
ORDER BY total DESC
LIMIT 10";

$books = mysqli_query($conn, $books_sql);

?>

<h2>Top Borrowed Books</h2>

<table border="1" cellpadding="10">

<tr>
<th>Book</th>
<th>Total Borrow</th>
</tr>

<?php while($row = mysqli_fetch_assoc($books)) { ?>

<tr>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['total']; ?></td>

</tr>

<?php } ?>

</table>