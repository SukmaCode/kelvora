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

        if ($_SESSION['user_role'] === 'customer') {
            $this->redirect('');
            return;
        }

        if ($_SESSION['user_role'] === 'admin') {
            $userModel = new User();
            $productModel = new Product();
            $orderModel = new Order();
            
            $revenueData = $orderModel->getTotalRevenue();

            $this->view('admin.index', [
                'title' => 'Admin Dashboard',
                'totalUsers' => $userModel->count(),
                'totalProducts' => $productModel->count(),
                'totalOrders' => $orderModel->count(),
                'totalRevenue' => $revenueData->gross_revenue,
                'platformFee' => $revenueData->platform_fee
            ]);
        } else {
            $userId = $_SESSION['user_id'];
            $productModel = new Product();
            $orderModel = new Order();
            
            $stats = $orderModel->getStatsByUser($userId);

            $todaySales = $orderModel->getTodaySales($userId);
            $monthlyRevenue = $orderModel->getMonthlyRevenue($userId);

            $this->view('owner.index', [
                'title' => 'Dashboard',
                'totalProducts' => $productModel->countByUser($userId),
                'totalOrders' => $stats->total_orders ?? 0,
                'todaySales' => $todaySales->total ?? 0,
                'todayNet' => $todaySales->net_total ?? 0,
                'monthlyRevenue' => $monthlyRevenue->total ?? 0,
                'monthlyNet' => $monthlyRevenue->net_total ?? 0,
                'totalNet' => $stats->owner_earning ?? 0
            ]);
        }
    }
}
