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
var popularSwiper = new Swiper(".popular-swiper", {
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
//                                         <div class="size-item p-2 border rounded" style="color: #0e6030;">
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
//                                         <div class="extra-item p-2 border rounded" style="color: #0e6030;">
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



const popUp = document.querySelector('.pop-up');
const allMeals = document.querySelectorAll('.mealsSwiper img');


allMeals.forEach(img => {
    img.addEventListener('click' , () => {
        const slide = img.parentElement;
        popUp.querySelector('img').src = img.src;

        popUp.querySelector('h3').textContent = slide.querySelector('h3').textContent;
        popUp.querySelector('span').textContent = slide.querySelector('span').textContent;
        popUp.querySelector('p').textContent = slide.querySelector('p').textContent;


        popUp.classList.add('active');
    })
})

popUp.querySelector('.close i').addEventListener('click' , () => {
    popUp.classList.remove('active');
})

