<?php
session_start();
include_once ('../models/MemberModel.php');

function test_input($data) { return htmlspecialchars(stripslashes(trim($data))); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = isset($_POST['email']) ? test_input($_POST['email']) : '';
    $password = isset($_POST['password']) ? test_input($_POST['password']) : '';

    $errors = false;
    if (empty($email)) { $_SESSION['Email'] = "Email required"; $errors = true; }
    if (empty($password)) { $_SESSION['Password'] = "Password required"; $errors = true; }

    if ($errors) {
        header("Location: ../views/Login.php");
        exit();
    } else {
        $model = new MemberModel();
        $user = $model->getUserByEmail($email);

        if (empty($user) || !password_verify($password, $user['password_hash'])) {
            $_SESSION['loginError'] = "Invalid email or password";
            header("Location: ../views/Login.php");
            exit();
        } else {
            $_SESSION['member_id'] = $user['id'];
            $_SESSION['name'] = $user['name'];
            $_SESSION['role'] = $user['role'];
            
            if ($user['role'] == "member") header("Location: ../views/member/Dashboard.php");
            elseif ($user['role'] == "librarian") header("Location: ../views/librarian/Dashboard.php");
            elseif ($user['role'] == "admin") header("Location: ../views/admin/Dashboard.php");
            exit();
        }
    }
}
?>