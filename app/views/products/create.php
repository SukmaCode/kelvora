<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h2 class="text-lg font-semibold">Create New Product</h2>
    <a href="<?= url('/products') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 w-full sm:w-auto">← Back to List</a>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="p-4 sm:p-6">
        <form action="<?= url('/products/store') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div class="flex flex-col gap-1.5">
                    <label for="name" class="text-sm font-medium text-slate-400">Product Name <span class="text-red-400">*</span></label>
                    <input type="text" id="name" name="name" 
                           value="<?= old('name') ?>" 
                           class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500" required>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="category" class="text-sm font-medium text-slate-400">Category</label>
                    <input type="text" id="category" name="category" 
                           value="<?= old('category') ?>" 
                           class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="price" class="text-sm font-medium text-slate-400">Price (Rp) <span class="text-red-400">*</span></label>
                    <input type="number" id="price" name="price" 
                           value="<?= old('price') ?>" 
                           class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500" required min="1" step="100">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="stock" class="text-sm font-medium text-slate-400">Stock</label>
                    <input type="number" id="stock" name="stock" 
                           value="<?= old('stock', '0') ?>" 
                           class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500" min="0">
                </div>

                <div class="flex flex-col gap-1.5 sm:col-span-2">
                    <label for="description" class="text-sm font-medium text-slate-400">Description</label>
                    <textarea id="description" name="description" 
                              class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500 resize-y min-h-[80px]" rows="4"><?= old('description') ?></textarea>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="status" class="text-sm font-medium text-slate-400">Status</label>
                    <select id="status" name="status" class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2012%2012%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M6%208L1%203h10z%22/%3E%3C/svg%3E')] bg-no-repeat bg-[position:right_0.75rem_center] pr-8">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="mt-6 flex flex-col sm:flex-row gap-3 pt-6 border-t border-border">
                <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-accent text-white border border-accent hover:bg-accent-hover hover:-translate-y-px w-full sm:w-auto">💾 Save Product</button>
                <a href="<?= url('/products') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 w-full sm:w-auto">Cancel</a>
            </div>
        </form>
    </div>
</div>
