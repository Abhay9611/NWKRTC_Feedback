<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NWKRTC Feedback System</title>
    <script src="https://unpkg.com/html5-qrcode"></script>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background: #f8f9fa;
            min-height: 100vh;
            display: flex;
            flex-direction: column;
            align-items: center;
            padding: 2rem;
        }

        .container {
            max-width: 800px;
            width: 100%;
        }

        .card {
            background: white;
            border-radius: 15px;
            box-shadow: 0 4px 20px rgba(0, 0, 0, 0.1);
            padding: 2rem;
            margin-bottom: 2rem;
        }

        .header {
            text-align: center;
            margin-bottom: 2rem;
        }

        .header h1 {
            color: #0d6efd;
            font-weight: 600;
        }

        .header p {
            color: #6c757d;
            margin-top: 1rem;
        }

        #reader {
            width: 100%;
            max-width: 500px;
            margin: 0 auto;
        }

        .instructions {
            margin-top: 2rem;
            text-align: center;
            color: #6c757d;
        }

        .error {
            color: #dc2626;
            margin-top: 1rem;
            text-align: center;
            display: none;
        }

        .qr-link {
            margin-top: 2rem;
            text-align: center;
        }

        .qr-link a {
            color: #0d6efd;
            text-decoration: none;
            display: inline-flex;
            align-items: center;
            gap: 0.5rem;
        }

        .qr-link a:hover {
            text-decoration: underline;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="card">
            <div class="header">
                <h1>NWKRTC Feedback System</h1>
                <p>Scan the QR code at your depot to submit feedback</p>
            </div>

            <div id="reader"></div>
            
            <div class="instructions">
                <p>Please scan the QR code at your depot to access the feedback form.</p>
                <p>ದಯವಿಟ್ಟು ನಿಮ್ಮ ಡಿಪೋದಲ್ಲಿ QR ಕೋಡ್ ಅನ್ನು ಸ್ಕ್ಯಾನ್ ಮಾಡಿ ಪ್ರತಿಕ್ರಿಯೆ ಫಾರ್ಮ್ ಅನ್ನು ಪ್ರವೇಶಿಸಲು.</p>
            </div>

            <div id="error" class="error"></div>

            <div class="qr-link">
                <a href="generate_qr.php">
                    <i class="bi bi-qr-code"></i>
                    Generate Depot QR Codes
                </a>
            </div>
        </div>
    </div>

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        function onScanSuccess(decodedText, decodedResult) {
            // Stop scanning
            html5QrcodeScanner.clear();
            
            // Redirect to scan.php with the depot code
            window.location.href = `scan.php?depot=${decodedText}`;
        }

        function onScanFailure(error) {
            // Handle scan failure
            console.warn(`QR error = ${error}`);
            document.getElementById('error').style.display = 'block';
            document.getElementById('error').textContent = 'Failed to scan QR code. Please try again.';
        }

        let html5QrcodeScanner = new Html5QrcodeScanner(
            "reader",
            { fps: 10, qrbox: {width: 250, height: 250} },
            /* verbose= */ false);
        html5QrcodeScanner.render(onScanSuccess, onScanFailure);
    </script>
</body>
</html>
