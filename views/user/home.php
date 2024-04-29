<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">

    <link rel="stylesheet" href="home.css">
    <title>Home</title>
</head>

<body>
    <?php require_once __DIR__ . '/user_navbar.php'; ?>
    <main class="d-flex min-vh-100">

        <!-- Sidebar -->
        <div class="w-25 p-4">
            <!-- Sidebar content -->
        </div>

        <!-- Products -->
        <div class="w-75 p-4">
            <h1 class="text-center p-3 brown">Products</h1>

            <form id="search-form" action="" method="GET" class="d-flex justify-content-center my-3">
                <input type="text" name="search" placeholder="Search products..." id="search-bar" class="form-control me-2 search-bar">
                <button type="submit" class="btn btn-custom">Search</button>
            </form>

            <div class="row gx-3 gy-3">
                <?php
                require_once __DIR__ . '/../../utilities/db_connection.php';
                require_once __DIR__ . '/../../controllers/productController.php';

                $productController = new ProductController($conn);

                if (isset($_GET['search'])) {
                    $keyword = $_GET['search'];
                    if (!empty($keyword)) {
                        $products = $productController->search($keyword);
                    } else {
                        $products = $productController->getAllProducts();
                    }
                } else {
                    $products = $productController->getAllProducts();
                }

                ?>
                <?php
                if (!$products)
                    return;
                foreach ($products as $product): ?>
                                    <div class="col-md-4">
                                        <div class="card">
                                            <img src=<?php echo $product['image_url']; ?> alt="Product Image" class="card-img-top">
                                            <div class="card-body">
                                                <h5 class="card-title"><?php echo $product['name']; ?></h5>
                                                <p class="card-text text-success">$<?php echo $product['price']; ?></p>
                                                <button id="add" class="btn btn-custom">Add</button>
                                            </div>
                                        </div>
                                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </main>

    <script>
        document.getElementById("product-header").addEventListener("click", function() {
            window.location.href = "home.php";
        });
    </script>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
