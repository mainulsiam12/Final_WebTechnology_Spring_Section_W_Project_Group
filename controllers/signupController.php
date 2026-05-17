<?php
session_start();
include_once ('../models/MemberModel.php');

function test_input($data) { return htmlspecialchars(stripslashes(trim($data))); }

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $name = isset($_POST['name']) ? test_input($_POST['name']) : '';
    $email = isset($_POST['email']) ? test_input($_POST['email']) : '';
    $phone = isset($_POST['phone']) ? test_input($_POST['phone']) : '';
    $password = isset($_POST['password']) ? test_input($_POST['password']) : '';

    $errors = false;
    if (empty($name)) { $_SESSION['Name'] = "Name is required"; $errors = true; }
    if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) { $_SESSION['Email'] = "Valid email required"; $errors = true; }
    if (empty($phone) || !is_numeric($phone)) { $_SESSION['Phone'] = "Phone must be numeric"; $errors = true; }
    if (empty($password) || strlen($password) < 8) { $_SESSION['Password'] = "Password must be at least 8 characters"; $errors = true; }

    if ($errors) {
        header("Location: ../views/Signup.php");
        exit();
    } else {
        $model = new MemberModel();
        if (!empty($model->userExistByEmail($email))) {
            $_SESSION['Email'] = "Email already registered";
            header("Location: ../views/Signup.php");
            exit();
        } else {
            $password_hash = password_hash($password, PASSWORD_DEFAULT);
            $model->createMember($name, $email, $password_hash, $phone);
            header("Location: ../views/Login.php");
            exit();
        }
    }
}
?>