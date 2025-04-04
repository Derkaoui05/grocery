<?php

class Product extends Model {
    protected $table = 'products';
    protected $primaryKey = 'product_id';

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        $sql = "INSERT INTO {$this->table} (name, description, price, stock, image, category_id, seller_id, created_at) 
                VALUES (:name, :description, :price, :stock, :image, :category_id, :seller_id, NOW())";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image' => $data['image'],
            'category_id' => $data['category_id'],
            'seller_id' => $data['seller_id']
        ]);
    }

    public function update($id, $data) {
        $sql = "UPDATE {$this->table} SET 
                name = :name,
                description = :description,
                price = :price,
                stock = :stock,
                image = :image,
                category_id = :category_id,
                updated_at = NOW()
                WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute([
            'id' => $id,
            'name' => $data['name'],
            'description' => $data['description'],
            'price' => $data['price'],
            'stock' => $data['stock'],
            'image' => $data['image'],
            'category_id' => $data['category_id']
        ]);
    }

    public function getProductsByCategory($categoryId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE category_id = ?");
        $stmt->execute([$categoryId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductsBySeller($sellerId) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE seller_id = ?");
        $stmt->execute([$sellerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function search($query) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE name LIKE ? OR description LIKE ?");
        $searchQuery = "%{$query}%";
        $stmt->execute([$searchQuery, $searchQuery]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function updateStock($productId, $quantity) {
        $stmt = $this->db->prepare("UPDATE {$this->table} SET stock = stock + ? WHERE {$this->primaryKey} = ?");
        return $stmt->execute([$quantity, $productId]);
    }

    public function getExpiringProducts() {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE expiration_date <= DATE_ADD(CURDATE(), INTERVAL 7 DAY)
            AND expiration_date >= CURDATE()
            ORDER BY expiration_date ASC
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getLowStockProducts($threshold = 10) {
        $stmt = $this->db->prepare("
            SELECT * FROM {$this->table} 
            WHERE stock <= ?
            ORDER BY stock ASC
        ");
        $stmt->execute([$threshold]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function applyPromotion($productId, $discount, $type = 'percentage') {
        $product = $this->find($productId);
        if (!$product) {
            return false;
        }

        $newPrice = $product['price'];
        if ($type === 'percentage') {
            $newPrice = $product['price'] * (1 - ($discount / 100));
        } else {
            $newPrice = $product['price'] - $discount;
        }

        return $this->update($productId, [
            'price' => $newPrice,
            'promotion' => $discount
        ]);
    }

    public function removePromotion($productId) {
        $product = $this->find($productId);
        if (!$product) {
            return false;
        }

        return $this->update($productId, [
            'price' => $product['original_price'] ?? $product['price'],
            'promotion' => 0
        ]);
    }

    public function count() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function countBySeller($sellerId) {
        $sql = "SELECT COUNT(*) as count FROM {$this->table} WHERE seller_id = :seller_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['seller_id' => $sellerId]);
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }

    public function getBySeller($sellerId) {
        $sql = "SELECT * FROM {$this->table} WHERE seller_id = :seller_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['seller_id' => $sellerId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function delete($id) {
        $sql = "DELETE FROM {$this->table} WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        return $stmt->execute(['id' => $id]);
    }

    public function find($id) {
        $sql = "SELECT * FROM {$this->table} WHERE product_id = :id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute(['id' => $id]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function getAll() {
        $sql = "SELECT p.*, c.name as category_name 
                FROM {$this->table} p 
                LEFT JOIN categories c ON p.category_id = c.category_id";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 