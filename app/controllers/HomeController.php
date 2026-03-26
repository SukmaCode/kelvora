<?php

namespace App\Controllers;

use Core\BaseController;

/**
 * Home Controller
 * 
 * Dashboard / landing page.
 */
class HomeController extends BaseController
{
    public function index(): void
    {
        $this->requireAuth();

        if ($_SESSION['user_role'] === 'admin') {
            $this->view('admin.index', [
                'title' => 'Admin Dashboard',
            ]);
        } else {
            $this->view('owner.index', [
                'title' => 'Dashboard',
            ]);
        }
    }
}
