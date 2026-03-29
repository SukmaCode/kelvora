<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Daftar') ?> — Kelvora</title>
    <meta name="description" content="Mulai gabung dengan Kelvora dan jadikan UMKM Anda otomatis dalam hitungan menit.">
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@800&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS CDN -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
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
        /* Error state logic handled dynamically by JS now */
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
                Automasi Bisnis<br><span class="text-primary">Mulai Di Sini.</span>
            </h1>

            <!-- Social proof -->
            <div class="flex items-center gap-4 mb-10">
                <div class="flex -space-x-3">
                    <img src="https://i.pravatar.cc/100?img=1" alt="User" class="w-10 h-10 rounded-full border-2 border-brandBg object-cover">
                    <img src="https://i.pravatar.cc/100?img=2" alt="User" class="w-10 h-10 rounded-full border-2 border-brandBg object-cover">
                    <img src="https://i.pravatar.cc/100?img=3" alt="User" class="w-10 h-10 rounded-full border-2 border-brandBg object-cover">
                </div>
                <div class="text-sm">
                    <p class="font-bold">1,000+ UMKM</p>
                    <p class="text-brandText/70">Telah bergabung bulan ini</p>
                </div>
            </div>
            
            <div class="bg-white/80 backdrop-blur-xl rounded-2xl p-6 shadow-soft border border-white">
                <h3 class="font-bold text-sm mb-4">Fitur Utama Anda:</h3>
                <ul class="space-y-3 text-sm font-semibold text-slate-600">
                    <li class="flex items-center gap-3"><div class="bg-primary/10 text-primary p-1 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>Bot WhatsApp Anti-Telat</li>
                    <li class="flex items-center gap-3"><div class="bg-primary/10 text-primary p-1 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>Dashboard Ringkasan Omzet</li>
                    <li class="flex items-center gap-3"><div class="bg-primary/10 text-primary p-1 rounded-md"><svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M5 13l4 4L19 7"/></svg></div>Autentikasi Aman dengan Email</li>
                </ul>
            </div>
        </div>
        <!-- Decorative blobs -->
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-accent/10 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- ===================== RIGHT: REGISTER FORM ===================== -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative overflow-y-auto">

        <!-- Mobile logo -->
        <a href="<?= url('/') ?>" class="absolute top-6 left-6 lg:hidden flex items-center gap-2">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center shadow-sm">
                <span class="text-white font-bold text-sm">⚡</span>
            </div>
            <span class="font-heading text-xl tracking-tight">Kelvora</span>
        </a>

        <div class="w-full max-w-lg bg-surface p-8 sm:p-10 rounded-xl shadow-soft fade-up mt-16 md:mt-0 lg:mb-0 mb-10 relative">

            <div id="alertBox" class="hidden absolute top-0 left-0 right-0 z-50 mx-8 mt-4 px-4 py-3 rounded-xl text-sm border font-semibold bg-red-50 border-red-200 text-red-600 shadow-soft">
                <span id="alertMsg"></span>
            </div>
            
            <div class="mb-8">
                <h2 id="registerTitle" class="text-2xl font-heading mb-2">Buat Akun Baru</h2>
                <p id="registerSubtitle" class="text-sm text-slate-500 font-medium">Lengkapi data Anda untuk memulai.</p>
            </div>

            <form id="registerForm" onsubmit="event.preventDefault(); submitRegister();" class="space-y-5">
                <!-- CSRF Token -->
                <?= csrf_field() ?>
                <input type="hidden" id="role" name="role" value="owner">

                <!-- Row 1: Nama Bisnis & Nama Lengkap -->
                <div id="name_row_container" class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div id="business_name_container" class="space-y-1.5">
                        <label for="business_name" class="text-sm font-semibold">Nama Bisnis</label>
                        <input type="text" id="business_name" name="business_name" required
                               class="w-full h-[44px] px-4 bg-white border border-slate-200 rounded-xl text-brandText focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder-slate-400 font-medium"
                               placeholder="Toko Makmur">
                    </div>
                    <div id="name_container" class="space-y-1.5">
                        <label for="name" class="text-sm font-semibold">Nama Lengkap</label>
                        <input type="text" id="name" name="name" required
                               class="w-full h-[44px] px-4 bg-white border border-slate-200 rounded-xl text-brandText focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder-slate-400 font-medium"
                               placeholder="Budi Raharjo">
                    </div>
                </div>

                <!-- Row 2: Email and Phone -->
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-5">
                    <div class="space-y-1.5">
                        <label for="email" class="text-sm font-semibold">Alamat Email Aktif</label>
                        <input type="email" id="email" name="email" required
                               class="w-full h-[44px] px-4 bg-white border border-slate-200 rounded-xl text-brandText focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder-slate-400 font-medium"
                               placeholder="budi@email.com">
                    </div>
                    <div class="space-y-1.5">
                        <label for="phone" class="text-sm font-semibold">Nomor HP (Unik)</label>
                        <input type="tel" id="phone" name="phone" required
                               class="w-full h-[44px] px-4 bg-white border border-slate-200 rounded-xl text-brandText focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder-slate-400 font-medium"
                               placeholder="08123456789">
                    </div>
                </div>

                <!-- Row 3: Password -->
                <div class="space-y-1.5">
                    <label for="password" class="text-sm font-semibold">Kata Sandi (Min. 8 Karakter)</label>
                    <div class="relative">
                        <input type="password" id="password" name="password" required minlength="8"
                               class="w-full h-[44px] pl-4 pr-11 bg-white border border-slate-200 rounded-xl text-brandText focus:outline-none focus:ring-2 focus:ring-primary/20 focus:border-primary transition-all placeholder-slate-400 font-medium"
                               placeholder="Buat sandi yang kuat">
                        <button type="button" onclick="togglePwd('password', this)" class="pwd-toggle absolute inset-y-0 right-0 pr-3 flex items-center text-slate-400 hover:text-brandText transition-colors" aria-label="Tampilkan sandi">
                            <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                            <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                        </button>
                    </div>
                </div>

                <!-- Terms Clause -->
                <div class="pt-2">
                    <p class="text-xs text-slate-500 font-medium leading-relaxed">
                        Dengan mendaftar, Anda menyetujui
                        <a href="<?= url('/terms-conditions') ?>" class="font-bold text-primary hover:text-secondary">Syarat Ketentuan</a> dan
                        <a href="<?= url('/policy-privacy') ?>" class="font-bold text-primary hover:text-secondary">Kebijakan Privasi</a> kami.
                    </p>
                </div>

                <button type="submit" id="btn-register"
                        class="w-full h-[44px] flex justify-center items-center gap-2 rounded-xl text-sm font-bold text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all disabled:opacity-70 disabled:cursor-not-allowed">
                    <span class="btn-label">Buat Akun Sekarang</span>
                    <div class="spinner hidden"></div>
                </button>
            </form>

            <p class="mt-8 text-sm font-semibold text-slate-500 text-center">
                Sudah punya akun?
                <a href="<?= url('/login') ?>" class="font-bold text-primary hover:text-secondary transition-colors ml-1">Masuk di sini</a>
            </p>

        </div>

        <div class="absolute bottom-6 text-xs font-bold text-slate-400 hidden lg:block">
            &copy; <?= date('Y') ?> Kelvora. All rights reserved.
        </div>
    </div>
