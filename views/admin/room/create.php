<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Create Room</title>
</head>

<body>
    <?php require_once __DIR__ . '/../../user/user_navbar.php'; ?>
    <h1>Create Room</h1>
    <form action="" method="post">
        <label for="name">Name:</label>
        <input type="text" name="name" id="name" required><br>
        <button type="submit">Create</button>
    </form>

    <?php
    require_once __DIR__ . '/../../utilities/db_connection.php';
    require_once '../../controllers/roomController.php';

    $roomController = new RoomController($conn);

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $name = $_POST['name'];

        if ($roomController->create($name)) {
            echo "<p>Room created successfully.</p>";
        } else {
            echo "<p>Failed to create room.</p>";
        }
    }
    ?>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>