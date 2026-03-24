<?php

namespace App\Models;

use Core\BaseModel;

/**
 * OrderItem Model
 */
class OrderItem extends BaseModel
{
    protected string $table = 'order_items';

    protected array $fillable = [
        'order_id',
        'product_id',
        'quantity',
        'price',
    ];

    /**
     * Get all items for an order, with product name joined.
     */
    public function findByOrder(int $orderId): array
    {
        return $this->raw(
            "SELECT oi.*, p.name as product_name
             FROM {$this->table} oi
             LEFT JOIN products p ON oi.product_id = p.id
             WHERE oi.order_id = :order_id",
            ['order_id' => $orderId]
        );
    }
}
