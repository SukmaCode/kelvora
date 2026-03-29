<?php
    // Generate initials
    $displayName = $user->name ?? $user->business_name ?? 'U';
    $nameParts = explode(' ', trim($displayName));
    $initials = strtoupper(substr($nameParts[0], 0, 1));
    if (count($nameParts) > 1) {
        $initials .= strtoupper(substr(end($nameParts), 0, 1));
    }

    // Get validation errors
    $errors = $_SESSION['errors'] ?? [];
?>

<!-- Include Cropper.js -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.css" rel="stylesheet">
<script src="https://cdnjs.cloudflare.com/ajax/libs/cropperjs/1.5.13/cropper.min.js"></script>

<!-- Profile Edit Page -->
<div class="max-w-xl mx-auto h-screen">

    <!-- Edit Form Card -->
    <div class="bg-white rounded-xl border border-border p-6 sm:p-8">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-black">Informasi Akun</h3>
            <p class="text-sm text-slate-500 mt-1">Perbarui data bisnis dan akun Anda</p>
        </div>

        <form action="<?= url('/profile/update') ?>" method="POST" class="space-y-2">
            <?= csrf_field() ?>

            <!-- Row 1: Nama Lengkap -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div class="<?= $user->role !== 'owner' ? 'sm:col-span-2' : '' ?>">
                    <label for="name" class="block text-sm font-medium text-black mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                           value="<?= old('name', e($user->name ?? '')) ?>"
                           required
                           class="w-full px-4 py-2 bg-white border <?= !empty($errors['name']) ? 'border-red-500' : 'border-border' ?> rounded-md text-black focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-black"
                           placeholder="Budi Santoso">
                    <?php if (!empty($errors['name'])): ?>
                        <p class="text-xs text-red-400 mt-1.5"><?= e($errors['name']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Row 2: Email + WhatsApp -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-2">
                <div>
                    <label for="email" class="block text-sm font-medium text-black mb-2">Email</label>
                    <input type="email" id="email" name="email"
                           value="<?= old('email', e($user->email ?? '')) ?>"
                           required
                           class="w-full px-4 py-2 bg-white border <?= !empty($errors['email']) ? 'border-red-500' : 'border-border' ?> rounded-md text-black focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                           placeholder="nama@bisnis.com">
                    <?php if (!empty($errors['email'])): ?>
                        <p class="text-xs text-red-400 mt-1.5"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-black mb-2">Nomor WhatsApp</label>
                    <input type="tel" id="phone" name="phone"
                           value="<?= old('phone', e($user->phone ?? '')) ?>"
                           required
                           class="w-full px-4 py-2 bg-white border <?= !empty($errors['phone']) ? 'border-red-500' : 'border-border' ?> rounded-md text-black focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                           placeholder="08123456789">
                    <?php if (!empty($errors['phone'])): ?>
                        <p class="text-xs text-red-400 mt-1.5"><?= e($errors['phone']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Change Password Section -->
            <div>
                <h4 class="text-sm font-bold text-black mb-1">Ubah Password</h4>
                <p class="text-xs text-slate-500 mb-4">Kosongkan jika tidak ingin mengubah password</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-black mb-2">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-2 pr-11 bg-white border <?= !empty($errors['password']) ? 'border-red-500' : 'border-border' ?> rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                                   placeholder="Min. 6 karakter">
                            <button type="button" onclick="togglePwd('password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-black transition-colors" aria-label="Tampilkan password">
                                <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        <?php if (!empty($errors['password'])): ?>
                            <p class="text-xs text-red-400 mt-1.5"><?= e($errors['password']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-black mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="w-full px-4 py-2 pr-11 bg-white border border-border rounded-lg text-black focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                                   placeholder="Ulangi password baru">
                            <button type="button" onclick="togglePwd('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-black transition-colors" aria-label="Tampilkan konfirmasi password">
                                <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center gap-3 pt-4">
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-2 bg-[#2d3bd9] hover:bg-accent-hover text-white font-medium rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-dark text-sm">
                    Simpan Perubahan
                </button>
                <a href="<?= url('/home') ?>"
                   class="w-full sm:w-auto px-8 py-2 text-center border border-border text-slate-400 hover:text-black hover:border-slate-500 font-medium rounded-lg transition-all text-sm">
                    Kembali
                </a>
            </div>
        </form>
    </div>
</div>

<!-- Modal for Crop Image -->
<div id="cropModal" class="fixed inset-0 z-[110] hidden bg-black/80 items-center justify-center p-4">
    <div class="bg-card rounded-xl border border-border w-full max-w-lg overflow-hidden shadow-2xl flex flex-col">
        <div class="p-4 border-b border-border flex justify-between items-center bg-card">
            <h3 class="text-white font-semibold">Sesuaikan Foto</h3>
            <button type="button" onclick="closeCropModal()" class="text-slate-400 hover:text-white transition-colors">
                <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path></svg>
            </button>
        </div>
        <div class="p-4 bg-black flexItems-center justify-center relative min-h-[300px] max-h-[60vh] overflow-hidden">
            <img id="imageToCrop" src="" alt="To Crop" class="max-w-full block">
        </div>
        <div class="p-4 border-t border-border bg-card flex justify-end gap-3">
            <button type="button" onclick="closeCropModal()" class="px-4 py-2 border border-border text-black rounded hover:bg-slate-800 transition-colors text-sm font-medium">Batal</button>
            <button type="button" onclick="submitCrop()" class="px-4 py-2 bg-accent text-white rounded hover:bg-accent-hover transition-colors text-sm font-medium">Terapkan & Simpan</button>
        </div>
    </div>
</div>

<script>
// Password toggle
function togglePwd(inputId, btn) {
    const input = document.getElementById(inputId);
    const isHidden = input.type === 'password';
    input.type = isHidden ? 'text' : 'password';
    btn.querySelector('.eye-open').classList.toggle('hidden', isHidden);
    btn.querySelector('.eye-closed').classList.toggle('hidden', !isHidden);
}

// Image Cropper Logic
let cropper = null;
const fileInput = document.getElementById('profile_upload');
const cropModal = document.getElementById('cropModal');
const imageToCrop = document.getElementById('imageToCrop');
const uploadForm = document.getElementById('uploadForm');
const cropDataInput = document.getElementById('crop_data');

fileInput.addEventListener('change', function(e) {
    if (e.target.files && e.target.files.length > 0) {
        let file = e.target.files[0];
        
        // Validation size (2MB) inside client
        if (file.size > 2 * 1024 * 1024) {
            alert('Ukuran file maksimal 2MB.');
            fileInput.value = '';
            return;
        }

        // Validate type
        if (!['image/jpeg', 'image/png', 'image/webp'].includes(file.type)) {
            alert('Format tidak didukung. Harap upload gambar JPG, PNG, atau WebP.');
            fileInput.value = '';
            return;
        }

        let reader = new FileReader();
        reader.onload = function(event) {
            imageToCrop.src = event.target.result;
            cropModal.classList.remove('hidden');
            cropModal.classList.add('flex');
            
            // Initialize cropper after image loads
            if (cropper) {
                cropper.destroy();
            }
            
            cropper = new Cropper(imageToCrop, {
                aspectRatio: 1, // 1:1 like instagram
                viewMode: 1, // Restrict crop box to not exceed the canvas
                dragMode: 'move',
                autoCropArea: 0.9,
                guides: false,
                center: true,
                highlight: false,
                cropBoxMovable: true,
                cropBoxResizable: true,
                toggleDragModeOnDblclick: false,
            });
        };
        reader.readAsDataURL(file);
    }
});

function closeCropModal() {
    cropModal.classList.add('hidden');
    cropModal.classList.remove('flex');
    if (cropper) {
        cropper.destroy();
        cropper = null;
    }
    fileInput.value = ''; // Reset file input
}

function submitCrop() {
    if (!cropper) return;
    
    // Get crop data
    const data = cropper.getData();
    cropDataInput.value = JSON.stringify({
        x: data.x,
        y: data.y,
        width: data.width,
        height: data.height
    });
    
    // Submit form visually showing process
    document.body.style.cursor = 'wait';
    uploadForm.submit();
}
</script>
