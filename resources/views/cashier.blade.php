<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    <meta charset="UTF-8">
    <meta name="viewport" content="width=device-width, initial-scale=1.0">
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>SOMI Cashier Dashboard</title>
    <link href="https://cdn.jsdelivr.net/npm/tailwindcss@2.2.19/dist/tailwind.min.css" rel="stylesheet">
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet">
    <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.7.2/css/all.min.css" integrity="sha512-Evv84Mr4kqVGRNSgIGL/F/aIDqQb7xQ2vcrdIwxfjThSH8CSR7PBEakCr51Ck+w+/U6swU2Im1vVX0SVk9ABhg==" crossorigin="anonymous" referrerpolicy="no-referrer" />

    <style>
        body {
            font-family: 'Inter', sans-serif;
            background-color: #e0f2f2;
        }
        .scrollable-content {
            max-height: calc(100vh - 80px);
            overflow-y: auto;
            -ms-overflow-style: none;
            scrollbar-width: none;
        }
        .scrollable-content::-webkit-scrollbar {
            display: none;
        }
        .table-card {
            background-color: #ffffff;
            border-radius: 12px;
            box-shadow: 0 4px 8px rgba(0, 0, 0, 0.05);
            transition: all 0.2s ease-in-out;
            cursor: pointer;
        }
        .table-card:hover {
            transform: translateY(-3px);
            box-shadow: 0 6px 12px rgba(0, 0, 0, 0.1);
        }
        .table-card.active {
            border: 2px solid #007bff;
        }
        .table-card.booked {
            background-color: #f00;
        }
        .size-radio:checked + label {
            background-color: #0e6030;
            color: white;
        }
        /* New styles for interactive elements */
        .category-btn.active {
            background-color: #0e6030;
            color: white;
        }
        .order-type-btn.active {
            background-color: #0e6030;
            color: white;
        }
        .payment-method-btn.active {
            background-color: #0e6030;
            color: white;
        }
        .addBtn {
            background-color: #0e6030;
            color: white;
            transition: .3s;
            &:hover {
                opacity :.7 !important;
            }
        }
        .sidebar {
            display:  none ;
            transform: translateX(-100%);
            transition: .3s;
            transition-delay: .3s;
            &.active {
                display: flex ;
                transform: translateX(0);
            }
            .item {
                padding: 10px 0;
                display: flex;
                gap: 18px;
                position: relative;
                &:not(:last-child) {
                    border-bottom: 1px solid #ddd;
                }
                .img {
                    width : 20%;
                    height : 100%;
                    img {
                        border-radius: 20%
                    }
                }
                h2 {
                    font-weight: bold;
                    font-size : 20px;
                    color : #000;
                }
                p {
                    margin : 5px 0;
                    font-size: 14px;
                    color : #333;
                }
                span.price {
                    font-size: 20px;
                    font-weight: bold;
                    color : #0e6030;
                }
                i {
                    position : absolute;
                    top : 10px;
                    left : 10px;
                    font-size: 20px;
                    color : #f00;
                    cursor : pointer;
                }
            }
        }
    </style>
