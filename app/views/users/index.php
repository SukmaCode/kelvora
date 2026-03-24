<div class="content-header">
    <h2>All Users</h2>
    <a href="<?= url('/users/create') ?>" class="btn btn-primary">+ Add User</a>
</div>

<div class="card">
    <div class="table-responsive">
        <table class="table">
            <thead>
                <tr>
                    <th>ID</th>
                    <th>Business Name</th>
                    <th>Owner</th>
                    <th>Email</th>
                    <th>Phone</th>
                    <th>Role</th>
                    <th>Status</th>
                    <th>Created</th>
                    <th>Actions</th>
                </tr>
            </thead>
            <tbody>
                <?php if (empty($users)): ?>
                    <tr>
                        <td colspan="9" class="text-center text-muted">No users found.</td>
                    </tr>
                <?php else: ?>
                    <?php foreach ($users as $user): ?>
                        <tr>
                            <td><?= e($user->id) ?></td>
                            <td><strong><?= e($user->business_name) ?></strong></td>
                            <td><?= e($user->owner_name) ?></td>
                            <td><?= e($user->email) ?></td>
                            <td><?= e($user->phone) ?></td>
                            <td><span class="badge badge-info"><?= e($user->role) ?></span></td>
                            <td>
                                <span class="badge badge-<?= $user->status === 'active' ? 'success' : 'danger' ?>">
                                    <?= e($user->status) ?>
                                </span>
                            </td>
                            <td><?= format_date($user->created_at) ?></td>
                            <td class="actions">
                                <a href="<?= url("/users/{$user->id}") ?>" class="btn btn-sm btn-info" title="View">👁</a>
                                <a href="<?= url("/users/{$user->id}/edit") ?>" class="btn btn-sm btn-warning" title="Edit">✏️</a>
                                <form action="<?= url("/users/{$user->id}/delete") ?>" method="POST" class="inline-form"
                                      onsubmit="return confirm('Are you sure you want to delete this user?')">
                                    <?= csrf_field() ?>
                                    <button type="submit" class="btn btn-sm btn-danger" title="Delete">🗑</button>
                                </form>
                            </td>
                        </tr>
                    <?php endforeach; ?>
                <?php endif; ?>
            </tbody>
        </table>
    </div>
</div>
