<div class="flex items-center justify-between mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-bold text-black border-l-4 border-[#2d3bd9] pl-3 sm:pl-4 tracking-tight py-0.5 mb-0 leading-tight">UMKM Revenues</h1>
</div>

<div class="bg-transparent border border-gray-300 rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="p-4 sm:p-5 md:p-6 pb-0">
        <h2 class="text-base font-semibold text-black mb-1">UMKM Reporting</h2>
        <p class="text-sm text-black mb-4 sm:mb-5">View complete gross and net income from all registered UMKMs.</p>
    </div>
    
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse min-w-[800px]">
            <thead>
                <tr class="bg-indigo-50/50 text-black text-xs uppercase tracking-wider">
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Shop ID</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Business Name</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Owner</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Total Orders</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Gross Revenue (Total)</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Net Revenue (Owner)</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200 text-center">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php if (empty($revenues)): ?>
                    <tr>
                        <td colspan="7" class="p-8 text-center text-gray-500">
                            No UMKM revenue records found.
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($revenues as $revenue): ?>
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="p-3 sm:p-4 text-center font-medium text-black">#<?= e($revenue->id) ?></td>
                            <td class="p-3 sm:p-4 font-medium text-[#2d3bd9]">
                                <?= e($revenue->business_name) ?>
                            </td>
                            <td class="p-3 sm:p-4">
                                <div class="font-medium text-black"><?= e($revenue->owner_name) ?></div>
                                <div class="text-xs text-gray-500 mt-0.5"><?= e($revenue->email) ?></div>
                            </td>
                            <td class="p-3 sm:p-4 text-center font-medium text-black">
                                <?= e($revenue->total_orders) ?>
                            </td>
                            <td class="p-3 sm:p-4 font-semibold text-black">
                                <?= format_rupiah($revenue->gross_revenue) ?>
                            </td>
                            <td class="p-3 sm:p-4 font-semibold text-green-600">
                                <?= format_rupiah($revenue->net_revenue) ?>
                            </td>
                            <td class="p-3 sm:p-4 text-center">
                                <a href="<?= url('/admin/revenues/' . $revenue->id) ?>" class="inline-flex items-center px-3 py-1.5 bg-indigo-50 text-[#2d3bd9] hover:bg-[#2d3bd9] hover:text-white rounded transition-colors border border-indigo-200 text-xs font-semibold">
                                    View Details
                                </a>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
