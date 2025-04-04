<?php

class CartController extends Controller {
    public function __construct() {
        parent::__construct();
        if (!isset($_SESSION['cart'])) {
            $_SESSION['cart'] = [];
        }
    }

    public function index() {
        $cart = $_SESSION['cart'];
        $products = [];
        $total = 0;

        foreach ($cart as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $product['quantity'] = $quantity;
                $product['subtotal'] = $product['price'] * $quantity;
                $total += $product['subtotal'];
                $products[] = $product;
            }
        }

        $this->render('cart/index', [
            'products' => $products,
            'total' => $total
        ]);
    }

    public function add($productId) {
        $product = $this->productModel->find($productId);
        if (!$product) {
            $this->redirect('/products');
        }

        $quantity = $_POST['quantity'] ?? 1;
        if (isset($_SESSION['cart'][$productId])) {
            $_SESSION['cart'][$productId] += $quantity;
        } else {
            $_SESSION['cart'][$productId] = $quantity;
        }

        $this->redirect('/cart');
    }

    public function update($productId) {
        $quantity = $_POST['quantity'] ?? 1;
        if ($quantity > 0) {
            $_SESSION['cart'][$productId] = $quantity;
        } else {
            unset($_SESSION['cart'][$productId]);
        }
        $this->redirect('/cart');
    }

    public function remove($productId) {
        unset($_SESSION['cart'][$productId]);
        $this->redirect('/cart');
    }

    public function checkout() {
        $this->auth->requireLogin();
        
        if (empty($_SESSION['cart'])) {
            $this->redirect('/cart');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'user_id' => $this->auth->getUser()['user_id'],
                'delivery_type' => $_POST['delivery_type'],
                'delivery_date' => $_POST['delivery_date'],
                'address' => $_POST['address'],
                'total' => $this->calculateTotal(),
                'status' => 'pending'
            ];

            $orderId = $this->orderModel->create($data);
            if ($orderId) {
                foreach ($_SESSION['cart'] as $productId => $quantity) {
                    $product = $this->productModel->find($productId);
                    $this->orderModel->addItem($orderId, $productId, $quantity, $product['price']);
                    $this->productModel->updateStock($productId, -$quantity);
                }
                unset($_SESSION['cart']);
                $this->redirect('/orders/' . $orderId);
            }
        }

        $this->render('cart/checkout', [
            'total' => $this->calculateTotal()
        ]);
    }

    private function calculateTotal() {
        $total = 0;
        foreach ($_SESSION['cart'] as $productId => $quantity) {
            $product = $this->productModel->find($productId);
            if ($product) {
                $total += $product['price'] * $quantity;
            }
        }
        return $total;
    }
} 