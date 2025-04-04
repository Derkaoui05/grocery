<?php
require_once 'models/Product.php';
require_once 'models/Order.php';

$productModel = new Product();
$orderModel = new Order();

// Get seller-specific statistics
$sellerId = $_SESSION['user']['user_id'];
$totalProducts = $productModel->countBySeller($sellerId);
$totalSales = $orderModel->getTotalSalesBySeller($sellerId);
$recentOrders = $orderModel->getRecentBySeller($sellerId, 5);
?>

<!DOCTYPE html>
<html lang="fr">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>Dashboard Vendeur</title>
    <script src="https://cdn.tailwindcss.com"></script>
</head>
<body class="bg-gray-100">
    <?php include 'views/partials/navbar.php'; ?>

    <div class="container mx-auto px-4 py-8">
        <h1 class="text-3xl font-bold mb-8">Dashboard Vendeur</h1>

        <!-- Statistics Cards -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-gray-500 text-sm font-medium">Mes Produits</h3>
                <p class="text-3xl font-bold"><?php echo $totalProducts; ?></p>
            </div>
            <div class="bg-white rounded-lg shadow p-6">
                <h3 class="text-gray-500 text-sm font-medium">Ventes Totales</h3>
                <p class="text-3xl font-bold"><?php echo number_format($totalSales, 2); ?> €</p>
            </div>
        </div>

        <!-- Quick Actions -->
        <div class="grid grid-cols-1 md:grid-cols-2 gap-6 mb-8">
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Actions Rapides</h2>
                <div class="space-y-4">
                    <a href="/ensa/ecommerce/products/create" class="block bg-blue-500 text-white rounded px-4 py-2 text-center hover:bg-blue-600">Ajouter un Produit</a>
                    <a href="/ensa/ecommerce/seller/products" class="block bg-green-500 text-white rounded px-4 py-2 text-center hover:bg-green-600">Gérer Mes Produits</a>
                    <a href="/ensa/ecommerce/seller/orders" class="block bg-yellow-500 text-white rounded px-4 py-2 text-center hover:bg-yellow-600">Voir Mes Commandes</a>
                </div>
            </div>

            <!-- Recent Orders -->
            <div class="bg-white rounded-lg shadow p-6">
                <h2 class="text-xl font-bold mb-4">Commandes Récentes</h2>
                <div class="space-y-4">
                    <?php foreach ($recentOrders as $order): ?>
                    <div class="border-b pb-2">
                        <p class="font-medium">Commande #<?php echo $order['order_id']; ?></p>
                        <p class="text-sm text-gray-500">
                            Total: <?php echo number_format($order['total'], 2); ?> €
                            <span class="ml-2 px-2 py-1 rounded text-xs <?php echo $order['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                <?php echo ucfirst($order['status']); ?>
                            </span>
                        </p>
                    </div>
                    <?php endforeach; ?>
                </div>
            </div>
        </div>

        <!-- Products Table -->
        <div class="bg-white rounded-lg shadow overflow-hidden">
            <div class="p-6">
                <h2 class="text-xl font-bold mb-4">Mes Produits</h2>
                <div class="overflow-x-auto">
                    <table class="min-w-full divide-y divide-gray-200">
                        <thead class="bg-gray-50">
                            <tr>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Nom</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Prix</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Stock</th>
                                <th class="px-6 py-3 text-left text-xs font-medium text-gray-500 uppercase tracking-wider">Actions</th>
                            </tr>
                        </thead>
                        <tbody class="bg-white divide-y divide-gray-200">
                            <?php 
                            $products = $productModel->getBySeller($sellerId);
                            foreach ($products as $product): 
                            ?>
                            <tr>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm font-medium text-gray-900"><?php echo htmlspecialchars($product['name']); ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo number_format($product['price'], 2); ?> €</div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap">
                                    <div class="text-sm text-gray-900"><?php echo $product['stock']; ?></div>
                                </td>
                                <td class="px-6 py-4 whitespace-nowrap text-sm font-medium">
                                    <a href="/ensa/ecommerce/products/edit/<?php echo $product['product_id']; ?>" class="text-indigo-600 hover:text-indigo-900 mr-3">Modifier</a>
                                    <a href="/ensa/ecommerce/products/delete/<?php echo $product['product_id']; ?>" class="text-red-600 hover:text-red-900" onclick="return confirm('Êtes-vous sûr de vouloir supprimer ce produit ?')">Supprimer</a>
                                </td>
                            </tr>
                            <?php endforeach; ?>
                        </tbody>
                    </table>
                </div>
            </div>
        </div>
    </div>
</body>
</html> 