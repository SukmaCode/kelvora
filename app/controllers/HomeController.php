<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\User;
use App\Models\Product;
use App\Models\Order;

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
            $userModel = new User();
            $productModel = new Product();
            $orderModel = new Order();
            
            $this->view('admin.index', [
                'title' => 'Admin Dashboard',
                'totalUsers' => $userModel->count(),
                'totalProducts' => $productModel->count(),
                'totalOrders' => $orderModel->count(),
                'totalRevenue' => $orderModel->getTotalRevenue()
            ]);
        } else {
            $userId = $_SESSION['user_id'];
            $productModel = new Product();
            $orderModel = new Order();
            
            $stats = $orderModel->getStatsByUser($userId);

            $this->view('owner.index', [
                'title' => 'Dashboard',
                'totalProducts' => $productModel->countByUser($userId),
                'totalOrders' => $stats->total_orders ?? 0,
                'todaySales' => $orderModel->getTodaySales($userId),
                'monthlyRevenue' => $orderModel->getMonthlyRevenue($userId)
            ]);
        }
    }
}
