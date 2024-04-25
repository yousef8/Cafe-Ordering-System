<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "../utilities/db_connection.php";

# Create categories table first
$create_products_stmt = $conn->prepare("CREATE TABLE IF NOT EXISTS products (
    id int unsigned auto_increment primary key, 
    name varchar(255) not null,
    price decimal(10,2) not null,
    category_name varchar(255),
    image_url varchar(255),
    stock int unsigned,
    foreign key (category_name) references categories(name) ON DELETE CASCADE
    )");

try {
    $create_products_stmt->execute();
} catch(PDOException $e) {
    echo $e->getMessage().PHP_EOL;
    exit(", maybe try to create categories table first");
}
