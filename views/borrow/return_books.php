<?php
include 'config/database.php';

$search = "";

if(isset($_GET['search'])){
    $search = $_GET['search'];
}

$sql = "
SELECT borrow_records.id,
members.name AS member_name,
books.title,
borrow_records.borrow_date,
borrow_records.due_date

FROM borrow_records

JOIN members
ON borrow_records.member_id = members.id

JOIN books
ON borrow_records.book_id = books.id

WHERE borrow_records.status='Active'
AND (
    members.name LIKE ?
    OR books.title LIKE ?
)
";

$stmt = $conn->prepare($sql);

$stmt->execute([
    "%$search%",
    "%$search%"
]);

$records = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Return Books</title>

    <style>

        body{
            font-family:Arial;
            padding:20px;
        }

        table{
            width:100%;
            border-collapse:collapse;
        }

        table, th, td{
            border:1px solid #ccc;
        }

        th, td{
            padding:10px;
        }

        input{
            padding:8px;
            width:300px;
        }

        button{
            padding:8px 12px;
            cursor:pointer;
        }

    </style>

</head>

<body>

<h2>Return Books</h2>

<form method="GET">

    <input type="text"
           name="search"
           placeholder="Search member or book"
           value="<?php echo $search; ?>">

    <button type="submit">Search</button>

</form>

<br>

<table>

<tr>
    <th>Member</th>
    <th>Book</th>
    <th>Borrow Date</th>
    <th>Due Date</th>
    <th>Action</th>
</tr>

<?php foreach($records as $row): ?>

<tr>

    <td><?php echo $row['member_name']; ?></td>

    <td><?php echo $row['title']; ?></td>

    <td><?php echo $row['borrow_date']; ?></td>

    <td><?php echo $row['due_date']; ?></td>

    <td>

        <a href="process_return.php?id=<?php echo $row['id']; ?>">
            <button>Process Return</button>
        </a>

    </td>

</tr>

<?php endforeach; ?>

</table>

</body>
</html>