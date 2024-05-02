<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "../utilities/db_connection.php";

# Create rooms table first
$create_users_stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS users (
    id int unsigned auto_increment primary key, 
    first_name varchar(255), 
    last_name varchar(255), 
    email varchar(255) unique, 
    password varchar(255), 
    image_url varchar(255),
    room_name varchar(255),
    is_admin boolean default false,
    foreign key (room_name) references rooms(name) ON DELETE CASCADE
    )");

try {
    $create_users_stmt->execute();
} catch(PDOException $e) {
    echo $e->getMessage().PHP_EOL;
    exit("maybe try to create rooms table first");
}

