<div class="content-header">
    <h2>All Orders</h2>
    <a href="<?= url('/orders/create') ?>" class="btn btn-primary">+ Create Order</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>Order #</th>
                    <th>Customer</th>
                    <th>Total</th>
                    <th>Payment</th>
                    <th>Status</th>
                    <th>Date</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($orders)): ?>
                    <tr>
                        <td colspan="7" class="text-center text-muted">No orders found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($orders as $order): ?>
                        <tr>
                            <td><strong>#<?= e($order->id) ?></strong></td>
                            <td><?= e($order->customer_name ?? '-') ?></td>
                            <td><?= format_rupiah($order->total_price) ?></td>
                            <td>
                                <?php
                                    $paymentBadge = match($order->payment_status) {
                                        'paid'    => 'success',
                                        'pending' => 'warning',
                                        'failed'  => 'danger',
                                        default   => 'info',
                                    };
                                ?>
                                <span class="badge badge-<?= $paymentBadge ?>">
                                    <?= e($order->payment_status) ?>
                                </span>
                            </td>
                            <td>
                                <?php
                                    $statusBadge = match($order->order_status) {
                                        'completed'  => 'success',
                                        'processing' => 'info',
                                        'new'        => 'warning',
                                        'cancelled'  => 'danger',
                                        default      => 'info',
                                    };
                                ?>
                                <span class="badge badge-<?= $statusBadge ?>">
                                    <?= e($order->order_status) ?>
                                </span>
                            </td>
                            <td><?= format_datetime($order->created_at) ?></td>
                            <td class="actions">
                                <a href="<?= url("/orders/{$order->id}") ?>" class="btn btn-sm btn-info">👁</a>
                                <form action="<?= url("/orders/{$order->id}/delete") ?>" method="POST" class="inline-form"
                                      onsubmit="return confirm('Delete this order?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger">🗑</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
