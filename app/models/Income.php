<?php

namespace App\Models;

use Core\BaseModel;

/**
 * Income Model
 * 
 * Handles CRUD operations for the `incomes` table.
 */
class Income extends BaseModel
{
    protected string $table = 'incomes';

    protected array $fillable = [
        'user_id',
        'category',
        'description',
        'amount',
        'income_date',
        'reference_id',
    ];

    /**
     * Get all incomes for a user.
     */
    public function findByUser(int $userId): array
    {
        return $this->raw(
            "SELECT * FROM {$this->table}
             WHERE user_id = :user_id
             ORDER BY income_date DESC",
            ['user_id' => $userId]
        );
    }

    /**
     * Get incomes for a user filtered by month and year.
     */
    public function getByPeriod(int $userId, int $month, int $year): array
    {
        return $this->raw(
            "SELECT * FROM {$this->table}
             WHERE user_id = :user_id
               AND MONTH(income_date) = :month
               AND YEAR(income_date) = :year
             ORDER BY income_date ASC",
            ['user_id' => $userId, 'month' => $month, 'year' => $year]
        );
    }

    /**
     * Get total income for a user in a specific period.
     */
    public function getTotalByPeriod(int $userId, int $month, int $year): float
    {
        $result = $this->rawOne(
            "SELECT COALESCE(SUM(amount), 0) as total
             FROM {$this->table}
             WHERE user_id = :user_id
               AND MONTH(income_date) = :month
               AND YEAR(income_date) = :year",
            ['user_id' => $userId, 'month' => $month, 'year' => $year]
        );
        return (float) ($result->total ?? 0);
    }

    /**
     * Get income grouped by category for a period.
     */
    public function getByCategoryPeriod(int $userId, int $month, int $year): array
    {
        return $this->raw(
            "SELECT category, COALESCE(SUM(amount), 0) as total, COUNT(*) as count
             FROM {$this->table}
             WHERE user_id = :user_id
               AND MONTH(income_date) = :month
               AND YEAR(income_date) = :year
             GROUP BY category
             ORDER BY total DESC",
            ['user_id' => $userId, 'month' => $month, 'year' => $year]
        );
    }
}
