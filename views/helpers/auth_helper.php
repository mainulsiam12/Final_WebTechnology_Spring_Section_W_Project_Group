<?php

session_start();

function auth_check($role){

    if(!isset($_SESSION['member_id'])){

        header("Location: login.php");
        exit();

    }

    if($_SESSION['role'] != $role){

        echo "Access Denied";
        exit();

    }

}
?>