<?php
    session_start();
    include_once('../../controllers/auth_helper.php');
    auth_check('librarian'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Librarian Panel</title>
    <link rel="stylesheet" href="../../CSS/style.css"> 
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Librarian Panel - <?php echo $_SESSION['name']; ?></h2>
            <nav><a href="../../controllers/logout.php">Log Out</a></nav>
        </header>
        <hr>
        <div class="container" style="margin: 20px;">
            <p>Book Catalog Management goes here.</p>
        </div>
    </div>
</body>
</html>