<div class="content-header">
    <h2>Edit User: <?= e($user->business_name) ?></h2>
    <a href="<?= url('/users') ?>" class="btn btn-secondary">← Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= url("/users/{$user->id}/update") ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="business_name">Business Name <span class="required">*</span></label>
                    <input type="text" id="business_name" name="business_name" 
                           value="<?= e(old('business_name', $user->business_name)) ?>" 
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="owner_name">Owner Name <span class="required">*</span></label>
                    <input type="text" id="owner_name" name="owner_name" 
                           value="<?= e(old('owner_name', $user->owner_name)) ?>" 
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" 
                           value="<?= e(old('email', $user->email)) ?>" 
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" 
                           value="<?= e(old('phone', $user->phone)) ?>" 
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">New Password</label>
                    <input type="password" id="password" name="password" 
                           class="form-control" minlength="6">
                    <small class="form-hint">Leave blank to keep current password</small>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="form-control">
                        <option value="owner" <?= $user->role === 'owner' ? 'selected' : '' ?>>Owner</option>
                        <option value="admin" <?= $user->role === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="staff" <?= $user->role === 'staff' ? 'selected' : '' ?>>Staff</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active" <?= $user->status === 'active' ? 'selected' : '' ?>>Active</option>
                        <option value="inactive" <?= $user->status === 'inactive' ? 'selected' : '' ?>>Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Update User</button>
                <a href="<?= url('/users') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
