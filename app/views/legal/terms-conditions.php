<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="description" content="Ketentuan Layanan Kelvora terkait syarat dan aturan penggunaan platform SaaS kelola bisnis.">
    <title>Ketentuan Layanan — Kelvora</title>
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
            <a href="/terms-conditions" class="text-sm font-medium text-brand">Ketentuan Layanan</a>
            <a href="/remove-data" class="text-sm font-medium text-slate-600 hover:text-brand transition">Penghapusan Data</a>
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
            <h1 class="text-3xl sm:text-4xl font-extrabold text-slate-900 tracking-tight">Ketentuan Layanan</h1>
            <p class="mt-4 text-sm text-slate-500 font-medium">Diperbarui Terakhir: 25 Maret 2026</p>
        </header>

        <section class="space-y-8 text-slate-600 leading-relaxed">
            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">1. Definisi Layanan</h2>
                <p>Kelvora adalah platform Perangkat Lunak sebagai Layanan (SaaS) berorientasi pengelolaan bisnis bagi UMKM yang mencakup manajemen data, pemantauan pesanan (Orders), manajemen produk, pengelolaan pengguna, dan solusi operasional bisnis secara holistik, dapat diakses sepenuhnya melalui antarmuka web.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">2. Ketentuan Penggunaan Platform</h2>
                <p>Dengan melakukan registrasi, mengakses, dan menggunakan fungsionalitas di platform Kelvora, Anda menyatakan bahwa Anda telah cakap secara hukum serta sepenuhnya secara mengikat telah menyetujui seluruh butir kontrak yang terkandung dalam Ketentuan Layanan ini layaknya kontrak legal pada umumnya.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">3. Hak dan Kewajiban Pengguna</h2>
                <p class="mb-2">Setiap pengguna memegang hak dan kewajiban profesional sebagai berikut:</p>
                <ul class="list-disc pl-5 space-y-2">
                    <li>Bertanggung jawab sepenuhnya untuk menjaga keamanan kata sandi serta kredensial otorisasi yang dipercayakan dalam ekosistem Kelvora.</li>
                    <li>Wajib memberikan informasi bisnis yang akurat dan sah di hadapan hukum selama proses pendaftaran.</li>
                    <li>Kami sebagai penyedia, berhak menolak akses, memodifikasi, atau memutus layanan kepada pengguna mana pun tanpa memerlukan kompensasi apabila dideteksi adanya penyalahgunaan akses.</li>
                </ul>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">4. Larangan Penggunaan</h2>
                <p class="mb-2">Untuk senantiasa merawat stabilitas dan keamanan platform, setiap pengguna atau entitas diamanatkan untuk <strong>TIDAK</strong> melakukan intervensi berikut:</p>
                <div class="grid grid-cols-1 sm:grid-cols-2 gap-4 mt-4">
                    <div class="border border-slate-100 bg-slate-50 p-4 rounded-lg">
                        <h4 class="font-bold text-slate-800 text-sm mb-1">Eksploitasi Jaringan</h4>
                        <p class="text-sm">Melaksanakan rekayasa balik (reverse-engineering), dekripsi instrumen, maupun manipulasi kode secara ilegal atas infrastruktur Kelvora.</p>
                    </div>
                    <div class="border border-slate-100 bg-slate-50 p-4 rounded-lg">
                        <h4 class="font-bold text-slate-800 text-sm mb-1">Aktivitas Destruktif</h4>
                        <p class="text-sm">Mendistribusikan berkas elektronik berbau malware, spam terautomasi, serta aktivitas yang mengganggu stabilitas bandwidth hosting.</p>
                    </div>
                </div>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">5. Pembayaran dan Langganan</h2>
                <p>Biaya atas layanan Kelvora ditagih di awal pada setiap periode tagihan langganan (secara bulanan maupun tahunan). Sistem akan memperbarui paket secara otomatis (auto-renewal) pada titik akhir dari siklus penagihan reguler kecuali apabila Anda memutuskan untuk menganulir paket langganan secara proaktif di menu tagihan sebelum tanggal tersebut jatuh tempo. Kami memproses transaksi dengan bantuan agregator pembayaran, dan seluruh faktur dapat dicetak pada portal.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">6. Pembatalan dan Penghentian Akun</h2>
                <p>Anda dapat mengakhiri status berlangganan atau menutup fungsionalitas akun Anda pada masa apa pun. Meski demikian, segala biaya periode langganan berjalan dan yang telah disalurkan <strong>tidak dapat dikembalikan secara parsial (non-refundable)</strong> berdasarkan durasi penggunaan yang belum genap. Setelah dinonaktifkan, profil bisnis akan dihapus dari portal sesuai prosedur pada kebijakan privasi.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">7. Batasan Tanggung Jawab (Limitation of Liability)</h2>
                <p>Platform SaaS Kelvora disediakan secara eksplisit berbasis pedoman "Sebagaimana Adanya" ("As Is") dan "Sebagaimana Tersedia" ("As Available"). Terlepas dari skenario apapun, pihak manajemen operasional Kelvora tidak akan secara hukum dianggap bertanggung jawab atas segala wujud kerugian langsung atau tak langsung, insidental, atau hal finansial konsekuensial lainnya yang lahir dari kegagalan server sementara, disrupsi layanan, atau ketidakmampuan menggunakan fitur aplikasi secara insidental akibat pemeliharaan operasional.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">8. Perubahan Ketentuan</h2>
                <p>Dari waktu ke waktu, Kelvora memiliki mandat sepihak untuk memperbarui dan memodifikasi ketentuan secara substansial. Saat dilangsungkan perubahan tersebut, kami akan mendedikasikan transparansi penuh baik melalui pesan pemberitahuan banner dasbor maupun surat elektronik kepada para pelanggan aktif untuk mensosialisasikan regulasi anyar tersebut.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">9. Hukum yang Berlaku</h2>
                <p>Setiap Ketentuan Layanan ini termasuk ke dalam ranah domain peradilan serta akan secara ekstensif ditafsirkan berlandaskan aturan Hukum dan Perundang-undangan di Negara Kesatuan Republik Indonesia tanpa bertentangan dengan prinsip-prinsip penegakan hukum lainnya.</p>
            </div>

            <div>
                <h2 class="text-xl font-bold text-slate-900 mb-3 block">10. Kontak Resmi</h2>
                <p>Apabila Anda memiliki kekhawatiran pada kepatuhan aturan yang relevan beserta klausul-klausul di dalamnya, harap layangkan korespondensi ke alamat berikut:</p>
                <div class="mt-4 p-4 bg-slate-50 border border-slate-200 rounded-lg inline-block">
                    <p class="font-medium text-slate-800">Urusan Legal & Kepatuhan: <a href="mailto:legal@kelvora.com" class="text-brand hover:underline">legal@kelvora.com</a></p>
                    <p class="font-medium text-slate-800 mt-1">Korespondensi Umum: cs@kelvora.com</p>
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
