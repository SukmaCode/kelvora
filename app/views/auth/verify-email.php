<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title><?= e($title ?? 'Verifikasi Email') ?> — Kelvora</title>
    <meta name="description" content="Verifikasikan email Anda untuk melanjutkan registrasi akun Kelvora.">
    
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
        
        .otp-input {
            width: 3rem;
            height: 3.5rem;
            text-align: center;
            font-size: 1.5rem;
            font-weight: 700;
        }
        .otp-input::-webkit-outer-spin-button,
        .otp-input::-webkit-inner-spin-button {
            -webkit-appearance: none;
            margin: 0;
        }
        .otp-input[type=number] {
            -moz-appearance: textfield;
        }
    </style>
</head>
<body class="bg-gray-50 text-brandText antialiased">

<div class="flex w-full min-h-screen">

    <!-- ===================== LEFT: BRANDING ===================== -->
    <div class="hidden lg:flex lg:w-1/2 bg-brandBg flex-col justify-center items-center p-12 relative overflow-hidden select-none">
        <div class="max-w-md w-full z-10">
            <!-- Logo -->
            <a href="<?= url('/') ?>" class="mb-6 flex items-center gap-3 group">
                <img src="<?= url('assets/images/logo-biru.png') ?>" alt="Logo" class="w-10 h-10">
                <span class="font-heading text-2xl tracking-tight">Kelvora</span>
            </a>

            <!-- Headline -->
            <h1 class="text-4xl lg:text-5xl font-heading leading-[1.12] mb-6">
                Amankan Akses <br><span class="text-primary">Melalui Email.</span>
            </h1>

            <p class="text-slate-600 font-medium leading-relaxed max-w-sm mb-10">
                Kami memastikan hanya Anda yang memiliki akses penuh ke akun bisnis Anda.
            </p>

            <!-- Feature Checklist -->
            <div class="space-y-4 text-sm font-semibold text-brandText">
                <div class="flex items-center gap-3 bg-white/60 p-3 rounded-xl shadow-sm border border-white">
                    <div class="bg-accent/20 text-teal-700 p-1.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg></div>
                    Dukungan Email Anti-Spam
                </div>
                <div class="flex items-center gap-3 bg-white/60 p-3 rounded-xl shadow-sm border border-white">
                    <div class="bg-accent/20 text-teal-700 p-1.5 rounded-lg"><svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M12 15v2m-6 4h12a2 2 0 002-2v-6a2 2 0 00-2-2H6a2 2 0 00-2 2v6a2 2 0 002 2zm10-10V7a4 4 0 00-8 0v4h8z"/></svg></div>
                    Sandi Hash Modern Berstandar
                </div>
            </div>

        </div>

        <!-- Decorative blobs -->
        <div class="absolute -top-20 -right-20 w-96 h-96 bg-primary/5 rounded-full blur-3xl pointer-events-none"></div>
        <div class="absolute -bottom-20 -left-20 w-96 h-96 bg-brandText/5 rounded-full blur-3xl pointer-events-none"></div>
    </div>

    <!-- ===================== RIGHT: VERIFY FORM ===================== -->
    <div class="w-full lg:w-1/2 flex items-center justify-center p-6 sm:p-12 relative overflow-y-auto">

        <!-- Mobile logo -->
        <a href="<?= url('/') ?>" class="absolute top-6 left-6 lg:hidden flex items-center gap-2">
            <div class="w-8 h-8 bg-primary rounded-lg flex items-center justify-center shadow-sm">
                <span class="text-white font-bold text-sm">⚡</span>
            </div>
            <span class="font-heading text-xl tracking-tight">Kelvora</span>
        </a>

        <div class="w-full max-w-md bg-surface p-8 sm:p-10 rounded-xl shadow-soft fade-up mt-16 md:mt-0 lg:mb-0 mb-10 relative">

            <div id="alertBox" class="hidden absolute top-0 left-0 right-0 z-50 mx-8 mt-4 px-4 py-3 rounded-xl text-sm border font-semibold bg-red-50 border-red-200 text-red-600 shadow-soft">
                <span id="alertMsg"></span>
            </div>
            <div id="successBox" class="hidden absolute top-0 left-0 right-0 z-50 mx-8 mt-4 px-4 py-3 rounded-xl text-sm border font-semibold bg-green-50 border-green-200 text-green-600 shadow-soft">
                <span id="successMsg"></span>
            </div>
            
            <div class="mb-8 text-center">
                <div class="inline-flex items-center justify-center w-14 h-14 bg-primary/10 text-primary rounded-full mb-4">
                    <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24"><path stroke-linecap="round" stroke-linejoin="round" stroke-width="2.5" d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z"/></svg>
                </div>
                <h2 class="text-2xl font-heading mb-2">Verifikasi Email</h2>
                <p class="text-sm text-slate-500 font-medium">
                    Masukkan kode 6 digit yang dikirim ke email <br>
                    <span class="font-bold text-brandText"><?= e($_SESSION['pending_email'] ?? 'Anda') ?></span>
                </p>
            </div>

            <form id="verifyForm" onsubmit="event.preventDefault(); submitVerify();" class="space-y-6">
                <!-- CSRF Token -->
                <?= csrf_field() ?>
                <input type="hidden" name="otp" id="fullOtp" value="">

                <div class="flex justify-between gap-1 sm:gap-2" id="otp-container">
                    <input type="number" autofocus class="otp-input bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-brandText" maxlength="1">
                    <input type="number" class="otp-input bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-brandText" maxlength="1">
                    <input type="number" class="otp-input bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-brandText" maxlength="1">
                    <input type="number" class="otp-input bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-brandText" maxlength="1">
                    <input type="number" class="otp-input bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-brandText" maxlength="1">
                    <input type="number" class="otp-input bg-slate-50 border border-slate-200 rounded-xl focus:border-primary focus:ring-2 focus:ring-primary/20 focus:bg-white transition-all text-brandText" maxlength="1">
                </div>

                <div class="text-center mt-2 text-sm font-semibold text-slate-500" id="timer-container">
                    Kode berlaku <span id="timer" class="text-primary font-bold">04:59</span>
                </div>

                <button type="submit" id="verifyBtn" disabled
                        class="w-full h-[44px] mt-2 flex justify-center items-center gap-2 rounded-xl text-sm font-bold text-white bg-primary hover:bg-secondary focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-primary transition-all disabled:opacity-50 disabled:cursor-not-allowed">
                    <span class="btn-label">Verifikasi Email</span>
                    <div class="spinner hidden"></div>
                </button>
            </form>

            <form onsubmit="event.preventDefault(); submitResend();" class="text-center mt-6 hidden" id="resend-container">
                <button type="submit" id="resendBtn" class="text-sm font-bold text-primary hover:text-secondary transition-colors">
                    Kirim ulang kode OTP
                </button>
            </form>
            
            <div class="text-center mt-4">
                <a href="<?= url('/login') ?>" class="text-sm font-semibold text-slate-400 hover:text-red-500 transition-colors">Ubah Akun Email</a>
            </div>

        </div>

        <div class="absolute bottom-6 text-xs font-bold text-slate-400 hidden lg:block">
            &copy; <?= date('Y') ?> Kelvora. All rights reserved.
        </div>
    </div>
