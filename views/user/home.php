<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Home</title>
    <link rel="stylesheet" href="home.css">
</head>
<body>
    <h1>Products</h1>
    <div class="products-container">
        <?php
        require_once __DIR__ . '/../../utilities/db_connection.php';
        require_once __DIR__ . '/../../controllers/productController.php';

        $productController = new ProductController($conn);
        $products = $productController->getAllProducts();
        ?>
        <?php foreach ($products as $product): ?>
            <div class="product">
                <img src="../../uploads-product/<?php echo $product['image_url']; ?>" alt="Product Image">
                <p class="name"><?php echo $product['name']; ?></p>
                <p class="price"><?php echo $product['price']; ?></p>
            </div>
        <?php endforeach; ?>
    </div>
</body>
</html>
