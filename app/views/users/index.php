<div class="flex flex-col sm:flex-row sm:justify-between sm:items-center gap-3 mb-6">
    <h2 class="text-lg font-semibold">All Users</h2>
    <a href="<?= url('/users/create') ?>" class="inline-flex items-center justify-center gap-1.5 px-5 py-2.5 text-sm font-medium rounded-md cursor-pointer transition-all duration-200 bg-accent text-white border border-accent hover:bg-accent-hover hover:-translate-y-px w-full sm:w-auto">+ Add User</a>
</div>

<div class="border border-border rounded-[10px] shadow-[0_4px_24px_rgba(0,0,0,0.25)] overflow-hidden">
    <div class="overflow-x-auto">
        <table class="w-full border-collapse min-w-[700px]">
            <thead>
                <tr>
                    <th class="px-2 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">ID</th>
                    <th class="px-2 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Business Name</th>
                    <th class="px-2 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Owner</th>
                    <th class="px-2 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Email</th>
                    <th class="px-2 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Phone</th>
                    <th class="px-2 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Role</th>
                    <th class="px-2 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Status</th>
                    <th class="px-2 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Created</th>
                    <th class="px-2 py-4 text-left text-xs font-semibold uppercase tracking-wide text-slate-400 bg-black/20 border-b border-border">Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="9" class="text-center text-slate-500 px-4 py-6 text-sm border-b border-border">No users found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr class="hover:bg-indigo-500/[0.04] [&:last-child>td]:border-b-0">
                            <td class="px-2 py-4 text-sm border-b border-border align-middle"><?= e($user->id) ?></td>
                            <td class="px-2 py-4 text-sm border-b border-border align-middle"><strong><?= e($user->business_name) ?></strong></td>
                            <td class="px-2 py-4 text-sm border-b border-border align-middle"><?= e($user->owner_name) ?></td>
                            <td class="px-2 py-4 text-sm border-b border-border align-middle"><?= e($user->email) ?></td>
                            <td class="px-2 py-4 text-sm border-b border-border align-middle"><?= e($user->phone) ?></td>
                            <td class="px-2 py-4 text-sm border-b border-border align-middle"><span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full capitalize tracking-tight bg-cyan-500/15 text-cyan-400"><?= e($user->role) ?></span></td>
                            <td class="px-2 py-4 text-sm border-b border-border align-middle">
                                <span class="inline-block px-2.5 py-0.5 text-xs font-semibold rounded-full capitalize tracking-tight <?= $user->status === 'active' ? 'bg-green-500/15 text-green-400' : 'bg-red-500/15 text-red-400' ?>">
                                    <?= e($user->status) ?>
                                </span>
                            </td>
                            <td class="px-2 py-4 text-sm border-b border-border align-middle"><?= format_date($user->created_at) ?></td>
                            <td class="px-2 py-4 text-sm border-b border-border align-middle">
                                <div class="flex gap-1.5 items-center flex-nowrap">
                                    <a href="<?= url("/users/{$user->id}") ?>" class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-md cursor-pointer transition-all duration-200 bg-cyan-500/15 text-cyan-400 border border-cyan-500/30 hover:bg-cyan-500/25" title="View">👁</a>
                                    <a href="<?= url("/users/{$user->id}/edit") ?>" class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-md cursor-pointer transition-all duration-200 bg-amber-500/15 text-amber-400 border border-amber-500/30 hover:bg-amber-500/25" title="Edit">✏️</a>
                                    <form action="<?= url("/users/{$user->id}/delete") ?>" method="POST" class="inline-block"
                                          onsubmit="return confirm('Are you sure you want to delete this user?')">
                                        <?= csrf_field() ?>
                                        <button type="submit" class="inline-flex items-center gap-1 px-2 py-1 text-xs font-medium rounded-md cursor-pointer transition-all duration-200 bg-red-500/15 text-red-400 border border-red-500/30 hover:bg-red-500/25" title="Delete">🗑</button>
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
