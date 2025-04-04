<?php
require_once 'models/Auth.php';
$auth = Auth::getInstance();
$isLoggedIn = $auth->isLoggedIn();
$isAdmin = $auth->isAdmin();
$isSeller = $auth->isSeller();
?>

<nav class="bg-gray-800">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between h-16">
            <div class="flex items-center">
                <a href="/ensa/ecommerce" class="text-white font-bold">E-Commerce</a>
                <div class="hidden md:block ml-10">
                    <div class="flex items-baseline space-x-4">
                        <a href="/ensa/ecommerce" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Accueil</a>
                        <a href="/ensa/ecommerce/products" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Produits</a>
                        <?php if ($isAdmin): ?>
                        <a href="/ensa/ecommerce/admin" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard Admin</a>
                        <?php endif; ?>
                        <?php if ($isSeller): ?>
                        <a href="/ensa/ecommerce/seller" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Dashboard Vendeur</a>
                        <?php endif; ?>
                    </div>
                </div>
            </div>
            <div class="hidden md:block">
                <div class="ml-4 flex items-center md:ml-6">
                    <?php if ($isLoggedIn): ?>
                    <a href="/ensa/ecommerce/cart" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Panier</a>
                    <div class="ml-3 relative">
                        <div class="relative inline-block text-left">
                            <div>
                                <button type="button" class="inline-flex items-center px-3 py-2 border border-transparent text-sm leading-4 font-medium rounded-md text-gray-300 hover:text-white focus:outline-none" id="user-menu-button" aria-expanded="false" aria-haspopup="true">
                                    <span>Mon Compte</span>
                                    <svg class="-mr-1 ml-2 h-5 w-5" xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                        <path fill-rule="evenodd" d="M5.293 7.293a1 1 0 011.414 0L10 10.586l3.293-3.293a1 1 0 111.414 1.414l-4 4a1 1 0 01-1.414 0l-4-4a1 1 0 010-1.414z" clip-rule="evenodd" />
                                    </svg>
                                </button>
                            </div>
                            <div class="hidden origin-top-right absolute right-0 mt-2 w-48 rounded-md shadow-lg bg-white ring-1 ring-black ring-opacity-5 divide-y divide-gray-100" role="menu" aria-orientation="vertical" aria-labelledby="user-menu-button" tabindex="-1" id="user-menu">
                                <div class="py-1" role="none">
                                    <a href="/ensa/ecommerce/profile" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem">Profile</a>
                                    <?php if ($isAdmin): ?>
                                    <a href="/ensa/ecommerce/admin" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem">Dashboard Admin</a>
                                    <?php endif; ?>
                                    <?php if ($isSeller): ?>
                                    <a href="/ensa/ecommerce/seller" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem">Dashboard Vendeur</a>
                                    <?php endif; ?>
                                    <a href="/ensa/ecommerce/orders" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem">Mes Commandes</a>
                                </div>
                                <div class="py-1" role="none">
                                    <a href="/ensa/ecommerce/logout" class="text-gray-700 block px-4 py-2 text-sm hover:bg-gray-100" role="menuitem">Déconnexion</a>
                                </div>
                            </div>
                        </div>
                    </div>
                    <?php else: ?>
                    <a href="/ensa/ecommerce/login" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Connexion</a>
                    <a href="/ensa/ecommerce/register" class="text-gray-300 hover:text-white px-3 py-2 rounded-md text-sm font-medium">Inscription</a>
                    <?php endif; ?>
                </div>
            </div>
        </div>
    </div>
</nav>

<script>
document.getElementById('user-menu-button').addEventListener('click', function() {
    const menu = document.getElementById('user-menu');
    menu.classList.toggle('hidden');
});

// Close the menu when clicking outside
document.addEventListener('click', function(event) {
    const menu = document.getElementById('user-menu');
    const button = document.getElementById('user-menu-button');
    if (!menu.contains(event.target) && !button.contains(event.target)) {
        menu.classList.add('hidden');
    }
});
</script> 