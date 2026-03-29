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
                            
                            <?php if ($product->stock > 0): ?>
                                <button onclick="checkoutProduct(<?= $product->id ?>, '<?= e(addslashes($product->name)) ?>', <?= $product->price ?>, <?= $product->stock ?>, this)" class="w-full flex items-center justify-center gap-2 h-10 bg-primary/10 text-primary hover:bg-primary hover:text-white rounded-xl font-semibold text-sm transition-colors border border-primary/20 hover:border-primary">
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 3h2l.4 2M7 13h10l4-8H5.4M7 13L5.4 5M7 13l-2.293 2.293c-.63.63-.184 1.707.707 1.707H17m0 0a2 2 0 100 4 2 2 0 000-4zm-8 2a2 2 0 11-4 0 2 2 0 014 0z"/></svg>
                                    Pesan Sekarang
                                </button>
                            <?php else: ?>
                                <button disabled class="w-full flex items-center justify-center gap-2 h-10 bg-gray-100 text-gray-400 rounded-xl font-semibold text-sm cursor-not-allowed">
                                    Stok Habis
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                <?php endforeach; ?>
            </div>
        <?php endif; ?>
    </div>

    <!-- UI Modal Checkout -->
    <div id="checkoutModal" class="fixed inset-0 z-[100] items-center justify-center p-4 bg-black/50 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-floating w-full max-w-md overflow-hidden transform scale-95 transition-transform duration-300" id="checkoutModalContent">
            <div class="px-6 py-4 border-b border-gray-100 flex justify-between items-center bg-gray-50/50">
                <h3 class="font-bold text-lg text-gray-900">Rincian Pemesanan</h3>
                <button onclick="closeCheckoutModal()" class="text-gray-400 hover:text-gray-600 transition-colors">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
                </button>
            </div>
            <div class="p-6">
                <!-- Product Detail -->
                <div class="mb-4">
                    <p class="text-sm font-semibold text-gray-500 mb-1 uppercase tracking-wide">Produk</p>
                    <p class="font-bold text-gray-900 text-lg" id="modalProductName">-</p>
                    <p class="text-sm text-gray-500 mt-1">Sisa Stok: <span id="modalProductStock" class="font-semibold text-gray-700">0</span></p>
                </div>

                <!-- Quantity -->
                <div class="mb-6 flex items-center justify-between bg-gray-50 rounded-xl p-4 border border-gray-100">
                    <span class="text-sm font-semibold text-gray-700">Jumlah Pesanan</span>
                    <div class="flex items-center gap-3">
                        <button type="button" onclick="updateQuantity(-1)" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 shadow-sm hover:bg-gray-100 transition-colors">-</button>
                        <span id="modalQuantity" class="font-bold text-gray-900 w-6 text-center">1</span>
                        <button type="button" onclick="updateQuantity(1)" class="w-8 h-8 rounded-full bg-white border border-gray-200 flex items-center justify-center text-gray-600 shadow-sm hover:bg-gray-100 transition-colors">+</button>
                    </div>
                </div>
                
                <!-- Pricing Breakdown -->
                <div class="bg-gray-50 rounded-xl p-4 border border-gray-100 mb-6">
                    <div class="flex justify-between items-center">
                        <span class="font-bold text-gray-900">Total Harga</span>
                        <span class="font-bold text-xl text-primary" id="modalTotalPrice">-</span>
                    </div>
                    <p class="text-xs text-gray-400 mt-1">*Harga sudah termasuk biaya admin platform.</p>
                </div>

                <div class="flex gap-3">
                    <button onclick="cancelCheckout()" class="flex-1 py-3 px-4 rounded-xl font-bold text-gray-600 bg-gray-100 hover:bg-gray-200 transition-colors text-sm">Batal</button>
                    <button id="btnProceedQRIS" class="flex-1 py-3 px-4 rounded-xl font-bold text-white bg-primary hover:bg-secondary transition-colors text-sm shadow-soft">Konfirmasi</button>
                </div>
            </div>
        </div>
    </div>

    <!-- QRIS Modal -->
    <div id="qrisModal" class="fixed inset-0 z-[110] items-center justify-center p-4 bg-black/50 backdrop-blur-sm hidden opacity-0 transition-opacity duration-300">
        <div class="bg-white rounded-2xl shadow-floating w-full max-w-sm overflow-hidden transform scale-95 transition-transform duration-300 text-center relative" id="qrisModalContent">
            <button onclick="closeQrisModal()" class="absolute top-4 right-4 text-gray-400 hover:text-gray-600 transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
            <div class="p-8 pb-6 bg-red-500/5">
                <img src="<?= url('public/assets/images/logo-biru.png') ?>" alt="QRIS" class="w-12 h-12 mx-auto mb-3">
                <h3 class="font-bold text-xl text-gray-900">Scan QRIS</h3>
                <p class="text-sm text-gray-500 mt-1">Silakan lakukan pembayaran melalui QRIS di bawah ini sejumlah <strong id="qrisTotalDisplay" class="text-primary">-</strong></p>
                
                <div class="mt-6 bg-white p-4 rounded-xl shadow-sm border border-gray-200 inline-block">
                    <!-- Placeholder QRIS Barcode -->
                    <div class="w-48 h-48 bg-gray-100 rounded-lg flex flex-col items-center justify-center border-2 border-dashed border-gray-300 mx-auto">
                        <span class="text-4xl mb-2">📱</span>
                        <span class="text-xs font-semibold text-gray-400">QRIS STATIS</span>
                    </div>
                </div>
            </div>

            <div class="p-6 pt-2">
                <button id="btnConfirmPaid" class="w-full py-3.5 px-4 rounded-xl font-bold text-white bg-[#0f766e] hover:bg-teal-800 transition-colors text-[15px] shadow-soft flex items-center justify-center gap-2">
                    <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path></svg>
                    Saya Sudah Bayar
                </button>
            </div>
        </div>
    </div>
