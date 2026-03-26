<?php

namespace App\Models;

use Core\BaseModel;

/**
 * Expense Model
 * 
 * Handles CRUD operations for the `expenses` table.
 */
class Expense extends BaseModel
{
    protected string $table = 'expenses';

    protected array $fillable = [
        'user_id',
        'category',
        'description',
        'amount',
        'expense_date',
    ];

    /**
     * Get all expenses for a user.
     */
    public function findByUser(int $userId): array
    {
        return $this->raw(
            "SELECT * FROM {$this->table}
             WHERE user_id = :user_id
             ORDER BY expense_date DESC",
            ['user_id' => $userId]
        );
    }

    /**
     * Get expenses for a user filtered by month and year.
     */
    public function getByPeriod(int $userId, int $month, int $year): array
    {
        return $this->raw(
            "SELECT * FROM {$this->table}
             WHERE user_id = :user_id
               AND MONTH(expense_date) = :month
               AND YEAR(expense_date) = :year
             ORDER BY expense_date ASC",
            ['user_id' => $userId, 'month' => $month, 'year' => $year]
        );
    }

    /**
     * Get total expense for a user in a specific period.
     */
    public function getTotalByPeriod(int $userId, int $month, int $year): float
    {
        $result = $this->rawOne(
            "SELECT COALESCE(SUM(amount), 0) as total
             FROM {$this->table}
             WHERE user_id = :user_id
               AND MONTH(expense_date) = :month
               AND YEAR(expense_date) = :year",
            ['user_id' => $userId, 'month' => $month, 'year' => $year]
        );
        return (float) ($result->total ?? 0);
    }

    /**
     * Get expenses grouped by category for a period.
     */
    public function getByCategoryPeriod(int $userId, int $month, int $year): array
    {
        return $this->raw(
            "SELECT category, COALESCE(SUM(amount), 0) as total, COUNT(*) as count
             FROM {$this->table}
             WHERE user_id = :user_id
               AND MONTH(expense_date) = :month
               AND YEAR(expense_date) = :year
             GROUP BY category
             ORDER BY total DESC",
            ['user_id' => $userId, 'month' => $month, 'year' => $year]
        );
    }
}
