CREATE DATABASE IF NOT EXISTS feedback_db;
USE feedback_db;

CREATE TABLE IF NOT EXISTS feedback (
    id INT AUTO_INCREMENT PRIMARY KEY,
    depot_code VARCHAR(10) NOT NULL,
    email VARCHAR(255) NOT NULL,
    name VARCHAR(255) NOT NULL,
    gender ENUM('male', 'female') NOT NULL,
    phone VARCHAR(20),
    toilet_cleanliness ENUM('very_poor', 'poor', 'average', 'good', 'excellent') NOT NULL,
    bus_stand_cleanliness ENUM('very_poor', 'poor', 'average', 'good', 'excellent') NOT NULL,
    traffic_controller_behavior ENUM('very_poor', 'poor', 'average', 'good', 'excellent') NOT NULL,
    drinking_water ENUM('not_available', 'unsatisfactory', 'satisfactory') NOT NULL,
    toilet_fee ENUM('prescribed', 'more') NOT NULL,
    overall_rating INT NOT NULL CHECK (overall_rating BETWEEN 1 AND 5),
    other_comments TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
); 