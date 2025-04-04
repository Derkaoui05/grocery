<?php
$content = '
<div class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900"><?php echo $is_edit ? \'Modifier le produit\' : \'Nouveau produit\'; ?></h3>
                        <p class="mt-1 text-sm text-gray-600">
                            Remplissez les informations ci-dessous pour <?php echo $is_edit ? \'modifier\' : \'créer\'; ?> votre produit.
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="<?php echo $is_edit ? \'/ensa/ecommerce/seller/products/\' . $product[\'id\'] . \'/update\' : \'/ensa/ecommerce/seller/products/store\'; ?>" method="POST" enctype="multipart/form-data">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom du produit</label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" value="<?php echo $is_edit ? $product[\'name\'] : \'\'; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <div class="mt-1">
                                        <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required><?php echo $is_edit ? $product[\'description\'] : \'\'; ?></textarea>
                                    </div>
                                </div>

                                <div>
                                    <label for="category_id" class="block text-sm font-medium text-gray-700">Catégorie</label>
                                    <div class="mt-1">
                                        <select id="category_id" name="category_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="">Sélectionnez une catégorie</option>
                                            <?php foreach ($categories as $category): ?>
                                            <option value="<?php echo $category[\'id\']; ?>" <?php echo $is_edit && $product[\'category_id\'] == $category[\'id\'] ? \'selected\' : \'\'; ?>>
                                                <?php echo $category[\'name\']; ?>
                                            </option>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="price" class="block text-sm font-medium text-gray-700">Prix (MAD)</label>
                                    <div class="mt-1">
                                        <input type="number" step="0.01" name="price" id="price" value="<?php echo $is_edit ? $product[\'price\'] : \'\'; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="stock" class="block text-sm font-medium text-gray-700">Stock</label>
                                    <div class="mt-1">
                                        <input type="number" name="stock" id="stock" value="<?php echo $is_edit ? $product[\'stock\'] : \'\'; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="image" class="block text-sm font-medium text-gray-700">Image</label>
                                    <div class="mt-1 flex items-center">
                                        <span class="inline-block h-12 w-12 rounded-full overflow-hidden bg-gray-100">
                                            <?php if ($is_edit && $product[\'image_url\']): ?>
                                            <img src="<?php echo $product[\'image_url\']; ?>" alt="Current product image" class="h-full w-full text-gray-300">
                                            <?php else: ?>
                                            <svg class="h-full w-full text-gray-300" fill="currentColor" viewBox="0 0 24 24">
                                                <path d="M24 20.993V24H0v-2.996A14.977 14.977 0 0112.004 15c4.904 0 9.26 2.354 11.996 5.993zM16.002 8.999a4 4 0 11-8 0 4 4 0 018 0z" />
                                            </svg>
                                            <?php endif; ?>
                                        </span>
                                        <input type="file" name="image" id="image" class="ml-5 block w-full text-sm text-gray-500 file:mr-4 file:py-2 file:px-4 file:rounded-md file:border-0 file:text-sm file:font-semibold file:bg-blue-50 file:text-blue-700 hover:file:bg-blue-100" <?php echo $is_edit ? \'\' : \'required\'; ?>>
                                    </div>
                                </div>

                                <div>
                                    <label for="status" class="block text-sm font-medium text-gray-700">Statut</label>
                                    <div class="mt-1">
                                        <select id="status" name="status" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="active" <?php echo $is_edit && $product[\'status\'] === \'active\' ? \'selected\' : \'\'; ?>>Actif</option>
                                            <option value="inactive" <?php echo $is_edit && $product[\'status\'] === \'inactive\' ? \'selected\' : \'\'; ?>>Inactif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <a href="/ensa/ecommerce/seller/products" class="inline-flex items-center px-4 py-2 border border-gray-300 rounded-md shadow-sm text-sm font-medium text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Annuler
                                </a>
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <?php echo $is_edit ? \'Mettre à jour\' : \'Créer\'; ?>
                                </button>
                            </div>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</div>
';

require_once 'layouts/main.php'; 