<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Product</title>
</head>
<body>
    <h1>Create Product</h1>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>

        <label for="price">Price:</label>
        <input type="number" name="price" id="price" step="0.01" required><br>

        <label for="category_name">Category:</label>
        <input type="text" name="category_name" id="category_name" required><br>

        <label for="image_url">Image URL:</label>
        <input type="url" name="image_url" id="image_url" required><br>

        <label for="stock">Stock:</label>
        <input type="number" name="stock" id="stock" required><br>

        <button type="submit">Create</button>
    </form>

    <?php 
    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        require_once __DIR__ . '/../../utilities/db_connection.php';

        require_once __DIR__ . '/../../controllers/productController.php';

        $productController = new ProductController($conn);

        $data = [
            'name' => $_POST['name'],
            'price' => $_POST['price'],
            'category_name' => $_POST['category_name'],
            'image_url' => $_POST['image_url'],
            'stock' => $_POST['stock']
        ];

        if ($productController->create($data)) {
            echo "<p>Product created successfully.</p>";
        } else {
            echo "<p>Failed to create product.</p>";
        }
    }
    ?>
</body>
</html>
