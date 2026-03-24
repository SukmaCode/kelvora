<div class="content-header">
    <h2>Product Detail</h2>
    <div>
        <a href="<?= url("/products/{$product->id}/edit") ?>" class="btn btn-warning">✏️ Edit</a>
        <a href="<?= url('/products') ?>" class="btn btn-secondary">← Back to List</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">ID</span>
                <span class="detail-value"><?= e($product->id) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Name</span>
                <span class="detail-value"><?= e($product->name) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Category</span>
                <span class="detail-value"><?= e($product->category ?? '-') ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Price</span>
                <span class="detail-value"><?= format_rupiah($product->price) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Stock</span>
                <span class="detail-value"><?= e($product->stock) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    <span class="badge badge-<?= $product->status === 'active' ? 'success' : 'danger' ?>">
                        <?= e($product->status) ?>
                    </span>
                </span>
            </div>
            <div class="detail-item full-width">
                <span class="detail-label">Description</span>
                <span class="detail-value"><?= nl2br(e($product->description ?? '-')) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Created At</span>
                <span class="detail-value"><?= format_datetime($product->created_at) ?></span>
            </div>
        </div>
    </div>
</div>
