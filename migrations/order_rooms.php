<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "../utilities/db_connection.php";


$create_order_rooms_stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS order_rooms (
    name VARCHAR(255) PRIMARY KEY
    )");

try {
    $create_order_rooms_stmt->execute();
} catch(PDOException $e) {
    echo $e->getMessage().PHP_EOL;
    exit("couldn't create order_rooms");
}