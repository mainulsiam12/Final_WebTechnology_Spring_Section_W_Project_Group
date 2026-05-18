<?php
include 'config/database.php';

$sql = "
SELECT borrow_records.id,
members.name AS member_name,
books.title,
borrow_records.borrow_date

FROM borrow_records

JOIN members
ON borrow_records.member_id = members.id

JOIN books
ON borrow_records.book_id = books.id

WHERE borrow_records.status='Pending'
";

$stmt = $conn->query($sql);

$requests = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>

<head>

    <title>Borrow Requests</title>

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
            text-align:left;
        }

        button{
            padding:6px 10px;
            margin-right:5px;
            cursor:pointer;
        }

    </style>

</head>

<body>

<h2>Pending Borrow Requests</h2>

<table>

<tr>
    <th>Member</th>
    <th>Book</th>
    <th>Date</th>
    <th>Action</th>
</tr>

<?php foreach($requests as $row): ?>

<tr id="row-<?php echo $row['id']; ?>">

    <td><?php echo $row['member_name']; ?></td>

    <td><?php echo $row['title']; ?></td>

    <td><?php echo $row['borrow_date']; ?></td>

    <td>

        <button onclick="approveBorrow(<?php echo $row['id']; ?>)">
            Approve
        </button>

        <button onclick="rejectBorrow(<?php echo $row['id']; ?>)">
            Reject
        </button>

    </td>

</tr>

<?php endforeach; ?>

</table>

<script>

function approveBorrow(id){

    fetch('approve_borrow.php',{

        method:'POST',

        headers:{
            'Content-Type':'application/x-www-form-urlencoded'
        },

        body:'id=' + id

    })

    .then(response => response.json())

    .then(data => {

        if(data.success){
            document.getElementById('row-' + id).remove();
        }

    });

}

function rejectBorrow(id){

    fetch('reject_borrow.php',{

        method:'POST',

        headers:{
            'Content-Type':'application/x-www-form-urlencoded'
        },

        body:'id=' + id

    })

    .then(response => response.json())

    .then(data => {

        if(data.success){
            document.getElementById('row-' + id).remove();
        }

    });

}

</script>

</body>
</html>