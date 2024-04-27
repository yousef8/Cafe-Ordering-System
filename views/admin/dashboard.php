<?php
require_once __DIR__ . '/../../utilities/db_connection.php';
require_once __DIR__ . '/../../controllers/productController.php';

$productController = new ProductController($conn);
$products = $productController->getAllProducts();
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>
<body>
    <div class="dashboard">
            <div class="product-cards">
                <?php foreach ($products as $product): ?>
                    <div class="product-card">
                        <img src="../../uploads-product/<?php echo $product['image_url']; ?>" alt="Product Image">
                        <div class="name"><?php echo $product['name']; ?></div>
                        <div class="price"><?php echo $product['price']; ?></div>
                    </div>
                <?php endforeach; ?>
            </div>
    </div>
</body>
</html>
