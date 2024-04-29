<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
</head>
<body>
    <div class="container mt-5">
        <h1>User Orders</h1>
        <table class="table table-striped">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Total Price</th>
                    <th>Create Date</th>
                    <th>Delivery Date</th>
                    <th>Shipping Status</th>
                    <th>Cancelled</th>
                    <th>Note</th>
                    <th>Room Name</th>
                </tr>
            </thead>
            <tbody>
            <?php
            require_once __DIR__ . '/../../utilities/db_connection.php';
            require_once __DIR__ . '/../../controllers/user_controller.php';

            try {
                session_start();
                if (!isset($_SESSION['user_id']))
                    return;
                $userId = $_SESSION['user_id'];
                $userController = new UserController($conn);
                $orders = $userController->getOrders($userId);
                if ($orders === false) {
                    echo "<tr><td colspan='9'>No orders found.</td></tr>";
                } else {
                    foreach ($orders as $order) {
                        echo "<tr>";
                        echo "<td>{$order['id']}</td>";
                        echo "<td>{$order['total_price']}</td>";
                        echo "<td>{$order['create_date']}</td>";
                        echo "<td>{$order['delivery_date']}</td>";
                        echo "<td>{$order['shipping_status']}</td>";
                        echo "<td>{$order['is_cancelled']}</td>";
                        echo "<td>{$order['note']}</td>";
                        echo "<td>{$order['room_name']}</td>";
                        echo "</tr>";
                    }
                }
            } catch (PDOException $e) {
                echo "Connection failed: " . $e->getMessage();
            }
            ?>
            </tbody>
        </table>
    </div>
</body>
</html>
