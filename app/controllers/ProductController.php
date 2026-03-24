<?php

namespace App\Controllers;

use Core\BaseController;
use App\Models\Product;

/**
 * Product Controller
 * 
 * Full CRUD for products.
 * Products are scoped by user_id (SaaS multi-tenancy).
 * For demo purposes, we use user_id = 1. In production, use session-based auth.
 */
class ProductController extends BaseController
{
    private Product $productModel;
    private int $currentUserId = 1; // Demo: hardcoded user_id

    public function __construct()
    {
        $this->productModel = new Product();
    }

    /**
     * GET /products
     */
    public function index(): void
    {
        $products = $this->productModel->findByUser($this->currentUserId);

        $this->view('products.index', [
            'title'    => 'Products',
            'products' => $products,
        ]);
    }

    /**
     * GET /products/create
     */
    public function create(): void
    {
        $this->view('products.create', [
            'title' => 'Create Product',
        ]);
    }

    /**
     * POST /products/store
     */
    public function store(): void
    {
        $this->validateCsrfToken();

        $data = [
            'user_id'     => $this->currentUserId,
            'name'        => trim($this->input('name', '')),
            'description' => trim($this->input('description', '')),
            'price'       => (float) $this->input('price', 0),
            'stock'       => (int) $this->input('stock', 0),
            'category'    => trim($this->input('category', '')),
            'status'      => $this->input('status', 'active'),
        ];

        $errors = [];
        if (empty($data['name']))  $errors[] = 'Product name is required.';
        if ($data['price'] <= 0)   $errors[] = 'Price must be greater than 0.';

        if (!empty($errors)) {
            $_SESSION['errors']    = $errors;
            $_SESSION['old_input'] = $data;
            $this->redirect('/products/create');
            return;
        }

        $this->productModel->create($data);

        $this->setFlash('success', 'Product created successfully.');
        $this->redirect('/products');
    }

    /**
     * GET /products/{id}
     */
    public function show(int $id): void
    {
        $product = $this->productModel->findById($id);

        if (!$product) {
            $this->setFlash('danger', 'Product not found.');
            $this->redirect('/products');
            return;
        }

        $this->view('products.show', [
            'title'   => 'Product Detail',
            'product' => $product,
        ]);
    }

    /**
     * GET /products/{id}/edit
     */
    public function edit(int $id): void
    {
        $product = $this->productModel->findById($id);

        if (!$product) {
            $this->setFlash('danger', 'Product not found.');
            $this->redirect('/products');
            return;
        }

        $this->view('products.edit', [
            'title'   => 'Edit Product',
            'product' => $product,
        ]);
    }

    /**
     * POST /products/{id}/update
     */
    public function update(int $id): void
    {
        $this->validateCsrfToken();

        $product = $this->productModel->findById($id);
        if (!$product) {
            $this->setFlash('danger', 'Product not found.');
            $this->redirect('/products');
            return;
        }

        $data = [
            'name'        => trim($this->input('name', '')),
            'description' => trim($this->input('description', '')),
            'price'       => (float) $this->input('price', 0),
            'stock'       => (int) $this->input('stock', 0),
            'category'    => trim($this->input('category', '')),
            'status'      => $this->input('status', 'active'),
        ];

        $errors = [];
        if (empty($data['name']))  $errors[] = 'Product name is required.';
        if ($data['price'] <= 0)   $errors[] = 'Price must be greater than 0.';

        if (!empty($errors)) {
            $_SESSION['errors']    = $errors;
            $_SESSION['old_input'] = $data;
            $this->redirect("/products/{$id}/edit");
            return;
        }

        $this->productModel->update($id, $data);

        $this->setFlash('success', 'Product updated successfully.');
        $this->redirect('/products');
    }

    /**
     * POST /products/{id}/delete
     */
    public function delete(int $id): void
    {
        $this->validateCsrfToken();

        $this->productModel->delete($id);

        $this->setFlash('success', 'Product deleted successfully.');
        $this->redirect('/products');
    }
}
