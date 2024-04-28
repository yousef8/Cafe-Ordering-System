<?php
require_once __DIR__ . '/../../utilities/db_connection.php';
require_once __DIR__ . '/../../controllers/user_controller.php';

$userController = new UserController($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['user_id'])) {
    $userId = $_POST['user_id'];
    if ($userController->deleteUser($userId)) {
        header("Location: get_users.php");
        exit;
    } else {
        echo "Can't delete this user.";
    }
} else {
    echo "Invalid request.";
}
?>