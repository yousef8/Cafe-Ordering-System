<?php
require_once __DIR__ . '/../../utilities/db_connection.php';

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {

    if ($_POST['new_password'] == $_POST['confirm_password']) {
        try {

            $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../');
            $dotenv->load();

            $pdo = new PDO($_ENV['DB_DSN'], $_ENV['DB_USER'], $_ENV['DB_PASSWORD']);
            $pdo->setAttribute(PDO::ATTR_ERRMODE, PDO::ERRMODE_EXCEPTION);
            
            // Check if email exists
            $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $check_stmt->bindParam(':email', $_POST['email']);
            $check_stmt->execute();
            $email_exists = $check_stmt->fetchColumn();
            
            if ($email_exists) {
                // Email exists, proceed with password update
                $update_stmt = $pdo->prepare("UPDATE users SET password = :new_password WHERE email = :email");
                $update_stmt->bindParam(':new_password', $_POST['new_password']);
                $update_stmt->bindParam(':email', $_POST['email']);
                $update_stmt->execute();
                $message = "Password updated successfully!";
            } else {
                // Email does not exist
                $message = "Email does not exist!";
            }
        } catch(PDOException $e) {
            $message = "Error updating password: " . $e->getMessage();
        }
    } else {
        $message = "Passwords do not match!";
    }
}

// Load view
require_once 'forget_password.php'; 
?>
