<div class="content-header">
    <h2>All Products</h2>
    <a href="<?= url('/products/create') ?>" class="btn btn-primary">+ Add Product</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Name</th>
                    <th>Category</th>
                    <th>Price</th>
                    <th>Stock</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-muted">No products found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($products as $product): ?>
                        <tr>
                            <td><?= e($product->id) ?></td>
                            <td><strong><?= e($product->name) ?></strong></td>
                            <td><?= e($product->category ?? '-') ?></td>
                            <td><?= format_rupiah($product->price) ?></td>
                            <td><?= e($product->stock) ?></td>
                            <td>
                                <span class="badge badge-<?= $product->status === 'active' ? 'success' : 'danger' ?>">
                                    <?= e($product->status) ?>
                                </span>
                            </td>
                            <td><?= format_date($product->created_at) ?></td>
                            <td class="actions">
                                <a href="<?= url("/products/{$product->id}") ?>" class="btn btn-sm btn-info">👁</a>
                                <a href="<?= url("/products/{$product->id}/edit") ?>" class="btn btn-sm btn-warning">✏️</a>
                                <form action="<?= url("/products/{$product->id}/delete") ?>" method="POST" class="inline-form"
                                      onsubmit="return confirm('Delete this product?')">
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
