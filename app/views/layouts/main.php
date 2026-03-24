<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kelvora - SaaS Business Management Platform">
    <title><?= e($title ?? 'Kelvora') ?> — Kelvora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= asset('css/style.css') ?>">
</head>
<body>
    <!-- Sidebar Navigation -->
    <aside class="sidebar">
        <div class="sidebar-brand">
            <span class="brand-icon">⚡</span>
            <span class="brand-text">Kelvora</span>
        </div>
        <nav class="sidebar-nav">
            <a href="<?= url('/') ?>" class="nav-link <?= ($_GET['url'] ?? '') === '' ? 'active' : '' ?>">
                <span class="nav-icon">📊</span> Dashboard
            </a>
            <a href="<?= url('/users') ?>" class="nav-link <?= str_starts_with($_GET['url'] ?? '', 'users') ? 'active' : '' ?>">
                <span class="nav-icon">👥</span> Users
            </a>
            <a href="<?= url('/products') ?>" class="nav-link <?= str_starts_with($_GET['url'] ?? '', 'products') ? 'active' : '' ?>">
                <span class="nav-icon">📦</span> Products
            </a>
            <a href="<?= url('/orders') ?>" class="nav-link <?= str_starts_with($_GET['url'] ?? '', 'orders') ? 'active' : '' ?>">
                <span class="nav-icon">🛒</span> Orders
            </a>
        </nav>
        <div class="sidebar-footer">
            <small>v1.0.0</small>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="main-content">
        <header class="topbar">
            <h1 class="page-title"><?= e($title ?? 'Dashboard') ?></h1>
        </header>

        <!-- Flash Message -->
        <?= flash_message() ?>

        <!-- Validation Errors -->
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="alert alert-danger">
                <ul class="error-list">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <!-- Page Content (injected by controller) -->
        <div class="content-wrapper">
            <?= $content ?>
        </div>
    </main>
</body>
</html>
