<?php
header('Content-Type: application/json');

// Database connection parameters
$servername = "localhost";
$username = "root";  // Replace with your database username
$password = "";      // Replace with your database password
$dbname = "feedback_db";  // Replace with your database name

try {
    // Create connection
    $conn = new mysqli($servername, $username, $password, $dbname);

    // Check connection
    if ($conn->connect_error) {
        throw new Exception("Connection failed: " . $conn->connect_error);
    }

    // Get JSON data from request
    $json = file_get_contents('php://input');
    $data = json_decode($json, true);

    // Prepare SQL statement
    $stmt = $conn->prepare("INSERT INTO feedback (
        depot_code, email, name, gender, phone, toilet_cleanliness, 
        bus_stand_cleanliness, traffic_controller_behavior, 
        drinking_water, toilet_fee, overall_rating, other_comments
    ) VALUES (?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?, ?)");

    // Bind parameters
    $stmt->bind_param("ssssssssssis", 
        $data['depot_code'],
        $data['email'],
        $data['name'],
        $data['gender'],
        $data['phone'],
        $data['toiletCleanliness'],
        $data['busStandCleanliness'],
        $data['trafficControllerBehavior'],
        $data['drinkingWater'],
        $data['toiletFee'],
        $data['overallRating'],
        $data['otherComments']
    );

    // Execute statement
    if ($stmt->execute()) {
        echo json_encode(['success' => true, 'message' => 'Feedback submitted successfully']);
    } else {
        throw new Exception("Error: " . $stmt->error);
    }

    // Close statement and connection
    $stmt->close();
    $conn->close();

} catch (Exception $e) {
    http_response_code(500);
    echo json_encode(['success' => false, 'message' => $e->getMessage()]);
}
?> 