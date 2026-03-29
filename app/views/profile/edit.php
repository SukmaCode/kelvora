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
<div class="max-w-3xl mx-auto">

    <!-- Profile Header Card -->
    <div class="bg-card rounded-xl border border-border p-6 sm:p-8 mb-6">
        <div class="flex flex-col sm:flex-row items-center gap-6">
            
            <!-- Avatar Section -->
            <div class="flex flex-col items-center sm:items-start gap-3">
                <div class="relative w-24 h-24 sm:w-28 sm:h-28 rounded-full border-4 border-card shadow-lg bg-accent flex items-center justify-center text-white font-bold text-3xl flex-shrink-0 overflow-hidden group">
                    <?php if (!empty($user->profile_image)): ?>
                        <img src="<?= url('public/uploads/profile/' . $user->profile_image) ?>" alt="Profile" class="w-full h-full object-cover">
                    <?php else: ?>
                        <?= e($initials) ?>
                    <?php endif; ?>
                    
                    <!-- Overlay Upload -->
                    <label for="profile_upload" class="absolute inset-0 bg-black/50 flex flex-col items-center justify-center opacity-0 group-hover:opacity-100 transition-opacity cursor-pointer">
                        <svg class="w-6 h-6 text-white mb-1" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 9a2 2 0 012-2h.93a2 2 0 001.664-.89l.812-1.22A2 2 0 0110.07 4h3.86a2 2 0 011.664.89l.812 1.22A2 2 0 0018.07 7H19a2 2 0 012 2v9a2 2 0 01-2 2H5a2 2 0 01-2-2V9z"></path><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 13a3 3 0 11-6 0 3 3 0 016 0z"></path></svg>
                        <span class="text-[10px] font-medium text-white">Ganti</span>
                    </label>
                </div>
                
                <?php if (!empty($user->profile_image)): ?>
                <form action="<?= url('/profile/delete-photo') ?>" method="POST" onsubmit="return confirm('Yakin ingin menghapus foto profil?');">
                    <?= csrf_field() ?>
                    <button type="submit" class="text-xs text-red-400 hover:text-red-300 transition-colors font-medium">Hapus Foto</button>
                </form>
                <?php endif; ?>
            </div>

            <!-- Hidden Form for Upload -->
            <form id="uploadForm" action="<?= url('/profile/upload-photo') ?>" method="POST" enctype="multipart/form-data" class="hidden">
                <?= csrf_field() ?>
                <input type="file" id="profile_upload" name="profile_image" accept="image/jpeg,image/png,image/webp">
                <input type="hidden" id="crop_data" name="crop_data">
            </form>

            <!-- Info -->
            <div class="text-center sm:text-left">
                <h2 class="text-xl font-bold text-slate-100"><?= e($user->name ?? '') ?></h2>
                <p class="text-sm text-slate-400 mt-1"><?= e($user->business_name ?? '') ?></p>
                <div class="flex items-center gap-3 mt-3 justify-center sm:justify-start">
                    <span class="inline-flex items-center gap-1.5 text-xs font-semibold px-2.5 py-1 rounded-full <?= $user->status === 'active' ? 'bg-green-500/10 text-green-400 border border-green-500/20' : 'bg-red-500/10 text-red-400 border border-red-500/20' ?>">
                        <span class="w-1.5 h-1.5 rounded-full <?= $user->status === 'active' ? 'bg-green-400' : 'bg-red-400' ?>"></span>
                        <?= $user->status === 'active' ? 'Aktif' : 'Tidak Aktif' ?>
                    </span>
                    <span class="text-xs text-slate-500 font-medium capitalize"><?= e($user->role) ?></span>
                </div>
            </div>
        </div>
    </div>

    <!-- Edit Form Card -->
    <div class="bg-card rounded-xl border border-border p-6 sm:p-8">
        <div class="mb-6">
            <h3 class="text-lg font-bold text-slate-100">Informasi Akun</h3>
            <p class="text-sm text-slate-500 mt-1">Perbarui data bisnis dan akun Anda</p>
        </div>

        <form action="<?= url('/profile/update') ?>" method="POST" class="space-y-6">
            <?= csrf_field() ?>

            <!-- Row 1: Nama Bisnis + Nama Lengkap -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <?php if ($user->role === 'owner'): ?>
                <div>
                    <label for="business_name" class="block text-sm font-medium text-slate-300 mb-2">Nama Bisnis</label>
                    <input type="text" id="business_name" name="business_name"
                           value="<?= old('business_name', e($user->business_name ?? '')) ?>"
                           required
                           class="w-full px-4 py-3 bg-input border <?= !empty($errors['business_name']) ? 'border-red-500' : 'border-border' ?> rounded-lg text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                           placeholder="Toko Kelvora">
                    <?php if (!empty($errors['business_name'])): ?>
                        <p class="text-xs text-red-400 mt-1.5"><?= e($errors['business_name']) ?></p>
                    <?php endif; ?>
                </div>
                <?php else: ?>
                <div class="hidden">
                    <input type="hidden" name="business_name" value="<?= e($user->business_name ?? '') ?>">
                </div>
                <?php endif; ?>

                <div class="<?= $user->role !== 'owner' ? 'sm:col-span-2' : '' ?>">
                    <label for="name" class="block text-sm font-medium text-slate-300 mb-2">Nama Lengkap</label>
                    <input type="text" id="name" name="name"
                           value="<?= old('name', e($user->name ?? '')) ?>"
                           required
                           class="w-full px-4 py-3 bg-input border <?= !empty($errors['name']) ? 'border-red-500' : 'border-border' ?> rounded-lg text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                           placeholder="Budi Santoso">
                    <?php if (!empty($errors['name'])): ?>
                        <p class="text-xs text-red-400 mt-1.5"><?= e($errors['name']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Row 2: Email + WhatsApp -->
            <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                <div>
                    <label for="email" class="block text-sm font-medium text-slate-300 mb-2">Email</label>
                    <input type="email" id="email" name="email"
                           value="<?= old('email', e($user->email ?? '')) ?>"
                           required
                           class="w-full px-4 py-3 bg-input border <?= !empty($errors['email']) ? 'border-red-500' : 'border-border' ?> rounded-lg text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                           placeholder="nama@bisnis.com">
                    <?php if (!empty($errors['email'])): ?>
                        <p class="text-xs text-red-400 mt-1.5"><?= e($errors['email']) ?></p>
                    <?php endif; ?>
                </div>

                <div>
                    <label for="phone" class="block text-sm font-medium text-slate-300 mb-2">Nomor WhatsApp</label>
                    <input type="tel" id="phone" name="phone"
                           value="<?= old('phone', e($user->phone ?? '')) ?>"
                           required
                           class="w-full px-4 py-3 bg-input border <?= !empty($errors['phone']) ? 'border-red-500' : 'border-border' ?> rounded-lg text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                           placeholder="08123456789">
                    <?php if (!empty($errors['phone'])): ?>
                        <p class="text-xs text-red-400 mt-1.5"><?= e($errors['phone']) ?></p>
                    <?php endif; ?>
                </div>
            </div>

            <!-- Change Password Section -->
            <div class="border-t border-border pt-6">
                <h4 class="text-sm font-bold text-slate-300 mb-1">Ubah Password</h4>
                <p class="text-xs text-slate-500 mb-4">Kosongkan jika tidak ingin mengubah password</p>

                <div class="grid grid-cols-1 sm:grid-cols-2 gap-6">
                    <div>
                        <label for="password" class="block text-sm font-medium text-slate-300 mb-2">Password Baru</label>
                        <div class="relative">
                            <input type="password" id="password" name="password"
                                   class="w-full px-4 py-3 pr-11 bg-input border <?= !empty($errors['password']) ? 'border-red-500' : 'border-border' ?> rounded-lg text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                                   placeholder="Min. 6 karakter">
                            <button type="button" onclick="togglePwd('password', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-300 transition-colors" aria-label="Tampilkan password">
                                <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                        <?php if (!empty($errors['password'])): ?>
                            <p class="text-xs text-red-400 mt-1.5"><?= e($errors['password']) ?></p>
                        <?php endif; ?>
                    </div>

                    <div>
                        <label for="password_confirmation" class="block text-sm font-medium text-slate-300 mb-2">Konfirmasi Password</label>
                        <div class="relative">
                            <input type="password" id="password_confirmation" name="password_confirmation"
                                   class="w-full px-4 py-3 pr-11 bg-input border border-border rounded-lg text-slate-200 focus:outline-none focus:ring-2 focus:ring-accent focus:border-transparent transition-all placeholder-slate-500"
                                   placeholder="Ulangi password baru">
                            <button type="button" onclick="togglePwd('password_confirmation', this)" class="absolute inset-y-0 right-0 pr-3 flex items-center text-slate-500 hover:text-slate-300 transition-colors" aria-label="Tampilkan konfirmasi password">
                                <svg class="eye-open w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M15 12a3 3 0 11-6 0 3 3 0 016 0z"/><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M2.458 12C3.732 7.943 7.523 5 12 5c4.478 0 8.268 2.943 9.542 7-1.274 4.057-5.064 7-9.542 7-4.477 0-8.268-2.943-9.542-7z"/></svg>
                                <svg class="eye-closed w-5 h-5 hidden" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M13.875 18.825A10.05 10.05 0 0112 19c-4.478 0-8.268-2.943-9.543-7a9.97 9.97 0 011.563-3.029m5.858.908a3 3 0 114.243 4.243M9.878 9.878l4.242 4.242M9.88 9.88l-3.29-3.29m7.532 7.532l3.29 3.29M3 3l3.59 3.59m0 0A9.953 9.953 0 0112 5c4.478 0 8.268 2.943 9.543 7a10.025 10.025 0 01-4.132 5.411m0 0L21 21"/></svg>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Actions -->
            <div class="flex flex-col sm:flex-row items-center gap-3 pt-4 border-t border-border">
                <button type="submit"
                        class="w-full sm:w-auto px-8 py-3 bg-accent hover:bg-accent-hover text-white font-medium rounded-lg transition-all focus:outline-none focus:ring-2 focus:ring-accent focus:ring-offset-2 focus:ring-offset-dark text-sm">
                    Simpan Perubahan
                </button>
                <a href="<?= url('/home') ?>"
                   class="w-full sm:w-auto px-8 py-3 text-center border border-border text-slate-400 hover:text-slate-200 hover:border-slate-500 font-medium rounded-lg transition-all text-sm">
                    Kembali ke Dashboard
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
            <button type="button" onclick="closeCropModal()" class="px-4 py-2 border border-border text-slate-300 rounded hover:bg-slate-800 transition-colors text-sm font-medium">Batal</button>
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
