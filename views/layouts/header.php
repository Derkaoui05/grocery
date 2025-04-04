<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>E-Commerce Store</title>
    <script src="https://cdn.tailwindcss.com"></script>
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
</head>
<body class="bg-gray-100">
    <nav class="bg-white shadow-lg">
        <div class="container mx-auto px-4">
            <div class="flex justify-between items-center h-16">
                <div class="flex items-center">
                    <a href="/ensa/ecommerce" class="text-xl font-bold text-blue-600">E-Commerce</a>
                </div>
                
                <div class="flex items-center space-x-4">
                    <a href="/ensa/ecommerce/products" class="text-gray-600 hover:text-blue-600">Products</a>
                    <a href="/ensa/ecommerce/cart" class="text-gray-600 hover:text-blue-600">
                        <i class="fas fa-shopping-cart"></i>
                    </a>
                    <?php if (isset($_SESSION['user'])): ?>
                        <div class="relative">
                            <button class="flex items-center text-gray-600 hover:text-blue-600">
                                <i class="fas fa-user mr-2"></i>
                                <?= htmlspecialchars($_SESSION['user']['username']); ?>
                            </button>
                            <div class="absolute right-0 mt-2 w-48 bg-white rounded-md shadow-lg py-1 hidden">
                                <a href="/ensa/ecommerce/profile" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Profile</a>
                                <a href="/ensa/ecommerce/orders" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Orders</a>
                                <a href="/ensa/ecommerce/logout" class="block px-4 py-2 text-sm text-gray-700 hover:bg-gray-100">Logout</a>
                            </div>
                        </div>
                    <?php else: ?>
                        <a href="/ensa/ecommerce/login" class="text-gray-600 hover:text-blue-600">Login</a>
                        <a href="/ensa/ecommerce/register" class="bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700">Register</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </nav>

    <main class="min-h-screen"> 