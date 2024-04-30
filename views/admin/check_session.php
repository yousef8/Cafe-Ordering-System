<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /Cafe-Ordering-System/views/admin/login.php");
    exit;
} else {

    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === true) {
        header("Location: /Cafe-Ordering-System/views/admin/home.php");
        exit;
    } else {
        header("Location: /Cafe-Ordering-System/views/user/home.php");
        exit;
    }
}
?>
