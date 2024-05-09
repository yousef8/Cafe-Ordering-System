<?php
require_once __DIR__ . '/../admin/check_session.php';

if (isset($_SESSION['user_id']) && isset($_SESSION['first_name']) && isset($_SESSION['image_url'])) {
    $userName = $_SESSION['first_name'];
    $userImageUrl = $_SESSION['image_url'];
    $imageUrl = "../../uploads-user/";
    $loggedIn = true;
} else {
    $loggedIn = false;
}

$userLinks = array(
    'The Cafe' => '/Cafe-Ordering-System/views/user/home.php',
    'Home' => '/Cafe-Ordering-System/views/user/home.php',
    'MyOrders' => '/Cafe-Ordering-System/views/user/user_orders.php',
);

$adminLinks = array(
    'The Cafe' => '/Cafe-Ordering-System/views/user/home.php',
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
    <style>
        .active-link {
            color: black !important;
        }

        .navbar {
            background-color: brown !important;
        }


        .navbar-nav .nav-link {
            font-weight: 900;
            color: white;
        }


        .navbar-nav .nav-link:hover {

            opacity: 0.8;
        }


        .dropdown-menu .dropdown-item {
            color: white;
        }


        .dropdown-menu .dropdown-item:hover {
            background-color: brown;
            color: white;
        }


        .navbar-brand {
            color: white;
        }

        .navbar-brand:hover {
            opacity: 0.8;
        }


        .navbar-toggler-icon {
            background-color: white;
        }
    </style>

    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>The Cafe</title>
</head>

<body>

    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <!-- <a class="navbar-brand" href="/Cafe-Ordering-System/views/user/home.php">The Cafe</a> -->
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
                <?php if ($loggedIn) : ?>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item dropdown">
                            <a class="nav-link dropdown-toggle" href="#" id="navbarDropdown" role="button" data-bs-toggle="dropdown" aria-expanded="false">
                                <?php if (!empty($userImageUrl)) : ?>
                                    <img class="rounded-circle" src="/Cafe-Ordering-System/uploads-user/<?php echo $userImageUrl; ?>" alt="User Photo" style="width: 40px; height: 40px;">
                                <?php else : ?>
                                    <img src="https://vectorified.com/images/no-profile-picture-icon-14.png">
                                <?php endif; ?>
                                <?php echo $userName; ?>
                            </a>
                            <ul class="dropdown-menu" aria-labelledby="navbarDropdown">
                                <li><a style="color:black;" class="dropdown-item" href="/Cafe-Ordering-System/views/admin/logout.php">Logout</a></li>
                            </ul>
                        </li>
                    </ul>
                <?php endif; ?>
                <?php if (!$loggedIn) : ?>
                    <ul class="navbar-nav mb-2 mb-lg-0">
                        <li class="nav-item">
                            <a class="nav-link" href="../admin/login.php">Login</a>
                        </li>
                    </ul>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <script>
        document.addEventListener("DOMContentLoaded", function() {
            var currentUrl = window.location.pathname;
            var links = document.querySelectorAll('.nav-link');

            links.forEach(function(link) {
                if (link.getAttribute('href') === currentUrl) {
                    console.log(currentUrl, " ", link.getAttribute('href'))
                    link.classList.add('active-link');
                }
            });
        });
    </script>


</body>

</html>