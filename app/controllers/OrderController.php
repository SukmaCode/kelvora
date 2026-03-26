<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Database;
use App\Models\Order;
use App\Models\OrderItem;
use App\Models\Customer;
use App\Models\Product;

/**
 * Order Controller
 * 
 * Full CRUD for orders.
 * Demonstrates JOIN queries, transactions, and related model interactions.
 */
class OrderController extends BaseController
{
    private Order $orderModel;
    private OrderItem $orderItemModel;
    private Customer $customerModel;
    private Product $productModel;
    private int $currentUserId;

    public function __construct()
    {
        $this->requireRole('owner');
        $this->orderModel     = new Order();
        $this->orderItemModel = new OrderItem();
        $this->customerModel  = new Customer();
        $this->productModel   = new Product();
        $this->currentUserId  = $_SESSION['user_id'] ?? 1;
    }

    /**
     * GET /orders
     */
    public function index(): void
    {
        $orders = $this->orderModel->findByUserWithCustomer($this->currentUserId);

        $this->view('orders.index', [
            'title'  => 'Orders',
            'orders' => $orders,
        ]);
    }

    /**
     * GET /orders/create
     */
    public function create(): void
    {
        $customers = $this->customerModel->findByUser($this->currentUserId);
        $products  = $this->productModel->findActiveByUser($this->currentUserId);

        $this->view('orders.create', [
            'title'     => 'Create Order',
            'customers' => $customers,
            'products'  => $products,
        ]);
    }

    /**
     * POST /orders/store
     * Uses a database transaction to insert order + order items atomically.
     */
    public function store(): void
    {
        $this->validateCsrfToken();

        $customerId = (int) $this->input('customer_id', 0);
        $productIds = $_POST['product_id'] ?? [];
        $quantities = $_POST['quantity'] ?? [];

        $errors = [];
        if ($customerId <= 0) $errors[] = 'Please select a customer.';
        if (empty($productIds)) $errors[] = 'Please add at least one product.';

        if (!empty($errors)) {
            $_SESSION['errors'] = $errors;
            $this->redirect('/orders/create');
            return;
        }

        $db = Database::getInstance();

        try {
            $db->beginTransaction();

            // Calculate total price
            $totalPrice = 0;
            $items = [];

            foreach ($productIds as $index => $productId) {
                $product  = $this->productModel->findById((int) $productId);
                $quantity = (int) ($quantities[$index] ?? 1);

                if ($product && $quantity > 0) {
                    $lineTotal = $product->price * $quantity;
                    $totalPrice += $lineTotal;

                    $items[] = [
                        'product_id' => (int) $productId,
                        'quantity'   => $quantity,
                        'price'      => $product->price,
                    ];
                }
            }

            // INSERT order
            $orderId = $this->orderModel->create([
                'user_id'        => $this->currentUserId,
                'customer_id'    => $customerId,
                'total_price'    => $totalPrice,
                'payment_status' => 'pending',
                'order_status'   => 'new',
            ]);

            // INSERT order items
            foreach ($items as $item) {
                $item['order_id'] = $orderId;
                $this->orderItemModel->create($item);
            }

            $db->commit();

            $this->setFlash('success', 'Order created successfully.');
            $this->redirect('/orders');

        } catch (\Exception $e) {
            $db->rollBack();
            $this->setFlash('danger', 'Failed to create order: ' . $e->getMessage());
            $this->redirect('/orders/create');
        }
    }

    /**
     * GET /orders/{id}
     */
    public function show(int $id): void
    {
        $order = $this->orderModel->findWithDetails($id);

        if (!$order) {
            $this->setFlash('danger', 'Order not found.');
            $this->redirect('/orders');
            return;
        }

        $items = $this->orderItemModel->findByOrder($id);

        $this->view('orders.show', [
            'title' => 'Order #' . $id,
            'order' => $order,
            'items' => $items,
        ]);
    }

    /**
     * POST /orders/{id}/delete
     */
    public function delete(int $id): void
    {
        $this->validateCsrfToken();

        $this->orderModel->delete($id);

        $this->setFlash('success', 'Order deleted successfully.');
        $this->redirect('/orders');
    }
}
