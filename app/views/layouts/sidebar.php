<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kelvora - SaaS Business Management Platform">
    <title><?= e($title ?? 'Kelvora') ?> — Kelvora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: {
                        sans: ['Inter', '-apple-system', 'BlinkMacSystemFont', 'sans-serif'],
                    },
                    colors: {
                        dark: '#0f172a',
                        sidebar: '#1e293b',
                        card: '#1e293b',
                        input: '#0f172a',
                        border: '#334155',
                        accent: {
                            DEFAULT: '#6366f1',
                            hover: '#4f46e5',
                            light: '#818cf8',
                        },
                    },
                    width: {
                        sidebar: '260px',
                    },
                    margin: {
                        sidebar: '260px',
                    },
                },
            },
        }
    </script>
    <style type="text/tailwindcss">
        @layer utilities {
            .brand-gradient {
                background: linear-gradient(135deg, #818cf8, #6366f1);
                -webkit-background-clip: text;
                -webkit-text-fill-color: transparent;
                background-clip: text;
            }
        }
        @keyframes fadeIn {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="font-sans bg-dark text-slate-200 flex min-h-screen leading-relaxed">
    <!-- Mobile Overlay -->
    <div id="sidebarOverlay" class="fixed inset-0 bg-black/50 z-[90] hidden lg:hidden" onclick="toggleSidebar()"></div>

    <!-- Sidebar Navigation -->
    <aside id="sidebar" class="w-sidebar min-h-screen bg-sidebar border-r border-border flex flex-col fixed top-0 left-0 z-[100] transition-transform duration-300 -translate-x-full lg:translate-x-0">
        <div class="px-5 py-6 flex items-center gap-3 border-b border-border">
            <span class="text-2xl">⚡</span>
            <span class="text-xl font-bold brand-gradient">Kelvora</span>
        </div>
        <nav class="flex-1 py-4 flex flex-col gap-0.5 overflow-y-auto">
            <a href="<?= url('/') ?>" class="flex items-center gap-3 py-3 px-5 text-slate-400 border-l-[3px] border-transparent transition-all duration-200 font-medium hover:text-slate-200 hover:bg-indigo-500/[0.08] <?= ($_GET['url'] ?? '') === '' ? '!text-indigo-400 !bg-indigo-500/[0.12] !border-l-indigo-500' : '' ?>">
                <span class="text-lg w-6 text-center">📊</span> <span>Dashboard</span>
            </a>
            
            <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
            <a href="<?= url('/users') ?>" class="flex items-center gap-3 py-3 px-5 text-slate-400 border-l-[3px] border-transparent transition-all duration-200 font-medium hover:text-slate-200 hover:bg-indigo-500/[0.08] <?= str_starts_with($_GET['url'] ?? '', 'users') ? '!text-indigo-400 !bg-indigo-500/[0.12] !border-l-indigo-500' : '' ?>">
                <span class="text-lg w-6 text-center">👥</span> <span>Users</span>
            </a>
            <?php endif; ?>

            <?php if (($_SESSION['user_role'] ?? '') === 'owner'): ?>
            <a href="<?= url('/products') ?>" class="flex items-center gap-3 py-3 px-5 text-slate-400 border-l-[3px] border-transparent transition-all duration-200 font-medium hover:text-slate-200 hover:bg-indigo-500/[0.08] <?= str_starts_with($_GET['url'] ?? '', 'products') ? '!text-indigo-400 !bg-indigo-500/[0.12] !border-l-indigo-500' : '' ?>">
                <span class="text-lg w-6 text-center">📦</span> <span>Products</span>
            </a>
            <a href="<?= url('/orders') ?>" class="flex items-center gap-3 py-3 px-5 text-slate-400 border-l-[3px] border-transparent transition-all duration-200 font-medium hover:text-slate-200 hover:bg-indigo-500/[0.08] <?= str_starts_with($_GET['url'] ?? '', 'orders') ? '!text-indigo-400 !bg-indigo-500/[0.12] !border-l-indigo-500' : '' ?>">
                <span class="text-lg w-6 text-center">🛒</span> <span>Orders</span>
            </a>
            <a href="<?= url('/income-statements') ?>" class="flex items-center gap-3 py-3 px-5 text-slate-400 border-l-[3px] border-transparent transition-all duration-200 font-medium hover:text-slate-200 hover:bg-indigo-500/[0.08] <?= str_starts_with($_GET['url'] ?? '', 'income-statements') ? '!text-indigo-400 !bg-indigo-500/[0.12] !border-l-indigo-500' : '' ?>">
                <span class="text-lg w-6 text-center">📈</span> <span>Income Statements</span>
            </a>
            <?php endif; ?>

            <div class="mt-auto"></div>
            <a href="<?= url('/logout') ?>" class="flex items-center gap-3 py-3 px-5 text-red-500 border-l-[3px] border-transparent transition-all duration-200 font-medium hover:text-red-400 hover:bg-red-500/[0.08] mt-2 border-t border-border">
                <span class="text-lg w-6 text-center">🚪</span> <span>Logout</span>
            </a>
        </nav>
        <div class="px-5 py-4 border-t border-border text-slate-500 text-center">
            <small>v1.0.0</small>
        </div>
    </aside>

    <!-- Main Content -->
    <main class="flex-1 min-h-screen w-full lg:ml-sidebar">
        <!-- Mobile Topbar -->
        <header class="pt-4 px-4 pb-2 sm:pt-6 sm:px-6 md:px-8 flex items-center gap-3">
            <button id="menuBtn" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-md bg-card border border-border text-slate-300 hover:bg-indigo-500/10 transition-all" onclick="toggleSidebar()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="text-xl sm:text-2xl font-bold text-slate-200"><?= e($title ?? 'Dashboard') ?></h1>
        </header>

        <!-- Flash Message -->
        <?= flash_message() ?>

        <!-- Validation Errors -->
        <?php if (!empty($_SESSION['errors'])): ?>
            <div class="mx-4 sm:mx-6 md:mx-8 px-4 sm:px-5 py-3.5 rounded-md mb-4 text-sm border border-red-500/25 bg-red-500/10 text-red-400 animate-[fadeIn_0.3s_ease]">
                <ul class="list-disc list-inside m-0 p-0">
                    <?php foreach ($_SESSION['errors'] as $error): ?>
                        <li class="mb-1"><?= e($error) ?></li>
                    <?php endforeach; ?>
                </ul>
            </div>
            <?php unset($_SESSION['errors']); ?>
        <?php endif; ?>

        <!-- Page Content (injected by controller) -->
        <div class="px-4 sm:px-6 md:px-8 pb-8 sm:pb-12 pt-2 sm:pt-4">
            <?= $content ?>
        </div>
    </main>

    <script>
        function toggleSidebar() {
            const sidebar = document.getElementById('sidebar');
            const overlay = document.getElementById('sidebarOverlay');
            sidebar.classList.toggle('-translate-x-full');
            overlay.classList.toggle('hidden');
        }
        // Close sidebar on nav link click (mobile)
        document.querySelectorAll('#sidebar a').forEach(link => {
            link.addEventListener('click', () => {
                if (window.innerWidth < 1024) {
                    toggleSidebar();
                }
            });
        });
    </script>
</body>
</html>
