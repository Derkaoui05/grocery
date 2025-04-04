<?php
$content = '
<div class="bg-gray-100">
    <div class="max-w-7xl mx-auto py-6 sm:px-6 lg:px-8">
        <div class="px-4 py-6 sm:px-0">
            <div class="flex justify-between items-center">
                <h1 class="text-3xl font-extrabold tracking-tight text-gray-900">Utilisateurs</h1>
                <a href="/ensa/ecommerce/admin/users/create" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md shadow-sm text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                    Nouvel utilisateur
                </a>
            </div>

            <div class="mt-8 flex flex-col">
                <div class="-my-2 -mx-4 overflow-x-auto sm:-mx-6 lg:-mx-8">
                    <div class="inline-block min-w-full py-2 align-middle md:px-6 lg:px-8">
                        <div class="overflow-hidden shadow ring-1 ring-black ring-opacity-5 md:rounded-lg">
                            <table class="min-w-full divide-y divide-gray-300">
                                <thead class="bg-gray-50">
                                    <tr>
                                        <th scope="col" class="py-3.5 pl-4 pr-3 text-left text-sm font-semibold text-gray-900 sm:pl-6">Nom</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Email</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Rôle</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Statut</th>
                                        <th scope="col" class="px-3 py-3.5 text-left text-sm font-semibold text-gray-900">Date d\'inscription</th>
                                        <th scope="col" class="relative py-3.5 pl-3 pr-4 sm:pr-6">
                                            <span class="sr-only">Actions</span>
                                        </th>
                                    </tr>
                                </thead>
                                <tbody class="divide-y divide-gray-200 bg-white">
                                    <?php foreach ($users as $user): ?>
                                    <tr>
                                        <td class="whitespace-nowrap py-4 pl-4 pr-3 text-sm font-medium text-gray-900 sm:pl-6">
                                            <?php echo $user[\'name\']; ?>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <?php echo $user[\'email\']; ?>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 <?php
                                                switch ($user[\'role\']) {
                                                    case \'admin\':
                                                        echo \'bg-purple-100 text-purple-800\';
                                                        break;
                                                    case \'seller\':
                                                        echo \'bg-blue-100 text-blue-800\';
                                                        break;
                                                    case \'customer\':
                                                        echo \'bg-green-100 text-green-800\';
                                                        break;
                                                    default:
                                                        echo \'bg-gray-100 text-gray-800\';
                                                }
                                            ?>">
                                                <?php echo $user[\'role\']; ?>
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <span class="inline-flex rounded-full px-2 text-xs font-semibold leading-5 <?php
                                                echo $user[\'is_active\'] ? \'bg-green-100 text-green-800\' : \'bg-red-100 text-red-800\';
                                            ?>">
                                                <?php echo $user[\'is_active\'] ? \'Actif\' : \'Inactif\'; ?>
                                            </span>
                                        </td>
                                        <td class="whitespace-nowrap px-3 py-4 text-sm text-gray-500">
                                            <?php echo date(\'d/m/Y H:i\', strtotime($user[\'created_at\'])); ?>
                                        </td>
                                        <td class="relative whitespace-nowrap py-4 pl-3 pr-4 text-right text-sm font-medium sm:pr-6">
                                            <a href="/ensa/ecommerce/admin/users/<?php echo $user[\'id\']; ?>/edit" class="text-blue-600 hover:text-blue-900 mr-4">
                                                Modifier
                                            </a>
                                            <form action="/ensa/ecommerce/admin/users/<?php echo $user[\'id\']; ?>/delete" method="POST" class="inline">
                                                <button type="submit" class="text-red-600 hover:text-red-900" onclick="return confirm(\'Êtes-vous sûr de vouloir supprimer cet utilisateur ?\')">
                                                    Supprimer
                                                </button>
                                            </form>
                                        </td>
                                    </tr>
                                    <?php endforeach; ?>
                                </tbody>
                            </table>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
';

require_once 'views/layouts/main.php'; 