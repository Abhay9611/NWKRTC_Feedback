# NWKRTC Feedback System

A QR Code-based feedback collection system for NWKRTC bus stations. This system allows passengers to provide feedback about various aspects of bus stations by scanning QR codes placed at each location.

## Features

- **QR Code Generation**: Generate unique QR codes for each bus station
- **Bilingual Support**: Forms available in both English and Kannada
- **Comprehensive Feedback**: Collect feedback about:
  - Toilet Cleanliness
  - Bus Stand Cleanliness
  - Drinking Water Facilities
  - Toilet Usage Fees
  - Overall Experience
- **User Verification**: Email verification system for feedback submission
- **Mobile Responsive**: Works seamlessly on all devices

## Setup

1. Clone the repository:
   ```bash
   git clone https://github.com/yourusername/nwkrtc-feedback.git
   ```

2. Configure your web server (e.g., XAMPP) to serve the project from the `feedback` directory.

3. Import the database schema:
   - Use `schema.sql` to create the database structure
   - Use `insert_depots.sql` to populate depot information

4. Configure the database connection:
   - Copy `config.example.php` to `config.php`
   - Update the database credentials in `config.php`

5. Access the system:
   - QR Code Generation: `http://localhost/feedback/generate_qr.php`
   - Main Page: `http://localhost/feedback/index.php`

## Usage

1. Generate QR codes for all depots using the generation page
2. Download and print the QR codes
3. Place QR codes at respective bus stations
4. Users can scan QR codes to provide feedback
5. Feedback data is stored in the database for analysis

## Directory Structure

```
feedback/
├── config.php           # Database configuration
├── generate_qr.php      # QR code generation page
├── scan.php            # QR code scanning handler
├── feedback.php        # Feedback form
├── submit_feedback.php # Feedback submission handler
├── verify_email.php    # Email verification
├── schema.sql         # Database schema
└── insert_depots.sql  # Depot data
```

## Technologies Used

- PHP 7.4+
- MySQL 5.7+
- Bootstrap 5.3
- QR Code API
- JavaScript/jQuery

## Contributing

1. Fork the repository
2. Create your feature branch (`git checkout -b feature/AmazingFeature`)
3. Commit your changes (`git commit -m 'Add some AmazingFeature'`)
4. Push to the branch (`git push origin feature/AmazingFeature`)
5. Open a Pull Request

## License

This project is licensed under the MIT License - see the [LICENSE](LICENSE) file for details.
