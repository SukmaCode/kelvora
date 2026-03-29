<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Prosedur Penghapusan Data Pengguna Kelvora. Panduan cara mengajukan penghapusan data secara permanen secara aman.">
    <title>Penghapusan Data Pengguna — Kelvora</title>
    <link rel="preconnect" href="https://fonts.googleapis.com">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@300;400;500;600;700;800&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="<?= url('public/build/assets/style.css') ?>">
    <script>
        window.tailwind = window.tailwind || {}; tailwind.config = {
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
</head>
<body class="font-sans text-slate-800 antialiased bg-slate-50 flex flex-col min-h-screen">

<!-- HEADER -->
<header class="fixed top-0 left-0 w-full z-50 bg-white/80 backdrop-blur-md border-b border-slate-200">
    <div class="max-w-7xl mx-auto flex items-center justify-between px-6 py-4">
        <!-- Logo -->
        <a href="/" class="flex items-center gap-2 group">
            <svg class="w-7 h-7 text-brand" viewBox="0 0 32 32" fill="none">
                <path d="M6 8l10-5 10 5v10l-10 5-6-3" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
                <path d="M16 13v10m0-10l10-5M16 13L6 8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/>
            </svg>
            <span class="text-xl font-bold tracking-tight text-slate-900">KELVORA</span>
        </a>
        <!-- Links -->
        <div class="hidden md:flex items-center gap-8">
            <a href="/policy-privacy" class="text-sm font-medium text-slate-600 hover:text-brand transition">Kebijakan Privasi</a>
            <a href="/terms-conditions" class="text-sm font-medium text-slate-600 hover:text-brand transition">Ketentuan Layanan</a>
            <a href="/remove-data" class="text-sm font-medium text-brand">Penghapusan Data</a>
        </div>
        <div class="flex items-center">
            <a href="/login" class="px-5 py-2.5 bg-brand text-white text-sm font-semibold rounded-lg shadow-lg shadow-indigo-500/25 hover:bg-brand-dark transition duration-200">Menuju Dashboard</a>
        </div>
    </div>
</header>

<!-- MAIN CONTENT -->
<main class="flex-grow pt-32 pb-16 px-6">
    <article class="max-w-4xl mx-auto bg-white p-8 sm:p-12 rounded-2xl shadow-sm border border-slate-100">
        <header class="mb-10 border-b border-slate-100 pb-8 text-center sm:text-left">
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Penghapusan Data Pengguna</h1>
            <p class="mt-4 text-sm text-slate-500 font-medium">Diperbarui Terakhir: 25 Maret 2026</p>
        </header>

        <!-- Alert info -->
        <div class="mb-10 p-5 bg-orange-50/80 border border-orange-200 rounded-xl flex gap-4 items-start">
            <div class="w-6 h-6 text-orange-600 shrink-0 mt-0.5">
                <svg fill="none" viewBox="0 0 24 24" stroke="currentColor" stroke-width="2"><path stroke-linecap="round" stroke-linejoin="round" d="M12 9v2m0 4h.01m-6.938 4h13.856c1.54 0 2.502-1.667 1.732-3L13.732 4c-.77-1.333-2.694-1.333-3.464 0L3.34 16c-.77 1.333.192 3 1.732 3z"/></svg>
            </div>
            <div>
                <h3 class="text-sm font-bold text-orange-900 mb-1">Peringatan Penting</h3>
                <p class="text-sm text-orange-800 leading-relaxed">Tindakan penghapusan data bersifat permanen dan tidak dapat dibatalkan. Segera setelah proses penghapusan selesai, Anda tidak akan lagi bisa mengakses rekam jejak bisnis, data produk, inventori, dan informasi operasional Anda di platform Kelvora.</p>
            </div>
        </div>
        
        <section class="space-y-8 text-slate-600 leading-relaxed">
            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">1. Hak Anda atas Penghapusan Data</h2>
                <p>Kelvora sepenuhnya mematuhi peraturan perlindungan data global, memberi Anda visibilitas dan kendali penuh terhadap informasi Anda. Sebagai pengguna terdaftar, Anda mempunyai hak yang dilindungi oleh sistem untuk mengajukan permohonan penghapusan secara definitif atas data pribadi dan data operasional yang tersimpan di dalam infrastruktur kami.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">2. Jenis Data yang Akan Dihapus</h2>
                <p class="mb-2">Saat Anda mengajukan permintaan penghapusan akun, elemen-elemen berikut ini akan tertarget dalam proses tersebut:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Informasi Profil: Nama, email, preferensi, pengaturan akun, dan kata sandi yang di-hash.</li>
                    <li>Sistem Transaksi: Seluruh jejak historis pemesanan (Orders) dan entitas transaksi kelolaan.</li>
                    <li>Manajemen Konten: Daftar inventori/produk yang sebelumnya telah Anda unggah dan distribusikan.</li>
                    <li>Log Analitik: Sesi login historis dan catatan lalu lintas operasional bisnis Anda.</li>
                </ul>
                <p class="mt-3 text-sm italic text-slate-500">*Catatan: Data yang berkaitan dengan legalitas keuangan atau catatan perpajakan yang diwajibkan oleh hukum negara mungkin akan diretensi untuk jangka waktu tertentu sesuai undang-undang sebelum dihancurkan secara permanen.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">3. Cara Mengajukan Permintaan Penghapusan</h2>
                <p class="mb-2">Untuk memulai inisiasi penghapusan permanen ini, kami menyediakan dua jalur dukungan formal:</p>
                <ol class="list-decimal pl-5 space-y-2">
                    <li><strong>Melalui Portal Dashboard:</strong> Masuk ke akun Anda &rarr; Menuju menu 'Pengaturan' &rarr; 'Privasi & Keamanan' &rarr; Klik 'Hapus Akun Secara Permanen'. Ikuti instruksi verifikasi keamanan, lalu konfirmasi.</li>
                    <li><strong>Melalui Surat Elektronik (Email):</strong> Anda dapat mengirimkan email yang menyertakan alamat email terdaftar dan ID Perusahaan ke <span class="text-slate-800 font-semibold">privacy@kelvora.com</span> dengan subjek <em>"Permohonan Penghapusan Akun [Nama Perusahaan]"</em>.</li>
                </ol>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">4. Proses & Estimasi Waktu Pelaksanaan</h2>
                <p>Segera sesudah permintaan berhasil divalidasi dan terkonfirmasi, kami akan memulai rutinitas pembersihan (purging routine) dari cloud database aktif kami. Proses ini membutuhkan estimasi durasi operasional <strong>hingga maksimal 30 hari kerja</strong> untuk menjangkau setiap file pencadangan backup secara komprehensif. Anda akan menerima sebuah konfirmasi penutupan via email sebagai bukti pelepasan.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">5. Dampak Lanjutan Setelah Penghapusan</h2>
                <p>Setelah tahapan ini berhasil diproses sepenuhnya, seluruh kredensial lama Anda tidak dapat digunakan untuk otentikasi. Semua endpoint atau API Key yang menaut pada platform Anda akan dinonaktifkan secara seketika dan akan menolak semua lalu lintas permintaan, sehingga mencegah integritas yang tak diinginkan di masa depan.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">6. Kontak Bantuan</h2>
                <p>Apabila Anda mendapati kesulitan selama proses pengajuan ini atau ingin menghentikan sementara prosesnya, silakan terhubung dengan tim Data Support kami:</p>
                <div class="mt-4 p-4 bg-slate-50 border border-slate-200 rounded-lg inline-block">
                    <p class="font-medium text-slate-800">Email Utama: <a href="mailto:support@kelvora.com" class="text-brand hover:underline">support@kelvora.com</a></p>
                    <p class="font-medium text-slate-800 mt-1">Eskalasi Khusus: <a href="mailto:privacy@kelvora.com" class="text-brand hover:underline">privacy@kelvora.com</a></p>
                </div>
            </div>
        </section>
    </article>
</main>

<!-- FOOTER -->
<footer class="bg-slate-900 text-slate-400 py-12 mt-auto">
    <div class="max-w-7xl mx-auto px-6 text-center sm:text-left flex flex-col md:flex-row items-center justify-between">
        <div class="mb-6 md:mb-0">
            <div class="flex items-center justify-center sm:justify-start gap-2 mb-2">
                <svg class="w-6 h-6 text-brand-light" viewBox="0 0 32 32" fill="none"><path d="M6 8l10-5 10 5v10l-10 5-6-3" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/><path d="M16 13v10m0-10l10-5M16 13L6 8" stroke="currentColor" stroke-width="2.5" stroke-linecap="round" stroke-linejoin="round"/></svg>
                <span class="text-lg font-bold text-white">KELVORA</span>
            </div>
            <p class="text-sm">Modern business management infrastructure. Aman, andal, dan cerdas.</p>
        </div>
        <div class="flex items-center gap-6 text-sm">
            <a href="/policy-privacy" class="hover:text-white transition">Kebijakan Privasi</a>
            <a href="/terms-conditions" class="hover:text-white transition">Ketentuan Layanan</a>
            <a href="/remove-data" class="hover:text-white transition">Hapus Data</a>
        </div>
    </div>
    <div class="max-w-7xl mx-auto px-6 mt-8 pt-8 border-t border-slate-800 text-center text-sm">
        <p>&copy; 2026 Kelvora. All rights reserved.</p>
    </div>
</footer>

</body>
</html>
