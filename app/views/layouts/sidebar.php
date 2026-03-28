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
                        sidebar: '#ffffff',
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
        <div class="px-5 py-6 flex items-center gap-3 border-b border-gray-300">
            <a href="<?= url('/') ?>" class="flex gap-4 justify-center items-center">
                <span>
                    <img 
                    src="<?= url('public/assets/images/logo-biru.png') ?>" 
                    alt="Logo"
                    class="w-8 h-8">
                </span>
                <span class="text-xl font-bold text-[#171717]">Kelvora</span>
            </a>
        </div>
        <nav class="flex-1 px-3 py-4 flex flex-col gap-1 overflow-y-auto">
            <?php $uriPath = $_GET['url'] ?? ''; ?>
            
            <a href="<?= url('/home') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= ($uriPath === 'home' || $uriPath === '') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
                <span class="text-lg w-6 flex justify-center">
                    <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><rect x="3" y="3" width="7" height="9"></rect><rect x="14" y="3" width="7" height="5"></rect><rect x="14" y="12" width="7" height="9"></rect><rect x="3" y="16" width="7" height="5"></rect></svg>
                </span>
                <span>Dashboard</span>
            </a>
            
            <?php if (($_SESSION['user_role'] ?? '') === 'admin'): ?>
            <a href="<?= url('/users') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'users') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
                <span class="text-lg w-6 flex justify-center">
                    <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M17 21v-2a4 4 0 0 0-4-4H5a4 4 0 0 0-4 4v2"></path><circle cx="9" cy="7" r="4"></circle><path d="M23 21v-2a4 4 0 0 0-3-3.87"></path><path d="M16 3.13a4 4 0 0 1 0 7.75"></path></svg>
                </span>
                <span>Users</span>
            </a>
            <?php endif; ?>

            <?php if (($_SESSION['user_role'] ?? '') === 'owner'): ?>
            <a href="<?= url('/products') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'products') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
                <span class="text-lg w-6 flex justify-center">
                    <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><line x1="16.5" y1="9.4" x2="7.5" y2="4.21"></line><path d="M21 16V8a2 2 0 0 0-1-1.73l-7-4a2 2 0 0 0-2 0l-7 4A2 2 0 0 0 3 8v8a2 2 0 0 0 1 1.73l7 4a2 2 0 0 0 2 0l7-4A2 2 0 0 0 21 16z"></path><polyline points="3.27 6.96 12 12.01 20.73 6.96"></polyline><line x1="12" y1="22.08" x2="12" y2="12"></line></svg>
                </span> 
                <span>Products</span>
            </a>
            <a href="<?= url('/orders') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'orders') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
                <span class="text-lg w-6 flex justify-center">
                    <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><circle cx="9" cy="21" r="1"></circle><circle cx="20" cy="21" r="1"></circle><path d="M1 1h4l2.68 13.39a2 2 0 0 0 2 1.61h9.72a2 2 0 0 0 2-1.61L23 6H6"></path></svg>
                </span> 
                <span>Orders</span>
            </a>
            <a href="<?= url('/income-statements') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium <?= str_starts_with($uriPath, 'income-statements') ? 'bg-[#2d3bd9] text-white shadow-md shadow-[#2d3bd9]/20' : 'text-[#545e68] hover:bg-slate-100 hover:text-black' ?>">
                <span class="text-lg w-6 flex justify-center">
                    <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><polyline points="23 6 13.5 15.5 8.5 10.5 1 18"></polyline><polyline points="17 6 23 6 23 12"></polyline></svg>
                </span> 
                <span>Income Statements</span>
            </a>
            <?php endif; ?>

            <div class="mt-auto"></div>
            <a href="<?= url('/logout') ?>" class="flex items-center gap-3 py-3 px-4 rounded-[10px] transition-all duration-200 font-medium text-red-500 hover:bg-red-50">
                <span class="text-lg w-6 flex justify-center">
                    <svg class="w-[22px] h-[22px]" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round" stroke-linejoin="round"><path d="M9 21H5a2 2 0 0 1-2-2V5a2 2 0 0 1 2-2h4"></path><polyline points="16 17 21 12 16 7"></polyline><line x1="21" y1="12" x2="9" y2="12"></line></svg>
                </span>
                <span>Logout</span>
            </a>
        </nav>
    </aside>

    <!-- Main Content -->
    <main class="bg-white flex-1 min-h-screen w-full lg:ml-sidebar">
        <!-- Mobile Topbar -->
        <header class="pt-4 px-4 pb-2 sm:pt-6 sm:px-6 md:px-8 flex items-center gap-3">
            <button id="menuBtn" class="lg:hidden flex items-center justify-center w-10 h-10 rounded-md bg-card border border-border text-slate-300 hover:bg-indigo-500/10 transition-all" onclick="toggleSidebar()">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
            <h1 class="text-xl sm:text-2xl font-bold text-black"><?= e($title ?? 'Dashboard') ?></h1>
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
