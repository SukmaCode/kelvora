<div class="dashboard-grid">
    <div class="stat-card">
        <div class="stat-icon">👥</div>
        <div class="stat-info">
            <span class="stat-label">Users</span>
            <span class="stat-value">—</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">📦</div>
        <div class="stat-info">
            <span class="stat-label">Products</span>
            <span class="stat-value">—</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">🛒</div>
        <div class="stat-info">
            <span class="stat-label">Orders</span>
            <span class="stat-value">—</span>
        </div>
    </div>
    <div class="stat-card">
        <div class="stat-icon">💰</div>
        <div class="stat-info">
            <span class="stat-label">Revenue</span>
            <span class="stat-value">—</span>
        </div>
    </div>
</div>

<div class="card" style="margin-top: 2rem;">
    <div class="card-header">
        <h2>Welcome to Kelvora</h2>
    </div>
    <div class="card-body">
        <p>This is the main dashboard of your SaaS business management platform. Use the sidebar to navigate:</p>
        <ul style="margin-top: 1rem; padding-left: 1.5rem;">
            <li><strong>Users</strong> — Manage registered business users</li>
            <li><strong>Products</strong> — Add and manage product catalog</li>
            <li><strong>Orders</strong> — Track and process orders</li>
        </ul>
        <div style="margin-top: 1.5rem;">
            <a href="<?= url('/users') ?>" class="btn btn-primary">Manage Users</a>
            <a href="<?= url('/products') ?>" class="btn btn-secondary" style="margin-left: 0.5rem;">Manage Products</a>
        </div>
    </div>
</div>
