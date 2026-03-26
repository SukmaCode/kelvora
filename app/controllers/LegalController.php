<?php

namespace App\Controllers;

use Core\BaseController;

/**
 * Legal Controller
 * 
 * Public-facing legal pages (Privacy Policy, Terms & Conditions, Remove Data).
 */
class LegalController extends BaseController
{
    public function policyPrivacy(): void
    {
        $viewFile = BASE_PATH . '/app/views/Legal/policy-privacy.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View not found at [{$viewFile}].");
        }

        require $viewFile;
    }

    public function removeData(): void
    {
        $viewFile = BASE_PATH . '/app/views/Legal/remove-data.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View not found at [{$viewFile}].");
        }

        require $viewFile;
    }

    public function termsConditions(): void
    {
        $viewFile = BASE_PATH . '/app/views/Legal/terms-conditions.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("View not found at [{$viewFile}].");
        }

        require $viewFile;
    }
}
