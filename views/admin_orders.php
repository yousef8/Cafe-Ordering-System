<!DOCTYPE html>
<html lang="en">
<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
require "../utilities/db_connection.php";
require_once "../models/Order.php";
$orders = new OrderModel($conn);
?>

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <title>Orders</title>
</head>

<body>
    <div class="container-lg mt-4">
        <?php
        function getActionsMenu(array $order): string
        {
            $options = [
                "processing" => "Processing",
                "out-for-delivery" => "Out For Delivery",
                "delivered" => "Delivered",
            ];

            $selectedStatus = $order['shipping_status'] ?? '';
            $result = '<select class="form-select" aria-label="Default select example"' . "onchange=" . "submitActionsMenu(" . $order['user_id'] . "," . $order['id'] . "," . "this)>";
            foreach ($options as $value => $label) {
                $selected = ($selectedStatus === $value) ? 'selected' : '';
                $result .= "<option value='$value' $selected>$label</option>";
            }
            $result .= '</select>';

            return $result;
        }
        ?>

        <?php foreach ($orders->getAll() as $idx => $order) : ?>
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User</th>
                        <th scope="col">Creation Date</th>
                        <th scope="col">Delivery Date</th>
                        <th scope="col">Shipping Status</th>
                        <th scope="col">Cancelled</th>
                        <th scope="col">Action</th>
                    </tr>
                </thead>
                <tbody>
                    <tr>
                        <td><?php echo $order['id'] ?></td>
                        <td><?php echo $order['user_id'] ?></td>
                        <td><?php echo $order['create_date'] ?></td>
                        <td><?php echo $order['delivery_date'] ?? "Not yet delivered" ?></td>
                        <td><?php echo $order['shipping_status'] ?></td>
                        <td> <?php echo $order['is_cancelled'] ? 'Yes' : 'No' ?> </td>
                        <td>
                            <?php echo getActionsMenu($order); ?>
                        </td>
                    </tr>
                </tbody>
            </table>
        <?php endforeach ?>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
    <script>
        function submitActionsMenu(userId, orderId, selectElement) {
            var selectedStatus = selectElement.value;
            var url = `/Cafe-Ordering-System/controllers/admins/orders/change-shipping-status.php?order_id=${orderId}&user_id=${userId}&status=${selectedStatus}`;
            window.location.href = url;
        }
    </script>
</body>

</html>