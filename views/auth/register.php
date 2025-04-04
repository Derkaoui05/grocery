<?php
$content = '
<!-- Add required CSS for animations -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/animate.css/4.1.1/animate.min.css" rel="stylesheet">

<div class="min-h-screen flex items-center justify-center py-12 px-4 sm:px-6 lg:px-8">
    <div class="max-w-md w-full backdrop-blur-lg bg-white/30 rounded-2xl p-8 shadow-2xl transform hover:scale-105 transition-all duration-300 animate__animated animate__fadeIn">
        <div class="text-center">
            <div class="mx-auto h-24 w-24 bg-white rounded-full flex items-center justify-center shadow-lg mb-6 animate__animated animate__bounceIn">
                <i class="fas fa-user-plus text-5xl text-indigo-600"></i>
            </div>
            <h2 class="text-3xl font-extrabold text-white mb-2">
                Rejoignez-nous
            </h2>
            <p class="text-white/80 text-sm mb-8">
                Créez votre compte pour commencer l\'aventure
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

        <form class="mt-8 space-y-6" action="/ensa/ecommerce/register" method="POST">
            <div class="space-y-4">
                <div class="group">
                    <div class="relative rounded-lg bg-white/50 backdrop-blur-sm shadow-sm hover:bg-white/60 transition-all duration-300">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-user text-gray-500 group-hover:text-indigo-500 transition-colors"></i>
                        </div>
                        <input id="username" name="username" type="text" required 
                            class="block w-full pl-10 pr-3 py-3 border-0 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-transparent placeholder-gray-500 text-gray-900 sm:text-sm" 
                            placeholder="Votre nom d\'utilisateur">
                    </div>
                </div>

                <div class="group">
                    <div class="relative rounded-lg bg-white/50 backdrop-blur-sm shadow-sm hover:bg-white/60 transition-all duration-300">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-envelope text-gray-500 group-hover:text-indigo-500 transition-colors"></i>
                        </div>
                        <input id="email" name="email" type="email" required 
                            class="block w-full pl-10 pr-3 py-3 border-0 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-transparent placeholder-gray-500 text-gray-900 sm:text-sm" 
                            placeholder="Votre email">
                    </div>
                </div>

                <div class="group">
                    <div class="relative rounded-lg bg-white/50 backdrop-blur-sm shadow-sm hover:bg-white/60 transition-all duration-300">
                        <div class="absolute inset-y-0 left-0 pl-3 flex items-center pointer-events-none">
                            <i class="fas fa-lock text-gray-500 group-hover:text-indigo-500 transition-colors"></i>
                        </div>
                        <input id="password" name="password" type="password" required 
                            class="block w-full pl-10 pr-10 py-3 border-0 rounded-lg focus:ring-2 focus:ring-indigo-500 bg-transparent placeholder-gray-500 text-gray-900 sm:text-sm" 
                            placeholder="Votre mot de passe">
                        <div class="absolute inset-y-0 right-0 pr-3 flex items-center">
                            <button type="button" onclick="togglePassword()" class="text-gray-500 hover:text-indigo-500 focus:outline-none">
                                <i class="fas fa-eye" id="toggleIcon"></i>
                            </button>
                        </div>
                    </div>
                </div>
            </div>

            <div class="mt-8">
                <button type="submit" 
                    class="group relative w-full flex justify-center py-3 px-4 border-0 text-sm font-medium rounded-lg text-white bg-gradient-to-r from-indigo-600 to-purple-600 hover:from-indigo-700 hover:to-purple-700 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transform hover:scale-105 transition-all duration-300">
                    <span class="absolute left-0 inset-y-0 flex items-center pl-3">
                        <i class="fas fa-user-plus text-indigo-200 group-hover:text-indigo-100 transition-colors"></i>
                    </span>
                    Créer mon compte
                </button>
            </div>

            <div class="mt-6 flex items-center justify-center">
                <div class="text-sm">
                    <a href="/ensa/ecommerce/login" class="font-medium text-white hover:text-indigo-200 transition-colors flex items-center">
                        <i class="fas fa-sign-in-alt mr-2"></i>
                        Déjà un compte? Se connecter
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

// Add password strength indicator
document.getElementById("password").addEventListener("input", function() {
    const password = this.value;
    const strength = calculatePasswordStrength(password);
    updatePasswordStrengthUI(strength);
});

function calculatePasswordStrength(password) {
    let strength = 0;
    if (password.length >= 8) strength++;
    if (password.match(/[A-Z]/)) strength++;
    if (password.match(/[0-9]/)) strength++;
    if (password.match(/[^A-Za-z0-9]/)) strength++;
    return strength;
}

function updatePasswordStrengthUI(strength) {
    const input = document.getElementById("password");
    const colors = ["red", "orange", "yellow", "green"];
    if (strength > 0) {
        input.style.borderRight = `4px solid ${colors[strength-1]}`;
    } else {
        input.style.borderRight = "none";
    }
}
</script>
';

require_once 'views/layouts/main.php'; 