<?php

namespace App\Models;

use Core\BaseModel;

/**
 * Income Statement Model
 * 
 * Aggregation model for generating profit/loss reports
 * by combining data from incomes and expenses tables.
 */
class IncomeStatement extends BaseModel
{
    protected string $table = 'profit_loss_reports';

    protected array $fillable = [
        'user_id',
        'period_month',
        'period_year',
        'total_income',
        'total_expense',
        'net_profit',
    ];

    /**
     * Generate a full income statement report for a given period.
     */
    public function generateReport(int $userId, int $month, int $year): array
    {
        $incomeModel = new Income();
        $expenseModel = new Expense();

        $incomes = $incomeModel->getByPeriod($userId, $month, $year);
        $expenses = $expenseModel->getByPeriod($userId, $month, $year);
        $totalIncome = $incomeModel->getTotalByPeriod($userId, $month, $year);
        $totalExpense = $expenseModel->getTotalByPeriod($userId, $month, $year);
        $netProfit = $totalIncome - $totalExpense;

        $incomeByCategory = $incomeModel->getByCategoryPeriod($userId, $month, $year);
        $expenseByCategory = $expenseModel->getByCategoryPeriod($userId, $month, $year);

        return [
            'period_month'      => $month,
            'period_year'       => $year,
            'total_income'      => $totalIncome,
            'total_expense'     => $totalExpense,
            'net_profit'        => $netProfit,
            'incomes'           => $incomes,
            'expenses'          => $expenses,
            'income_by_category'  => $incomeByCategory,
            'expense_by_category' => $expenseByCategory,
        ];
    }

    /**
     * Get available periods (months) that have data for a user.
     */
    public function getAvailablePeriods(int $userId): array
    {
        return $this->raw(
            "SELECT DISTINCT MONTH(income_date) as month, YEAR(income_date) as year
             FROM incomes WHERE user_id = :uid1
             UNION
             SELECT DISTINCT MONTH(expense_date) as month, YEAR(expense_date) as year
             FROM expenses WHERE user_id = :uid2
             ORDER BY year DESC, month DESC",
            ['uid1' => $userId, 'uid2' => $userId]
        );
    }
}
