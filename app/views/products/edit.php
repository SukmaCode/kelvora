<div class="content-header">
    <h2>Edit Product: <?= e($product->name) ?></h2>
    <a href="<?= url('/products') ?>" class="btn btn-secondary">← Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= url("/products/{$product->id}/update") ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="name">Product Name <span class="required">*</span></label>
                    <input type="text" id="name" name="name" 
                           value="<?= e($product->name) ?>" 
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="category">Category</label>
                    <input type="text" id="category" name="category" 
                           value="<?= e($product->category ?? '') ?>" 
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="price">Price (Rp) <span class="required">*</span></label>
                    <input type="number" id="price" name="price" 
                           value="<?= e($product->price) ?>" 
                           class="form-control" required min="1" step="100">
                </div>

                <div class="form-group">
                    <label for="stock">Stock</label>
                    <input type="number" id="stock" name="stock" 
                           value="<?= e($product->stock) ?>" 
                           class="form-control" min="0">
                </div>

                <div class="form-group full-width">
                    <label for="description">Description</label>
                    <textarea id="description" name="description" 
                              class="form-control" rows="4"><?= e($product->description ?? '') ?></textarea>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active" <?= $product->status === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $product->status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Update Product</button>
                <a href="<?= url('/products') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
