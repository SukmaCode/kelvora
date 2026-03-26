<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Kelvora — Seamless API integration, real-time syncing, and zero-maintenance infrastructure for modern engineering teams.">
    <title>Kelvora — Unify Your Data Streams</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <script src="https://cdn.tailwindcss.com"></script>
    <script>
        tailwind.config = {
            theme: {
                extend: {
                    fontFamily: { sans: ['Inter', 'sans-serif'] },
                    colors: {
                        brand: { DEFAULT: '#4f46e5', light: '#6366f1', dark: '#3730a3' },
                    },
                },
            },
        }
    </script>
    <style>
        .hero-bg {
            background: linear-gradient(135deg, #f8fafc 0%, #eef2ff 30%, #e0f2fe 60%, #ecfdf5 100%);
        }
        @keyframes float { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-12px); } }
        @keyframes floatSlow { 0%,100%{ transform: translateY(0); } 50%{ transform: translateY(-8px); } }
        @keyframes pulse-bar { 0%{ width: 30%; } 50%{ width: 70%; } 100%{ width: 30%; } }
        .float-1 { animation: float 5s ease-in-out infinite; }
        .float-2 { animation: floatSlow 6s ease-in-out infinite 0.5s; }
        .float-3 { animation: float 7s ease-in-out infinite 1s; }
        .float-4 { animation: floatSlow 5.5s ease-in-out infinite 1.5s; }
        .float-5 { animation: float 6.5s ease-in-out infinite 0.8s; }
        .pulse-bar { animation: pulse-bar 3s ease-in-out infinite; }
        @keyframes fadeUp { from { opacity:0; transform:translateY(24px); } to { opacity:1; transform:translateY(0); } }
        .fade-up { animation: fadeUp 0.7s ease-out both; }
        .fade-up-d1 { animation-delay: 0.1s; }
        .fade-up-d2 { animation-delay: 0.25s; }
        .fade-up-d3 { animation-delay: 0.4s; }
    </style>
</head>
<body class="font-sans text-slate-800 antialiased">

<!-- ============ NAVBAR ============ -->
<nav class="fixed top-0 left-0 w-full z-50 bg-white/70 backdrop-blur-lg border-b border-slate-200/60">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <!-- Logo -->
        <a href="#" class="flex items-center gap-2 group">
            <svg class="w-7 h-7 text-brand" viewBox="0 0 32 32" fill="none">
                <path d="M6 8l10-5 10 5v10l-10 5-6-3" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16 13v10m0-10l10-5M16 13L6 8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-xl font-bold tracking-tight text-slate-900">KELVORA</span>
        </a>
        <!-- Desktop Links -->
        <div class="hidden md:flex items-center gap-8">
            <a href="#features" class="text-sm font-medium text-slate-600 hover:text-brand transition">Features</a>
            <a href="#integrations" class="text-sm font-medium text-slate-600 hover:text-brand transition">Integrations</a>
            <a href="#pricing" class="text-sm font-medium text-slate-600 hover:text-brand transition">Pricing</a>
            <a href="#docs" class="text-sm font-medium text-slate-600 hover:text-brand transition">Docs</a>
            <a href="policy-privacy" class="text-sm font-medium text-slate-600 hover:text-brand py-2">Privacy Policy</a>
        </div>
        <!-- CTA -->
        <div class="flex items-center gap-3">
            <a href="#" class="hidden sm:inline-flex items-center gap-2 px-5 py-2.5 bg-brand text-white text-sm font-semibold rounded-lg shadow-lg shadow-indigo-500/25 hover:bg-brand-dark hover:shadow-indigo-500/40 transition-all duration-200">Start Building</a>
            <!-- Mobile Menu Button -->
            <button id="mobileMenuBtn" class="md:hidden flex items-center justify-center w-10 h-10 rounded-lg hover:bg-slate-100 transition" onclick="document.getElementById('mobileMenu').classList.toggle('hidden')">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 6h16M4 12h16M4 18h16"/></svg>
            </button>
        </div>
    </div>
    <!-- Mobile Menu -->
    <div id="mobileMenu" class="hidden md:hidden border-t border-slate-200/60 bg-white/90 backdrop-blur-lg">
        <div class="flex flex-col px-6 py-4 gap-3">
            <a href="#features" class="text-sm font-medium text-slate-600 hover:text-brand py-2">Features</a>
            <a href="#integrations" class="text-sm font-medium text-slate-600 hover:text-brand py-2">Integrations</a>
            <a href="#pricing" class="text-sm font-medium text-slate-600 hover:text-brand py-2">Pricing</a>
            <a href="#docs" class="text-sm font-medium text-slate-600 hover:text-brand py-2">Docs</a>
            <a href="policy-privacy" class="text-sm font-medium text-slate-600 hover:text-brand py-2">Privacy Policy</a>
            <a href="#" class="sm:hidden inline-flex items-center justify-center px-5 py-2.5 bg-brand text-white text-sm font-semibold rounded-lg">Start Building</a>
        </div>
    </div>
