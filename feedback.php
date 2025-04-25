<?php
require_once 'config.php';
session_start();

// Check if depot information is set in session
if (!isset($_SESSION['depot_code']) || !isset($_SESSION['depot_name'])) {
    $_SESSION['error'] = 'Please scan a valid QR code to access the feedback form.';
    header('Location: index.php');
    exit;
}

$depotCode = $_SESSION['depot_code'];
$depotName = $_SESSION['depot_name'];

// Check if user is verified
$isVerified = isset($_SESSION['user_id']) && $_SESSION['user_id'];
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
            <?php if (isset($_SESSION['success'])): ?>
                <div class="alert alert-success">
                    <?php 
                    echo $_SESSION['success'];
                    unset($_SESSION['success']);
                    ?>
                </div>
            <?php endif; ?>

            <?php if (isset($_SESSION['error'])): ?>
                <div class="alert alert-danger">
                    <?php 
                    echo $_SESSION['error'];
                    unset($_SESSION['error']);
                    ?>
                </div>
            <?php endif; ?>

            <h2 class="depot-header">
                <?php echo htmlspecialchars($depotName); ?> Feedback Form
                <?php if ($isVerified): ?>
                    <span class="verification-badge">
                        <i class="bi bi-check-circle-fill"></i>
                        Verified
                    </span>
                <?php endif; ?>
            </h2>

            <form id="feedbackForm" action="submit_feedback.php" method="POST">
                <input type="hidden" name="depotCode" value="<?php echo htmlspecialchars($depotCode); ?>" />
                
                <?php if (!$isVerified): ?>
                    <div class="mb-4">
                        <label for="email" class="form-label">Email / ಇಮೇಲ್ *</label>
                        <input type="email" class="form-control" id="email" name="email" required />
                    </div>

                    <div class="mb-4">
                        <label for="name" class="form-label">Name / ಹೆಸರು *</label>
                        <input type="text" class="form-control" id="name" name="name" required />
                    </div>
                <?php endif; ?>

                <div class="mb-4">
                    <label class="form-label">Gender / ಲಿಂಗ *</label>
                    <div class="d-flex gap-4">
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="male" id="male" required />
                            <label class="form-check-label" for="male">Male / ಗಂಡು</label>
                        </div>
                        <div class="form-check">
                            <input class="form-check-input" type="radio" name="gender" value="female" id="female" />
                            <label class="form-check-label" for="female">Female / ಹೆಣ್ಣು</label>
                        </div>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="phone" class="form-label">Phone No / ದೂರವಾಣಿ ಸಂಖ್ಯೆ (Optional)</label>
                    <input type="tel" class="form-control" id="phone" name="phone" />
                </div>

                <div class="mb-4">
                    <label for="toiletCleanliness" class="form-label">Toilet Cleanliness / ಶೌಚಾಲಯದ ಸ್ವಚ್ಛತೆ *</label>
                    <select class="form-select" id="toiletCleanliness" name="toiletCleanliness" required>
                        <option value="">Select rating</option>
                        <option value="very_poor">Very Poor/ಅತೀ ಕಳಪೆ</option>
                        <option value="poor">Poor/ಕಳಪೆ</option>
                        <option value="average">Average/ಸಾಧಾರಣ</option>
                        <option value="good">Good/ಉತ್ತಮ</option>
                        <option value="excellent">Excellent/ಅತ್ಯುತ್ತಮ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="busStandCleanliness" class="form-label">Bus Stand Cleanliness / ಬಸ್‌ ನಿಲ್ದಾಣದ ಸ್ವಚ್ಛತೆ *</label>
                    <select class="form-select" id="busStandCleanliness" name="busStandCleanliness" required>
                        <option value="">Select rating</option>
                        <option value="very_poor">Very Poor/ಅತೀ ಕಳಪೆ</option>
                        <option value="poor">Poor/ಕಳಪೆ</option>
                        <option value="average">Average/ಸಾಧಾರಣ</option>
                        <option value="good">Good/ಉತ್ತಮ</option>
                        <option value="excellent">Excellent/ಅತ್ಯುತ್ತಮ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="drinkingWater" class="form-label">Drinking Water Facility / ಕುಡಿಯುವ ನೀರಿನ ವ್ಯವಸ್ಥೆ *</label>
                    <select class="form-select" id="drinkingWater" name="drinkingWater" required>
                        <option value="">Select option</option>
                        <option value="not_available">Not Available / ಇರುವುದಿಲ್ಲ</option>
                        <option value="unsatisfactory">Unsatisfactory / ಅತೃಪ್ತಿಕರ</option>
                        <option value="satisfactory">Satisfactory / ತೃಪ್ತಿಕರ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label for="toiletFee" class="form-label">Fee Collected for Usage of Toilets / ಶೌಚಾಲಯ ಬಳಕೆಗೆ ಶುಲ್ಕ *</label>
                    <select class="form-select" id="toiletFee" name="toiletFee" required>
                        <option value="">Select option</option>
                        <option value="prescribed">Prescribed Fee (Rs. 5) / ನಿಗದಿತ ಶುಲ್ಕ</option>
                        <option value="more">Charged More / ಹೆಚ್ಚಿನ ಶುಲ್ಕ</option>
                    </select>
                </div>

                <div class="mb-4">
                    <label class="form-label">Overall Rating / ಒಟ್ಟಾರೆ ಶ್ರೇಣಿ *</label>
                    <div class="rating-stars">
                        <?php for ($i = 1; $i <= 5; $i++): ?>
                            <input type="radio" name="overallRating" value="<?php echo $i; ?>" id="rating<?php echo $i; ?>" required />
                            <label for="rating<?php echo $i; ?>"><i class="bi bi-star-fill"></i></label>
                        <?php endfor; ?>
                    </div>
                </div>

                <div class="mb-4">
                    <label for="otherComments" class="form-label">Other Comments / ಇತರೆ ಅನಿಸಿಕೆಗಳು (Optional)</label>
                    <textarea class="form-control" id="otherComments" name="otherComments" rows="4"></textarea>
                </div>

                <button type="submit" class="btn btn-primary btn-submit w-100">
                    Submit Feedback / ಪ್ರತಿಕ್ರಿಯೆ ಸಲ್ಲಿಸಿ
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