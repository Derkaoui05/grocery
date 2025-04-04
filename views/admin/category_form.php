<?php
$content = '
<div class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900"><?php echo $is_edit ? \'Modifier la catégorie\' : \'Nouvelle catégorie\'; ?></h3>
                        <p class="mt-1 text-sm text-gray-600">
                            <?php echo $is_edit ? \'Modifiez les informations de la catégorie.\' : \'Créez une nouvelle catégorie.\'; ?>
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="<?php echo $is_edit ? \'/ensa/ecommerce/admin/categories/\' . $category[\'id\'] . \'/update\' : \'/ensa/ecommerce/admin/categories/store\'; ?>" method="POST">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" value="<?php echo $is_edit ? $category[\'name\'] : \'\'; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <div class="mt-1">
                                        <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"><?php echo $is_edit ? $category[\'description\'] : \'\'; ?></textarea>
                                    </div>
                                </div>

                                <div>
                                    <label for="parent_id" class="block text-sm font-medium text-gray-700">Catégorie parente</label>
                                    <div class="mt-1">
                                        <select id="parent_id" name="parent_id" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                            <option value="">Aucune</option>
                                            <?php foreach ($categories as $parent): ?>
                                                <?php if (!$is_edit || $parent[\'id\'] != $category[\'id\']): ?>
                                                <option value="<?php echo $parent[\'id\']; ?>" <?php echo $is_edit && $category[\'parent_id\'] == $parent[\'id\'] ? \'selected\' : \'\'; ?>>
                                                    <?php echo $parent[\'name\']; ?>
                                                </option>
                                                <?php endif; ?>
                                            <?php endforeach; ?>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="is_active" class="block text-sm font-medium text-gray-700">Statut</label>
                                    <div class="mt-1">
                                        <select id="is_active" name="is_active" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="1" <?php echo $is_edit && $category[\'is_active\'] ? \'selected\' : \'\'; ?>>Actif</option>
                                            <option value="0" <?php echo $is_edit && !$category[\'is_active\'] ? \'selected\' : \'\'; ?>>Inactif</option>
                                        </select>
                                    </div>
                                </div>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <a href="/ensa/ecommerce/admin/categories" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    Annuler
                                </a>
                                <button type="submit" class="ml-3 inline-flex justify-center py-2 px-4 border border-transparent shadow-sm text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                                    <?php echo $is_edit ? \'Enregistrer\' : \'Créer\'; ?>
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