<?php

include '../../config/database.php';

$database = new Database();
$conn = $database->OpenCon();

$id = $_GET['id'];

$sql = "
SELECT *
FROM books
WHERE id='$id'
";

$result = mysqli_query($conn, $sql);

$book = mysqli_fetch_assoc($result);

?>

<!DOCTYPE html>
<html>

<head>

<title>Book Details</title>

<style>

body{
    font-family:Arial;
    padding:20px;
}

.card{
    border:1px solid #ccc;
    padding:20px;
    width:400px;
}

.available{
    color:green;
    font-weight:bold;
}

.unavailable{
    color:red;
    font-weight:bold;
}

</style>

</head>

<body>

<div class="card">

<h2><?php echo $book['title']; ?></h2>

<p>Author : <?php echo $book['author']; ?></p>

<p>ISBN : <?php echo $book['isbn']; ?></p>

<p id="badge"></p>

</div>

<script>

function loadAvailability(){

    fetch('../../api/availability.php?book_id=<?php echo $id; ?>')

    .then(res => res.json())

    .then(data => {

        let badge = document.getElementById('badge');

        if(data.available > 0){

            badge.innerHTML =
            '<span class=\"available\">Available</span>';

        }else{

            badge.innerHTML =
            '<span class=\"unavailable\">Unavailable</span>';

        }

    });

}

loadAvailability();

</script>

</body>
</html>