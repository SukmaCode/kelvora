<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h2 class="text-lg font-semibold">All Orders</h2>
    <a href="<?= url('/orders/create') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-accent text-white border border-accent hover:bg-accent-hover hover:-translate-y-px w-full sm:w-auto">+ Create Order</a>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse min-w-[600px]">
            <thead>
                <tr>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Order #</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Customer</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Gross</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Net</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Payment</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Status</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Date</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-slate-500 px-4 py-6 text-sm border-b border-border">No orders found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr class="hover:bg-indigo-500/[0.04] [&:last-child>td]:border-b-0">
                            <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle"><strong>#<?= e($order->id) ?></strong></td>
                            <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle"><?= e($order->customer_name ?? '-') ?></td>
                            <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle whitespace-nowrap"><?= format_rupiah($order->total_price) ?></td>
                            <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle whitespace-nowrap text-[#10b981] font-medium"><?= format_rupiah($order->owner_earning) ?></td>
                            <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle">
                                <?php
                                    $paymentBadge = match($order->payment_status) {
                                        'paid'    => 'bg-green-500/15 text-green-400',
                                        'pending' => 'bg-amber-500/15 text-amber-400',
                                        'failed'  => 'bg-red-500/15 text-red-400',
                                        default   => 'bg-cyan-500/15 text-cyan-400',
                                    };
                                ?>
                                <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full capitalize tracking-tight <?= $paymentBadge ?>">
                                    <?= e($order->payment_status) ?>
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle">
                                <?php
                                    $statusBadge = match($order->order_status) {
                                        'completed'  => 'bg-green-500/15 text-green-400',
                                        'processing' => 'bg-cyan-500/15 text-cyan-400',
                                        'new'        => 'bg-amber-500/15 text-amber-400',
                                        'cancelled'  => 'bg-red-500/15 text-red-400',
                                        default      => 'bg-cyan-500/15 text-cyan-400',
                                    };
                                ?>
                                <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full capitalize tracking-tight <?= $statusBadge ?>">
                                    <?= e($order->order_status) ?>
                                </span>
                            </td>
                            <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle whitespace-nowrap"><?= format_datetime($order->created_at) ?></td>
                            <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle">
                                <div class="flex gap-1.5 items-center flex-nowrap">
                                    <a href="<?= url("/orders/{$order->id}") ?>" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md cursor-pointer transition-all duration-200 bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 hover:bg-cyan-500/25">👁</a>
                                    <form action="<?= url("/orders/{$order->id}/delete") ?>" method="POST" class="inline-block"
                                          onsubmit="return confirm('Delete this order?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md cursor-pointer transition-all duration-200 bg-red-500/15 text-red-400 border border-red-500/30 hover:bg-red-500/25">🗑</button>
                                    </form>
                                </div>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