</div>

<!-- Modal Role Selection -->
<div id="roleModal" class="fixed inset-0 z-[100] flex items-center justify-center bg-black/50 backdrop-blur-sm transition-opacity duration-300">
    <div class="bg-white rounded-2xl w-full max-w-md p-8 shadow-floating mx-4">
        <h3 class="text-2xl font-heading mb-2 text-center text-brandText">Pilih Jenis Akun</h3>
        <p class="text-sm text-slate-500 text-center mb-6">Pilih peran Anda untuk melanjutkan pendaftaran.</p>
        
        <div class="space-y-4">
            <!-- Option: Owner -->
            <button onclick="selectRole('owner')" class="w-full flex items-center gap-4 p-4 border border-slate-200 rounded-xl hover:border-primary focus:border-primary hover:bg-primary/5 transition-all text-left group focus:outline-none focus:ring-2 focus:ring-primary/20">
                <div class="w-12 h-12 rounded-full bg-primary/10 flex items-center justify-center text-xl text-primary group-hover:scale-110 transition-transform">🏪</div>
                <div>
                    <div class="font-bold text-brandText">Owner Bisnis</div>
                    <div class="text-xs text-slate-500">Buat toko online dan automasi penjualan.</div>
                </div>
            </button>
            
            <!-- Option: Customer -->
            <button onclick="selectRole('customer')" class="w-full flex items-center gap-4 p-4 border border-slate-200 rounded-xl hover:border-secondary focus:border-secondary hover:bg-secondary/5 transition-all text-left group focus:outline-none focus:ring-2 focus:ring-secondary/20">
                <div class="w-12 h-12 rounded-full bg-secondary/10 flex items-center justify-center text-xl text-secondary group-hover:scale-110 transition-transform">🛍️</div>
                <div>
                    <div class="font-bold text-brandText">Customer</div>
                    <div class="text-xs text-slate-500">Beli produk dan lacak pesanan.</div>
                </div>
            </button>
        </div>
        <div class="mt-6 text-center">
            <a href="<?= url('/') ?>" class="text-sm font-bold text-slate-400 hover:text-primary transition-colors">Batal & Kembali ke Beranda</a>
        </div>
    </div>
