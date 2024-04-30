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
        $_SESSION['first_name'] = $user['first_name'];
        $_SESSION['last_name'] = $user['last_name'];
        $_SESSION['image_url'] = $user['image_url'];
        $_SESSION['is_admin'] = $user['is_admin'];
        if ($_SESSION['is_admin'] == 1) {
            header("Location: dashboard.php");
        } else {
            header("Location: ../user/home.php");
        }
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
    <link rel="stylesheet" href="login.css" >

    <title>Login</title>
</head>
<body>
    <h1>Login</h1>
    <form action="" method="POST">
        <label for="email">Email:</label>
        <input type="email" name="email" id="email" required><br>
        <label for="password">Password:</label>
        <div class="password-container">
                <input type="password" name="password" id="password" required>
                <span class="toggle-password" onclick="togglePasswordVisibility()">
                    <i class="fas fa-eye"></i>
                </span>
        </div>
        <button type="submit">Login</button>
        <div class="mt-3">
    <a href="../admin/reset-password/reset_password.php">Forgot your password? Reset it here.</a>
</div>
    </form>
    <?php if (isset($errorMessage)): ?>
        <p><?php echo $errorMessage; ?></p>
    <?php endif; ?>

    <script src="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/5.15.4/js/all.min.js"></script>
    <script>
        function togglePasswordVisibility() {
            var passwordInput = document.getElementById("password");
            var toggleButton = document.querySelector(".toggle-password");

            if (passwordInput.type === "password") {
                passwordInput.type = "text";
                toggleButton.innerHTML = '<i class="fas fa-eye-slash"></i>';
            } else {
                passwordInput.type = "password";
                toggleButton.innerHTML = '<i class="fas fa-eye"></i>';
            }
        }
    </script>
</body>
</html>
