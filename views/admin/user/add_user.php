<?php
ini_set('display_errors', 1);
ini_set('display_startup_errors', 1);
error_reporting(E_ALL);

$errors = [];

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
        $errors['email'] = "Invalid email format";
    }
   
    $password = $_POST['password'];
    $confirm_password = $_POST['confirm_password'];
    if (strlen($password) < 6) {
        $errors['password'] = "Password must be at least 6 characters long";
    } elseif ($password !== $confirm_password) {
        $errors['confirm_password'] = "Passwords do not match";
    }

    if ($_FILES['image']['error'] !== UPLOAD_ERR_OK) {
        $errors['image'] = "Error uploading file";
    } else {
        $file_type = $_FILES['image']['type'];
        if ($file_type !== 'image/jpeg' && $file_type !== 'image/png') {
            $errors['image'] = "Invalid image format. Please upload JPEG or PNG files.";
        }
    }

    if (empty($errors)) {
        require_once __DIR__ . '/../../../utilities/db_connection.php';
        require_once __DIR__ . '/../../../controllers/user_controller.php';

        $userController = new UserController($conn);

        //$targetDir = "../../../uploads-user/";
        $targetFile = basename($_FILES["image"]["name"] ?? "");

        if (move_uploaded_file($_FILES["image"]["tmp_name"], $targetFile)) {
            $data = [
                'first_name' => $_POST['first_name'],
                'last_name' => $_POST['last_name'],
                'email' => $email,
                'password' => $password,
                'image_url' => $targetFile,
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
}
?>

<!DOCTYPE html>
<html lang="en">

<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet" integrity="sha384-QWTKZyjpPEjISv5WaRU9OFeRpok6YctnYmDr5pNlyT2bRjXh0JMhjY6hW+ALEwIH" crossorigin="anonymous">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/css/all.min.css">
    <link rel="stylesheet" href="form.css">
    <title>Add User</title>
</head>

<body>
    <?php require_once __DIR__ . "/../../user/user_navbar.php"; ?>
    <h1>Add User</h1>

    <?php if (!empty($errors)): ?>
        <div class="alert alert-danger">
            <ul>
                <?php foreach ($errors as $error): ?>
                    <li><?php echo $error; ?></li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>

    <form id="userForm" action="" method="post" enctype="multipart/form-data">
        <label for="first_name">First Name:</label>
        <input type="text" name="first_name" id="first_name" value="<?php echo isset($_POST['first_name']) ? htmlspecialchars($_POST['first_name']) : ''; ?>" required><br>

        <label for="last_name">Last Name:</label>
        <input type="text" name="last_name" id="last_name" value="<?php echo isset($_POST['last_name']) ? htmlspecialchars($_POST['last_name']) : ''; ?>" required><br>

        <label for="email">Email:</label>
        <input type="email" name="email" id="email" value="<?php echo isset($_POST['email']) ? htmlspecialchars($_POST['email']) : ''; ?>" required><br>

        <label for="password">Password:</label>
        <input type="password" name="password" id="password" ><br>

        <label for="confirm_password">Confirm Password:</label>
        <input type="password" name="confirm_password" id="confirm_password" ><br>

        <label for="image">Image:</label>
        <input type="file" name="image" id="image" accept="image/*" ><br>

        <label for="room_name">Room:</label>
        <?php require_once __DIR__ . "/../room/dropDown.php"; ?>

        <label for="is_admin">Is Admin:</label>
        <input type="checkbox" name="is_admin" id="is_admin"><br>

        <button type="submit">Add User</button>
        <button type="reset">Reset</button>
    </form>
</body>

</html>
