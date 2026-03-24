<div class="content-header">
    <h2>User Detail</h2>
    <div>
        <a href="<?= url("/users/{$user->id}/edit") ?>" class="btn btn-warning">✏️ Edit</a>
        <a href="<?= url('/users') ?>" class="btn btn-secondary">← Back to List</a>
    </div>
</div>

<div class="card">
    <div class="card-body">
        <div class="detail-grid">
            <div class="detail-item">
                <span class="detail-label">ID</span>
                <span class="detail-value"><?= e($user->id) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Business Name</span>
                <span class="detail-value"><?= e($user->business_name) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Owner Name</span>
                <span class="detail-value"><?= e($user->owner_name) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Email</span>
                <span class="detail-value"><?= e($user->email) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Phone</span>
                <span class="detail-value"><?= e($user->phone ?? '-') ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Role</span>
                <span class="detail-value"><span class="badge badge-info"><?= e($user->role) ?></span></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Status</span>
                <span class="detail-value">
                    <span class="badge badge-<?= $user->status === 'active' ? 'success' : 'danger' ?>">
                        <?= e($user->status) ?>
                    </span>
                </span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Created At</span>
                <span class="detail-value"><?= format_datetime($user->created_at) ?></span>
            </div>
            <div class="detail-item">
                <span class="detail-label">Updated At</span>
                <span class="detail-value"><?= format_datetime($user->updated_at) ?></span>
            </div>
        </div>
    </div>
</div>