</section>

<!-- Checkout Modal/Logic -->
<script>
    let currentCheckoutData = null;
    let currentQuantity = 1;

    function formatRupiahJs(number) {
        return new Intl.NumberFormat('id-ID', { style: 'currency', currency: 'IDR', minimumFractionDigits: 0 }).format(number);
    }

    function updateTotal() {
        if (!currentCheckoutData) return;
        const basePrice = currentCheckoutData.price;
        const total = (basePrice * currentQuantity) + 1000;
        document.getElementById('modalTotalPrice').innerText = formatRupiahJs(total);
        document.getElementById('qrisTotalDisplay').innerText = formatRupiahJs(total);
    }

    function updateQuantity(amount) {
        if (!currentCheckoutData) return;
        const newQty = currentQuantity + amount;
        if (newQty >= 1 && newQty <= currentCheckoutData.stock) {
            currentQuantity = newQty;
            document.getElementById('modalQuantity').innerText = currentQuantity;
            updateTotal();
        }
    }

    function checkoutProduct(productId, productName, productPrice, productStock, btnElement) {
        currentCheckoutData = {
            id: productId,
            name: productName,
            price: parseInt(productPrice),
            stock: parseInt(productStock),
            btn: btnElement
        };
        currentQuantity = 1;

        // Populate Modal
        document.getElementById('modalProductName').innerText = productName;
        document.getElementById('modalQuantity').innerText = currentQuantity;
        document.getElementById('modalProductStock').innerText = productStock;
        
        updateTotal();

        // Show Modal
        const modal = document.getElementById('checkoutModal');
        const modalContent = document.getElementById('checkoutModalContent');
        
        modal.classList.remove('hidden');
        modal.classList.add('flex');
        // Trigger generic animation
        setTimeout(() => {
            modal.classList.remove('opacity-0');
            modalContent.classList.remove('scale-95');
        }, 10);
    }

    function closeCheckoutModal() {
        const modal = document.getElementById('checkoutModal');
        const modalContent = document.getElementById('checkoutModalContent');
        
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
        }, 300);
    }

    function cancelCheckout() {
        closeCheckoutModal();
        setTimeout(() => {
                currentCheckoutData = null;
        }, 300);
    }

    document.getElementById('btnProceedQRIS').addEventListener('click', function() {
        if (!currentCheckoutData) return;
        closeCheckoutModal();
        
        // Show QRIS Modal
        setTimeout(() => {
            const modal = document.getElementById('qrisModal');
            const modalContent = document.getElementById('qrisModalContent');
            
            modal.classList.remove('hidden');
            modal.classList.add('flex');
            setTimeout(() => {
                modal.classList.remove('opacity-0');
                modalContent.classList.remove('scale-95');
            }, 10);
        }, 300);
    });

    function closeQrisModal() {
        const modal = document.getElementById('qrisModal');
        const modalContent = document.getElementById('qrisModalContent');
        
        modal.classList.add('opacity-0');
        modalContent.classList.add('scale-95');
        
        setTimeout(() => {
            modal.classList.add('hidden');
            modal.classList.remove('flex');
            currentCheckoutData = null;
        }, 300);
    }

    document.getElementById('btnConfirmPaid').addEventListener('click', function() {
        if (!currentCheckoutData) return;
        
        const { id, btn } = currentCheckoutData;
        const btnElement = this;
        
        const originalText = btnElement.innerHTML;
        btnElement.innerHTML = '<span class="animate-pulse flex items-center justify-center gap-2"><svg class="animate-spin h-4 w-4 text-white" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24"><circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle><path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path></svg> Memproses...</span>';
        btnElement.disabled = true;

        const formData = new URLSearchParams();
        formData.append('product_id', id);
        formData.append('quantity', currentQuantity);
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
            closeQrisModal();
        });
    });
</script>
