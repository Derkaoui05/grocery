<?php require_once 'views/layouts/header.php'; ?>

<!-- Add required CSS -->
<link href="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.css" rel="stylesheet">
<link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.css">

<div class="min-h-screen bg-gradient-to-br from-gray-50 to-gray-100 py-12">
    <div class="container mx-auto px-4">
        <!-- Hero Section -->
        <div class="text-center mb-12" data-aos="fade-down">
            <h1 class="text-4xl md:text-5xl font-bold text-gray-800 mb-4">Découvrez Nos Produits</h1>
            <p class="text-gray-600 text-lg">Des produits frais et de qualité, livrés directement chez vous</p>
        </div>

        <!-- Filters Section -->
        <div class="bg-white rounded-xl shadow-lg p-6 mb-8" data-aos="fade-up">
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-4 gap-4">
                <!-- Search -->
                <div class="relative">
                    <input type="text" id="searchInput" placeholder="Rechercher des produits..." 
                           class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 transition-all">
                    <i class="fas fa-search absolute left-3 top-3.5 text-gray-400"></i>
                </div>

                <!-- Category Filter -->
                <div class="relative">
                    <select id="categoryFilter" 
                            class="w-full pl-10 pr-4 py-3 border rounded-lg focus:outline-none focus:ring-2 focus:ring-blue-500 appearance-none transition-all">
                        <option value="">Toutes les Catégories</option>
                        <?php foreach ($categories as $category): ?>
                            <option value="<?= htmlspecialchars($category['category_id']); ?>">
                                <?= htmlspecialchars($category['name']); ?>
                            </option>
                        <?php endforeach; ?>
                    </select>
                    <i class="fas fa-tag absolute left-3 top-3.5 text-gray-400"></i>
                    <i class="fas fa-chevron-down absolute right-3 top-3.5 text-gray-400"></i>
                </div>

                <!-- Price Range -->
                <div class="lg:col-span-2">
                    <div id="priceRange" class="mt-2"></div>
                    <div class="flex justify-between mt-2 text-sm text-gray-600">
                        <span id="priceMin">0 €</span>
                        <span id="priceMax">1000 €</span>
                    </div>
                </div>
            </div>

            <!-- Active Filters -->
            <div class="flex flex-wrap gap-2 mt-4 pt-4 border-t" id="activeFilters"></div>
        </div>

        <!-- Products Grid -->
        <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6" id="productsGrid">
            <?php foreach ($products as $product): ?>
                <div class="bg-white rounded-xl shadow-lg overflow-hidden product-card transform hover:scale-105 transition-all duration-300" 
                     data-aos="fade-up"
                     data-category="<?= htmlspecialchars($product['category_id']); ?>"
                     data-name="<?= htmlspecialchars(strtolower($product['name'])); ?>"
                     data-price="<?= htmlspecialchars($product['price']); ?>">
                    
                    <!-- Product Image Container -->
                    <div class="relative group">
                        <img src="/ensa/ecommerce/<?= htmlspecialchars($product['image']); ?>" 
                             alt="<?= htmlspecialchars($product['name']); ?>"
                             class="w-full h-56 object-cover transform group-hover:scale-110 transition-transform duration-300"
                             onerror="this.src='/ensa/ecommerce/public/uploads/products/default.jpg'">
                        
                        <?php if ($product['stock'] <= 0): ?>
                            <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-50 flex items-center justify-center">
                                <span class="bg-red-500 text-white px-4 py-2 rounded-full text-sm font-semibold">
                                    Rupture de Stock
                                </span>
                            </div>
                        <?php else: ?>
                            <div class="absolute top-0 left-0 w-full h-full bg-black bg-opacity-0 group-hover:bg-opacity-30 transition-all duration-300 flex items-center justify-center opacity-0 group-hover:opacity-100">
                                <a href="/ensa/ecommerce/products/<?= htmlspecialchars($product['product_id']); ?>" 
                                   class="bg-white text-gray-800 px-6 py-3 rounded-full font-semibold transform -translate-y-2 group-hover:translate-y-0 transition-all duration-300">
                                    Voir Détails
                                </a>
                            </div>
                        <?php endif; ?>

                        <!-- Category Badge -->
                        <div class="absolute top-4 left-4 bg-white bg-opacity-90 px-3 py-1 rounded-full text-sm font-medium text-gray-600">
                            <?= htmlspecialchars($product['name']); ?>
                        </div>
                    </div>

                    <!-- Product Info -->
                    <div class="p-6">
                        <div class="flex justify-between items-start mb-2">
                            <h3 class="text-xl font-bold text-gray-800">
                                <?= htmlspecialchars($product['name']); ?>
                            </h3>
                            <span class="text-2xl font-bold text-blue-600">
                                <?= number_format($product['price'], 2); ?> €
                            </span>
                        </div>
                        
                        <p class="text-gray-600 text-sm mb-4 line-clamp-2">
                            <?= htmlspecialchars($product['description']); ?>
                        </p>

                        <!-- Stock Indicator -->
                        <div class="flex items-center justify-between">
                            <div class="flex items-center">
                                <div class="w-2 h-2 rounded-full <?= $product['stock'] > 0 ? 'bg-green-500' : 'bg-red-500'; ?> mr-2"></div>
                                <span class="text-sm <?= $product['stock'] > 0 ? 'text-green-500' : 'text-red-500'; ?>">
                                    <?= $product['stock'] > 0 ? $product['stock'] . ' en stock' : 'Rupture de stock'; ?>
                                </span>
                            </div>
                            <?php if ($product['stock'] > 0): ?>
                                <button class="add-to-cart bg-blue-600 text-white px-4 py-2 rounded-lg hover:bg-blue-700 transition-colors flex items-center">
                                    <i class="fas fa-shopping-cart mr-2"></i>
                                    Ajouter
                                </button>
                            <?php endif; ?>
                        </div>
                    </div>
                </div>
            <?php endforeach; ?>
        </div>

        <!-- No Results Message -->
        <div id="noResults" class="hidden text-center py-12">
            <i class="fas fa-search text-4xl text-gray-400 mb-4"></i>
            <h3 class="text-xl font-semibold text-gray-600">Aucun produit trouvé</h3>
            <p class="text-gray-500 mt-2">Essayez de modifier vos filtres de recherche</p>
        </div>
    </div>
