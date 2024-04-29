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
            
            // Check if email exists
            $check_stmt = $pdo->prepare("SELECT COUNT(*) FROM users WHERE email = :email");
            $check_stmt->bindParam(':email', $_POST['email']);
            $check_stmt->execute();
            $email_exists = $check_stmt->fetchColumn();
            
            if ($email_exists) {
                // Send email to user
                $mail = new PHPMailer(true);

                //Server settings
                $mail->isSMTP();
                $mail->Host       = 'smtp.gmail.com'; // SMTP server
                $mail->SMTPAuth   = true;
                $mail->Username   = 'fathishimaa218@gmail.com'; // SMTP username
                $mail->Password   = 'dlxs wwvk evms inna'; // SMTP password
                $mail->SMTPSecure = 'ssl';
                $mail->Port       = 465;

                //Recipients
                $mail->setFrom('fathishimaa218@gmail.com', 'cafe');
                $mail->addAddress($_POST['email']); // User's email

                // Content
                $mail->isHTML(true);
                $mail->Subject = 'Reset Password';
                $mail->Body    = 'Please click the following link to reset your password: <a href="http://example.com/reset_password.php">Reset Password</a>';

                $mail->send();

                // Update password
                $update_stmt = $pdo->prepare("UPDATE users SET password = :new_password WHERE email = :email");
                $update_stmt->bindParam(':new_password', $_POST['new_password']);
                $update_stmt->bindParam(':email', $_POST['email']);
                $update_stmt->execute();

                $message = "Password updated successfully! Please check your email for further instructions.";
            } else {
                // Email does not exist
                $message = "Email does not exist!";
            }
        } catch(PDOException $e) {
            $message = "Error updating password: " . $e->getMessage();
        } catch (Exception $e) {
            $message = "Error sending email: " . $mail->ErrorInfo;
        }
    } else {
        $message = "Passwords do not match!";
    }
}

// Load view
require_once 'forget_password.php'; 
?>