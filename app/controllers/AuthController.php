<?php

namespace App\Controllers;

use Core\BaseController;
use Core\EmailHelper;
use App\Models\User;
use App\Models\EmailOtp;

/**
 * Authentication Controller
 * 
 * Handles Email-based OTP Registration and Email+Password Login using AJAX/Fetch.
 */
class AuthController extends BaseController
{
    private User $userModel;
    private EmailOtp $emailOtpModel;

    public function __construct()
    {
        $this->userModel = new User();
        $this->emailOtpModel = new EmailOtp();
    }
    private function validateCsrfAjax(): void
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid CSRF token.'], 403);
        }
    }
    /**
     * Show the Login form.
     */
    public function loginForm(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $this->redirect('home');
        }
        $this->view('auth.login', ['title' => 'Masuk ke Kelvora']);
    }

    /**
     * Show the Registration form.
     */
    public function registerForm(): void
    {
        if (!empty($_SESSION['user_id'])) {
            $this->redirect('home');
        }
        $this->view('auth.register', ['title' => 'Daftar Akun Kelvora']);
    }

    /**
     * Show the OTP Verification form.
     */
    public function showVerify(): void
    {
        if (empty($_SESSION['pending_email'])) {
            $this->redirect('login');
        }
        $this->view('auth.verify-email', ['title' => 'Verifikasi Email']);
    }

    /**
     * Handle Form Submission for Registration (AJAX POST /auth/register)
     */
    public function register(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Method not allowed.'], 405);
        }

         $this->validateCsrfAjax();

        $businessName = trim($this->input('business_name'));
        $name         = trim($this->input('name'));
        $email        = trim(strtolower($this->input('email')));
        $phone        = trim($this->input('phone'));
        $password     = $this->input('password');
        $role         = trim($this->input('role', 'owner'));

        if ($role === 'owner' && empty($businessName)) {
            $this->jsonResponse(['success' => false, 'message' => 'Nama Bisnis wajib diisi.']);
        }
        if (empty($name) || empty($email) || empty($phone) || empty($password)) {
            $this->jsonResponse(['success' => false, 'message' => 'Lengkapi data yang dibutuhkan.']);
        }

        if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $this->jsonResponse(['success' => false, 'message' => 'Format email tidak valid.']);
        }

        if (strlen($password) < 8) {
            $this->jsonResponse(['success' => false, 'message' => 'Password minimal 8 karakter.']);
        }

        // Check unique email and phone
        if ($this->userModel->phoneExists($phone)) {
            $this->jsonResponse(['success' => false, 'message' => 'Nomor HP sudah terdaftar.']);
        }

        $existingUser = $this->userModel->findByEmail($email);
        if ($existingUser) {
            if ($existingUser->email_verified_at !== null) {
                $this->jsonResponse(['success' => false, 'message' => 'Email sudah terdaftar dan terverifikasi. Silakan masuk.']);
            } else {
                // Exists but unverified, update name and password hash
                $this->userModel->update($existingUser->id, [
                    'business_name' => $businessName,
                    'name' => $name,
                    'phone' => $phone,
                    'password_hash' => password_hash($password, PASSWORD_BCRYPT)
                ]);
            }
        } else {
            // Create user
            $this->userModel->create([
                'business_name' => $businessName,
                'name' => $name,
                'email' => $email,
                'phone' => $phone,
                'password_hash' => password_hash($password, PASSWORD_BCRYPT),
                'role' => $role,
                'status' => 'active',
                'email_verified_at' => null
            ]);
        }

        // Generate and Send OTP
        if (!$this->emailOtpModel->canSendOTP($email)) {
            $this->jsonResponse(['success' => false, 'message' => 'Terlalu banyak permintaan OTP. Silakan tunggu beberapa saat.']);
        }

        $plainOtp = $this->emailOtpModel->generate($email);
        $sent = EmailHelper::sendOtp($email, $plainOtp);

        if ($sent) {
            $_SESSION['pending_email'] = $email;
            $this->jsonResponse([
                'success' => true,
                'message' => 'Pendaftaran berhasil. Silakan cek email Anda untuk kode OTP.',
                'redirect' => url('/auth/verify-email') // We tell JS where to redirect
            ]);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Gagal mengirim OTP ke email.']);
        }
    }

    /**
     * Process Email OTP Verification (AJAX POST /auth/verify-email-otp)
     */
    public function verifyEmailOtp(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Method not allowed.'], 405);
        }

        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid CSRF token.'], 403);
        }

        $email = $_SESSION['pending_email'] ?? null;
        $otp = trim($this->input('otp'));

        if (!$email) {
            $this->jsonResponse(['success' => false, 'message' => 'Sesi tidak valid. Silakan ulangi pendaftaran.']);
        }

        if (empty($otp)) {
            $this->jsonResponse(['success' => false, 'message' => 'Kode OTP wajib diisi.']);
        }

        [$isValid, $message, $otpId] = $this->emailOtpModel->verify($email, $otp);

        if (!$isValid) {
            $this->jsonResponse(['success' => false, 'message' => $message]);
        }

        // Valid OTP
        $this->emailOtpModel->markUsed($otpId);

        $user = $this->userModel->findByEmail($email);
        if ($user) {
            $this->userModel->markEmailAsVerified($user->id);
            // Auto login after verification
            $this->loginUser($user);
            unset($_SESSION['pending_email']);
            
            $redirectUrl = $user->role === 'customer' ? url('/') : url('/home');

            $this->jsonResponse([
                'success' => true,
                'message' => 'Email berhasil diverifikasi.',
                'redirect' => $redirectUrl
            ]);
        }

        $this->jsonResponse(['success' => false, 'message' => 'User tidak ditemukan.']);
    }

    /**
     * Resend OTP (AJAX POST /auth/resend-otp)
     */
    public function resendOtp(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Method not allowed.'], 405);
        }

        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid CSRF token.'], 403);
        }

        $email = $_SESSION['pending_email'] ?? $this->input('email'); // Allow manual email if pending_email expired

        if (empty($email)) {
            $this->jsonResponse(['success' => false, 'message' => 'Sesi atau email tidak ditemukan.']);
        }

        if (!$this->emailOtpModel->canSendOTP($email)) {
             $this->jsonResponse(['success' => false, 'message' => 'Terlalu banyak pengiriman OTP. Batas maks 3-5 kali per jam.']);
        }

        $plainOtp = $this->emailOtpModel->generate($email);
        $sent = EmailHelper::sendOtp($email, $plainOtp);

        if ($sent) {
            $_SESSION['pending_email'] = $email;
            $this->jsonResponse(['success' => true, 'message' => 'Kode OTP baru telah dikirimkan ke email Anda.']);
        } else {
            $this->jsonResponse(['success' => false, 'message' => 'Gagal mengirim email OTP.']);
        }
    }

    /**
     * Handle Login (AJAX POST /auth/login)
     */
    public function login(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Method not allowed.'], 405);
        }

        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid CSRF token.'], 403);
        }

        $email = trim(strtolower($this->input('email')));
        $password = $this->input('password');

        if (empty($email) || empty($password)) {
            $this->jsonResponse(['success' => false, 'message' => 'Email dan password wajib diisi.']);
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !password_verify($password, $user->password_hash)) {
            $this->jsonResponse(['success' => false, 'message' => 'Email atau Password salah.']);
        }

        // Check verification
        if ($user->email_verified_at === null) {
            // Inform frontend to show "Resend OTP" option
            $_SESSION['pending_email'] = $email; // Important for resend to work smoothly
            $this->jsonResponse([
                'success' => false, 
                'message' => 'Email Anda belum diverifikasi. Harap selesaikan verifikasi terlebih dahulu.',
                'unverified' => true
            ]);
        }

        if ($user->status !== 'active') {
            $this->jsonResponse(['success' => false, 'message' => 'Akun Anda sedang tidak aktif.']);
        }

        $this->loginUser($user);
        
        $redirectUrl = $user->role === 'customer' ? url('/') : url('/home');
        
        $this->jsonResponse([
            'success' => true,
            'redirect' => $redirectUrl
        ]);
    }

    public function logout(): void
    {
        unset($_SESSION['user_id']);
        unset($_SESSION['name']);
        unset($_SESSION['email']);
        unset($_SESSION['user_role']);
        session_destroy();
        
        $this->redirect('');
    }

    private function loginUser(object $user): void
    {
        session_regenerate_id(true);

        $_SESSION['user_id'] = $user->id;
        $_SESSION['name'] = $user->name; 
        $_SESSION['business_name'] = $user->business_name;
        $_SESSION['email'] = $user->email;
        $_SESSION['phone'] = $user->phone;
        $_SESSION['user_role'] = $user->role;
    }

    protected function view(string $view, array $data = []): void
    {
        $viewPath = str_replace('.', '/', $view);
        $viewFile = BASE_PATH . '/app/views/' . $viewPath . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View [{$view}] not found at [{$viewFile}].");
        }

        $this->generateCsrfToken();

        extract($data);
        require $viewFile;
    }
}
