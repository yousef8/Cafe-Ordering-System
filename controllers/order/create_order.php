<?php
session_start();
$userId = $_SESSION['user_id'];
require_once '../../utilities/db_connection.php';
require_once '../../models/Order.php';

// Assuming $conn is your PDO connection

$orderModel = new OrderModel($conn);

// Assuming the request body contains the cart items
$cartItems = json_decode(file_get_contents('php://input'), true);

// Assuming $userId is the ID of the current user
$userId = 1; // Replace with actual user ID

$totalPrice = array_reduce($cartItems, function ($acc, $item) {
    return $acc + $item['quantity'] * $item['price'];
}, 0);

// Create the order
$result = $orderModel->create([
    'user_id' => $userId,
    'total_price' => $totalPrice,
    'create_date' => date('Y-m-d H:i:s'),
    'delivery_date' => date('Y-m-d H:i:s'),
    'shipping_status' => 'processing',
    'is_cancelled' => false,
    'note' => 'Order placed from cart',
    'room_name' => 'ComboBox'
]);

if ($result !== false) {
    // You can also add the order items to a separate table
    foreach ($cartItems as $item) {
        // Assuming you have an OrderItemModel class for managing order items
        // $orderItemModel->create([...]);
    }

    echo json_encode(['success' => true]);
} else {
    echo json_encode(['success' => false]);
}
?>
