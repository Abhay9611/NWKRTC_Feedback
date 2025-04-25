<?php
require_once 'config.php';
session_start();

use PHPMailer\PHPMailer\PHPMailer;
use PHPMailer\PHPMailer\Exception;

require 'vendor/autoload.php';

function sendVerificationEmail($email, $name, $token) {
    $mail = new PHPMailer(true);
    
    try {
        // Server settings
        $mail->isSMTP();
        $mail->Host = SMTP_HOST;
        $mail->SMTPAuth = true;
        $mail->Username = SMTP_USERNAME;
        $mail->Password = SMTP_PASSWORD;
        $mail->SMTPSecure = PHPMailer::ENCRYPTION_STARTTLS;
        $mail->Port = SMTP_PORT;
        
        // Recipients
        $mail->setFrom(SMTP_FROM_EMAIL, SMTP_FROM_NAME);
        $mail->addAddress($email, $name);
        
        // Content
        $mail->isHTML(true);
        $mail->Subject = 'Verify your email - NWKRTC Feedback System';
        $mail->Body = "
            <h2>Email Verification</h2>
            <p>Dear $name,</p>
            <p>Thank you for submitting your feedback. Please verify your email by clicking the link below:</p>
            <p><a href='http://" . $_SERVER['HTTP_HOST'] . "/verify_email.php?token=$token'>Verify Email</a></p>
            <p>If you did not submit any feedback, please ignore this email.</p>
            <p>Best regards,<br>NWKRTC Team</p>
        ";
        
        $mail->send();
        return true;
    } catch (Exception $e) {
        error_log("Mailer Error: " . $mail->ErrorInfo);
        return false;
    }
}

if ($_SERVER['REQUEST_METHOD'] === 'POST') {
    try {
        $conn = getDBConnection();
        
        // Get form data
        $depotCode = $_POST['depotCode'];
        $email = $_POST['email'] ?? null;
        $name = $_POST['name'] ?? null;
        $gender = $_POST['gender'];
        $phone = $_POST['phone'];
        $toiletCleanliness = $_POST['toiletCleanliness'];
        $busStandCleanliness = $_POST['busStandCleanliness'];
        $drinkingWater = $_POST['drinkingWater'];
        $toiletFee = $_POST['toiletFee'];
        $overallRating = $_POST['overallRating'];
        $otherComments = $_POST['otherComments'];
        
        // Check if user is already verified
        if (isset($_SESSION['user_id'])) {
            $userId = $_SESSION['user_id'];
        } else {
            // Generate verification token
            $token = bin2hex(random_bytes(32));
            
            // Insert user data
            $stmt = $conn->prepare("INSERT INTO users (email, name, phone, verification_token) VALUES (?, ?, ?, ?)");
            $stmt->execute([$email, $name, $phone, $token]);
            $userId = $conn->lastInsertId();
            
            // Send verification email
            if (!sendVerificationEmail($email, $name, $token)) {
                throw new Exception("Failed to send verification email");
            }
            
            $_SESSION['success'] = "Please check your email to verify your account before submitting feedback.";
            header("Location: feedback.php?depot=" . urlencode($depotCode));
            exit;
        }
        
        // Insert feedback
        $stmt = $conn->prepare("
            INSERT INTO feedback (
                user_id, depot_code, toilet_cleanliness, bus_stand_cleanliness,
                drinking_water, toilet_fee, overall_rating, other_comments
            ) VALUES (?, ?, ?, ?, ?, ?, ?, ?)
        ");
        
        $stmt->execute([
            $userId, $depotCode, $toiletCleanliness, $busStandCleanliness,
            $drinkingWater, $toiletFee, $overallRating, $otherComments
        ]);
        
        $_SESSION['success'] = "Thank you for your feedback! / ನಿಮ್ಮ ಪ್ರತಿಕ್ರಿಯೆಗೆ ಧನ್ಯವಾದಗಳು!";
        
    } catch (Exception $e) {
        error_log("Feedback submission error: " . $e->getMessage());
        $_SESSION['error'] = "An error occurred. Please try again later.";
    }
    
    header("Location: feedback.php?depot=" . urlencode($depotCode));
    exit;
}
?> 