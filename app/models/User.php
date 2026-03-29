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
        'name',
        'email',
        'phone',
        'profile_image',
        'password_hash',
        'pin_hash',
        'is_verified',
        'email_verified_at',
        'role',
        'active_subscription_id',
        'status',
        'last_login_at',
    ];

    /**
     * Find a user by email address.
     */
    public function findByEmail(string $email): ?object
    {
        return $this->findOneBy('email', $email);
    }

    /**
     * Find a user by phone number.
     */
    public function findByPhone(string $phone): ?object
    {
        return $this->findOneBy('phone', $phone);
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
    public function phoneExists(string $phone, ?int $excludeId = null): bool
    {
        $sql = "SELECT COUNT(*) as total FROM {$this->table} WHERE phone = :phone";
        $params = ['phone' => $phone];

        if ($excludeId) {
            $sql .= " AND id != :id";
            $params['id'] = $excludeId;
        }

        return (int) $this->rawOne($sql, $params)->total > 0;
    }

    /**
     * Set a new PIN for a user.
     */
    public function setPin(int $userId, string $plainPin): void
    {
        $pinHash = password_hash($plainPin, PASSWORD_BCRYPT);
        $this->update($userId, [
            'pin_hash' => $pinHash,
            'is_verified' => 1
        ]);
    }

    /**
     * Verify a user's PIN.
     */
    public function verifyPin(object $user, string $plainPin): bool
    {
        return password_verify($plainPin, $user->pin_hash ?? '');
    }

    /**
     * Update a user's phone number.
     */
    public function updatePhone(int $userId, string $newPhone): void
    {
        $this->update($userId, ['phone' => $newPhone]);
    }

    /**
     * Mark a user's email as verified.
     */
    public function markEmailAsVerified(int $userId): void
    {
        $this->update($userId, ['email_verified_at' => date('Y-m-d H:i:s')]);
    }

    /**
     * Get list of owners (UMKMs) with their gross and net revenue.
     */
    public function getUmkmRevenues(): array
    {
        return $this->raw(
            "SELECT 
                u.id, 
                u.business_name, 
                u.name, 
                u.email,
                COUNT(o.id) as total_orders,
                COALESCE(SUM(o.total_price), 0) as gross_revenue,
                COALESCE(SUM(o.owner_earning), 0) as net_revenue
             FROM {$this->table} u
             LEFT JOIN orders o ON u.id = o.user_id AND o.payment_status IN ('paid', 'approved', 'processing')
             WHERE u.role = 'owner'
             GROUP BY u.id
             ORDER BY net_revenue DESC"
        );
    }

    /**
     * Update user's profile image.
     */
    public function updateProfileImage(int $userId, string $filename): void
    {
        $this->update($userId, ['profile_image' => $filename]);
    }

    /**
     * Delete/remove user's profile image (set to null).
     */
    public function deleteProfileImage(int $userId): void
    {
        $this->update($userId, ['profile_image' => null]);
    }

    /**
     * Update the last login time for a user.
     */
    public function updateLastLogin(int $userId): void
    {
        $this->raw("UPDATE {$this->table} SET last_login_at = CURRENT_TIMESTAMP WHERE id = :id", ['id' => $userId]);
    }
}
