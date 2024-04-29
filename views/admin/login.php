<?php
session_start(); // Start the session

require_once __DIR__ . '/../../models/user.php';
require_once __DIR__ . '/../../utilities/db_connection.php';
require_once __DIR__ . '/../../controllers/user_controller.php';

$userController = new UserController($conn);

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    $email = $_POST['email'];
    $password = $_POST['password'];
    $user = $userController->login($email, $password);

    if ($user) {
        var_dump("logged");
        $_SESSION['user_id'] = $user['id'];
        $_SESSION['email'] = $user['email'];
        $_SESSION['image_url'] = $user['image_url'];
        $_SESSION['is_admin'] = $user['is_admin'];
        // check the route to the user and admin landing page
        // if ($_SESSION['is_admin'] == 1) {
        //     header("Location: admin_navbar.php");
        // } else {
        //     header("Location: user_dashboard.php");
        // }
        exit();
    } else {
        $errorMessage = "Invalid email or password. Please try again.";
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password:</label>
        <input type="password" name="password" id="password" required><br>
        <button type="submit">Login</button>
    </form>
    <?php if (isset($errorMessage)): ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>
</body>
</html>
