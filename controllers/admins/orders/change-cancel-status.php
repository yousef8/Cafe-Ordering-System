<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>

<?php
if (!isset($_GET['order_id']) && !isset($_GET['user_id']) && !isset($_GET['status'])) {
    echo "<h1>You need to provide order_id, user_id and status as query parameters</h1>";
    die();
}
require "../../../utilities/db_connection.php";
require "../../../models/Order.php";

$order_id = $_GET['order_id'];
$status = $_GET['status'] ? true : false;



$orders = new OrderModel($conn);
$order = $orders->getById($order_id);

if (!$orders->update($order_id, ["is_cancelled" => $status])) {
    echo $orders->get_last_error_message();
    die();
}

header('Location: /Cafe-Ordering-System/views/admin_orders.php');
die();
