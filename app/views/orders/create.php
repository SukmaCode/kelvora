<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h2 class="text-lg font-semibold">Create New Order</h2>
    <a href="<?= url('/orders') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 w-full sm:w-auto">← Back to List</a>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="p-4 sm:p-6">
        <form action="<?= url('/orders/store') ?>" method="POST" id="orderForm">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div class="flex flex-col gap-1.5">
                    <label for="customer_id" class="text-sm font-medium text-slate-400">Customer <span class="text-red-400">*</span></label>
                    <select id="customer_id" name="customer_id" class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2012%2012%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M6%208L1%203h10z%22/%3E%3C/svg%3E')] bg-no-repeat bg-[position:right_0.75rem_center] pr-8" required>
                        <option value="">— Select Customer —</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?= e($customer->id) ?>">
                                <?= e($customer->name) ?> (<?= e($customer->phone ?? '-') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (empty($customers)): ?>
                        <small class="text-xs text-red-400">No customers available. Please add customers first.</small>
                    <?php endif; ?>
                </div>
            </div>

            <h3 class="mt-6 mb-4 text-base font-semibold">Order Items</h3>
            <div id="order-items">
                <div class="order-item-row flex flex-col sm:flex-row gap-3 sm:gap-4 mb-4 sm:mb-3 sm:items-end p-3 sm:p-0 bg-dark/50 sm:bg-transparent rounded-lg sm:rounded-none">
                    <div class="flex flex-col gap-1.5 sm:flex-[3]">
                        <label class="text-sm font-medium text-slate-400">Product</label>
                        <select name="product_id[]" class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2012%2012%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M6%208L1%203h10z%22/%3E%3C/svg%3E')] bg-no-repeat bg-[position:right_0.75rem_center] pr-8" required>
                            <option value="">— Select Product —</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= e($product->id) ?>">
                                    <?= e($product->name) ?> — <?= format_rupiah($product->price) ?> (Stock: <?= e($product->stock) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="flex flex-col gap-1.5 sm:flex-1">
                        <label class="text-sm font-medium text-slate-400">Qty</label>
                        <input type="number" name="quantity[]" class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500" value="1" min="1" required>
                    </div>
                    <button type="button" class="inline-flex items-center justify-center gap-1 px-3 py-2 sm:px-2.5 sm:py-1.5 text-xs font-medium rounded-md cursor-pointer transition-all duration-200 bg-red-500/15 text-red-400 border border-red-500/30 hover:bg-red-500/25 w-full sm:w-auto" onclick="this.closest('.order-item-row').remove()">✕ Remove</button>
                </div>
            </div>

            <button type="button" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 mt-2 w-full sm:w-auto" onclick="addOrderItem()">
                + Add Item
            </button>

            <div class="mt-8 flex flex-col sm:flex-row gap-3 pt-6 border-t border-border">
                <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-accent text-white border border-accent hover:bg-accent-hover hover:-translate-y-px w-full sm:w-auto">💾 Create Order</button>
                <a href="<?= url('/orders') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 w-full sm:w-auto">Cancel</a>
            </div>
        </form>
    </div>
</div>

<script>
function addOrderItem() {
    const container = document.getElementById('order-items');
    const row = container.querySelector('.order-item-row').cloneNode(true);
    row.querySelector('input[name="quantity[]"]').value = 1;
    row.querySelector('select[name="product_id[]"]').selectedIndex = 0;
    container.appendChild(row);
}
</script>
