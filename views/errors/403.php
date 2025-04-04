<?php
$content = '
<div class="min-h-screen flex items-center justify-center bg-gray-50 py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full space-y-8">
        <div>
            <h2 class="mt-6 text-center text-3xl font-extrabold text-gray-900">
                Accès interdit
            </h2>
            <p class="mt-2 text-center text-sm text-gray-600">
                Vous n\'avez pas les permissions nécessaires pour accéder à cette ressource.
            </p>
        </div>
        <div class="text-center">
            <a href="' . BASE_URL . '" class="inline-flex items-center px-4 py-2 border border-transparent text-sm font-medium rounded-md text-white bg-blue-600 hover:bg-blue-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500">
                Retour à l\'accueil
            </a>
        </div>
    </div>
</div>
';

require_once __DIR__ . '/../layouts/main.php'; 