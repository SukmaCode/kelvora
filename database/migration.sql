-- ==============================================================
-- KELVORA DATABASE SCHEMA
-- ==============================================================
-- SaaS Business Management Platform
-- Run this file to create all tables.
-- ==============================================================

CREATE DATABASE IF NOT EXISTS kelvora
    CHARACTER SET utf8mb4
    COLLATE utf8mb4_unicode_ci;

USE kelvora;

-- =========================
-- 1. USERS
-- =========================
CREATE TABLE IF NOT EXISTS users (
    id INT PRIMARY KEY AUTO_INCREMENT,
    business_name VARCHAR(150) NOT NULL,
    owner_name VARCHAR(150) NOT NULL,
    email VARCHAR(150) UNIQUE NOT NULL,
    phone VARCHAR(30),
    password_hash TEXT NOT NULL,
    role ENUM('admin', 'owner') DEFAULT 'owner',
    active_subscription_id INT,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 2. FEATURES MASTER
-- =========================
CREATE TABLE IF NOT EXISTS features (
    id INT PRIMARY KEY AUTO_INCREMENT,
    code VARCHAR(50) UNIQUE NOT NULL,
    name VARCHAR(100) NOT NULL,
    description TEXT
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 3. SUBSCRIPTION PACKAGES
-- =========================
CREATE TABLE IF NOT EXISTS subscription_packages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    name VARCHAR(100) NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    chat_limit INT NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 4. PACKAGE FEATURES (M:N)
-- =========================
CREATE TABLE IF NOT EXISTS package_features (
    package_id INT NOT NULL,
    feature_id INT NOT NULL,
    value_int INT,
    value_bool BOOLEAN,
    PRIMARY KEY (package_id, feature_id),
    FOREIGN KEY (package_id) REFERENCES subscription_packages(id) ON DELETE CASCADE,
    FOREIGN KEY (feature_id) REFERENCES features(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 5. SUBSCRIPTIONS (HISTORY)
-- =========================
CREATE TABLE IF NOT EXISTS subscriptions (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    package_id INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    chat_limit INT NOT NULL,
    chat_used INT DEFAULT 0,
    start_date DATE NOT NULL,
    end_date DATE NOT NULL,
    status VARCHAR(20) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (package_id) REFERENCES subscription_packages(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 6. CHANNELS (WA / IG)
-- =========================
CREATE TABLE IF NOT EXISTS channels (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    platform VARCHAR(50) NOT NULL,
    account_name VARCHAR(150),
    account_id VARCHAR(150),
    access_token TEXT,
    webhook_url TEXT,
    status VARCHAR(30) DEFAULT 'connected',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 7. PRODUCTS
-- =========================
CREATE TABLE IF NOT EXISTS products (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(150) NOT NULL,
    description TEXT,
    price DECIMAL(12,2) NOT NULL,
    stock INT DEFAULT 0,
    image_url TEXT,
    category VARCHAR(100),
    status VARCHAR(30) DEFAULT 'active',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 8. CUSTOMERS
-- =========================
CREATE TABLE IF NOT EXISTS customers (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    name VARCHAR(150),
    email VARCHAR(255) UNIQUE,
    phone VARCHAR(30) UNIQUE,
    instagram_username VARCHAR(150),
    address TEXT,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 9. ORDERS
-- =========================
CREATE TABLE IF NOT EXISTS orders (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    customer_id INT NOT NULL,
    channel_id INT,
    total_price DECIMAL(12,2) NOT NULL,
    admin_fee DECIMAL(12,2) DEFAULT 1000.00,
    owner_earning DECIMAL(12,2) NOT NULL,
    payment_status VARCHAR(30) DEFAULT 'pending',
    order_status VARCHAR(30) DEFAULT 'new',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (channel_id) REFERENCES channels(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 10. ORDER ITEMS
-- =========================
CREATE TABLE IF NOT EXISTS order_items (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    product_id INT NOT NULL,
    quantity INT NOT NULL,
    price DECIMAL(12,2) NOT NULL,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE,
    FOREIGN KEY (product_id) REFERENCES products(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 10.5. ORDER PAYMENTS
-- =========================
CREATE TABLE IF NOT EXISTS order_payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    order_id INT NOT NULL,
    gross_amount DECIMAL(12,2) NOT NULL,
    admin_fee DECIMAL(12,2) DEFAULT 1000.00,
    net_amount DECIMAL(12,2) NOT NULL,
    payment_status VARCHAR(30) DEFAULT 'pending',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
    FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 11. MESSAGES (CHAT LOG)
-- =========================
CREATE TABLE IF NOT EXISTS messages (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    customer_id INT,
    channel_id INT,
    message_text TEXT,
    message_type VARCHAR(30),
    direction VARCHAR(30),
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (customer_id) REFERENCES customers(id),
    FOREIGN KEY (channel_id) REFERENCES channels(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 12. ANALYTICS (DAILY)
-- =========================
CREATE TABLE IF NOT EXISTS analytics (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    date DATE NOT NULL,
    total_orders INT DEFAULT 0,
    total_revenue DECIMAL(14,2) DEFAULT 0,
    total_chats INT DEFAULT 0,
    conversion_rate DECIMAL(5,2) DEFAULT 0,
    UNIQUE(user_id, date),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 13. PAYMENTS (BILLING)
-- =========================
CREATE TABLE IF NOT EXISTS payments (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    subscription_id INT NOT NULL,
    invoice_number VARCHAR(100) UNIQUE NOT NULL,
    amount DECIMAL(12,2) NOT NULL,
    payment_method VARCHAR(50),
    payment_status VARCHAR(30) DEFAULT 'pending',
    paid_at TIMESTAMP NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE,
    FOREIGN KEY (subscription_id) REFERENCES subscriptions(id)
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 14. INCOMES (PEMASUKAN)
-- =========================
CREATE TABLE IF NOT EXISTS incomes (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'sales',
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(14,2) NOT NULL,
    income_date DATE NOT NULL,
    reference_id INT NULL COMMENT 'Optional link to orders.id',
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 15. EXPENSES (PENGELUARAN)
-- =========================
CREATE TABLE IF NOT EXISTS expenses (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    category VARCHAR(50) NOT NULL DEFAULT 'operational',
    description VARCHAR(255) NOT NULL,
    amount DECIMAL(14,2) NOT NULL,
    expense_date DATE NOT NULL,
    created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- 16. PROFIT LOSS REPORTS
-- =========================
CREATE TABLE IF NOT EXISTS profit_loss_reports (
    id INT PRIMARY KEY AUTO_INCREMENT,
    user_id INT NOT NULL,
    period_month TINYINT NOT NULL,
    period_year SMALLINT NOT NULL,
    total_income DECIMAL(14,2) DEFAULT 0,
    total_expense DECIMAL(14,2) DEFAULT 0,
    net_profit DECIMAL(14,2) DEFAULT 0,
    generated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
    UNIQUE(user_id, period_month, period_year),
    FOREIGN KEY (user_id) REFERENCES users(id) ON DELETE CASCADE
) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;

-- =========================
-- INDEXES (PERFORMANCE)
-- =========================
CREATE INDEX idx_users_email ON users(email);
CREATE INDEX idx_orders_user ON orders(user_id);
CREATE INDEX idx_orders_customer ON orders(customer_id);
CREATE INDEX idx_products_user ON products(user_id);
CREATE INDEX idx_messages_user ON messages(user_id);
CREATE INDEX idx_subscriptions_user ON subscriptions(user_id);
CREATE INDEX idx_incomes_user ON incomes(user_id);
CREATE INDEX idx_incomes_date ON incomes(income_date);
CREATE INDEX idx_expenses_user ON expenses(user_id);
CREATE INDEX idx_expenses_date ON expenses(expense_date);
CREATE INDEX idx_profit_loss_user ON profit_loss_reports(user_id);

-- =========================
-- SAMPLE DATA (optional)
-- =========================
INSERT INTO users (business_name, owner_name, email, phone, password_hash, role, status) VALUES
('Kelvora Admin', 'Super Admin', 'admin@kelvora.com', '08111111111', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'admin', 'active'),
('Toko Makmur', 'Budi Santoso', 'budi@example.com', '081234567890', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'active'),
('Warung Sejahtera', 'Siti Aminah', 'siti@example.com', '081298765432', '$2y$10$92IXUNpkjO0rOQ5byMi.Ye4oKoEa3Ro9llC/.og/at2.uheWG/igi', 'owner', 'active');

-- Sample password: "password" (bcrypt hashed)

INSERT INTO customers (user_id, name, email, phone, address) VALUES
(1, 'Customer A', '08111111111', 'Jakarta'),
(1, 'Customer B', '08122222222', 'Bandung'),
(2, 'Customer C', '08133333333', 'Surabaya');

INSERT INTO products (user_id, name, description, price, stock, category, status) VALUES
(1, 'Kaos Polos Hitam', 'Kaos cotton combed 30s', 85000.00, 150, 'Fashion', 'active'),
(1, 'Hoodie Premium', 'Hoodie fleece tebal', 250000.00, 50, 'Fashion', 'active'),
(1, 'Topi Snapback', 'Topi snapback logo custom', 75000.00, 200, 'Accessories', 'active'),
(2, 'Nasi Goreng Spesial', 'Nasi goreng dengan telur dan ayam', 25000.00, 0, 'Food', 'active'),
(2, 'Es Teh Manis', 'Es teh manis segar', 5000.00, 0, 'Beverage', 'active');

-- Sample Incomes
INSERT INTO incomes (user_id, category, description, amount, income_date) VALUES
(1, 'sales', 'Penjualan Kaos Polos Hitam (10 pcs)', 850000.00, '2026-03-01'),
(1, 'sales', 'Penjualan Hoodie Premium (5 pcs)', 1250000.00, '2026-03-05'),
(1, 'sales', 'Penjualan Topi Snapback (8 pcs)', 600000.00, '2026-03-10'),
(1, 'service', 'Jasa Custom Design', 500000.00, '2026-03-12'),
(1, 'other', 'Pendapatan Bunga Bank', 75000.00, '2026-03-15'),
(1, 'sales', 'Penjualan Kaos Polos Hitam (20 pcs)', 1700000.00, '2026-03-18'),
(1, 'sales', 'Penjualan Hoodie Premium (3 pcs)', 750000.00, '2026-03-22'),
(1, 'sales', 'Penjualan Paket Bundle', 450000.00, '2026-02-05'),
(1, 'service', 'Jasa Sablon Kaos', 300000.00, '2026-02-10'),
(1, 'other', 'Pendapatan Lain-lain', 150000.00, '2026-02-20'),
(2, 'sales', 'Penjualan Nasi Goreng (50 porsi)', 1250000.00, '2026-03-01'),
(2, 'sales', 'Penjualan Es Teh Manis (100 gelas)', 500000.00, '2026-03-05'),
(2, 'other', 'Pendapatan Catering', 2000000.00, '2026-03-15');

-- Sample Expenses
INSERT INTO expenses (user_id, category, description, amount, expense_date) VALUES
(1, 'purchase', 'Beli Bahan Kaos Cotton Combed 30s', 1500000.00, '2026-03-02'),
(1, 'operational', 'Biaya Listrik & Air', 350000.00, '2026-03-03'),
(1, 'salary', 'Gaji Karyawan (2 orang)', 4000000.00, '2026-03-05'),
(1, 'operational', 'Biaya Internet & Hosting', 250000.00, '2026-03-06'),
(1, 'purchase', 'Beli Bahan Hoodie Fleece', 800000.00, '2026-03-08'),
(1, 'operational', 'Biaya Pengiriman/Ekspedisi', 200000.00, '2026-03-12'),
(1, 'other', 'Biaya Maintenance Mesin', 500000.00, '2026-03-15'),
(1, 'purchase', 'Beli Bahan Topi', 400000.00, '2026-02-03'),
(1, 'operational', 'Biaya Sewa Tempat', 1500000.00, '2026-02-05'),
(1, 'salary', 'Gaji Karyawan (2 orang)', 4000000.00, '2026-02-05'),
(2, 'purchase', 'Beli Bahan Masakan', 800000.00, '2026-03-01'),
(2, 'salary', 'Gaji Karyawan (3 orang)', 4500000.00, '2026-03-05'),
(2, 'operational', 'Biaya Gas & Listrik', 450000.00, '2026-03-10');