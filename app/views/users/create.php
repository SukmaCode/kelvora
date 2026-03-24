<div class="content-header">
    <h2>Create New User</h2>
    <a href="<?= url('/users') ?>" class="btn btn-secondary">← Back to List</a>
</div>

<div class="card">
    <div class="card-body">
        <form action="<?= url('/users/store') ?>" method="POST">
            <?= csrf_field() ?>

            <div class="form-grid">
                <div class="form-group">
                    <label for="business_name">Business Name <span class="required">*</span></label>
                    <input type="text" id="business_name" name="business_name" 
                           value="<?= old('business_name') ?>" 
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="owner_name">Owner Name <span class="required">*</span></label>
                    <input type="text" id="owner_name" name="owner_name" 
                           value="<?= old('owner_name') ?>" 
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="email">Email <span class="required">*</span></label>
                    <input type="email" id="email" name="email" 
                           value="<?= old('email') ?>" 
                           class="form-control" required>
                </div>

                <div class="form-group">
                    <label for="phone">Phone</label>
                    <input type="text" id="phone" name="phone" 
                           value="<?= old('phone') ?>" 
                           class="form-control">
                </div>

                <div class="form-group">
                    <label for="password">Password <span class="required">*</span></label>
                    <input type="password" id="password" name="password" 
                           class="form-control" required minlength="6">
                    <small class="form-hint">Minimum 6 characters</small>
                </div>

                <div class="form-group">
                    <label for="role">Role</label>
                    <select id="role" name="role" class="form-control">
                        <option value="owner" <?= old('role', 'owner') === 'owner' ? 'selected' : '' ?>>Owner</option>
                        <option value="admin" <?= old('role') === 'admin' ? 'selected' : '' ?>>Admin</option>
                        <option value="staff" <?= old('role') === 'staff' ? 'selected' : '' ?>>Staff</option>
                    </select>
                </div>

                <div class="form-group">
                    <label for="status">Status</label>
                    <select id="status" name="status" class="form-control">
                        <option value="active">Active</option>
                        <option value="inactive">Inactive</option>
                    </select>
                </div>
            </div>

            <div class="form-actions">
                <button type="submit" class="btn btn-primary">💾 Save User</button>
                <a href="<?= url('/users') ?>" class="btn btn-secondary">Cancel</a>
            </div>
        </form>
    </div>
</div>
