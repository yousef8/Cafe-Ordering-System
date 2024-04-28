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
    <h1>Products</h1>
    <div class="products-container">
        <?php
        require_once __DIR__ . '/../../utilities/db_connection.php';
        require_once __DIR__ . '/../../controllers/productController.php';

        $productController = new ProductController($conn);
        $products = $productController->getAllProducts();
        ?>
        <?php foreach ($products as $product) : ?>
            <div class="product">
                <img src="../../uploads-product/<?php echo $product['image_url']; ?>" alt="Product Image">
                <p class="name"><?php echo $product['name']; ?></p>
                <p class="price"><?php echo $product['price']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>