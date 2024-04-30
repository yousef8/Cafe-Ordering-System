<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/productController.php';

$productController = new ProductController($conn);

$page = isset($_GET['page']) ? $_GET['page'] : 1;
$perPage = 8;
$products = $productController->getAllProducts($page, $perPage);

?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="get.css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Product List</title>
</head>

<body>
    <?php require_once __DIR__ . '/../../user/user_navbar.php'; ?>
    <h1>Product List</h1>
    <a href="create.php" class="add"><button type="button">Add Product</button></a>
    <table>

        <thead>
            <tr>
                <th>Name</th>
                <th>Price</th>
                <th>Category</th>
                <th>Image</th>
                <th>Stock</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
        <?php if (empty($products)): ?>
                <tr><td colspan="6">No products have been added yet.</td></tr>
            <?php else: ?>
                <?php foreach ($products as $product): ?>
                    <tr>
                        <td><?php echo $product['name']; ?></td>
                        <td><?php echo $product['price']; ?></td>
                        <td><?php echo $product['category_name']; ?></td>
                        <td><img src="../../../uploads-product/<?php echo $product['image_url']; ?>" alt="Product Image" style="width: 100px;"></td>
                        <td><?php echo $product['stock']; ?></td>
                        <td>
                            <div class="actions">
                            <form action="update.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit">Update</button>
                            </form>
                            <form action="delete.php" method="POST">
                                <input type="hidden" name="product_id" value="<?php echo $product['id']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                            </div>
                        </td>
                    </tr>
                <?php endforeach; ?>
            <?php endif; ?>
        </tbody>
    </table>
    
    <div class="pagination">
    <div class="pagination">
    <?php
    $totalProducts = $productController->getTotalProductsCount();
    $totalPages = ceil($totalProducts / $perPage);

    for ($i = 1; $i <= $totalPages; $i++) {
        echo "<a href='?page=$i'>$i</a>";
    }
    ?>
    </div>
</div>

</body>

</html>