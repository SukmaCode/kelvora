<?php

namespace App\Models;

use Core\BaseModel;

/**
 * User Model
 * 
 * Handles CRUD operations for the `users` table.
 */
class User extends BaseModel
{
    protected string $table = 'users';

    protected array $fillable = [
        'business_name',
        'owner_name',
        'email',
        'phone',
        'password_hash',
        'role',
        'active_subscription_id',
        'status',
    ];

    /**
     * Find a user by email address.
     */
    public function findByEmail(string $email): ?object
    {
        return $this->findOneBy('email', $email);
    }

    /**
     * Get all active users.
     */
    public function findActive(): array
    {
        return $this->raw(
            "SELECT * FROM {$this->table} WHERE status = :status ORDER BY created_at DESC",
            ['status' => 'active']
        );
    }

    /**
     * Create a new user with password hashing.
     */
    public function createWithPassword(array $data, string $plainPassword): int
    {
        $data['password_hash'] = password_hash($plainPassword, PASSWORD_BCRYPT);
        return $this->create($data);
    }

    /**
     * Verify a user's password.
     */
    public function verifyPassword(object $user, string $plainPassword): bool
    {
        return password_verify($plainPassword, $user->password_hash);
    }

    /**
     * Check if an email already exists.
     */
    public function emailExists(string $email, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE email = :email";
        $params = ['email' => $email];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        return (int) $this->rawOne($sql, $params)->total > 0;
    }
}