</div>

<script>
    const ACTION_URL = "<?= url() ?>";
    const CSRF_TOKEN = document.querySelector('input[name="csrf_token"]').value;

    let countdown;
    const initialTime = 300; // 5 mins
    
    function startTimer(time) {
        clearInterval(countdown);
        
        if(time <= 0) {
            document.getElementById('timer-container').classList.add('hidden');
            document.getElementById('resend-container').classList.remove('hidden');
            return;
        }

        document.getElementById('timer-container').classList.remove('hidden');
        document.getElementById('resend-container').classList.add('hidden');
        
        countdown = setInterval(() => {
            time--;
            const min = Math.floor(time / 60).toString().padStart(2, '0');
            const sec = (time % 60).toString().padStart(2, '0');
            document.getElementById('timer').innerText = `${min}:${sec}`;
            
            if (time <= 0) {
                clearInterval(countdown);
                document.getElementById('timer-container').classList.add('hidden');
                document.getElementById('resend-container').classList.remove('hidden');
            }
        }, 1000);
    }

    startTimer(initialTime);

    function showError(msg) {
        const box = document.getElementById('alertBox');
        document.getElementById('alertMsg').innerText = msg;
        box.classList.remove('hidden');
        setTimeout(() => box.classList.add('hidden'), 5000);
    }

    function showSuccess(msg) {
        const box = document.getElementById('successBox');
        document.getElementById('successMsg').innerText = msg;
        box.classList.remove('hidden');
        setTimeout(() => box.classList.add('hidden'), 5000);
    }

    const otpInputs = document.querySelectorAll('.otp-input');
    const fullOtpInput = document.getElementById('fullOtp');
    const verifyBtn = document.getElementById('verifyBtn');
    
    function checkOtpFilled() {
        const otpValue = Array.from(otpInputs).map(i => i.value).join('');
        fullOtpInput.value = otpValue;
        verifyBtn.disabled = otpValue.length !== 6;
        if(otpValue.length === 6) {
            submitVerify();
        }
    }

    otpInputs.forEach((input, index) => {
        input.addEventListener('input', (e) => {
            e.target.value = e.target.value.replace(/[^0-9]/g, '');
            if (e.target.value.length > 1) {
                e.target.value = e.target.value.slice(0, 1);
            }
            if (e.target.value !== '' && index < otpInputs.length - 1) {
                otpInputs[index + 1].focus();
            }
            checkOtpFilled();
        });
        
        input.addEventListener('keydown', (e) => {
            if (e.key === 'Backspace' && e.target.value === '' && index > 0) {
                otpInputs[index - 1].focus();
            }
        });
        
        input.addEventListener('paste', (e) => {
            e.preventDefault();
            const pastedData = e.clipboardData.getData('text').replace(/[^0-9]/g, '').slice(0, 6);
            for (let i = 0; i < pastedData.length; i++) {
                if (otpInputs[i]) {
                    otpInputs[i].value = pastedData[i];
                    if (i < otpInputs.length - 1) {
                        otpInputs[i+1].focus();
                    }
                }
            }
            checkOtpFilled();
        });
    });

    function setLoading(btnId, isLoading) {
        const btn = document.getElementById(btnId);
        btn.disabled = isLoading;
        if (isLoading) {
            btn.querySelector('.btn-label').classList.add('hidden');
            btn.querySelector('.spinner').classList.remove('hidden');
        } else {
            btn.querySelector('.btn-label').classList.remove('hidden');
            btn.querySelector('.spinner').classList.add('hidden');
        }
    }

    async function submitVerify() {
        if(fullOtpInput.value.length !== 6) return;
        setLoading('verifyBtn', true);
        
        const formData = new URLSearchParams();
        formData.append('csrf_token', CSRF_TOKEN);
        formData.append('otp', fullOtpInput.value);

        try {
            const res = await fetch(`${ACTION_URL}/auth/verify-email-otp`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });
            
            const data = await res.json();
            if (data.success) {
                showSuccess(data.message);
                setTimeout(() => window.location.href = data.redirect, 1000);
            } else {
                showError(data.message);
                otpInputs.forEach(i => i.value = '');
                otpInputs[0].focus();
            }
        } catch (e) {
            showError("Terjadi kesalahan jaringan.");
        } finally {
            setLoading('verifyBtn', false);
        }
    }

    async function submitResend() {
        const btn = document.getElementById('resendBtn');
        btn.disabled = true;
        btn.innerText = "Mengirim...";

        const formData = new URLSearchParams();
        formData.append('csrf_token', CSRF_TOKEN);

        try {
            const res = await fetch(`${ACTION_URL}/auth/resend-otp`, {
                method: 'POST',
                headers: { 'Content-Type': 'application/x-www-form-urlencoded' },
                body: formData.toString()
            });
            
            const data = await res.json();
            if (data.success) {
                showSuccess(data.message);
                otpInputs.forEach(i => i.value = '');
                otpInputs[0].focus();
                startTimer(initialTime);
            } else {
                showError(data.message);
            }
        } catch (e) {
            showError("Kesalahan jaringan.");
        } finally {
            btn.disabled = false;
            btn.innerText = "Kirim ulang kode OTP";
        }
    }
</script>
</body>
</html>
