<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\User;

/**
 * Revenue Controller
 * 
 * Exclusively for Admin to monitor UMKM revenues.
 */
class RevenueController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        $this->requireRole('admin');
        $this->userModel = new User();
    }

    /**
     * GET /admin/revenues
     */
    public function index(): void
    {
        $revenues = $this->userModel->getUmkmRevenues();

        $this->view('admin.revenues.index', [
            'title' => 'UMKM Revenues',
            'revenues' => $revenues
        ]);
    }

    /**
     * GET /admin/revenues/{id}
     * Detail view of a specific UMKM's revenue (optional, redirect to list for now)
     */
    public function show(int $id): void
    {
        // For now, redirect back to index. Can be extended to show per-order detail if needed by the owner.
        $this->redirect('/admin/revenues');
    }
}
