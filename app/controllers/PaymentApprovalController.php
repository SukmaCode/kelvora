<?php

namespace App\Controllers;

use Core\BaseController;
use Core\Database;
use App\Models\OrderPayment;
use App\Models\Order;

/**
 * Payment Approval Controller
 * 
 * Exclusively for Admin to review, approve, or reject customer payments.
 */
class PaymentApprovalController extends BaseController
{
    private OrderPayment $orderPaymentModel;
    private Order $orderModel;

    public function __construct()
    {
        // Only accessible by admin
        $this->requireRole('admin');
        $this->orderPaymentModel = new OrderPayment();
        $this->orderModel = new Order();
    }

    /**
     * GET /admin/payments
     */
    public function index(): void
    {
        $payments = $this->orderPaymentModel->getAllWithDetails();

        $this->view('admin.payments.index', [
            'title' => 'Payment Approvals',
            'payments' => $payments
        ]);
    }

    /**
     * POST /admin/payments/{id}/approve
     */
    public function approve(int $id): void
    {
        $this->validateCsrfToken();

        $payment = $this->orderPaymentModel->findById($id);

        if (!$payment) {
            $this->setFlash('danger', 'Payment not found.');
            $this->redirect('/admin/payments');
            return;
        }

        if ($payment->payment_status !== 'pending') {
            $this->setFlash('danger', 'Only pending payments can be approved.');
            $this->redirect('/admin/payments');
            return;
        }

        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $this->orderPaymentModel->update($id, [
                'payment_status' => 'approved'
            ]);

            $this->orderModel->update($payment->order_id, [
                'payment_status' => 'paid',
                'order_status' => 'processing'
            ]);

            $db->commit();
            $this->setFlash('success', 'Payment approved successfully.');

        } catch (\Exception $e) {
            $db->rollBack();
            $this->setFlash('danger', 'Failed to approve payment: ' . $e->getMessage());
        }

        $this->redirect('/admin/payments');
    }

    /**
     * POST /admin/payments/{id}/reject
     */
    public function reject(int $id): void
    {
        $this->validateCsrfToken();

        $payment = $this->orderPaymentModel->findById($id);

        if (!$payment) {
            $this->setFlash('danger', 'Payment not found.');
            $this->redirect('/admin/payments');
            return;
        }

        if ($payment->payment_status !== 'pending') {
            $this->setFlash('danger', 'Only pending payments can be rejected.');
            $this->redirect('/admin/payments');
            return;
        }

        $db = Database::getInstance();
        try {
            $db->beginTransaction();

            $this->orderPaymentModel->update($id, [
                'payment_status' => 'rejected'
            ]);

            $this->orderModel->update($payment->order_id, [
                'payment_status' => 'failed',
                'order_status' => 'cancelled'
            ]);

            $db->commit();
            $this->setFlash('success', 'Payment rejected successfully.');

        } catch (\Exception $e) {
            $db->rollBack();
            $this->setFlash('danger', 'Failed to reject payment: ' . $e->getMessage());
        }

        $this->redirect('/admin/payments');
    }
}
