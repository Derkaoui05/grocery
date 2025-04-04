    </main>

    <footer class="bg-white shadow-lg mt-8">
        <div class="container mx-auto px-4 py-6">
            <div class="flex flex-col md:flex-row justify-between items-center">
                <div class="mb-4 md:mb-0">
                    <p class="text-gray-600">&copy; <?= date('Y'); ?> E-Commerce Store. All rights reserved.</p>
                </div>
                <div class="flex space-x-4">
                    <a href="/ensa/ecommerce/about" class="text-gray-600 hover:text-blue-600">About Us</a>
                    <a href="/ensa/ecommerce/contact" class="text-gray-600 hover:text-blue-600">Contact</a>
                    <a href="/ensa/ecommerce/terms" class="text-gray-600 hover:text-blue-600">Terms of Service</a>
                    <a href="/ensa/ecommerce/privacy" class="text-gray-600 hover:text-blue-600">Privacy Policy</a>
                </div>
            </div>
        </div>
    </footer>

    <script>
        // Dropdown menu functionality
        document.addEventListener('DOMContentLoaded', function() {
            const userButton = document.querySelector('button.flex.items-center');
            const dropdown = document.querySelector('.absolute.right-0');

            if (userButton && dropdown) {
                userButton.addEventListener('click', function() {
                    dropdown.classList.toggle('hidden');
                });

                // Close dropdown when clicking outside
                document.addEventListener('click', function(event) {
                    if (!userButton.contains(event.target) && !dropdown.contains(event.target)) {
                        dropdown.classList.add('hidden');
                    }
                });
            }
        });
    </script>
</body>
</html> 