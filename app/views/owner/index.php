<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] flex items-center justify-between p-6 mb-8">
    <div>
        <h2 class="text-2xl font-bold text-white mb-1">Hello, <?= e($_SESSION['business_name'] ?? 'Owner') ?>! 👋</h2>
        <p class="text-slate-400">Here's a quick overview of your business today.</p>
    </div>
</div>

<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5 mb-8">
    <div class="bg-card border border-border rounded-[10px] p-4 sm:p-5 flex items-center gap-4 shadow-[0_4px_24px_rgba(0,0,0,0.25)] transition-all duration-200 hover:border-accent hover:-translate-y-0.5">
        <div class="text-2xl sm:text-3xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-indigo-500/[0.12] rounded-md shrink-0">📦</div>
        <div class="flex flex-col min-w-0">
            <span class="text-xs text-slate-400 uppercase tracking-wide">Products</span>
            <span class="text-lg sm:text-xl font-bold"><?= number_format($totalProducts ?? 0, 0, ',', '.') ?></span>
        </div>
    </div>
    <div class="bg-card border border-border rounded-[10px] p-4 sm:p-5 flex items-center gap-4 shadow-[0_4px_24px_rgba(0,0,0,0.25)] transition-all duration-200 hover:border-accent hover:-translate-y-0.5">
        <div class="text-2xl sm:text-3xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-indigo-500/[0.12] rounded-md shrink-0">🛒</div>
        <div class="flex flex-col min-w-0">
            <span class="text-xs text-slate-400 uppercase tracking-wide">Orders</span>
            <span class="text-lg sm:text-xl font-bold"><?= number_format($totalOrders ?? 0, 0, ',', '.') ?></span>
        </div>
    </div>
    <div class="bg-card border border-border rounded-[10px] p-4 sm:p-5 flex items-center gap-4 shadow-[0_4px_24px_rgba(0,0,0,0.25)] transition-all duration-200 hover:border-accent hover:-translate-y-0.5">
        <div class="text-2xl sm:text-3xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-indigo-500/[0.12] rounded-md shrink-0">💸</div>
        <div class="flex flex-col min-w-0">
            <span class="text-xs text-slate-400 uppercase tracking-wide">Today's Sales</span>
            <span class="text-lg font-bold"><?= format_rupiah($todaySales ?? 0) ?></span>
        </div>
    </div>
    <div class="bg-card border border-border rounded-[10px] p-4 sm:p-5 flex items-center gap-4 shadow-[0_4px_24px_rgba(0,0,0,0.25)] transition-all duration-200 hover:border-accent hover:-translate-y-0.5">
        <div class="text-2xl sm:text-3xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-indigo-500/[0.12] rounded-md shrink-0">📈</div>
        <div class="flex flex-col min-w-0">
            <span class="text-xs text-slate-400 uppercase tracking-wide">Monthly Revenue</span>
            <span class="text-lg font-bold"><?= format_rupiah($monthlyRevenue ?? 0) ?></span>
        </div>
    </div>
</div>

<div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
    <div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
        <div class="px-4 sm:px-6 py-4 border-b border-border flex justify-between items-center">
            <h2 class="text-base font-semibold">Quick Actions</h2>
        </div>
        <div class="p-4 sm:p-6 grid grid-cols-2 gap-4">
            <a href="<?= url('/products/create') ?>" class="flex flex-col items-center justify-center gap-2 p-4 rounded bg-indigo-500/10 border border-indigo-500/20 hover:bg-indigo-500/20 transition-all text-indigo-400">
                <span class="text-2xl">➕</span>
                <span class="text-sm font-medium">Add Product</span>
            </a>
            <a href="<?= url('/orders/create') ?>" class="flex flex-col items-center justify-center gap-2 p-4 rounded bg-[#10b981]/10 border border-[#10b981]/20 hover:bg-[#10b981]/20 transition-all text-[#10b981]">
                <span class="text-2xl">🛍️</span>
                <span class="text-sm font-medium">New Order</span>
            </a>
            <a href="<?= url('/income-statements') ?>" class="col-span-2 flex items-center justify-center gap-2 p-4 rounded bg-slate-800 border border-slate-700 hover:bg-slate-700 transition-all">
                <span class="text-xl">📊</span>
                <span class="text-sm font-medium">View Income Statement</span>
            </a>
        </div>
    </div>
</div>
