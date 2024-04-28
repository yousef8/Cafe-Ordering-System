    <nav class="navbar navbar-expand-lg bg-body-tertiary">
        <div class="container-fluid">
            <a class="navbar-brand" href="../user/home.php">The Cafe</a>
            <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
                <span class="navbar-toggler-icon"></span>
            </button>
            <div class="collapse navbar-collapse" id="navbarSupportedContent">
                <ul class="navbar-nav me-auto mb-2 mb-lg-0">
                    <?php
                    $links = array(
                        'Home' => 'home.php',
                        'Products' => 'products.php',
                        'Users' => 'users.php',
                        'Manual Orders' => 'manual_orders.php',
                        'Checks' => 'checks.php',
                    );

                    foreach ($links as $title => $url) {
                        echo "<li class='nav-item'><a class='nav-link' href=\"$url\">$title</a></li>";
                    }
                    ?>
                </ul>
                <ul class="navbar-nav  mb-2 mb-lg-0">
                    <li class="nav-item"><a class="nav-link" href="admin.php"><i class="fas fa-user-cog fa-admin"></i> Admin</a></li>
                </ul>
            </div>
        </div>
    </nav>