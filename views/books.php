<?php

require_once '../models/BookModel.php';

$model = new BookModel();

$books = $model->getBooks();
?>

<input type="text"
       id="search"
       placeholder="Search Book">

<br><br>

<table border="1">

<thead>
<tr>

<th>Title</th>
<th>Author</th>
<th>Genre</th>
<th>Total Copies</th>
<th>Available Copies</th>

</tr>
</thead>

<tbody id="bookTable">

<?php while($row = mysqli_fetch_assoc($books)) { ?>

<tr style="<?= ($row['available_copies']==0)
? 'background:red;color:white;'
: '' ?>">

<td><?= $row['title'] ?></td>
<td><?= $row['author'] ?></td>
<td><?= $row['genre_name'] ?></td>
<td><?= $row['total_copies'] ?></td>
<td><?= $row['available_copies'] ?></td>

</tr>

<?php } ?>

</tbody>

</table>

<script>

document.getElementById("search")
.addEventListener("keyup", function() {

    let q = this.value;

    fetch("/project/api/search_books.php?q=" + q)
    .then(response => response.json())

    .then(data => {

        let rows = "";

        data.forEach(book => {

            rows += `
            <tr>
            <td>${book.title}</td>
            <td>${book.author}</td>
            <td>${book.genre_name}</td>
            <td>${book.total_copies}</td>
            <td>${book.available_copies}</td>
            </tr>
            `;
        });

        document.getElementById("bookTable")
        .innerHTML = rows;
    });
});

</script>