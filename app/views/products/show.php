<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h2 class="text-lg font-semibold">Product Detail</h2>
    <div class="flex flex-col sm:flex-row gap-2">
        <a href="<?= url("/products/{$product->id}/edit") ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-amber-500/15 text-amber-400 border border-amber-500/30 hover:bg-amber-500/25 w-full sm:w-auto">✏️ Edit</a>
        <a href="<?= url('/products') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 w-full sm:w-auto">← Back to List</a>
    </div>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">ID</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($product->id) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Name</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($product->name) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Category</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($product->category ?? '-') ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Price</span>
                <span class="text-[0.95rem] text-slate-200"><?= format_rupiah($product->price) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Stock</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($product->stock) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Status</span>
                <span class="text-[0.95rem] text-slate-200">
                    <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full capitalize tracking-tight <?= $product->status === 'active' ? 'bg-green-500/15 text-green-400' : 'bg-red-500/15 text-red-400' ?>">
                        <?= e($product->status) ?>
                    </span>
                </span>
            </div>
            <div class="flex flex-col gap-1 sm:col-span-2">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Description</span>
                <span class="text-[0.95rem] text-slate-200"><?= nl2br(e($product->description ?? '-')) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Created At</span>
                <span class="text-[0.95rem] text-slate-200"><?= format_datetime($product->created_at) ?></span>
            </div>
        </div>
    </div>
</div>
