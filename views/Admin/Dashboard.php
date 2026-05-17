<?php
    session_start();
    include_once('../../controllers/auth_helper.php');
    auth_check('admin'); 
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Admin Panel</title>
    <link rel="stylesheet" href="../../CSS/style.css"> 
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Admin Panel - <?php echo $_SESSION['name']; ?></h2>
            <nav><a href="../../controllers/logout.php">Log Out</a></nav>
        </header>
        <hr>
        <div class="container" style="margin: 20px;">
            <p>Admin tools go here.</p>
        </div>
    </div>
</body>
</html>