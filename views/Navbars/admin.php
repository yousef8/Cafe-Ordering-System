<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <style>
        nav {
            background-color: #333;
            color: #fff;
            padding: 10px;
            display: flex;
            justify-content: space-between;
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
            display: flex;
        }

        nav ul li {
            margin-right: 20px;
        }

        nav ul li a {
            color: #fff;
            text-decoration: none;
        }

        .fa-admin {
            font-size: 1.2em;
            margin-right: 5px;
        }
    </style>
</head>
<body>
    <nav>
        <ul>
            <?php
            $links = array(
                'Home' => 'home.php',
                'Products' => 'products.php',
                'Users' => 'users.php',
                'Manual Orders' => 'manual_orders.php',
                'Checks' => 'checks.php',
            );

            foreach ($links as $title => $url) {
                echo "<li><a href=\"$url\">$title</a></li>";
            }
            ?>
        </ul>
        <ul>
            <li><a href="admin.php"><i class="fas fa-user-cog fa-admin"></i>Admin</a></li>
        </ul>
    </nav>
</body>
</html>