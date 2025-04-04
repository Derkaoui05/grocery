<?php
$content = '
<div class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="md:grid md:grid-cols-3 md:gap-6">
                <div class="md:col-span-1">
                    <div class="px-4 sm:px-0">
                        <h3 class="text-lg font-medium leading-6 text-gray-900"><?php echo $is_edit ? \'Modifier l\\\'utilisateur\' : \'Nouvel utilisateur\'; ?></h3>
                        <p class="mt-1 text-sm text-gray-600">
                            <?php echo $is_edit ? \'Modifiez les informations de l\\\'utilisateur.\' : \'Créez un nouvel utilisateur.\'; ?>
                        </p>
                    </div>
                </div>
                <div class="mt-5 md:mt-0 md:col-span-2">
                    <form action="<?php echo $is_edit ? \'/ensa/ecommerce/admin/users/\' . $user[\'id\'] . \'/update\' : \'/ensa/ecommerce/admin/users/store\'; ?>" method="POST">
                        <div class="shadow sm:rounded-md sm:overflow-hidden">
                            <div class="px-4 py-5 bg-white space-y-6 sm:p-6">
                                <div>
                                    <label for="name" class="block text-sm font-medium text-gray-700">Nom</label>
                                    <div class="mt-1">
                                        <input type="text" name="name" id="name" value="<?php echo $is_edit ? $user[\'name\'] : \'\'; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="email" class="block text-sm font-medium text-gray-700">Email</label>
                                    <div class="mt-1">
                                        <input type="email" name="email" id="email" value="<?php echo $is_edit ? $user[\'email\'] : \'\'; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                    </div>
                                </div>

                                <div>
                                    <label for="password" class="block text-sm font-medium text-gray-700">Mot de passe</label>
                                    <div class="mt-1">
                                        <input type="password" name="password" id="password" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" <?php echo $is_edit ? \'\' : \'required\'; ?>>
                                    </div>
                                    <?php if ($is_edit): ?>
                                    <p class="mt-2 text-sm text-gray-500">Laissez vide pour ne pas changer le mot de passe</p>
                                    <?php endif; ?>
                                </div>

                                <div>
                                    <label for="role" class="block text-sm font-medium text-gray-700">Rôle</label>
                                    <div class="mt-1">
                                        <select id="role" name="role" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="customer" <?php echo $is_edit && $user[\'role\'] == \'customer\' ? \'selected\' : \'\'; ?>>Client</option>
                                            <option value="seller" <?php echo $is_edit && $user[\'role\'] == \'seller\' ? \'selected\' : \'\'; ?>>Vendeur</option>
                                            <option value="admin" <?php echo $is_edit && $user[\'role\'] == \'admin\' ? \'selected\' : \'\'; ?>>Administrateur</option>
                                        </select>
                                    </div>
                                </div>

                                <div>
                                    <label for="is_active" class="block text-sm font-medium text-gray-700">Statut</label>
                                    <div class="mt-1">
                                        <select id="is_active" name="is_active" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md" required>
                                            <option value="1" <?php echo $is_edit && $user[\'is_active\'] ? \'selected\' : \'\'; ?>>Actif</option>
                                            <option value="0" <?php echo $is_edit && !$user[\'is_active\'] ? \'selected\' : \'\'; ?>>Inactif</option>
                                        </select>
                                    </div>
                                </div>

                                <?php if ($is_edit && $user[\'role\'] == \'seller\'): ?>
                                <div>
                                    <label for="store_name" class="block text-sm font-medium text-gray-700">Nom du magasin</label>
                                    <div class="mt-1">
                                        <input type="text" name="store_name" id="store_name" value="<?php echo $user[\'store_name\']; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div>
                                    <label for="description" class="block text-sm font-medium text-gray-700">Description</label>
                                    <div class="mt-1">
                                        <textarea id="description" name="description" rows="3" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md"><?php echo $user[\'description\']; ?></textarea>
                                    </div>
                                </div>

                                <div>
                                    <label for="address" class="block text-sm font-medium text-gray-700">Adresse</label>
                                    <div class="mt-1">
                                        <input type="text" name="address" id="address" value="<?php echo $user[\'address\']; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div>
                                    <label for="city" class="block text-sm font-medium text-gray-700">Ville</label>
                                    <div class="mt-1">
                                        <input type="text" name="city" id="city" value="<?php echo $user[\'city\']; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div>
                                    <label for="postal_code" class="block text-sm font-medium text-gray-700">Code postal</label>
                                    <div class="mt-1">
                                        <input type="text" name="postal_code" id="postal_code" value="<?php echo $user[\'postal_code\']; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>

                                <div>
                                    <label for="phone" class="block text-sm font-medium text-gray-700">Téléphone</label>
                                    <div class="mt-1">
                                        <input type="text" name="phone" id="phone" value="<?php echo $user[\'phone\']; ?>" class="shadow-sm focus:ring-blue-500 focus:border-blue-500 block w-full sm:text-sm border-gray-300 rounded-md">
                                    </div>
                                </div>
                                <?php endif; ?>
                            </div>
                            <div class="px-4 py-3 bg-gray-50 text-right sm:px-6">
                                <a href="/ensa/ecommerce/admin/users" class="inline-flex justify-center py-2 px-4 border border-gray-300 shadow-sm text-sm font-medium rounded-md text-gray-700 bg-white hover:bg-gray-50 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
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