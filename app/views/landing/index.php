<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Kelvora - Ubah Chat Menjadi Otomatis Closing dengan AI</title>
    
    <!-- Google Fonts -->
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link rel="preconnect" href="https://fonts.gstatic.com" crossorigin>
    <link href="https://fonts.googleapis.com/css2?family=Outfit:wght@800&family=Plus+Jakarta+Sans:wght@500;600;700&display=swap" rel="stylesheet">
    
    <!-- Tailwind CSS -->
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    colors: {
                        primary: '#2D3BD9',
                        bgnav: '#E0F2F4', 
                        bgColor: '#E0F2F4',
                        surface: '#FFFFFF',
                        txtmain: '#0B1220',
                        secondary: '#5C6AE6',
                        accent: '#4FD1C5'
                    },
                    fontFamily: {
                        heading: ['Outfit', 'sans-serif'],
                        body: ['"Plus Jakarta Sans"', 'sans-serif']
                    },
                    boxShadow: {
                        'soft': '0 4px 14px rgba(11, 18, 32, 0.08)',
                        'floating': '0 12px 32px rgba(11, 18, 32, 0.12)'
                    },
                    borderRadius: {
                        'xl': '12px'
                    }
                }
            }
        }
    </script>
    <style>
        body {
            background-color: #E0F2F4;
            color: #0B1220;
            font-family: 'Plus Jakarta Sans', sans-serif;
            font-weight: 500;
            line-height: 1.5;
        }
        h1, h2, h3, h4, h5, h6 {
            font-family: 'Outfit', sans-serif;
            font-weight: 800;
            letter-spacing: -0.02em;
        }
        .container-custom {
            max-width: 1200px;
            margin: 0 auto;
            padding-left: 24px;
            padding-right: 24px;
        }
        /* Hide scrollbar for step flow */
        .hide-scrollbar::-webkit-scrollbar {
            display: none;
        }
        .hide-scrollbar {
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        @keyframes fadeDown {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
        @keyframes fadeDownMobile {
            from { opacity: 0; transform: translateY(-8px); }
            to   { opacity: 1; transform: translateY(0); }
        }
    </style>
</head>
<body class="antialiased selection:bg-primary selection:text-white">

    <!-- 1. NAVIGATION BAR -->
    <nav class="sticky top-0 z-50 bg-[#E0F2F4]/80 backdrop-blur-lg border-b border-[#2D3BD9]/10">
        <div class="container-custom flex items-center justify-between h-[72px]">
            <a href="#" class="flex items-center justify-center gap-3">
                <img src="<?= url('public/assets/images/logo-biru.png') ?>" alt="Logo" class="w-8 h-8">
                <span class="font-heading text-2xl text-txtmain tracking-tight mt-1">Kelvora</span>
            </a>
            <!-- Navbar Desktop -->
            <div class="hidden md:flex items-center gap-8 text-[14px] font-semibold uppercase text-txtmain/70">
                <?php if (($_SESSION['user_role'] ?? '') !== 'customer'): ?>
                <a href="#fitur" class="hover:text-primary transition-colors">Fitur</a>
                <a href="#cara-kerja" class="hover:text-primary transition-colors">Cara Kerja</a>
                <a href="#harga" class="hover:text-primary transition-colors">Harga</a>
                <?php endif; ?>
            </div>
            <!-- Navbar Mobile -->
            <div id="navbarMobile" class="hidden md:hidden absolute z-1 w-full right-0 top-0 p-8 bg-[#E0F2F4] backdrop-blur-lg flex flex-col gap-6 text-[14px] font-semibold uppercase text-txtmain/70" style="animation: fadeDownMobile .2s ease">
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <?php
                        $displayName = $_SESSION['name'] ?? $_SESSION['business_name'] ?? 'U';
                        $nameParts = explode(' ', trim($displayName));
                        $initials = strtoupper(substr($nameParts[0], 0, 1));
                        if (count($nameParts) > 1) {
                            $initials .= strtoupper(substr(end($nameParts), 0, 1));
                        }
                    ?>
                    <?php if (($_SESSION['user_role'] ?? '') !== 'customer'): ?>
                    <a href="#fitur" class="hover:text-primary transition-colors">Fitur</a>
                    <a href="#cara-kerja" class="hover:text-primary transition-colors">Cara Kerja</a>
                    <a href="#harga" class="hover:text-primary transition-colors">Harga</a>
                    <?php endif; ?>
                    <!-- Profile Menu -->
                    <button onclick="toggleProfileMenu()" class="w-10 h-10 rounded-full bg-primary text-white font-bold text-sm flex items-center justify-center shadow-soft hover:bg-secondary transition-all focus:outline-none focus:ring-2 focus:ring-primary/30 focus:ring-offset-2 focus:ring-offset-[#E0F2F4] overflow-hidden bg-cover bg-center" aria-label="Menu profil">
                        <?php if (!empty($_SESSION['profile_image'])): ?>
                            <img src="<?= url('public/uploads/profile/' . $_SESSION['profile_image']) ?>" alt="Profile" class="w-full h-full object-cover">
                        <?php else: ?>
                            <?= e($initials) ?>
                        <?php endif; ?>
                    </button>

                <?php else: ?>
                    <a href="<?= url('login') ?>" class=" font-bold text-[15px] text-txtmain hover:text-primary transition-colors">Masuk</a>
                    <a href="<?= url('register') ?>" class="inline-flex items-center justify-center h-[44px] px-6 bg-primary text-white font-bold text-[15px] rounded-xl hover:bg-secondary transition-all shadow-soft hover:-translate-y-0.5">Daftar Sekarang</a>
                <?php endif; ?>
            </div>
            <div class="flex items-center gap-4">
                <?php if (!empty($_SESSION['user_id'])): ?>
                    <?php
                        $displayName = $_SESSION['name'] ?? $_SESSION['business_name'] ?? 'U';
                        $nameParts = explode(' ', trim($displayName));
                        $initials = strtoupper(substr($nameParts[0], 0, 1));
                        if (count($nameParts) > 1) {
                            $initials .= strtoupper(substr(end($nameParts), 0, 1));
                        }
                    ?>
                    <div class="relative" id="profileDropdown">
                        <div class="flex justify-center items-center gap-4">
                            <!-- Profile User Desktop -->
                            <button onclick="toggleProfileMenu()" class="hidden md:flex w-10 h-10 rounded-full bg-primary text-white font-bold text-sm flex items-center justify-center shadow-soft hover:bg-secondary transition-all focus:outline-none focus:ring-2 focus:ring-primary/30 focus:ring-offset-2 focus:ring-offset-[#E0F2F4] overflow-hidden bg-cover bg-center" aria-label="Menu profil">
                                <?php if (!empty($_SESSION['profile_image'])): ?>
                                    <img src="<?= url('public/uploads/profile/' . $_SESSION['profile_image']) ?>" alt="Profile" class="w-full h-full object-cover">
                                <?php else: ?>
                                    <?= e($initials) ?>
                                <?php endif; ?>
                            </button>
                            <!-- Hamburger Bar -->
                            <button class="flex flex-col gap-1 p-2 md:hidden" onclick="toggleNavbarMobile()">
                                <span class="w-4 h-0.5 bg-black"></span>
                                <span class="w-4 h-0.5 bg-black"></span>
                                <span class="w-4 h-0.5 bg-black"></span>
                            </button>
                        </div>
                        <!-- Modal/Overlay Profile -->
                        <div id="profileMenu" class="hidden absolute right-0 mt-3 w-64 bg-surface rounded-xl shadow-floating border border-txtmain/5 overflow-hidden z-50" style="animation: fadeDown .2s ease">
                            <div class="px-5 py-4 border-b border-txtmain/5">
                                <div class="flex items-center gap-3">
                                    <div class="w-10 h-10 rounded-full bg-primary text-white font-bold text-sm flex items-center justify-center flex-shrink-0 overflow-hidden bg-cover bg-center">
                                        <?php if (!empty($_SESSION['profile_image'])): ?>
                                            <img src="<?= url('public/uploads/profile/' . $_SESSION['profile_image']) ?>" alt="Profile" class="w-full h-full object-cover">
                                        <?php else: ?>
                                            <?= e($initials) ?>
                                        <?php endif; ?>
                                    </div>
                                    <div class="min-w-0">
                                        
                                        <p class="font-bold text-sm text-txtmain truncate"><?= e($displayName) ?></p>
                                        <p class="text-xs text-txtmain/50 truncate"><?= e($_SESSION['business_name'] ?? '') ?></p>
                                    </div>
                                </div>
                            </div>
                            <div class="py-2">
                                <?php if (($_SESSION['user_role'] ?? '') !== 'customer'): ?>
                                <a href="<?= url('home') ?>" class="flex items-center gap-3 px-5 py-2.5 text-sm font-semibold text-txtmain/70 hover:bg-brandBg hover:text-primary transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2V6zM14 6a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2V6zM4 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2H6a2 2 0 01-2-2v-2zM14 16a2 2 0 012-2h2a2 2 0 012 2v2a2 2 0 01-2 2h-2a2 2 0 01-2-2v-2z"/></svg>
                                    Dashboard
                                </a>
                                <?php endif; ?>
                                
                                <a href="<?= url('profile') ?>" class="flex items-center gap-3 px-5 py-2.5 text-sm font-semibold text-txtmain/70 hover:bg-brandBg hover:text-primary transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/></svg>
                                    Edit Profil
                                </a>
                            </div>
                            <div class="border-t border-txtmain/5 py-2">
                                <a href="<?= url('logout') ?>" class="flex items-center gap-3 px-5 py-2.5 text-sm font-semibold text-red-500 hover:bg-red-50 transition-colors">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1"/></svg>
                                    Keluar
                                </a>
                            </div>
                        </div>
                    </div>
                <?php else: ?>
                    <a href="<?= url('login') ?>" class="hidden md:block font-bold text-[15px] text-txtmain hover:text-primary transition-colors">Masuk</a>
                    <a href="<?= url('register') ?>" class="inline-flex items-center justify-center h-[44px] px-6 bg-primary text-white font-bold text-[15px] rounded-xl hover:bg-secondary transition-all shadow-soft hover:-translate-y-0.5">Daftar Sekarang</a>
                <?php endif; ?>
            </div>
        </div>
    </nav>

    <?php if (($_SESSION['user_role'] ?? '') === 'customer'): ?>
        <?php require BASE_PATH . '/app/views/landing/storefront.php'; ?>
    <?php else: ?>

    <!-- 1. HERO SECTION -->
    <section class="pt-20 pb-24 overflow-hidden relative">
        <div class="container-custom">
            <div class="grid grid-cols-1 lg:grid-cols-12 gap-6 items-center">
                <!-- Text Content -->
                <div class="lg:col-span-5 relative z-10">
                    <div class="inline-flex items-center gap-2 px-3 py-1.5 bg-accent/20 text-[#0f766e] rounded-full text-sm font-semibold mb-6">
                        <span class="w-2 h-2 bg-accent rounded-full animate-pulse"></span>
                        AI-Powered SaaS untuk UMKM
                    </div>
                    <h1 class="text-[40px] md:text-[52px] lg:text-[64px] leading-[1.1] text-txtmain mb-6">
                        Ubah Chat Menjadi <span class="text-primary">Sales Otomatis.</span>
                    </h1>
                    <p class="text-[16px] md:text-[18px] text-txtmain/80 mb-8 max-w-lg">
                        Berhenti membalas pesan satu per satu. Sistem cerdas Kelvora mengotomatisasi WhatsApp & Instagram Anda, menangkap order masuk, hingga dikelola dalam satu dashboard terstruktur dengan AI.
                    </p>
                    <div class="flex flex-col sm:flex-row items-start gap-4">
                        <a href="<?= url('register') ?>" class="inline-flex items-center justify-center h-[52px] px-8 bg-primary text-white font-bold text-[16px] rounded-xl hover:bg-secondary transition-all shadow-soft hover:-translate-y-1 w-full sm:w-auto">
                            Daftar Sekarang
                        </a>
                        <a href="#cara-kerja" class="inline-flex items-center justify-center h-[52px] px-8 bg-surface text-txtmain font-bold text-[16px] rounded-xl hover:bg-white transition-all shadow-soft w-full sm:w-auto">
                            Lihat Cara Kerja
                        </a>
                    </div>
                    <div class="mt-8 flex items-center gap-4 text-sm font-semibold text-txtmain/70 uppercase">
                        <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Setup 5 Menit</span>
                        <span class="flex items-center gap-1.5"><svg class="w-4 h-4 text-accent" fill="currentColor" viewBox="0 0 20 20"><path fill-rule="evenodd" d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.707-9.293a1 1 0 00-1.414-1.414L9 10.586 7.707 9.293a1 1 0 00-1.414 1.414l2 2a1 1 0 001.414 0l4-4z" clip-rule="evenodd"></path></svg> Tanpa Kartu Kredit</span>
                    </div>
                </div>

                <!-- Visual Content -->
                <div class="lg:col-span-7 relative mt-16 lg:mt-0">
                    <!-- Dashboard Mockup -->
                    <div class="bg-surface rounded-[20px] p-2 shadow-floating relative z-10 border border-txtmain/5">
                        <div class="bg-[#F8FAFC] rounded-xl overflow-hidden border border-[#E2E8F0]">
                            <!-- Dashboard Header -->
                            <div class="border-b border-[#E2E8F0] px-4 py-3 flex justify-between items-center bg-white">
                                <div class="flex gap-2">
                                    <div class="w-3 h-3 rounded-full bg-red-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-amber-400"></div>
                                    <div class="w-3 h-3 rounded-full bg-green-400"></div>
                                </div>
                                <div class="font-bold text-sm">Overview</div>
                                <div></div>
                            </div>
                            <!-- Dashboard Body -->
                            <div class="p-4 grid grid-cols-3 gap-4">
                                <!-- Cards -->
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-[#E2E8F0]">
                                    <div class="text-[12px] uppercase font-semibold text-txtmain/50 mb-1">Total Orders</div>
                                    <div class="text-2xl font-bold font-heading">1,208</div>
                                </div>
                                <div class="bg-white p-4 rounded-xl shadow-sm border border-[#E2E8F0]">
                                    <div class="text-[12px] uppercase font-semibold text-txtmain/50 mb-1">Today's Revenue</div>
                                    <div class="text-2xl font-bold font-heading text-accent">Rp 8.5M</div>
                                </div>
                                <div class="bg-primary text-white p-4 rounded-xl shadow-sm relative overflow-hidden">
                                    <div class="text-[12px] uppercase font-semibold text-white/70 mb-1 relative z-10">AI Auto Reply</div>
                                    <div class="text-2xl font-bold font-heading relative z-10">Active</div>
                                    <div class="absolute right-[-10px] bottom-[-10px] text-5xl opacity-20">🤖</div>
                                </div>
                            </div>
                            <!-- Graph area -->
                            <div class="p-4 pt-0">
                                <div class="bg-white h-40 rounded-xl shadow-sm border border-[#E2E8F0] p-4 flex items-end justify-between gap-2">
                                    <div class="w-full bg-primary/20 rounded-t-sm" style="height: 40%"></div>
                                    <div class="w-full bg-primary/30 rounded-t-sm" style="height: 60%"></div>
                                    <div class="w-full bg-primary/40 rounded-t-sm" style="height: 50%"></div>
                                    <div class="w-full bg-primary/60 rounded-t-sm" style="height: 80%"></div>
                                    <div class="w-full bg-primary/80 rounded-t-sm" style="height: 70%"></div>
                                    <div class="w-full bg-primary rounded-t-sm" style="height: 100%"></div>
                                </div>
                            </div>
                        </div>
                    </div>

                    <!-- Flow Floating Element (Chat to Order) -->
                    <div class="absolute -left-10 md:-left-20 bottom-10 bg-surface p-4 rounded-xl shadow-floating z-20 border border-txtmain/5 flex items-center gap-3 animate-bounce" style="animation-duration: 3s;">
                        <div class="w-10 h-10 bg-[#25D366] rounded-full flex items-center justify-center text-white text-xl">💬</div>
                        <svg class="w-5 h-5 text-txtmain/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        <div class="w-10 h-10 bg-accent rounded-full flex items-center justify-center text-white text-xl">🤖</div>
                        <svg class="w-5 h-5 text-txtmain/30" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                        <div class="w-10 h-10 bg-primary rounded-full flex items-center justify-center text-white text-xl">🛒</div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 2. PROBLEM -> SOLUTION SECTION -->
    <section class="py-24 bg-surface relative" id="masalah">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-3xl md:text-4xl lg:text-[40px] text-txtmain max-w-2xl mx-auto">Kami mengerti rasa frustrasi Anda mengurus pesanan harian.</h2>
            </div>
            
            <div class="grid grid-cols-1 md:grid-cols-2 gap-6 lg:gap-8 max-w-5xl mx-auto">
                <!-- Problems -->
                <div class="bg-[#F8EAEB] rounded-xl p-8 border border-[#F4B4B9]/30">
                    <div class="inline-flex items-center gap-2 text-sm font-semibold uppercase text-[#E03131] tracking-wider mb-6">
                        <span class="w-8 h-8 rounded-full bg-[#E03131]/10 flex items-center justify-center text-lg">❌</span> Cara Lama (Tanpa Sistem)
                    </div>
                    <ul class="space-y-5">
                        <li class="flex items-start gap-4">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#E03131] mt-2.5"></div>
                            <div>
                                <h4 class="font-bold text-txtmain text-lg">Balas Chat Manual & Lambat</h4>
                                <p class="text-txtmain/60 text-sm mt-1">Buang waktu berjam-jam cuma buat jawab "Ready gan?" atau menghitung ongkir.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#E03131] mt-2.5"></div>
                            <div>
                                <h4 class="font-bold text-txtmain text-lg">Order Berantakan</h4>
                                <p class="text-txtmain/60 text-sm mt-1">Data pelanggan dan pesanan cuma numpuk di chat form, rawan salah kirim/hilang.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-1.5 h-1.5 rounded-full bg-[#E03131] mt-2.5"></div>
                            <div>
                                <h4 class="font-bold text-txtmain text-lg">Pusing Bikin Konten Marketing</h4>
                                <p class="text-txtmain/60 text-sm mt-1">Harus mikir keras bikin caption, deskripsi produk, atau poster promosi dari nol setiap hari.</p>
                            </div>
                        </li>
                    </ul>
                </div>

                <!-- Solutions -->
                <div class="bg-primary/5 rounded-xl p-8 border border-primary/20 relative overflow-hidden">
                    <div class="absolute -right-10 -top-10 w-40 h-40 bg-accent/20 rounded-full blur-[40px]"></div>
                    <div class="inline-flex items-center gap-2 text-sm font-semibold uppercase text-primary tracking-wider mb-6 relative">
                        <span class="w-8 h-8 rounded-full bg-primary/10 flex items-center justify-center text-lg">✅</span> Cara Baru dengan Kelvora
                    </div>
                    <ul class="space-y-5 relative">
                        <li class="flex items-start gap-4">
                            <div class="w-1.5 h-1.5 rounded-full bg-primary mt-2.5"></div>
                            <div>
                                <h4 class="font-bold text-txtmain text-lg">Smart AI Bot WA & IG</h4>
                                <p class="text-txtmain/60 text-sm mt-1">Sistem merespon otomatis siang/malam seolah admin manusia sungguhan menangani pelanggan.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-1.5 h-1.5 rounded-full bg-primary mt-2.5"></div>
                            <div>
                                <h4 class="font-bold text-txtmain text-lg">Order Masuk Dashboard Rapi</h4>
                                <p class="text-txtmain/60 text-sm mt-1">Chat closing langsung tertangkap jadi Invoice di sistem. Data terstruktur dan 100% aman.</p>
                            </div>
                        </li>
                        <li class="flex items-start gap-4">
                            <div class="w-1.5 h-1.5 rounded-full bg-primary mt-2.5"></div>
                            <div>
                                <h4 class="font-bold text-txtmain text-lg">AI Content Generator</h4>
                                <p class="text-txtmain/60 text-sm mt-1">Satu klik untuk generate caption, deskripsi katalog, dan ide promo menggunakan kecerdasan AI.</p>
                            </div>
                        </li>
                    </ul>
                </div>
            </div>
        </div>
    </section>

    <!-- 3. CARA KERJA (STEP FLOW VISUAL) -->
    <section class="py-24 bg-bgnav" id="cara-kerja">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-[32px] md:text-[40px] text-txtmain mb-4">Gampang Banget Pakainya.</h2>
                <p class="text-txtmain/70 text-lg max-w-2xl mx-auto">Mulai melipatgandakan sales otomatis Anda hari ini dalam 11 langkah praktis. Setup sekali, panen seterusnya.</p>
            </div>

            <!-- Horizontal Scroll Flow -->
            <div class="flex overflow-x-auto hide-scrollbar gap-6 pb-8 snap-x" style="scroll-snap-type: x mandatory;">
                
                <!-- Step Cards Generator -->
                <?php 
                $steps = [
                    ['icon' => '🚀', 'title' => 'Klik Daftar Sekarang', 'desc' => 'Mulai buat akun kelvora Anda gratis.'],
                    ['icon' => '📝', 'title' => 'Isi Form Bisnis', 'desc' => 'Lengkapi profil UMKM Anda.'],
                    ['icon' => '📦', 'title' => 'Pilih Paket', 'desc' => 'Tentukan layanan AI sesuai kebutuhan.'],
                    ['icon' => '💳', 'title' => 'Konfirmasi Bayar', 'desc' => 'Aktivasi akun akan segera diproses.'],
                    ['icon' => '📱', 'title' => 'Connect WhatsApp', 'desc' => 'Tautkan nomor WA Bisnis Anda.'],
                    ['icon' => '🔗', 'title' => 'Redirect Meta Business', 'desc' => 'Otorisasi resmi dan dijamin aman.'],
                    ['icon' => '✨', 'title' => 'Data Otomatis Terisi', 'desc' => 'Sistem menarik profil dan katalog.'],
                    ['icon' => '🔙', 'title' => 'Kembali ke Website', 'desc' => 'Proses integrasi telah selesai.'],
                    ['icon' => '🟢', 'title' => 'Cek Status Bot', 'desc' => 'Pastikan bot Active merespon chat.'],
                    ['icon' => '📊', 'title' => 'Masuk Dashboard', 'desc' => 'Akses pusat kontrol bisnis harian.'],
                    ['icon' => '⚙️', 'title' => 'Setting Bot & Profile', 'desc' => 'Sesuaikan gaya AI menjawab pesanan.']
                ];
                foreach ($steps as $idx => $step): ?>
                <div class="min-w-[280px] sm:min-w-[300px] bg-surface rounded-xl p-6 shadow-soft border border-txtmain/5 relative snap-center flex-shrink-0 group hover:border-primary/30 transition-all">
                    <div class="absolute -top-4 -left-4 w-8 h-8 bg-txtmain text-white font-bold rounded-full flex items-center justify-center text-sm shadow-soft group-hover:bg-primary transition-colors">
                        <?= $idx + 1 ?>
                    </div>
                    <div class="text-4xl mb-4 bg-bgnav w-16 h-16 rounded-xl flex items-center justify-center"><?= $step['icon'] ?></div>
                    <h4 class="font-bold text-lg mb-2 text-txtmain"><?= $step['title'] ?></h4>
                    <p class="text-sm text-txtmain/60"><?= $step['desc'] ?></p>
                    
                    <?php if($idx === 8): // Bot status visual ?>
                        <div class="mt-4 inline-flex items-center gap-2 px-3 py-1 bg-green-500/10 border border-green-500/20 text-green-600 rounded-full text-xs font-bold">
                            <span class="w-1.5 h-1.5 bg-green-500 rounded-full"></span> BOT ACTIVE
                        </div>
                    <?php endif; ?>
                </div>
                
                <?php if ($idx < count($steps) - 1): ?>
                <div class="flex items-center justify-center flex-shrink-0 text-txtmain/20 hidden md:flex">
                    <svg class="w-8 h-8" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M14 5l7 7m0 0l-7 7m7-7H3"></path></svg>
                </div>
                <?php endif; ?>
                <?php endforeach; ?>
                
            </div>
            
            <div class="flex justify-center mt-6 hidden sm:flex">
                <p class="text-sm text-txtmain/50 uppercase font-semibold tracking-wider">Scroll ke kanan untuk urutan lengkap →</p>
            </div>
        </div>
    </section>

    <!-- 4. FITUR UTAMA -->
    <section class="py-24 bg-surface" id="fitur">
        <div class="container-custom">
            <div class="mb-16 md:flex justify-between items-end">
                <div class="max-w-xl">
                    <h2 class="text-[32px] md:text-[40px] text-txtmain mb-4">Fitur Lengkap untuk Skalasi Bisnis Anda.</h2>
                    <p class="text-txtmain/70 text-lg">Kelvora bukan sekadar bot. Ini adalah ERP mini canggih khusus UMKM agar jualan jadi autopilot.</p>
                </div>
                <div class="mt-6 md:mt-0">
                    <button class="inline-flex items-center gap-2 h-[44px] px-6 bg-accent text-[#0f766e] font-bold text-[14px] rounded-xl hover:bg-[#45b8ad] transition-all shadow-soft group">
                        <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"></path></svg>
                        Generate Deskripsi dengan AI
                    </button>
                </div>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-6">
                <!-- Card 1 -->
                <div class="bg-bgnav/50 rounded-xl p-8 border border-[#2D3BD9]/5 hover:bg-white hover:shadow-floating transition-all duration-300">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-2xl mb-6">📊</div>
                    <h3 class="text-xl font-bold mb-3">Dashboard Terpusat</h3>
                    <p class="text-txtmain/60 text-sm">Kelola produk, lacak pesanan, dan kelola database pelanggan semua dalam satu jendela kerja yang sangat bersih.</p>
                </div>
                <!-- Card 2 -->
                <div class="bg-bgnav/50 rounded-xl p-8 border border-[#2D3BD9]/5 hover:bg-white hover:shadow-floating transition-all duration-300">
                    <div class="w-14 h-14 bg-primary text-white rounded-xl shadow-soft flex items-center justify-center text-2xl mb-6">🤖</div>
                    <h3 class="text-xl font-bold mb-3">Auto Reply WA & IG</h3>
                    <p class="text-txtmain/60 text-sm">Kecerdasan AI membaca niat pelanggan, merekomendasikan produk yang tepat, dan mendorong transaksi (push-selling).</p>
                </div>
                <!-- Card 3 -->
                <div class="bg-bgnav/50 rounded-xl p-8 border border-[#2D3BD9]/5 hover:bg-white hover:shadow-floating transition-all duration-300">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-2xl mb-6">🛒</div>
                    <h3 class="text-xl font-bold mb-3">Order Terstruktur</h3>
                    <p class="text-txtmain/60 text-sm">Pelanggan deal di chat? Data nama, alamat, produk langsung tercatat rapi ke form order. Selamat tinggal proses manual.</p>
                </div>
                <!-- Card 4 -->
                <div class="bg-primary/5 rounded-xl p-8 border border-primary/20 hover:bg-primary/10 transition-all duration-300">
                    <div class="w-14 h-14 bg-accent text-[#0f766e] rounded-xl shadow-soft flex items-center justify-center text-2xl mb-6">✨</div>
                    <h3 class="text-xl font-bold mb-3">AI Content Generator</h3>
                    <p class="text-txtmain/60 text-sm">Bingung mau nulis caption IG atau detail produk? Cukup beri kata kunci, biarkan AI pintar kami menuliskan copy yang persuasif.</p>
                </div>
                <!-- Card 5 -->
                <div class="bg-bgnav/50 rounded-xl p-8 border border-[#2D3BD9]/5 hover:bg-white hover:shadow-floating transition-all duration-300">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-2xl mb-6">📈</div>
                    <h3 class="text-xl font-bold mb-3">Monitoring & Laporan</h3>
                    <p class="text-txtmain/60 text-sm">Cek pendapatan harian, bulanan, dan evaluasi laporan untung rugi bersih secara otomatis di Income Statement.</p>
                </div>
                <!-- Card 6 -->
                <div class="bg-bgnav/50 rounded-xl p-8 border border-[#2D3BD9]/5 hover:bg-white hover:shadow-floating transition-all duration-300">
                    <div class="w-14 h-14 bg-white rounded-xl shadow-sm flex items-center justify-center text-2xl mb-6">💳</div>
                    <h3 class="text-xl font-bold mb-3">Integrasi Pembayaran</h3>
                    <p class="text-txtmain/60 text-sm">Kirim otomatis tagihan bayar (invoice) dengan rincian biaya ongkir yang telah dihitung langsung oleh sistem.</p>
                </div>
            </div>
        </div>
    </section>

    <!-- 5. PRICING SECTION -->
    <section class="py-24 bg-bgnav" id="harga">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-[32px] md:text-[40px] text-txtmain mb-4">Investasi Berharga Kembangkan Bisnis.</h2>
                <p class="text-txtmain/70 text-lg">Hanya seharga rekrut admin beberapa hari untuk menggaji AI cerdas yang bekerja 24/7/365.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-8 items-center max-w-5xl mx-auto">
                <!-- Package A -->
                <div class="bg-surface rounded-[24px] p-8 shadow-soft border border-txtmain/5 relative">
                    <h3 class="text-xl font-bold mb-2">Starter</h3>
                    <p class="text-txtmain/50 text-sm mb-6">Cocok untuk UMKM pemula</p>
                    <div class="mb-6">
                        <span class="text-3xl font-heading font-bold">Rp 149k</span><span class="text-txtmain/50">/bln</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Dashboard & Order Management
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Limit 500 Pesan AI / bulan
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-txtmain/40">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> AI Content Generator
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold text-txtmain/40">
                            <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg> WhatsApp Integration
                        </li>
                    </ul>
                    <a href="#" class="block w-full text-center h-[44px] leading-[44px] rounded-xl border-2 border-txtmain/10 text-txtmain font-bold hover:border-primary hover:text-primary transition-colors">Pilih Starter</a>
                </div>

                <!-- Package B (Recommended) -->
                <div class="bg-primary rounded-[24px] p-8 shadow-floating border border-primary relative transform md:scale-105 z-10 text-white">
                    <div class="absolute top-0 left-1/2 -translate-x-1/2 -translate-y-1/2 bg-accent text-[#0f766e] px-4 py-1 rounded-full text-xs font-bold uppercase tracking-wider shadow-sm">
                        Paling Laris
                    </div>
                    <h3 class="text-xl font-bold mb-2">Pro Seller</h3>
                    <p class="text-white/70 text-sm mb-6">Standar automasi bisnis digital</p>
                    <div class="mb-6">
                        <span class="text-3xl font-heading font-bold">Rp 349k</span><span class="text-white/70">/bln</span>
                    </div>
                    <ul class="space-y-4 mb-8 border-t border-white/10 pt-6">
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Full Dashboard Access
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Limit 2500 Pesan AI / bulan
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> AI Content Generator Lengkap
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> WA & IG Direct Message
                        </li>
                    </ul>
                    <a href="#" class="block w-full text-center h-[44px] leading-[44px] rounded-xl bg-white text-primary font-bold hover:bg-bgnav transition-colors">Pilih Paket Pro</a>
                </div>

                <!-- Package C -->
                <div class="bg-surface rounded-[24px] p-8 shadow-soft border border-txtmain/5 relative">
                    <h3 class="text-xl font-bold mb-2">Corporate</h3>
                    <p class="text-txtmain/50 text-sm mb-6">Skala besar antri ribuan order</p>
                    <div class="mb-6">
                        <span class="text-3xl font-heading font-bold">Rp 899k</span><span class="text-txtmain/50">/bln</span>
                    </div>
                    <ul class="space-y-4 mb-8">
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Semua Fitur di Pro Seller
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Limit UNLIMITED Pesan AI
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Multi Admin Role
                        </li>
                        <li class="flex items-center gap-3 text-sm font-semibold">
                            <svg class="w-5 h-5 text-accent" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg> Priority Support 24/7
                        </li>
                    </ul>
                    <a href="#" class="block w-full text-center h-[44px] leading-[44px] rounded-xl border-2 border-txtmain/10 text-txtmain font-bold hover:border-primary hover:text-primary transition-colors">Hubungi Kami</a>
                </div>
            </div>
        </div>
    </section>

    <!-- 6. TRUST SECTION -->
    <section class="py-24 bg-surface" id="testimoni">
        <div class="container-custom">
            <div class="text-center mb-16">
                <h2 class="text-[32px] md:text-[40px] text-txtmain mb-4">Dipercayai UMKM Kreatif.</h2>
                <p class="text-txtmain/70 text-lg">Mendengar cerita mereka yang sudah bertransformasi bersama Kelvora.</p>
            </div>

            <div class="grid grid-cols-1 md:grid-cols-3 gap-6">
                <!-- Testi 1 -->
                <div class="bg-bgnav/50 p-6 rounded-[20px] border border-txtmain/5 flex flex-col justify-between">
                    <div>
                        <div class="flex text-amber-400 mb-4 text-sm">★★★★★</div>
                        <p class="text-txtmain font-medium leading-relaxed italic mb-6">"Dulu bales chat pelanggan sampe begadang, keteteran input alamat. Semenjak pake Kelvora, tau-tau order udah masuk ke Dashboard, tinggal packing!"</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-slate-200 rounded-full bg-[url('https://i.pravatar.cc/150?img=47')] bg-cover"></div>
                        <div>
                            <div class="font-bold text-sm">Nisa Fashion</div>
                            <div class="text-xs text-txtmain/60">Owner Hijab Store</div>
                        </div>
                    </div>
                </div>
                <!-- Testi 2 -->
                <div class="bg-bgnav/50 p-6 rounded-[20px] border border-txtmain/5 flex flex-col justify-between">
                    <div>
                        <div class="flex text-amber-400 mb-4 text-sm">★★★★★</div>
                        <p class="text-txtmain font-medium leading-relaxed italic mb-6">"AI nya pinter banget! Kasih saran up-selling ke customer otomatis, dan generate caption IG ngga sampe 5 detik. Sangat menghemat biaya admin."</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-slate-200 rounded-full bg-[url('https://i.pravatar.cc/150?img=11')] bg-cover"></div>
                        <div>
                            <div class="font-bold text-sm">Budi Kopi</div>
                            <div class="text-xs text-txtmain/60">F&B Owner</div>
                        </div>
                    </div>
                </div>
                <!-- Testi 3 -->
                <div class="bg-bgnav/50 p-6 rounded-[20px] border border-txtmain/5 flex flex-col justify-between">
                    <div>
                        <div class="flex text-amber-400 mb-4 text-sm">★★★★★</div>
                        <p class="text-txtmain font-medium leading-relaxed italic mb-6">"Dashboardnya gampang dimengerti, rekap income statement tiap akhir bulan bisa diunduh dalam sekejap. Software bisnis paling the best dibilang lokal."</p>
                    </div>
                    <div class="flex items-center gap-3">
                        <div class="w-12 h-12 bg-slate-200 rounded-full bg-[url('https://i.pravatar.cc/150?img=5')] bg-cover"></div>
                        <div>
                            <div class="font-bold text-sm">Ahmad Elektronik</div>
                            <div class="text-xs text-txtmain/60">Gadget Retail</div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>

    <!-- 7. FINAL CTA -->
    <section class="py-24 relative overflow-hidden bg-primary mx-4 sm:mx-8 md:mx-auto max-w-7xl rounded-[32px] mb-24 shadow-floating">
        <div class="absolute inset-0 bg-[url('data:image/svg+xml;base64,PHN2ZyB4bWxucz0iaHR0cDovL3d3dy53My5vcmcvMjAwMC9zdmciIHdpZHRoPSI0MCIgaGVpZ2h0PSI0MCIgb3BhY2l0eT0iMC4wNSI+PGNpcmNsZSBjeD0iMjAiIGN5PSIyMCIgcj0iMiIgZmlsbD0iI2ZmZiIvPjwvc3ZnPg==')] opacity-30"></div>
        <div class="absolute -right-32 -top-40 w-96 h-96 bg-accent rounded-full blur-[100px] opacity-40"></div>
        
        <div class="container-custom relative z-10 text-center text-white">
            <h2 class="text-[36px] md:text-[48px] max-w-3xl mx-auto mb-6">Siap Mengurus Pesanan Sambil Rebahan?</h2>
            <p class="text-white/80 text-lg mb-10 max-w-xl mx-auto">Bergabunglah dengan UMKM digital lainnya. Jadikan percakapan sosial media Anda lumbung transaksi yang solid bersama sistem kami.</p>
            <a href="<?= url('register') ?>" class="inline-flex items-center justify-center h-[56px] px-10 bg-accent text-[#0f766e] font-bold text-[16px] rounded-xl hover:bg-white hover:text-primary transition-all shadow-floating hover:-translate-y-1">
                Daftar Sekarang — Gratis Uji Coba
            </a>
        </div>
    </section>

    <?php endif; ?>

    <!-- 8. FOOTER -->
    <footer class="bg-surface pt-16 pb-8 border-t border-txtmain/5">
        <div class="container-custom">
            <div class="grid grid-cols-1 md:grid-cols-4 gap-12 mb-12">
                <div class="md:col-span-1">
                    <a href="#" class="flex items-center gap-2 mb-4">
                        <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center text-white font-bold text-xl">⚡</div>
                        <span class="font-heading text-2xl text-txtmain tracking-tight">Kelvora</span>
                    </a>
                    <p class="text-sm text-txtmain/60 mb-6">
                        Menghubungkan UMKM ke gerbang otomasi digital masa depan lewat AI dan platform cerdas.
                    </p>
                    <!-- Social icons dummy -->
                    <div class="flex gap-4">
                        <a href="#" class="w-8 h-8 rounded-full bg-bgnav flex items-center justify-center text-txtmain/60 hover:bg-primary hover:text-white transition-colors">In</a>
                        <a href="#" class="w-8 h-8 rounded-full bg-bgnav flex items-center justify-center text-txtmain/60 hover:bg-primary hover:text-white transition-colors">Ig</a>
                        <a href="#" class="w-8 h-8 rounded-full bg-bgnav flex items-center justify-center text-txtmain/60 hover:bg-primary hover:text-white transition-colors">X</a>
                    </div>
                </div>
                
                <div>
                    <h5 class="font-bold text-txtmain mb-4 uppercase text-sm tracking-wider">Produk</h5>
                    <ul class="space-y-3 text-sm text-txtmain/60">
                        <li><a href="#fitur" class="hover:text-primary">Fitur AI</a></li>
                        <li><a href="#harga" class="hover:text-primary">Harga & Paket</a></li>
                        <li><a href="#cara-kerja" class="hover:text-primary">Integrasi API</a></li>
                        <li><a href="#" class="hover:text-primary">Changelog</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold text-txtmain mb-4 uppercase text-sm tracking-wider">Sumber Daya</h5>
                    <ul class="space-y-3 text-sm text-txtmain/60">
                        <li><a href="#" class="hover:text-primary">Pusat Bantuan</a></li>
                        <li><a href="#" class="hover:text-primary">Tutorial Video</a></li>
                        <li><a href="#" class="hover:text-primary">Blog & Artikel</a></li>
                        <li><a href="#" class="hover:text-primary">Komunitas Kelvora</a></li>
                    </ul>
                </div>

                <div>
                    <h5 class="font-bold text-txtmain mb-4 uppercase text-sm tracking-wider">Perusahaan</h5>
                    <ul class="space-y-3 text-sm text-txtmain/60">
                        <li><a href="#" class="hover:text-primary">Tentang Kami</a></li>
                        <li><a href="#" class="hover:text-primary">Karir</a></li>
                        <li><a href="/policy-privacy" class="hover:text-primary">Privacy Policy</a></li>
                        <li><a href="/terms-conditions" class="hover:text-primary">Terms & Conditions</a></li>
                    </ul>
                </div>
            </div>
            
            <div class="border-t border-txtmain/5 pt-8 flex flex-col md:flex-row items-center justify-between text-xs text-txtmain/40">
                <p>&copy; 2026 Kelvora Inc. All rights reserved.</p>
                <div class="flex gap-4 mt-4 md:mt-0">
                    <span>Made in Indonesia</span>
                </div>
            </div>
        </div>
    </footer>

<script>
    function toggleProfileMenu() {
        const menu = document.getElementById('profileMenu');
        menu.classList.toggle('hidden');
    }
    function toggleNavbarMobile() {
        const menu = document.getElementById('navbarMobile');
        menu.classList.toggle('hidden');
    }
    document.addEventListener('click', function(e) {
        const dropdown = document.getElementById('profileDropdown');
        const menu = document.getElementById('profileMenu');
        if (dropdown && menu && !dropdown.contains(e.target)) {
            menu.classList.add('hidden');
        }
    });
</script>
</body>
</html>
