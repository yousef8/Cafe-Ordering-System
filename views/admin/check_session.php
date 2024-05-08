<?php
session_start();

if (!isset($_SESSION['user_id'])) {
    header("Location: /Cafe-Ordering-System/views/admin/login.php");
    exit;
} else {
    if (isset($_SESSION['is_admin']) && $_SESSION['is_admin'] === 1) {
        $requestedPage = $_SERVER['PHP_SELF'];
        $allowedAdminPages = array(
            //'/Cafe-Ordering-System/views/admin/dashboard.php',
            '/Cafe-Ordering-System/views/user/home.php',
            '/Cafe-Ordering-System/views/admin/user/get_users.php',
            '/Cafe-Ordering-System/views/admin/user/add_user.php',
            '/Cafe-Ordering-System/views/admin/user/update_user.php',
            '/Cafe-Ordering-System/views/admin/user/delete_user.php',
            '/Cafe-Ordering-System/views/admin/room/create.php',
            '/Cafe-Ordering-System/views/admin/room/delete.php',
            '/Cafe-Ordering-System/views/admin/room/update.php',
            '/Cafe-Ordering-System/views/admin/room/get.php',
            '/Cafe-Ordering-System/views/admin/products/get.php',
            '/Cafe-Ordering-System/views/admin/products/create.php',
            '/Cafe-Ordering-System/views/admin/products/update.php',
            '/Cafe-Ordering-System/views/admin/products/delete.php',
            '/Cafe-Ordering-System/views/admin/category/create.php',
            '/Cafe-Ordering-System/views/admin/category/get.php',
            '/Cafe-Ordering-System/views/admin/category/update.php',
            '/Cafe-Ordering-System/views/admin/category/delete.php',
            '/Cafe-Ordering-System/views/admin/orders/admin_orders.php',
            '/Cafe-Ordering-System/views/admin/orders/checks.php',
        );

        if (!in_array($requestedPage, $allowedAdminPages)) {
            header("Location: /Cafe-Ordering-System/views/user/home.php");
            exit;
        }
    } else {
        $requestedPage = $_SERVER['PHP_SELF'];
        $allowedUserPages = array(
            '/Cafe-Ordering-System/views/user/home.php',
            '/Cafe-Ordering-System/views/user/user_orders.php',

        );

        if (!in_array($requestedPage, $allowedUserPages)) {
            header("Location: /Cafe-Ordering-System/views/user/home.php");
            exit;
        }
    }
}
?>