</nav>

<!-- ============ HERO ============ -->
<section class="hero-bg min-h-screen pt-24 md:pt-32 pb-16 overflow-hidden">
    <div class="max-w-7xl mx-auto px-6 flex flex-col lg:flex-row items-center gap-12 lg:gap-8">
        <!-- Left: Copy -->
        <div class="flex-1 max-w-xl fade-up">
            <h1 class="text-4xl sm:text-5xl lg:text-[3.5rem] font-extrabold leading-[1.1] tracking-tight text-slate-900 fade-up">
                Unify your<br>data streams.
            </h1>
            <p class="mt-6 text-lg text-slate-500 leading-relaxed max-w-md fade-up fade-up-d1">
                Seamless API integration, real-time syncing, and zero-maintenance infrastructure designed for modern engineering teams.
            </p>
            <div class="mt-8 flex flex-wrap items-center gap-4 fade-up fade-up-d2">
                <a href="#" class="inline-flex items-center gap-2 px-7 py-3.5 bg-brand text-white text-sm font-semibold rounded-full shadow-lg shadow-indigo-500/30 hover:bg-brand-dark hover:shadow-indigo-500/50 transition-all duration-200 hover:-translate-y-0.5">
                    Start Stitching
                </a>
                <a href="#docs" class="inline-flex items-center gap-1.5 text-sm font-semibold text-brand hover:text-brand-dark transition group">
                    Read Docs <span class="group-hover:translate-x-1 transition-transform">→</span>
                </a>
            </div>
        </div>

        <!-- Right: Integration Cards Visual -->
        <div class="flex-1 relative w-full max-w-lg lg:max-w-xl min-h-[380px] sm:min-h-[440px] fade-up fade-up-d3">
            <!-- Center Card: Stitch Core -->
            <div class="absolute left-[32%] top-[26%] sm:top-32 sm:left-36 lg:top-[26%] lg:left-[32%] -translate-x-1/2 -translate-y-1/2 z-20 w-48 sm:w-56 bg-white rounded-2xl shadow-xl shadow-slate-200/60 border border-slate-100 p-5 sm:p-6 text-center float-2">
                <div class="w-12 h-12 mx-auto bg-indigo-50 rounded-xl flex items-center justify-center mb-3">
                    <svg class="w-7 h-7 text-brand" fill="none" viewBox="0 0 24 24" stroke="currentColor"><circle cx="12" cy="12" r="3" stroke-width="2"/><path stroke-width="2" stroke-linecap="round" d="M12 2v4m0 12v4m10-10h-4M6 12H2m15.07-7.07l-2.83 2.83M9.76 14.24l-2.83 2.83m11.14 0l-2.83-2.83M9.76 9.76L6.93 6.93"/></svg>
                </div>
                <p class="font-bold text-slate-800 text-sm">Stitch Core</p>
                <p class="text-xs text-slate-400 mt-1">Status: Syncing</p>
                <div class="mt-3 h-1.5 bg-indigo-100 rounded-full overflow-hidden">
                    <div class="h-full bg-brand rounded-full pulse-bar"></div>
                </div>
            </div>

            <!-- PostgreSQL -->
            <div class="absolute left-[10%] top-[8%] sm:left-[15%] sm:top-[5%] z-10 bg-white rounded-xl shadow-lg shadow-slate-200/40 border border-slate-100 px-4 py-3 flex items-center gap-3 float-1">
                <div class="w-9 h-9 bg-blue-50 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-blue-600" viewBox="0 0 24 24" fill="currentColor"><path d="M12 2C6.48 2 2 4.02 2 6.5v11C2 19.98 6.48 22 12 22s10-2.02 10-4.5v-11C22 4.02 17.52 2 12 2zm0 2c4.42 0 8 1.57 8 3.5S16.42 11 12 11 4 9.43 4 7.5 7.58 4 12 4z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-700">PostgreSQL</p>
                    <p class="text-[10px] text-emerald-500 font-medium">Connected</p>
                </div>
            </div>

            <!-- Stripe API -->
            <div class="absolute right-[2%] top-[12%] sm:right-[5%] sm:top-[10%] z-10 bg-white rounded-xl shadow-lg shadow-slate-200/40 border border-slate-100 px-4 py-3 flex items-center gap-3 float-3">
                <div class="w-9 h-9 bg-violet-50 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-violet-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M12 2l3.09 6.26L22 9.27l-5 4.87 1.18 6.88L12 17.77l-6.18 3.25L7 14.14 2 9.27l6.91-1.01L12 2z"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-700">Stripe API</p>
                </div>
            </div>

            <!-- Snowflake -->
            <div class="absolute left-[5%] bottom-[18%] sm:left-[8%] sm:bottom-[15%] z-10 bg-white rounded-xl shadow-lg shadow-slate-200/40 border border-slate-100 px-4 py-3 flex items-center gap-3 float-4">
                <div class="w-9 h-9 bg-sky-50 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-sky-600" viewBox="0 0 24 24" fill="currentColor"><rect x="3" y="3" width="7" height="7" rx="1.5"/><rect x="14" y="3" width="7" height="7" rx="1.5"/><rect x="3" y="14" width="7" height="7" rx="1.5"/><rect x="14" y="14" width="7" height="7" rx="1.5"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-700">Snowflake</p>
                </div>
            </div>

            <!-- AWS S3 -->
            <div class="absolute right-[5%] bottom-[8%] sm:right-[8%] sm:bottom-[5%] z-10 bg-white rounded-xl shadow-lg shadow-slate-200/40 border border-slate-100 px-4 py-3 flex items-center gap-3 float-5">
                <div class="w-9 h-9 bg-emerald-50 rounded-lg flex items-center justify-center shrink-0">
                    <svg class="w-5 h-5 text-emerald-600" viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"><path d="M3 15l4-8 4 8"/><path d="M13 15l4-8 4 8"/><path d="M5 11h4m4 0h4"/></svg>
                </div>
                <div>
                    <p class="text-xs font-semibold text-slate-700">AWS S3</p>
                    <p class="text-[10px] text-emerald-500 font-medium">Connected</p>
                </div>
            </div>

            <!-- Connection Lines (decorative) -->
            <svg class="absolute inset-0 w-full h-full z-0 pointer-events-none opacity-20" viewBox="0 0 500 440">
                <line x1="160" y1="60" x2="250" y2="200" stroke="#6366f1" stroke-width="1.5" stroke-dasharray="6 4"/>
                <line x1="380" y1="70" x2="280" y2="190" stroke="#6366f1" stroke-width="1.5" stroke-dasharray="6 4"/>
                <line x1="100" y1="330" x2="230" y2="240" stroke="#6366f1" stroke-width="1.5" stroke-dasharray="6 4"/>
                <line x1="400" y1="360" x2="290" y2="250" stroke="#6366f1" stroke-width="1.5" stroke-dasharray="6 4"/>
            </svg>
        </div>
    </div>
