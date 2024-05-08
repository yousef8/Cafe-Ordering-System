<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "../utilities/db_connection.php";

# Create order_rooms & users table first
$stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS carts (
    id INT UNSIGNED AUTO_INCREMENT PRIMARY KEY,
    user_id INT UNSIGNED NOT NULL UNIQUE,
    note VARCHAR(255),
    total_price DECIMAL(10, 2) DEFAULT 0,
    room_name VARCHAR(255),
    created_at DATETIME DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (room_name) REFERENCES order_rooms(name) ON DELETE CASCADE,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
)");

try {
    if (!$stmt->execute()) {
        echo $e->getMessage() . PHP_EOL;
        exit("maybe try to create order_rooms & users tables first");
    }
} catch (PDOException $e) {
    echo $e->getMessage() . PHP_EOL;
    exit("maybe try to create order_rooms & users tables first");
}
