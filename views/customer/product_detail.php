<?php
$content = '
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8 py-16">
        <div class="lg:grid lg:grid-cols-2 lg:gap-x-8 lg:items-start">
            <!-- Image gallery -->
            <div class="flex flex-col-reverse">
                <div class="mt-6 w-full max-w-2xl mx-auto sm:block lg:max-w-none">
                    <div class="grid grid-cols-1 gap-y-6 gap-x-6 sm:grid-cols-2 lg:grid-cols-1">
                        <div class="aspect-w-3 aspect-h-2 rounded-lg overflow-hidden">
                            <img src="<?php echo $product[\'image_url\']; ?>" alt="<?php echo $product[\'name\']; ?>" class="w-full h-full object-center object-cover">
                        </div>
                    </div>
                </div>
            </div>

            <!-- Product info -->
            <div class="mt-10 px-4 sm:px-0 sm:mt-16 lg:mt-0">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900"><?php echo $product[\'name\']; ?></h1>

                <div class="mt-3">
                    <h2 class="sr-only">Product information</h2>
                    <p class="text-3xl text-gray-900"><?php echo number_format($product[\'price\'], 2); ?> MAD</p>
                </div>

                <div class="mt-6">
                    <h3 class="sr-only">Description</h3>
                    <div class="text-base text-gray-700 space-y-6">
                        <p><?php echo $product[\'description\']; ?></p>
                    </div>
                </div>

                <div class="mt-6">
                    <div class="flex items-center">
                        <p class="text-sm text-gray-500">Stock disponible: <?php echo $product[\'stock\']; ?></p>
                    </div>
                </div>

                <form class="mt-6" action="/ensa/ecommerce/cart/add" method="POST">
                    <input type="hidden" name="product_id" value="<?php echo $product[\'id\']; ?>">
                    <div class="mt-10 flex sm:flex-col1">
                        <button type="submit" class="max-w-xs flex-1 bg-blue-600 border border-transparent rounded-md py-3 px-8 flex items-center justify-center text-base font-medium text-white hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-offset-gray-50 focus:ring-blue-500 sm:w-full">
                            Ajouter au panier
                        </button>
                    </div>
                </form>

                <div class="mt-6">
                    <h3 class="text-sm font-medium text-gray-900">Vendeur</h3>
                    <div class="mt-4">
                        <p class="text-sm text-gray-500"><?php echo $product[\'seller_name\']; ?></p>
                    </div>
                </div>
            </div>
        </div>

        <!-- Reviews section -->
        <div class="mt-16">
            <h2 class="text-lg font-medium text-gray-900">Avis des clients</h2>
            <div class="mt-6 space-y-10 divide-y divide-gray-200 border-t border-gray-200 pb-10">
                <?php foreach ($reviews as $review): ?>
                <div class="pt-10 lg:grid lg:grid-cols-12 lg:gap-x-8">
                    <div class="lg:col-span-8 lg:col-start-5 xl:col-span-9 xl:col-start-4 xl:grid xl:grid-cols-3 xl:gap-x-8 xl:items-start">
                        <div class="flex items-center xl:col-span-1">
                            <div class="flex items-center">
                                <?php for ($i = 1; $i <= 5; $i++): ?>
                                    <svg class="h-5 w-5 <?php echo $i <= $review[\'rating\'] ? \'text-yellow-400\' : \'text-gray-200\'; ?>" fill="currentColor" viewBox="0 0 20 20">
                                        <path d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                                    </svg>
                                <?php endfor; ?>
                            </div>
                        </div>
                        <div class="mt-4 lg:mt-6 xl:col-span-2 xl:mt-0">
                            <h3 class="text-sm font-medium text-gray-900"><?php echo $review[\'user_name\']; ?></h3>
                            <div class="mt-3 space-y-6 text-sm text-gray-500">
                                <p><?php echo $review[\'comment\']; ?></p>
                            </div>
                        </div>
                    </div>
                </div>
                <?php endforeach; ?>
            </div>
        </div>
    </div>
</div>
';

require_once 'layouts/main.php'; 