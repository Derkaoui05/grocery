<?php

class SellerController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->auth->requireSeller();
    }

    public function dashboard() {
        $sellerId = $this->auth->getUser()['user_id'];
        $products = $this->productModel->getProductsBySeller($sellerId);
        $orders = $this->orderModel->getOrdersBySeller($sellerId);
        
        $this->render('seller/dashboard', [
            'products' => $products,
            'orders' => $orders
        ]);
    }

    public function products() {
        $sellerId = $this->auth->getUser()['user_id'];
        $products = $this->productModel->getProductsBySeller($sellerId);
        $this->render('seller/products', ['products' => $products]);
    }

    public function addProduct() {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'category_id' => $_POST['category_id'],
                'seller_id' => $this->auth->getUser()['user_id'],
                'expiration_date' => $_POST['expiration_date'],
                'promotion' => $_POST['promotion'] ?? 0
            ];

            if ($this->productModel->create($data)) {
                $this->redirect('/seller/products');
            } else {
                $this->render('seller/add_product', ['error' => 'Failed to add product']);
            }
        } else {
            $categories = $this->categoryModel->findAll();
            $this->render('seller/add_product', ['categories' => $categories]);
        }
    }

    public function editProduct($productId) {
        $product = $this->productModel->find($productId);
        if (!$product || $product['seller_id'] != $this->auth->getUser()['user_id']) {
            $this->redirect('/seller/products');
        }

        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'],
                'description' => $_POST['description'],
                'price' => $_POST['price'],
                'stock' => $_POST['stock'],
                'category_id' => $_POST['category_id'],
                'expiration_date' => $_POST['expiration_date'],
                'promotion' => $_POST['promotion'] ?? 0
            ];

            if ($this->productModel->update($productId, $data)) {
                $this->redirect('/seller/products');
            } else {
                $this->render('seller/edit_product', [
                    'product' => $product,
                    'error' => 'Failed to update product'
                ]);
            }
        } else {
            $categories = $this->categoryModel->findAll();
            $this->render('seller/edit_product', [
                'product' => $product,
                'categories' => $categories
            ]);
        }
    }

    public function deleteProduct($productId) {
        $product = $this->productModel->find($productId);
        if ($product && $product['seller_id'] == $this->auth->getUser()['user_id']) {
            $this->productModel->delete($productId);
        }
        $this->redirect('/seller/products');
    }

    public function orders() {
        $sellerId = $this->auth->getUser()['user_id'];
        $orders = $this->orderModel->getOrdersBySeller($sellerId);
        $this->render('seller/orders', ['orders' => $orders]);
    }

    public function updateOrderStatus($orderId, $status) {
        $order = $this->orderModel->find($orderId);
        if ($order) {
            $this->orderModel->updateStatus($orderId, $status);
        }
        $this->redirect('/seller/orders');
    }

    public function generateInvoice($orderId) {
        $order = $this->orderModel->getOrderWithItems($orderId);
        if ($order) {
            $this->render('seller/invoice', ['order' => $order]);
        } else {
            $this->redirect('/seller/orders');
        }
    }
} 