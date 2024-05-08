<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/productController.php';
require_once __DIR__ . '/../check_session.php';

$productController = new ProductController($conn);

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $productId = $_POST['product_id'];

    $updatedData = array();
    if (isset($_POST['name'])) {
        $updatedData['name'] = $_POST['name'];
    }
    if (isset($_POST['price'])) {
        $updatedData['price'] = $_POST['price'];
    }
    if (isset($_POST['category_name'])) {
        $updatedData['category_name'] = $_POST['category_name'];
    }
    if (isset($_POST['image_url'])) {
        $updatedData['image_url'] = $_POST['image_url'];
    }
    if (isset($_POST['stock'])) {
        $updatedData['stock'] = $_POST['stock'];
    }

    if (!empty($updatedData)) {
        if ($productController->update($productId, $updatedData)) {
            $successMessage = "Product updated successfully.";
        } else {
            $errorMessage = "Failed to update product.";
        }
    }
}

if (!isset($_POST['product_id'])) {
    header("Location: get.php");
    exit();
}

$productId = $_POST['product_id'];

$product = $productController->getProductById($productId);

if (!$product) {
    header("Location: get.php?error=product_not_found");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="create.css" >
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Update Product</title>
</head>

<body>
    <?php require_once __DIR__ . '/../../user/user_navbar.php'; ?>
    <h1>Update Product</h1>
    <?php if (!empty($errorMessage)) : ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <?php if (!empty($successMessage)) : ?>
        <p><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <input type="hidden" name="product_id" value="<?php echo $productId; ?>">
        <div class="form-group">
        <label for="name">Name:</label>
        <input type="text" id="name" name="name" value="<?php echo isset($product['name']) ? htmlspecialchars($product['name']) : ''; ?>"><br>
        </div>

        <div class="form-group">
        <label for="price">Price:</label>
        <input type="text" id="price" name="price" value="<?php echo isset($product['price']) ? htmlspecialchars($product['price']) : ''; ?>"><br>
    </div>
    <!-- <div class="form-group">
        <label for="category_name">Category:</label>
        <input type="text" id="category_name" name="category_name" value="<?php echo isset($product['category_name']) ? htmlspecialchars($product['category_name']) : ''; ?>"><br>
    </div> -->
    <div class="form-group">
            <label for="category_name">Category:</label>
            <select name="category_name" id="category_name" required>
                <?php
                require_once __DIR__ . '/../../../utilities/db_connection.php';
                $stmt = $conn->prepare("SELECT name FROM categories");
                $stmt->execute();
                $categories = $stmt->fetchAll(PDO::FETCH_ASSOC);
                foreach ($categories as $category) {
                    echo "<option value=\"{$category['name']}\">{$category['name']}</option>";
                }
                ?>
            </select>
            <a href="../category/create.php">Add Category</a>
        </div>
   
    <div class="form-group">
        <label for="stock">Stock:</label>
        <input type="text" id="stock" name="stock" value="<?php echo isset($product['stock']) ? htmlspecialchars($product['stock']) : ''; ?>"><br>
    </div>
    <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>
        </div>
    
        <button type="submit">Update</button>
        <a href="get.php"><button type="button" class="back">Back</button></a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>