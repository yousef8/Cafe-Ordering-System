<?php

if(isset ($_SESSION['image_url'])){
    $userImageUrl = $_SESSION['image_url'];
}
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/roomController.php';

$roomController = new roomController($conn);
$Rooms = $roomController->getAllRooms();
?>


<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Rooms List</title>
</head>

<body>
    <?php require_once __DIR__ . '/../../user/user_navbar.php'; ?>
    <h1>Rooms List</h1>
    <table>
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($Rooms as $room) : ?>
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

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>