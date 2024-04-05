<?php
session_start();

if(!isset($_SESSION['loggedInStatus'])){

    $_SESSION['message'] = "Login to continue...";
    header('Location: login.php');
    exit();
}

$user_id = $_SESSION['user_id'];
?>
