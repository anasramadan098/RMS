
    @extends('layouts.menu')

    @section('title' , 'HOME')



    @section('search') 
        <div class="search">
            <input type="text" name="menu-search" id="search" placeholder="Search for ..." data-words="Café,Sandwiches,Drinks" data-text="searchPlaceholder">
            <i class="fa-solid fa-magnifying-glass"></i>
                <script>
                    function searchReveal() {
                        const el = document.getElementById('search');
                        let words = el.dataset.words.split(',');
                        let wi = 0, ci = 0, back = false;
                        const baseText = currentLanguage === 'ar' ? 'البحث عن ' : 'Search for ';
                        
                        setInterval(() => {
                            let txt = words[wi].slice(0, ci);
                            el.placeholder = baseText + txt;
                        
                            if (!back && ci++ === words[wi].length) back = true, setTimeout(()=>{},1000);
                            if (back && --ci === 0) back = false, wi = (wi+1) % words.length;
                        
                        }, 120);
                    }
                </script>

        </div>
    @endsection


    @section('swipers')
        <!-- Categories Swiper -->
        <div class="categories-swiper"> 
            <div class="container">
                <h4 class="categories-title" data-text="categories"> 
                    Categories
                </h4>
                <div class="swiper categoriesSwiper">
                    <div class="swiper-wrapper" id="categoriesWrapper">
                        <!-- Categories will be loaded here -->
                    </div>
                </div>
            </div>
        </div>


        <div class="meals-swiper">
              <div class="swiper mealsSwiper" dir="rtl">
                <div class="swiper-wrapper">
                
                </div>
                <div class="swiper-pagination"></div>
            </div>
        </div>

        <!-- Meals Container -->
        <div class="meals-container">
            <div id="mealsWrapper" class="d-flex flex-column">
                <div class="loading">
                    <div class="spinner-border text-primary" role="status">
                        <span class="visually-hidden">Loading...</span>
                    </div>
                    <p class="mt-3 loading-text">جاري تحميل القائمة...</p>
                </div>
            </div>
        </div>
    @endsection


    @section('content')
        <section class="ads">
            <div class="swiper adsSwiper">
            <div class="swiper-wrapper">
                @foreach ($ads as $ad)
                    <div class="swiper-slide">
                        <img src="{{ asset($ad->path) }}" />
                    </div>
                @endforeach
            </div>
            <div class="swiper-pagination"></div>
        </div>
        </section>
        <section class="popular">
            <div class="container">
                <h4 class="mb-2 mt-5" data-text="popularChoices">
                Popular Choices 
                </h4>
                <div class="popular-swiper">
                    <div class="swiper normalSwiper">
                        <div class="swiper-wrapper">
                            @foreach ($popular_meals as $meal)
                                <div class="swiper-slide">
                                <img src="{{asset($meal->image)}}" />
                                <div class="box">                       
                                    <div class="content">
                                        <h3>{{$meal->name_en}}</h3>
                                        <span>
                                            EG {{$meal->price}}
                                        </span>
                                        <p style="display: none">
                                            {{$meal->description}}
                                        </p>
                                    </div>
                                </div>
                                </div>
                            @endforeach
                        </div>
                        <div class="swiper-pagination"></div>
                    </div>
                </div>
            </div>

        </section>
        <section class="countdown">
            <div class="container">
                <div class="title">
                    <div class="row">
                        <i class="fa-solid fa-gem"></i>
                        <h3>
                            Save Up To <span> EGP <span class="number">85</span> </span>
                        </h3>
                    </div>
                    <span class="counter">
                        24:50
                    </span>
                </div>
                <div class="swiper countdownSwiper">
                    <div class="boxes swiper-wrapper">


                        @php

                        $meals = \App\Models\Meal::take(10)->get();

                        $pairedMeals = [];
                        for ($i = 0; $i < count($meals); $i += 2) {
                            $pair = [];
                            $pair[] = $meals[$i];
                            $pair[] = $meals[$i + 1];
                            // if (isset($meals[$i + 1])) {
                            //     $pair[] = $meals[$i + 1];
                            // } else {
                            //     // If there's no second element, skip adding another element
                            // }
                            $pairedMeals[] = $pair;
                        }



                        @endphp
                        
                        @foreach ($pairedMeals as $meal) 
                            <div class="swiper-slide ">
                                <div class="box">
                                    <img src="{{asset($meal[0]->image)}}" alt="Meal Image " />
                                    <div class="text">
                                        <h4>
                                            {{ $meal[0]->name_en }}
                                        </h4>
                                        <p>
                                            {{ $meal[0]->price }} 
                                        </p>
                                    </div>
                                </div>
                                <div class="box">
                                    <img src="{{asset($meal[1]->image)}}" alt="Meal Image " />
                                    <div class="text">
                                        <h4>
                                            {{ $meal[1]->name_en }}
                                        </h4>
                                        <p>
                                            {{ $meal[1]->price }} 
                                        </p>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
            </div>
        </section>
        <style>
            .countdown {
                background: #eee;
                padding-top: 30px;
                padding-bottom: 30px;
                .title {
                    display: flex;
                    justify-content: space-between;
                    align-items: center;
                    .row {
                        flex-wrap: nowrap;
                        align-items: center;
                                    margin: 0 10px;
                        gap: 10px;
                        > * {
                            width: auto;
                        }
                    }
                    i {
                        font-size: 1.3em;
                        margin: 0;
                        padding: 0;
                        color: var(--green);
                    }
                    h3 {
                        font-size:1em;
                        padding: 0;
                        span {
                            color: var(--green);
                        }
                    }
                    > .counter {
                        background: var(--white);
                        padding: 3px 7px;
                        border-radius: 50px;
                        color: var(--green);
                        font-weight: bold;
                    }
                }
                .boxes {
                    display: flex;
                    gap: 15px;
                    margin-top: 30px;
                    .swiper-slide {
                        display: flex;
                        flex-wrap: wrap;
                    }
                    .box {
                        display: flex;
                        border: 1px solid #ddd;
                        width: 100%;
                        margin-bottom: 20px; 
                        border-radius: 7px;
                        img {
                            max-width: 100px;
                            border-radius: 7px;
                        }
                        .text {
                            background: var(--white);
                            width: 100%;
                            padding: 10px 30px;
                        }
                    }
                }
            }
        </style>
        <section class="testmionals" style="padding-top : 30px;">
            <div class="container">
                
                <h4 data-text="reviews">Reviews</h4>
                <div class="swiper testimonialsSwiper">
                    <div class="swiper-wrapper">
                        @foreach ($feedbacks as $feedback)
                            <div class="swiper-slide">
                                
                                <div class="user">
                                    {{-- Icon Icon --}}
                                    <div class="info">
                                        <i class="fa-solid fa-user"></i>
                                        <h3>
                                            {{$feedback->en_name}}
                                        </h3>
                                    </div>
                                    <div class="details">
                                        <div class="stars">
                                            @php
                                                $all_stars = $feedback->stars;
                                                $negative_stars = 5 - $all_stars;
                                            @endphp
                                            {{-- Loop ON $feedback->stars --}}
                                            @for ($i = 0; $i < $all_stars ; $i++)  
                                                ⭐
                                            @endfor

                                            @for ($i = 0; $i < $negative_stars ; $i++)  
                                                ☆                         
                                            @endfor

                                            <div class="date">
                                                {{$feedback->date}}
                                            </div>
                                        </div>
                                        <p>"{{$feedback->en_comment}}"</p>
                                    </div>
                                </div>
                                
                            </div>
                        
                        @endforeach
                    </div>
                    <div class="swiper-pagination"></div>
                </div>
            </div>
        </section>
        {{-- Pop Up --}}
        <div class="pop-up">
            {{-- X ICon --}}
            <div class="close">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <img src="{{asset('img/product-defualt.jpg')}}" alt="Image">
            <div class="sizes">
                <div class="size small" data-price="">
                    <i class="fa-solid fa-wine-glass"></i>
                </div>
                <div class="size medium" data-price="">
                    <i class="fa-solid fa-wine-glass"></i>
                </div>
                <div class="size large" data-price="">
                    <i class="fa-solid fa-wine-glass"></i>
                </div>
            </div>
            <div class="row">
                <h3>
                    Meal Name
                </h3>
                <span>
                    Price
                </span>
            </div>
            <p>
                Lorem ipsum dolor sit amet consectetur adipisicing elit. Dignissimos, explicabo!
            </p>
        </div>
        {{-- Image Holder --}}
        <div class="image-holder">
            <div class="close">
                <i class="fa-solid fa-xmark"></i>
            </div>
            <img src="{{asset('img/product-defualt.jpg')}}" alt="Image">
        </div> 
        <p class="dangrous" style="color: red;padding: 25px;text-align: center; display:none;">
            
        </p>
        @endsection   
        
        
        
        @section('js')
            <!-- Bootstrap JS -->
            <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.0/dist/js/bootstrap.bundle.min.js"></script>
            <!-- Swiper JS -->
            <script src="https://cdn.jsdelivr.net/npm/swiper@10/swiper-bundle.min.js"></script>

            <script>
                var countdownSwiper = new Swiper(".countdownSwiper", {
                    spaceBetween: 30,
                    slidesPerView : 1.3,
                    // centeredSlides: true,
                    loop: true,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                });


                const counterElement = document.querySelector('.countdown .counter');
                
                const now = new Date();
                const tomorrow = new Date('2025-08-30 16:00:00');
                const diffInSeconds = Math.round((tomorrow.getTime() - now.getTime()) / 1000);
                let time = diffInSeconds;

                function updateCounter() {
                    const minutes = Math.floor(time / 60);
                    const seconds = time % 60;

                    counterElement.textContent = `${minutes.toString().padStart(2, '0')}:${seconds.toString().padStart(2, '0')}`;

                    if (time <= 0) {
                        clearInterval(countdownInterval);
                        counterElement.textContent = "00:00";
                        // Optionally, add logic for when the countdown finishes
                    } else {
                        time--;
                    }
                }

                const countdownInterval = setInterval(updateCounter, 1000);
                updateCounter(); // Initial call to display the time immediately

                
            </script>

            <script>
                var adsSwiper = new Swiper(".adsSwiper", {
                    spaceBetween: 30,
                    // centeredSlides: true,
                    loop: true,
                    autoplay: {
                        delay: 2500,
                        disableOnInteraction: false,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                });
                
                var normalSwiper = new Swiper('.normalSwiper' , {
                    slidesPerView: 2.5,
                    spaceBetween: 20,

                    pagination: {
                        el: ".swiper-pagination",
                    }
                })

                var testimonialsSwiper = new Swiper(".testimonialsSwiper", {
                    pagination: {
                        el: ".swiper-pagination",
                        clickable: true,
                    },
                    autoplay: {
                        delay: 5000,
                        disableOnInteraction: false,
                    },
                    loop: true,
                });

                var mealsSwiper = new Swiper(".mealsSwiper", {
                    effect: "coverflow",
                    grabCursor: true,
                    centeredSlides: true,
                    slidesPerView: "auto",
                    coverflowEffect: {
                        rotate: 50,
                        stretch: 0,
                        depth: 100,
                        modifier: 1,
                        slideShadows: true,
                    },
                    pagination: {
                        el: ".swiper-pagination",
                    },
                });
                // var popularSwiper = new Swiper(".popular-swiper", {
                //     effect: "coverflow",
                //     grabCursor: true,
                //     centeredSlides: true,
                //     slidesPerView: "auto",
                //     coverflowEffect: {
                //         rotate: 50,
                //         stretch: 0,
                //         depth: 100,
                //         modifier: 1,
                //         slideShadows: true,
                //     },
                //     pagination: {
                //         el: ".swiper-pagination",
                //     },
                // });



                // meals.forEach((meal, index) => {
                //                 const mealElement = document.createElement('div');
                //                 mealElement.className = 'meal-item';
                //                 mealElement.style.opacity = '0';
                //                 mealElement.style.transform = 'translateY(20px)';

                //                 let order;
                //                 if (meal.order != 0) {
                //                     order = meal.order;
                //                 } else {
                //                     order = index;
                //                 }
                //                 mealElement.style.order = order;

                //                 const imageUrl = meal.image ?
                //                     (meal.image.startsWith('http') ? meal.image : `{{ asset('img/productImages/') }}/${meal.image}`) :
                //                     '{{ asset("img/product-defualt.jpg") }}';

                //                 // Generate sizes HTML
                //                 let sizesHTML = '';
                //                 if (meal.sizes && meal.sizes.length > 0) {
                //                     sizesHTML = `
                //                         <div class="meal-sizes mb-3">
                //                             <h6 class="mb-2 text-center">${texts[currentLanguage].availableSizes}:</h6>
                //                             <div class="d-flex flex-wrap justify-content-center gap-2">
                //                                 ${meal.sizes.map(size => {
                //                                     let priceHtml = '';
                //                                     if (meal.expiration_date) {
                //                                         if (new Date(meal.expiration_date).getTime() <= new Date().getTime()) {
                //                                             let discountPrice = size.price - (meal.discount_number);
                //                                             if (disClient && disClient.per > 1) {
                //                                                 discountPrice = discountPrice - (discountPrice * Number(disClient.per.split('%')[0]) / 100);
                //                                                 priceHtml = `<del>${size.price}</del> ${discountPrice.toFixed(2)} ${texts[currentLanguage].price}`;
                //                                             } else {
                //                                                 priceHtml = `<del>${size.price}</del> ${discountPrice.toFixed(2)} ${texts[currentLanguage].price}`;
                //                                             }
                //                                         } else {
                //                                             if (disClient && disClient.per > 1) {
                //                                                 const discounted = (size.price - (size.price * Number(disClient.per.split('%')[0]) / 100)).toFixed(2);
                //                                                 priceHtml = `<del>${size.price}</del> ${discounted} ${texts[currentLanguage].price}`;
                //                                             } else {
                //                                                 priceHtml = `${size.price} ${texts[currentLanguage].price}`;
                //                                             }
                //                                         }
                //                                     } else {
                //                                         if (disClient && disClient.per > 1) {
                //                                             const discounted = (size.price - (size.price * Number(disClient.per.split('%')[0]) / 100)).toFixed(2);
                //                                             priceHtml = `<del>${size.price}</del> ${discounted} ${texts[currentLanguage].price}`;
                //                                         } else {
                //                                             priceHtml = `${size.price} ${texts[currentLanguage].price}`;
                //                                         }
                //                                     }
                //                                     return `
                //                                         <div class="size-item p-2 border rounded" style="color: var(--green);">
                //                                             ${size.name} - ${priceHtml}
                //                                         </div>
                //                                     `;
                //                                 }).join('')}
                //                             </div>
                //                         </div>
                //                     `;
                //                 }

                //                 // Generate extras HTML
                //                 let extrasHTML = '';
                //                 if (meal.extras && meal.extras.length > 0) {

                                    
                //                     extrasHTML = `
                //                         <div class="meal-extras">
                //                             <h6 class="mb-2 text-center">${texts[currentLanguage].availableExtras}:</h6>
                //                             <div class="d-flex flex-wrap justify-content-center gap-2">
                //                                 ${meal.extras.map(extra => {
                //                                     let priceHtml = '';
                //                                     if (meal.expiration_date) {
                //                                         if (new Date(meal.expiration_date).getTime() <= new Date().getTime()) {
                //                                             let discountPrice = extra.price - (meal.discount_number);
                //                                             if (disClient && disClient.per > 1) {
                //                                                 discountPrice = discountPrice - (discountPrice * Number(disClient.per.split('%')[0]) / 100);
                //                                                 priceHtml = `<del>${extra.price}</del> ${discountPrice.toFixed(2)} ${texts[currentLanguage].price}`;
                //                                             } else {
                //                                                 priceHtml = `<del>${extra.price}</del> ${discountPrice.toFixed(2)} ${texts[currentLanguage].price}`;
                //                                             }
                //                                         } else {
                //                                             if (disClient && disClient.per > 1) {
                //                                                 const discounted = (extra.price - (extra.price * Number(disClient.per.split('%')[0]) / 100)).toFixed(2);
                //                                                 priceHtml = `<del>${extra.price}</del> ${discounted} ${texts[currentLanguage].price}`;
                //                                             } else {
                //                                                 priceHtml = `${extra.price} ${texts[currentLanguage].price}`;
                //                                             }
                //                                         }
                //                                     } else {
                //                                         if (disClient && disClient.per > 1) {
                //                                             const discounted = (extra.price - (extra.price * Number(disClient.per.split('%')[0]) / 100)).toFixed(2);
                //                                             priceHtml = `<del>${extra.price}</del> ${discounted} ${texts[currentLanguage].price}`;
                //                                         } else {
                //                                             priceHtml = `${extra.price} ${texts[currentLanguage].price}`;
                //                                         }
                //                                     }
                //                                     return `
                //                                         <div class="extra-item p-2 border rounded" style="color: var(--green);">
                //                                             ${extra.name} + ${priceHtml}
                //                                         </div>
                //                                     `;
                //                                 }).join('')}
                //                             </div>
                //                         </div>
                //                     `;
                //                 }


                //                 let finalContent = '';

                                
                //                 if (meal.extras.length == 0 &&  meal.sizes.length == 0) {
                //                     if (meal.expiration_date) {
                //                         if (new Date(meal.expiration_date).getTime()  <= new Date().getTime()) {
                //                             let discountPrice = meal.price - (meal.discount_number)
                //                             if (disClient && disClient.per > 1) {
                //                                 discountPrice = discountPrice - ( discountPrice * Number(disClient.per.split('%')[0]).toFixed(2) / 100);
                //                             }
                //                             console.log('Enter Here')
                //                             finalContent = `<div class="meal-price"><del>${meal.price}</del> ${discountPrice} ${texts[currentLanguage].price}</div>`
                //                         }
                //                     } else {
                //                         if (disClient && disClient.per > 1) {
                //                             finalContent = `<div class="meal-price"> <del>${meal.price}</del> ${(meal.price - (meal.price * Number(disClient.per.split('%')[0]) / 100)).toFixed(2)} ${texts[currentLanguage].price}</div>`
                //                         } else {
                //                             finalContent = `<div class="meal-price">${meal.price} ${texts[currentLanguage].price}</div>`
                //                         }
                //                     }
                //                 } else {
                //                     finalContent = `
                                    
                //                             ${sizesHTML}
                //                             ${extrasHTML}
                                    
                //                     `
                //                 }

                //                 if (disClient && disClient.per > 1) {
                //                     disClient.purchsed = true;
                //                     localStorage.setItem('somi_client' , JSON.stringify(disClient));
                //                 }
                
                //                 function addToOrders() {
                                    
                //                 }
                //                 // QTY INput
                //                 const qtyInput = document.createElement('input');
                //                 qtyInput.className = 'form-control';
                //                 qtyInput.type = 'number';
                //                 qtyInput.value = '0';
                //                 qtyInput.name = `qty-${meal.id}`;
                //                 qtyInput.addEventListener('change' , () => {
                //                     const mealId = meal.id;
                //                     const mealName = meal.name;
                //                     const qty = parseInt(qtyInput.value, 10) || 0;

                //                     // Check if meal already exists in orders
                //                     const existingOrder = orders.find(order => order.mealId === mealId);

                //                     if (existingOrder) {
                //                         existingOrder.qty = qty;
                //                     } else {
                //                         orders.push({ mealId, mealName, qty});
                //                     }

                //                     // Optionally, remove from orders if qty is 0
                //                     if (qty === 0) {
                //                         const idx = orders.findIndex(order => order.mealId === mealId);
                //                         if (idx !== -1) orders.splice(idx, 1);
                //                     }

                //                     // console.log(orders);
                //                 })

                //                 mealElement.innerHTML = `
                //                     <img src="${imageUrl}" alt="${meal.name}" onclick="showMealImage(this)" class="meal-image"
                //                          loading="lazy" onerror="this.src='{{ asset("img/product-defualt.jpg") }}'">
                //                     <div class="meal-info">
                //                         <div class="meal-name">${meal.name}</div>
                //                         ${meal.description ? `<div class="meal-description">${meal.description}</div>` : ''}
                //                         <div class="qty">
                //                         </div>
                //                     </div>
                //                     ${finalContent}
                //                 `;
                //                 // mealElement.querySelector('.qty').appendChild(qtyInput);

                //                 fragment.appendChild(mealElement);

                //                 // تأثير الظهور التدريجي
                //                 setTimeout(() => {
                //                     mealElement.style.transition = 'all 0.3s ease';
                //                     mealElement.style.opacity = '1';
                //                     mealElement.style.transform = 'translateY(0)';
                //                 }, index * 50);
                //             });

                //             mealsWrapper.innerHTML = '';
                //             mealsWrapper.appendChild(fragment);


                // Diplay None









            </script>

            <script>

                let disClient = JSON.parse(localStorage.getItem('somi_client')) ?? null;

                
                // if (disClient) {
                //     if (new Date(disClient.lastFollow) >= new Date()) {
                //         document.querySelector('.follow-btn').style.display = 'none';
                //         document.querySelector('.icon').style.display = 'none';
                //     } else {
                //         document.querySelector('.follow-btn').style.display = 'block';
                //          document.querySelector('.icon').style.display = 'block';
                //     }


                //     if (disClient.purchsed) {
                //         disClient = null;
                //     } else if (disClient.spin) {
                //         document.querySelector('.icon').style.display = 'none';
                //     }
                // }


                document.querySelector('.image-holder .close i').addEventListener('click' , () => {
                    document.querySelector('.image-holder').style.display = 'none';
                })


                

                // دوال التخزين المحلي
                function saveToLocalStorage() {
                    try {
                        allMenuData.lastUpdated = Date.now();
                        // localStorage.setItem(STORAGE_KEY, JSON.stringify(allMenuData));
                        // console.log('✅ تم حفظ البيانات في التخزين المحلي');
                    } catch (error) {
                        // console.warn('⚠️ فشل في حفظ البيانات محلياً:', error);
                    }
                }

                function loadFromLocalStorage() {
                    try {
                        // const cached = localStorage.getItem(STORAGE_KEY);
                        // if (!cached) return false;

                        // const data = JSON.parse(cached);
                        // const now = Date.now();

                        // // التحقق من انتهاء صلاحية البيانات
                        // if (!data.lastUpdated || (now - data.lastUpdated) > CACHE_DURATION) {
                        //     // console.log('⏰ انتهت صلاحية البيانات المحفوظة');
                        //     localStorage.removeItem(STORAGE_KEY);
                        //     return false;
                        // }

                        // allMenuData = data;
                        // console.log('✅ تم تحميل البيانات من التخزين المحلي');
                        return false;
                    } catch (error) {
                        // console.warn('⚠️ فشل في تحميل البيانات المحفوظة:', error);
                        // localStorage.removeItem(STORAGE_KEY);
                        return false;
                    }
                }

                function clearLocalStorage() {
                    // localStorage.removeItem(STORAGE_KEY);
                    allMenuData = { categories: {}, meals: {}, lastUpdated: null };
                    // console.log('🗑️ تم مسح البيانات المحفوظة');
                }

                // تحميل جميع البيانات مرة واحدة
                function preloadAllData() {

                    try {
                        // تحميل الفئات للغتين
                        const categoriesAr = @json($categories_ar).original;
                        const categoriesEn = @json($categories_en).original;

                        const mealsAr = @json($meals_ar);
                        const mealsEn = @json($meals_en);



                        // const [categoriesAr, categoriesEn] = await Promise.all([
                        //     fetch('/api/menu/categories?locale=ar').then(r => r.json()),
                        //     fetch('/api/menu/categories?locale=en').then(r => r.json())
                        // ]);

                        allMenuData.categories.ar = categoriesAr;
                        allMenuData.categories.en = categoriesEn;

                        // تحميل الوجبات لجميع الفئات واللغتين
                        // const mealPromises = [];


                        // للعربية
                        categoriesAr.forEach(category => {
                            

                            mealsAr.forEach(meal => {
                                if (meal.category_id === category.id) {
                                    if (!allMenuData.meals.ar) allMenuData.meals.ar = {};
                                    if (!allMenuData.meals.ar[category.id]) allMenuData.meals.ar[category.id] = [];

                                    allMenuData.meals.ar[category.id].push(meal);
                                }
                            })
                            // mealPromises.push(
                            //     fetch(`/api/menu/meals/${category.id}?locale=ar`)
                            //         .then(r => r.json())
                            //         .then(meals => {
                            //             if (!allMenuData.meals.ar) allMenuData.meals.ar = {};
                            //             allMenuData.meals.ar[category.id] = meals;
                            //         })
                            // );
                        });

                        // للإنجليزية
                        categoriesEn.forEach(category => {
                            mealsEn.forEach(meal => {
                                if (meal.category_id === category.id) {
                                    if (!allMenuData.meals.en) allMenuData.meals.en = {};
                                    if (!allMenuData.meals.en[category.id]) allMenuData.meals.en[category.id] = [];

                                    allMenuData.meals.en[category.id].push(meal);
                                }
                            })
                        });

                        // حفظ البيانات محلياً
                        // saveToLocalStorage();

                        return true;


                    } catch (error) {
                        console.log(error);
                        return false;
                    }
                }

                preloadAllData();

                // دالة تحميل البيانات الذكية
                async function loadMenuData() {
                    const startTime = performance.now();

                    // محاولة تحميل البيانات من التخزين المحلي أولاً
                    // const hasLocalData = loadFromLocalStorage();

                    // if (hasLocalData && allMenuData.categories[currentLanguage]) {
                    //     console.log('⚡ استخدام البيانات المحفوظة محلياً');
                    //     categories = allMenuData.categories[currentLanguage];
                    //     renderCategories();
                    //     initializeSwiper();

                    //     if (categories.length > 0) {
                    //         loadMealsFromCache(categories[0].id);
                    //         setActiveCategory(0);
                    //     }

                    //     const endTime = performance.now();
                    //     console.log(`✅ تم تحميل البيانات محلياً في ${Math.round(endTime - startTime)}ms`);
                    //     return;
                    // }

                    // إذا لم توجد بيانات محلية، تحميل من السيرفر
                    console.log('🌐 تحميل البيانات من السيرفر...');

                    // إظهار مؤشر التحميل
                    showLoadingIndicator();
                    

                    try {
                        // تحميل جميع البيانات مرة واحدة
                        const success = true;

                        if (success && allMenuData.categories[currentLanguage]) {
                            categories = allMenuData.categories[currentLanguage];
                            
                            // Search Bar
                            let words = [];
                            categories.map(category => {
                                words.push(category.name[0] +  category.name.slice(1).toLocaleLowerCase())  ;
                            })

                            document.querySelector('input#search').dataset.words = words.join(',');
                            searchReveal();
                            renderCategories();
                            // renderCategoriesBoxes();
                            document.querySelector('.loading').remove();
                            initializeSwiper();

                            
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
                        renderMeals(meals);
                    } else {
                        // console.warn('⚠️ لم توجد وجبات محفوظة للفئة:', categoryId);
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
                            <small class="text-muted">${texts[currentLanguage].loadingFirstTime}</small>
                        </div>
                    `;
                }



                function goBackToLanguageSelector() {
                    document.getElementById('menuContainer').style.display = 'none';
                    document.getElementById('languageSelector').style.display = 'flex';
                }


                function renderCategoriesBoxes() {
                    const holder = document.querySelector('.categories-boxes');
                    holder.innerHTML = '';
                    document.getElementById('categoriesWrapper').innerHTML = '';
                    if (!categories || categories.length === 0) {
                        holder.innerHTML = `<div class="box"><h5>${texts[currentLanguage].noCategories}</h5></div></div>`;
                        return;
                    }

                    categories.forEach((category, index) => {
                        const box = document.createElement('div');
                        box.className = 'box';
                        box.style.order = category.order;
                        box.innerHTML = category.name;
                        box.addEventListener('click' , () => {
                            holder.innerHTML = '';
                            renderCategories();
                            selectCategory(index , category.id);
                            scrollTo(0,0);
                        });
                        holder.appendChild(box);
                    });

                }


                function renderCategories() {
                    const wrapper = document.getElementById('categoriesWrapper');
                    wrapper.innerHTML = '';

                    if (!categories || categories.length === 0) {
                        wrapper.innerHTML = `<div class="swiper-slide"><div class="category-slide"><h5>${texts[currentLanguage].noCategories}</h5></div></div>`;
                        return;
                    }

                    categories.forEach((category, index) => {
                        const slide = document.createElement('div');
                        slide.className = 'swiper-slide';
                        slide.style.order = category.order;
                        console.log(category.image);
                        const imagePath = category.image ?? 'img/product-defualt.jpg';

                        slide.innerHTML = `
                            <div class="category-slide" onclick="selectCategory(${index}, ${category.id})">
                                <img src="{{asset( '${imagePath}' ) }}" alt="${category.name}" class="img-fluid mb-2" />
                                <h5>${category.name}</h5>
                            </div>
                        `;
                        slide.addEventListener('click' , () => {
                            scrollTo(0,0)
                        })
                        
                        wrapper.appendChild(slide);
                    });
                }

                function initializeSwiper() {
                    if (categoriesSwiper) {
                        categoriesSwiper.destroy();
                    }
                    
                    categoriesSwiper = new Swiper('.categoriesSwiper', {
                        slidesPerView: 3.5,
                        spaceBetween: 10,
                        freeMode: true,
                        breakpoints: {
                            320: {
                                slidesPerView: 4.5,
                                spaceBetween: 10
                            },
                            768: {
                                slidesPerView: 5.5,
                                spaceBetween: 15
                            },
                            1024: {
                                slidesPerView: 7.5,
                                spaceBetween: 20
                            }
                        },
                    });
                }

                function selectCategory(index, categoryId) {
                    // console.log('Category selected:', index, categoryId);
                    setActiveCategory(index);

                    categoriesSwiper.slideTo(index);

                    startOrdering()
                    
                    // تحميل الوجبات من البيانات المحفوظة (فوري!)
                    loadMealsFromCache(categoryId);
                }
                

                document.querySelector('input#search').addEventListener('input' , (e) => {
                    
                    startOrdering();
                    
                    const mealsArray = allMenuData.meals[currentLanguage];
                    let search = e.target.value;
                    
                    let results = [];


                    if (search.length == 0) {
                        document.querySelector('.mealsSwiper .swiper-wrapper').innerHTML = '';
                        
                        visitHome();
                        return;
                    }
            
                    // loop علي الـ object كله
                    for (const key in mealsArray) {
                    mealsArray[key].forEach(item => {
                        let name = item.name_ar ?? item.name_en;
                        if (name.toLowerCase().includes(search.toLowerCase())) {
                            results.push(item);
                        }
                    });
                    }
                    
                    renderMeals(results);
                    
                });
                document.querySelector('.search i').addEventListener('click' , () => {
                    window.scrollTo(0 , document.querySelector('.mealsSwiper ').offsetHeight) ;
                })

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
                    const mealsWrapper = document.querySelector('.mealsSwiper .swiper-wrapper');

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
                            const slide = document.createElement('div');
                            slide.className = 'swiper-slide';
                            slide.dataset.mealId = meal.id;
                            slide.dataset.categoryId = meal.category_id;
                            
                            const imageUrl = meal.image ?
                                (meal.image.startsWith('http') ? meal.image : `{{ asset('img/productImages/') }}/${meal.image}`) :
                                '{{ asset("img/product-defualt.jpg") }}';



                            let sizesHTML = '';
                            if (meal.sizes && meal.sizes.length > 0) {
                                sizesHTML = meal.sizes.map(size => {
                                    let priceHtml = '';
                                    if (meal.expiration_date) {
                                        if (new Date(meal.expiration_date).getTime() <= new Date().getTime()) {
                                            let discountPrice = size.price - (meal.discount_number);
                                            if (disClient && disClient.per > 1) {
                                                discountPrice = discountPrice - (discountPrice * Number(disClient.per.split('%')[0]) / 100);
                                                priceHtml = `<del>${size.price}</del> ${discountPrice.toFixed(2)} ${texts[currentLanguage].price}`;
                                            } else {
                                                priceHtml = `<del>${size.price}</del> ${discountPrice.toFixed(2)} ${texts[currentLanguage].price}`;
                                            }
                                        } else {
                                            priceHtml = `${size.price} ${texts[currentLanguage].price}`;
                                        }
                                    } else {
                                        priceHtml = `${size.price} ${texts[currentLanguage].price}`;
                                    }
                                    return `${size.name} - ${priceHtml}`;
                                }).join('<br>');
                            }
                            slide.innerHTML = `
                                <img src="${imageUrl}" />
                                <div class="box">                       
                                    <div class="content">
                                        <h3>${meal.name}</h3>
                                        <p style="display : none"> ${meal.description} </p>
                                        ${sizesHTML ? `<div class="sizes" style="display : none;">${sizesHTML}</div>` : ''}
                                        ${`<span class="price" >${meal.price ?? meal.sizes[0].price} ${texts[currentLanguage].price}</span>`}
                                    </div>
                                </div>
                            `;

                            // <p>${meal.description || ''}</p>
                            fragment.appendChild(slide);
                        });




                    mealsWrapper.innerHTML = '';
                    mealsWrapper.appendChild(fragment);
                    enablePopUp();

                }

                function openCart() {
                    let cartOverlay = document.getElementById('cartOverlay');
                    if (!cartOverlay) {
                        cartOverlay = document.createElement('div');
                        cartOverlay.id = 'cartOverlay';
                        cartOverlay.style.cssText = `
                            position: fixed; top: 0; left: 0; width: 100vw; height: 100vh;
                            background: rgba(0,0,0,0.7); z-index: 2000; display: flex; align-items: center; justify-content: center;
                        `;
                        cartOverlay.innerHTML = `
                            <div id="cartBox" style="
                                background: var(--white); border-radius: 24px; max-width: 480px; width: 95vw; max-height: 90vh; overflow-y: auto;
                                box-shadow: 0 10px 40px rgba(0,0,0,0.25); padding: 2rem 1.5rem 1.5rem 1.5rem; position: relative; display: flex; flex-direction: column;
                            ">
                                <form>
                                    <button id="closeCartBtn" style="
                                        position: absolute; top: 18px; right: 18px; background: none; border: none; font-size: 1.7rem; color: var(--green); cursor: pointer;
                                    " title="Close"><i class="fa-solid fa-xmark"></i></button>
                                    <h4 style="text-align:center; margin-bottom:1.5rem; color:var(--green);">
                                        <i class="fa-solid fa-cart-shopping me-2"></i>
                                        ${texts[currentLanguage].cartTitle}
                                    </h4>
                                    <div class="main-details">
                                        <input class="form-control mb-3" type="text" placeholder="${texts[currentLanguage].typeName}" name="name"/>                            
                                        <input class="form-control mb-3" type="email" placeholder="${texts[currentLanguage].typeEmail}" name="email"/>                            
                                        <input class="form-control mb-3" type="tel" placeholder="${texts[currentLanguage].typePhone}" name="phone"/>                            
                                        <input class="form-control mb-3 tableNumber" type="number" min="1" max="50" maxLength="2" placeholder="${texts[currentLanguage].selectTable}" name="table_number"/>                            
                                    </div>
                                    <div id="cartMeals"></div>
                                    <div id="cartTotal" style="margin: 1.5rem 0 1rem 0; text-align:center; font-weight:bold; color:#28a745;"></div>
                                    <button id="sendOrderBtn" class="btn btn-success w-100" style="font-size:1.2rem;">
                                        <i class="fa-solid fa-paper-plane me-2"></i>
                                        ${texts[currentLanguage].sendOrder}
                                    </button>
                                </form>
                            </div>
                        `;
                        document.body.appendChild(cartOverlay);

                        cartOverlay.querySelector('.tableNumber').addEventListener('input' , (e) => {
                            const value = e.target.value
                            if (value > 50 || value < 1 || String(value).length > 2) {
                                e.target.value = 0;
                            }
                        })
                        cartOverlay.addEventListener('click', e => {
                            if (e.target === cartOverlay) cartOverlay.style.display = 'none';
                        });
                        cartOverlay.querySelector('#closeCartBtn').onclick = () => cartOverlay.style.display = 'none';
                        cartOverlay.querySelector('#sendOrderBtn').onclick = (e) => {
                            e.preventDefault();

                            // Get all form data
                            const form = cartOverlay.querySelector('form');
                            const formData = new FormData(form);
                            const formObj = {};
                            for (const [key, value] of formData.entries()) {
                                formObj[key] = value;
                            }
                            // Group all data in one object
                            const orderData = {
                                customer: formObj,
                                orders: orders
                            };


                            // Send To Server
                            fetch("/menu-order", {
                                method : 'POST',
                                headers: {
                                    'Content-Type': 'application/json',
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                },
                                body : JSON.stringify(orderData)
                            }).then(res => res.json()).then(data => {
                                console.log(data);
                            })




                            alert(texts[currentLanguage].orderSent);
                            cartOverlay.style.display = 'none';
                        };
                    }

                    function renderCart() {
                        const cartMeals = cartOverlay.querySelector('#cartMeals');
                        cartMeals.innerHTML = '';
                        if (!orders.length) {
                            cartMeals.innerHTML = `<div class="text-center text-muted py-4">
                                <i class="fa-solid fa-basket-shopping fa-2x mb-2"></i><br>
                                ${texts[currentLanguage].cartEmpty}
                            </div>`;
                            cartOverlay.querySelector('#cartTotal').textContent = '';
                            return;
                        }
                        let total = 0;
                        orders.forEach((order, idx) => {
                            // Find meal data
                            let meal = null;
                            for (const catId in allMenuData.meals[currentLanguage]) {
                                meal = allMenuData.meals[currentLanguage][catId].find(m => m.id === order.mealId);
                                if (meal) break;
                            }
                            if (!meal) return;

                            // Sizes
                            let sizeOptions = '';
                            if (meal.sizes && meal.sizes.length > 0) {
                                sizeOptions = `<select class="form-select form-select-sm size-select" data-idx="${idx}" style="margin-bottom:6px;">` +
                                    `<option selected disabled value=""> ${texts[currentLanguage].selectSize} </option>` + 
                                    meal.sizes.map((size, sidx) =>
                                        `<option value="${sidx}" ${order.sizeIdx == sidx ? 'selected' : ''}>
                                            ${size.name} - ${size.price} ${texts[currentLanguage].price}
                                        </option>`
                                    ).join('') +
                                    `</select>`;
                            }

                            // Extras
                            let extrasOptions = '';
                            if (meal.extras && meal.extras.length > 0) {
                                extrasOptions = `<div class="d-flex flex-wrap gap-2 mb-2">` +
                                    meal.extras.map((extra, eidx) =>
                                        `<label class="form-check-label" style="font-size:0.95em;">
                                            <input type="checkbox" class="form-check-input extra-checkbox" data-idx="${idx}" data-eidx="${eidx}" ${order.extrasIdx && order.extrasIdx.includes(eidx) ? 'checked' : ''}>
                                            ${extra.name} +${extra.price} ${texts[currentLanguage].price}
                                        </label>`
                                    ).join('') +
                                    `</div>`;
                            }

                            // Price calculation
                            let price = meal.price || 0;
                            if (meal.sizes && meal.sizes.length > 0 && order.sizeIdx !== undefined) {
                                price = meal.sizes[order.sizeIdx || 0].price;
                            }
                            let extrasPrice = 0;
                            if (meal.extras && meal.extras.length > 0 && order.extrasIdx && order.extrasIdx.length) {
                                extrasPrice = order.extrasIdx.reduce((sum, eidx) => sum + (meal.extras[eidx]?.price || 0), 0);
                            }
                            let itemTotal = (price + extrasPrice) * (order.qty || 0);
                            total += itemTotal;

                            // Cart item
                            const itemDiv = document.createElement('div');
                            itemDiv.className = 'cart-meal-item mb-3 p-2 rounded shadow-sm';
                            itemDiv.style.background = '#f8f9fa';
                            itemDiv.innerHTML = `
                                <div class="d-flex align-items-center justify-content-between mb-1">
                                    <div style="font-weight:600; color:var(--green);">${meal.name}</div>
                                    <button class="btn btn-sm btn-outline-danger remove-meal" data-idx="${idx}" title="Remove"><i class="fa-solid fa-trash"></i></button>
                                </div>
                                ${sizeOptions}
                                ${extrasOptions}
                                <div class="d-flex align-items-center gap-2">
                                    <input type="number" min="1" class="form-control form-control-sm qty-input" style="width:60px;" value="${order.qty || 1}" data-idx="${idx}">
                                    <span style="font-weight:500;"> ${texts[currentLanguage].price}</span>
                                    <span class="ms-auto" style="font-weight:bold; color:#28a745;">
                                        ${(price + extrasPrice) * (order.qty || 1)} ${texts[currentLanguage].price}
                                    </span>
                                </div>
                            `;
                            cartMeals.appendChild(itemDiv);
                        });
                        cartOverlay.querySelector('#cartTotal').textContent =
                            texts[currentLanguage].total + ': ' + total + ' ' + texts[currentLanguage].price;

                        // QTY change
                        cartMeals.querySelectorAll('.qty-input').forEach(input => {
                            input.onchange = function () {
                                const idx = +this.dataset.idx;
                                let val = parseInt(this.value, 10);
                                if (isNaN(val) || val < 1) val = 1;
                                this.value = val;
                                orders[idx].qty = val;
                                renderCart();
                            };
                        });
                        // Remove meal
                        cartMeals.querySelectorAll('.remove-meal').forEach(btn => {
                            btn.onclick = function () {
                                const idx = +this.dataset.idx;
                                orders.splice(idx, 1);
                                renderCart();
                            };
                        });
                        // Size change
                        cartMeals.querySelectorAll('.size-select').forEach(sel => {
                            sel.onchange = function () {
                                const idx = +this.dataset.idx;
                                const selectedIdx = this.selectedIndex;
                                const meal = (() => {
                                    let m = null;
                                    for (const catId in allMenuData.meals[currentLanguage]) {
                                        m = allMenuData.meals[currentLanguage][catId].find(m => m.id === orders[idx].mealId);
                                        if (m) break;
                                    }
                                    return m;
                                })();
                                if (meal && meal.sizes && meal.sizes[selectedIdx]) {
                                    // Store by name and value, update if exists
                                    const selectedSize = meal.sizes[selectedIdx];
                                    orders[idx].size = {
                                        name: selectedSize.name,
                                        value: selectedSize.price
                                    };
                                    orders[idx].sizeIdx = selectedIdx;
                                }
                                renderCart();
                            };
                        });
                        // Extras change
                        cartMeals.querySelectorAll('.extra-checkbox').forEach(chk => {
                            chk.onchange = function () {
                                const idx = +this.dataset.idx;
                                const eidx = +this.dataset.eidx;
                                let meal = null;
                                for (const catId in allMenuData.meals[currentLanguage]) {
                                    meal = allMenuData.meals[currentLanguage][catId].find(m => m.id === orders[idx].mealId);
                                    if (meal) break;
                                }
                                if (!orders[idx].extras) orders[idx].extras = [];
                                if (!orders[idx].extrasIdx) orders[idx].extrasIdx = [];
                                const extraObj = meal && meal.extras && meal.extras[eidx]
                                    ? { name: meal.extras[eidx].name, value: meal.extras[eidx].price }
                                    : null;
                                if (this.checked) {
                                    // If exists, update value, else add
                                    const foundIdx = orders[idx].extras.findIndex(e => e.name === extraObj.name);
                                    if (extraObj) {
                                        if (foundIdx !== -1) {
                                            orders[idx].extras[foundIdx] = extraObj;
                                        } else {
                                            orders[idx].extras.push(extraObj);
                                        }
                                        if (!orders[idx].extrasIdx.includes(eidx)) {
                                            orders[idx].extrasIdx.push(eidx);
                                        }
                                    }
                                } else {
                                    // Remove by name
                                    if (extraObj) {
                                        orders[idx].extras = orders[idx].extras.filter(e => e.name !== extraObj.name);
                                        orders[idx].extrasIdx = orders[idx].extrasIdx.filter(i => i !== eidx);
                                    }
                                }
                                renderCart();
                            };
                        });
                    
                    }

                    renderCart();
                    cartOverlay.style.display = 'flex';
                }

            
                function showMealImage(e) {
                    document.querySelector('.image-holder img').src = e.src;
                    document.querySelector('.image-holder').style.display = 'flex';
                }

                function showError(customMessage = null) {
                    const mealsWrapper = document.getElementById('mealsWrapper');
                    const errorMessage = customMessage || texts[currentLanguage].error;
                    mealsWrapper.innerHTML = `
                        <div class="text-center py-5">
                            <i class="fas fa-exclamation-triangle fa-3x text-danger mb-3"></i>
                            <p class="text-danger">${errorMessage}</p>
                            <div class="mt-3">
                                <button class="btn btn-outline-primary me-2">
                                    <i class="fas fa-sync-alt me-1"></i>
                                    ${texts[currentLanguage].refreshData}
                                </button>
                                <button class="btn btn-outline-secondary" onclick="location.reload()">
                                    <i class="fas fa-redo me-1"></i>
                                    ${texts[currentLanguage].reloadPage}
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
                            <p class="text-muted">${texts[currentLanguage].noCategoriesAvailable}</p>
                        </div>
                    `;
                }


                // إعادة تعريف loadFromLocalStorage
                // loadFromLocalStorage = updateLoadFromLocalStorage();

                // تحديث preloadAllData لإظهار التقدم
                const originalPreload = preloadAllData;
                preloadAllData = async function() {
                    const result = await originalPreload();
                    return result;
                };






            </script>

            <script>
                



                function enablePopUp() {
                    const popUp = document.querySelector('.pop-up');
                    const allMeals = document.querySelectorAll('.mealsSwiper img');
    
    
                    allMeals.forEach(img => {
                        img.addEventListener('click' , () => {
                            const slide = img.parentElement;


                            let popUpMeal = allMenuData.meals[currentLanguage][slide.dataset.categoryId].find((meal) => {
                                return meal.id == slide.dataset.mealId;
                            });


                            popUp.querySelector('img').src = img.src;
    
                            popUp.querySelector('h3').textContent = popUpMeal.name;
                            popUp.querySelector('span').textContent = popUpMeal.price ?? popUpMeal.sizes[0].price;
                            popUp.querySelector('p').textContent = popUpMeal.description;


                            if (popUpMeal.sizes) {
                                popUpMeal.sizes.forEach((size , index) => {
                                    let sizeEle = popUp.querySelectorAll('.sizes .size')[index];
                                    sizeEle.classList.add('show');
                                    sizeEle.dataset.price = size.price;
                                    sizeEle.addEventListener('click' , () => {
                                        popUp.querySelectorAll('.sizes .size').forEach(size => size.classList.remove('active'));
                                        sizeEle.classList.add('active');
                                        popUp.querySelector('span').textContent = size.price;
                                    });
                                })
                                popUp.querySelectorAll('.sizes .size')[0].click();
                                
                            }

                            
    
                            popUp.classList.add('active');
                        })
                    })
    
                    popUp.querySelector('.close i').addEventListener('click' , () => {
                        popUp.classList.remove('active');
                    })
                }

                

                
                // Handle RTL direction for swipers when Arabic is selected
                function updateSwipersDirection() {
                    const isRTL = currentLanguage === 'ar';
                    
                    // Update all existing swipers
                    if (categoriesSwiper) {
                        categoriesSwiper.changeLanguageDirection(isRTL ? 'rtl' : 'ltr');
                        categoriesSwiper.update();
                    }
                    
                    if (adsSwiper) {
                        adsSwiper.changeLanguageDirection(isRTL ? 'rtl' : 'ltr');
                        adsSwiper.update();
                    }
                    
                    if (normalSwiper) {
                        normalSwiper.changeLanguageDirection(isRTL ? 'rtl' : 'ltr');
                        normalSwiper.update();
                    }
                    
                    if (testimonialsSwiper) {
                        testimonialsSwiper.changeLanguageDirection(isRTL ? 'rtl' : 'ltr');
                        testimonialsSwiper.update();
                    }
                    
                    if (mealsSwiper) {
                        mealsSwiper.changeLanguageDirection(isRTL ? 'rtl' : 'ltr');
                        mealsSwiper.update();
                    }
                    
                    if (countdownSwiper) {
                        countdownSwiper.changeLanguageDirection(isRTL ? 'rtl' : 'ltr');
                        countdownSwiper.update();
                    }
                    
                    // Update swiper containers direction
                    document.querySelectorAll('.swiper').forEach(swiperEl => {
                        swiperEl.dir = isRTL ? 'rtl' : 'ltr';
                    });
                }
                
                // Call this function in selectLanguage after setting the language
                if (typeof selectLanguage !== 'undefined') {
                    const originalSelectLanguage = selectLanguage;
                    selectLanguage = async function(lang) {
                        await originalSelectLanguage(lang);
                        // Update swipers direction after language change
                        setTimeout(() => {
                            updateSwipersDirection();
                        }, 100);
                    };
                }
            </script>
        
        @endsection
    