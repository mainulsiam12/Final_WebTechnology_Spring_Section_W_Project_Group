<?php

include '../../config/database.php';
include '../../models/Borrow.php';

$database = new Database();
$conn = $database->OpenCon();

$borrow = new Borrow($conn);

$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$result = $borrow->activeLoans($search);

?>

<!DOCTYPE html>
<html>

<head>

<title>Return Books</title>

<style>

table{
    width:100%;
    border-collapse:collapse;
}

table,th,td{
    border:1px solid black;
}

th,td{
    padding:10px;
}

input{
    padding:8px;
}

button{
    padding:8px 12px;
}

</style>

</head>

<body>

<h2>Return Books</h2>

<form>

<input type="text"
name="search"
placeholder="Search">

<button>Search</button>

</form>

<br>

<table>

<tr>

<th>Member</th>
<th>Book</th>
<th>Due Date</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr>

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['due_date']; ?></td>

<td>

<a href="../../process_return.php?id=<?php echo $row['id']; ?>">

<button>Return</button>

</a>

</td>

</tr>

<?php } ?>

</table>

</body>
</html>