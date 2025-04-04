<?php
session_start();
require_once 'models/Database.php';
require_once 'models/Model.php';
require_once 'models/User.php';
require_once 'models/Auth.php';
require_once 'controllers/Controller.php';
require_once 'controllers/AuthController.php';
require_once 'controllers/ProductController.php';

// Initialize Auth
$auth = Auth::getInstance();

// Simple routing
$request = $_SERVER['REQUEST_URI'];
$basePath = '/ensa/ecommerce';

// Remove base path from request
$request = str_replace($basePath, '', $request);

// Remove query string
$request = strtok($request, '?');

// Initialize controllers
$authController = new AuthController();
$productController = new ProductController();

// Route handling
switch ($request) {
    case '/':
    case '':
        $productController->index();
        break;
    case '/login':
        $authController->login();
        break;
    case '/register':
        $authController->register();
        break;
    case '/logout':
        $authController->logout();
        break;
    case '/products':
        $productController->index();
        break;
    case (preg_match('/^\/products\/(\d+)$/', $request, $matches) ? true : false):
        $productController->show($matches[1]);
        break;
    case '/products/create':
        $auth->requireSeller();
        $productController->create();
        break;
    case '/products/search':
        $productController->search();
        break;
    case '/cart':
        $auth->requireLogin();
        require 'views/cart/index.php';
        break;
    case '/profile':
        $auth->requireLogin();
        require 'views/profile/index.php';
        break;
    case '/admin':
        $auth->requireAdmin();
        $content = require_once 'views/admin/dashboard.php';
        require 'views/layouts/main.php';
        break;
    case '/admin/users':
        $auth->requireAdmin();
        require 'views/admin/users.php';
        break;
    case '/admin/products':
        $auth->requireAdmin();
        require 'views/admin/products.php';
        break;
    case '/admin/categories':
        $auth->requireAdmin();
        require 'views/admin/categories.php';
        break;
    case '/admin/orders':
        $auth->requireAdmin();
        require 'views/admin/orders.php';
        break;
    case '/seller':
        $auth->requireSeller();
        require 'views/seller/dashboard.php';
        break;
    case '/seller/products':
        $auth->requireSeller();
        require 'views/seller/products.php';
        break;
    case '/seller/orders':
        $auth->requireSeller();
        require 'views/seller/orders.php';
        break;
    default:
        http_response_code(404);
        require 'views/404.php';
        break;
}
