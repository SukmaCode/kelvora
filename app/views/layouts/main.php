<?php
// Main Content
?>
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
