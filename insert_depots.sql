-- First, make sure the database exists
CREATE DATABASE IF NOT EXISTS nwkrtc_feedback;
USE nwkrtc_feedback;

-- Create the depots table if it doesn't exist
CREATE TABLE IF NOT EXISTS depots (
    code VARCHAR(20) PRIMARY KEY,
    name VARCHAR(255) NOT NULL,
    location VARCHAR(255) NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
);

-- Insert all depots
INSERT INTO depots (code, name, location) VALUES
('BEL_CBT', 'Belagavi City CBT', 'Belagavi'),
('BEL', 'Belagavi', 'Belagavi'),
('KNP', 'Khanapur', 'Khanapur'),
('BLH', 'Bailhongal', 'Bailhongal'),
('SIR_N', 'Sirsi (New)', 'Sirsi'),
('KMT', 'Kumta', 'Kumta'),
('BHT', 'Bhatkal', 'Bhatkal'),
('KRW', 'Karwar', 'Karwar'),
('YLP', 'Yellapur', 'Yellapur'),
('ANK', 'Ankola', 'Ankola'),
('GDG_O', 'Gadag (OBS)', 'Gadag'),
('GDG_N', 'Gadag (NBS)', 'Gadag'),
('BTG', 'Betageri', 'Betageri'),
('MND', 'Mundargi', 'Mundargi'),
('RON', 'Ron', 'Ron'),
('GJD', 'Gajendragad', 'Gajendragad'),
('SHT', 'Shirahatti', 'Shirahatti'),
('NRG', 'Naragund', 'Naragund'),
('LXM_N', 'Laxmeshwar (New)', 'Laxmeshwar'),
('DWD_N', 'Dharwad New B/S', 'Dharwad'),
('DWD_O', 'Dharwad Old B/S', 'Dharwad'),
('DWD_C', 'Dharwad CBT', 'Dharwad'),
('HLY', 'Haliyal', 'Haliyal'),
('DNL', 'Dandeli', 'Dandeli'),
('SVD', 'Savadatti', 'Savadatti'),
('RMD_N', 'Ramadurga (New)', 'Ramadurga'),
('RMD_O', 'Ramadurga (Old)', 'Ramadurga'),
('HBL_N', 'Hubli New B/S', 'Hubli'),
('HBL_C', 'Hubli C.B.T', 'Hubli'),
('HSR', 'Hosur Bus stand', 'Hosur'),
('KLG', 'Kalagatgi', 'Kalagatgi'),
('KND', 'Kundagol', 'Kundagol'),
('NVL', 'Navalgund', 'Navalgund'),
('CKD', 'Chikkodi', 'Chikkodi'),
('RBG', 'Raibag', 'Raibag'),
('SDL', 'Sadlaga', 'Sadlaga'),
('NPN', 'Nippani', 'Nippani'),
('SKW', 'Sankeshwar', 'Sankeshwar'),
('HKR', 'Hukkeri', 'Hukkeri'),
('GKK', 'Gokak', 'Gokak'),
('ATN', 'Athani', 'Athani'),
('BGT_O', 'Bagalkot (OBS)', 'Bagalkot'),
('BGT_N', 'Bagalkot (NBS)', 'Bagalkot'),
('ILK', 'Ilkal', 'Ilkal'),
('HGD', 'Hungund', 'Hungund'),
('BDM', 'Badami', 'Badami'),
('SVD2', 'Savadatti', 'Savadatti'),
('GLD', 'Guledgudda', 'Guledgudda'),
('BLG', 'Bilagi', 'Bilagi'),
('MDL', 'Mudhol', 'Mudhol'),
('LKP', 'Lokapur', 'Lokapur'),
('JMK', 'Jamakhandi', 'Jamakhandi'),
('HVR', 'Haveri', 'Haveri'),
('RNB', 'Ranebennur', 'Ranebennur'),
('HNG', 'Hanagal', 'Hanagal'),
('HKR2', 'Hirekerur', 'Hirekerur'),
('BYD', 'Byadagi', 'Byadagi'),
('SVN', 'Savanur', 'Savanur'),
('SGN_N', 'Shiggoan (New)', 'Shiggoan');

-- Create users table if it doesn't exist
CREATE TABLE IF NOT EXISTS users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    email VARCHAR(255) NOT NULL UNIQUE,
    name VARCHAR(255) NOT NULL,
    phone VARCHAR(20),
    verification_token VARCHAR(64),
    is_verified BOOLEAN DEFAULT FALSE,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
);

-- Create feedback table if it doesn't exist
CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    user_id INT NOT NULL,
    depot_code VARCHAR(20) NOT NULL,
    toilet_cleanliness VARCHAR(20) NOT NULL,
    bus_stand_cleanliness VARCHAR(20) NOT NULL,
    drinking_water VARCHAR(20) NOT NULL,
    toilet_fee VARCHAR(20) NOT NULL,
    overall_rating INT NOT NULL,
    other_comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id),
    FOREIGN KEY (depot_code) REFERENCES depots(code)
); 