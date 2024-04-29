<?php
require_once __DIR__ . '/../../controllers/roomController.php';
require_once __DIR__ . '/../../utilities/db_connection.php';

$roomController = new RoomController($conn);
$rooms = $roomController->getAllRooms();
?>

<select name="room">
    <option value="">ComboBox</option>
    <?php foreach ($rooms as $room): ?>
        <option value="<?php echo $room['name']; ?>"><?php echo $room['name']; ?></option>
    <?php endforeach; ?>
</select>
