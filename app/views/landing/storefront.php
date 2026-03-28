<section class="pt-28 pb-24 overflow-hidden relative min-h-screen">
    <div class="container-custom relative z-10">
        <div class="flex flex-col md:flex-row items-end md:items-center justify-between mb-8 pb-6 border-b border-txtmain/10 gap-4">
            <div>
                <h1 class="text-3xl font-heading text-txtmain">Katalog Produk</h1>
                <p class="text-txtmain/60 mt-1">Temukan produk terbaik dari partner UMKM Kelvora.</p>
            </div>
        </div>

        <?php if (empty($products)): ?>
            <div class="bg-white rounded-2xl p-10 text-center shadow-soft border border-txtmain/5">
                <div class="w-16 h-16 bg-primary/10 text-primary rounded-full flex items-center justify-center mx-auto mb-4 text-2xl">📦</div>
                <h3 class="font-heading text-xl mb-2">Belum Ada Produk</h3>
                <p class="text-txtmain/60 text-sm">Saat ini belum ada produk yang tersedia. Silakan cek kembali nanti.</p>
            </div>
        <?php else: ?>
            <div class="grid grid-cols-2 sm:grid-cols-3 lg:grid-cols-5 gap-6">
                <?php foreach ($products as $product): ?>
                    <div class="bg-surface rounded-2xl shadow-soft border border-txtmain/5 overflow-hidden flex flex-col group hover:shadow-floating transition-all">
                        <div class="aspect-square bg-slate-100 flex items-center justify-center relative overflow-hidden">
                            <?php if (!empty($product->image_url)): ?>
                                <img src="<?= url($product->image_url) ?>" alt="<?= e($product->name) ?>" class="w-full h-full object-cover group-hover:scale-105 transition-transform duration-500">
                            <?php else: ?>
                                <span class="text-4xl opacity-50">🛍️</span>
                            <?php endif; ?>
                            <div class="absolute top-3 left-3 bg-white/90 backdrop-blur-sm px-2.5 py-1 rounded-lg text-xs font-bold shadow-sm">
                                <?= e($product->business_name) ?>
                            </div>
                        </div>
                        <div class="p-5 flex flex-col flex-1">
                            <h3 class="font-heading text-lg leading-tight mb-1 text-txtmain line-clamp-2" title="<?= e($product->name) ?>"><?= e($product->name) ?></h3>
                            <p class="text-primary font-bold mb-3 mt-1">Rp <?= number_format($product->price, 0, ',', '.') ?></p>
                            <p class="text-sm text-txtmain/60 mb-5 line-clamp-2 flex-1" title="<?= e($product->description) ?>"><?= e($product->description ?: 'Tidak ada deskripsi.') ?></p>
                            
                            <button onclick="checkoutProduct(<?= $product->id ?>, '<?= e(addslashes($product->name)) ?>', this)" class="w-full flex items-center justify-center gap-2 h-10 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl font-semibold text-sm transition-colors border border-primary/20 hover:border-primary">
                                <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                Pesan Sekarang
                            </button>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>
</section>

<!-- Checkout Modal/Logic -->
<script>
    function checkoutProduct(productId, productName, btnElement) {
        if (!confirm('Apakah Anda yakin ingin memesan produk "' + productName + '"?')) {
            return;
        }

        const originalText = btnElement.innerHTML;
        btnElement.innerHTML = '<span class="animate-pulse flex items-center gap-2"><svg class="animate-spin h-4 w-4 text-current" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...</span>';
        btnElement.disabled = true;

        const formData = new URLSearchParams();
        formData.append('product_id', productId);
        formData.append('csrf_token', '<?= $_SESSION['csrf_token'] ?? '' ?>');

        fetch('<?= url('order/checkout') ?>', {
            method: 'POST',
            headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
            body: formData.toString()
        })
        .then(res => res.json())
        .then(data => {
            if (data.success) {
                alert('Sukses: ' + data.message);
            } else {
                alert('Gagal: ' + data.message);
                if (data.redirect) {
                    window.location.href = data.redirect;
                }
            }
        })
        .catch(err => {
            console.error(err);
            alert('Terjadi kesalahan jaringan.');
        })
        .finally(() => {
            btnElement.innerHTML = originalText;
            btnElement.disabled = false;
        });
    }
</script>
