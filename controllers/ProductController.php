<?php

class ProductController extends Controller {
    public function index() {
        $products = $this->productModel->findAll();
        $categories = $this->categoryModel->findAll();
        $this->render('products/index', [
            'products' => $products,
            'categories' => $categories
        ]);
    }

    public function show($id) {
        $product = $this->productModel->find($id);
        if (!$product) {
            $this->redirect('/products');
        }

        $reviews = $this->reviewModel->getProductReviews($id);
        $averageRating = $this->reviewModel->getProductAverageRating($id);

        $this->render('products/show', [
            'product' => $product,
            'reviews' => $reviews,
            'averageRating' => $averageRating
        ]);
    }

    public function create() {
        $this->auth->requireSeller();
        
        if ($_SERVER['REQUEST_METHOD'] === 'POST') {
            $data = [
                'name' => $_POST['name'] ?? '',
                'description' => $_POST['description'] ?? '',
                'price' => $_POST['price'] ?? 0,
                'stock' => $_POST['stock'] ?? 0,
                'category_id' => $_POST['category_id'] ?? null,
                'seller_id' => $this->auth->getUser()['user_id']
            ];

            // Handle image upload
            if (isset($_FILES['image']) && $_FILES['image']['error'] === UPLOAD_ERR_OK) {
                $uploadDir = 'public/uploads/products/';
                if (!file_exists($uploadDir)) {
                    mkdir($uploadDir, 0777, true);
                }
                
                $fileExtension = strtolower(pathinfo($_FILES['image']['name'], PATHINFO_EXTENSION));
                $allowedExtensions = ['jpg', 'jpeg', 'png', 'gif'];
                
                if (!in_array($fileExtension, $allowedExtensions)) {
                    $this->render('products/create', ['error' => 'Type de fichier non autorisé. Utilisez JPG, PNG ou GIF.']);
                    return;
                }
                
                $fileName = uniqid() . '.' . $fileExtension;
                $uploadPath = $uploadDir . $fileName;

                if (move_uploaded_file($_FILES['image']['tmp_name'], $uploadPath)) {
                    // Store the path relative to the project root
                    $data['image'] = $uploadPath; // This will store: public/uploads/products/filename.ext
                } else {
                    $this->render('products/create', ['error' => 'Failed to upload image']);
                    return;
                }
            } else {
                // Store the default image path relative to the project root
                $data['image'] = 'public/uploads/products/default.jpg';
            }

            if ($this->productModel->create($data)) {
                $this->redirect('/products');
            } else {
                $this->render('products/create', ['error' => 'Failed to create product']);
            }
        } else {
            $categories = $this->categoryModel->findAll();
            $this->render('products/create', ['categories' => $categories]);
        }
    }

    public function search() {
        $query = $_GET['q'] ?? '';
        $products = $this->productModel->search($query);
        $this->render('products/search', [
            'products' => $products,
            'query' => $query
        ]);
    }
} 