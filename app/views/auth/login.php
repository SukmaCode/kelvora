<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Masuk') ?> — Kelvora</title>
    <meta name="description" content="Masuk ke akun Kelvora Anda. Kelola bisnis UMKM lebih cepat dengan otomatisasi AI.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@800&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <link rel="stylesheet" href="<?= url('public/build/assets/style.css') ?>">
    <script>
        window.tailwind = window.tailwind || {}; tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2D3BD9',
                        brandBg: '#E0F2F4',
                        surface: '#FFFFFF',
                        brandText: '#0B1220',
                        secondary: '#5C6AE6',
                        accent: '#4FD1C5',
                    },
                    fontFamily: {
                        heading: ['Outfit', 'sans-serif'],
                        body: ['"Plus Jakarta Sans"', 'sans-serif'],
                    },
                    boxShadow: {
                        'soft': '0 4px 14px rgba(11,18,32,0.08)',
                    },
                    borderRadius: {
                        'xl': '12px',
                    }
                }
            }
        }
    </script>
    <style>
        body { font-family: 'Plus Jakarta Sans', sans-serif; font-weight: 500; }
        h1, h2, h3, h4, h5, h6 { font-family: 'Outfit', sans-serif; font-weight: 800; }
        .pwd-toggle { cursor: pointer; }
        .spinner {
            border: 3px solid rgba(255,255,255,0.3);
            border-radius: 50%;
            border-top: 3px solid #fff;
            width: 20px; height: 20px;
            animation: spin .8s linear infinite;
        }
        @keyframes spin { to { transform: rotate(360deg); } }
        @keyframes fadeUp {
            from { opacity: 0; transform: translateY(16px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        .fade-up { animation: fadeUp .5s ease-out both; }
    </style>
</head>
<body class="bg-gray-50 text-brandText antialiased">

<div class="flex w-full min-h-screen">

    <!-- ===================== LEFT: BRANDING ===================== -->
    <div class="hidden lg:flex lg:w-1/2 bg-brandBg flex-col justify-center items-center p-12 relative overflow-hidden select-none">
        <!-- Decoration elements from the template -->
        <div class="max-w-md w-full z-10">
            <!-- Logo -->
            <a href="<?= url('/') ?>" class="mb-6 flex items-center gap-3 group">
                <img src="<?= url('assets/images/logo-biru.png') ?>" alt="Logo" class="w-10 h-10">
                <span class="font-heading text-2xl tracking-tight">Kelvora</span>
            </a>

            <!-- Headline -->
            <h1 class="text-4xl lg:text-5xl font-heading leading-[1.12] mb-6">
                Ubah Chat Menjadi<br><span class="text-primary">Sales Otomatis.</span>
            </h1>

            <!-- Flow badges -->
            <div class="flex flex-wrap items-center gap-2 font-semibold mb-10 text-sm">
                <?php
                $flow = [
                    ['💬','Chat'],['🤖','Bot'],['📊','Dashboard'],['📦','Order']
                ];
                foreach ($flow as $i => $f): ?>
                    <?php if ($i > 0): ?>
                        <svg class="w-4 h-4 text-brandText/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M14 5l7 7m0 0l-7 7m7-7H3"/></svg>
                    <?php endif; ?>
                    <div class="flex items-center gap-2 bg-white/60 px-4 py-2 rounded-xl shadow-sm border border-white/50">
                        <span class="text-lg"><?= $f[0] ?></span> <?= $f[1] ?>
                    </div>
                <?php endforeach; ?>
            </div>

            <!-- Mini dashboard card -->
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-soft border border-white">
                <div class="flex items-center justify-between mb-5">
                    <h3 class="font-bold text-sm">Overview</h3>
                    <span class="flex items-center gap-1.5 text-xs font-bold px-2.5 py-1 bg-primary/10 text-primary rounded-full">
                        <span class="relative flex h-2 w-2">
                            <span class="animate-ping absolute inline-flex h-full w-full rounded-full bg-primary/60"></span>
                            <span class="relative inline-flex rounded-full h-2 w-2 bg-primary"></span>
                        </span>
                        Bot Active
                    </span>
                </div>
                <div class="grid grid-cols-3 gap-3">
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-1">Total Orders</p>
                        <p class="text-2xl font-heading text-brandText">1,208</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-1">Revenue</p>
                        <p class="text-2xl font-heading text-accent">Rp 8.5M</p>
                    </div>
                    <div class="bg-white rounded-xl p-4 shadow-sm border border-slate-100">
                        <p class="text-[10px] text-slate-500 font-bold uppercase tracking-wider mb-1">Bot Status</p>
                        <p class="text-2xl font-heading text-primary">Active</p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Decorative blobs -->
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- ===================== RIGHT: LOGIN FORM ===================== -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative overflow-y-auto">

        <!-- Mobile logo -->
        <a href="<?= url('/') ?>" class="absolute top-6 left-6 lg:hidden flex items-center gap-2">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center shadow-sm">
                <span class="text-white font-bold text-sm">⚡</span>
            </div>
            <span class="font-heading text-xl tracking-tight">Kelvora</span>
        </a>

        <div class="w-full max-w-sm bg-surface p-8 sm:p-10 rounded-xl shadow-soft fade-up mt-16 md:mt-0 lg:mb-0 mb-10 relative">

            <div id="alertBox" class="hidden absolute top-0 left-0 right-0 z-50 mx-8 mt-4 px-4 py-3 rounded-xl text-sm border font-semibold bg-red-50 border-red-200 text-red-600 shadow-soft">
                <span id="alertMsg"></span>
            </div>
            
            <div class="mb-8">
                <h2 class="text-2xl font-heading mb-2">Selamat Datang Kembali!</h2>
                <p class="text-sm text-slate-500 font-medium">Masuk untuk mengelola bisnis Anda.</p>
            </div>

            <!-- Flash message for logout/session expired if any -->
            <?php
                if (!empty($_SESSION['flash'])):
                    $flash = $_SESSION['flash'];
                    unset($_SESSION['flash']);
            ?>
            <div class="mb-6 px-4 py-3 rounded-xl text-sm border font-semibold bg-blue-50 border-blue-200 text-blue-600">
                <?= e($flash['message']) ?>
            </div>
            <?php endif; ?>

            <!-- RESEND OTP ACTION BOX -->
            <div id="unverifiedBox" class="hidden mb-6 px-4 py-4 rounded-xl text-sm border font-semibold bg-orange-50 border-orange-200 shadow-soft text-center">
                <p class="text-orange-700 mb-2">Akun ini belum diverifikasi. Cek Email untuk Kode OTP.</p>
                <div class="flex gap-2 justify-center">
                    <button type="button" onclick="window.location.href='<?= url('/auth/verify-email') ?>'" class="px-3 py-1.5 bg-orange-600 text-white rounded-lg hover:bg-orange-700 transition">Ke Halaman Verifikasi</button>
                    <button type="button" onclick="requestResend()" id="resendBtn" class="px-3 py-1.5 bg-white border border-orange-200 text-orange-600 rounded-lg hover:bg-orange-100 transition">Kirim Ulang</button>
                </div>
            </div>

            <form id="loginForm" onsubmit="event.preventDefault(); submitLogin();" class="space-y-5">
                <!-- CSRF Token -->
                <?= csrf_field() ?>

                <div class="space-y-1.5">
                    <label for="email" class="text-sm font-semibold">Alamat Email</label>
                    <input type="email" id="email" name="email" required autofocus
                           class="w-full h-[44px] px-4 bg-white border border-slate-200 rounded-xl text-brandText focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder-slate-400 font-medium"
                           placeholder="budi@email.com">
                </div>

                <div class="space-y-1.5">
                    <label for="password" class="text-sm font-semibold">Kata Sandi</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required
                               class="w-full h-[44px] pl-4 pr-11 bg-white border border-slate-200 rounded-xl text-brandText focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder-slate-400 font-medium"
                               placeholder="Masukkan sandi">
                        <button type="button" onclick="togglePwd('password', this)" class="pwd-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-brandText transition-colors" aria-label="Tampilkan sandi">
                            <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <div class="flex justify-end pt-1">
                    <a href="#" class="text-sm font-bold text-primary hover:text-secondary transition-colors">Lupa sandi?</a>
                </div>

                <button type="submit" id="btn-login"
                        class="w-full h-[44px] flex justify-center items-center gap-2 rounded-xl text-sm font-bold text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                    <span class="btn-label">Masuk</span>
                    <div class="spinner hidden"></div>
                </button>
            </form>

            <p class="mt-8 text-sm font-semibold text-slate-500 text-center">
                Belum punya akun?
                <a href="<?= url('/register') ?>" class="font-bold text-primary hover:text-secondary transition-colors ml-1">Daftar sekarang</a>
            </p>

        </div>

        <div class="absolute bottom-6 text-xs font-bold text-slate-400 hidden lg:block">
            &copy; <?= date('Y') ?> Kelvora. All rights reserved.
        </div>
    </div>
</div>

<script>
    const ACTION_URL = "<?= url() ?>";
    const CSRF_TOKEN = document.querySelector('input[name="csrf_token"]').value;

    function togglePwd(inputId, btn) {
        const input = document.getElementById(inputId);
        const isHidden = input.type === 'password';
        input.type = isHidden ? 'text' : 'password';
        btn.querySelector('.eye-open').classList.toggle('hidden', isHidden);
        btn.querySelector('.eye-closed').classList.toggle('hidden', !isHidden);
    }

    function showError(msg) {
        const box = document.getElementById('alertBox');
        document.getElementById('alertMsg').innerText = msg;
        box.classList.remove('hidden');
        setTimeout(() => box.classList.add('hidden'), 5000);
    }
    
    function setLoading(isLoading) {
        const btn = document.getElementById('btn-login');
        btn.disabled = isLoading;
        if (isLoading) {
            btn.querySelector('.btn-label').classList.add('hidden');
            btn.querySelector('.spinner').classList.remove('hidden');
        } else {
            btn.querySelector('.btn-label').classList.remove('hidden');
            btn.querySelector('.spinner').classList.add('hidden');
        }
    }

    async function submitLogin() {
        setLoading(true);
        document.getElementById('unverifiedBox').classList.add('hidden');
        
        const email = document.getElementById('email').value;
        const formData = new URLSearchParams();
        formData.append('csrf_token', CSRF_TOKEN);
        formData.append('email', email);
        formData.append('password', document.getElementById('password').value);

        try {
            const res = await fetch(`${ACTION_URL}/login`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });
            
            const data = await res.json();
            if (data.success) {
                window.location.href = data.redirect;
            } else {
                if (data.unverified) {
                    document.getElementById('unverifiedBox').classList.remove('hidden');
                } else {
                    showError(data.message);
                }
            }
        } catch (e) {
            showError("Terjadi kesalahan jaringan.");
        } finally {
            setLoading(false);
        }
    }

    async function requestResend() {
        const email = document.getElementById('email').value;
        const resendBtn = document.getElementById('resendBtn');
        resendBtn.disabled = true;
        resendBtn.innerText = 'Mengirim...';

        const formData = new URLSearchParams();
        formData.append('csrf_token', CSRF_TOKEN);
        formData.append('email', email);

        try {
            const res = await fetch(`${ACTION_URL}/auth/resend-otp`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });
            
            const data = await res.json();
            if (data.success) {
                alert("Kode OTP berhasil dikirim ulang ke Email Anda. Segera periksa dan lakukan verifikasi.");
                window.location.href = '<?= url('/auth/verify-email') ?>';
            } else {
                alert(data.message);
            }
        } catch (e) {
            alert("Kesalahan jaringan.");
        } finally {
            resendBtn.disabled = false;
            resendBtn.innerText = 'Kirim Ulang';
        }
    }
</script>
</body>
</html>
