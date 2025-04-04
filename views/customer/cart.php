<?php
$content = '
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <h1 class="text-3xl font-extrabold tracking-tight text-gray-900 sm:text-4xl">Panier</h1>

        <div class="mt-12 lg:grid lg:grid-cols-12 lg:gap-x-12 lg:items-start xl:gap-x-16">
            <section aria-labelledby="cart-heading" class="lg:col-span-7">
                <h2 id="cart-heading" class="sr-only">Articles dans votre panier</h2>

                <ul role="list" class="border-t border-b border-gray-200 divide-y divide-gray-200">
                    <?php foreach ($cart_items as $item): ?>
                    <li class="flex py-6 sm:py-10">
                        <div class="flex-shrink-0">
                            <img src="<?php echo $item[\'product_image\']; ?>" alt="<?php echo $item[\'product_name\']; ?>" class="w-24 h-24 rounded-md object-center object-cover sm:w-32 sm:h-32">
                        </div>

                        <div class="ml-4 flex-1 flex flex-col sm:ml-6">
                            <div>
                                <div class="flex justify-between">
                                    <h4 class="text-sm">
                                        <a href="/ensa/ecommerce/product/<?php echo $item[\'product_id\']; ?>" class="font-medium text-gray-700 hover:text-gray-800">
                                            <?php echo $item[\'product_name\']; ?>
                                        </a>
                                    </h4>
                                    <p class="ml-4 text-sm font-medium text-gray-900"><?php echo number_format($item[\'price\'], 2); ?> MAD</p>
                                </div>
                                <p class="mt-1 text-sm text-gray-500">Vendeur: <?php echo $item[\'seller_name\']; ?></p>
                            </div>

                            <div class="mt-4 flex-1 flex items-end justify-between">
                                <p class="flex items-center text-sm text-gray-700 space-x-2">
                                    <span>Quantité:</span>
                                    <form class="flex items-center" action="/ensa/ecommerce/cart/update" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $item[\'product_id\']; ?>">
                                        <input type="number" name="quantity" value="<?php echo $item[\'quantity\']; ?>" min="1" max="<?php echo $item[\'stock\']; ?>" class="w-16 text-center border-gray-300 rounded-md">
                                        <button type="submit" class="ml-2 text-sm font-medium text-blue-600 hover:text-blue-500">Mettre à jour</button>
                                    </form>
                                </p>

                                <div class="ml-4">
                                    <form action="/ensa/ecommerce/cart/remove" method="POST">
                                        <input type="hidden" name="product_id" value="<?php echo $item[\'product_id\']; ?>">
                                        <button type="submit" class="text-sm font-medium text-red-600 hover:text-red-500">
                                            Supprimer
                                        </button>
                                    </form>
                                </div>
                            </div>
                        </div>
                    </li>
                    <?php endforeach; ?>
                </ul>
            </section>

            <!-- Order summary -->
            <section aria-labelledby="summary-heading" class="mt-16 bg-gray-50 rounded-lg px-4 py-6 sm:p-6 lg:p-8 lg:mt-0 lg:col-span-5">
                <h2 id="summary-heading" class="text-lg font-medium text-gray-900">Résumé de la commande</h2>

                <dl class="mt-6 space-y-4">
                    <div class="flex items-center justify-between">
                        <dt class="text-sm text-gray-600">Sous-total</dt>
                        <dd class="text-sm font-medium text-gray-900"><?php echo number_format($subtotal, 2); ?> MAD</dd>
                    </div>
                    <div class="border-t border-gray-200 pt-4 flex items-center justify-between">
                        <dt class="text-base font-medium text-gray-900">Total</dt>
                        <dd class="text-base font-medium text-gray-900"><?php echo number_format($total, 2); ?> MAD</dd>
                    </div>
                </dl>

                <div class="mt-6">
                    <a href="/ensa/ecommerce/checkout" class="w-full bg-blue-600 border border-transparent rounded-md shadow-sm py-3 px-4 text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-blue-500">
                        Passer la commande
                    </a>
                </div>
            </section>
        </div>
    </div>
</div>
';

require_once 'layouts/main.php'; 