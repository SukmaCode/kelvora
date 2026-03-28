-- ==============================================================
-- KELVORA OTP AUTH MIGRATION
-- ==============================================================
-- Run this AFTER the main migration.sql
-- Adds WhatsApp OTP-based authentication support
-- ==============================================================

USE kelvora;

-- ============================================
-- 1. ALTER users table
-- ============================================
ALTER TABLE users
    MODIFY COLUMN email VARCHAR(150) NULL,
    MODIFY COLUMN password_hash TEXT NULL,
    MODIFY COLUMN phone VARCHAR(20) NOT NULL,
    ADD COLUMN pin_hash TEXT NULL AFTER phone,
    ADD COLUMN is_verified TINYINT(1) DEFAULT 0 AFTER pin_hash;

-- Add unique index on phone
ALTER TABLE users ADD UNIQUE INDEX idx_users_phone (phone);

-- ============================================
-- 2. otp_codes
-- ============================================
CREATE TABLE IF NOT EXISTS otp_codes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    phone VARCHAR(20) NOT NULL,
    otp_hash TEXT NOT NULL,
    type ENUM('login','register','change_phone') DEFAULT 'login',
    expires_at DATETIME NOT NULL,
    attempts INT DEFAULT 0,
    is_used TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_otp_phone (phone),
    INDEX idx_otp_expires (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 3. otp_rate_limits
-- ============================================
CREATE TABLE IF NOT EXISTS otp_rate_limits (
    id INT PRIMARY KEY AUTO_INCREMENT,
    phone VARCHAR(20) NOT NULL,
    action ENUM('send','verify') NOT NULL,
    attempt_count INT DEFAULT 1,
    window_start DATETIME NOT NULL,
    blocked_until DATETIME NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_rate_phone_action (phone, action)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 4. user_devices
-- ============================================
CREATE TABLE IF NOT EXISTS user_devices (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    device_hash VARCHAR(64) NOT NULL,
    user_agent TEXT,
    ip_address VARCHAR(45),
    last_login_at DATETIME,
    is_trusted TINYINT(1) DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    UNIQUE KEY idx_user_device (user_id, device_hash)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 5. phone_change_requests
-- ============================================
CREATE TABLE IF NOT EXISTS phone_change_requests (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    old_phone VARCHAR(20) NOT NULL,
    new_phone VARCHAR(20) NOT NULL,
    old_phone_verified TINYINT(1) DEFAULT 0,
    new_phone_verified TINYINT(1) DEFAULT 0,
    status ENUM('pending','completed','expired','manual_review') DEFAULT 'pending',
    expires_at DATETIME NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 6. Update sample data phone format
-- ============================================
UPDATE users SET phone = '+628111111111', is_verified = 1 WHERE id = 1;
UPDATE users SET phone = '+6281234567890', is_verified = 1 WHERE id = 2;
UPDATE users SET phone = '+6281298765432', is_verified = 1 WHERE id = 3;

-- ============================================
-- 7. Cleanup expired OTP cron (manual)
-- ============================================
-- Run periodically:
-- DELETE FROM otp_codes WHERE expires_at < NOW() AND is_used = 1;
-- DELETE FROM otp_rate_limits WHERE window_start < DATE_SUB(NOW(), INTERVAL 2 HOUR);
