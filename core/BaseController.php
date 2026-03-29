<?php

namespace Core;

/**
 * Base Controller
 * 
 * Provides common utilities for all controllers:
 * - View rendering with layout support
 * - Redirects
 * - JSON responses
 * - CSRF token management
 * - Flash messages
 */
class BaseController
{
    /**
     * Render a view file inside the main layout.
     *
     * @param string $view  Dot-separated path (e.g. 'users.index' → views/users/index.php)
     * @param array  $data  Variables to extract into view scope
     */
    protected function view(string $view, array $data = []): void
    {
        // Convert dot notation to path
        $viewPath = str_replace('.', '/', $view);
        $viewFile = BASE_PATH . '/app/views/' . $viewPath . '.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View [{$view}] not found at [{$viewFile}].");
        }

        // Extract data to make variables available in view
        extract($data);

        // Capture the view content
        ob_start();
        require $viewFile;
        $content = ob_get_clean();

        // Render inside layout
        if (file_exists(BASE_PATH . '/app/views/layouts/sidebar-and-main.php')) {
            require BASE_PATH . '/app/views/layouts/sidebar-and-main.php';
        } else {
            require BASE_PATH . '/app/views/layouts/sidebar.php';
        }

        // Clear flashed session data (errors & old input) after rendering the view
        unset($_SESSION['errors']);
        unset($_SESSION['old_input']);
    }

    /**
     * Redirect to a URL.
     */
    protected function redirect(string $url): void
    {
        header('Location: ' . BASE_URL . '/' . ltrim($url, '/'));
        exit;
    }

    /**
     * Send a JSON response.
     */
    protected function jsonResponse(array $data, int $statusCode = 200): void
    {
        http_response_code($statusCode);
        header('Content-Type: application/json; charset=utf-8');
        echo json_encode($data, JSON_UNESCAPED_UNICODE);
        exit;
    }

    /**
     * Generate a CSRF token and store it in the session.
     */
    protected function generateCsrfToken(): string
    {
        if (empty($_SESSION['csrf_token'])) {
            $_SESSION['csrf_token'] = bin2hex(random_bytes(32));
        }
        return $_SESSION['csrf_token'];
    }

    /**
     * Validate the CSRF token from a form submission.
     */
    protected function validateCsrfToken(): bool
    {
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            http_response_code(403);
            die('Invalid CSRF token.');
        }
        // Regenerate after validation
        unset($_SESSION['csrf_token']);
        return true;
    }

    /**
     * Set a flash message for the next request.
     */
    protected function setFlash(string $type, string $message): void
    {
        $_SESSION['flash'] = [
            'type'    => $type,
            'message' => $message,
        ];
    }

    /**
     * Get and clear the flash message.
     */
    protected function getFlash(): ?array
    {
        $flash = $_SESSION['flash'] ?? null;
        unset($_SESSION['flash']);
        return $flash;
    }

    /**
     * Get POST data with optional default.
     */
    protected function input(string $key, $default = null)
    {
        return $_POST[$key] ?? $default;
    }

    /**
     * Require the user to be authenticated.
     */
    protected function requireAuth(): void
    {
        if (empty($_SESSION['user_id'])) {
            $this->setFlash('danger', 'Please login to continue.');
            $this->redirect('login');
        }
    }

    /**
     * Require the user to have a specific role.
     */
    protected function requireRole(string $role): void
    {
        $this->requireAuth();
        
        if (($_SESSION['user_role'] ?? '') !== $role) {
            http_response_code(403);
            die('Unauthorized access. You do not have the required role.');
        }
    }
}
