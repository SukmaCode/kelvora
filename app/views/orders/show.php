<div class="content-header">
    <h2>Order #<?= e($order->id) ?></h2>
    <a href="<?= url('/orders') ?>" class="btn btn-secondary">← Back to List</a>
</div>

<div class="card">
    <div class="card-header">
        <h3>Order Information</h3>
    </div>
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">Order ID</span>
                <span class="detail-value">#<?= e($order->id) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Customer</span>
                <span class="detail-value"><?= e($order->customer_name ?? '-') ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Phone</span>
                <span class="detail-value"><?= e($order->customer_phone ?? '-') ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Address</span>
                <span class="detail-value"><?= e($order->customer_address ?? '-') ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Total Price</span>
                <span class="detail-value" style="font-size: 1.2rem; font-weight: 700; color: #6366f1;">
                    <?= format_rupiah($order->total_price) ?>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Payment Status</span>
                <span class="detail-value">
                    <span class="badge badge-<?= $order->payment_status === 'paid' ? 'success' : 'warning' ?>">
                        <?= e($order->payment_status) ?>
                    </span>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Order Status</span>
                <span class="detail-value">
                    <span class="badge badge-<?= $order->order_status === 'completed' ? 'success' : 'info' ?>">
                        <?= e($order->order_status) ?>
                    </span>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Created At</span>
                <span class="detail-value"><?= format_datetime($order->created_at) ?></span>
            </div>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 1.5rem;">
    <div class="card-header">
        <h3>Order Items</h3>
    </div>
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Product</th>
                    <th>Price</th>
                    <th>Quantity</th>
                    <th>Subtotal</th>
                </tr>
            </thead>
            <tbody>
                <?php foreach ($items as $item): ?>
                    <tr>
                        <td><?= e($item->product_name ?? 'Deleted Product') ?></td>
                        <td><?= format_rupiah($item->price) ?></td>
                        <td><?= e($item->quantity) ?></td>
                        <td><strong><?= format_rupiah($item->price * $item->quantity) ?></strong></td>
                    </tr>
                <?php endforeach; ?>
            </tbody>
            <tfoot>
                <tr>
                    <td colspan="3" style="text-align: right; font-weight: 600;">Total:</td>
                    <td style="font-weight: 700; font-size: 1.1rem; color: #6366f1;">
                        <?= format_rupiah($order->total_price) ?>
                    </td>
                </tr>
            </tfoot>
        </table>
    </div>
</div>
