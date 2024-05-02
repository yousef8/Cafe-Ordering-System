<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<?php
require_once '../../../utilities/db_connection.php';
require_once '../../../models/user.php';
require_once '../../../models/Order.php';
require_once __DIR__ . '/../check_session.php';
$users_table = new User($conn);
$orders_table = new OrderModel($conn);

$users = array();

foreach ($users_table->getAllUsers() as $idx => $user) {
    $orders = $orders_table->where(["user_id" => $user['id'], "is_cancelled" => false]);
    $total_orders_amount = 0;
    foreach ($orders as $order) {
        $total_orders_amount += $order['total_price'];
    }
    $user['total_orders_amount'] = $total_orders_amount;
    $user['orders'] = $orders; // Include the orders for each user
    $users[$idx] = $user;
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Checks</title>
</head>

<body>
    <?php require_once __DIR__ . '/../../user/user_navbar.php'; ?>
    <div class="container-fluid">
        <form class="w-25 mt-4">
            <div class="container-fluid d-flex flex-row justify-content-around">
                <div>
                    <label for="from">From</label>
                    <input type="date" id="fromDate" name="from" placeholder="From">
                </div>
                <div class="ms-4">
                    <label for="to">To</label>
                    <input type="date" id="toDate" name="to" placeholder="To">
                </div>
            </div>

            <select class="form-select mt-3" aria-label="Default select example" name="user_id" id="userFilter">
                <option value="" selected>Choose User</option>
                <option value="1">One</option>
                <option value="2">Two</option>
                <option value="3">Three</option>
            </select>
            <input class="btn btn-warning mt-3" type="button" value="Filter" id="filterButton">
        </form>

        <div class="checks">
            <table class="table">
                <thead>
                    <tr>
                        <th scope="col">ID</th>
                        <th scope="col">User</th>
                        <th scope="col">Total Orders Amount</th>
                    </tr>
                </thead>
                <tbody id="filteredOrders">
                    <?php foreach ($users as $user) : ?>
                        <tr data-bs-toggle="collapse" data-bs-target="#accordion-<?php echo $user['id']; ?>" aria-expanded="false" aria-controls="accordion-<?php echo $user['id']; ?>">
                            <td><?php echo $user['id'] ?></td>
                            <td><?php echo $user['first_name'] . ' ' . $user['last_name'] ?></td>
                            <td><?php echo $user['total_orders_amount'] ?></td>
                        </tr>
                        <tr>
                            <td colspan="3" class="p-0">
                                <div id="accordion-<?php echo $user['id']; ?>" class="collapse">
                                    <table class="table table-striped mb-0">
                                        <thead>
                                            <tr>
                                                <th scope="col">Order ID</th>
                                                <th scope="col">Created At</th>
                                                <th scope="col">Total Price</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            <?php foreach ($user['orders'] as $order) : ?>
                                                <tr>
                                                    <td><?php echo $order['id']; ?></td>
                                                    <td><?php echo $order['create_date']; ?></td>
                                                    <td><?php echo $order['total_price']; ?></td>
                                                </tr>
                                            <?php endforeach; ?>
                                        </tbody>
                                    </table>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                </tbody>
            </table>
        </div>
    </div>

    <script>
        document.getElementById('filterButton').addEventListener('click', function (event) {
    event.preventDefault(); // Prevent the form from being submitted

    var selectedUserId = document.getElementById('userFilter').value;
    var fromDate = document.getElementById('fromDate').value;
    var toDate = document.getElementById('toDate').value;

    var tableBody = document.getElementById('filteredOrders');
    tableBody.innerHTML = '';

    <?php echo json_encode($users); ?>.forEach(function (user) {
        if (selectedUserId === '' || user.id == selectedUserId) {
            var ordersHtml = '';

            user.orders.forEach(function (order) {
                if ((fromDate === '' || order.create_date >= fromDate) &&
                    (toDate === '' || order.create_date <= toDate)) {
                    ordersHtml += '<tr>' +
                        '<td>' + order.id + '</td>' +
                        '<td>' + order.create_date + '</td>' +
                        '<td>' + order.total_price + '</td>' +
                        '</tr>';
                }
            });

            if (ordersHtml !== '') {
                var row = '<tr data-bs-toggle="collapse" data-bs-target="#accordion-' + user.id + '" aria-expanded="true" aria-controls="accordion-' + user.id + '">' +
                    '<td>' + user.id + '</td>' +
                    '<td>' + user.first_name + ' ' + user.last_name + '</td>' +
                    '<td>' + user.total_orders_amount + '</td>' +
                    '</tr>';

                var subRow = '<tr>' +
                    '<td colspan="3" class="p-0">' +
                    '<div id="accordion-' + user.id + '" class="collapse show">' +
                    '<table class="table table-striped mb-0">' +
                    '<thead>' +
                    '<tr>' +
                    '<th scope="col">Order ID</th>' +
                    '<th scope="col">Created At</th>' +
                    '<th scope="col">Total Price</th>' +
                    '</tr>' +
                    '</thead>' +
                    '<tbody>' + ordersHtml + '</tbody></table></div></td></tr>';

                tableBody.innerHTML += row + subRow;
            }
        }
    });
});


    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
