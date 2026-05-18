<?php
session_start();
include_once('../models/MemberModel.php');
include_once('auth_helper.php');
auth_check(); 

$model = new MemberModel();
$userId = $_SESSION['member_id'];
$user = $model->getUserById($userId);

function test_input($data) { return htmlspecialchars(stripslashes(trim($data))); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if (isset($_POST['action']) && $_POST['action'] === "update_info") {
        $name = isset($_POST['name']) ? test_input($_POST['name']) : '';
        $email = isset($_POST['email']) ? test_input($_POST['email']) : '';
        $phone = isset($_POST['phone']) ? test_input($_POST['phone']) : '';

        $errors = false;
        if (empty($name)) { $_SESSION['Name'] = "Name required"; $errors = true; }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $_SESSION['Email'] = "Valid email required"; $errors = true; }
        if (empty($phone) || !is_numeric($phone)) { $_SESSION['Phone'] = "Numeric phone required"; $errors = true; }

        $existing = $model->userExistByEmail($email);
        if (!empty($existing) && $existing[0]['id'] != $userId) {
            $_SESSION['Email'] = "Email already in use"; $errors = true;
        }

        if ($errors) {
            header("Location: ../views/member/Dashboard.php");
            exit();
        }

        $model->updateProfile($userId, $name, $email, $phone);
        $_SESSION['name'] = $name; 
        $_SESSION['success'] = "Profile updated.";
        header("Location: ../views/member/Dashboard.php");
        exit();
    }

    if (isset($_POST['action']) && $_POST['action'] === "update_password") {
        $current_password = isset($_POST['current_password']) ? test_input($_POST['current_password']) : '';
        $new_password = isset($_POST['new_password']) ? test_input($_POST['new_password']) : '';
        
        if (!password_verify($current_password, $user['password_hash'])) {
            $_SESSION['PassError'] = "Current password incorrect";
            header("Location: ../views/member/Dashboard.php");
            exit();
        }

        if (strlen($new_password) < 8) {
            $_SESSION['PassError'] = "New password must be >= 8 chars";
            header("Location: ../views/member/Dashboard.php");
            exit();
        }

        $model->updatePassword($userId, password_hash($new_password, PASSWORD_DEFAULT));
        $_SESSION['success'] = "Password changed.";
        header("Location: ../views/member/Dashboard.php");
        exit();
    }
}
?>