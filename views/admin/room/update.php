<?php
require_once __DIR__ . '/../../utilities/db_connection.php';
require_once __DIR__ . '/../../controllers/roomController.php';

$roomController = new RoomController($conn);

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $oldName = $_POST['name'];
    if (isset($_POST['new_name'])) {
        $newName = $_POST['new_name'];
    }

    if (!empty($oldName) && !empty($newName)) {
        if ($roomController->updateRoom($oldName, $newName)) {
            $successMessage = "Room updated successfully.";
        } else {
            $errorMessage = "Failed to update Room.";
        }
    }
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Update Room</title>
</head>

<body>
    <?php require_once __DIR__ . "/../admin_navbar.php"; ?>
    <h1>Update Room</h1>
    <?php if (!empty($errorMessage)) : ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
    <?php if (!empty($successMessage)) : ?>
        <p><?php echo $successMessage; ?></p>
    <?php endif; ?>
    <form action="" method="POST">
        <input type="hidden" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
        <label for="new_name">New Name:</label>
        <input type="text" id="new_name" name="new_name" value="<?php echo isset($_POST['new_name']) ? htmlspecialchars($_POST['new_name']) : ''; ?>"><br>
        <button type="submit">Update</button>
        <a href="get.php"><button type="button">Back</button></a>
    </form>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>