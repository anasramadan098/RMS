<!DOCTYPE html>
<html lang="ar">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <title>قائمة المطعم - Restaurant Menu | @yield('title')</title>
    
    {{-- Fav ICON --}}
    <link rel="icon" type="image/png" href="{{asset('img/logo.png')}}" />
    <!-- Bootstrap CSS -->
    <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/css/bootstrap.min.css" rel="stylesheet">
    <!-- Font Awesome -->
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.4.0/css/all.min.css">
    <!-- Swiper CSS -->
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.css">
    <!-- Custom CSS -->
    <link href="{{asset('css/menu-page.css')}}" rel="stylesheet" />
    <link href="{{asset('css/rtl-support.css')}}" rel="stylesheet" />

    @yield('styles')
</head>
<body>
    @if (session('msg'))
        <div class="alert alert-success alert-home">
            {{ session('msg') }}
        </div>
    @endif
    
    <div class="loader">
        <img src="{{asset('img/loading.gif')}}" alt="Somi Cafe Loader" />
        <h2>Loading...</h2>
    </div>
    <!-- Language Selector -->
    <div class="language-selector" id="languageSelector">
        <div class="language-card">
            <h2 class="mb-4">
                Choose Language
                <br>
                اختر اللغة 
                </h2>
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
            <a href="{{route('menu.login_page')}}" class="follow-btn" data-text="login">
                Log In 
                {{-- Arrow Icon --}}
                <i class="fa-solid fa-arrow-right"></i>
            </a>
            <a href="{{route('menu.login_page')}}" class="s-btn" data-text="createAccount">
                Create Account
            </a>
        </div>
    </div>



    <div class="bell-holder" >
        <div class="box">
            <div class="head">
                <h3 data-text="notificationsTitle">
                    Notifications
                </h3>
                <i class="fa-solid fa-x close" ></i>
            </div>
            <div class="msg" >
                <i class="fa-solid fa-bell shape"></i>
                <p>
                    A Message From SOMICAFE.COM
                </p>
            </div>
        </div>
    </div>


    <!-- Menu Container -->
    <div class="menu-container" id="menuContainer">
        <!-- Header with Logo -->
        <div class="menu-header">
            <div class="container">
                <div class="main">
                    <div class="col-auto mb-2">
                        
                        <p class="greeting">
                            <span></span>
                            <span>
                                <script>
                                    let client  = JSON.parse(localStorage.getItem("somi_client"));
                                    client ? document.write(client.name.split(' ')[0]) : "";
                                </script>
                            </span>
                            <i class="fa-solid fa-heart"></i>
                        </p>
                    </div>
                    <div class="notification">
                        {{-- Notification Icon --}}
                        <i class="fa-solid fa-bell bellIcon"></i>
                    </div>
                </div>

                @yield('search')

            </div>
        </div>

       
        @yield('swipers')

    </div>

    @yield('content')
    
    
    
     <footer>
        <ul>
            <li>
                <a href="{{route('menu.offers')}}">
                    <i class="fa-solid fa-percent"></i>
                    <p data-text="offers">
                        Offers
                    </p>
                </a>
            </li>
            <li>
                <a href="{{route('menu.login_page')}}">
                    <i class="fa-solid fa-user"></i>
                    <p data-text="login">
                        Login
                    </p>
                </a>
            </li>
            <li>
                <a href="#" class="home" onclick="visitHome()">

                    <!--<i class="fa-solid fa-home"></i>-->
                    <div class="logo">
                        <img src="{{asset('img/logo.png')}}" style="max-width :100%" alt="LOGO" />
                    </div>
                    <p data-text="home">
                        Home
                    </p>
                </a>
            </li>
            <li>
                <a href="{{route('menu.book')}}">
                    <i class="fa-solid fa-table"></i>
                    <p data-text="booking">
                        Booking
                    </p>
                </a>
            </li>
            <li>
                <a href="https://g.page/r/CRdYU3FskfbIEBE/review" target="_blank">
                    <i class="fa-solid fa-star"></i>
                    <p data-text="reviews">
                        Reviews
                    </p>
                </a>
            </li>
            
        </ul>
    </footer>

    


    <script>

        document.querySelectorAll('body *:not(.language-selector , .loader , .loader *)').forEach(e => e.classList.add('d-none'));
        document.querySelectorAll('.language-selector *').forEach(e => e.classList.remove('d-none'));

        const orderElements = document.querySelectorAll('body > *:not(.menu-container, footer , .loader , .image-holder, .pop-up , .popular-swiper p , .language-selector , .bell-holder , script , style )');
        let currentLanguage = 'ar';

        


                
        let categoriesSwiper = null;
        let categories = [];
        let orders = [];

        // نظام التخزين المحلي والتحميل المسبق
        let allMenuData = {
            categories: {},
            meals: {},
            lastUpdated: null
        };

        const CACHE_DURATION = 5 * 60 * 1000; // 5 دقائق
        const STORAGE_KEY = 'restaurant_menu_cache';



        // Language texts
        let texts = {
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
                added: 'تم الإضافة!',
                taxContent: 'سوف يتم إضافة رسوم 14% خدمة',
                typeName: 'اكتب إسمك',
                typeEmail: 'إكتب إيميلك',
                typePhone: 'إكتب رقم هاتفك',
                selectTable: 'رقم الطاولة',
                selectSize: 'إختر الحجم',
                morning: "صباح الخير",
                evening: "مساء الخير",
                // Header and navigation texts
                chooseLanguage: 'اختر اللغة',
                searchPlaceholder: 'البحث عن...',
                categories: 'الفئات',
                popularChoices: 'الاختيارات الشائعة',
                reviews: 'التقييمات',
                // Footer navigation
                offers: 'العروض',
                login: 'تسجيل ',
                home: 'الرئيسية',
                booking: 'الحجز',
                // Cart and ordering
                cartTitle: 'سلة الطلبات',
                total: 'الإجمالي',
                sendOrder: 'إرسال الطلب',
                orderSent: 'تم إرسال الطلب!',
                cartEmpty: 'السلة فارغة',
                // Special offers and countdown
                saveUpTo: 'وفر حتى',
                mealName: 'اسم الوجبة',
                mealPrice: 'السعر',
                // Action buttons
                close: 'إغلاق',
                refreshData: 'تحديث البيانات',
                reloadPage: 'إعادة تحميل الصفحة',
                // Account related
                createAccount: 'إنشاء حساب',
                // Notification
                notificationMessage: 'رسالة من SOMICAFE.COM',
                // Loading states
                loadingFirstTime: 'جاري تحميل جميع البيانات للمرة الأولى...',
                // Categories
                noCategoriesAvailable: 'لا توجد فئات متاحة',
                noCategories: 'لا توجد فئات',
                // Login and Booking pages
                loginPageTitle: 'تسجيل الدخول',
                bookingPageTitle: 'حجز طاولة',
                notificationsTitle: "الإشعارات",
                terms: 'الشروط و الأحكام',
                howWork: 'كيف تعمل',
                
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
                added: 'Added!',
                taxContent: 'An Additional 14% For Services',
                typeName: 'Type Your Name',
                typeEmail: 'Type Your Email',
                typePhone: 'Type Your Phone',
                selectTable: 'Your Table',
                selectSize: 'Select Size',
                morning: "Good Morning",
                evening: "Good Evening",
                // Header and navigation texts
                chooseLanguage: 'Choose Language',
                searchPlaceholder: 'Search for...',
                categories: 'Categories',
                popularChoices: 'Popular Choices',
                reviews: 'Reviews',
                // Footer navigation
                offers: 'Offers',
                login: 'Login',
                home: 'Home',
                booking: 'Booking',
                // Cart and ordering
                cartTitle: 'Shopping Cart',
                total: 'Total',
                sendOrder: 'Send Order',
                orderSent: 'Order sent!',
                cartEmpty: 'Cart is empty',
                // Special offers and countdown
                saveUpTo: 'Save Up To',
                mealName: 'Meal Name',
                mealPrice: 'Price',
                // Action buttons
                close: 'Close',
                refreshData: 'Refresh Data',
                reloadPage: 'Reload Page',
                // Account related
                createAccount: 'Create Account',
                // Notification
                notificationMessage: 'A Message From SOMICAFE.COM',
                // Loading states
                loadingFirstTime: 'Loading all data for the first time...',
                // Categories
                noCategoriesAvailable: 'No categories available',
                noCategories: 'No categories',
                // Login and Booking pages
                loginPageTitle: 'Login',
                bookingPageTitle: 'Table Booking',
                notificationsTitle: 'Notifications',
                terms: 'Terms & Conditions',
            howWork: 'How It Works',
            }
        };
        

        
        function checkLang() {
            return 
            currentLanguage === 'ar' ? 'ar' : 'en';
        } 

        function startOrdering() {
            // Hide All Elements
            orderElements.forEach(e => e.style.display = 'none');
            // Show Meals
            document.querySelector('.meals-swiper').style.display = 'block';
        }
        function visitHome() {
                if (location.pathname.split('/').length != 2){
                    location.href = '/menu';
                    return;
                }
                document.querySelector('input#search').value = '';
            
                orderElements.forEach(e => e.style.display = 'block');
                // Show Meals
                document.querySelector('.meals-swiper').style.display = 'none';
                
                document.querySelectorAll('.category-slide').forEach(slide => slide.classList.remove('active'));
        }
        function updateTexts() {
                // Update all elements with data-text attributes
                document.querySelectorAll('[data-text]').forEach(element => {
                    const textKey = element.getAttribute('data-text');
                    if (texts[currentLanguage][textKey]) {
                        if (element.tagName === 'INPUT' && element.type === 'text') {
                            element.placeholder = texts[currentLanguage][textKey];
                        } else {
                            // Preserve any icons or other HTML content
                            const icons = element.querySelectorAll('i');
                            const iconHTML = Array.from(icons).map(icon => icon.outerHTML).join(' ');
                            
                            if (textKey === 'login' && element.classList.contains('follow-btn')) {
                                element.innerHTML = `${texts[currentLanguage][textKey]} ${iconHTML}`;
                            } else {
                                element.textContent = texts[currentLanguage][textKey];
                            }
                        }
                    }
                });

                // Loading and basic navigation texts
                const loadingText = document.querySelector('.loading-text');
                const backText = document.querySelector('.back-text');
                
                if (loadingText) loadingText.textContent = texts[currentLanguage].loading;
                if (backText) backText.textContent = texts[currentLanguage].back;

                // Greeting text based on time
                const hour = new Date().getHours();
                const isAM = hour < 12;
                const greetingSpan = document.querySelector('.greeting span');
                if (greetingSpan) {
                    greetingSpan.textContent = isAM === true ? texts[currentLanguage].morning : texts[currentLanguage].evening;
                }

                // Header elements
                const categoriesTitle = document.querySelector('.categories-title');
                if (categoriesTitle) {
                    categoriesTitle.textContent = texts[currentLanguage].categories;
                }

                // Search placeholder - update the base placeholder
                const searchInput = document.querySelector('input#search');
                if (searchInput) {
                    const placeholderBase = texts[currentLanguage].searchPlaceholder;
                    searchInput.setAttribute('data-placeholder-base', placeholderBase);
                    // Restart the search animation with new language
                    if (typeof searchReveal === 'function') {
                        setTimeout(() => searchReveal(), 100);
                    }
                }

                // Popular section title
                const popularTitle = document.querySelector('section.popular h4');
                if (popularTitle) {
                    popularTitle.textContent = texts[currentLanguage].popularChoices;
                }

                // Reviews section title
                const reviewsTitle = document.querySelector('section.testmionals h4');
                if (reviewsTitle) {
                    reviewsTitle.textContent = texts[currentLanguage].reviews;
                }

                // Countdown section
                const saveUpToText = document.querySelector('.countdown .title h3');
                if (saveUpToText) {
                    const span = saveUpToText.querySelector('span');
                    const numberSpan = span ? span.innerHTML : 'EGP <span class="number">85</span>';
                    saveUpToText.innerHTML = `${texts[currentLanguage].saveUpTo} <span> ${numberSpan} </span>`;
                }

                // Footer navigation - handled by data-text attributes above

                // Language selector texts
                const languageTitle = document.querySelector('.language-card h2');
                if (languageTitle) {
                    languageTitle.innerHTML = currentLanguage === 'ar' ? 
                        'اختر اللغة<br>Choose Language' : 
                        'Choose Language<br>اختر اللغة';
                }

                // Account buttons in language selector - handled by data-text attributes above

                // Pop-up modal texts
                const popUpTitle = document.querySelector('.pop-up h3');
                const popUpPrice = document.querySelector('.pop-up span');
                if (popUpTitle && popUpPrice) {
                    popUpTitle.textContent = texts[currentLanguage].mealName;
                    popUpPrice.textContent = texts[currentLanguage].mealPrice;
                }

                // Loading indicator detailed text
                const loadingDetailText = document.querySelector('.loading small');
                if (loadingDetailText) {
                    loadingDetailText.textContent = texts[currentLanguage].loadingFirstTime;
                }

                // Update any error messages that might be showing
                const errorRefreshBtn = document.querySelector('.text-center .btn-outline-primary');
                const errorReloadBtn = document.querySelector('.text-center .btn-outline-secondary');
                if (errorRefreshBtn) {
                    errorRefreshBtn.innerHTML = `<i class="fas fa-sync-alt me-1"></i> ${texts[currentLanguage].refreshData}`;
                }
                if (errorReloadBtn) {
                    errorReloadBtn.innerHTML = `<i class="fas fa-redo me-1"></i> ${texts[currentLanguage].reloadPage}`;
                }

                // Update cart modal texts if it exists
                const cartTitle = document.querySelector('#cartBox h4');
                if (cartTitle) {
                    cartTitle.innerHTML = `<i class="fa-solid fa-cart-shopping me-2"></i> ${texts[currentLanguage].cartTitle}`;
                }

                const sendOrderBtn = document.querySelector('#sendOrderBtn');
                if (sendOrderBtn) {
                    sendOrderBtn.innerHTML = `<i class="fa-solid fa-paper-plane me-2"></i> ${texts[currentLanguage].sendOrder}`;
                }

                // Update form placeholders in cart modal
                const nameInput = document.querySelector('#cartBox input[name="name"]');
                const emailInput = document.querySelector('#cartBox input[name="email"]');
                const phoneInput = document.querySelector('#cartBox input[name="phone"]');
                const tableInput = document.querySelector('#cartBox input[name="table_number"]');
                
                if (nameInput) nameInput.placeholder = texts[currentLanguage].typeName;
                if (emailInput) emailInput.placeholder = texts[currentLanguage].typeEmail;
                if (phoneInput) phoneInput.placeholder = texts[currentLanguage].typePhone;
                if (tableInput) tableInput.placeholder = texts[currentLanguage].selectTable;

                // Update page title
                document.title = currentLanguage === 'ar' ? 
                    'قائمة المطعم - Restaurant Menu' : 
                    'Restaurant Menu - قائمة المطعم';

                // Update HTML lang attribute
                document.documentElement.lang = currentLanguage;
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
            document.querySelectorAll('body *:not(.language-selector , .loader , .loader *)').forEach(e => e.classList.remove('d-none'));
            


            if (currentLanguage == 'ar' ) {
                if (document.querySelector('.menu-header .search i') ) {
                    document.querySelector('.menu-header .search i').style.cssText = 'right: auto ; left : 16%';            
                }
            }
            
            
            // تحميل البيانات (محلياً أو من السيرفر)
            if (typeof loadMenuData === 'function') {
                await loadMenuData();
            }

            
            if (typeof updateOffers === 'function') {
                await updateOffers();
            }

            
        }
        window.onload = function () {
            document.querySelector('.loader').classList.add('end');
        }

        
        function formatPhoneFor(element) {
            element.addEventListener('input', function(e) {
                let value = e.target.value.replace(/\D/g, '');
                if (value.length > 0 && !value.startsWith('01')) {
                    value = '01' + value.slice(2);
                }
                if (value.length > 11) {
                    value = value.slice(0, 11);
                }
                e.target.value = value;
            });
        }


        
        document.querySelector('.bellIcon').addEventListener('click' , () => {
            document.querySelector('.bell-holder').classList.add('active');
        })
        
        document.querySelector('.bell-holder i.fa-x').addEventListener('click' ,()=> {
            document.querySelector('.bell-holder').classList.remove('active');
        } )

    </script>

    @yield('js')

</body>
</html>
