<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h2 class="text-lg font-semibold">Order #<?= e($order->id) ?></h2>
    <a href="<?= url('/orders') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 w-full sm:w-auto">← Back to List</a>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="px-4 sm:px-6 py-4 border-b border-border">
        <h3 class="text-base font-semibold">Order Information</h3>
    </div>
    <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Order ID</span>
                <span class="text-[0.95rem] text-slate-200">#<?= e($order->id) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Customer</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($order->customer_name ?? '-') ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Phone</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($order->customer_phone ?? '-') ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Address</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($order->customer_address ?? '-') ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Total Price</span>
                <span class="text-base sm:text-lg font-bold text-indigo-400">
                    <?= format_rupiah($order->total_price) ?>
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Payment Status</span>
                <span class="text-[0.95rem] text-slate-200">
                    <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full capitalize tracking-tight <?= $order->payment_status === 'paid' ? 'bg-green-500/15 text-green-400' : 'bg-amber-500/15 text-amber-400' ?>">
                        <?= e($order->payment_status) ?>
                    </span>
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Order Status</span>
                <span class="text-[0.95rem] text-slate-200">
                    <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full capitalize tracking-tight <?= $order->order_status === 'completed' ? 'bg-green-500/15 text-green-400' : 'bg-cyan-500/15 text-cyan-400' ?>">
                        <?= e($order->order_status) ?>
                    </span>
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Created At</span>
                <span class="text-[0.95rem] text-slate-200"><?= format_datetime($order->created_at) ?></span>
            </div>
        </div>
    </div>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden mt-4 sm:mt-6">
    <div class="px-4 sm:px-6 py-4 border-b border-border">
        <h3 class="text-base font-semibold">Order Items</h3>
    </div>
    <div class="overflow-x-auto">
        <table class="w-full border-collapse min-w-[400px]">
            <thead>
                <tr>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Product</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Price</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Quantity</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr class="hover:bg-indigo-500/[0.04] [&:last-child>td]:border-b-0">
                        <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle"><?= e($item->product_name ?? 'Deleted Product') ?></td>
                        <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle whitespace-nowrap"><?= format_rupiah($item->price) ?></td>
                        <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle"><?= e($item->quantity) ?></td>
                        <td class="px-3 sm:px-4 py-3 text-sm border-b border-border align-middle whitespace-nowrap"><strong><?= format_rupiah($item->price * $item->quantity) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" class="px-3 sm:px-4 py-3.5 text-right font-semibold border-t-2 border-border">Total:</td>
                    <td class="px-3 sm:px-4 py-3.5 font-bold text-base sm:text-lg text-indigo-400 border-t-2 border-border whitespace-nowrap">
                        <?= format_rupiah($order->total_price) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
