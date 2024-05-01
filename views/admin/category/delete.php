<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/categoryController.php';
require_once __DIR__ . '/../check_session.php';
$categoryController = new CategoryController($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'])) {
    $categoryName = $_POST['name'];
    
    if ($categoryController->delete($categoryName)) {
        echo "Category deleted successfully.";
    } else {
        echo "Failed to delete category.";
    }
}

header("Location: get.php");
exit;
?>
