-- ==============================================================
-- KELVORA EMAIL OTP AUTH MIGRATION
-- ==============================================================
-- Run this to switch authentication to Email OTP
-- ==============================================================

USE kelvora;

-- Asumsikan tabel users sudah ada. Kita sesuaikan schema
-- sesuai permintaan khusus: penambahan email_verified_at.
-- Kita menggunakan owner_name yang sudah ada sebagai identitas.
ALTER TABLE users
    ADD COLUMN IF NOT EXISTS email_verified_at DATETIME NULL AFTER password_hash;

-- Menghapus kolom dari versi OTP WhatsApp (Jika ada)
-- Note: Jalankan baris DROP ini HANYA jika Anda ingin menghapus data lama yang terkait WhatsApp OTP
-- ALTER TABLE users DROP COLUMN phone;
-- ALTER TABLE users DROP COLUMN pin_hash;
-- ALTER TABLE users DROP COLUMN is_verified;

-- Pastikan email unique
ALTER TABLE users ADD UNIQUE INDEX IF NOT EXISTS idx_users_email (email);



-- ============================================
-- 2. email_otps
-- ============================================
CREATE TABLE IF NOT EXISTS email_otps (
    id INT PRIMARY KEY AUTO_INCREMENT,
    email VARCHAR(150) NOT NULL,
    otp_hash TEXT NOT NULL,
    expires_at DATETIME NOT NULL,
    attempts INT DEFAULT 0,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    INDEX idx_otp_email (email),
    INDEX idx_otp_expires (expires_at)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- ============================================
-- 3. Cleanup script (manual)
-- ============================================
-- Run periodically:
-- DELETE FROM email_otps WHERE expires_at < NOW();