</section>

<!-- ============ FEATURES SECTION ============ -->
<section id="features" class="py-20 sm:py-28 bg-white">
    <div class="max-w-7xl mx-auto px-6">
        <div class="text-center max-w-2xl mx-auto mb-16">
            <p class="text-sm font-semibold text-brand uppercase tracking-wider mb-3">Features</p>
            <h2 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Everything you need to unify your stack</h2>
            <p class="mt-4 text-slate-500 text-lg">Built for developers who want reliable data pipelines without the overhead.</p>
        </div>
        <div class="grid sm:grid-cols-2 lg:grid-cols-3 gap-8">
            <!-- Feature 1 -->
            <div class="group p-6 rounded-2xl border border-slate-200 hover:border-brand/30 hover:shadow-lg hover:shadow-indigo-500/5 transition-all duration-300">
                <div class="w-11 h-11 bg-indigo-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-brand group-hover:text-white transition-colors">
                    <svg class="w-5 h-5 text-brand group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13 10V3L4 14h7v7l9-11h-7z"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Real-Time Syncing</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Bi-directional data sync with sub-second latency across all connected sources.</p>
            </div>
            <!-- Feature 2 -->
            <div class="group p-6 rounded-2xl border border-slate-200 hover:border-brand/30 hover:shadow-lg hover:shadow-indigo-500/5 transition-all duration-300">
                <div class="w-11 h-11 bg-indigo-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-brand group-hover:text-white transition-colors">
                    <svg class="w-5 h-5 text-brand group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Enterprise Security</h3>
                <p class="text-sm text-slate-500 leading-relaxed">End-to-end encryption, SOC 2 compliance, and role-based access control built-in.</p>
            </div>
            <!-- Feature 3 -->
            <div class="group p-6 rounded-2xl border border-slate-200 hover:border-brand/30 hover:shadow-lg hover:shadow-indigo-500/5 transition-all duration-300">
                <div class="w-11 h-11 bg-indigo-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-brand group-hover:text-white transition-colors">
                    <svg class="w-5 h-5 text-brand group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M4 7v10c0 2.21 3.58 4 8 4s8-1.79 8-4V7M4 7c0 2.21 3.58 4 8 4s8-1.79 8-4M4 7c0-2.21 3.58-4 8-4s8 1.79 8 4"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Zero Maintenance</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Fully managed infrastructure that scales automatically. No ops team required.</p>
            </div>
            <!-- Feature 4 -->
            <div class="group p-6 rounded-2xl border border-slate-200 hover:border-brand/30 hover:shadow-lg hover:shadow-indigo-500/5 transition-all duration-300">
                <div class="w-11 h-11 bg-indigo-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-brand group-hover:text-white transition-colors">
                    <svg class="w-5 h-5 text-brand group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M11 4a2 2 0 114 0v1a1 1 0 001 1h3a1 1 0 011 1v3a1 1 0 01-1 1h-1a2 2 0 100 4h1a1 1 0 011 1v3a1 1 0 01-1 1h-3a1 1 0 01-1-1v-1a2 2 0 10-4 0v1a1 1 0 01-1 1H7a1 1 0 01-1-1v-3a1 1 0 00-1-1H4a2 2 0 110-4h1a1 1 0 001-1V7a1 1 0 011-1h3a1 1 0 001-1V4z"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">150+ Integrations</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Connect to databases, APIs, SaaS tools, and warehouses in minutes.</p>
            </div>
            <!-- Feature 5 -->
            <div class="group p-6 rounded-2xl border border-slate-200 hover:border-brand/30 hover:shadow-lg hover:shadow-indigo-500/5 transition-all duration-300">
                <div class="w-11 h-11 bg-indigo-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-brand group-hover:text-white transition-colors">
                    <svg class="w-5 h-5 text-brand group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 19v-6a2 2 0 00-2-2H5a2 2 0 00-2 2v6a2 2 0 002 2h2a2 2 0 002-2zm0 0V9a2 2 0 012-2h2a2 2 0 012 2v10m-6 0a2 2 0 002 2h2a2 2 0 002-2m0 0V5a2 2 0 012-2h2a2 2 0 012 2v14a2 2 0 01-2 2h-2a2 2 0 01-2-2z"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Analytics Dashboard</h3>
                <p class="text-sm text-slate-500 leading-relaxed">Monitor pipeline health, throughput, and errors in a real-time dashboard.</p>
            </div>
            <!-- Feature 6 -->
            <div class="group p-6 rounded-2xl border border-slate-200 hover:border-brand/30 hover:shadow-lg hover:shadow-indigo-500/5 transition-all duration-300">
                <div class="w-11 h-11 bg-indigo-50 rounded-xl flex items-center justify-center mb-4 group-hover:bg-brand group-hover:text-white transition-colors">
                    <svg class="w-5 h-5 text-brand group-hover:text-white" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M10 20l4-16m4 4l4 4-4 4M6 16l-4-4 4-4"/></svg>
                </div>
                <h3 class="font-bold text-slate-900 mb-2">Developer-First API</h3>
                <p class="text-sm text-slate-500 leading-relaxed">RESTful & GraphQL APIs with SDKs for Python, Node.js, Go, and more.</p>
            </div>
        </div>
    </div>
