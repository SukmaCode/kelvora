<!DOCTYPE html>
<html lang="en" class="h-full bg-[#0B0F19]">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Login') ?> — Kelvora</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <script src="https://cdn.jsdelivr.net/npm/@tailwindcss/browser@4"></script>
    <!-- Tailwind CSS -->
    <link rel="stylesheet" href="<?= asset('css/index.css') ?>">
</head>
<body class="font-sans antialiased text-slate-300 h-full flex items-center justify-center p-4">

    <div class="w-full max-w-md bg-[#131B2C] border border-border rounded-xl shadow-[0_8px_32px_rgba(0,0,0,0.5)] overflow-hidden">
        <div class="px-6 py-8 sm:p-10">
            <div class="text-center mb-8">
                <div class="inline-flex items-center justify-center w-12 h-12 bg-accent rounded-lg mb-4">
                    <span class="text-white text-2xl">⚡</span>
                </div>
                <h1 class="text-2xl font-bold text-white tracking-tight">Welcome back</h1>
                <p class="text-sm text-slate-400 mt-2">Sign in to your Kelvora account to continue.</p>
            </div>

            <!-- Flash Error -->
            <?php 
                // We use custom flash handling here since flash_message() uses a specific padding/margin
                $flash = $_SESSION['flash'] ?? null;
                unset($_SESSION['flash']);
                if ($flash):
                    $type = e($flash['type']);
                    $message = e($flash['message']);
                    $colorClasses = match($type) {
                        'success' => 'bg-green-500/10 border-green-500/25 text-green-400',
                        'danger'  => 'bg-red-500/10 border-red-500/25 text-red-400',
                        default   => 'bg-cyan-500/10 border-cyan-500/25 text-cyan-400',
                    };
            ?>
                <div class="mb-6 px-4 py-3 rounded-md text-sm border <?= $colorClasses ?>">
                    <?= $message ?>
                </div>
            <?php endif; ?>

            <form action="<?= url('/login') ?>" method="POST" class="space-y-6">
                <?= csrf_field() ?>

                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email Address</label>
                    <input type="email" id="email" name="email" value="<?= old('email') ?>" required autofocus
                           class="w-full px-4 py-3 bg-[#0B0F19] border border-border rounded-md text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500" 
                           placeholder="admin@kelvora.com">
                </div>

                <div>
                    <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password</label>
                    <input type="password" id="password" name="password" required
                           class="w-full px-4 py-3 bg-[#0B0F19] border border-border rounded-md text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500" 
                           placeholder="••••••••">
                </div>

                <button type="submit" 
                        class="w-full flex justify-center py-3 px-4 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-accent hover:bg-accent-hover focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-[#131B2C] focus:ring-accent transition-all">
                    Sign in
                </button>
            </form>
            
            <div class="mt-6 text-center">
                <p class="text-sm text-slate-400">
                    Don't have an account? <a href="#" class="font-medium text-accent hover:text-accent-hover">Contact Sales</a>
                </p>
            </div>
        </div>
    </div>

</body>
</html>
