<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kelvora - SaaS Business Management Platform">
    <title><?= e($title ?? 'Kelvora') ?> — Kelvora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('public/build/assets/style.css') ?>">
    <script>
        window.tailwind = window.tailwind || {}; tailwind.config = {
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
    <?php require __DIR__ . '/sidebar.php'; ?>

    <!-- Main Content -->
    <?php require __DIR__ . '/main.php'; ?>

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
