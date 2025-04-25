<?php
require_once 'config.php';
session_start();

// Get depot code from URL
$depotCode = $_GET['depot'] ?? '';

// Validate depot code
if (empty($depotCode)) {
    die("Invalid depot code");
}

// Get depot name from database
$stmt = $conn->prepare("SELECT name FROM depots WHERE code = ?");
$stmt->bind_param("s", $depotCode);
$stmt->execute();
$result = $stmt->get_result();

if ($result->num_rows === 0) {
    die("Depot not found");
}

$depot = $result->fetch_assoc();
$depotName = $depot['name'];

// Display success/error messages
$success = $_SESSION['success'] ?? '';
$error = $_SESSION['error'] ?? '';
unset($_SESSION['success'], $_SESSION['error']);
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0"/>
    <title>Feedback Form - <?php echo htmlspecialchars($depotName); ?></title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
        }

        .feedback-card {
            background: white;
            max-width: 800px;
            margin: 2rem auto;
            padding: 2rem;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
        }

        .depot-header {
            color: #0d6efd;
            margin-bottom: 2rem;
            text-align: center;
            font-weight: 600;
        }

        .form-label {
            font-weight: 500;
            color: #495057;
        }

        .form-control, .form-select {
            border-radius: 8px;
            padding: 0.75rem;
            border: 1px solid #ced4da;
        }

        .form-control:focus, .form-select:focus {
            border-color: #86b7fe;
            box-shadow: 0 0 0 0.25rem rgba(13, 110, 253, 0.25);
        }

        .rating-stars {
            display: flex;
            gap: 1rem;
            justify-content: center;
            margin: 1rem 0;
        }

        .rating-stars input[type="radio"] {
            display: none;
        }

        .rating-stars label {
            font-size: 2rem;
            color: #ffc107;
            cursor: pointer;
        }

        .rating-stars input[type="radio"]:checked ~ label {
            color: #ffc107;
        }

        .btn-submit {
            background: #0d6efd;
            border: none;
            padding: 0.75rem 2rem;
            font-weight: 500;
            transition: all 0.3s ease;
        }

        .btn-submit:hover {
            background: #0b5ed7;
            transform: translateY(-2px);
        }

        .alert {
            border-radius: 8px;
            margin-bottom: 1.5rem;
        }

        .verification-badge {
            background: #198754;
            color: white;
            padding: 0.5rem 1rem;
            border-radius: 20px;
            font-size: 0.9rem;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="feedback-card">
            <?php if ($success): ?>
                <div class="alert alert-success">
                    <?php 
                    echo $success;
                    ?>
                </div>
            <?php endif; ?>

            <?php if ($error): ?>
                <div class="alert alert-danger">
                    <?php 
                    echo $error;
                    ?>
                </div>
            <?php endif; ?>

            <h2 class="depot-header">
                <?php echo htmlspecialchars($depotName); ?> Feedback Form
            </h2>

            <form id="feedbackForm" action="submit_feedback.php" method="POST">
                <input type="hidden" name="depot_code" value="<?php echo htmlspecialchars($depotCode); ?>" />
                
                <div class="mb-4">
                    <label for="rating" class="form-label">Overall Rating</label>
                    <div class="rating-stars">
                        <input type="radio" name="rating" value="5" id="star5" required>
                        <label for="star5"><i class="bi bi-star-fill"></i></label>
                        <input type="radio" name="rating" value="4" id="star4">
                        <label for="star4"><i class="bi bi-star-fill"></i></label>
                        <input type="radio" name="rating" value="3" id="star3">
                        <label for="star3"><i class="bi bi-star-fill"></i></label>
                        <input type="radio" name="rating" value="2" id="star2">
                        <label for="star2"><i class="bi bi-star-fill"></i></label>
                        <input type="radio" name="rating" value="1" id="star1">
                        <label for="star1"><i class="bi bi-star-fill"></i></label>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="feedback" class="form-label">Your Feedback</label>
                    <textarea class="form-control" id="feedback" name="feedback" rows="4" required></textarea>
                </div>

                <div class="mb-4">
                    <label for="name" class="form-label">Name (Optional)</label>
                    <input type="text" class="form-control" id="name" name="name">
                </div>

                <div class="mb-4">
                    <label for="contact" class="form-label">Contact Number (Optional)</label>
                    <input type="tel" class="form-control" id="contact" name="contact">
                </div>

                <button type="submit" class="btn btn-primary btn-submit w-100">
                    Submit Feedback
                </button>
            </form>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        // Add star rating interaction
        document.querySelectorAll('.rating-stars input[type="radio"]').forEach(radio => {
            radio.addEventListener('change', function() {
                const stars = document.querySelectorAll('.rating-stars label');
                stars.forEach((star, index) => {
                    if (index < this.value) {
                        star.style.color = '#ffc107';
                    } else {
                        star.style.color = '#e4e5e9';
                    }
                });
            });
        });
    </script>
</body>
</html> 