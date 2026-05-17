<?php
    session_start();
    include_once('../../controllers/auth_helper.php');
    auth_check('member'); 
    include_once('../../models/MemberModel.php');
    
    $model = new MemberModel();
    $user = $model->getUserById($_SESSION['member_id']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>Member Dashboard</title>
    <link rel="stylesheet" href="../../CSS/style.css"> 
</head>
<body>
    <div class="main-content">
        <header>
            <h2>Member Dashboard - Welcome <?php echo $_SESSION['name']; ?></h2>
            <nav><a href="../../controllers/logout.php">Log Out</a></nav>
        </header>
        <hr>
        
        <div class="container" style="margin: 20px;">
            <h3>Your Overview</h3>
            <ul>
                <li>Active Loans: <strong>0</strong></li>
                <li>Upcoming Due Dates: <strong>0</strong></li>
                <li>Outstanding Fines: <strong>0</strong></li>
            </ul>
        </div>

        <div class="profile-container" style="margin: 20px;">
            <h3>Edit Profile</h3>
            <span class="success"><?php if (isset($_SESSION['success'])) { echo $_SESSION['success']; unset($_SESSION['success']); } ?></span>
            
            <form action="../../controllers/profileController.php" method="POST">
                <label>Name</label><br>
                <input type="text" name="name" class="form_input" value="<?php echo $user['name']; ?>">
                <span class="error"><?php if(isset($_SESSION['Name'])) { echo $_SESSION['Name']; unset($_SESSION['Name']); } ?></span><br>

                <label>Email</label><br>
                <input type="email" name="email" class="form_input" value="<?php echo $user['email']; ?>">
                <span class="error"><?php if(isset($_SESSION['Email'])) { echo $_SESSION['Email']; unset($_SESSION['Email']); } ?></span><br>

                <label>Phone</label><br>
                <input type="text" name="phone" class="form_input" value="<?php echo $user['phone']; ?>">
                <span class="error"><?php if(isset($_SESSION['Phone'])) { echo $_SESSION['Phone']; unset($_SESSION['Phone']); } ?></span><br>

                <button type="submit" name="action" value="update_info" class="btn">Update Info</button>
            </form>

            <hr style="margin: 20px 0;">

            <h3>Change Password</h3>
            <form action="../../controllers/profileController.php" method="POST">
                <span class="error"><?php if(isset($_SESSION['PassError'])) { echo $_SESSION['PassError']; unset($_SESSION['PassError']); } ?></span><br>
                
                <label>Current Password</label><br>
                <input type="password" name="current_password" class="form_input"><br>

                <label>New Password</label><br>
                <input type="password" name="new_password" class="form_input"><br>

                <button type="submit" name="action" value="update_password" class="btn">Change Password</button>
            </form>
        </div>
    </div>
</body>
</html>