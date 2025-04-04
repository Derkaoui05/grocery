<?php
$content = '
<div class="bg-white">
    <div class="max-w-7xl mx-auto px-4 sm:px-6 lg:px-8">
        <div class="flex items-center justify-between border-b border-gray-200 pb-6 pt-6">
            <h1 class="text-4xl font-bold tracking-tight text-gray-900">Nos Produits</h1>
            <div class="flex items-center">
                <div class="relative inline-block text-left">
                    <div>
                        <button type="button" class="group inline-flex justify-center text-sm font-medium text-gray-700 hover:text-gray-900" id="menu-button">
                            Trier par
                            <svg class="-mr-1 ml-1 h-5 w-5 flex-shrink-0 text-gray-400 group-hover:text-gray-500" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                <path fill-rule="evenodd" d="M5.23 7.21a.75.75 0 011.06.02L10 11.168l3.71-3.938a.75.75 0 111.08 1.04l-4.25 4.5a.75.75 0 01-1.08 0l-4.25-4.5a.75.75 0 01.02-1.06z" clip-rule="evenodd" />
                            </svg>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <div class="pt-6 pb-24">
            <div class="grid grid-cols-1 gap-x-8 gap-y-10 lg:grid-cols-4">
                <!-- Filters -->
                <div class="hidden lg:block">
                    <form class="space-y-4 divide-y divide-gray-200">
                        <div>
                            <h3 class="text-lg font-medium text-gray-900">Catégories</h3>
                            <div class="pt-6">
                                <div class="space-y-4">
                                    <?php foreach ($categories as $category): ?>
                                    <div class="flex items-center">
                                        <input id="category-<?php echo $category[\'id\']; ?>" name="category[]" value="<?php echo $category[\'id\']; ?>" type="checkbox" class="h-4 w-4 rounded border-gray-300 text-blue-600 focus:ring-blue-500">
                                        <label for="category-<?php echo $category[\'id\']; ?>" class="ml-3 text-sm text-gray-600"><?php echo $category[\'name\']; ?></label>
                                    </div>
                                    <?php endforeach; ?>
                                </div>
                            </div>
                        </div>
                    </form>
                </div>

                <!-- Product grid -->
                <div class="lg:col-span-3">
                    <div class="grid grid-cols-1 gap-x-6 gap-y-10 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-3 xl:gap-x-8">
                        <?php foreach ($products as $product): ?>
                        <div class="group">
                            <div class="aspect-h-1 aspect-w-1 w-full overflow-hidden rounded-lg bg-gray-200 xl:aspect-h-8 xl:aspect-w-7">
                                <img src="<?php echo $product[\'image_url\']; ?>" alt="<?php echo $product[\'name\']; ?>" class="h-full w-full object-cover object-center group-hover:opacity-75">
                            </div>
                            <h3 class="mt-4 text-sm text-gray-700"><?php echo $product[\'name\']; ?></h3>
                            <p class="mt-1 text-lg font-medium text-gray-900"><?php echo number_format($product[\'price\'], 2); ?> MAD</p>
                            <div class="mt-4">
                                <a href="/ensa/ecommerce/product/<?php echo $product[\'id\']; ?>" class="relative flex items-center justify-center rounded-md border border-transparent bg-blue-600 px-8 py-2 text-sm font-medium text-white hover:bg-blue-700">
                                    Voir détails
                                </a>
                            </div>
                        </div>
                        <?php endforeach; ?>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
';

require_once 'layouts/main.php'; 