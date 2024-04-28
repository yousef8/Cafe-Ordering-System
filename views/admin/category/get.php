<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/categoryController.php';

$categoryController = new CategoryController($conn);
$categories = $categoryController->getAllCategories();
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link rel="stylesheet" href="get.css" >
    <title>Categories List</title>
</head>
<body>
    <h1>Categories List</h1>
    <a href="create.php" class="add"><button type="button">Add Category</button></a>

    
        <table>
            <thead>
                <tr>
                    <th>Name</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
            <?php if (empty($categories)): ?>
                <tr><td colspan="6">No Categories have been added yet.</td></tr>
    <?php else: ?>
                <?php foreach ($categories as $category): ?>
                    <tr>
                        <td><?php echo $category['name']; ?></td>
                        <td>
                            <form action="update.php" method="POST">
                                <input type="hidden" name="name" value="<?php echo $category['name']; ?>">
                                <button type="submit">Update</button>
                            </form>

                            <form action="delete.php" method="POST">
                                <input type="hidden" name="name" value="<?php echo $category['name']; ?>">
                                <button type="submit">Delete</button>
                            </form>
                        </td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
        </table>
    <?php endif; ?>
</body>
</html>
