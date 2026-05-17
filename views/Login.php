<?php session_start(); ?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Library Login</title>
    <link rel="stylesheet" href="../CSS/style.css">
</head>
<body>
    <div class="main-content">
        <header>
            <h2>LIBRARY PORTAL</h2>
            <nav><a href="Signup.php">Sign Up</a></nav>
        </header>
        <hr>
        
        <form action="../controllers/loginController.php" method="POST">
            <div class="container">
                <h1>Log In</h1>
                <span class="error"><?php if (isset($_SESSION['loginError'])) { echo $_SESSION['loginError']; unset($_SESSION['loginError']); } ?></span>
            </div>

            <div class="container">
                <label>Email</label><br>
                <input type="email" name="email" class="form_input">
                <span class="error"><?php if (isset($_SESSION['Email'])) { echo $_SESSION['Email']; unset($_SESSION['Email']); } ?></span>
            </div>

            <div class="container">
                <label>Password</label><br>
                <input type="password" name="password" class="form_input">
                <span class="error"><?php if (isset($_SESSION['Password'])) { echo $_SESSION['Password']; unset($_SESSION['Password']); } ?></span>
            </div>

            <div class="form-group">
                <button type="submit" class="btn">Log In</button>
            </div>
        </form>
    </div>
</body>
</html>