<?php

class Order extends Model {
    protected $table = 'orders';
    protected $primaryKey = 'order_id';

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (user_id, total, status, address, created_at) 
                VALUES (:user_id, :total, :status, :address, NOW())";
        $stmt = $this->db->prepare($sql);
        $success = $stmt->execute([
            'user_id' => $data['user_id'],
            'total' => $data['total'],
            'status' => $data['status'],
            'address' => $data['address']
        ]);

        if ($success) {
            $orderId = $this->db->lastInsertId();
            // Insert order items
            foreach ($data['items'] as $item) {
                $sql = "INSERT INTO order_items (order_id, product_id, quantity, price) 
                        VALUES (:order_id, :product_id, :quantity, :price)";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    'order_id' => $orderId,
                    'product_id' => $item['product_id'],
                    'quantity' => $item['quantity'],
                    'price' => $item['price']
                ]);

                // Update product stock
                $sql = "UPDATE products 
                        SET stock = stock - :quantity 
                        WHERE product_id = :product_id";
                $stmt = $this->db->prepare($sql);
                $stmt->execute([
                    'quantity' => $item['quantity'],
                    'product_id' => $item['product_id']
                ]);
            }
            return $orderId;
        }
        return false;
    }

    public function update($id, $data) {
        $data['updated_at'] = date('Y-m-d H:i:s');
        return parent::update($id, $data);
    }

    public function getOrdersByUser($userId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE user_id = ? ORDER BY created_at DESC");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrdersBySeller($sellerId) {
        $stmt = $this->db->prepare("
            SELECT o.* FROM {$this->table} o
            JOIN order_items oi ON o.order_id = oi.order_id
            JOIN products p ON oi.product_id = p.product_id
            WHERE p.seller_id = ?
            GROUP BY o.order_id
            ORDER BY o.created_at DESC
        ");
        $stmt->execute([$sellerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getOrderWithItems($orderId) {
        $order = $this->find($orderId);
        if (!$order) {
            return null;
        }

        $stmt = $this->db->prepare("
            SELECT oi.*, p.name, p.image, p.seller_id 
            FROM order_items oi 
            JOIN products p ON oi.product_id = p.product_id 
            WHERE oi.order_id = ?
        ");
        $stmt->execute([$orderId]);
        $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);

        return $order;
    }

    public function getOrderItems($orderId) {
        $stmt = $this->db->prepare("SELECT * FROM order_items WHERE order_id = ?");
        $stmt->execute([$orderId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function addItem($orderId, $productId, $quantity, $price) {
        $stmt = $this->db->prepare("
            INSERT INTO order_items (order_id, product_id, quantity, price)
            VALUES (?, ?, ?, ?)
        ");
        return $stmt->execute([$orderId, $productId, $quantity, $price]);
    }

    public function updateStatus($id, $status) {
        $sql = "UPDATE {$this->table} SET status = :status, updated_at = NOW() WHERE order_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'status' => $status
        ]);
    }

    public function getTotalSales() {
        $stmt = $this->db->prepare("SELECT SUM(total) as total_sales FROM {$this->table} WHERE status = 'completed'");
        $stmt->execute();
        $result = $stmt->fetch(PDO::FETCH_ASSOC);
        return $result['total_sales'] ?? 0;
    }

    public function generateReport($period) {
        $sql = "SELECT 
            DATE(created_at) as date,
            COUNT(*) as total_orders,
            SUM(total) as total_sales
            FROM {$this->table}
            WHERE status = 'completed'";

        switch ($period) {
            case 'daily':
                $sql .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 1 DAY)";
                break;
            case 'weekly':
                $sql .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 1 WEEK)";
                break;
            case 'monthly':
                $sql .= " AND created_at >= DATE_SUB(NOW(), INTERVAL 1 MONTH)";
                break;
        }

        $sql .= " GROUP BY DATE(created_at) ORDER BY date DESC";

        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function count() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getRecent($limit = 5) {
        $sql = "SELECT o.*, u.username 
                FROM {$this->table} o 
                LEFT JOIN users u ON o.user_id = u.user_id 
                ORDER BY o.created_at DESC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getTotalSalesBySeller($sellerId) {
        $sql = "SELECT COALESCE(SUM(oi.price * oi.quantity), 0) as total 
                FROM order_items oi 
                INNER JOIN products p ON oi.product_id = p.product_id 
                WHERE p.seller_id = :seller_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['seller_id' => $sellerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['total'];
    }

    public function getRecentBySeller($sellerId, $limit = 5) {
        $sql = "SELECT DISTINCT o.*, u.username 
                FROM {$this->table} o 
                INNER JOIN order_items oi ON o.order_id = oi.order_id 
                INNER JOIN products p ON oi.product_id = p.product_id 
                LEFT JOIN users u ON o.user_id = u.user_id 
                WHERE p.seller_id = :seller_id 
                ORDER BY o.created_at DESC 
                LIMIT :limit";
        $stmt = $this->db->prepare($sql);
        $stmt->bindValue(':seller_id', $sellerId, PDO::PARAM_INT);
        $stmt->bindValue(':limit', $limit, PDO::PARAM_INT);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function find($id) {
        $sql = "SELECT o.*, u.username, u.email 
                FROM {$this->table} o 
                LEFT JOIN users u ON o.user_id = u.user_id 
                WHERE o.order_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        $order = $stmt->fetch(PDO::FETCH_ASSOC);

        if ($order) {
            // Get order items
            $sql = "SELECT oi.*, p.name as product_name, p.image 
                    FROM order_items oi 
                    LEFT JOIN products p ON oi.product_id = p.product_id 
                    WHERE oi.order_id = :order_id";
            $stmt = $this->db->prepare($sql);
            $stmt->execute(['order_id' => $id]);
            $order['items'] = $stmt->fetchAll(PDO::FETCH_ASSOC);
        }

        return $order;
    }
} 