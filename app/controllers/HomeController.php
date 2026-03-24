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
        $this->view('home.index', [
            'title' => 'Dashboard',
        ]);
    }
}
