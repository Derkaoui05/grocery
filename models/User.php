<?php

class User extends Model {
    protected $table = 'users';
    protected $primaryKey = 'user_id';

    public function __construct() {
        parent::__construct();
    }

    public function register($data) {
        // Validate required fields
        $required = ['username', 'email', 'password'];
        foreach ($required as $field) {
            if (empty($data[$field])) {
                return false;
            }
        }

        // Check if email already exists
        if ($this->findByEmail($data['email'])) {
            return false;
        }

        // Hash password
        $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        
        // Add timestamps
        $data['created_at'] = date('Y-m-d H:i:s');
        $data['updated_at'] = date('Y-m-d H:i:s');
        
        // Set default role if not provided
        if (!isset($data['role'])) {
            $data['role'] = 'customer';
        }

        return $this->create($data);
    }

    public function login($email, $password) {
        // Validate input
        if (empty($email) || empty($password)) {
            return false;
        }

        // Find user by email
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        $user = $stmt->fetch(PDO::FETCH_ASSOC);

        // Verify password
        if ($user && password_verify($password, $user['password'])) {
            // Remove sensitive data
            unset($user['password']);
            return $user;
        }

        return false;
    }

    public function findByEmail($email) {
        $stmt = $this->db->prepare("SELECT * FROM {$this->table} WHERE email = ?");
        $stmt->execute([$email]);
        return $stmt->fetch(PDO::FETCH_ASSOC);
    }

    public function updateProfile($userId, $data) {
        // Hash password if it's being updated
        if (!empty($data['password'])) {
            $data['password'] = password_hash($data['password'], PASSWORD_DEFAULT);
        }

        $data['updated_at'] = date('Y-m-d H:i:s');
        return $this->update($userId, $data);
    }

    public function isAdmin($userId) {
        $user = $this->find($userId);
        return $user && $user['role'] === 'admin';
    }

    public function isSeller($userId) {
        $user = $this->find($userId);
        return $user && $user['role'] === 'seller';
    }

    public function isCustomer($userId) {
        $user = $this->find($userId);
        return $user && $user['role'] === 'customer';
    }

    public function count() {
        $sql = "SELECT COUNT(*) as count FROM {$this->table}";
        $stmt = $this->db->prepare($sql);
        $stmt->execute();
        return $stmt->fetch(PDO::FETCH_ASSOC)['count'];
    }
} 