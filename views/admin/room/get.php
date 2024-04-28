<?php
require_once __DIR__ . '/../../utilities/db_connection.php';
require_once __DIR__ . '/../../controllers/roomController.php';

$roomController = new roomController($conn);
$Rooms = $roomController->getAllRooms();
?>


<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Rooms List</title>
</head>
<body>
    <h1>Rooms List</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Rooms as $room): ?>
                <tr>
                    <td><?php echo $room['name']; ?></td>
                    <td>
                        <form action="update.php" method="POST">
                            <input type="hidden" name="name" value="<?php echo $room['name']; ?>">
                            <button type="submit">Update</button>
                        </form>

                        <form action="delete.php" method="POST">
                            <input type="hidden" name="name" value="<?php echo $room['name']; ?>">
                            <button type="submit">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach; ?>
        </tbody>
    </table>
</body>
</html>