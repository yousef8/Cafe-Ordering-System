<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/productController.php';

$productController = new ProductController($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['product_id'])) {
    $productId = $_POST['product_id'];
    $productController->delete($productId);
}

header("Location: get.php");
exit;
?>
