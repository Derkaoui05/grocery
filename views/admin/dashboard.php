<?php
require_once 'models/User.php';
require_once 'models/Product.php';
require_once 'models/Order.php';

$userModel = new User();
$productModel = new Product();
$orderModel = new Order();

// Get statistics
$totalUsers = $userModel->count();
$totalProducts = $productModel->count();
$totalOrders = $orderModel->count();
$recentOrders = $orderModel->getRecent(5);

ob_start();
?>

<!-- Add Font Awesome and Chart.js -->
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.0.0/css/all.min.css">
<script src="https://cdn.jsdelivr.net/npm/chart.js"></script>

<div class="min-h-screen bg-gray-100">
    <div class="py-6">
        <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
            <!-- Welcome Section -->
            <div class="bg-gradient-to-r from-purple-600 to-blue-600 rounded-lg shadow-lg p-6 mb-8">
                <div class="flex items-center justify-between">
                    <div>
                        <h1 class="text-3xl font-bold text-white mb-2">Bienvenue dans votre Dashboard</h1>
                        <p class="text-purple-100">Gérez votre e-commerce en un coup d'œil</p>
                    </div>
                    <div class="text-white text-right">
                        <p class="text-sm"><?php echo date('l, d M Y'); ?></p>
                        <p class="text-2xl font-bold" id="time">00:00:00</p>
                    </div>
                </div>
            </div>

            <!-- Statistics Cards -->
            <div class="grid grid-cols-1 md:grid-cols-4 gap-6 mb-8">
                <div class="bg-white rounded-lg shadow-md p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-blue-100 bg-opacity-75">
                            <i class="fas fa-users text-2xl text-blue-600"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-gray-500 text-sm">Utilisateurs</h2>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $totalUsers; ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-green-100 bg-opacity-75">
                            <i class="fas fa-box text-2xl text-green-600"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-gray-500 text-sm">Produits</h2>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $totalProducts; ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-yellow-100 bg-opacity-75">
                            <i class="fas fa-shopping-cart text-2xl text-yellow-600"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-gray-500 text-sm">Commandes</h2>
                            <p class="text-3xl font-bold text-gray-800"><?php echo $totalOrders; ?></p>
                        </div>
                    </div>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6 transform hover:scale-105 transition-transform duration-200">
                    <div class="flex items-center">
                        <div class="p-3 rounded-full bg-purple-100 bg-opacity-75">
                            <i class="fas fa-money-bill-wave text-2xl text-purple-600"></i>
                        </div>
                        <div class="ml-4">
                            <h2 class="text-gray-500 text-sm">Revenu Total</h2>
                            <p class="text-3xl font-bold text-gray-800">€<?php echo number_format($totalOrders * 100, 2); ?></p>
                        </div>
                    </div>
                </div>
            </div>

            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8 mb-8">
                <!-- Quick Actions -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-bolt text-yellow-500 mr-2"></i>
                        Actions Rapides
                    </h2>
                    <div class="grid grid-cols-1 md:grid-cols-2 gap-4">
                        <a href="/ensa/ecommerce/admin/users" class="flex items-center p-4 bg-blue-50 rounded-lg hover:bg-blue-100 transition-colors duration-200">
                            <i class="fas fa-users text-blue-600 text-2xl"></i>
                            <span class="ml-3 font-medium text-blue-600">Gérer les Utilisateurs</span>
                        </a>
                        <a href="/ensa/ecommerce/admin/products" class="flex items-center p-4 bg-green-50 rounded-lg hover:bg-green-100 transition-colors duration-200">
                            <i class="fas fa-box text-green-600 text-2xl"></i>
                            <span class="ml-3 font-medium text-green-600">Gérer les Produits</span>
                        </a>
                        <a href="/ensa/ecommerce/admin/categories" class="flex items-center p-4 bg-purple-50 rounded-lg hover:bg-purple-100 transition-colors duration-200">
                            <i class="fas fa-tags text-purple-600 text-2xl"></i>
                            <span class="ml-3 font-medium text-purple-600">Gérer les Catégories</span>
                        </a>
                        <a href="/ensa/ecommerce/admin/orders" class="flex items-center p-4 bg-yellow-50 rounded-lg hover:bg-yellow-100 transition-colors duration-200">
                            <i class="fas fa-shopping-cart text-yellow-600 text-2xl"></i>
                            <span class="ml-3 font-medium text-yellow-600">Gérer les Commandes</span>
                        </a>
                    </div>
                </div>

                <!-- Recent Orders -->
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6 flex items-center">
                        <i class="fas fa-clock text-blue-500 mr-2"></i>
                        Commandes Récentes
                    </h2>
                    <div class="space-y-4">
                        <?php foreach ($recentOrders as $order): ?>
                        <div class="flex items-center justify-between p-4 bg-gray-50 rounded-lg hover:bg-gray-100 transition-colors duration-200">
                            <div>
                                <p class="font-medium text-gray-800">Commande #<?php echo $order['order_id']; ?></p>
                                <p class="text-sm text-gray-500">Client: <?php echo $order['username']; ?></p>
                            </div>
                            <div class="text-right">
                                <p class="font-bold text-gray-800">€<?php echo number_format($order['total'], 2); ?></p>
                                <span class="inline-flex items-center px-2.5 py-0.5 rounded-full text-xs font-medium <?php echo $order['status'] === 'completed' ? 'bg-green-100 text-green-800' : 'bg-yellow-100 text-yellow-800'; ?>">
                                    <?php echo ucfirst($order['status']); ?>
                                </span>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>

            <!-- Charts Section -->
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-8">
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Ventes Mensuelles</h2>
                    <canvas id="salesChart" height="200"></canvas>
                </div>
                <div class="bg-white rounded-lg shadow-md p-6">
                    <h2 class="text-xl font-bold text-gray-800 mb-6">Répartition des Produits</h2>
                    <canvas id="productsChart" height="200"></canvas>
                </div>
            </div>
        </div>
    </div>
</div>

<script>
// Update time
function updateTime() {
    const now = new Date();
    document.getElementById('time').textContent = now.toLocaleTimeString();
}
setInterval(updateTime, 1000);
updateTime();

// Sample data for charts
const months = ['Jan', 'Fév', 'Mar', 'Avr', 'Mai', 'Jun'];
const salesData = [30, 45, 35, 50, 40, 60];

// Sales Chart
new Chart(document.getElementById('salesChart'), {
    type: 'line',
    data: {
        labels: months,
        datasets: [{
            label: 'Ventes',
            data: salesData,
            borderColor: '#4F46E5',
            backgroundColor: 'rgba(79, 70, 229, 0.1)',
            tension: 0.4,
            fill: true
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                display: false
            }
        },
        scales: {
            y: {
                beginAtZero: true
            }
        }
    }
});

// Products Chart
new Chart(document.getElementById('productsChart'), {
    type: 'doughnut',
    data: {
        labels: ['Fruits', 'Légumes', 'Produits Laitiers', 'Viandes', 'Boissons'],
        datasets: [{
            data: [30, 25, 20, 15, 10],
            backgroundColor: [
                '#3B82F6',
                '#10B981',
                '#F59E0B',
                '#EF4444',
                '#8B5CF6'
            ]
        }]
    },
    options: {
        responsive: true,
        plugins: {
            legend: {
                position: 'bottom'
            }
        }
    }
});
</script>

<?php
$content = ob_get_clean();
return $content;
?> 