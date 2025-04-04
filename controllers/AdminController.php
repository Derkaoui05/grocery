<?php

class AdminController extends Controller {
    public function __construct() {
        parent::__construct();
        $this->auth->requireAdmin();
    }

    public function dashboard() {
        $stats = [
            'total_users' => count($this->userModel->findAll()),
            'total_products' => count($this->productModel->findAll()),
            'total_orders' => count($this->orderModel->findAll()),
            'total_sales' => $this->orderModel->getTotalSales()
        ];
        
        $this->render('admin/dashboard', ['stats' => $stats]);
    }

    public function users() {
        $users = $this->userModel->findAll();
        $this->render('admin/users', ['users' => $users]);
    }

    public function manageUser($userId) {
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'username' => $_POST['username'],
                'email' => $_POST['email'],
                'role' => $_POST['role']
            ];
            
            if (!empty($_POST['password'])) {
                $data['password'] = password_hash($_POST['password'], PASSWORD_DEFAULT);
            }
            
            $this->userModel->update($userId, $data);
            $this->redirect('/admin/users');
        }
        
        $user = $this->userModel->find($userId);
        $this->render('admin/edit_user', ['user' => $user]);
    }

    public function deleteUser($userId) {
        $this->userModel->delete($userId);
        $this->redirect('/admin/users');
    }

    public function reports() {
        $period = $_GET['period'] ?? 'daily';
        $report = $this->orderModel->generateReport($period);
        $this->render('admin/reports', ['report' => $report, 'period' => $period]);
    }

    public function exportReport() {
        $period = $_GET['period'] ?? 'daily';
        $format = $_GET['format'] ?? 'pdf';
        $report = $this->orderModel->generateReport($period);
        
        if ($format === 'excel') {
            $this->exportExcel($report);
        } else {
            $this->exportPDF($report);
        }
    }

    private function exportExcel($data) {
        // Implement Excel export
        header('Content-Type: application/vnd.ms-excel');
        header('Content-Disposition: attachment; filename="report.xlsx"');
        // Excel generation logic here
    }

    private function exportPDF($data) {
        // Implement PDF export
        header('Content-Type: application/pdf');
        header('Content-Disposition: attachment; filename="report.pdf"');
        // PDF generation logic here
    }
} 