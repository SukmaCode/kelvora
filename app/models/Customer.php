<?php

namespace App\Models;

use Core\BaseModel;

/**
 * Customer Model
 */
class Customer extends BaseModel
{
    protected string $table = 'customers';

    protected array $fillable = [
        'user_id',
        'name',
        'phone',
        'instagram_username',
        'address',
    ];

    /**
     * Get all customers belonging to a specific user.
     */
    public function findByUser(int $userId): array
    {
        return $this->raw(
            "SELECT * FROM {$this->table} WHERE user_id = :user_id ORDER BY name ASC",
            ['user_id' => $userId]
        );
    }
}
