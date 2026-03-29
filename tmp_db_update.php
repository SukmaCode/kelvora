<?php
require 'd:/Apps/laragon/www/kelvora/core/Database.php';

// Bootstrap minimal config
define('BASE_PATH', 'd:/Apps/laragon/www/kelvora');

try {
    $db = \Core\Database::getInstance();
    
    // Add columns to orders
    $db->query("ALTER TABLE orders ADD COLUMN admin_fee DECIMAL(12,2) DEFAULT 1000.00 AFTER total_price;");
    echo "Added admin_fee to orders.\n";
} catch (Exception $e) {
    echo "Failed to add admin_fee: " . $e->getMessage() . "\n";
}

try {
    $db = \Core\Database::getInstance();
    
    // Add columns to orders
    $db->query("ALTER TABLE orders ADD COLUMN owner_earning DECIMAL(12,2) DEFAULT 0.00 AFTER admin_fee;");
    echo "Added owner_earning to orders.\n";
} catch (Exception $e) {
    echo "Failed to add owner_earning: " . $e->getMessage() . "\n";
}

try {
    $db = \Core\Database::getInstance();
    // Update existing orders to have owner_earning = total_price
    $db->query("UPDATE orders SET owner_earning = total_price;");
    echo "Updated existing orders owner_earning.\n";
} catch (Exception $e) {
    echo "Failed to update existing orders owner_earning: " . $e->getMessage() . "\n";
}

try {
    $db = \Core\Database::getInstance();
    
    // Create order_payments table
    $db->query("CREATE TABLE IF NOT EXISTS order_payments (
        id INT PRIMARY KEY AUTO_INCREMENT,
        order_id INT NOT NULL,
        gross_amount DECIMAL(12,2) NOT NULL,
        admin_fee DECIMAL(12,2) DEFAULT 1000.00,
        net_amount DECIMAL(12,2) NOT NULL,
        payment_status VARCHAR(30) DEFAULT 'pending',
        created_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP,
        updated_at TIMESTAMP DEFAULT CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP,
        FOREIGN KEY (order_id) REFERENCES orders(id) ON DELETE CASCADE
    ) ENGINE=InnoDB DEFAULT CHARSET=utf8mb4;");
    echo "Created order_payments table.\n";
} catch (Exception $e) {
    echo "Failed to create order_payments: " . $e->getMessage() . "\n";
}

echo "Database updates complete.\n";
