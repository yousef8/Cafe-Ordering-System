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
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Admin Dashboard</title>
    <link rel="stylesheet" href="styles.css">
</head>

<body>
    <div class="container-fluid">
        <?php require_once __DIR__ . "/../user/user_navbar.php"; ?>
        <div class="dashboard">
        <?php
        require_once __DIR__ . '/../../utilities/db_connection.php';
        require_once __DIR__ . '/../../controllers/productController.php';

        $productController = new ProductController($conn);
        
        if(isset($_GET['search'])) {
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
    <form id="search-form" action="" method="GET" class="search-form" style="display: flex; justify-content: center; align-items: center; margin: 50px;">
    <input type="text" name="search" placeholder="Search products..." id="search-bar" style="width: 300px; padding: 10px; border-radius: 5px; border: 1px solid #ccc; margin-right: 10px; margin-left: 200px">
    <button type="submit" style="padding: 10px 20px; border: none; background-color: #555; color: #fff; border-radius: 5px; cursor: pointer; transition: background-color 0.3s;">Search</button>
    </form>
            <div class="product-cards">
                <?php foreach ($products as $product) : ?>
                    <div class="product-card">
                        <img src="../../uploads-product/<?php echo $product['image_url']; ?>" alt="Product Image">
                        <div class="name"><?php echo $product['name']; ?></div>
                        <div class="price"><?php echo $product['price']; ?></div>
                        <button id="add" style="background-color:  #555; color: #fff">Add</button>

                    </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>