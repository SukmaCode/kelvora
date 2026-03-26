<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h2 class="text-lg font-semibold">User Detail</h2>
    <div class="flex flex-col sm:flex-row gap-2">
        <a href="<?= url("/users/{$user->id}/edit") ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-amber-500/15 text-amber-400 border border-amber-500/30 hover:bg-amber-500/25 w-full sm:w-auto">✏️ Edit</a>
        <a href="<?= url('/users') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-transparent text-slate-400 border border-border hover:text-slate-200 hover:border-slate-400 w-full sm:w-auto">← Back to List</a>
    </div>
</div>

<div class="bg-card border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="p-4 sm:p-6">
        <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 sm:gap-5">
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">ID</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($user->id) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Business Name</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($user->business_name) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Owner Name</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($user->owner_name) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Email</span>
                <span class="text-[0.95rem] text-slate-200 break-all"><?= e($user->email) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Phone</span>
                <span class="text-[0.95rem] text-slate-200"><?= e($user->phone ?? '-') ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Role</span>
                <span class="text-[0.95rem] text-slate-200"><span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full capitalize tracking-tight bg-cyan-500/15 text-cyan-400"><?= e($user->role) ?></span></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Status</span>
                <span class="text-[0.95rem] text-slate-200">
                    <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full capitalize tracking-tight <?= $user->status === 'active' ? 'bg-green-500/15 text-green-400' : 'bg-red-500/15 text-red-400' ?>">
                        <?= e($user->status) ?>
                    </span>
                </span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Created At</span>
                <span class="text-[0.95rem] text-slate-200"><?= format_datetime($user->created_at) ?></span>
            </div>
            <div class="flex flex-col gap-1">
                <span class="text-xs font-medium text-slate-500 uppercase tracking-wide">Updated At</span>
                <span class="text-[0.95rem] text-slate-200"><?= format_datetime($user->updated_at) ?></span>
            </div>
        </div>
    </div>
</div>
