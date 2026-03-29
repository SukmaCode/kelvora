<div class="flex items-center justify-between mb-4 sm:mb-6">
    <h1 class="text-xl sm:text-2xl font-bold text-black border-l-4 border-[#2d3bd9] pl-3 sm:pl-4 tracking-tight py-0.5 mb-0 leading-tight">Customer Payment Approvals</h1>
</div>

<div class="bg-transparent border border-gray-300 rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="p-4 sm:p-5 md:p-6 pb-0">
        <h2 class="text-base font-semibold text-black mb-1">Payment Queue</h2>
        <p class="text-sm text-black mb-4 sm:mb-5">Review and manage pending payments from customers to UMKMs.</p>
    </div>
    
    <div class="overflow-x-auto w-full">
        <table class="w-full text-left border-collapse min-w-[1000px]">
            <thead>
                <tr class="bg-indigo-50/50 text-black text-xs uppercase tracking-wider">
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200 w-[60px] text-center">ID</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Date</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Customer</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">UMKM Shop</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Gross Price</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Admin Fee</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200">Net to Owner</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200 text-center">Status</th>
                    <th class="p-3 sm:p-4 font-semibold border-y border-gray-200 text-center w-[160px]">Actions</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-100 text-sm">
                <?php if (empty($payments)): ?>
                    <tr>
                        <td colspan="9" class="p-8 text-center text-gray-500">
                            <div class="flex flex-col items-center justify-center">
                                <span class="text-4xl mb-3">📭</span>
                                <p>No payment found in the queue.</p>
                            </div>
                        </td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($payments as $payment): ?>
                        <tr class="hover:bg-gray-50/80 transition-colors">
                            <td class="p-3 sm:p-4 text-center font-medium text-black">#<?= e($payment->id) ?></td>
                            <td class="p-3 sm:p-4 text-gray-600">
                                <?= date('d M Y, H:i', strtotime($payment->created_at)) ?>
                            </td>
                            <td class="p-3 sm:p-4">
                                <div class="font-medium text-black"><?= e($payment->customer_name) ?></div>
                                <div class="text-xs text-gray-500 mt-0.5"><?= e($payment->customer_phone) ?></div>
                            </td>
                            <td class="p-3 sm:p-4 font-medium text-[#2d3bd9]">
                                <?= e($payment->business_name) ?>
                            </td>
                            <td class="p-3 sm:p-4 font-semibold text-black">
                                <?= format_rupiah($payment->gross_amount) ?>
                            </td>
                            <td class="p-3 sm:p-4 font-semibold text-green-600">
                                <?= format_rupiah($payment->admin_fee) ?>
                            </td>
                            <td class="p-3 sm:p-4 font-semibold text-gray-700">
                                <?= format_rupiah($payment->net_amount) ?>
                            </td>
                            <td class="p-3 sm:p-4 text-center">
                                <?php if ($payment->payment_status === 'pending'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-yellow-100 text-yellow-800 border border-yellow-200">
                                        Pending
                                    </span>
                                <?php elseif ($payment->payment_status === 'approved'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-green-100 text-green-800 border border-green-200">
                                        Approved
                                    </span>
                                <?php elseif ($payment->payment_status === 'rejected'): ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-red-100 text-red-800 border border-red-200">
                                        Rejected
                                    </span>
                                <?php else: ?>
                                    <span class="inline-flex items-center px-2.5 py-1 rounded-full text-xs font-medium bg-gray-100 text-gray-800 border border-gray-200">
                                        <?= e(ucfirst($payment->payment_status)) ?>
                                    </span>
                                <?php endif; ?>
                            </td>
                            <td class="p-3 sm:p-4 text-center">
                                <?php if ($payment->payment_status === 'pending'): ?>
                                <div class="flex items-center justify-center gap-2">
                                    <form action="<?= url('/admin/payments/' . $payment->id . '/approve') ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to approve this payment?');">
                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                        <button type="submit" title="Approve Payment" class="p-1.5 text-green-600 hover:text-white hover:bg-green-600 border border-green-200 hover:border-green-600 rounded transition-colors group">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M22 11.08V12a10 10 0 1 1-5.93-9.14"></path><polyline points="22 4 12 14.01 9 11.01"></polyline></svg>
                                        </button>
                                    </form>
                                    <form action="<?= url('/admin/payments/' . $payment->id . '/reject') ?>" method="POST" class="inline" onsubmit="return confirm('Are you sure you want to reject this payment?');">
                                        <input type="hidden" name="csrf_token" value="<?= $_SESSION['csrf_token'] ?? '' ?>">
                                        <button type="submit" title="Reject Payment" class="p-1.5 text-red-600 hover:text-white hover:bg-red-600 border border-red-200 hover:border-red-600 rounded transition-colors group">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="18" y1="6" x2="6" y2="18"></line><line x1="6" y1="6" x2="18" y2="18"></line></svg>
                                        </button>
                                    </form>
                                </div>
                                <?php else: ?>
                                    <span class="text-xs text-gray-400 italic">No actions</span>
                                <?php endif; ?>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
