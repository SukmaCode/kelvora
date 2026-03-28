<?php

/**
 * Route Definitions
 * 
 * Maps URI patterns to Controller@method.
 * Supports GET and POST methods with dynamic {id} parameters.
 *
 * Flow: Request → Router → Controller@method → Model → View
 */

/** @var \Core\Router $router */

// =========================================================================
// Landing Page (public, no sidebar layout)
// =========================================================================
$router->get('',  'LandingController@index');
$router->post('order/checkout', 'LandingController@checkout');

// =========================================================================
// Authentication
// =========================================================================
$router->get('login',    'AuthController@loginForm');
$router->post('login',   'AuthController@login');
$router->get('register', 'AuthController@registerForm');
$router->post('register','AuthController@register');
$router->post('logout',  'AuthController@logout');
$router->get('logout',   'AuthController@logout'); // Allow GET for simple usage if needed

// OTP & Additional Auth actions
$router->get('auth/verify-email',      'AuthController@showVerify');
$router->post('auth/verify-email-otp', 'AuthController@verifyEmailOtp');
$router->post('auth/resend-otp',       'AuthController@resendOtp');

// =========================================================================
// Profile (Edit own profile)
// =========================================================================
$router->get('profile',        'ProfileController@edit');
$router->post('profile/update','ProfileController@update');

// =========================================================================
// Home / Dashboard
// =========================================================================
$router->get('home',  'HomeController@index');

// =========================================================================
// Users (Full CRUD)
// =========================================================================
$router->get('users',              'UserController@index');
$router->get('users/create',      'UserController@create');
$router->post('users/store',      'UserController@store');
$router->get('users/{id}',        'UserController@show');
$router->get('users/{id}/edit',   'UserController@edit');
$router->post('users/{id}/update', 'UserController@update');
$router->post('users/{id}/delete', 'UserController@delete');

// =========================================================================
// Products (Full CRUD)
// =========================================================================
$router->get('products',              'ProductController@index');
$router->get('products/create',      'ProductController@create');
$router->post('products/store',      'ProductController@store');
$router->get('products/{id}',        'ProductController@show');
$router->get('products/{id}/edit',   'ProductController@edit');
$router->post('products/{id}/update', 'ProductController@update');
$router->post('products/{id}/delete', 'ProductController@delete');

// =========================================================================
// Orders (CRUD)
// =========================================================================
$router->get('orders',              'OrderController@index');
$router->get('orders/create',      'OrderController@create');
$router->post('orders/store',      'OrderController@store');
$router->get('orders/{id}',        'OrderController@show');
$router->post('orders/{id}/delete', 'OrderController@delete');

// =========================================================================
// Income Statements (Dashboard + Export)
// =========================================================================
$router->get('income-statements',              'IncomeStatementController@index');
$router->get('income-statements/export-excel', 'IncomeStatementController@exportExcel');
$router->get('income-statements/export-pdf',   'IncomeStatementController@exportPdf');

// =========================================================================
// Legal Pages (Public)
// =========================================================================
$router->get('policy-privacy',   'LegalController@policyPrivacy');
$router->get('remove-data',      'LegalController@removeData');
$router->get('terms-conditions', 'LegalController@termsConditions');
