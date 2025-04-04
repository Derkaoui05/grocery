<?php
require_once __DIR__ . '/../config/config.php';

class Auth {
    private static $instance = null;
    private $userModel;

    private function __construct() {
        if (session_status() === PHP_SESSION_NONE) {
            session_start();
        }
        $this->userModel = new User();
    }

    public static function getInstance() {
        if (self::$instance === null) {
            self::$instance = new self();
        }
        return self::$instance;
    }

    public function login($email, $password) {
        $user = $this->userModel->login($email, $password);
        
        if ($user) {
            $_SESSION['user'] = $user;
            $_SESSION['user_id'] = $user['user_id'];
            $_SESSION['role'] = $user['role'];
            return true;
        }
        
        return false;
    }

    public function logout() {
        unset($_SESSION['user']);
        unset($_SESSION['user_id']);
        unset($_SESSION['role']);
        session_destroy();
    }

    public function isLoggedIn() {
        return isset($_SESSION['user_id']);
    }

    public function getUser() {
        return $_SESSION['user'] ?? null;
    }

    public function getUserId() {
        return $_SESSION['user_id'] ?? null;
    }

    public function getRole() {
        return $_SESSION['role'] ?? null;
    }

    public function isAdmin() {
        return $this->getRole() === 'admin';
    }

    public function isSeller() {
        return $this->getRole() === 'seller';
    }

    public function isCustomer() {
        return $this->getRole() === 'customer';
    }

    public function requireLogin() {
        if (!$this->isLoggedIn()) {
            header('Location: /ensa/ecommerce/login');
            exit();
        }
    }

    public function requireAdmin() {
        $this->requireLogin();
        if (!$this->isAdmin()) {
            header('Location: /ensa/ecommerce/403');
            exit();
        }
    }

    public function requireSeller() {
        $this->requireLogin();
        if (!$this->isSeller()) {
            header('Location: /ensa/ecommerce/403');
            exit();
        }
    }

    public function requireCustomer() {
        $this->requireLogin();
        if (!$this->isCustomer()) {
            header('Location: /ensa/ecommerce/403');
            exit();
        }
    }
} 