<?php
require_once 'config.php';
session_start();

if (!isset($_GET['token'])) {
    header('Location: index.php');
    exit;
}

$token = $_GET['token'];

try {
    $conn = getDBConnection();
    
    // Find user with this token
    $stmt = $conn->prepare("SELECT id, email FROM users WHERE verification_token = ? AND is_verified = 0");
    $stmt->execute([$token]);
    $user = $stmt->fetch(PDO::FETCH_ASSOC);
    
    if ($user) {
        // Mark user as verified
        $stmt = $conn->prepare("UPDATE users SET is_verified = 1, verification_token = NULL WHERE id = ?");
        $stmt->execute([$user['id']]);
        
        $_SESSION['success'] = "Email verified successfully! You can now submit your feedback.";
        $_SESSION['user_id'] = $user['id'];
    } else {
        $_SESSION['error'] = "Invalid or expired verification link.";
    }
    
} catch(PDOException $e) {
    error_log("Verification error: " . $e->getMessage());
    $_SESSION['error'] = "An error occurred. Please try again later.";
}

header('Location: feedback.php');
exit;
?> 