</div>

<!-- Add required JS -->
<script src="https://cdnjs.cloudflare.com/ajax/libs/aos/2.3.4/aos.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/noUiSlider/14.6.3/nouislider.min.js"></script>

<script>
document.addEventListener('DOMContentLoaded', function() {
    // Initialize AOS
    AOS.init({
        duration: 800,
        once: true
    });

    const categoryFilter = document.getElementById('categoryFilter');
    const searchInput = document.getElementById('searchInput');
    const productsGrid = document.getElementById('productsGrid');
    const productCards = document.querySelectorAll('.product-card');
    const noResults = document.getElementById('noResults');
    const activeFilters = document.getElementById('activeFilters');

    // Initialize Price Range Slider
    const priceRange = document.getElementById('priceRange');
    noUiSlider.create(priceRange, {
        start: [0, 1000],
        connect: true,
        range: {
            'min': 0,
            'max': 1000
        },
        format: {
            to: value => Math.round(value),
            from: value => Math.round(value)
        }
    });

    // Update price labels
    const priceMin = document.getElementById('priceMin');
    const priceMax = document.getElementById('priceMax');
    priceRange.noUiSlider.on('update', (values) => {
        priceMin.textContent = values[0] + ' €';
        priceMax.textContent = values[1] + ' €';
        filterProducts();
    });

    function updateActiveFilters() {
        activeFilters.innerHTML = '';
        
        // Add category filter if selected
        if (categoryFilter.value) {
            const categoryName = categoryFilter.options[categoryFilter.selectedIndex].text;
            addFilterTag('Catégorie: ' + categoryName);
        }

        // Add search filter if there's a search term
        if (searchInput.value) {
            addFilterTag('Recherche: ' + searchInput.value);
        }

        // Add price range filter
        const [min, max] = priceRange.noUiSlider.get();
        addFilterTag(`Prix: ${min}€ - ${max}€`);
    }

    function addFilterTag(text) {
        const tag = document.createElement('span');
        tag.className = 'bg-blue-100 text-blue-800 px-3 py-1 rounded-full text-sm font-medium';
        tag.textContent = text;
        activeFilters.appendChild(tag);
    }

    function filterProducts() {
        const selectedCategory = categoryFilter.value;
        const searchTerm = searchInput.value.toLowerCase();
        const [minPrice, maxPrice] = priceRange.noUiSlider.get();
        let visibleCount = 0;

        productCards.forEach(card => {
            const categoryMatch = !selectedCategory || card.dataset.category === selectedCategory;
            const nameMatch = card.dataset.name.includes(searchTerm);
            const price = parseFloat(card.dataset.price);
            const priceMatch = price >= minPrice && price <= maxPrice;
            
            if (categoryMatch && nameMatch && priceMatch) {
                card.style.display = 'block';
                visibleCount++;
            } else {
                card.style.display = 'none';
            }
        });

        noResults.style.display = visibleCount === 0 ? 'block' : 'none';
        updateActiveFilters();
    }

    // Add animation to "Add to Cart" buttons
    document.querySelectorAll('.add-to-cart').forEach(button => {
        button.addEventListener('click', function(e) {
            e.preventDefault();
            this.classList.add('animate-pulse');
            setTimeout(() => {
                this.classList.remove('animate-pulse');
            }, 1000);
        });
    });

    categoryFilter.addEventListener('change', filterProducts);
    searchInput.addEventListener('input', filterProducts);

    // Initial filter
    filterProducts();
});
</script>

<?php require_once 'views/layouts/footer.php'; ?> 