<?php
// Sidebar Navigation
?>
<aside id="sidebar" class="w-sidebar min-h-screen bg-sidebar border-r border-border flex flex-col fixed top-0 left-0 z-[100] transition-transform duration-300 -translate-x-full lg:translate-x-0">
    <div class="px-5 py-6 flex items-center gap-3 border-b border-gray-300">
        <a href="<?= url('/') ?>" class="flex gap-4 justify-center items-center">
            <span>
                <img 
                src="<?= url('public/assets/images/logo-biru.png') ?>" 
                alt="Logo"
                class="w-8 h-8">
            </span>
            <span class="text-xl font-bold text-[#171717]">Kelvora</span>
        </a>
    </div>
    <nav class="flex-1 px-3 py-4 flex flex-col gap-1 overflow-y-auto">
        <?php $uriPath = $_GET['url'] ?? ''; ?>
        
        <?php if (($_SESSION['user_role'] ?? '') === 'owner' || ($_SESSION['user_role'] ?? '') === 'admin'): ?>
        <a href="<?= url('/home') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= ($uriPath === 'home' || $uriPath === '') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
            <span class="text-lg w-6 flex justify-center">
                <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
            </span>
            <span>Dashboard</span>
        </a>
        <?php endif; ?>
        
        <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
        <a href="<?= url('/users') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'users') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
            <span class="text-lg w-6 flex justify-center">
                <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
            </span>
            <span>Users</span>
        </a>
        <a href="<?= url('/admin/revenues') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'admin/revenues') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
            <span class="text-lg w-6 flex justify-center">
                <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M21.21 15.89A10 10 0 1 1 8 2.83"></path><path d="M22 12A10 10 0 0 0 12 2v10z"></path></svg>
            </span>
            <span>UMKM Revenues</span>
        </a>
        <a href="<?= url('/admin/payments') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'admin/payments') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
            <span class="text-lg w-6 flex justify-center">
                <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="12" y1="1" x2="12" y2="23"></line><path d="M17 5H9.5a3.5 3.5 0 0 0 0 7h5a3.5 3.5 0 0 1 0 7H6"></path></svg>
            </span>
            <span>Payment Approvals</span>
        </a>
        <?php endif; ?>

        <?php if (($_SESSION['user_role'] ?? '') === 'owner'): ?>
        <a href="<?= url('/products') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'products') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
            <span class="text-lg w-6 flex justify-center">
                <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
            </span> 
            <span>Products</span>
        </a>
        <a href="<?= url('/orders') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'orders') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
            <span class="text-lg w-6 flex justify-center">
                <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
            </span> 
            <span>Orders</span>
        </a>
        <a href="<?= url('/income-statements') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'income-statements') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
            <span class="text-lg w-6 flex justify-center">
                <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            </span> 
            <span>Income Statements</span>
        </a>
        <?php endif; ?>

        <a href="<?= url('/profile') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'profile') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
            <span class="text-lg w-6 flex justify-center">
                <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
            </span> 
            <span>Edit Profile</span>
        </a>

        <div class="mt-auto"></div>
        <a href="<?= url('/logout') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium text-red-500 hover:bg-red-50">
            <span class="text-lg w-6 flex justify-center">
                <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
            </span>
            <span>Logout</span>
        </a>
    </nav>
</aside>