</section>

<!-- ============ CTA SECTION ============ -->
<section class="py-20 sm:py-24 bg-gradient-to-br from-indigo-600 via-brand to-violet-600 relative overflow-hidden">
    <div class="absolute inset-0 opacity-10">
        <div class="absolute w-96 h-96 bg-white rounded-full -top-48 -left-48"></div>
        <div class="absolute w-64 h-64 bg-white rounded-full -bottom-32 -right-32"></div>
    </div>
    <div class="max-w-3xl mx-auto px-6 text-center relative z-10">
        <h2 class="text-3xl sm:text-4xl font-extrabold text-white tracking-tight">Ready to unify your data?</h2>
        <p class="mt-4 text-indigo-100 text-lg max-w-xl mx-auto">Join thousands of engineering teams shipping faster with Kelvora's data infrastructure.</p>
        <div class="mt-8 flex flex-wrap justify-center gap-4">
            <a href="#" class="px-8 py-3.5 bg-white text-brand font-semibold text-sm rounded-full shadow-lg hover:shadow-xl hover:-translate-y-0.5 transition-all duration-200">Get Started Free</a>
            <a href="#" class="px-8 py-3.5 bg-transparent text-white font-semibold text-sm rounded-full border-2 border-white/30 hover:bg-white/10 transition-all duration-200">Talk to Sales</a>
        </div>
    </div>
