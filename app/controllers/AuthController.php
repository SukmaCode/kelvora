<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\User;

/**
 * Authentication Controller
 * 
 * Handles user login and logout.
 */
class AuthController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->userModel = new User();
    }

    /**
     * Show the login form.
     */
    public function loginForm(): void
    {
        // If already logged in, redirect to dashboard
        if (!empty($_SESSION['user_id'])) {
            $this->redirect('');
        }

        // Render login view (using a simple layout without sidebar)
        $this->view('auth.login', ['title' => 'Login to Kelvora']);
    }

    /**
     * Process the login request.
     */
    public function login(): void
    {
        // Must be POST
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->redirect('login');
        }

        $this->validateCsrfToken();

        $email = trim($this->input('email'));
        $password = $this->input('password');

        if (empty($email) || empty($password)) {
            $this->setFlash('danger', 'Email and password are required.');
            $_SESSION['old_input'] = ['email' => $email];
            $this->redirect('login');
        }

        $user = $this->userModel->findByEmail($email);

        if (!$user || !$this->userModel->verifyPassword($user, $password)) {
            $this->setFlash('danger', 'Invalid credentials.');
            $_SESSION['old_input'] = ['email' => $email];
            $this->redirect('login');
        }

        if ($user->status !== 'active') {
            $this->setFlash('danger', 'Your account is currently inactive.');
            $this->redirect('login');
        }

        // Set session variables
        $_SESSION['user_id'] = $user->id;
        $_SESSION['business_name'] = $user->business_name;
        $_SESSION['user_role'] = $user->role;

        // Redirect to dashboard
        $this->redirect('');
    }

    /**
     * Process logout request.
     */
    public function logout(): void
    {
        // Can be via POST or simple unset
        unset($_SESSION['user_id']);
        unset($_SESSION['business_name']);
        unset($_SESSION['user_role']);
        session_destroy();
        
        $this->redirect('login');
    }

    /**
     * Override view method to use auth layout instead of sidebar for login form.
     */
    protected function view(string $view, array $data = []): void
    {
        // Convert dot notation to path
        $viewPath = str_replace('.', '/', $view);
        $viewFile = BASE_PATH . '/app/views/' . $viewPath . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View [{$view}] not found at [{$viewFile}].");
        }

        extract($data);
        require $viewFile;
    }
}
