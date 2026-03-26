<?php
/** @var array $report */
/** @var int $currentMonth */
/** @var int $currentYear */
/** @var array $availablePeriods */

$months = [
    1 => 'Januari', 2 => 'Februari', 3 => 'Maret', 4 => 'April',
    5 => 'Mei', 6 => 'Juni', 7 => 'Juli', 8 => 'Agustus',
    9 => 'September', 10 => 'Oktober', 11 => 'November', 12 => 'Desember'
];

$isProfit = $report['net_profit'] >= 0;
?>

<!-- Filter Bar -->
<div class="flex flex-col sm:flex-row items-start sm:items-center justify-between gap-4 mb-6">
    <form method="GET" action="<?= url('/income-statements') ?>" class="flex items-center gap-3">
        <select name="month" class="bg-input border border-border rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent transition-all">
            <?php for ($m = 1; $m <= 12; $m++): ?>
                <option value="<?= $m ?>" <?= $m === $currentMonth ? 'selected' : '' ?>><?= $months[$m] ?></option>
            <?php endfor; ?>
        </select>
        <select name="year" class="bg-input border border-border rounded-lg px-3 py-2.5 text-sm text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent/50 focus:border-accent transition-all">
            <?php for ($y = date('Y') - 5; $y <= date('Y') + 1; $y++): ?>
                <option value="<?= $y ?>" <?= $y === $currentYear ? 'selected' : '' ?>><?= $y ?></option>
            <?php endfor; ?>
        </select>
        <button type="submit" class="bg-accent hover:bg-accent-hover text-white px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200 hover:shadow-lg hover:shadow-accent/25">
            <span class="flex items-center gap-2">
                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 4a1 1 0 011-1h16a1 1 0 011 1v2.586a1 1 0 01-.293.707l-6.414 6.414a1 1 0 00-.293.707V17l-4 4v-6.586a1 1 0 00-.293-.707L3.293 7.293A1 1 0 013 6.586V4z"/></svg>
                Filter
            </span>
        </button>
    </form>

    <!-- Export Buttons -->
    <div class="flex items-center gap-2">
        <a href="<?= url('/income-statements/export-excel?month=' . $currentMonth . '&year=' . $currentYear) ?>"
           class="flex items-center gap-2 bg-emerald-600/20 border border-emerald-500/30 text-emerald-400 hover:bg-emerald-600/30 hover:border-emerald-500/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 10v6m0 0l-3-3m3 3l3-3m2 8H7a2 2 0 01-2-2V5a2 2 0 012-2h5.586a1 1 0 01.707.293l5.414 5.414a1 1 0 01.293.707V19a2 2 0 01-2 2z"/></svg>
            Export Excel
        </a>
        <a href="<?= url('/income-statements/export-pdf?month=' . $currentMonth . '&year=' . $currentYear) ?>"
           target="_blank"
           class="flex items-center gap-2 bg-red-600/20 border border-red-500/30 text-red-400 hover:bg-red-600/30 hover:border-red-500/50 px-4 py-2.5 rounded-lg text-sm font-medium transition-all duration-200">
            <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M7 21h10a2 2 0 002-2V9.414a1 1 0 00-.293-.707l-5.414-5.414A1 1 0 0012.586 3H7a2 2 0 00-2 2v14a2 2 0 002 2z"/></svg>
            Export PDF
        </a>
    </div>
</div>

<!-- Summary Cards -->
<div class="grid grid-cols-1 sm:grid-cols-3 gap-4 mb-8">
    <!-- Total Income Card -->
    <div class="bg-card border border-border rounded-xl p-5 transition-all duration-300 hover:border-emerald-500/30 hover:shadow-lg hover:shadow-emerald-500/5 group">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-400 text-sm font-medium">Total Pemasukan</span>
            <span class="text-2xl opacity-60 group-hover:opacity-100 transition-opacity">💰</span>
        </div>
        <p class="text-2xl lg:text-3xl font-bold text-emerald-400"><?= format_rupiah($report['total_income']) ?></p>
        <p class="text-slate-500 text-xs mt-2"><?= $months[$currentMonth] ?> <?= $currentYear ?></p>
    </div>

    <!-- Total Expense Card -->
    <div class="bg-card border border-border rounded-xl p-5 transition-all duration-300 hover:border-red-500/30 hover:shadow-lg hover:shadow-red-500/5 group">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-400 text-sm font-medium">Total Pengeluaran</span>
            <span class="text-2xl opacity-60 group-hover:opacity-100 transition-opacity">📉</span>
        </div>
        <p class="text-2xl lg:text-3xl font-bold text-red-400"><?= format_rupiah($report['total_expense']) ?></p>
        <p class="text-slate-500 text-xs mt-2"><?= $months[$currentMonth] ?> <?= $currentYear ?></p>
    </div>

    <!-- Net Profit/Loss Card -->
    <div class="bg-card border border-border rounded-xl p-5 transition-all duration-300 hover:border-<?= $isProfit ? 'indigo' : 'red' ?>-500/30 hover:shadow-lg hover:shadow-<?= $isProfit ? 'indigo' : 'red' ?>-500/5 group">
        <div class="flex items-center justify-between mb-3">
            <span class="text-slate-400 text-sm font-medium">Laba / Rugi Bersih</span>
            <span class="text-2xl opacity-60 group-hover:opacity-100 transition-opacity"><?= $isProfit ? '📈' : '📉' ?></span>
        </div>
        <p class="text-2xl lg:text-3xl font-bold <?= $isProfit ? 'text-indigo-400' : 'text-red-400' ?>">
            <?= $isProfit ? '' : '- ' ?><?= format_rupiah(abs($report['net_profit'])) ?>
        </p>
        <p class="text-xs mt-2 <?= $isProfit ? 'text-emerald-500' : 'text-red-500' ?> font-medium">
            <?= $isProfit ? '✓ Profit' : '✗ Loss' ?>
        </p>
    </div>
