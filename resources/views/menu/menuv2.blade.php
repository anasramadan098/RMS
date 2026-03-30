<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المطعم - Restaurant Menu</title>
    
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <!-- Custom CSS -->
    <link href="{{asset('css/rtl-support.css')}}" rel="stylesheet" />
    <link href="{{asset('css/menu.css')}}" rel="stylesheet" />
    <style>
        body {
            font-family: 'Segoe UI', Tahoma, Geneva, Verdana, sans-serif;
            background-color: #f8f9fa;
            margin: 0;
            padding: 0;
        }

        .language-selector {
            min-height: 100vh;
            display: flex;
            align-items: center;
            justify-content: center;
            background: linear-gradient(135deg, #667eea 0%, #764ba2 100%);
        }

        .language-card {
            background: white;
            border-radius: 20px;
            padding: 3rem;
            box-shadow: 0 20px 40px rgba(0,0,0,0.1);
            text-align: center;
            max-width: 500px;
            width: 90%;
        }

        .language-btn {
            width: 200px;
            height: 80px;
            margin: 1rem;
            border: none;
            border-radius: 15px;
            font-size: 1.2rem;
            font-weight: bold;
            transition: all 0.3s ease;
            cursor: pointer;
        }

        .language-btn.arabic {
            background: linear-gradient(45deg, #28a745, #20c997);
            color: white;
        }

        .language-btn.english {
            background: linear-gradient(45deg, #007bff, #6610f2);
            color: white;
        }

        .language-btn:hover {
            transform: translateY(-3px);
            box-shadow: 0 10px 20px rgba(0,0,0,0.2);
        }

        .menu-container {
            display: none;
            min-height: 100vh;
            background-color: #f8f9fa;
        }

        .menu-header {
            background: #0e6030;
            padding: 1rem 0;
            box-shadow: 0 2px 10px rgba(0,0,0,0.1);
            position: sticky;
            top: 0;
            z-index: 1000;
        }

        .logo {
            height: 160px;
            width: auto;
        }

        .backBtn {
            border-color: #fff;
            color:#fff;
        }

        .categories-swiper {
            padding: 2rem 0;
            background: white;
            margin-bottom: 2rem;
        }

        .category-slide {
            text-align: center;
            cursor: pointer;
            padding: 1rem;
            border-radius: 15px;
            transition: all 0.3s ease;
            background: #f8f9fa;
            margin: 0 0.5rem;
        }

        .category-slide:hover,
        .category-slide.active {
            background: #0e6030;
            color: white;
            transform: translateY(-2px);
        }

        .swiper-button-next, .swiper-button-prev {
            color : #0e6030 !important;
        }
        [dir="ltr"] {
            .logoDiv {
                order:1;
            }
        }
        .category-slide h5 {
            margin: 0;
            font-weight: 600;
        }

        .meals-container {
            max-width: 1200px;
            margin: 0 auto;
            padding: 0 1rem;
        }

        .meal-item {
            background: white;
            border-radius: 15px;
            padding: 1.5rem;
            margin-bottom: 1.5rem;
            box-shadow: 0 5px 15px rgba(0,0,0,0.08);
            transition: all 0.3s ease;
            display: flex;
            align-items: center;
            gap: 1.5rem;
        }

        .meal-item:hover {
            transform: translateY(-2px);
            box-shadow: 0 10px 25px rgba(0,0,0,0.15);
        }

        .meal-image {
            width: 100%;
            height: auto;
            border-radius: 15px;
            object-fit: cover;
            flex-shrink: 0;
            max-width: 120px;
        }

        .meal-content {
            flex: 1;
            text-align: center;
        }

        .meal-name {
            font-size: 1.3rem;
            font-weight: bold;
            color: #333;
            margin-bottom: 0.5rem;
        }

        .meal-description {
            color: #666;
            margin-bottom: 1rem;
            line-height: 1.5;
        }

        .meal-price {
            font-size: 1.5rem;
            font-weight: bold;
            color: #28a745;
            text-align: center;
        }

        .loading {
            text-align: center;
            padding: 3rem;
        }

        .spinner-border {
            width: 3rem;
            height: 3rem;
        }

        /* Simple meal info styles */
        .meal-info {
            flex: 1;
            padding-right: 15px;
        }

        .meal-sizes {
            margin-top: 8px;
        }

        .meal-sizes-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 5px;
        }

        .sizes-list {
            display: flex;
            flex-wrap: wrap;
            gap: 8px;
        }

        .size-item {
            background: #f8f9fa;
            border: 1px solid #dee2e6;
            border-radius: 6px;
            padding: 4px 8px;
            font-size: 0.75rem;
            color: #495057;
        }

        .meal-extras {
            margin-top: 8px;
        }

        .meal-extras-title {
            font-size: 0.85rem;
            font-weight: 600;
            color: #666;
            margin-bottom: 5px;
        }

        .extras-list {
            display: flex;
            flex-wrap: wrap;
            gap: 6px;
        }

        .extra-item {
            background: #fff3cd;
            border: 1px solid #ffeaa7;
            border-radius: 6px;
            padding: 3px 6px;
            font-size: 0.7rem;
            color: #856404;
        }

        @media (max-width: 768px) {
            .meal-item {
                flex-direction: column;
                text-align: center;
            }
            .meal-info {
                order: 1;
                padding-right: 0;
                padding-top: 15px;
            }
            .meal-image {
                max-width: 100%;
                width: 100%;
                height: 200px;
            }

            .sizes-list, .extras-list {
                justify-content: center;
            }

            .size-item, .extra-item {
                font-size: 0.7rem;
                padding: 3px 6px;
            }
        }

        @media (max-width: 480px) {
            .meal-item {
                padding: 1rem;
            }

            .meal-image {
                height: 150px;
            }

            .meal-name {
                font-size: 1.1rem;
            }

            .meal-description {
                font-size: 0.85rem;
            }

            .meal-sizes-title, .meal-extras-title {
                font-size: 0.8rem;
            }

            .size-item, .extra-item {
                font-size: 0.65rem;
                padding: 2px 5px;
            }
        }
    </style>
</head>
<body>

    <!-- Language Selector -->
    <div class="language-selector" id="languageSelector">
        <div class="language-card">
            <h2 class="mb-4">اختر اللغة - Choose Language</h2>
            <div class="d-flex flex-column align-items-center">
                <button class="language-btn arabic" onclick="selectLanguage('ar')">
                    <i class="fas fa-globe me-2"></i>
                    العربية
                </button>
                <button class="language-btn english" onclick="selectLanguage('en')">
                    <i class="fas fa-globe me-2"></i>
                    English
                </button>
            </div>
        </div>
    </div>

    <!-- Menu Container -->
    <div class="menu-container" id="menuContainer">
        <!-- Header with Logo -->
        <div class="menu-header">
            <div class="container">
                <div class="row align-items-center">
                    <div class="col-auto ms-auto logoDiv">
                        <img src="{{asset('img/logo.png')}}" alt="Restaurant Logo" class="logo">
                    </div>
                    <div class="col-auto">
                        <button class="btn btn-outline-light me-2" onclick="refreshMenuData()" title="{{ __('app.menu.refresh_data') }}">
                            <i class="fas fa-sync-alt"></i>
                        </button>
                        <button class="btn btn-outline-secondary backBtn" onclick="goBackToLanguageSelector()">
                            <i class="fas fa-arrow-left me-2"></i>
                            <span class="back-text">{{ __('app.menu.back') }}</span>
                        </button>
                    </div>
                </div>
            </div>
        </div>

        <!-- مؤشر حالة البيانات -->
        <div class="container mt-2">
            <div class="row">
                <div class="col-12">
                    <div id="dataStatus" class="alert alert-info alert-dismissible fade show d-none" role="alert">
                        <i class="fas fa-info-circle me-2"></i>
                        <span id="statusMessage">جاري تحميل البيانات...</span>
                        <button type="button" class="btn-close" data-bs-dismiss="alert"></button>
                    </div>
                </div>
            </div>
        </div>

        <!-- Categories Swiper -->
        <div class="categories-swiper">
            <div class="container">
                <div class="swiper categoriesSwiper">
                    <div class="swiper-wrapper" id="categoriesWrapper">
                        <!-- Categories will be loaded here -->
                    </div>
                    <div class="swiper-button-prev"></div>
                    <div class="swiper-button-next"></div>
                </div>
            </div>
        </div>

        <!-- Meals Container -->
        <div class="meals-container">
            <div id="mealsWrapper" class="d-flex" style="flex-direction: column; ">
                <div class="loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 loading-text">جاري تحميل القائمة...</p>
                </div>
            </div>
        </div>
    </div>

    <!-- Bootstrap JS -->
    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
    <!-- Swiper JS -->
    <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>
    
    <script>
        let currentLanguage = 'ar';
        let categoriesSwiper = null;
        let categories = [];

        // نظام التخزين المحلي والتحميل المسبق
        let allMenuData = {
            categories: {},
            meals: {},
            lastUpdated: null
        };

        const CACHE_DURATION = 5 * 60 * 1000; // 5 دقائق
        const STORAGE_KEY = 'restaurant_menu_cache';

        // Language texts
        const texts = {
            ar: {
                loading: 'جاري تحميل القائمة...',
                back: 'العودة',
                price: 'جم',
                noMeals: 'لا توجد وجبات في هذه الفئة',
                error: 'حدث خطأ في تحميل البيانات',
                availableSizes: 'الأحجام المتاحة',
                availableExtras: 'الإضافات المتاحة',
                totalPrice: 'السعر الإجمالي',
                addToCart: 'إضافة للسلة',
                added: 'تم الإضافة!'
            },
            en: {
                loading: 'Loading menu...',
                back: 'Back',
                price: 'EG',
                noMeals: 'No meals in this category',
                error: 'Error loading data',
                availableSizes: 'Available Sizes',
                availableExtras: 'Available Extras',
                totalPrice: 'Total Price',
                addToCart: 'Add to Cart',
                added: 'Added!'
            }
        };

        // دوال التخزين المحلي
        function saveToLocalStorage() {
            try {
                allMenuData.lastUpdated = Date.now();
                localStorage.setItem(STORAGE_KEY, JSON.stringify(allMenuData));
                console.log('✅ تم حفظ البيانات في التخزين المحلي');
            } catch (error) {
                console.warn('⚠️ فشل في حفظ البيانات محلياً:', error);
            }
        }

        function loadFromLocalStorage() {
            try {
                const cached = localStorage.getItem(STORAGE_KEY);
                if (!cached) return false;

                const data = JSON.parse(cached);
                const now = Date.now();

                // التحقق من انتهاء صلاحية البيانات
                if (!data.lastUpdated || (now - data.lastUpdated) > CACHE_DURATION) {
                    console.log('⏰ انتهت صلاحية البيانات المحفوظة');
                    localStorage.removeItem(STORAGE_KEY);
                    return false;
                }

                allMenuData = data;
                console.log('✅ تم تحميل البيانات من التخزين المحلي');
                return true;
            } catch (error) {
                console.warn('⚠️ فشل في تحميل البيانات المحفوظة:', error);
                localStorage.removeItem(STORAGE_KEY);
                return false;
            }
        }

        function clearLocalStorage() {
            localStorage.removeItem(STORAGE_KEY);
            allMenuData = { categories: {}, meals: {}, lastUpdated: null };
            console.log('🗑️ تم مسح البيانات المحفوظة');
        }

        // تحميل جميع البيانات مرة واحدة
        async function preloadAllData() {
            const startTime = performance.now();
            console.log('🚀 بدء تحميل جميع البيانات...');

            try {
                // تحميل الفئات للغتين
                const [categoriesAr, categoriesEn] = await Promise.all([
                    fetch('/api/menu/categories?locale=ar').then(r => r.json()),
                    fetch('/api/menu/categories?locale=en').then(r => r.json())
                ]);

                allMenuData.categories.ar = categoriesAr;
                allMenuData.categories.en = categoriesEn;

                // تحميل الوجبات لجميع الفئات واللغتين
                const mealPromises = [];

                // للعربية
                categoriesAr.forEach(category => {
                    mealPromises.push(
                        fetch(`/api/menu/meals/${category.id}?locale=ar`)
                            .then(r => r.json())
                            .then(meals => {
                                if (!allMenuData.meals.ar) allMenuData.meals.ar = {};
                                allMenuData.meals.ar[category.id] = meals;
                            })
                    );
                });

                // للإنجليزية
                categoriesEn.forEach(category => {
                    mealPromises.push(
                        fetch(`/api/menu/meals/${category.id}?locale=en`)
                            .then(r => r.json())
                            .then(meals => {
                                if (!allMenuData.meals.en) allMenuData.meals.en = {};
                                allMenuData.meals.en[category.id] = meals;
                            })
                    );
                });

                await Promise.all(mealPromises);

                // حفظ البيانات محلياً
                saveToLocalStorage();

                const endTime = performance.now();
                const loadTime = Math.round(endTime - startTime);
                console.log(`✅ تم تحميل جميع البيانات في ${loadTime}ms`);

                return true;
            } catch (error) {
                console.error('❌ خطأ في تحميل البيانات:', error);
                return false;
            }
        }

        async function selectLanguage(lang) {
            currentLanguage = lang;

            // Update document direction and language
            document.documentElement.lang = lang;
            document.documentElement.dir = lang === 'ar' ? 'rtl' : 'ltr';

            // Update texts
            updateTexts();

            // Show menu container
            document.getElementById('languageSelector').style.display = 'none';
            document.getElementById('menuContainer').style.display = 'block';

            // تحميل البيانات (محلياً أو من السيرفر)
            await loadMenuData();
        }

        // دالة تحميل البيانات الذكية
        async function loadMenuData() {
            const startTime = performance.now();

            // محاولة تحميل البيانات من التخزين المحلي أولاً
            const hasLocalData = loadFromLocalStorage();

            if (hasLocalData && allMenuData.categories[currentLanguage]) {
                console.log('⚡ استخدام البيانات المحفوظة محلياً');
                categories = allMenuData.categories[currentLanguage];
                renderCategories();
                initializeSwiper();

                if (categories.length > 0) {
                    loadMealsFromCache(categories[0].id);
                    setActiveCategory(0);
                }

                const endTime = performance.now();
                console.log(`✅ تم تحميل البيانات محلياً في ${Math.round(endTime - startTime)}ms`);
                return;
            }

            // إذا لم توجد بيانات محلية، تحميل من السيرفر
            console.log('🌐 تحميل البيانات من السيرفر...');

            // إظهار مؤشر التحميل
            showLoadingIndicator();

            try {
                // تحميل جميع البيانات مرة واحدة
                const success = await preloadAllData();

                if (success && allMenuData.categories[currentLanguage]) {
                    categories = allMenuData.categories[currentLanguage];
                    renderCategories();
                    initializeSwiper();

                    if (categories.length > 0) {
                        loadMealsFromCache(categories[0].id);
                        setActiveCategory(0);
                    }
                } else {
                    throw new Error('فشل في تحميل البيانات');
                }

                const endTime = performance.now();
                console.log(`✅ تم تحميل البيانات من السيرفر في ${Math.round(endTime - startTime)}ms`);

            } catch (error) {
                console.error('❌ خطأ في تحميل البيانات:', error);
                showError();
            }
        }

        // تحميل الوجبات من البيانات المحفوظة
        function loadMealsFromCache(categoryId) {
            if (allMenuData.meals[currentLanguage] && allMenuData.meals[currentLanguage][categoryId]) {
                const meals = allMenuData.meals[currentLanguage][categoryId];
                console.log(`⚡ تحميل ${meals.length} وجبة من البيانات المحفوظة`);
                renderMeals(meals);
            } else {
                console.warn('⚠️ لم توجد وجبات محفوظة للفئة:', categoryId);
                showError('لم توجد وجبات لهذه الفئة');
            }
        }

        // إظهار مؤشر التحميل
        function showLoadingIndicator() {
            const mealsWrapper = document.getElementById('mealsWrapper');
            mealsWrapper.innerHTML = `
                <div class="loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3">${texts[currentLanguage].loading}</p>
                    <small class="text-muted">جاري تحميل جميع البيانات للمرة الأولى...</small>
                </div>
            `;
        }

        function updateTexts() {
            const loadingText = document.querySelector('.loading-text');
            const backText = document.querySelector('.back-text');
            
            if (loadingText) loadingText.textContent = texts[currentLanguage].loading;
            if (backText) backText.textContent = texts[currentLanguage].back;
        }

        function goBackToLanguageSelector() {
            document.getElementById('menuContainer').style.display = 'none';
            document.getElementById('languageSelector').style.display = 'flex';
        }

        // دالة تحديث البيانات (مسح Cache وإعادة تحميل)
        async function refreshMenuData() {
            console.log('🔄 تحديث البيانات...');
            clearLocalStorage();
            showLoadingIndicator();

            const success = await preloadAllData();
            if (success) {
                // إعادة تحميل الواجهة
                categories = allMenuData.categories[currentLanguage];
                renderCategories();
                initializeSwiper();

                if (categories.length > 0) {
                    loadMealsFromCache(categories[0].id);
                    setActiveCategory(0);
                }

                console.log('✅ تم تحديث البيانات بنجاح');
            } else {
                showError('فشل في تحديث البيانات');
            }
        }

        function renderCategories() {
            const wrapper = document.getElementById('categoriesWrapper');
            wrapper.innerHTML = '';

            console.log('Rendering categories:', categories);

            if (!categories || categories.length === 0) {
                wrapper.innerHTML = '<div class="swiper-slide"><div class="category-slide"><h5>لا توجد فئات</h5></div></div>';
                return;
            }

            categories.forEach((category, index) => {
                const slide = document.createElement('div');
                slide.className = 'swiper-slide';
                slide.innerHTML = `
                    <div class="category-slide" onclick="selectCategory(${index}, ${category.id})">
                        <h5>${category.name}</h5>
                    </div>
                `;
                wrapper.appendChild(slide);
            });
        }

        function initializeSwiper() {
            if (categoriesSwiper) {
                categoriesSwiper.destroy();
            }
            
            categoriesSwiper = new Swiper('.categoriesSwiper', {
                slidesPerView: 'auto',
                spaceBetween: 10,
                freeMode: true,
                breakpoints: {
                    320: {
                        slidesPerView: 2,
                        spaceBetween: 10
                    },
                    768: {
                        slidesPerView: 4,
                        spaceBetween: 15
                    },
                    1024: {
                        slidesPerView: 6,
                        spaceBetween: 20
                    }
                },
                navigation: {
                    nextEl: '.swiper-button-next',
                    prevEl: '.swiper-button-prev',
                },
            });
        }

        function selectCategory(index, categoryId) {
            console.log('Category selected:', index, categoryId);
            setActiveCategory(index);

            // تحميل الوجبات من البيانات المحفوظة (فوري!)
            loadMealsFromCache(categoryId);
        }

        function setActiveCategory(index) {
            document.querySelectorAll('.category-slide').forEach(slide => {
                slide.classList.remove('active');
            });
            
            const slides = document.querySelectorAll('.category-slide');
            if (slides[index]) {
                slides[index].classList.add('active');
            }
        }

        // تحسين دالة renderMeals مع lazy loading للصور
        function renderMeals(meals) {
            const mealsWrapper = document.getElementById('mealsWrapper');

            if (!meals || meals.length === 0) {
                mealsWrapper.innerHTML = `
                    <div class="text-center py-5">
                        <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                        <p class="text-muted">${texts[currentLanguage].noMeals}</p>
                    </div>
                `;
                return;
            }

            // إنشاء fragment لتحسين الأداء
            const fragment = document.createDocumentFragment();

            meals.forEach((meal, index) => {
                const mealElement = document.createElement('div');
                mealElement.className = 'meal-item';
                mealElement.style.opacity = '0';
                mealElement.style.transform = 'translateY(20px)';
                mealElement.style.order = meal.order;

                const imageUrl = meal.image ?
                    (meal.image.startsWith('http') ? meal.image : `{{ asset('img/productImages/') }}/${meal.image}`) :
                    '{{ asset("img/product-defualt.jpg") }}';

                // Generate sizes HTML (simple list)
                let sizesHTML = '';
                if (meal.sizes && meal.sizes.length > 0) {
                    sizesHTML = `
                        <div class="meal-sizes">
                            <div class="meal-sizes-title">${texts[currentLanguage].availableSizes}:</div>
                            <div class="sizes-list">
                                ${meal.sizes.map(size => `
                                    <span class="size-item">${size.name} - ${size.price} ${texts[currentLanguage].price}</span>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                // Generate extras HTML (simple list)
                let extrasHTML = '';
                if (meal.extras && meal.extras.length > 0) {
                    extrasHTML = `
                        <div class="meal-extras">
                            <div class="meal-extras-title">${texts[currentLanguage].availableExtras}:</div>
                            <div class="extras-list">
                                ${meal.extras.map(extra => `
                                    <span class="extra-item">${extra.name} +${extra.price} ${texts[currentLanguage].price}</span>
                                `).join('')}
                            </div>
                        </div>
                    `;
                }

                mealElement.innerHTML = `
                    <img src="${imageUrl}" alt="${meal.name}" class="meal-image"
                         loading="lazy" onerror="this.src='{{ asset("img/product-defualt.jpg") }}'">
                    <div class="meal-info">
                        <div class="meal-name">${meal.name}</div>
                        ${meal.description ? `<div class="meal-description">${meal.description}</div>` : ''}
                        ${sizesHTML}
                        ${extrasHTML}
                    </div>
                `;

                fragment.appendChild(mealElement);

                // تأثير الظهور التدريجي
                setTimeout(() => {
                    mealElement.style.transition = 'all 0.3s ease';
                    mealElement.style.opacity = '1';
                    mealElement.style.transform = 'translateY(0)';
                }, index * 50);
            });

            mealsWrapper.innerHTML = '';
            mealsWrapper.appendChild(fragment);

            console.log(`✅ تم عرض ${meals.length} وجبة`);
        }





        function showError(customMessage = null) {
            const mealsWrapper = document.getElementById('mealsWrapper');
            const errorMessage = customMessage || texts[currentLanguage].error;
            mealsWrapper.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                    <p class="text-danger">${errorMessage}</p>
                    <div class="mt-3">
                        <button class="btn btn-outline-primary me-2" onclick="refreshMenuData()">
                            <i class="fas fa-sync-alt me-1"></i>
                            ${currentLanguage === 'ar' ? 'تحديث البيانات' : 'Refresh Data'}
                        </button>
                        <button class="btn btn-outline-secondary" onclick="location.reload()">
                            <i class="fas fa-redo me-1"></i>
                            ${currentLanguage === 'ar' ? 'إعادة تحميل الصفحة' : 'Reload Page'}
                        </button>
                    </div>
                </div>
            `;
        }

        function showNoCategories() {
            const mealsWrapper = document.getElementById('mealsWrapper');
            mealsWrapper.innerHTML = `
                <div class="text-center py-5">
                    <i class="fas fa-utensils fa-3x text-muted mb-3"></i>
                    <p class="text-muted">${currentLanguage === 'ar' ? 'لا توجد فئات متاحة' : 'No categories available'}</p>
                </div>
            `;
        }


        // إعادة تعريف loadFromLocalStorage
        loadFromLocalStorage = updateLoadFromLocalStorage();

        // تحديث preloadAllData لإظهار التقدم
        const originalPreload = preloadAllData;
        preloadAllData = async function() {
            const result = await originalPreload();
            return result;
        };

        // بدء التطبيق
        document.addEventListener('DOMContentLoaded', function() {
            console.log('🎉 تطبيق القائمة المحسن جاهز!');

            // إظهار معلومات الأداء
            if (performance.memory) {
                console.log('💾 استخدام الذاكرة:', Math.round(performance.memory.usedJSHeapSize / 1024 / 1024) + 'MB');
            }
        });
    </script>
</body>
</html>
