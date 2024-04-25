<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "../utilities/db_connection.php";

# Create orders & products table first
$create_order_items_stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS order_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    order_id int unsigned,
    product_id int unsigned,
    quantity int unsigned,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)");

try {
    $create_order_items_stmt->execute();
} catch(PDOException $e) {
    echo $e->getMessage().PHP_EOL;
    exit("maybe try to create orders & products table first");
}