</div>

<!-- Category Breakdown -->
<div class="grid grid-cols-1 lg:grid-cols-2 gap-6 mb-8">
    <!-- Income by Category -->
    <div class="bg-card border border-border rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-border flex items-center gap-2">
            <span class="text-emerald-400">●</span>
            <h3 class="font-semibold text-slate-200">Pemasukan per Kategori</h3>
        </div>
        <div class="p-5">
            <?php if (!empty($report['income_by_category'])): ?>
                <div class="space-y-3">
                    <?php foreach ($report['income_by_category'] as $cat): ?>
                        <?php $percentage = $report['total_income'] > 0 ? ($cat->total / $report['total_income']) * 100 : 0; ?>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-sm text-slate-300 capitalize font-medium"><?= e(ucfirst($cat->category)) ?></span>
                                <span class="text-sm text-emerald-400 font-semibold"><?= format_rupiah($cat->total) ?></span>
                            </div>
                            <div class="w-full bg-slate-700/50 rounded-full h-2">
                                <div class="bg-gradient-to-r from-emerald-500 to-emerald-400 h-2 rounded-full transition-all duration-700" style="width: <?= round($percentage) ?>%"></div>
                            </div>
                            <p class="text-xs text-slate-500 mt-1"><?= $cat->count ?> transaksi · <?= round($percentage, 1) ?>%</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-slate-500 text-sm text-center py-6">Tidak ada data pemasukan</p>
            <?php endif; ?>
        </div>
    </div>

    <!-- Expense by Category -->
    <div class="bg-card border border-border rounded-xl overflow-hidden">
        <div class="px-5 py-4 border-b border-border flex items-center gap-2">
            <span class="text-red-400">●</span>
            <h3 class="font-semibold text-slate-200">Pengeluaran per Kategori</h3>
        </div>
        <div class="p-5">
            <?php if (!empty($report['expense_by_category'])): ?>
                <div class="space-y-3">
                    <?php foreach ($report['expense_by_category'] as $cat): ?>
                        <?php $percentage = $report['total_expense'] > 0 ? ($cat->total / $report['total_expense']) * 100 : 0; ?>
                        <div>
                            <div class="flex items-center justify-between mb-1.5">
                                <span class="text-sm text-slate-300 capitalize font-medium"><?= e(ucfirst($cat->category)) ?></span>
                                <span class="text-sm text-red-400 font-semibold"><?= format_rupiah($cat->total) ?></span>
                            </div>
                            <div class="w-full bg-slate-700/50 rounded-full h-2">
                                <div class="bg-gradient-to-r from-red-500 to-red-400 h-2 rounded-full transition-all duration-700" style="width: <?= round($percentage) ?>%"></div>
                            </div>
                            <p class="text-xs text-slate-500 mt-1"><?= $cat->count ?> transaksi · <?= round($percentage, 1) ?>%</p>
                        </div>
                    <?php endforeach; ?>
                </div>
            <?php else: ?>
                <p class="text-slate-500 text-sm text-center py-6">Tidak ada data pengeluaran</p>
            <?php endif; ?>
        </div>
    </div>
</div>

