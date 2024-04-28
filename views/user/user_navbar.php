<nav class="navbar navbar-expand-lg bg-body-tertiary">
    <div class="container-fluid">
        <a class="navbar-brand" href="/Cafe-Ordering-System/home.php">The Cafe</a>
        <button class="navbar-toggler" type="button" data-bs-toggle="collapse" data-bs-target="#navbarSupportedContent" aria-controls="navbarSupportedContent" aria-expanded="false" aria-label="Toggle navigation">
            <span class="navbar-toggler-icon"></span>
        </button>
        <div class="collapse navbar-collapse" id="navbarSupportedContent">
            <ul class="navbar-nav me-auto mb-2 mb-lg-0">

                <?php
                $links = array(
                    'Home' => '/Cafe-Ordering-System/home.php',
                    'MyOrders' => '#',
                );

                foreach ($links as $title => $url) {
                    echo "<li class='nav-item'><a class='nav-link' href=\"$url\">$title</a></li>";
                }
                ?>
            </ul>
            <ul class="navbar-nav  mb-2 mb-lg-0">
                <li class="nav-item"><a class="nav-link" href="user.php"><i class="fas fa-user fa-user"></i> UserName</a></li>
            </ul>
        </div>
    </div>
</nav>