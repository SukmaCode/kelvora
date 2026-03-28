<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Database;
use App\Models\Product;
use App\Models\Customer;
use App\Models\Order;
use App\Models\OrderItem;

/**
 * Landing Controller
 * 
 * Public-facing landing/marketing page (no sidebar layout).
 * Also serves as storefront for logged-in customers.
 */
class LandingController extends BaseController
{
    public function index(): void
    {
        $products = [];
        $userRole = $_SESSION['user_role'] ?? 'guest';

        if ($userRole === 'customer') {
            $productModel = new Product();
            $products = $productModel->findAllActive();
        }

        $this->generateCsrfToken();

        $viewFile = BASE_PATH . '/app/views/landing/index.php';

        if (!file_exists($viewFile)) {
            throw new \RuntimeException("Landing view not found at [{$viewFile}].");
        }

        extract(['products' => $products]);

        require $viewFile;
    }

    public function checkout(): void
    {
        if ($_SERVER['REQUEST_METHOD'] !== 'POST') {
            $this->jsonResponse(['success' => false, 'message' => 'Method not allowed.'], 405);
        }

        if (($_SESSION['user_role'] ?? '') !== 'customer') {
            $this->jsonResponse(['success' => false, 'message' => 'Silakan masuk sebagai customer terlebih dahulu.']);
        }
        
        $token = $_POST['csrf_token'] ?? '';
        if (!hash_equals($_SESSION['csrf_token'] ?? '', $token)) {
            $this->jsonResponse(['success' => false, 'message' => 'Invalid CSRF token.'], 403);
        }

        $productId = (int) $this->input('product_id', 0);
        
        if ($productId <= 0) {
            $this->jsonResponse(['success' => false, 'message' => 'Produk tidak valid.']);
        }

        $productModel = new Product();
        $product = $productModel->findById($productId);

        if (!$product || $product->status !== 'active') {
            $this->jsonResponse(['success' => false, 'message' => 'Produk tidak ditemukan atau tidak tersedia.']);
        }

        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $ownerId = $product->user_id;
            $customerModel = new Customer();
            
            // Check if customer alias exists for this owner
            $cust = $customerModel->findByOwnerAndPhone($ownerId, $_SESSION['email']);

            if (!$cust) {
                // Create customer record using email as phone according to user rules
                $customerId = $customerModel->create([
                    'user_id' => $ownerId,
                    'name' => $_SESSION['name'],
                    'phone' => $_SESSION['email'],
                    'instagram_username' => '',
                    'address' => '-'
                ]);
            } else {
                $customerId = $cust->id;
            }

            $orderModel = new Order();
            $orderId = $orderModel->create([
                'user_id' => $ownerId,
                'customer_id' => $customerId,
                'total_price' => $product->price,
                'payment_status' => 'pending',
                'order_status' => 'new'
            ]);

            $orderItemModel = new OrderItem();
            $orderItemModel->create([
                'order_id' => $orderId,
                'product_id' => $product->id,
                'quantity' => 1,
                'price' => $product->price
            ]);

            $db->commit();

            $this->jsonResponse([
                'success' => true,
                'message' => 'Pesanan berhasil dibuat! Penjual akan segera memproses.'
            ]);

        } catch (\Exception $e) {
            $db->rollBack();
            $this->jsonResponse(['success' => false, 'message' => 'Terjadi kesalahan: ' . $e->getMessage()]);
        }
    }
}
