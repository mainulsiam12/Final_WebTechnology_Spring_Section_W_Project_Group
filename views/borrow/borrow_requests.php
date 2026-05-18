<?php

include '../../config/database.php';
include '../../models/Borrow.php';

$database = new Database();
$conn = $database->OpenCon();

$borrow = new Borrow($conn);

$result = $borrow->pendingRequests();

?>

<!DOCTYPE html>
<html>

<head>

<title>Requests</title>

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

button{
    padding:6px 10px;
}

</style>

</head>

<body>

<h2>Pending Requests</h2>

<table>

<tr>

<th>Member</th>
<th>Book</th>
<th>Date</th>
<th>Action</th>

</tr>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<tr id="row<?php echo $row['id']; ?>">

<td><?php echo $row['name']; ?></td>

<td><?php echo $row['title']; ?></td>

<td><?php echo $row['borrow_date']; ?></td>

<td>

<button onclick="approve(<?php echo $row['id']; ?>)">
Approve
</button>

<button onclick="rejectBorrow(<?php echo $row['id']; ?>)">
Reject
</button>

</td>

</tr>

<?php } ?>

</table>

<script>

function approve(id){

    fetch('../../api/approve.php',{

        method:'POST',

        headers:{
            'Content-Type':'application/x-www-form-urlencoded'
        },

        body:'id=' + id

    })

    .then(res => res.json())

    .then(data => {

        if(data.success){

            document.getElementById('row'+id).remove();

        }

    });

}

function rejectBorrow(id){

    fetch('../../api/reject.php',{

        method:'POST',

        headers:{
            'Content-Type':'application/x-www-form-urlencoded'
        },

        body:'id=' + id

    })

    .then(res => res.json())

    .then(data => {

        if(data.success){

            document.getElementById('row'+id).remove();

        }

    });

}

</script>

</body>
</html>