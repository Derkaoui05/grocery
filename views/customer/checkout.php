<?php
$content = '
<div class="bg-gray-50">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="max-w-2xl mx-auto lg:max-w-none">
            <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Finaliser la commande</h1>

            <form class="mt-8 lg:grid lg:grid-cols-2 lg:gap-x-12 xl:gap-x-16" action="/ensa/ecommerce/order/create" method="POST">
                <div>
                    <div>
                        <h2 class="text-lg font-medium text-gray-900">Informations de livraison</h2>

                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div>
                                <label for="first-name" class="block text-sm font-medium text-gray-700">Prénom</label>
                                <div class="mt-1">
                                    <input type="text" id="first-name" name="first_name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label for="last-name" class="block text-sm font-medium text-gray-700">Nom</label>
                                <div class="mt-1">
                                    <input type="text" id="last-name" name="last_name" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                                <div class="mt-1">
                                    <input type="text" id="address" name="address" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                                <div class="mt-1">
                                    <input type="text" id="city" name="city" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>

                            <div>
                                <label for="postal-code" class="block text-sm font-medium text-gray-700">Code postal</label>
                                <div class="mt-1">
                                    <input type="text" id="postal-code" name="postal_code" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>

                            <div class="sm:col-span-2">
                                <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                <div class="mt-1">
                                    <input type="tel" id="phone" name="phone" class="block w-full border-gray-300 rounded-md shadow-sm focus:ring-blue-500 focus:border-blue-500 sm:text-sm">
                                </div>
                            </div>
                        </div>
                    </div>

                    <div class="mt-10 border-t border-gray-200 pt-10">
                        <h2 class="text-lg font-medium text-gray-900">Méthode de paiement</h2>

                        <div class="mt-4 grid grid-cols-1 gap-y-6 sm:grid-cols-2 sm:gap-x-4">
                            <div class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                                <input type="radio" name="payment_method" value="cash" class="sr-only" aria-labelledby="payment-method-0-label" aria-describedby="payment-method-0-description">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span id="payment-method-0-label" class="block text-sm font-medium text-gray-900">Paiement à la livraison</span>
                                        <span id="payment-method-0-description" class="mt-1 flex items-center text-sm text-gray-500">Payer en espèces à la livraison</span>
                                    </span>
                                </span>
                            </div>

                            <div class="relative flex cursor-pointer rounded-lg border bg-white p-4 shadow-sm focus:outline-none">
                                <input type="radio" name="payment_method" value="card" class="sr-only" aria-labelledby="payment-method-1-label" aria-describedby="payment-method-1-description">
                                <span class="flex flex-1">
                                    <span class="flex flex-col">
                                        <span id="payment-method-1-label" class="block text-sm font-medium text-gray-900">Carte bancaire</span>
                                        <span id="payment-method-1-description" class="mt-1 flex items-center text-sm text-gray-500">Payer avec votre carte bancaire</span>
                                    </span>
                                </span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Order summary -->
                <div class="mt-10 lg:mt-0">
                    <h2 class="text-lg font-medium text-gray-900">Résumé de la commande</h2>

                    <div class="mt-4 bg-white border border-gray-200 rounded-lg shadow-sm">
                        <h3 class="sr-only">Articles dans votre panier</h3>
                        <ul role="list" class="divide-y divide-gray-200">
                            <?php foreach ($cart_items as $item): ?>
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
                        <dl class="border-t border-gray-200 py-6 px-4 space-y-6 sm:px-6">
                            <div class="flex items-center justify-between">
                                <dt class="text-sm">Sous-total</dt>
                                <dd class="text-sm font-medium text-gray-900"><?php echo number_format($subtotal, 2); ?> MAD</dd>
                            </div>
                            <div class="flex items-center justify-between">
                                <dt class="text-sm">Frais de livraison</dt>
                                <dd class="text-sm font-medium text-gray-900"><?php echo number_format($shipping, 2); ?> MAD</dd>
                            </div>
                            <div class="flex items-center justify-between border-t border-gray-200 pt-6">
                                <dt class="text-base font-medium">Total</dt>
                                <dd class="text-base font-medium text-gray-900"><?php echo number_format($total, 2); ?> MAD</dd>
                            </div>
                        </dl>

                        <div class="border-t border-gray-200 py-6 px-4 sm:px-6">
                            <button type="submit" class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-blue-500">
                                Confirmer la commande
                            </button>
                        </div>
                    </div>
                </div>
            </form>
        </div>
    </div>
</div>
';

require_once 'layouts/main.php'; 