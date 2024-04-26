<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/categoryController.php';

$categoryController = new CategoryController($conn);

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldName = $_POST['name'];
    if (isset($_POST['new_name'])) {
        $newName = $_POST['new_name'];
    }

    if (!empty($oldName) && !empty($newName)) {
        if ($categoryController->updateCategory($oldName, $newName)) {
            $successMessage = "Category updated successfully.";
        } else {
            $errorMessage = "Failed to update Category.";
        }
    } 
}
?>

<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Update Category</title>
</head>
<body>
    <h1>Update Category</h1>
    <?php if (!empty($errorMessage)): ?>
    <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <?php if (!empty($successMessage)): ?>
    <p><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <input type="hidden" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
        <label for="new_name">New Name:</label>
        <input type="text" id="new_name" name="new_name" value="<?php echo isset($_POST['new_name']) ? htmlspecialchars($_POST['new_name']) : ''; ?>"><br>
        <button type="submit">Update</button>
        <a href="get.php"><button type="button">Back</button></a>
    </form>
</body>
</html>
