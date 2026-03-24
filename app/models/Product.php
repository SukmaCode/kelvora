<?php

namespace App\Models;

use Core\BaseModel;

/**
 * Product Model
 * 
 * Handles CRUD operations for the `products` table.
 * All product queries are scoped by user_id for SaaS multi-tenancy.
 */
class Product extends BaseModel
{
    protected string $table = 'products';

    protected array $fillable = [
        'user_id',
        'name',
        'description',
        'price',
        'stock',
        'image_url',
        'category',
        'status',
    ];

    /**
     * Get all products belonging to a specific user.
     */
    public function findByUser(int $userId): array
    {
        return $this->raw(
            "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY created_at DESC",
            ['user_id' => $userId]
        );
    }

    /**
     * Get active products for a specific user.
     */
    public function findActiveByUser(int $userId): array
    {
        return $this->raw(
            "SELECT * FROM {$this->table} 
             WHERE user_id = :user_id AND status = 'active' 
             ORDER BY name ASC",
            ['user_id' => $userId]
        );
    }

    /**
     * Search products by name.
     */
    public function search(string $keyword, int $userId): array
    {
        return $this->raw(
            "SELECT * FROM {$this->table} 
             WHERE user_id = :user_id AND name LIKE :keyword 
             ORDER BY name ASC",
            ['user_id' => $userId, 'keyword' => "%{$keyword}%"]
        );
    }

    /**
     * Update product stock.
     */
    public function updateStock(int $id, int $quantity): bool
    {
        $this->db->query(
            "UPDATE {$this->table} SET stock = stock - :qty WHERE id = :id AND stock >= :qty",
            ['qty' => $quantity, 'id' => $id]
        );
        return true;
    }
}
