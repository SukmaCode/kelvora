<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Income Statement — <?= e($monthName) ?> <?= e($year) ?></title>
    <style>
        * { margin: 0; padding: 0; box-sizing: border-box; }
        body {
            font-family: 'Segoe UI', 'Inter', -apple-system, sans-serif;
            color: #1e293b;
            background: #ffffff;
            padding: 40px;
            font-size: 13px;
            line-height: 1.6;
        }

        .header {
            text-align: center;
            margin-bottom: 30px;
            padding-bottom: 20px;
            border-bottom: 3px solid #6366f1;
        }
        .header h1 {
            font-size: 22px;
            font-weight: 700;
            color: #0f172a;
            margin-bottom: 4px;
        }
        .header p {
            color: #64748b;
            font-size: 13px;
        }

        .summary-grid {
            display: grid;
            grid-template-columns: 1fr 1fr 1fr;
            gap: 16px;
            margin-bottom: 30px;
        }
        .summary-card {
            border: 1px solid #e2e8f0;
            border-radius: 8px;
            padding: 16px;
            text-align: center;
        }
        .summary-card .label {
            font-size: 11px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
            margin-bottom: 6px;
        }
        .summary-card .value {
            font-size: 20px;
            font-weight: 700;
        }
        .summary-card .value.income { color: #059669; }
        .summary-card .value.expense { color: #dc2626; }
        .summary-card .value.profit { color: #4f46e5; }
        .summary-card .value.loss { color: #dc2626; }

        .section-title {
            font-size: 14px;
            font-weight: 700;
            margin: 24px 0 10px;
            padding-bottom: 6px;
            border-bottom: 2px solid #e2e8f0;
            color: #0f172a;
        }
        .section-title.income { border-color: #059669; }
        .section-title.expense { border-color: #dc2626; }

        table {
            width: 100%;
            border-collapse: collapse;
            margin-bottom: 16px;
        }
        th {
            background: #f8fafc;
            text-align: left;
            padding: 8px 12px;
            font-size: 11px;
            font-weight: 600;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            color: #64748b;
            border-bottom: 2px solid #e2e8f0;
        }
        th:last-child { text-align: right; }
        td {
            padding: 8px 12px;
            border-bottom: 1px solid #f1f5f9;
            color: #334155;
        }
        td:last-child { text-align: right; font-weight: 600; }
        tr.total td {
            font-weight: 700;
            border-top: 2px solid #e2e8f0;
            background: #f8fafc;
        }
        tr.total.income td:last-child { color: #059669; }
        tr.total.expense td:last-child { color: #dc2626; }

        .net-result {
            text-align: center;
            margin-top: 30px;
            padding: 20px;
            border: 2px solid #e2e8f0;
            border-radius: 10px;
        }
        .net-result .label {
            font-size: 12px;
            color: #64748b;
            text-transform: uppercase;
            letter-spacing: 0.5px;
            font-weight: 600;
        }
        .net-result .value {
            font-size: 28px;
            font-weight: 800;
            margin-top: 6px;
        }
        .net-result .value.profit { color: #059669; }
        .net-result .value.loss { color: #dc2626; }

        .footer {
            margin-top: 40px;
            padding-top: 16px;
            border-top: 1px solid #e2e8f0;
            text-align: center;
            color: #94a3b8;
            font-size: 11px;
        }

        .no-print { }

        @media print {
            body { padding: 20px; }
            .no-print { display: none !important; }
            @page {
                margin: 1.5cm;
                size: A4;
            }
        }
    </style>
</head>
<body>
    <!-- Print Action (hidden in print) -->
    <div class="no-print" style="text-align: center; margin-bottom: 20px;">
        <button onclick="window.print()" style="background: #6366f1; color: #fff; border: none; padding: 10px 24px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600;">
            🖨️ Print / Save as PDF
        </button>
        <button onclick="window.close()" style="background: #e2e8f0; color: #334155; border: none; padding: 10px 24px; border-radius: 6px; cursor: pointer; font-size: 14px; font-weight: 600; margin-left: 8px;">
            ✕ Close
        </button>
    </div>

    <div class="header">
        <h1>⚡ KELVORA — Income Statement</h1>
        <p>Periode: <?= e($monthName) ?> <?= e($year) ?> · Digenerate: <?= date('d M Y H:i') ?></p>
    </div>

    <!-- Summary -->
    <div class="summary-grid">
        <div class="summary-card">
            <div class="label">Total Pemasukan</div>
            <div class="value income"><?= format_rupiah($report['total_income']) ?></div>
        </div>
        <div class="summary-card">
            <div class="label">Total Pengeluaran</div>
            <div class="value expense"><?= format_rupiah($report['total_expense']) ?></div>
        </div>
        <div class="summary-card">
            <div class="label">Laba / Rugi Bersih</div>
            <div class="value <?= $report['net_profit'] >= 0 ? 'profit' : 'loss' ?>">
                <?= $report['net_profit'] >= 0 ? '' : '- ' ?><?= format_rupiah(abs($report['net_profit'])) ?>
            </div>
        </div>
    </div>

    <!-- Income Table -->
    <div class="section-title income">💰 Detail Pemasukan</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($report['incomes'])): ?>
                <?php foreach ($report['incomes'] as $income): ?>
                <tr>
                    <td><?= format_date($income->income_date) ?></td>
                    <td><?= e(ucfirst($income->category)) ?></td>
                    <td><?= e($income->description) ?></td>
                    <td><?= format_rupiah($income->amount) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total income">
                    <td colspan="3" style="text-align: right;">TOTAL PEMASUKAN</td>
                    <td><?= format_rupiah($report['total_income']) ?></td>
                </tr>
            <?php else: ?>
                <tr><td colspan="4" style="text-align: center; color: #94a3b8;">Tidak ada data</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Expense Table -->
    <div class="section-title expense">📉 Detail Pengeluaran</div>
    <table>
        <thead>
            <tr>
                <th>Tanggal</th>
                <th>Kategori</th>
                <th>Deskripsi</th>
                <th>Jumlah</th>
            </tr>
        </thead>
        <tbody>
            <?php if (!empty($report['expenses'])): ?>
                <?php foreach ($report['expenses'] as $expense): ?>
                <tr>
                    <td><?= format_date($expense->expense_date) ?></td>
                    <td><?= e(ucfirst($expense->category)) ?></td>
                    <td><?= e($expense->description) ?></td>
                    <td><?= format_rupiah($expense->amount) ?></td>
                </tr>
                <?php endforeach; ?>
                <tr class="total expense">
                    <td colspan="3" style="text-align: right;">TOTAL PENGELUARAN</td>
                    <td><?= format_rupiah($report['total_expense']) ?></td>
                </tr>
            <?php else: ?>
                <tr><td colspan="4" style="text-align: center; color: #94a3b8;">Tidak ada data</td></tr>
            <?php endif; ?>
        </tbody>
    </table>

    <!-- Net Result -->
    <div class="net-result">
        <div class="label">Laba / Rugi Bersih</div>
        <div class="value <?= $report['net_profit'] >= 0 ? 'profit' : 'loss' ?>">
            <?= $report['net_profit'] >= 0 ? '+ ' : '- ' ?><?= format_rupiah(abs($report['net_profit'])) ?>
        </div>
    </div>

    <div class="footer">
        <p>Kelvora — SaaS Business Management Platform</p>
        <p>Dokumen ini digenerate secara otomatis pada <?= date('d M Y H:i:s') ?></p>
    </div>
</body>
</html>
