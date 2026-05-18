<?php

require_once '../models/GenreModel.php';

$model = new GenreModel();

if(isset($_GET['delete'])) {

    $id = $_GET['delete'];

    $message = $model->deleteGenre($id);

    echo $message;
}

$genres = $model->getGenres();
?>

<table border="1">

<tr>
    <th>ID</th>
    <th>Name</th>
    <th>Action</th>
</tr>

<?php while($row = mysqli_fetch_assoc($genres)) { ?>

<tr>

<td><?= $row['id'] ?></td>
<td><?= $row['name'] ?></td>

<td>
<a href="genres.php?delete=<?= $row['id'] ?>">
Delete
</a>
</td>

</tr>

<?php } ?>

</table>