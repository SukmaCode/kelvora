<?php

namespace App\Models;

use Core\BaseModel;

/**
 * OrderPayment Model
 * 
 * Handles CRUD operations for the `order_payments` table.
 */
class OrderPayment extends BaseModel
{
    protected string $table = 'order_payments';

    protected array $fillable = [
        'order_id',
        'gross_amount',
        'admin_fee',
        'net_amount',
        'payment_status',
    ];

    /**
     * Get all pending payments with related order and UMKM owner details.
     */
    public function getPendingWithDetails(): array
    {
        return $this->raw(
            "SELECT op.*, o.user_id as owner_id, o.customer_id, u.business_name, c.name as customer_name, c.phone as customer_phone
             FROM {$this->table} op
             JOIN orders o ON op.order_id = o.id
             JOIN users u ON o.user_id = u.id
             JOIN customers c ON o.customer_id = c.id
             WHERE op.payment_status = 'pending'
             ORDER BY op.created_at ASC"
        );
    }
    
    /**
     * Get all payments with related order and UMKM owner details.
     */
    public function getAllWithDetails(): array
    {
        return $this->raw(
            "SELECT op.*, o.user_id as owner_id, o.customer_id, u.business_name, c.name as customer_name, c.phone as customer_phone
             FROM {$this->table} op
             JOIN orders o ON op.order_id = o.id
             JOIN users u ON o.user_id = u.id
             JOIN customers c ON o.customer_id = c.id
             ORDER BY op.created_at DESC"
        );
    }
}
