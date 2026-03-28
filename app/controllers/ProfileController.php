<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\User;

/**
 * Profile Controller
 * 
 * Handles user profile viewing and editing.
 */
class ProfileController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Show the profile edit form.
     */
    public function edit(): void
    {
        $this->requireAuth();

        $user = $this->userModel->findById($_SESSION['user_id']);

        if (!$user) {
            $this->setFlash('danger', 'User tidak ditemukan.');
            $this->redirect('');
        }

        $this->view('profile.edit', [
            'title' => 'Edit Profil',
            'user'  => $user,
        ]);
    }

    /**
     * Process the profile update.
     */
    public function update(): void
    {
        $this->requireAuth();

        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('profile');
        }

        $this->validateCsrfToken();

        $userId = $_SESSION['user_id'];
        $user = $this->userModel->findById($userId);

        if (!$user) {
            $this->setFlash('danger', 'User tidak ditemukan.');
            $this->redirect('');
        }

        // Collect input
        $businessName = trim($this->input('business_name'));
        $ownerName    = trim($this->input('owner_name'));
        $email        = trim($this->input('email'));
        $phone        = trim($this->input('phone'));
        $password     = $this->input('password');
        $confirmation = $this->input('password_confirmation');

        // Store old input
        $_SESSION['old_input'] = [
            'business_name' => $businessName,
            'owner_name'    => $ownerName,
            'email'         => $email,
            'phone'         => $phone,
        ];

        // Validate
        $errors = [];

        if (empty($businessName)) {
            $errors['business_name'] = 'Nama bisnis wajib diisi.';
        }
        if (empty($ownerName)) {
            $errors['owner_name'] = 'Nama owner wajib diisi.';
        }
        if (empty($email) || !filter_var($email, FILTER_VALIDATE_EMAIL)) {
            $errors['email'] = 'Email tidak valid.';
        }
        if (empty($phone)) {
            $errors['phone'] = 'Nomor WhatsApp wajib diisi.';
        }

        // Password optional — only validate if filled
        if (!empty($password)) {
            if (strlen($password) < 6) {
                $errors['password'] = 'Password minimal 6 karakter.';
            }
            if ($password !== $confirmation) {
                $errors['password'] = 'Password dan konfirmasi tidak cocok.';
            }
        }

        // Check duplicate email (exclude current user)
        if (empty($errors['email']) && $this->userModel->emailExists($email, $userId)) {
            $errors['email'] = 'Email sudah digunakan pengguna lain.';
        }

        // Check duplicate phone (exclude current user)
        if (empty($errors['phone']) && $this->userModel->phoneExists($phone, $userId)) {
            $errors['phone'] = 'Nomor WhatsApp sudah digunakan pengguna lain.';
        }

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->setFlash('danger', 'Mohon periksa kembali data yang Anda masukkan.');
            $this->redirect('profile');
        }

        // Build update data
        $updateData = [
            'business_name' => $businessName,
            'owner_name'    => $ownerName,
            'email'         => $email,
            'phone'         => $phone,
        ];

        if (!empty($password)) {
            $updateData['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
        }

        $this->userModel->update($userId, $updateData);

        // Sync session
        $_SESSION['business_name'] = $businessName;
        $_SESSION['owner_name']    = $ownerName;

        unset($_SESSION['old_input']);
        unset($_SESSION['errors']);

        $this->setFlash('success', 'Profil berhasil diperbarui.');
        $this->redirect('profile');
    }
}
