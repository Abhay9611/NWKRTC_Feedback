<?php
require_once 'config.php';

// List of all NWKRTC depots with new codes
$depots = [
    'BEL_CBT' => 'Belagavi City CBT',
    'BEL' => 'Belagavi',
    'KNP' => 'Khanapur',
    'BLH' => 'Bailhongal',
    'SIR_N' => 'Sirsi (New)',
    'KMT' => 'Kumta',
    'BHT' => 'Bhatkal',
    'KRW' => 'Karwar',
    'YLP' => 'Yellapur',
    'ANK' => 'Ankola',
    'GDG_O' => 'Gadag (OBS)',
    'GDG_N' => 'Gadag (NBS)',
    'BTG' => 'Betageri',
    'MND' => 'Mundargi',
    'RON' => 'Ron',
    'GJD' => 'Gajendragad',
    'SHT' => 'Shirahatti',
    'NRG' => 'Naragund',
    'LXM_N' => 'Laxmeshwar (New)',
    'DWD_N' => 'Dharwad New B/S',
    'DWD_O' => 'Dharwad Old B/S',
    'DWD_C' => 'Dharwad CBT',
    'HLY' => 'Haliyal',
    'DNL' => 'Dandeli',
    'SVD' => 'Savadatti',
    'RMD_N' => 'Ramadurga (New)',
    'RMD_O' => 'Ramadurga (Old)',
    'HBL_N' => 'Hubli New B/S',
    'HBL_C' => 'Hubli C.B.T',
    'HSR' => 'Hosur Bus stand',
    'KLG' => 'Kalagatgi',
    'KND' => 'Kundagol',
    'NVL' => 'Navalgund',
    'CKD' => 'Chikkodi',
    'RBG' => 'Raibag',
    'SDL' => 'Sadlaga',
    'NPN' => 'Nippani',
    'SKW' => 'Sankeshwar',
    'HKR' => 'Hukkeri',
    'GKK' => 'Gokak',
    'ATN' => 'Athani',
    'BGT_O' => 'Bagalkot (OBS)',
    'BGT_N' => 'Bagalkot (NBS)',
    'ILK' => 'Ilkal',
    'HGD' => 'Hungund',
    'BDM' => 'Badami',
    'SVD2' => 'Savadatti',
    'GLD' => 'Guledgudda',
    'BLG' => 'Bilagi',
    'MDL' => 'Mudhol',
    'LKP' => 'Lokapur',
    'JMK' => 'Jamakhandi',
    'HVR' => 'Haveri',
    'RNB' => 'Ranebennur',
    'HNG' => 'Hanagal',
    'HKR2' => 'Hirekerur',
    'BYD' => 'Byadagi',
    'SVN' => 'Savanur',
    'SGN_N' => 'Shiggoan (New)'
];

// Function to generate QR code URL using Google Charts API
function generateQRCode($depotCode) {
    $url = "https://abhay9611.github.io/NWKRTC_Feedback/feedback.html?depot=" . $depotCode;
    return "https://api.qrserver.com/v1/create-qr-code/?size=300x300&data=" . urlencode($url);
}

// Function to download QR code
function downloadQRCode($depotCode, $depotName) {
    $qrCodeUrl = generateQRCode($depotCode);
    $ch = curl_init();
    curl_setopt($ch, CURLOPT_URL, $qrCodeUrl);
    curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
    curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
    $imageData = curl_exec($ch);
    
    if (curl_errno($ch)) {
        die('Error downloading QR code: ' . curl_error($ch));
    }
    curl_close($ch);
    
    if ($imageData === false) {
        die('Failed to download QR code image');
    }
    
    header('Content-Type: image/png');
    header('Content-Disposition: attachment; filename="nwkrtc_' . strtolower($depotCode) . '_qr.png"');
    echo $imageData;
    exit;
}

// Handle individual QR code download
if (isset($_GET['download']) && isset($_GET['code'])) {
    $code = $_GET['code'];
    if (isset($depots[$code])) {
        downloadQRCode($code, $depots[$code]);
    }
}

