<?php

namespace App\Controllers;

use Core\BaseController;

/**
 * Landing Controller
 * 
 * Public-facing landing/marketing page (no sidebar layout).
 */
class LandingController extends BaseController
{
    public function index(): void
    {
        $viewFile = BASE_PATH . '/app/views/landing/index.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("Landing view not found at [{$viewFile}].");
        }

        require $viewFile;
    }
}