<!-- Income Detail Table -->
<div class="bg-card border border-border rounded-xl overflow-hidden mb-6">
    <div class="px-5 py-4 border-b border-border flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-emerald-400">💰</span>
            <h3 class="font-semibold text-slate-200">Detail Pemasukan</h3>
        </div>
        <span class="text-xs text-slate-500 bg-emerald-500/10 text-emerald-400 px-2.5 py-1 rounded-full font-medium">
            <?= count($report['incomes']) ?> transaksi
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-border">
                    <th class="text-left px-5 py-3 text-slate-400 font-medium text-xs uppercase tracking-wider">Tanggal</th>
                    <th class="text-left px-5 py-3 text-slate-400 font-medium text-xs uppercase tracking-wider">Kategori</th>
                    <th class="text-left px-5 py-3 text-slate-400 font-medium text-xs uppercase tracking-wider">Deskripsi</th>
                    <th class="text-right px-5 py-3 text-slate-400 font-medium text-xs uppercase tracking-wider">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($report['incomes'])): ?>
                    <?php foreach ($report['incomes'] as $income): ?>
                    <tr class="border-b border-border/50 hover:bg-indigo-500/[0.04] transition-colors">
                        <td class="px-5 py-3.5 text-slate-300"><?= format_date($income->income_date) ?></td>
                        <td class="px-5 py-3.5">
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                                <?= match($income->category) {
                                    'sales'   => 'bg-emerald-500/15 text-emerald-400',
                                    'service' => 'bg-blue-500/15 text-blue-400',
                                    default   => 'bg-slate-500/15 text-slate-400',
                                } ?>">
                                <?= e(ucfirst($income->category)) ?>
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-300"><?= e($income->description) ?></td>
                        <td class="px-5 py-3.5 text-right text-emerald-400 font-semibold"><?= format_rupiah($income->amount) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="bg-emerald-500/[0.06]">
                        <td colspan="3" class="px-5 py-3.5 text-right font-bold text-slate-200 uppercase text-xs tracking-wider">Total Pemasukan</td>
                        <td class="px-5 py-3.5 text-right font-bold text-emerald-400 text-base"><?= format_rupiah($report['total_income']) ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-slate-500">Tidak ada data pemasukan untuk periode ini</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Expense Detail Table -->
<div class="bg-card border border-border rounded-xl overflow-hidden mb-6">
    <div class="px-5 py-4 border-b border-border flex items-center justify-between">
        <div class="flex items-center gap-2">
            <span class="text-red-400">📉</span>
            <h3 class="font-semibold text-slate-200">Detail Pengeluaran</h3>
        </div>
        <span class="text-xs text-slate-500 bg-red-500/10 text-red-400 px-2.5 py-1 rounded-full font-medium">
            <?= count($report['expenses']) ?> transaksi
        </span>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full text-sm">
            <thead>
                <tr class="border-b border-border">
                    <th class="text-left px-5 py-3 text-slate-400 font-medium text-xs uppercase tracking-wider">Tanggal</th>
                    <th class="text-left px-5 py-3 text-slate-400 font-medium text-xs uppercase tracking-wider">Kategori</th>
                    <th class="text-left px-5 py-3 text-slate-400 font-medium text-xs uppercase tracking-wider">Deskripsi</th>
                    <th class="text-right px-5 py-3 text-slate-400 font-medium text-xs uppercase tracking-wider">Jumlah</th>
                </tr>
            </thead>
            <tbody>
                <?php if (!empty($report['expenses'])): ?>
                    <?php foreach ($report['expenses'] as $expense): ?>
                    <tr class="border-b border-border/50 hover:bg-indigo-500/[0.04] transition-colors">
                        <td class="px-5 py-3.5 text-slate-300"><?= format_date($expense->expense_date) ?></td>
                        <td class="px-5 py-3.5">
                            <span class="inline-block px-2.5 py-1 rounded-full text-xs font-medium
                                <?= match($expense->category) {
                                    'purchase'    => 'bg-amber-500/15 text-amber-400',
                                    'operational' => 'bg-blue-500/15 text-blue-400',
                                    'salary'      => 'bg-purple-500/15 text-purple-400',
                                    default       => 'bg-slate-500/15 text-slate-400',
                                } ?>">
                                <?= e(ucfirst($expense->category)) ?>
                            </span>
                        </td>
                        <td class="px-5 py-3.5 text-slate-300"><?= e($expense->description) ?></td>
                        <td class="px-5 py-3.5 text-right text-red-400 font-semibold"><?= format_rupiah($expense->amount) ?></td>
                    </tr>
                    <?php endforeach; ?>
                    <tr class="bg-red-500/[0.06]">
                        <td colspan="3" class="px-5 py-3.5 text-right font-bold text-slate-200 uppercase text-xs tracking-wider">Total Pengeluaran</td>
                        <td class="px-5 py-3.5 text-right font-bold text-red-400 text-base"><?= format_rupiah($report['total_expense']) ?></td>
                    </tr>
                <?php else: ?>
                    <tr>
                        <td colspan="4" class="px-5 py-8 text-center text-slate-500">Tidak ada data pengeluaran untuk periode ini</td>
                    </tr>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>

<!-- Profit/Loss Summary Banner -->
<div class="bg-card border border-border rounded-xl p-6 text-center <?= $isProfit ? 'border-emerald-500/20' : 'border-red-500/20' ?>">
    <p class="text-slate-400 text-sm mb-2">Laba / Rugi Bersih — <?= $months[$currentMonth] ?> <?= $currentYear ?></p>
    <p class="text-4xl font-bold <?= $isProfit ? 'text-emerald-400' : 'text-red-400' ?> mb-2">
        <?= $isProfit ? '+ ' : '- ' ?><?= format_rupiah(abs($report['net_profit'])) ?>
    </p>
    <div class="inline-flex items-center gap-1.5 px-3 py-1.5 rounded-full text-xs font-semibold <?= $isProfit ? 'bg-emerald-500/15 text-emerald-400' : 'bg-red-500/15 text-red-400' ?>">
        <?= $isProfit ? '▲ PROFIT' : '▼ LOSS' ?>
    </div>
</div>
