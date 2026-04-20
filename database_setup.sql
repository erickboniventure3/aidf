-- AIDF Database Tables
-- Run this SQL script to create all necessary tables

-- Admin Users Table
CREATE TABLE IF NOT EXISTS admin_users (
    id INT AUTO_INCREMENT PRIMARY KEY,
    username VARCHAR(50) UNIQUE NOT NULL,
    password VARCHAR(255) NOT NULL,
    email VARCHAR(100) UNIQUE NOT NULL,
    full_name VARCHAR(100),
    role ENUM('admin', 'moderator') DEFAULT 'admin',
    status ENUM('active', 'inactive') DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    last_login TIMESTAMP NULL
);

-- Donations Table
CREATE TABLE IF NOT EXISTS donations (
    id INT AUTO_INCREMENT PRIMARY KEY,
    donor_name VARCHAR(100) NOT NULL,
    donor_email VARCHAR(100) NOT NULL,
    donor_phone VARCHAR(20),
    amount DECIMAL(10,2) NOT NULL,
    currency VARCHAR(3) DEFAULT 'TZS',
    donation_type ENUM('one-time', 'monthly', 'yearly') DEFAULT 'one-time',
    payment_method ENUM('card', 'bank', 'mobile') DEFAULT 'card',
    cause VARCHAR(100),
    message TEXT,
    anonymous TINYINT(1) NOT NULL DEFAULT 0,
    transaction_id VARCHAR(100),
    status ENUM('pending', 'completed', 'failed', 'cancelled') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    processed_at TIMESTAMP NULL
);

-- Membership Applications Table
CREATE TABLE IF NOT EXISTS memberships (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    address TEXT,
    occupation VARCHAR(100),
    education_level VARCHAR(100),
    interests TEXT,
    membership_type ENUM('ordinary', 'college_student', 'institutional', 'honorary') DEFAULT 'ordinary',
    motivation TEXT,
    terms_accepted TINYINT(1) NOT NULL DEFAULT 0,
    newsletter_subscribed TINYINT(1) NOT NULL DEFAULT 0,
    status ENUM('pending', 'approved', 'rejected') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL,
    approved_by INT,
    FOREIGN KEY (approved_by) REFERENCES admin_users(id)
);

-- Volunteer Applications Table
CREATE TABLE IF NOT EXISTS volunteers (
    id INT AUTO_INCREMENT PRIMARY KEY,
    full_name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20) NOT NULL,
    date_of_birth DATE,
    gender ENUM('male', 'female', 'other'),
    address TEXT,
    occupation VARCHAR(100),
    education_level VARCHAR(100),
    skills TEXT,
    interests TEXT,
    availability TEXT,
    experience TEXT,
    motivation TEXT,
    volunteer_area VARCHAR(100),
    terms_accepted TINYINT(1) NOT NULL DEFAULT 0,
    background_check_consent TINYINT(1) NOT NULL DEFAULT 0,
    status ENUM('pending', 'approved', 'rejected', 'active', 'inactive') DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    approved_at TIMESTAMP NULL,
    approved_by INT,
    FOREIGN KEY (approved_by) REFERENCES admin_users(id)
);

-- Contact Messages Table (for existing contact forms)
CREATE TABLE IF NOT EXISTS contact_messages (
    id INT AUTO_INCREMENT PRIMARY KEY,
    name VARCHAR(100) NOT NULL,
    email VARCHAR(100) NOT NULL,
    phone VARCHAR(20),
    subject VARCHAR(200) NOT NULL,
    message TEXT NOT NULL,
    status ENUM('unread', 'read', 'replied') DEFAULT 'unread',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    replied_at TIMESTAMP NULL,
    replied_by INT,
    FOREIGN KEY (replied_by) REFERENCES admin_users(id)
);

-- Insert default admin user
INSERT INTO admin_users (username, password, email, full_name, role) VALUES
('admin', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin@aidf.or.tz', 'System Administrator', 'admin')
ON DUPLICATE KEY UPDATE username=username;

-- Password is 'password' (hashed with bcrypt)
