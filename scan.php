<?php
// Get the depot code from the URL
$depotCode = isset($_GET['depot']) ? $_GET['depot'] : '';

// Validate depot code
if (empty($depotCode)) {
    die("Invalid depot code");
}

// Include database connection
require_once 'config.php';

// Get depot name from database
$stmt = $conn->prepare("SELECT depot_name FROM depots WHERE depot_code = ?");
$stmt->bind_param("s", $depotCode);
$stmt->execute();
$result = $stmt->get_result();
$depot = $result->fetch_assoc();

if (!$depot) {
    die("Depot not found");
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Feedback Form - <?php echo htmlspecialchars($depot['depot_name']); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/css/bootstrap.min.css" rel="stylesheet">
    <style>
        .feedback-form {
            max-width: 600px;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 10px;
            box-shadow: 0 0 10px rgba(0,0,0,0.1);
        }
        .depot-header {
            text-align: center;
            margin-bottom: 2rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="feedback-form">
            <div class="depot-header">
                <h2><?php echo htmlspecialchars($depot['depot_name']); ?></h2>
                <p class="text-muted">Please provide your feedback below</p>
            </div>
            
            <form action="submit_feedback.php" method="POST">
                <input type="hidden" name="depot_code" value="<?php echo htmlspecialchars($depotCode); ?>">
                
                <div class="mb-3">
                    <label for="rating" class="form-label">Overall Rating</label>
                    <select class="form-select" id="rating" name="rating" required>
                        <option value="">Select rating</option>
                        <option value="5">Excellent</option>
                        <option value="4">Good</option>
                        <option value="3">Average</option>
                        <option value="2">Poor</option>
                        <option value="1">Very Poor</option>
                    </select>
                </div>
                
                <div class="mb-3">
                    <label for="feedback" class="form-label">Your Feedback</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
                </div>
                
                <div class="mb-3">
                    <label for="name" class="form-label">Your Name (Optional)</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>
                
                <div class="mb-3">
                    <label for="contact" class="form-label">Contact Number (Optional)</label>
                    <input type="tel" class="form-control" id="contact" name="contact">
                </div>
                
                <button type="submit" class="btn btn-primary w-100">Submit Feedback</button>
            </form>
        </div>
    </div>
    
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.1.3/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 