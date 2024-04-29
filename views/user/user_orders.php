<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>User Orders</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        body {
            padding-top: 5rem;
        }
    </style>
</head>

<body>
    <?php
    require_once __DIR__ . '/../../utilities/db_connection.php';
    require_once __DIR__ . '/../../controllers/user_controller.php';

    session_start();
    if (!isset($_SESSION['user_id'])) {
        echo "<p class='container'>User not logged in.</p>";
        exit();
    }
    $userId = $_SESSION['user_id'];
    $userController = new UserController($conn);
    $orders = $userController->getOrders($userId);
    ?>
    <div class="container">
        <h1 class="mb-5">User Orders</h1>
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
                    <th>Actions</th>
                    <th>Cancel</th>
                </tr>
            </thead>
            <tbody>
                <?php if ($orders === false || empty($orders)): ?>
                    <tr>
                        <td colspan='9'>No orders found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><?php echo htmlspecialchars($order['id']); ?></td>
                            <td><?php echo htmlspecialchars($order['total_price']); ?></td>
                            <td><?php echo htmlspecialchars($order['create_date']); ?></td>
                            <td><?php echo htmlspecialchars($order['delivery_date'] ?? ""); ?></td>
                            <td><?php echo htmlspecialchars($order['shipping_status']); ?></td>
                            <td><?php echo $order['is_cancelled'] ? 'Yes' : 'No'; ?></td>
                            <td><?php echo htmlspecialchars($order['note']); ?></td>
                            <td><?php echo htmlspecialchars($order['room_name'] ?? ""); ?></td>
                            <td>
                                <select class="form-select" aria-label="Select shipping status" onchange="submitActionsMenu(<?php echo $order['user_id']; ?>, <?php echo $order['id']; ?>, this)">
                                    <?php
                                    $options = [
                                        "processing" => "Processing",
                                        "out-for-delivery" => "Out For Delivery",
                                        "delivered" => "Delivered",
                                    ];
                                    foreach ($options as $value => $label) {
                                        $selected = ($order['shipping_status'] === $value) ? 'selected' : '';
                                        echo "<option value='$value' $selected>$label</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                            <td>
                                <select class="form-select" aria-label="Select cancellation status" onchange="submitCancelMenu(<?php echo $order['user_id']; ?>, <?php echo $order['id']; ?>, this)">
                                    <?php
                                    $options = [
                                        0 => "NO",
                                        1 => "YES"
                                    ];
                                    foreach ($options as $value => $label) {
                                        $selected = ($order['is_cancelled'] === $value) ? 'selected' : '';
                                        echo "<option value='$value' $selected>$label</option>";
                                    }
                                    ?>
                                </select>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function submitActionsMenu(userId, orderId, selectElement) {
            const selectedStatus = selectElement.value;
            const url = `/Cafe-Ordering-System/controllers/admins/orders/change-shipping-status.php?order_id=${orderId}&user_id=${userId}&status=${selectedStatus}`;
            window.location.href = url;
        }

        function submitCancelMenu(userId, orderId, selectElement) {
            const selectedStatus = selectElement.value;
            const url = `/Cafe-Ordering-System/controllers/admins/orders/change-cancel-status.php?order_id=${orderId}&user_id=${userId}&status=${selectedStatus}`;
            window.location.href = url;
        }
    </script>
</body>

</html>
