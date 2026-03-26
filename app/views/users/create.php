<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h2 class="text-lg font-semibold">Create New User</h2>
    <a href="<?= url('/users') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 w-full sm:w-auto">← Back to List</a>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="p-4 sm:p-6">
        <form action="<?= url('/users/store') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
                <div class="flex flex-col gap-1.5">
                    <label for="business_name" class="text-sm font-medium text-slate-400">Business Name <span class="text-red-400">*</span></label>
                    <input type="text" id="business_name" name="business_name" 
                           value="<?= old('business_name') ?>" 
                           class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500" required>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="owner_name" class="text-sm font-medium text-slate-400">Owner Name <span class="text-red-400">*</span></label>
                    <input type="text" id="owner_name" name="owner_name" 
                           value="<?= old('owner_name') ?>" 
                           class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500" required>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="email" class="text-sm font-medium text-slate-400">Email <span class="text-red-400">*</span></label>
                    <input type="email" id="email" name="email" 
                           value="<?= old('email') ?>" 
                           class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500" required>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="phone" class="text-sm font-medium text-slate-400">Phone</label>
                    <input type="text" id="phone" name="phone" 
                           value="<?= old('phone') ?>" 
                           class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500">
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="password" class="text-sm font-medium text-slate-400">Password <span class="text-red-400">*</span></label>
                    <input type="password" id="password" name="password" 
                           class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] placeholder:text-slate-500" required minlength="6">
                    <small class="text-xs text-slate-500">Minimum 6 characters</small>
                </div>

                <div class="flex flex-col gap-1.5">
                    <label for="role" class="text-sm font-medium text-slate-400">Role</label>
                    <select id="role" name="role" class="w-full px-3 sm:px-3.5 py-2.5 text-sm font-sans text-slate-200 bg-input border border-border rounded-md outline-none transition-all duration-200 focus:border-accent focus:shadow-[0_0_0_3px_rgba(99,102,241,0.15)] appearance-none bg-[url('data:image/svg+xml,%3Csvg%20xmlns%3D%22http%3A//www.w3.org/2000/svg%22%20width%3D%2212%22%20height%3D%2212%22%20viewBox%3D%220%200%2012%2012%22%3E%3Cpath%20fill%3D%22%2394a3b8%22%20d%3D%22M6%208L1%203h10z%22/%3E%3C/svg%3E')] bg-no-repeat bg-[position:right_0.75rem_center] pr-8">
                        <option value="owner" <?= old('role', 'owner') === 'owner' ? 'selected' : '' ?>>Owner</option>
                        <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="staff" <?= old('role') === 'staff' ? 'selected' : '' ?>>Staff</option>
                    </select>
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
                <button type="submit" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-accent text-white border border-accent hover:bg-accent-hover hover:-translate-y-px w-full sm:w-auto">💾 Save User</button>
                <a href="<?= url('/users') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 w-full sm:w-auto">Cancel</a>
            </div>
        </form>
    </div>
</div>
