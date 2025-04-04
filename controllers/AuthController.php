<?php

class AuthController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function login() {
        // If user is already logged in, redirect based on role
        if ($this->auth->isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            if ($this->auth->login($email, $password)) {
                // Redirect based on user role after successful login
                $this->redirectBasedOnRole();
                return;
            } else {
                $error = "Email ou mot de passe incorrect";
                require 'views/auth/login.php';
            }
        } else {
            require 'views/auth/login.php';
        }
    }

    private function redirectBasedOnRole() {
        if ($this->auth->isAdmin()) {
            header('Location: /ensa/ecommerce/admin');
            exit;
        } elseif ($this->auth->isSeller()) {
            header('Location: /ensa/ecommerce/seller');
            exit;
        } else {
            header('Location: /ensa/ecommerce');
            exit;
        }
    }

    public function register() {
        if ($this->auth->isLoggedIn()) {
            $this->redirectBasedOnRole();
            return;
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $username = $_POST['username'] ?? '';
            $email = $_POST['email'] ?? '';
            $password = $_POST['password'] ?? '';

            // Validate required fields
            if (empty($username) || empty($email) || empty($password)) {
                $error = "Tous les champs sont obligatoires";
                require 'views/auth/register.php';
                return;
            }

            // Validate email format
            if (!filter_var($email, FILTER_VALIDATE_EMAIL)) {
                $error = "Format d'email invalide";
                require 'views/auth/register.php';
                return;
            }

            // Check if email already exists
            $userModel = new User();
            if ($userModel->findByEmail($email)) {
                $error = "Cet email est déjà utilisé";
                require 'views/auth/register.php';
                return;
            }

            // Create user
            $userData = [
                'username' => $username,
                'email' => $email,
                'password' => $password,
                'role' => 'customer'
            ];

            if ($userModel->create($userData)) {
                // Log the user in automatically
                $this->auth->login($email, $password);
                $this->redirectBasedOnRole();
            } else {
                $error = "Une erreur est survenue lors de l'inscription";
                require 'views/auth/register.php';
            }
        } else {
            require 'views/auth/register.php';
        }
    }

    public function logout() {
        $this->auth->logout();
        header('Location: /ensa/ecommerce/login');
        exit;
    }
} 
