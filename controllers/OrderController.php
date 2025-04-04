<?php

class OrderController extends Controller {
    public function __construct() {
        parent::__construct();
    }

    public function index() {
        $this->auth->requireLogin();
        $userId = $this->auth->getUser()['user_id'];
        $orders = $this->orderModel->getOrdersByUser($userId);
        $this->render('orders/index', ['orders' => $orders]);
    }

    public function show($orderId) {
        $this->auth->requireLogin();
        $order = $this->orderModel->getOrderWithItems($orderId);
        
        if (!$order || ($order['user_id'] != $this->auth->getUser()['user_id'] && !$this->auth->isAdmin() && !$this->auth->isSeller())) {
            $this->redirect('/orders');
        }

        $this->render('orders/show', ['order' => $order]);
    }

    public function track($orderId) {
        $this->auth->requireLogin();
        $order = $this->orderModel->getOrderWithItems($orderId);
        
        if (!$order || $order['user_id'] != $this->auth->getUser()['user_id']) {
            $this->redirect('/orders');
        }

        $this->render('orders/track', ['order' => $order]);
    }

    public function cancel($orderId) {
        $this->auth->requireLogin();
        $order = $this->orderModel->find($orderId);
        
        if ($order && $order['user_id'] == $this->auth->getUser()['user_id'] && $order['status'] == 'pending') {
            $this->orderModel->updateStatus($orderId, 'cancelled');
            
            // Restore stock
            $items = $this->orderModel->getOrderItems($orderId);
            foreach ($items as $item) {
                $this->productModel->updateStock($item['product_id'], $item['quantity']);
            }
        }
        
        $this->redirect('/orders');
    }

    public function invoice($orderId) {
        $this->auth->requireLogin();
        $order = $this->orderModel->getOrderWithItems($orderId);
        
        if (!$order || ($order['user_id'] != $this->auth->getUser()['user_id'] && !$this->auth->isAdmin() && !$this->auth->isSeller())) {
            $this->redirect('/orders');
        }

        $this->render('orders/invoice', ['order' => $order]);
    }
}