<?php
require_once 'config/config.php';

$content = '
<!-- Add required CSS for animations -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full backdrop-blur-lg bg-white/30 rounded-2xl p-8 shadow-2xl transform hover:scale-105 transition-all duration-300 animate__animated animate__fadeIn">
        <div class="text-center">
            <div class="mx-auto h-24 w-24 bg-white rounded-full flex items-center justify-center shadow-lg mb-6 animate__animated animate__bounceIn">
                <i class="fas fa-user-circle text-5xl text-blue-600"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-white mb-2">
                Bienvenue
            </h2>
            <p class="text-white/80 text-sm mb-8">
                Connectez-vous à votre compte pour continuer
            </p>
        </div>

        ' . (!empty($error) ? '<div class="bg-red-100/90 backdrop-blur border-l-4 border-red-500 text-red-700 p-4 rounded-lg mb-6 animate__animated animate__shakeX" role="alert">
            <div class="flex">
                <div class="flex-shrink-0">
                    <i class="fas fa-exclamation-circle"></i>
                </div>
                <div class="ml-3">
                    <p class="text-sm">' . htmlspecialchars($error) . '</p>
                </div>
            </div>
        </div>' : '') . '

        <form class="mt-8 space-y-6" action="/ensa/ecommerce/login" method="POST">
            <div class="space-y-4">
                <div class="group">
                    <div class="relative rounded-lg bg-white/50 backdrop-blur-sm shadow-sm hover:bg-white/60 transition-all duration-300">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-500 group-hover:text-blue-500 transition-colors"></i>
                        </div>
                        <input id="email" name="email" type="email" required 
                            class="block w-full pl-10 pr-3 py-3 border-0 rounded-lg focus:ring-2 focus:ring-blue-500 bg-transparent placeholder-gray-500 text-gray-900 sm:text-sm" 
                            placeholder="Votre email">
                    </div>
                </div>

                <div class="group">
                    <div class="relative rounded-lg bg-white/50 backdrop-blur-sm shadow-sm hover:bg-white/60 transition-all duration-300">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-500 group-hover:text-blue-500 transition-colors"></i>
                        </div>
                        <input id="password" name="password" type="password" required 
                            class="block w-full pl-10 pr-3 py-3 border-0 rounded-lg focus:ring-2 focus:ring-blue-500 bg-transparent placeholder-gray-500 text-gray-900 sm:text-sm" 
                            placeholder="Votre mot de passe">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword()" class="text-gray-500 hover:text-blue-500 focus:outline-none">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border-0 text-sm font-medium rounded-lg text-white bg-gradient-to-r from-blue-600 to-blue-800 hover:from-blue-700 hover:to-blue-900 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-blue-500 transform hover:scale-105 transition-all duration-300">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-sign-in-alt text-blue-200 group-hover:text-blue-100 transition-colors"></i>
                    </span>
                    Se connecter
                </button>
            </div>

            <div class="mt-6 flex items-center justify-between">
                <div class="text-sm">
                    <a href="/ensa/ecommerce/register" class="font-medium text-white hover:text-blue-200 transition-colors flex items-center">
                        <i class="fas fa-user-plus mr-2"></i>
                        Créer un compte
                    </a>
                </div>
                <div class="text-sm">
                    <a href="#" class="font-medium text-white hover:text-blue-200 transition-colors flex items-center">
                        <i class="fas fa-key mr-2"></i>
                        Mot de passe oublié?
                    </a>
                </div>
            </div>
        </form>
    </div>
</div>

<script>
function togglePassword() {
    const password = document.getElementById("password");
    const icon = document.getElementById("toggleIcon");
    
    if (password.type === "password") {
        password.type = "text";
        icon.classList.remove("fa-eye");
        icon.classList.add("fa-eye-slash");
    } else {
        password.type = "password";
        icon.classList.remove("fa-eye-slash");
        icon.classList.add("fa-eye");
    }
}

// Add animation to form fields on focus
document.querySelectorAll("input").forEach(input => {
    input.addEventListener("focus", function() {
        this.closest(".group").classList.add("animate__animated", "animate__pulse");
    });
    
    input.addEventListener("blur", function() {
        this.closest(".group").classList.remove("animate__animated", "animate__pulse");
    });
});
</script>
';

require_once 'views/layouts/main.php'; 