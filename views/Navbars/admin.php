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
        }

        nav ul {
            list-style-type: none;
            padding: 0;
            margin: 0;
        }

        nav ul li {
            display: inline;
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
                'Admin' => 'admin.php'
            );

            foreach ($links as $title => $url) {
                if ($title == 'Admin') {
                    echo "<li><a href=\"$url\"><i class=\"fas fa-user-cog fa-admin\"></i>$title</a></li>";
                } else {
                    echo "<li><a href=\"$url\">$title</a></li>";
                }
            }
            ?>
        </ul>
    </nav>
</body>
</html>
