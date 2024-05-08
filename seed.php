<?php

require_once './utilities/db_connection.php'; // Include your database connection file
require_once './models/Order.php';
require_once './models/OrderItem.php';
require_once './models/OrderRoom.php';
require_once './models/Room.php';



// Define the seed data
$orders = [
    [
        'user_id' => 1,
        'total_price' => 100,
        'create_date' => '2024-04-26 10:00:00',
        'shipping_status' => 'processing',
        'is_cancelled' => false,
        'note' => 'Order 1'
    ],
    [
        'user_id' => 2,
        'total_price' => 150,
        'create_date' => '2024-04-26 11:00:00',
        'shipping_status' => 'out-for-delivery',
        'is_cancelled' => false,
        'note' => 'Order 2'
    ],
    [
        'user_id' => 3,
        'total_price' => 200,
        'create_date' => '2024-04-26 12:00:00',
        'shipping_status' => 'delivered',
        'is_cancelled' => false,
        'note' => 'Order 3'
    ]
];

$orderItems = [
    [
        'order_id' => 1,
        'product_id' => 1,
        'quantity' => 2
    ],
    [
        'order_id' => 1,
        'product_id' => 2,
        'quantity' => 1
    ],
    [
        'order_id' => 1,
        'product_id' => 3,
        'quantity' => 3
    ],
    [
        'order_id' => 2,
        'product_id' => 4,
        'quantity' => 1
    ],
    [
        'order_id' => 2,
        'product_id' => 5,
        'quantity' => 2
    ],
    [
        'order_id' => 2,
        'product_id' => 6,
        'quantity' => 1
    ],
    [
        'order_id' => 3,
        'product_id' => 7,
        'quantity' => 4
    ],
    [
        'order_id' => 3,
        'product_id' => 8,
        'quantity' => 2
    ],
    [
        'order_id' => 3,
        'product_id' => 9,
        'quantity' => 3
    ]
];


$orderModel = new OrderModel($conn);
$orderItemModel = new OrderItemModel($conn);
$room = new Room($conn);

foreach ($orders as $order) {
    $orderModel->create($order);
    $orderId = $orderModel->get_last_inserted_id();

    foreach ($orderItems as $item) {
        if ($item['order_id'] == $orderId) {
            $orderItemModel->create($item);
        }
    }
}

$products = [
    [
        'name' => 'Product 1',
        'price' => 50.00,
        'category_name' => 'Category 1',
        'image_url' => 'https://example.com/image1.jpg',
        'stock' => 10
    ],
    [
        'name' => 'Product 2',
        'price' => 75.00,
        'category_name' => 'Category 2',
        'image_url' => 'https://example.com/image2.jpg',
        'stock' => 20
    ],
    [
        'name' => 'Product 3',
        'price' => 100.00,
        'category_name' => 'Category 1',
        'image_url' => 'https://example.com/image3.jpg',
        'stock' => 15
    ],
    // Add more products as needed
];

// Loop through the products and insert them into the database
foreach ($products as $product) {
    $insert_product_stmt = $conn->prepare("INSERT INTO products (name, price, category_name, image_url, stock) VALUES (:name, :price, :category_name, :image_url, :stock)");
    $insert_product_stmt->execute([
        'name' => $product['name'],
        'price' => $product['price'],
        'category_name' => $product['category_name'],
        'image_url' => $product['image_url'],
        'stock' => $product['stock']
    ]);
}


echo "Seed data inserted successfully!\n";
