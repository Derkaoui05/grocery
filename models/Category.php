<?php

class Category extends Model {
    protected $table = 'categories';
    protected $primaryKey = 'category_id';

    public function __construct() {
        parent::__construct();
    }

    public function getProducts($categoryId) {
        $productModel = new Product();
        return $productModel->getProductsByCategory($categoryId);
    }

    public function getCategoriesWithProductCount() {
        $stmt = $this->db->prepare("
            SELECT c.*, COUNT(p.product_id) as product_count 
            FROM {$this->table} c 
            LEFT JOIN products p ON c.category_id = p.category_id 
            GROUP BY c.category_id
        ");
        $stmt->execute();
        return $stmt->fetchAll(PDO::FETCH_ASSOC);
    }
} 