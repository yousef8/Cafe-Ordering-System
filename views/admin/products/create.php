<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Create Product</title>
    <link rel="stylesheet" href="create.css">
</head>

<body>
    <?php require_once __DIR__ . '/../../user/user_navbar.php'; ?>
    <h1>Create Product</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <div class="form-group">
            <label for="name">Name:</label>
            <input type="text" name="name" id="name" required>
        </div>

        <div class="form-group">
            <label for="price">Price</label>
            <input type="number" name="price" id="price" step="0.01" required>
        </div>
       

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
            <label for="stock">Stock</label>
            <input type="number" name="stock" id="stock" required>
        </div>

        <div class="form-group">
            <label for="image">Image</label>
            <input type="file" name="image" id="image" accept="image/*" required>
        </div>

       

        <div class="form-group">
            <button type="submit">Create</button>
            <button type="reset">Reset</button>
        </div>
    </form>
    <div class="form-message">
        <?php
        require_once __DIR__ . '/../../../utilities/db_connection.php';
        require_once __DIR__ . '/../../../controllers/productController.php';
        require_once __DIR__ . '/../check_session.php';

        if ($_SERVER["REQUEST_METHOD"] == "POST") {
            $productController = new ProductController($conn);

            $targetDir = "../../../uploads-product/";
            $targetFile = $targetDir . basename($_FILES["image"]["name"]);
            $fileName = basename($_FILES["image"]["name"]);

            if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
                $data = [
                    'name' => $_POST['name'],
                    'price' => $_POST['price'],
                    'category_name' => $_POST['category_name'],
                    'image_url' => $fileName,
                    'stock' => $_POST['stock']
                ];

                if ($productController->create($data)) {
                    echo "<p>Product created successfully.</p>";
                } else {
                    echo "<p>Failed to create product. The product name already exists.</p>";
                }
            } else {
                echo "Sorry, there was an error uploading your file.";
            }
        }
        ?>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
