<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Sign Up</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>LIBRARY PORTAL</h2>
            <nav><a href="Login.php">Log In</a></nav>
        </header>
        <hr>
        
        <form action="../controllers/signupController.php" method="POST">
            <div class="container"><h1>Sign Up</h1></div>

            <div class="container">
                <label>Name</label><br>
                <input type="text" name="name" class="form_input">
                <span class="error"><?php if(isset($_SESSION['Name'])) { echo $_SESSION['Name']; unset($_SESSION['Name']); } ?></span>
            </div>

            <div class="container">
                <label>Email</label><br>
                <input type="email" name="email" class="form_input">
                <span class="error"><?php if(isset($_SESSION['Email'])) { echo $_SESSION['Email']; unset($_SESSION['Email']); } ?></span>
            </div>

            <div class="container">
                <label>Phone</label><br>
                <input type="text" name="phone" class="form_input">
                <span class="error"><?php if(isset($_SESSION['Phone'])) { echo $_SESSION['Phone']; unset($_SESSION['Phone']); } ?></span>
            </div>

            <div class="container">
                <label>Password</label><br>
                <input type="password" name="password" class="form_input">
                <span class="error"><?php if(isset($_SESSION['Password'])) { echo $_SESSION['Password']; unset($_SESSION['Password']); } ?></span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Sign Up</button>
            </div>
        </form>
    </div>
</body>
</html>