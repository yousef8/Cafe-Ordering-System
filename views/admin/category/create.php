
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Create Category</title>
</head>
<body>
    <h1>Create Category</h1>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        <button type="submit">Create</button>
    </form>

    <?php 
    require_once __DIR__ . '/../../../utilities/db_connection.php';

    require_once __DIR__ .  '/../../../controllers/categoryController.php';

    $categoryController = new CategoryController($conn);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];

        if ($categoryController->create($name)) {
            echo "<p>Category created successfully.</p>";
        } else {
            echo "<p>Failed to create category.</p>";
        }
    }
    ?>
</body>
</html>
