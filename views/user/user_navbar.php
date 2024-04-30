<?php
session_start();

if (isset($_SESSION['user_id']) && isset($_SESSION['first_name']) && isset($_SESSION['image_url'])) {
    $userName = $_SESSION['first_name'];
    $userImageUrl = $_SESSION['image_url'];
    $imageUrl = "../../uploads-user/" ;
    $loggedIn = true;
} else {
    $loggedIn = false;
}

$userLinks = array(
    'Home' => '/Cafe-Ordering-System/views/user/home.php',
    'MyOrders' => '#',
);

$adminLinks = array(
    'Products' => '/Cafe-Ordering-System/views/admin/products/get.php',
    'Categories' => '/Cafe-Ordering-System/views/admin/category/get.php',
    'Rooms' => '/Cafe-Ordering-System/views/admin/room/get.php',
    'Users' => '/Cafe-Ordering-System/views/admin/user/get_users.php',
    'Manual Orders' => '/Cafe-Ordering-System/views/admin/orders/admin_orders.php',
    'Checks' => '/Cafe-Ordering-System/views/admin/orders/checks.php',
);

$is_admin = isset($_SESSION['is_admin']) && $_SESSION['is_admin'] == 1;

$links = $is_admin ? $adminLinks : $userLinks;

?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Cafe</title>
</head>
<body>

<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand">The Cafe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                <?php
                foreach ($links as $title => $url) {
                    echo "<li class='nav-item'><a class='nav-link' href=\"$url\">$title</a></li>";
                }
                ?>
            </ul>
            <?php if ($loggedIn): ?>
                <ul class="navbar-nav mb-2 mb-lg-0">
                    <li class="nav-item">
                        <a class="nav-link" href="user.php">
                            <?php if (!empty($userImageUrl)): ?>
                                
                                <?php  ?>
                                <img class="rounded-circle" src= <?php echo  "../../uploads-user/" . $userImageUrl; ?> alt="User Photo" style="width: 40px; height: 40px;">
                            <?php else: ?>
                                <img src="https://vectorified.com/images/no-profile-picture-icon-14.png">
                            <?php endif; ?>
                                <?php echo $userName; ?>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link" href="/Cafe-Ordering-System/views/admin/login.php">Logout</a>
                    </li>
                </ul>
            <?php endif; ?>
        </div>
    </div>
</nav>

</body>
</html>
