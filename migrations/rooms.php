<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "../utilities/db_connection.php";

$create_rooms_stmt = $conn->prepare("
    CREATE TABLE IF NOT EXISTS rooms (
        room_id INT AUTO_INCREMENT PRIMARY KEY,
        room_name VARCHAR(255) NOT NULL,
        capacity INT NOT NULL
    )
");

try {
    $create_rooms_stmt->execute();
    echo "Rooms table created successfully.";
} catch(PDOException $e) {
    echo $e->getMessage().PHP_EOL;
    exit("Couldn't create rooms table");
}
?>
