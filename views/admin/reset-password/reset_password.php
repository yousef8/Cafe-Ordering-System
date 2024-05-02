<?php
require_once __DIR__ . '/../../../utilities/db_connection.php';
require_once __DIR__ . '/../../../vendor/autoload.php'; 

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

$message = '';

if ($_SERVER["REQUEST_METHOD"] == "POST") {
    try {
        $dotenv = Dotenv\Dotenv::createImmutable(__DIR__.'/../../../');
        $dotenv->load();

        $check_stmt = $conn->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
        $check_stmt->bindParam(':email', $_POST['email']);
        $check_stmt->execute();
        $email_exists = $check_stmt->fetchColumn();
        
        if ($email_exists) {
            $mail = new PHPMailer(true);

            // Load SMTP settings from .env
            $mail->isSMTP();
            $mail->Host       = $_ENV['SMTP_HOST'];
            $mail->SMTPAuth   = true;
            $mail->Username   = $_ENV['SMTP_USERNAME'];
            $mail->Password   = $_ENV['SMTP_PASSWORD'];
            $mail->SMTPSecure = $_ENV['SMTP_SECURE'];
            $mail->Port       = $_ENV['SMTP_PORT'];

            //Recipients
            $mail->setFrom($_ENV['SMTP_USERNAME'], 'cafe');
            $mail->addAddress($_POST['email']); // User's email

            // Content
            $mail->isHTML(true);
            $mail->Subject = 'Reset Password';
            $mail->Body    = 'Please click the following link to reset your password: <a href="http://localhost/Cafe-ordering-system/views/admin/reset-password/reset-after-email.php">Reset Password</a>';

            $mail->send();

            $message = "Password reset instructions have been sent to your email address.";
        } else {
            // Email does not exist
            $message = "Email does not exist!";
        }
    } catch(Exception $e) {
        $message = "Error: " . $e->getMessage();
    }
}

require_once 'forget_password.php'; 
?>
