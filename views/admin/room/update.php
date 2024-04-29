<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/roomController.php';

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
    <div class="container mt-5">
        <h1>Update Room</h1>
        <?php if (!empty($errorMessage)) : ?>
            <div class="alert alert-danger alert-dismissible fade show" role="alert">
                <?php echo $errorMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <?php if (!empty($successMessage)) : ?>
            <div class="alert alert-success alert-dismissible fade show" role="alert">
                <?php echo $successMessage; ?>
                <button type="button" class="btn-close" data-bs-dismiss="alert" aria-label="Close"></button>
            </div>
        <?php endif; ?>
        <form action="" method="POST">
            <input type="hidden" name="name" value="<?php echo isset($_POST['name']) ? htmlspecialchars($_POST['name']) : ''; ?>">
            <div class="mb-3">
                <label for="new_name" class="form-label">New Name:</label>
                <input type="text" class="form-control" id="new_name" name="new_name" value="<?php echo isset($_POST['new_name']) ? htmlspecialchars($_POST['new_name']) : ''; ?>">
            </div>
            <button type="submit" class="btn btn-primary">Update</button>
            <a href="get.php" class="btn btn-secondary">Back</a>
        </form>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js" integrity="sha384-YvpcrYf0tY3lHB60NNkmXc5s9fDVZLESaAA55NDzOxhy9GkcIdslK1eN7N6jIeHz" crossorigin="anonymous"></script>
</body>

</html>
