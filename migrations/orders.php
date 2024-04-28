<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "../utilities/db_connection.php";

# Create order_rooms & users table first
$create_orders_stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS orders (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    total_price DECIMAL(10, 2),
    create_date DATETIME DEFAULT CURRENT_TIMESTAMP,
    delivery_date DATETIME,
    shipping_status ENUM('processing', 'out-for-delivery', 'delivered') DEFAULT 'processing',
    is_cancelled BOOLEAN DEFAULT FALSE,
    note VARCHAR(255),
    room_name VARCHAR(255),
    user_id INT UNSIGNED NOT NULL,
    FOREIGN KEY (room_name) REFERENCES order_rooms(name) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

try {
    $create_orders_stmt->execute();
} catch (PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit("maybe try to create order_rooms & users tables first");
}
