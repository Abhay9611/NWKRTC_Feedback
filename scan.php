<?php
session_start();
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

// Get depot code from URL
$depotCode = isset($_GET['depot']) ? strtoupper($_GET['depot']) : '';

// Validate depot code
if (empty($depotCode) || !isset($depots[$depotCode])) {
    $_SESSION['error'] = 'Invalid depot code. Please scan a valid QR code.';
    header('Location: index.php');
    exit;
}

// Store depot code in session
$_SESSION['depot_code'] = $depotCode;
$_SESSION['depot_name'] = $depots[$depotCode];

// Redirect to feedback form
header('Location: feedback.php');
exit;
?> 