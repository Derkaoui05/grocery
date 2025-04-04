<?php

class Review extends Model {
    protected $table = 'reviews';
    protected $primaryKey = 'review_id';

    public function __construct() {
        parent::__construct();
    }

    public function create($data) {
        $data['created_at'] = date('Y-m-d H:i:s');
        return parent::create($data);
    }

    public function getProductReviews($productId) {
        $stmt = $this->db->prepare("
            SELECT r.*, u.username 
            FROM {$this->table} r 
            JOIN users u ON r.user_id = u.user_id 
            WHERE r.product_id = ? 
            ORDER BY r.created_at DESC
        ");
        $stmt->execute([$productId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getUserReviews($userId) {
        $stmt = $this->db->prepare("
            SELECT r.*, p.name as product_name 
            FROM {$this->table} r 
            JOIN products p ON r.product_id = p.product_id 
            WHERE r.user_id = ? 
            ORDER BY r.created_at DESC
        ");
        $stmt->execute([$userId]);
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }

    public function getProductAverageRating($productId) {
        $stmt = $this->db->prepare("
            SELECT AVG(rating) as average_rating, COUNT(*) as total_reviews 
            FROM {$this->table} 
            WHERE product_id = ?
        ");
        $stmt->execute([$productId]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }
} 