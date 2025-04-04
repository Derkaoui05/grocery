<?php

require_once __DIR__ . '/../models/Product.php';
require_once __DIR__ . '/../models/User.php';
require_once __DIR__ . '/../models/Order.php';
require_once __DIR__ . '/../models/Category.php';
require_once __DIR__ . '/../models/Review.php';
require_once __DIR__ . '/../models/Auth.php';

abstract class Controller {
    protected $auth;
    protected $userModel;
    protected $productModel;
    protected $orderModel;
    protected $categoryModel;
    protected $reviewModel;

    public function __construct() {
        $this->auth = Auth::getInstance();
        $this->userModel = new User();
        $this->productModel = new Product();
        $this->orderModel = new Order();
        $this->categoryModel = new Category();
        $this->reviewModel = new Review();
    }

    protected function render($view, $data = []) {
        extract($data);
        require_once "views/{$view}.php";
    }

    protected function redirect($path) {
        header("Location: /ensa/ecommerce{$path}");
        exit();
    }

    protected function json($data) {
        header('Content-Type: application/json');
        echo json_encode($data);
        exit();
    }
} 