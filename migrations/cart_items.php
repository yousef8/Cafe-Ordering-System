<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "../utilities/db_connection.php";

# Create cart & products table first
$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS cart_items (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    cart_id int unsigned,
    product_id int unsigned,
    quantity int unsigned,
    FOREIGN KEY (cart_id) REFERENCES carts(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id) ON DELETE CASCADE
)");

try {
    if (!$stmt->execute()) {
        echo $e->getMessage() . PHP_EOL;
        exit("maybe try to create orders & products table first");
    }
} catch (PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit("maybe try to create orders & products table first");
}
