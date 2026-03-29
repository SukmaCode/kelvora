<?php

namespace App\Models;

use Core\BaseModel;

/**
 * Order Model
 * 
 * Handles CRUD operations for the `orders` table.
 * Includes JOIN queries for customer and channel data.
 */
class Order extends BaseModel
{
    protected string $table = 'orders';

    protected array $fillable = [
        'user_id',
        'customer_id',
        'channel_id',
        'total_price',
        'admin_fee',
        'owner_earning',
        'payment_status',
        'order_status',
    ];

    /**
     * Get all orders for a user, with customer name joined.
     */
    public function findByUserWithCustomer(int $userId): array
    {
        return $this->raw(
            "SELECT o.*, c.name as customer_name, c.phone as customer_phone
             FROM {$this->table} o
             LEFT JOIN customers c ON o.customer_id = c.id
             WHERE o.user_id = :user_id
             ORDER BY o.created_at DESC",
            ['user_id' => $userId]
        );
    }

    /**
     * Get a single order with full details (customer + items).
     */
    public function findWithDetails(int $id): ?object
    {
        return $this->rawOne(
            "SELECT o.*, c.name as customer_name, c.phone as customer_phone, c.address as customer_address
             FROM {$this->table} o
             LEFT JOIN customers c ON o.customer_id = c.id
             WHERE o.id = :id",
            ['id' => $id]
        );
    }

    /**
     * Get order statistics for a user.
     */
    public function getStatsByUser(int $userId): object
    {
        return $this->rawOne(
            "SELECT 
                COUNT(*) as total_orders,
                COALESCE(SUM(total_price), 0) as total_revenue,
                COALESCE(SUM(owner_earning), 0) as owner_earning,
                COALESCE(SUM(CASE WHEN order_status = 'new' THEN 1 ELSE 0 END), 0) as pending_orders
             FROM {$this->table}
             WHERE user_id = :user_id",
            ['user_id' => $userId]
        );
    }

    /**
     * Get system-wide total revenue (Gross + Platform Net).
     */
    public function getTotalRevenue(): object
    {
        $grossResult = $this->rawOne("SELECT COALESCE(SUM(total_price), 0) as total FROM {$this->table}");
        
        // Only count approved payments for true platform revenue
        $platformResult = $this->rawOne("SELECT COALESCE(SUM(admin_fee), 0) as total_fee FROM order_payments WHERE payment_status = 'approved'");

        return (object)[
            'gross_revenue' => (float) ($grossResult->total ?? 0),
            'platform_fee'  => (float) ($platformResult->total_fee ?? 0)
        ];
    }

    /**
     * Get today's total sales for a user.
     */
    public function getTodaySales(int $userId): object
    {
        $result = $this->rawOne(
            "SELECT 
                COALESCE(SUM(total_price), 0) as total,
                COALESCE(SUM(owner_earning), 0) as net_total
             FROM {$this->table} 
             WHERE user_id = :user_id 
               AND DATE(created_at) = CURDATE()",
            ['user_id' => $userId]
        );
        return $result;
    }

    /**
     * Get current month's revenue for a user.
     */
    public function getMonthlyRevenue(int $userId): object
    {
        $result = $this->rawOne(
            "SELECT 
                COALESCE(SUM(total_price), 0) as total,
                COALESCE(SUM(owner_earning), 0) as net_total
             FROM {$this->table} 
             WHERE user_id = :user_id 
               AND MONTH(created_at) = MONTH(CURDATE()) 
               AND YEAR(created_at) = YEAR(CURDATE())",
            ['user_id' => $userId]
        );
        return $result;
    }
}
