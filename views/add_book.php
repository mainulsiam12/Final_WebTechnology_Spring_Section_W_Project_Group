<?php

require_once '../models/BookModel.php';
require_once '../models/GenreModel.php';

$bookModel = new BookModel();
$genreModel = new GenreModel();

$genres = $genreModel->getGenres();

if(isset($_POST['add'])) {

    $isbn = $_POST['isbn'];

    if(!preg_match('/^(\\d{10}|\\d{13})$/', $isbn)) {

        echo "Invalid ISBN";

    } else {

        $data = [

            'genre_id' => $_POST['genre_id'],
            'title' => $_POST['title'],
            'author' => $_POST['author'],
            'isbn' => $_POST['isbn'],
            'total_copies' => $_POST['total_copies'],
            'shelf_location' => $_POST['shelf_location'],
            'published_year' => $_POST['published_year']
        ];

        $bookModel->addBook($data);

        echo "Book Added Successfully";
    }
}
?>

<form method="POST">

    <input type="text"
           name="title"
           placeholder="Book Title">

    <br><br>

    <input type="text"
           name="author"
           placeholder="Author Name">

    <br><br>

    <input type="text"
           name="isbn"
           placeholder="ISBN">

    <br><br>

    <select name="genre_id">

        <?php while($row = mysqli_fetch_assoc($genres)) { ?>

        <option value="<?= $row['id'] ?>">
            <?= $row['name'] ?>
        </option>

        <?php } ?>

    </select>

    <br><br>

    <input type="number"
           name="total_copies"
           placeholder="Total Copies">

    <br><br>

    <input type="text"
           name="shelf_location"
           placeholder="Shelf Location">

    <br><br>

    <input type="number"
           name="published_year"
           placeholder="Published Year">

    <br><br>

    <button name="add">
        Add Book
    </button>

</form>