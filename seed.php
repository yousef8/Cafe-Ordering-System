<?php

require_once './utilities/db_connection.php'; // Include your database connection file
require_once './models/Order.php';
require_once './models/OrderItem.php';
require_once './models/OrderRoom.php';



// Define the seed data
$orders = [
    [
        'user_id' => 1,
        'total_price' => 100,
        'create_date' => '2024-04-26 10:00:00',
        'delivery_date' => '2024-04-30',
        'shipping_status' => 'processing',
        'is_cancelled' => false,
        'note' => 'Order 1'
    ],
    [
        'user_id' => 2,
        'total_price' => 150,
        'create_date' => '2024-04-26 11:00:00',
        'delivery_date' => '2024-05-01',
        'shipping_status' => 'out-for-delivery',
        'is_cancelled' => false,
        'note' => 'Order 2'
    ],
    [
        'user_id' => 3,
        'total_price' => 200,
        'create_date' => '2024-04-26 12:00:00',
        'delivery_date' => '2024-05-02',
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

foreach ($orders as $order) {
    $orderModel->create($order);
    $orderId = $orderModel->get_last_inserted_id();

    foreach ($orderItems as $item) {
        if ($item['order_id'] == $orderId) {
            $orderItemModel->create($item);
        }
    }
}

echo "Seed data inserted successfully!\n";


