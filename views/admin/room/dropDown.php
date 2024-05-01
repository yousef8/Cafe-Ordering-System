<?php
require_once __DIR__ . '/../../../controllers/roomController.php';
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../check_session.php';
$roomController = new RoomController($conn);
$rooms = $roomController->getAllRooms();
?>

<select name="room_name">
    <option value="">ComboBox</option>
    <?php foreach ($rooms as $room): ?>
        <option value="<?php echo $room['name']; ?>"><?php echo $room['name']; ?></option>
    <?php endforeach; ?>
</select>
