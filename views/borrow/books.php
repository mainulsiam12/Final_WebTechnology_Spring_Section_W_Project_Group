<?php

session_start();

include '../../config/database.php';

$database = new Database();
$conn = $database->OpenCon();

$sql = "
SELECT books.*,
(
books.total_copies -
COUNT(CASE WHEN borrow_records.status='Active' THEN 1 END)
) AS available

FROM books

LEFT JOIN borrow_records
ON books.id = borrow_records.book_id

GROUP BY books.id
";

$result = mysqli_query($conn, $sql);
?>

<!DOCTYPE html>
<html>

<head>

<title>Books</title>

<style>

body{
    font-family:Arial;
    padding:20px;
}

.book{
    border:1px solid #ccc;
    padding:15px;
    margin-bottom:15px;
}

.available{
    color:green;
}

.unavailable{
    color:red;
}

button{
    padding:8px 12px;
}

</style>

</head>

<body>

<h2>Books</h2>

<?php while($row = mysqli_fetch_assoc($result)){ ?>

<div class="book">

    <h3><?php echo $row['title']; ?></h3>

    <p>Author : <?php echo $row['author']; ?></p>

    <p>

        Available :

        <?php if($row['available'] > 0){ ?>

            <span class="available">
                <?php echo $row['available']; ?>
            </span>

            <br><br>

            <a href="../../borrow_book.php?book_id=<?php echo $row['id']; ?>">

                <button>Borrow</button>

            </a>

        <?php } else { ?>

            <span class="unavailable">
                Unavailable
            </span>

        <?php } ?>

    </p>

</div>

<?php } ?>

</body>
</html>