</section>

<!-- ============ FOOTER ============ -->
<footer class="bg-slate-900 text-slate-400 py-12 sm:py-16">
    <div class="max-w-7xl mx-auto px-6">
        <div class="grid sm:grid-cols-2 lg:grid-cols-4 gap-8 sm:gap-12">
            <div>
                <div class="flex items-center gap-2 mb-4">
                    <svg class="w-6 h-6 text-brand-light" viewBox="0 0 32 32" fill="none"><path d="M6 8l10-5 10 5v10l-10 5-6-3" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 13v10m0-10l10-5M16 13L6 8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                    <span class="text-lg font-bold text-white">KELVORA</span>
                </div>
                <p class="text-sm leading-relaxed">Modern data infrastructure for engineering teams that move fast.</p>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white mb-4">Product</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">Features</a></li>
                    <li><a href="#" class="hover:text-white transition">Integrations</a></li>
                    <li><a href="#" class="hover:text-white transition">Pricing</a></li>
                    <li><a href="#" class="hover:text-white transition">Changelog</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white mb-4">Resources</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">Documentation</a></li>
                    <li><a href="#" class="hover:text-white transition">API Reference</a></li>
                    <li><a href="#" class="hover:text-white transition">Blog</a></li>
                    <li><a href="#" class="hover:text-white transition">Community</a></li>
                </ul>
            </div>
            <div>
                <h4 class="text-sm font-semibold text-white mb-4">Company</h4>
                <ul class="space-y-2 text-sm">
                    <li><a href="#" class="hover:text-white transition">About</a></li>
                    <li><a href="#" class="hover:text-white transition">Careers</a></li>
                    <li><a href="policy-privacy" class="hover:text-white transition">Privacy</a></li>
                    <li><a href="terms-conditions" class="hover:text-white transition">Terms</a></li>
                </ul>
            </div>
        </div>
        <div class="mt-12 pt-8 border-t border-slate-800 text-center text-sm">
            <p>&copy; 2026 Kelvora. All rights reserved.</p>
        </div>
    </div>
</footer>

<script>
// Scroll-triggered fade-in for feature cards
const observer = new IntersectionObserver((entries) => {
    entries.forEach(entry => {
        if (entry.isIntersecting) {
            entry.target.classList.add('fade-up');
            observer.unobserve(entry.target);
        }
    });
}, { threshold: 0.1 });
document.querySelectorAll('#features .group').forEach(el => {
    el.style.opacity = '0';
    observer.observe(el);
});
// Smooth scroll for anchor links
document.querySelectorAll('a[href^="#"]').forEach(a => {
    a.addEventListener('click', e => {
        const id = a.getAttribute('href');
        if (id.length > 1) {
            e.preventDefault();
            document.querySelector(id)?.scrollIntoView({ behavior: 'smooth' });
            document.getElementById('mobileMenu')?.classList.add('hidden');
        }
    });
});
</script>
</body>
</html>
