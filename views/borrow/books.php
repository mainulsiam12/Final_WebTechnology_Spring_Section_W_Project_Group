<?php
session_start();
include 'config/database.php';

$sql = "SELECT books.*,
(
    books.total_copies -
    COUNT(CASE WHEN borrow_records.status='Active' THEN 1 END)
) AS available_copies

FROM books

LEFT JOIN borrow_records
ON books.id = borrow_records.book_id

GROUP BY books.id";

$stmt = $conn->query($sql);
$books = $stmt->fetchAll(PDO::FETCH_ASSOC);
?>

<!DOCTYPE html>
<html>
<head>
    <title>Books</title>

    <style>

        body{
            font-family: Arial;
            padding:20px;
        }

        .book-card{
            border:1px solid #ccc;
            padding:15px;
            margin-bottom:15px;
        }

        .available{
            color:green;
            font-weight:bold;
        }

        .unavailable{
            color:red;
            font-weight:bold;
        }

        button{
            padding:8px 12px;
            cursor:pointer;
        }

    </style>
</head>

<body>

<h2>Book List</h2>

<?php foreach($books as $book): ?>

<div class="book-card">

    <h3><?php echo $book['title']; ?></h3>

    <p>Author: <?php echo $book['author']; ?></p>

    <p>
        Available Copies:

        <?php if($book['available_copies'] > 0): ?>

            <span class="available">
                <?php echo $book['available_copies']; ?>
            </span>

        <?php else: ?>

            <span class="unavailable">
                Unavailable
            </span>

        <?php endif; ?>
    </p>

    <?php if($book['available_copies'] > 0): ?>

        <a href="borrow_book.php?book_id=<?php echo $book['id']; ?>">
            <button>Borrow</button>
        </a>

    <?php endif; ?>

</div>

<?php endforeach; ?>

</body>
</html>