<?php

require_once '../models/GenreModel.php';

$model = new GenreModel();

if(isset($_POST['add'])) {

    $name = trim($_POST['name']);

    if(empty($name)) {

        echo "Genre name required";

    } else {

        $model->addGenre($name);

        echo "Genre Added Successfully";
    }
}
?>

<form method="POST">

    <input type="text"
           name="name"
           placeholder="Genre Name">

    <button name="add">
        Add Genre
    </button>

</form>