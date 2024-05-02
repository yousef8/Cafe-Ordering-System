<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);
?>
<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <title>Add User</title>
</head>

<body>
    <?php require_once __DIR__ . "/../admin_navbar.php"; ?>
    <h1>Add User</h1>
    <form action="" method="post" enctype="multipart/form-data">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*" required><br>

        <label for="room_name">Room:</label>
        <input type="text" name="room_name" id="room_name" required><br>

        <label for="is_admin">Is Admin:</label>
        <input type="checkbox" name="is_admin" id="is_admin"><br>

        <button type="submit">Add User</button>
        <button type="reset">Reset</button>
    </form>

    <?php
    require_once __DIR__ . '/../../../utilities/db_connection.php';
    require_once __DIR__ . '/../../../controllers/user_controller.php';

    if ($_SERVER["REQUEST_METHOD"] == "POST") {
        $userController = new UserController($conn);

        $targetDir = "../../../uploads-user/";
        $targetFile = $targetDir . basename($_FILES["image"]["name"] ?? "");

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $_POST['email'],
                'password' => $_POST['password'],
                'image_url' => $_FILES["image"]["name"],
                'room_name' => $_POST['room_name'],
                'is_admin' => isset($_POST['is_admin']) ? 1 : 0
            ];

            if ($userController->create($data)) {
                echo "<p>User added successfully.</p>";
            } else {
                echo "<p>Failed to add user.</p>";
            }
        } else {
            echo "Sorry, there was an error uploading your file.";
        }
    }
    ?>
</body>

</html>