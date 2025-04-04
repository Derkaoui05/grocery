<?php
$content = '
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-2xl mx-auto text-center">
            <svg class="h-12 w-12 text-green-500 mx-auto" fill="none" stroke="currentColor" viewBox="0 0 24 24" xmlns="http://www.w3.org/2000/svg">
                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"></path>
            </svg>
            <h1 class="mt-4 text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">
                Commande confirmée
            </h1>
            <p class="mt-4 text-base text-gray-500">
                Votre commande a été enregistrée avec succès. Voici les détails de votre commande.
            </p>
        </div>

        <div class="mt-16 max-w-2xl mx-auto">
            <div class="bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8">
                <h2 class="text-lg font-medium text-gray-900">Détails de la commande</h2>

                <dl class="mt-6 space-y-6 divide-y divide-gray-200">
                    <div class="pt-6 flex items-center justify-between">
                        <dt class="text-sm font-medium text-gray-900">Numéro de commande</dt>
                        <dd class="text-sm text-gray-500"><?php echo $order[\'id\']; ?></dd>
                    </div>

                    <div class="pt-6 flex items-center justify-between">
                        <dt class="text-sm font-medium text-gray-900">Date de commande</dt>
                        <dd class="text-sm text-gray-500"><?php echo date(\'d/m/Y H:i\', strtotime($order[\'created_at\'])); ?></dd>
                    </div>

                    <div class="pt-6 flex items-center justify-between">
                        <dt class="text-sm font-medium text-gray-900">Statut</dt>
                        <dd class="text-sm text-gray-500"><?php echo $order[\'status\']; ?></dd>
                    </div>

                    <div class="pt-6 flex items-center justify-between">
                        <dt class="text-sm font-medium text-gray-900">Méthode de paiement</dt>
                        <dd class="text-sm text-gray-500"><?php echo $order[\'payment_method\']; ?></dd>
                    </div>

                    <div class="pt-6 flex items-center justify-between">
                        <dt class="text-sm font-medium text-gray-900">Total</dt>
                        <dd class="text-sm font-medium text-gray-900"><?php echo number_format($order[\'total\'], 2); ?> MAD</dd>
                    </div>
                </dl>
            </div>

            <div class="mt-8">
                <h2 class="text-lg font-medium text-gray-900">Articles commandés</h2>

                <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                    <ul role="list" class="divide-y divide-gray-200">
                        <?php foreach ($order_items as $item): ?>
                        <li class="flex py-6 px-4 sm:px-6">
                            <div class="flex-shrink-0">
                                <img src="<?php echo $item[\'product_image\']; ?>" alt="<?php echo $item[\'product_name\']; ?>" class="w-20 rounded-md">
                            </div>

                            <div class="ml-6 flex-1 flex flex-col">
                                <div class="flex">
                                    <div class="min-w-0 flex-1">
                                        <h4 class="text-sm">
                                            <a href="/ensa/ecommerce/product/<?php echo $item[\'product_id\']; ?>" class="font-medium text-gray-700 hover:text-gray-800">
                                                <?php echo $item[\'product_name\']; ?>
                                            </a>
                                        </h4>
                                        <p class="mt-1 text-sm text-gray-500">Quantité: <?php echo $item[\'quantity\']; ?></p>
                                    </div>

                                    <div class="ml-4 flex-shrink-0 flow-root">
                                        <p class="text-sm font-medium text-gray-900"><?php echo number_format($item[\'price\'] * $item[\'quantity\'], 2); ?> MAD</p>
                                    </div>
                                </div>
                            </div>
                        </li>
                        <?php endforeach; ?>
                    </ul>
                </div>
            </div>

            <div class="mt-8">
                <h2 class="text-lg font-medium text-gray-900">Adresse de livraison</h2>

                <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm px-4 py-6 sm:px-6">
                    <p class="text-sm text-gray-500">
                        <?php echo $order[\'shipping_address\']; ?><br>
                        <?php echo $order[\'shipping_city\']; ?>, <?php echo $order[\'shipping_postal_code\']; ?><br>
                        Téléphone: <?php echo $order[\'shipping_phone\']; ?>
                    </p>
                </div>
            </div>

            <div class="mt-8">
                <a href="/ensa/ecommerce/products" class="w-full flex justify-center items-center px-4 py-2 border border-transparent rounded-md shadow-sm text-sm font-medium text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Continuer vos achats
                </a>
            </div>
        </div>
    </div>
</div>
';

require_once 'layouts/main.php'; 