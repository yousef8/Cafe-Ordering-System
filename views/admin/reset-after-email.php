<?php
require_once __DIR__ . '/../../utilities/db_connection.php';
require_once __DIR__ . '/../../vendor/autoload.php'; // Include Composer's autoloader

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    if ($_POST['new_password'] == $_POST['confirm_password']) {
        try {
            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
            $dotenv->load();

            $pdo = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);

            // Update password
            $update_stmt = $pdo->prepare("UPDATE users SET password = :new_password WHERE email = :email");
            $update_stmt->bindParam(':new_password', $_POST['new_password']);
            $update_stmt->bindParam(':email', $_POST['email']); // Assuming you have stored the user's email somewhere
            $update_stmt->execute();

            // Check if password updated successfully
            if ($update_stmt->rowCount() > 0) {
                // Password updated successfully, redirect to user/home.php
                header("Location: ../user/home.php");
                exit(); // Make sure to exit after redirecting
            } else {
                $message = "Password update failed!";
            }
        } catch(PDOException $e) {
            $message = "Error updating password: " . $e->getMessage();
        }
    } else {
        $message = "Passwords do not match!";
    }
}

// Load view
require_once 'update_password.php'; 
?>