// Handle ZIP download
if (isset($_GET['download_all'])) {
    // Create a temporary directory
    $tempDir = sys_get_temp_dir() . '/nwkrtc_qr_codes_' . time();
    if (!mkdir($tempDir)) {
        die('Failed to create temporary directory');
    }
    
    // Download all QR codes
    foreach ($depots as $code => $name) {
        $qrCodeUrl = generateQRCode($code);
        $ch = curl_init();
        curl_setopt($ch, CURLOPT_URL, $qrCodeUrl);
        curl_setopt($ch, CURLOPT_RETURNTRANSFER, true);
        curl_setopt($ch, CURLOPT_SSL_VERIFYPEER, false);
        $imageData = curl_exec($ch);
        
        if (curl_errno($ch)) {
            curl_close($ch);
            continue;
        }
        curl_close($ch);
        
        if ($imageData !== false) {
            file_put_contents($tempDir . '/nwkrtc_' . strtolower($code) . '_qr.png', $imageData);
        }
    }
    
    // Create ZIP file
    $zipFile = 'nwkrtc_depot_qr_codes.zip';
    $zip = new ZipArchive();
    if ($zip->open($zipFile, ZipArchive::CREATE) === TRUE) {
        $files = glob($tempDir . '/*');
        foreach ($files as $file) {
            $zip->addFile($file, basename($file));
        }
        $zip->close();
        
        // Clean up temporary directory
        array_map('unlink', glob($tempDir . '/*'));
        rmdir($tempDir);
        
        // Send ZIP file
        header('Content-Type: application/zip');
        header('Content-Disposition: attachment; filename="' . $zipFile . '"');
        header('Content-Length: ' . filesize($zipFile));
        readfile($zipFile);
        unlink($zipFile);
        exit;
    }
}
?>
<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>NWKRTC Depot QR Codes</title>
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/bootstrap-icons@1.7.2/font/bootstrap-icons.css">
    <style>
        body {
            background: #f8f9fa;
            padding: 2rem;
        }
        .header {
            text-align: center;
            margin-bottom: 2rem;
        }
        .header h1 {
            color: #0d6efd;
            font-weight: 600;
        }
        .qr-card {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 4px 12px rgba(0, 0, 0, 0.1);
            transition: transform 0.3s ease;
        }
        .qr-card:hover {
            transform: translateY(-5px);
        }
        .qr-image {
            max-width: 300px;
            margin: 0 auto;
            display: block;
        }
        .depot-name {
            text-align: center;
            margin: 1rem 0;
            color: #0d6efd;
            font-weight: 600;
        }
        .download-btn {
            width: 100%;
            margin-top: 1rem;
        }
        .download-all-btn {
            margin-bottom: 2rem;
        }
        .depot-code {
            text-align: center;
            color: #6c757d;
            font-size: 0.9rem;
            margin-top: 0.5rem;
        }
    </style>
</head>
<body>
    <div class="container">
        <div class="header">
            <h1>NWKRTC Depot QR Codes</h1>
            <p class="text-muted">Download all QR codes at once or individually</p>
            <a href="?download_all=1" class="btn btn-primary download-all-btn">
                <i class="bi bi-download"></i> Download All QR Codes
            </a>
        </div>
        
        <div class="row">
            <?php foreach ($depots as $code => $name): ?>
                <div class="col-md-4">
                    <div class="qr-card">
                        <h3 class="depot-name"><?php echo htmlspecialchars($name); ?></h3>
                        <div class="depot-code">Code: <?php echo $code; ?></div>
                        <img src="<?php echo generateQRCode($code); ?>" alt="QR Code for <?php echo htmlspecialchars($name); ?>" class="qr-image">
                        <a href="?download=1&code=<?php echo urlencode($code); ?>" class="btn btn-outline-primary download-btn">
                            <i class="bi bi-download"></i> Download QR Code
                        </a>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>
    </div>
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
</body>
</html> 