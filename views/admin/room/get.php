<?php


$userImageUrl = isset($_SESSION['image_url']) ? $_SESSION['image_url'] : null;

require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/roomController.php';

$roomController = new RoomController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST" && isset($_POST['create_room'])) {
    $name = $_POST['name'];
    if ($roomController->create($name)) {
        echo "<p id='success_message' class='alert alert-success position-fixed bottom-0 start-50 translate-middle-x mb-0'>Room created successfully.</p>";
    } else {
        echo "<p id='error_message' class='alert alert-danger position-fixed bottom-0 start-50 translate-middle-x mb-0'>Failed to create room.</p>";
    }
}

$rooms = $roomController->getAllRooms();
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Rooms Management</title>
</head>

<body>
    <?php require_once __DIR__ . '/../../user/user_navbar.php'; ?>
    <h1>Rooms List</h1>
    <table class="table">
        <thead>
            <tr>
                <th>Name</th>
                <th>Actions</th>
            </tr>
        </thead>
        <tbody>
            <?php foreach ($rooms as $room) : ?>
                <tr>
                    <td><?php echo $room['name']; ?></td>
                    <td>
                        <form action="update.php" method="POST" class="d-inline">
                            <input type="hidden" name="name" value="<?php echo $room['name']; ?>">
                            <button type="submit" class="btn btn-sm btn-primary">Update</button>
                        </form>
                        <form action="delete.php" method="POST" class="d-inline">
                            <input type="hidden" name="name" value="<?php echo $room['name']; ?>">
                            <button type="submit" class="btn btn-sm btn-danger">Delete</button>
                        </form>
                    </td>
                </tr>
            <?php endforeach ?>
        </tbody>
    </table>

    <script>
        setTimeout(function() {
            var successMessage = document.getElementById('success_message');
            if (successMessage) {
                successMessage.style.display = 'none';
            }
            var errorMessage = document.getElementById('error_message');
            if (errorMessage) {
                errorMessage.style.display = 'none';
            }
        }, 1000);
    </script>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>