<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../controllers/user_controller.php';

$userController = new UserController($conn);

$errorMessage = "";
$successMessage = "";

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $userId = $_POST['user_id'];

    $updatedData = array();

    if (isset($_POST['first_name'])) {
        $updatedData['first_name'] = $_POST['first_name'];
    }
    if (isset($_POST['last_name'])) {
        $updatedData['last_name'] = $_POST['last_name'];
    }
    if (isset($_POST['email'])) {
        $updatedData['email'] = $_POST['email'];
    }
    if (isset($_FILES["image"]) && $_FILES["image"]["size"] > 0) {
        $targetDir = "../../../uploads-user/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"]);

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $updatedData['image_url'] = $targetFile;
        } else {
            $errorMessage = "Sorry, there was an error uploading your file.";
        }
    }
    if (isset($_POST['room_name'])) {
        $updatedData['room_name'] = $_POST['room_name'];
    }

    if (!empty($updatedData)) {
        if ($userController->updateUser($userId, $updatedData)) {
            $successMessage = "User updated successfully.";
        } else {
            $errorMessage = "Failed to update user.";
        }
    } else {
        $errorMessage = "No data provided for update.";
    }
}

if (!isset($_POST['user_id'])) {
    header("Location: get_users.php");
    exit();
}

$userId = $_POST['user_id'];

$user = $userController->getUserById($userId);

if (!$user) {
    header("Location: get_users.php?error=user_not_found");
    exit();
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="form.css" >
    <title>Update User</title>
</head>

<body>
    <?php require_once __DIR__ . "/../admin_navbar.php"; ?>
    <h1>Update User</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <input type="hidden" name="user_id" value="<?php echo $userId; ?>">

        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo isset($user['first_name']) ? htmlspecialchars($user['first_name']) : ''; ?>" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo isset($user['last_name']) ? htmlspecialchars($user['last_name']) : ''; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo isset($user['email']) ? htmlspecialchars($user['email']) : ''; ?>" required><br>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*"><br>

        <label for="room_name">Room:</label>
        <!-- <input type="text" name="room_name" id="room_name" value="<?php echo isset($user['room_name']) ? htmlspecialchars($user['room_name']) : ''; ?>" required><br> -->
        <?php require_once __DIR__ . "/../room/dropDown.php"; ?>
        <button type="submit">Update User</button>
        <a href="get_users.php"><button type="button">Back</button></a>
    </form>

    <?php
