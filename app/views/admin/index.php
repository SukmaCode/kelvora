<div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-4 sm:gap-5">
    <div class="bg-card border border-border rounded-[10px] p-4 sm:p-5 flex items-center gap-4 shadow-[0_4px_24px_rgba(0,0,0,0.25)] transition-all duration-200 hover:border-accent hover:-translate-y-0.5">
        <div class="text-2xl sm:text-3xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-indigo-500/[0.12] rounded-md shrink-0">👥</div>
        <div class="flex flex-col min-w-0">
            <span class="text-xs text-slate-400 uppercase tracking-wide">Users</span>
            <span class="text-lg sm:text-xl font-bold"><?= number_format($totalUsers ?? 0, 0, ',', '.') ?></span>
        </div>
    </div>
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
        <div class="text-2xl sm:text-3xl w-10 h-10 sm:w-12 sm:h-12 flex items-center justify-center bg-indigo-500/[0.12] rounded-md shrink-0">💰</div>
        <div class="flex flex-col min-w-0">
            <span class="text-xs text-slate-400 uppercase tracking-wide">Revenue</span>
            <span class="text-lg sm:text-xl font-bold"><?= format_rupiah($totalRevenue ?? 0) ?></span>
        </div>
    </div>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden mt-6 sm:mt-8">
    <div class="px-4 sm:px-6 py-4 border-b border-border">
        <h2 class="text-base font-semibold">Welcome to Kelvora Admin</h2>
    </div>
    <div class="p-4 sm:p-6">
        <p class="text-sm sm:text-base">This is the main admin dashboard of the Kelvora SaaS platform. Manage your overall users and businesses here.</p>
        <ul class="mt-3 sm:mt-4 pl-5 sm:pl-6 text-sm sm:text-base">
            <li><strong>Users</strong> — Manage registered business users (UMKM)</li>
        </ul>
        <div class="mt-4 sm:mt-6 flex flex-col sm:flex-row gap-2 sm:gap-3">
            <a href="<?= url('/users') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-accent text-white border border-accent hover:bg-accent-hover hover:-translate-y-px">Manage Users</a>
        </div>
    </div>
</div>
