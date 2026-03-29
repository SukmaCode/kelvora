

<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h2 class="text-lg text-black font-semibold">All Products</h2>
    <a href="<?= url('/products/create') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-[#2d3bd9] text-white border border-[#2d3bd9] hover:bg-[#2d3bd9]/80 hover:-translate-y-px w-full sm:w-auto">+ Add Product</a>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse min-w-[650px]">
            <thead>
                <tr class="bg-[#2d3bd9]">
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-white border-b border-border">NO</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-white border-b border-border">Name</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-white border-b border-border">Category</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-white border-b border-border">Price</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-white border-b border-border">Stock</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-white border-b border-border">Status</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-white border-b border-border">Created</th>
                    <th class="px-3 sm:px-4 py-3 text-left text-xs font-semibold uppercase tracking-wide text-white border-b border-border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($products)): ?>
                    <tr>
                        <td colspan="8" class="text-center text-slate-500 px-4 py-6 text-sm border-b border-border">No products found.</td>
                    </tr>
                <?php else: ?>
                    <?php $num = 1; ?>
                    <?php foreach ($products as $product): ?>
                    <tr class="hover:bg-indigo-500/[0.04] [&:last-child>td]:border-b-0">
                            <td class="bg-white px-3 sm:px-4 py-3 text-sm text-black border-b border-border align-middle"><?= e($num++) ?></td>
                            <td class="bg-white px-3 sm:px-4 py-3 text-sm text-black border-b border-border align-middle"><strong><?= e($product->name) ?></strong></td>
                            <td class="bg-white px-3 sm:px-4 py-3 text-sm text-black border-b border-border align-middle"><?= e($product->category ?? '-') ?></td>
                            <td class="bg-white px-3 sm:px-4 py-3 text-sm text-black border-b border-border align-middle whitespace-nowrap"><?= format_rupiah($product->price) ?></td>
                            <td class="bg-white px-3 sm:px-4 py-3 text-sm text-black border-b border-border align-middle"><?= e($product->stock) ?></td>
                            <td class="bg-white px-3 sm:px-4 py-3 text-sm text-black border-b border-border align-middle">
                                <span class="inline-block px-2.5 py-0.5 text-xs text-black font-semibold rounded-full capitalize tracking-tight <?= $product->status === 'active' ? 'bg-green-500/15 text-green-400' : 'bg-red-500/15 text-red-400' ?>">
                                    <?= e($product->status) ?>
                                </span>
                            </td>
                            <td class="bg-white px-3 sm:px-4 py-3 text-sm text-black border-b border-border align-middle whitespace-nowrap"><?= format_date($product->created_at) ?></td>
                            <td class="bg-white px-3 sm:px-4 py-3 text-sm text-black border-b border-border align-middle">
                                <div class="flex gap-1.5 items-center flex-nowrap">
                                    <a href="<?= url("/products/{$product->id}") ?>" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md cursor-pointer transition-all duration-200 bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 hover:bg-cyan-500/25" title="View">👁</a>
                                    <a href="<?= url("/products/{$product->id}/edit") ?>" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md cursor-pointer transition-all duration-200 bg-amber-500/15 text-amber-400 border border-amber-500/30 hover:bg-amber-500/25" title="Edit">✏️</a>
                                    <form action="<?= url("/products/{$product->id}/delete") ?>" method="POST" class="inline-block"
                                          onsubmit="return confirm('Delete this product?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="inline-flex items-center gap-1 px-2.5 py-1.5 text-xs font-medium rounded-md cursor-pointer transition-all duration-200 bg-red-500/15 text-red-400 border border-red-500/30 hover:bg-red-500/25" title="Delete">🗑</button>
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