</head>
<body class="flex flex-col h-screen">
    <!-- Logo Section -->
    <div class="p-4 fixed top-0 left-0 z-50">
        <img src="{{asset('img/logo.png')}}" alt="SOMI CAFE Logo" class="h-10 w-10 md:h-12 md:w-12 rounded-full shadow-md">
    </div>

    <div class="flex flex-1 overflow-hidden pt-16 md:pt-4">
        <!-- Main Content Area -->
        <div class="flex-1 p-4 md:p-6 scrollable-content">
            <!-- Header Section -->
            <div class="flex flex-col sm:flex-row justify-between items-start sm:items-center mb-6">
                <div class="mb-4 sm:mb-0 text-gray-700">
                    <p class="text-sm">{{ Carbon\Carbon::now()->format('F d, Y') }}</p>
                    <h1 class="text-2xl font-semibold text-gray-800">{{ env('APP_NAME') }}</h1>
                </div>

                <!-- Client Search Section -->
                <div class="flex flex-col items-end space-y-2">
                    <div class="relative">
                        <input
                            type="text"
                            id="clientSearch"
                            placeholder="اسم العميل"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64 text-right"
                            dir="rtl"
                        >
                        <div id="searchLoader" class="hidden mt-2 text-center">
                            <div class="inline-flex items-center px-3 py-1 text-sm text-blue-600 bg-blue-50 rounded-lg">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                جاري البحث...
                            </div>
                        </div>
                        <div id="clientInfo" class="hidden mt-2 p-3 bg-green-50 border border-green-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-green-800">
                                        <span class="font-semibold">المعرف:</span>
                                        <span id="clientId"></span>
                                    </p>
                                    <p class="text-sm text-green-800">
                                        <span class="font-semibold">العميل:</span>
                                        <span id="clientName"></span>
                                    </p>
                                    <p class="text-sm text-green-600">
                                        <span class="font-semibold">الهاتف:</span>
                                        <span id="clientPhone"></span>
                                    </p>
                                </div>
                                <button
                                    id="clearClient"
                                    class="text-green-600 hover:text-green-800 p-1"
                                    title="مسح العميل"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Employee Search Section -->
                <div class="flex flex-col items-end space-y-2">
                    <div class="relative">
                        <input
                            type="text"
                            id="employeeSearch"
                            placeholder="اسم الموظف"
                            class="px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent w-64 text-right"
                            dir="rtl"
                        >
                        <div id="employeeSearchLoader" class="hidden mt-2 text-center">
                            <div class="inline-flex items-center px-3 py-1 text-sm text-blue-600 bg-blue-50 rounded-lg">
                                <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-blue-600" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                    <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                    <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                </svg>
                                جاري البحث...
                            </div>
                        </div>
                        <div id="employeeInfo" class="hidden mt-2 p-3 bg-yellow-50 border border-yellow-200 rounded-lg">
                            <div class="flex items-center justify-between">
                                <div>
                                    <p class="text-sm text-yellow-800">
                                        <span class="font-semibold">المعرف:</span>
                                        <span id="employeeId"></span>
                                    </p>
                                    <p class="text-sm text-yellow-800">
                                        <span class="font-semibold">الموظف:</span>
                                        <span id="employeeName"></span>
                                    </p>
                                    <p class="text-sm text-yellow-600">
                                        <span class="font-semibold">الهاتف:</span>
                                        <span id="employeePhone"></span>
                                    </p>
                                    <p class="text-sm text-yellow-600">
                                        <span class="font-semibold">الوجبات المتاحه:</span>
                                        <div id="employeeMeals"></div>
                                    </p>
                                </div>
                                <button
                                    id="clearEmployee"
                                    class="text-yellow-600 hover:text-yellow-800 p-1"
                                    title="مسح الموظف"
                                >
                                    <svg class="w-4 h-4" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M6 18L18 6M6 6l12 12"></path>
                                    </svg>
                                </button>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- Add New Client Modal -->
            <div id="addClientModal" class="hidden fixed inset-0 bg-black bg-opacity-50 z-50 flex items-center justify-center">
                <div class="bg-white rounded-lg p-6 w-96 mx-4">
                    <h3 class="text-lg font-semibold mb-4 text-gray-800">إضافة عميل جديد</h3>
                    <form id="addClientForm">
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">اسم العميل</label>
                            <input
                                type="text"
                                id="newClientName"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                dir="rtl"
                            >
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">رقم الهاتف</label>
                            <input
                                type="tel"
                                id="newClientPhone"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                dir="ltr"
                            >
                        </div>
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700 mb-2">البريد الإلكتروني</label>
                            <input
                                type="email"
                                id="newClientEmail"
                                required
                                class="w-full px-3 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-blue-500 focus:border-transparent"
                                dir="ltr"
                            >
                        </div>
                        <div class="flex justify-end space-x-2 space-x-reverse">
                            <button
                                type="button"
                                id="cancelAddClient"
                                class="px-4 py-2 text-gray-600 bg-gray-200 rounded-lg hover:bg-gray-300 transition-colors"
                            >
                                إلغاء
                            </button>
                            <button
                                type="submit"
                                id="addClientBtn"
                                class="px-4 py-2 bg-blue-600 text-white rounded-lg hover:bg-blue-700 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                            >
                                <span id="addClientBtnText">إضافة العميل</span>
                                <span id="addClientBtnLoader" class="hidden">
                                    <svg class="animate-spin -ml-1 mr-2 h-4 w-4 text-white inline" xmlns="http://www.w3.org/2000/svg" fill="none" viewBox="0 0 24 24">
                                        <circle class="opacity-25" cx="12" cy="12" r="10" stroke="currentColor" stroke-width="4"></circle>
                                        <path class="opacity-75" fill="currentColor" d="M4 12a8 8 0 018-8V0C5.373 0 0 5.373 0 12h4zm2 5.291A7.962 7.962 0 014 12H0c0 3.042 1.135 5.824 3 7.938l3-2.647z"></path>
                                    </svg>
                                    جاري الإضافة...
                                </span>
                            </button>
                        </div>
                    </form>
                </div>
            </div>

            <!-- Categories Section -->
            <div class="mb-6">
                <div class="flex justify-between items-center mb-4">
                    <h2 class="text-xl font-semibold text-gray-800">العثور على أفضل الأطعمة</h2>
                </div>
                <div class="flex flex-wrap gap-2 text-sm">
                    {{-- <button class="category-btn active px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 cursor-pointer" data-type="all" data-id="0">الكل</button> --}}
                
                    @foreach ($categories as $category)
                        <button class="category-btn px-4 py-2 rounded-full bg-gray-200 text-gray-700 hover:bg-gray-300 cursor-pointer" data-type="{{$category->type}}" data-id="{{$category->id}}">
                            {{ $category->name_ar ?? $category->name }}
                        </button>
                    @endforeach
                    
                </div>
            </div>

            <!-- Food Items Grid -->
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 xl:grid-cols-4 gap-6 mb-6" id="meals-container">
                <!-- Food Item Card Template -->
                {{-- @foreach ($meals as $meal)
                    <div class="bg-white rounded-xl shadow-md p-4">
                        <h3 class="font-semibold text-lg text-gray-800 mealName">{{ $meal->name_ar }}</h3>
                        <p class="text-sm text-gray-500 mb-2 mealDescription">{{ $meal->description_ar }}</p>
                        <input type="hidden" name="type" value="{{$meal->category()->first()->type}}" class="mealType">
                        <!-- Size Selection -->
                        
                        <!-- Size Selection -->
                        <div class="mb-5 mt-5">
                            <div class="grid grid-cols-3 gap-2 sizesHolder">
                                @if ($meal->sizes)
                                    @foreach ($meal->sizes as $index => $size)
                                        <input type="radio" value="{{$size->name_ar}}" name="size-{{$meal->id}}" id="{{$size->name_en}}_{{$meal->id}}" class="hidden active size-radio" {{$index == 0 ? 'checked' : ''}}>
                                        <label for="{{$size->name_en}}_{{$meal->id}}" class="text-center py-1 px-2 rounded bg-gray-100 cursor-pointer text-sm">
                                            {{$size->name_ar}}
                                        </label>
                                    @endforeach
                                @else 
                                    <input type="radio" name="size-{{$size->id}}" id="default" class="hidden active size-radio" checked>
                                    <label for="default" class="text-center py-1 px-2 rounded bg-gray-100 cursor-pointer text-sm">
                                        الإفتراضي
                                    </label>
                                @endif
                            </div>
                        </div>
                        
                        <div class="flex justify-between items-center mb-2">
                            <span class="text-teal-600 font-bold">
                                £ <span class="mealPrice">{{$meal->price}}</span>
                            </span>
                            <input type="number" min="1" value="1" class="w-16 text-center border rounded mealQuantity">
                        </div>
                        
                        <button class="w-full mt-3 py-2 rounded-lg addBtn">
                            أضف إلى السلة
                        </button>
                    </div>
                @endforeach --}}
                
                <!-- Food Item Card Template -->
                
                <!-- Repeat similar structure for other food items -->
            </div>

            <!-- Table Selection Section -->
            <div class="mb-6">
                <h2 class="text-xl font-semibold text-gray-800 mb-4">اختيار الطاولة</h2>
                <div class="grid grid-cols-3 sm:grid-cols-4 md:grid-cols-5 lg:grid-cols-6 xl:grid-cols-8 gap-4" id="tables-container">
                    
                </div>
            </div>
        </div>

        <!-- Right Sidebar (Cart) -->
        <div class="w-full lg:w-96 bg-white p-4 md:p-6 shadow-lg lg:shadow-xl rounded-l-2xl flex flex-col scrollable-content sidebar">
            <h2 class="text-xl font-semibold text-gray-800 mb-4">طلبات</h2>

            <!-- Order Type Selection -->
            <div class="flex justify-around bg-gray-100 rounded-lg p-1 mb-4 orderTypeHolder">
                <button class="order-type-btn active flex-1 py-2 px-3 rounded-md text-center">تناول هنا</button>
                <button class="order-type-btn flex-1 py-2 px-3 rounded-md text-center">استلام</button>
                <button class="order-type-btn flex-1 py-2 px-3 rounded-md text-center">توصيل</button>
            </div>

            <!-- Cart Items -->
            <div class="flex-1 mb-4 space-y-4 itemsHolder">

            </div>

            <!-- Payment Section -->
            <div class="border-t border-gray-200 pt-4 mb-4">
                
                <div class="flex justify-between text-gray-700 mb-2">
                    <span>المجموع</span>
                    <span class="">£
                        <span class="subTotal"></span>
                    </span>
                </div>
                <div class="flex justify-between text-gray-700 mb-2">
                    <span>الضريبة</span>
                    <span class="">
                        <span class="taxNumber"></span>
                    </span>
                </div>
                <div class="flex justify-between text-red-500 mb-2">
                    <span>الخصم</span>
                    <input type="number" class="w-20 text-right border rounded discountNumber" placeholder="0.00" value="3.00">
                </div>
                <div class="flex justify-between text-lg font-bold text-gray-800">
                    <span>الإجمالي</span>
                    <span>
                        £ <span class="totalNumber"></span>
                    </span>
                </div>
            </div>

            <!-- Payment Method -->
            <div class="mb-4">
                <h3 class="font-medium text-gray-800 mb-2">طريقة الدفع</h3>
                <div class="grid grid-cols-3 gap-2 paymentHolder">
                    <button class="payment-method-btn active text-center py-2 px-3 rounded-md bg-gray-100">نقداً</button>
                    <button class="payment-method-btn text-center py-2 px-3 rounded-md bg-gray-100">بطاقة</button>
                    <button class="payment-method-btn text-center py-2 px-3 rounded-md bg-gray-100">محفظة</button>
                </div>
            </div>

            <!-- Checkout Button -->
            <button class="w-full bg-green-500 text-white py-3 rounded-lg text-lg font-semibold hover:bg-green-600 transition duration-200 shadow-lg orderSubBtn">
                إتمام الطلب
            </button>
        </div>
    </div>


    <script>



        // Emplyee 
        // #region
                    const employeeSearchInput = document.getElementById('employeeSearch');
                    const employeeInfo = document.getElementById('employeeInfo');
                    const employeeId = document.getElementById('employeeId');
                    const employeeName = document.getElementById('employeeName');
                    const employeePhone = document.getElementById('employeePhone');
                    const clearEmployeeBtn = document.getElementById('clearEmployee');
                    const employeeSearchLoader = document.getElementById('employeeSearchLoader');
                    let currentEmployee = null;

                    employeeSearchInput.addEventListener('keypress', function(e) {
                        if (e.key === 'Enter') {
                            e.preventDefault();
                            searchEmployee(this.value.trim());
                        }
                    });

                    async function searchEmployee(searchTerm) {
                        if (!searchTerm) {
                            hideEmployeeInfo();
                            hideEmployeeSearchLoader();
                            return;
                        }
                        showEmployeeSearchLoader();
                        try {
                            const response = await fetch(`/api/search-employee/${searchTerm}`, {
                                method: 'GET',
                                headers: {
                                    'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                                }
                            });
                            const data = await response.json();
                            hideEmployeeSearchLoader();
                            console.log(data);
                            if (data.success && data.employee) {
                                showEmployeeInfo(data.employee);
                            } else {
                                showEmployeeErrorMessage('لم يتم العثور على الموظف');
                            }
                        } catch (error) {
                            hideEmployeeSearchLoader();
                            showEmployeeErrorMessage('حدث خطأ أثناء البحث عن الموظف');
                        }
                    }

                    function showEmployeeInfo(employee) {
                        currentEmployee = employee;
                        employeeId.textContent = employee.id;
                        employeeName.textContent = employee.name;
                        employeePhone.textContent = employee.phone || 'غير محدد';
                        employeeInfo.classList.remove('hidden');
                        employeeSearchInput.value = employee.name;
                        const employeeMealsDiv = document.getElementById('employeeMeals');
                        employeeMealsDiv.innerHTML = '';
                        if (employee.meals && JSON.parse(employee.meals).length > 0) {
                            JSON.parse(employee.meals).forEach(meal => {
                                const mealRow = document.createElement('div');
                                mealRow.className = 'flex justify-between items-center mb-1';
                                mealRow.innerHTML = `
                                    <span class="font-semibold text-gray-700">${meal.name} : </span>
                                    <span class="ml-2 text-gray-600"> ${meal.qty} </span>
                                `;
                                employeeMealsDiv.appendChild(mealRow);
                            });
                        } else {
                            employeeMealsDiv.innerHTML = '<span class="text-gray-400">لا توجد وجبات متاحة</span>';
                        }
                    }

                    function hideEmployeeInfo() {
                        employeeInfo.classList.add('hidden');
                    }

                    function showEmployeeSearchLoader() {
                        employeeSearchLoader.classList.remove('hidden');
                        hideEmployeeInfo();
                    }

                    function hideEmployeeSearchLoader() {
                        employeeSearchLoader.classList.add('hidden');
                    }

                    function showEmployeeErrorMessage(message) {
                        const errorDiv = document.createElement('div');
                        errorDiv.className = 'fixed top-4 right-4 bg-yellow-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                        errorDiv.textContent = message;
                        document.body.appendChild(errorDiv);
                        setTimeout(() => {
                            errorDiv.remove();
                        }, 3000);
                    }

                    employeeSearchInput.addEventListener('input', function() {
                        if (!this.value.trim()) {
                            hideEmployeeInfo();
                        }
                    });

                    clearEmployeeBtn.addEventListener('click', function() {
                        hideEmployeeInfo();
                    });

        // #endregion



        // Table generation script
        document.addEventListener('DOMContentLoaded', function() {
            const tablesContainer = document.getElementById('tables-container');
            const numberOfTables = 50;
            const sidebar = document.querySelector('.sidebar');
            const orderTypeHolder = sidebar.querySelector('.orderTypeHolder');
            const paymentHolder = sidebar.querySelector('.paymentHolder');
            const taxNumber = sidebar.querySelector('.taxNumber');
            const discountNumber = sidebar.querySelector('.discountNumber');
            const itemsHolder = sidebar.querySelector('.itemsHolder');
            const subTotal = sidebar.querySelector('.subTotal');
            const totalNumber = sidebar.querySelector('.totalNumber');
            const mealsContainer = document.querySelector('#meals-container');
            const addBtns = document.querySelectorAll('.addBtn');
            let orders = {};


            for (let i = 1; i <= numberOfTables; i++) {
                const tableCard = document.createElement('div');
                tableCard.classList.add('table-card', 'p-4', 'flex', 'flex-col', 'items-center', 'justify-center', 'text-gray-700', 'text-lg', 'font-semibold', 'aspect-square');
                tableCard.innerHTML = `<span class="text-sm text-gray-500">طاولة</span><span class="the_number">${i}</span>`;
                tableCard.dataset.id = i;
                tablesContainer.appendChild(tableCard);

                tableCard.addEventListener('click', function() {
                    document.querySelectorAll('.table-card').forEach(card => {
                        card.classList.remove('active');
                    });
                    this.classList.add('active');
                    if (this.classList.contains('booked')) {
                        sidebar.classList.toggle('active');
                        renderSidebar(this.querySelector('.the_number').textContent)
                    }
                });
            }

            const data = @json($meals_by_category);
            console.log(data);
            // Add click handlers for interactive elements
            document.querySelectorAll('.category-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.category-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');


                    mealsContainer.innerHTML = '';

          
                    data[this.dataset.id].forEach(meal => {
                        
                        const mealCard = document.createElement('div');
                        mealCard.className = 'bg-white rounded-xl shadow-md p-4';

                        const mealId = document.createElement('input');
                        mealId.hidden = true;
                        mealId.name = 'meal_id';
                        mealId.value = meal.id;
                        mealCard.appendChild(mealId);
                        
                        
                        // // صورة الوجبة
                        // const mealImg = document.createElement('img');
                        // mealImg.src = meal.image;
                        // mealImg.alt = meal.name;
                        // mealImg.className = 'w-full h-32 object-cover rounded-lg mb-4';
                        // mealCard.appendChild(mealImg);

                        // اسم الوجبة
                        const mealName = document.createElement('h3');
                        mealName.className = 'font-semibold text-lg text-gray-800 mealName';
                        mealName.textContent = meal.name_ar;
                        mealCard.appendChild(mealName);

                        // وصف الوجبة
                        const mealDesc = document.createElement('p');
                        mealDesc.className = 'text-sm text-gray-500 mb-2 mealDescription';
                        mealDesc.textContent = meal.description_ar;
                        mealCard.appendChild(mealDesc);

                        // النوع المخفي
                        const hiddenType = document.createElement('input');
                        hiddenType.type = 'hidden';
                        hiddenType.name = 'type';
                        hiddenType.value = btn.getAttribute('data-type');
                        hiddenType.className = 'mealType';
                        mealCard.appendChild(hiddenType);

                        // حاوية الأحجام
                        const sizesContainer = document.createElement('div');
                        sizesContainer.className = 'mb-5 mt-5';

                        const sizesHolder = document.createElement('div');
                        sizesHolder.className = 'grid grid-cols-3 gap-2 sizesHolder';

                        if (meal.sizes.length > 0) {
                            Array.from(meal.sizes).forEach((size, index) => {
                                const sizeInput = document.createElement('input');
                                sizeInput.type = 'radio';
                                sizeInput.value = size.name_ar ?? size.name_en;
                                sizeInput.name = `size-${meal.id}`;
                                sizeInput.id = `${size.name_en}_${meal.id}`;
                                sizeInput.className = 'hidden active size-radio';
                                if (index === 0) sizeInput.checked = true;

                                const sizeLabel = document.createElement('label');
                                sizeLabel.setAttribute('for', `${size.name_en}_${meal.id}`);
                                sizeLabel.className = 'text-center py-1 px-2 rounded bg-gray-100 cursor-pointer text-sm';
                                sizeLabel.textContent = size.name_ar ?? size.name_en;

                                sizesHolder.appendChild(sizeInput);
                                sizesHolder.appendChild(sizeLabel);
                            });
                        } else {
                            const defaultInput = document.createElement('input');
                            defaultInput.type = 'radio';
                            defaultInput.name = `size-${meal.id}`;
                            defaultInput.id = 'default';
                            defaultInput.className = 'hidden active size-radio';
                            defaultInput.checked = true;

                            const defaultLabel = document.createElement('label');
                            defaultLabel.setAttribute('for', 'default');
                            defaultLabel.className = 'text-center py-1 px-2 rounded bg-gray-100 cursor-pointer text-sm';
                            defaultLabel.textContent = 'الإفتراضي';

                            sizesHolder.appendChild(defaultInput);
                            sizesHolder.appendChild(defaultLabel);
                        }

                        sizesContainer.appendChild(sizesHolder);
                        mealCard.appendChild(sizesContainer);

                        // السعر والكمية
                        const priceQtyDiv = document.createElement('div');
                        priceQtyDiv.className = 'flex justify-between items-center mb-2';

                        const priceSpan = document.createElement('span');
                        priceSpan.className = 'text-teal-600 font-bold';
                        priceSpan.innerHTML = `<span class="mealPrice">${meal.price}</span> £`;
                        priceQtyDiv.appendChild(priceSpan);

                        const quantityInput = document.createElement('input');
                        quantityInput.type = 'number';
                        quantityInput.min = '1';
                        quantityInput.value = '1';
                        quantityInput.className = 'w-16 text-center border rounded mealQuantity';
                        priceQtyDiv.appendChild(quantityInput);

                        mealCard.appendChild(priceQtyDiv);

                        // زر الإضافة للسلة
                        const addButton = document.createElement('button');
                        addButton.className = 'w-full mt-3 py-2 rounded-lg addBtn';
                        addButton.textContent = 'أضف إلى السلة';
                        addButton.addEventListener('click' , () => {
                                const meal = mealCard;

                                const mealName = meal.querySelector('.mealName').textContent;
                                const mealPrice = meal.querySelector('.mealPrice').textContent;
                                const mealSize = meal.querySelector('.sizesHolder input:checked').value;
                                const mealQuantity = meal.querySelector('.mealQuantity').value;
                                const mealType = meal.querySelector('.mealType').value;


                                if (currentEmployee) {
                                    if (currentEmployee.id != 1) {
                                        let employeeMeals = JSON.parse(currentEmployee.meals);
                                        let exceeded = false;
                                        
                                        if (employeeMeals.length > 0) {
                                            employeeMeals.map(meal => {
                                                if (meal.name == mealName) {
                                                    if (mealQuantity > meal.qty) {
                                                        alert('عدد الوجبات المطلوبة أكبر من المتاح للموظف!');
                                                        exceeded = true;
                                                    }
                                                } else {
                                                    alert('الوجبة غير مسموحة للموظف');
                                                    exceeded = true;
                                                }
                                            });
                                        } else {
                                            alert('الموظف ليس لديه وجبات');
                                            exceeded = true;
                                        }
                                        if (exceeded) {
                                            return;
                                        }
                                    }
                                }

                                const selectedTable = document.querySelector('.table-card.active');
                                if (!selectedTable) {
                                    alert('يجب إختيار الأول طاولة!');
                                    return;
                                }
                                const tableNumber = selectedTable.querySelector('.the_number').textContent;
                                

                                const order = {
                                    name: mealName,
                                    unit_price: mealPrice,
                                    size: mealSize,
                                    quantity: mealQuantity,
                                    table: tableNumber,
                                    type : mealType,
                                    total_price: mealPrice * mealQuantity,
                                    client_id : currentClient ? currentClient.id : null,
                                    meal_id : meal.querySelector('input[name="meal_id"]').value,
                                }


                                // Add New Key And Value In OBJ
                                if (selectedTable.classList.contains('booked'))  {
                                    orders[tableNumber].push(order);
                                } else {
                                    orders[tableNumber] = [order];
                                }

                                if (mealType == 'food') {
                                    // Print In Food Printer
                                    fetch("/kitchen-print" , {
                                        method : 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body : JSON.stringify(order)
                                    })
                                    .then(res => res.json())
                                    .then(data => console.log(data));

                                } else if (mealType == 'drink') {
                                    fetch("/bar-print" , {
                                        method : 'POST',
                                        headers: {
                                            'Content-Type': 'application/json',
                                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                                        },
                                        body : JSON.stringify(order)
                                    })
                                    .then(res => res.json())
                                    .then(data => console.log(data));
                                }

                                selectedTable.classList.remove('active');
                                selectedTable.classList.add('booked');
                                
                        })
                        mealCard.appendChild(addButton);

                        // وأخيرًا نضيف كل الكارت للـmealsContainer
                        mealsContainer.appendChild(mealCard);

                            
                    })
                    
                    
                    
                    
                    
                    
                    
                    
                });
            });


            document.querySelectorAll('.order-type-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.order-type-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });

            document.querySelectorAll('.payment-method-btn').forEach(btn => {
                btn.addEventListener('click', function() {
                    document.querySelectorAll('.payment-method-btn').forEach(b => b.classList.remove('active'));
                    this.classList.add('active');
                });
            });




            // Client Search Functionality
            const clientSearchInput = document.getElementById('clientSearch');
            const clientInfo = document.getElementById('clientInfo');
            const clientid = document.getElementById('clientId');
            const clientName = document.getElementById('clientName');
            const clientPhone = document.getElementById('clientPhone');
            const clearClientBtn = document.getElementById('clearClient');
            const searchLoader = document.getElementById('searchLoader');
            const addClientModal = document.getElementById('addClientModal');
            const addClientForm = document.getElementById('addClientForm');
            const cancelAddClient = document.getElementById('cancelAddClient');
            const newClientName = document.getElementById('newClientName');
            const newClientPhone = document.getElementById('newClientPhone');
            const newClientEmail = document.getElementById('newClientEmail');
            const addClientBtn = document.getElementById('addClientBtn');
            const addClientBtnText = document.getElementById('addClientBtnText');
            const addClientBtnLoader = document.getElementById('addClientBtnLoader');


            // #region client search
            let currentClient = null;

            // Search for client on Enter key press
            clientSearchInput.addEventListener('keypress', function(e) {
                if (e.key === 'Enter') {
                    e.preventDefault();
                    searchClient(this.value.trim());
                }
            });

            // Search client function
            async function searchClient(searchTerm) {
                if (!searchTerm) {
                    hideClientInfo();
                    hideSearchLoader();
                    return;
                }

                showSearchLoader();

                try {
                    const response = await fetch(`/api/search-client?search=${encodeURIComponent(searchTerm)}`, {
                        method: 'GET',
                        headers: {
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')?.getAttribute('content') || ''
                        }
                    });

                    const data = await response.json();
                    hideSearchLoader();

                    if (data.success && data.client) {
                        showClientInfo(data.client);
                    } else {
                        // Client not found, show add client modal
                        showAddClientModal(searchTerm);
                    }
                } catch (error) {
                    console.error('Error searching client:', error);
                    hideSearchLoader();
                    showErrorMessage('حدث خطأ أثناء البحث عن العميل');
                    // If API fails, show add client modal
                    showAddClientModal(searchTerm);
                }
            }

            // Show client info
            function showClientInfo(client) {
                currentClient = client;
                clientId.value = currentClient.id;
                clientName.textContent = client.name;
                clientPhone.textContent = client.phone || 'غير محدد';
                clientInfo.classList.remove('hidden');
                clientSearchInput.value = client.name;
            }

            // Hide client info
            function hideClientInfo() {
                clientInfo.classList.add('hidden');
            }

            // Show add client modal
            function showAddClientModal(searchTerm = '') {
                // Pre-fill phone if search term looks like a phone number
                if (searchTerm && /^\d+$/.test(searchTerm)) {
                    newClientPhone.value = searchTerm;
                } else {
                    newClientPhone.value = '';
                }

                newClientName.value = '';
                newClientEmail.value = '';
                addClientModal.classList.remove('hidden');
                newClientName.focus();
            }

            // Hide add client modal
            function hideAddClientModal() {
                addClientModal.classList.add('hidden');
                hideAddClientLoader();
            }

            // Cancel add client
            cancelAddClient.addEventListener('click', hideAddClientModal);

            // Close modal when clicking outside
            addClientModal.addEventListener('click', function(e) {
                if (e.target === this) {
                    hideAddClientModal();
                }
            });

            // Add new client form submission
            addClientForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                const formData = {
                    name: newClientName.value.trim(),
                    phone: newClientPhone.value.trim(),
                    email: newClientEmail.value.trim(),
                    type: 'customer',
                    fromJs: true
                };

                if (!formData.name || !formData.phone || !formData.email) {
                    showErrorMessage('يرجى ملء الاسم ورقم الهاتف والبريد الإلكتروني');
                    return;
                }

                // Show loading state
                showAddClientLoader();

                try {
                    // Create FormData for the existing store method
                    const form = new FormData();
                    form.append('name', formData.name);
                    form.append('phone', formData.phone);
                    form.append('email', formData.email);
                    form.append('type', 'customer');
                    form.append('fromJs', 'true'); // Flag to return JSON response

                    const response = await fetch('{{ route('clients.store') }}', {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: form
                    });

                    console.log(response);
                    const data = await response.json();
                    hideAddClientLoader();

                    if (data.success && data.client) {
                        // Update search input with client name
                        clientSearchInput.value = data.client.name;

                        // Show client info
                        showClientInfo(data.client);

                        // Hide modal
                        hideAddClientModal();

                        // Show success message
                        showSuccessMessage('تم إضافة العميل بنجاح');
                    } else {
                        showErrorMessage(data.message || 'حدث خطأ أثناء إضافة العميل');
                    }
                } catch (error) {
                    console.error('Error adding client:', error);
                    hideAddClientLoader();
                    showErrorMessage('حدث خطأ أثناء إضافة العميل');
                }
            });

            // Show/Hide search loader
            function showSearchLoader() {
                searchLoader.classList.remove('hidden');
                hideClientInfo();
            }

            function hideSearchLoader() {
                searchLoader.classList.add('hidden');
            }

            // Show/Hide add client loader
            function showAddClientLoader() {
                addClientBtn.disabled = true;
                addClientBtnText.classList.add('hidden');
                addClientBtnLoader.classList.remove('hidden');
            }

            function hideAddClientLoader() {
                addClientBtn.disabled = false;
                addClientBtnText.classList.remove('hidden');
                addClientBtnLoader.classList.add('hidden');
            }

            // Show success message
            function showSuccessMessage(message) {
                const successDiv = document.createElement('div');
                successDiv.className = 'fixed top-4 right-4 bg-green-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                successDiv.textContent = message;
                document.body.appendChild(successDiv);

                setTimeout(() => {
                    successDiv.remove();
                }, 3000);
            }

            // Show error message
            function showErrorMessage(message) {
                const errorDiv = document.createElement('div');
                errorDiv.className = 'fixed top-4 right-4 bg-red-500 text-white px-6 py-3 rounded-lg shadow-lg z-50';
                errorDiv.textContent = message;
                document.body.appendChild(errorDiv);

                setTimeout(() => {
                    errorDiv.remove();
                }, 3000);
            }

            // Clear client info when search input is cleared
            clientSearchInput.addEventListener('input', function() {
                if (!this.value.trim()) {
                    hideClientInfo();
                }
            });

            // Clear client button
            clearClientBtn.addEventListener('click', function() {
                hideClientInfo();
                // currentClient = null;
            });






            // #endregion





            // #region orders


            function addBtnsEvent() {
                addBtns.forEach(btn => {
                    btn.addEventListener('click' , () => {
                        const meal = btn.parentElement;

                        const mealName = meal.querySelector('.mealName').textContent;
                        const mealPrice = meal.querySelector('.mealPrice').textContent;
                        const mealSize = meal.querySelector('.sizesHolder input:checked').value;
                        const mealQuantity = meal.querySelector('.mealQuantity').value;
                        const mealType = meal.querySelector('.mealType').value;


                        const selectedTable = document.querySelector('.table-card.active');
                        if (!selectedTable) {
                            alert('يجب إختيار الأول طاولة!');
                            return;
                        }
                        const tableNumber = selectedTable.querySelector('.the_number').textContent;
                        

                        const order = {
                            name: mealName,
                            unit_price: mealPrice,
                            size: mealSize,
                            quantity: mealQuantity,
                            table: tableNumber,
                            type : mealType,
                            total_price: mealPrice * mealQuantity,
                            client_id : currentClient ? currentClient.id : null,
                        }

                        // Add New Key And Value In OBJ
                        if (selectedTable.classList.contains('booked'))  {
                            orders[tableNumber].push(order);
                        } else {
                            orders[tableNumber] = [order];
                        }

                        if (mealType == 'food') {
                            // Print In Food Printer
                        } else if (mealType == 'drink') {
                            // Print In Bar Printer
                        }

                        selectedTable.classList.remove('active');
                        selectedTable.classList.add('booked');
                        
                    })
                })
            }



            function renderSidebar(tableId) {
                let sidebarOrders = orders[tableId];

                sidebar.setAttribute('table-id' , tableId)

                

                itemsHolder.innerHTML = '';
                subTotal.textContent = 0;
                taxNumber.textContent = 0;
                totalNumber.textContent = 0;


                        


                sidebarOrders.map(item  => {
                    const itemElement = document.createElement('div');
                    itemElement.className = 'item';
                    itemElement.innerHTML = `
                        <div class="text">
                            <h2 class="bold">${item.name}</h2>
                            <p>${item.size}</p>
                            <span class="price">${item.unit_price} * ${item.quantity}  =  ${item.total_price} 
                            £ </span>
                        </div>
                        <i class="fa-solid fa-trash"></i>
                    `;
                    itemElement.querySelector('i').addEventListener('click' , (e) => {
                        let itemName = itemElement.querySelector('h2').textContent;
                        orders[tableId] = orders[tableId].filter(item => item.name !== itemName);
                        renderSidebar(tableId);
                    })
                    itemsHolder.appendChild(itemElement);
                    subTotal.textContent = Number(subTotal.textContent) + Number(item.total_price);
                    taxNumber.textContent = (Number(subTotal.textContent) * 0.14).toFixed(2);
                    discountNumber.value = 0;

                       
                    discountNumber.addEventListener('input', () => {
                    totalNumber.textContent = (Number(subTotal.textContent) + Number(taxNumber.textContent) - Number(discountNumber.value)).toFixed(2);
                    })
                       
                } )
                totalNumber.textContent = (Number(subTotal.textContent) + Number(taxNumber.textContent) - Number(discountNumber.value || 0)).toFixed(2);
            }

            
                sidebar.querySelector('.orderSubBtn').addEventListener('click' , () => {
    
                    const orderType = orderTypeHolder.querySelector('button.active').textContent;
                    const paymentType = paymentHolder.querySelector('button.active').textContent;
                    const tableSideId = sidebar.getAttribute('table-id');
            

                    // Send Data To Server
                    if (confirm('Are You Sure?')) {
                        fetch('{{route('orders.store')}}' ,
                        {
                        method: "POST",
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': '{{ csrf_token() }}'
                        },
                        body: JSON.stringify(
                            {
                                "client_id" : currentClient ? currentClient.id : null,
                                "employee_id" : currentEmployee ? currentEmployee.id : null,
                                'table_number' : tableSideId,
                                "order_type" : orderType,
                                "payment_type" : paymentType,
                                "items" : orders[tableSideId],
                                "subtotal" : subTotal.textContent,
                                "tax_amount" : taxNumber.textContent,
                                "discount" : discountNumber.value,
                                "total" : totalNumber.textContent,
                                "fromJs": true,
                            }
                        ),
                        } )
                        .then(res => res.json())
                        .then(data => {
                            console.log(data);
                            // Remove Booked class
                            document.querySelector(`.table-card[data-id="${tableSideId}"]`).classList.remove('booked');
                            document.querySelector(`.table-card[data-id="${tableSideId}"]`).classList.remove('active');
                            sidebar.classList.remove('active');

                            // Make sure orderId is set correctly
                            let orderId = data.order.id;


                            // Send Data To Printer

                            


                            
                        })
                        .catch((error) => {
                            console.error('Error:', error);
                        });
                    }

            })

            // #endregion



        });





        // #endregion
    </script>
</body>
</html>
