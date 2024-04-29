<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/roomController.php';

$roomController = new RoomController($conn);

if ($_SERVER["REQUEST_METHOD"] === "POST" && isset($_POST['name'])) {
    $roomName = $_POST['name'];
    
    if ($roomController->deleteRoom($roomName)) { 
        echo "Room deleted successfully.";
    } else {
        echo "Failed to delete room.";
    }
}

header("Location: get.php");
exit;
?>