</div>

<script>
    const ACTION_URL = "<?= url() ?>";
    const CSRF_TOKEN = document.querySelector('input[name="csrf_token"]').value;

    function selectRole(role) {
        document.getElementById('role').value = role;
        document.getElementById('roleModal').classList.add('hidden');
        
        const businessNameContainer = document.getElementById('business_name_container');
        const nameRowContainer = document.getElementById('name_row_container');
        const businessNameInput = document.getElementById('business_name');
        
        if (role === 'customer') {
            businessNameContainer.classList.add('hidden');
            nameRowContainer.classList.remove('sm:grid-cols-2');
            businessNameInput.required = false;
            businessNameInput.value = ''; 
            
            document.getElementById('registerTitle').innerText = 'Daftar sebagai Customer';
            document.getElementById('registerSubtitle').innerText = 'Lengkapi data pembeli Anda.';
        } else {
            businessNameContainer.classList.remove('hidden');
            nameRowContainer.classList.add('sm:grid-cols-2');
            businessNameInput.required = true;
            
            document.getElementById('registerTitle').innerText = 'Daftar sebagai Owner';
            document.getElementById('registerSubtitle').innerText = 'Mulai kelola bisnis Anda.';
        }
    }

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
        const btn = document.getElementById('btn-register');
        btn.disabled = isLoading;
        if (isLoading) {
            btn.querySelector('.btn-label').classList.add('hidden');
            btn.querySelector('.spinner').classList.remove('hidden');
        } else {
            btn.querySelector('.btn-label').classList.remove('hidden');
            btn.querySelector('.spinner').classList.add('hidden');
        }
    }

    async function submitRegister() {
        setLoading(true);
        
        const formData = new URLSearchParams();
        formData.append('csrf_token', CSRF_TOKEN);
        formData.append('role', document.getElementById('role').value);
        formData.append('business_name', document.getElementById('business_name').value);
        formData.append('name', document.getElementById('name').value);
        formData.append('email', document.getElementById('email').value);
        formData.append('phone', document.getElementById('phone').value);
        formData.append('password', document.getElementById('password').value);

        try {
            const res = await fetch(`${ACTION_URL}/register`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });
            const contentType = res.headers.get('content-type');
            if (!contentType || !contentType.includes('application/json')) {
                const rawText = await res.text(); // ← Ambil isi response mentah
                console.error('Raw response:', rawText); // ← Lihat di browser Console (F12)
                showError(`Server error (${res.status}). Silakan refresh halaman dan coba lagi.`);
                return;
            }   
            const data = await res.json();
            if (data.success) {
                // Redirect ke OTP verifikasi
                window.location.href = data.redirect;
            } else {
                showError(data.message);
            }
        } catch (e) {
            showError("Terjadi kesalahan jaringan.");
        } finally {
            setLoading(false);
        }
    }
</script>
</body>
</html>
