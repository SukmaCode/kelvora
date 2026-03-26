<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\IncomeStatement;
use App\Models\Income;
use App\Models\Expense;

/**
 * Income Statement Controller
 * 
 * Handles income statement dashboard, filtering, and export.
 */
class IncomeStatementController extends BaseController
{
    private IncomeStatement $statementModel;
    private Income $incomeModel;
    private Expense $expenseModel;
    private int $currentUserId;

    public function __construct()
    {
        $this->requireRole('owner');
        $this->statementModel = new IncomeStatement();
        $this->incomeModel = new Income();
        $this->expenseModel = new Expense();
        $this->currentUserId = $_SESSION['user_id'] ?? 1;
    }

    /**
     * Income Statement Dashboard
     */
    public function index(): void
    {
        // Default to current month/year, allow filter via GET params
        $month = (int) ($_GET['month'] ?? date('n'));
        $year  = (int) ($_GET['year'] ?? date('Y'));

        // Clamp values
        $month = max(1, min(12, $month));
        $year  = max(2020, min(2099, $year));

        $report = $this->statementModel->generateReport($this->currentUserId, $month, $year);
        $availablePeriods = $this->statementModel->getAvailablePeriods($this->currentUserId);

        $this->view('income-statements.index', [
            'title'            => 'Income Statements',
            'report'           => $report,
            'currentMonth'     => $month,
            'currentYear'      => $year,
            'availablePeriods' => $availablePeriods,
        ]);
    }

    /**
     * Export report as Excel (CSV format).
     */
    public function exportExcel(): void
    {
        $month = (int) ($_GET['month'] ?? date('n'));
        $year  = (int) ($_GET['year'] ?? date('Y'));
        $month = max(1, min(12, $month));
        $year  = max(2020, min(2099, $year));

        $report = $this->statementModel->generateReport($this->currentUserId, $month, $year);

        $monthName = date('F', mktime(0, 0, 0, $month, 1, $year));
        $filename = "Income_Statement_{$monthName}_{$year}.csv";

        header('Content-Type: text/csv; charset=utf-8');
        header("Content-Disposition: attachment; filename=\"{$filename}\"");
        header('Cache-Control: no-cache, no-store, must-revalidate');

        $output = fopen('php://output', 'w');

        // BOM for Excel UTF-8 compatibility
        fprintf($output, chr(0xEF) . chr(0xBB) . chr(0xBF));

        // Title
        fputcsv($output, ["INCOME STATEMENT REPORT"]);
        fputcsv($output, ["Period: {$monthName} {$year}"]);
        fputcsv($output, ["Generated: " . date('d M Y H:i:s')]);
        fputcsv($output, []);

        // Summary
        fputcsv($output, ["SUMMARY"]);
        fputcsv($output, ["Total Income", number_format($report['total_income'], 2, '.', '')]);
        fputcsv($output, ["Total Expense", number_format($report['total_expense'], 2, '.', '')]);
        fputcsv($output, ["Net Profit/Loss", number_format($report['net_profit'], 2, '.', '')]);
        fputcsv($output, []);

        // Incomes Detail
        fputcsv($output, ["INCOME DETAILS"]);
        fputcsv($output, ["Date", "Category", "Description", "Amount"]);
        foreach ($report['incomes'] as $income) {
            fputcsv($output, [
                $income->income_date,
                ucfirst($income->category),
                $income->description,
                number_format($income->amount, 2, '.', ''),
            ]);
        }
        fputcsv($output, ["", "", "TOTAL INCOME", number_format($report['total_income'], 2, '.', '')]);
        fputcsv($output, []);

        // Expenses Detail
        fputcsv($output, ["EXPENSE DETAILS"]);
        fputcsv($output, ["Date", "Category", "Description", "Amount"]);
        foreach ($report['expenses'] as $expense) {
            fputcsv($output, [
                $expense->expense_date,
                ucfirst($expense->category),
                $expense->description,
                number_format($expense->amount, 2, '.', ''),
            ]);
        }
        fputcsv($output, ["", "", "TOTAL EXPENSE", number_format($report['total_expense'], 2, '.', '')]);

        fclose($output);
        exit;
    }

    /**
     * Export report as a print-ready PDF page.
     */
    public function exportPdf(): void
    {
        $month = (int) ($_GET['month'] ?? date('n'));
        $year  = (int) ($_GET['year'] ?? date('Y'));
        $month = max(1, min(12, $month));
        $year  = max(2020, min(2099, $year));

        $report = $this->statementModel->generateReport($this->currentUserId, $month, $year);
        $monthName = date('F', mktime(0, 0, 0, $month, 1, $year));

        // Render a standalone print-ready page (no sidebar layout)
        extract([
            'report'    => $report,
            'monthName' => $monthName,
            'year'      => $year,
        ]);

        require BASE_PATH . '/app/views/income-statements/print.php';
        exit;
    }
}
