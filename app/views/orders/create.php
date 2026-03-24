<div class="content-header">
    <h2>Create New Order</h2>
    <a href="<?= url('/orders') ?>" class="btn btn-secondary">← Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= url('/orders/store') ?>" method="POST" id="orderForm">
            <?= csrf_field() ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="customer_id">Customer <span class="required">*</span></label>
                    <select id="customer_id" name="customer_id" class="form-control" required>
                        <option value="">— Select Customer —</option>
                        <?php foreach ($customers as $customer): ?>
                            <option value="<?= e($customer->id) ?>">
                                <?= e($customer->name) ?> (<?= e($customer->phone ?? '-') ?>)
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <?php if (empty($customers)): ?>
                        <small class="form-hint text-danger">No customers available. Please add customers first.</small>
                    <?php endif; ?>
                </div>
            </div>

            <h3 style="margin: 1.5rem 0 1rem;">Order Items</h3>
            <div id="order-items">
                <div class="order-item-row" style="display: flex; gap: 1rem; margin-bottom: 0.75rem; align-items: end;">
                    <div class="form-group" style="flex: 3; margin-bottom: 0;">
                        <label>Product</label>
                        <select name="product_id[]" class="form-control" required>
                            <option value="">— Select Product —</option>
                            <?php foreach ($products as $product): ?>
                                <option value="<?= e($product->id) ?>">
                                    <?= e($product->name) ?> — <?= format_rupiah($product->price) ?> (Stock: <?= e($product->stock) ?>)
                                </option>
                            <?php endforeach; ?>
                        </select>
                    </div>
                    <div class="form-group" style="flex: 1; margin-bottom: 0;">
                        <label>Qty</label>
                        <input type="number" name="quantity[]" class="form-control" value="1" min="1" required>
                    </div>
                    <button type="button" class="btn btn-danger btn-sm" onclick="this.closest('.order-item-row').remove()">✕</button>
                </div>
            </div>

            <button type="button" class="btn btn-secondary" style="margin-top: 0.5rem;" onclick="addOrderItem()">
                + Add Item
            </button>

            <div class="form-actions" style="margin-top: 2rem;">
                <button type="submit" class="btn btn-primary">💾 Create Order</button>
                <a href="<?= url('/orders') ?>" class="btn btn-secondary">Cancel</a>
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
