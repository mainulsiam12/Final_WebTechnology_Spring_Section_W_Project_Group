<?php
function auth_check($required_role = null) {
    if (!isset($_SESSION['member_id'])) {
        header("Location: ../views/Login.php");
        exit();
    }
    if ($required_role !== null && $_SESSION['role'] !== $required_role) {
        if ($_SESSION['role'] == 'member') { header("Location: ../views/Member/Dashboard.php"); } 
        elseif ($_SESSION['role'] == 'librarian') { header("Location: ../views/Librarian/Dashboard.php"); } 
        elseif ($_SESSION['role'] == 'admin') { header("Location: ../views/Admin/Dashboard.php"); }
        exit();
    }
}
?>