<?php

namespace App\Controllers;

use Core\BaseController;
use Core\ImageUploader;
use App\Models\User;

/**
 * User Controller
 * 
 * Handles full CRUD for users.
 * Demonstrates: SELECT, INSERT, UPDATE, DELETE with PDO prepared statements.
 */
class UserController extends BaseController
{
    private User $userModel;

    public function __construct()
    {
        // Must be admin to access users
        $this->requireRole('admin');
        $this->userModel = new User();
    }

    /**
     * GET /users
     * Display a list of all users.
     */
    public function index(): void
    {
        $users = $this->userModel->findAll('id', 'ASC');

        $this->view('users.index', [
            'title' => 'Users',
            'users' => $users,
        ]);
    }

    /**
     * GET /users/create
     * Show the create user form.
     */
    public function create(): void
    {
        $this->view('users.create', [
            'title' => 'Create User',
        ]);
    }

    /**
     * POST /users/store
     * Process the create form — INSERT into database.
     */
    public function store(): void
    {
        $this->validateCsrfToken();

        // Basic validation
        $errors = [];
        $data = [
            'business_name' => trim($this->input('business_name', '')),
            'name'          => trim($this->input('name', '')),
            'email'         => trim($this->input('email', '')),
            'phone'         => trim($this->input('phone', '')),
            'role'          => $this->input('role', 'owner'),
            'status'        => $this->input('status', 'active'),
        ];
        $password = $this->input('password', '');

        if (empty($data['business_name'])) $errors[] = 'Business name is required.';
        if (empty($data['name']))          $errors[] = 'Name is required.';
        if (empty($data['email']))         $errors[] = 'Email is required.';
        if (empty($data['phone']))         $errors[] = 'Phone number is required.';
        if (!filter_var($data['email'], FILTER_VALIDATE_EMAIL)) $errors[] = 'Invalid email format.';
        if (empty($password) || strlen($password) < 6) $errors[] = 'Password must be at least 6 characters.';

        if ($this->userModel->emailExists($data['email'])) {
            $errors[] = 'Email is already taken.';
        }

        if (!empty($errors)) {
            $_SESSION['errors']    = $errors;
            $_SESSION['old_input'] = $data;
            $this->redirect('/users/create');
            return;
        }

        // INSERT — using password hashing helper
        $this->userModel->createWithPassword($data, $password);

        $this->setFlash('success', 'User created successfully.');
        $this->redirect('/users');
    }

    /**
     * GET /users/{id}
     * Show a single user detail.
     */
    public function show(int $id): void
    {
        $user = $this->userModel->findById($id);

        if (!$user) {
            $this->setFlash('danger', 'User not found.');
            $this->redirect('/users');
            return;
        }

        $this->view('users.show', [
            'title' => 'User Detail',
            'user'  => $user,
        ]);
    }

    /**
     * GET /users/{id}/edit
     * Show the edit form for a user.
     */
    public function edit(int $id): void
    {
        $user = $this->userModel->findById($id);

        if (!$user) {
            $this->setFlash('danger', 'User not found.');
            $this->redirect('/users');
            return;
        }

        $this->view('users.edit', [
            'title' => 'Edit User',
            'user'  => $user,
        ]);
    }

    /**
     * POST /users/{id}/update
     * Process the edit form — UPDATE database.
     */
    public function update(int $id): void
    {
        $this->validateCsrfToken();

        $user = $this->userModel->findById($id);
        if (!$user) {
            $this->setFlash('danger', 'User not found.');
            $this->redirect('/users');
            return;
        }

        $data = [
            'business_name' => trim($this->input('business_name', '')),
            'name'          => trim($this->input('name', '')),
            'email'         => trim($this->input('email', '')),
            'phone'         => trim($this->input('phone', '')),
            'role'          => $this->input('role', 'owner'),
            'status'        => $this->input('status', 'active'),
        ];

        $errors = [];
        if (empty($data['business_name'])) $errors[] = 'Business name is required.';
        if (empty($data['name']))          $errors[] = 'Name is required.';
        if (empty($data['email']))         $errors[] = 'Email is required.';

        if ($this->userModel->emailExists($data['email'], $id)) {
            $errors[] = 'Email is already taken by another user.';
        }

        // Optional: update password if provided
        $password = $this->input('password', '');
        if (!empty($password)) {
            if (strlen($password) < 6) {
                $errors[] = 'Password must be at least 6 characters.';
            } else {
                $data['password_hash'] = password_hash($password, PASSWORD_BCRYPT);
            }
        }

        if (!empty($errors)) {
            $_SESSION['errors']    = $errors;
            $_SESSION['old_input'] = $data;
            $this->redirect("/users/{$id}/edit");
            return;
        }

        // UPDATE
        $this->userModel->update($id, $data);

        $this->setFlash('success', 'User updated successfully.');
        $this->redirect('/users');
    }

    /**
     * POST /users/{id}/delete
     * DELETE a user from the database.
     */
    public function delete(int $id): void
    {
        $this->validateCsrfToken();

        $user = $this->userModel->findById($id);
        if (!$user) {
            $this->setFlash('danger', 'User not found.');
            $this->redirect('/users');
            return;
        }

        if (!empty($user->profile_image)) {
            $uploader = new ImageUploader(BASE_PATH . '/public/uploads/profile');
            $uploader->deleteImage($user->profile_image);
        }

        $this->userModel->delete($id);

        $this->setFlash('success', 'User deleted successfully.');
        $this->redirect('/users');
    }
}
