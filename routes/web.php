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
// Home / Dashboard
// =========================================================================
$router->get('',  'HomeController@index');

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
