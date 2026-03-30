<!DOCTYPE html>
<html lang="ar" dir="rtl">
<head>
    @extends('layouts.head')
    <meta name="csrf-token" content="{{ csrf_token() }}">
</head>
<body>

    <style>
        body , .container {
            background-color : rgba(50, 78, 236, 0.603) !important;
        }
        .formClient{
            display: none;
            &.show {
                display: block;
            }
        }
        .tablesHolder {
            white-space: nowrap;
            .card {
                .btn {
                    background: yellow;
                    border-color: #fff;
                    color: #000 !important;
                    &.clicked {
                        background-color: red !important;
                    }
                    /* حالات الطاولة */
                    &.success {
                        background-color: #28a745 !important; /* أخضر للنجاح */
                        color: white !important;
                        animation: successPulse 2s ease-in-out;
                    }

                    &.has-order {
                        background-color: #dc3545 !important; /* أحمر للطاولات التي عليها أشخاص */
                        color: white !important;
                        position: relative;
                        box-shadow: 0 0 10px rgba(220, 53, 69, 0.5);
                    }

                    &.has-order::after {
                        content: '●';
                        position: absolute;
                        top: -5px;
                        right: -5px;
                        background: #ffc107;
                        color: #000;
                        border-radius: 50%;
                        width: 15px;
                        height: 15px;
                        font-size: 10px;
                        display: flex;
                        align-items: center;
                        justify-content: center;
                        animation: pulse 1.5s infinite;
                    }

                    &.payment-success {
                        background-color: #28a745 !important; /* أخضر بعد الدفع */
                        color: white !important;
                        animation: paymentSuccess 3s ease-in-out forwards;
                    }

                    &.default-state {
                        background-color: #ffc107 !important; /* أصفر للحالة الافتراضية */
                        color: #000 !important;
                    }
                }
            }
        }

        /* الـ Animations */
        @keyframes pulse {
            0% { transform: scale(1); opacity: 1; }
            50% { transform: scale(1.2); opacity: 0.7; }
            100% { transform: scale(1); opacity: 1; }
        }

        @keyframes paymentSuccess {
            0% {
                background-color: #28a745 !important;
                transform: scale(1);
            }
            25% {
                background-color: #20c997 !important;
                transform: scale(1.05);
            }
            50% {
                background-color: #28a745 !important;
                transform: scale(1);
            }
            75% {
                background-color: #20c997 !important;
                transform: scale(1.05);
            }
            100% {
                background-color: #ffc107 !important;
                color: #000 !important;
                transform: scale(1);
            }
        }

        @keyframes successPulse {
            0% { transform: scale(1); }
            50% { transform: scale(1.1); }
            100% { transform: scale(1); }
        }

        .categoryHolder {
            background: #fff;
            white-space: nowrap;
            padding: 15px 10px ; 
            border-radius: 10px;
            .card {
                cursor : pointer;
                .btn {
                    background: lightgreen;
                    border-color: transparent !important;
                    color: #000 !important;
                }
            }
        }
        .card {
            box-shadow: none !important;
            .btn {
                margin-bottom: 0 !important;
            }
        }


        .pop-up {
            position: absolute;
            display: flex;
            align-items: center;
            justify-content: center;
            z-index: 999;
            display: none;
            top: 30%;
            left: 35%;
            &.show {
                display : block;
            }
            &.pay {
                    max-width: 200%;
                    min-width: 30%;
            }
            .card {
                background : #ddd;
            }
        }
        .myHolder  {
        display: flex;
        justify-content: center;
        align-items: center;
        .card-body {
            background: #eee;
            border: 1px solid #fff;
            border-radius: 10px;
            cursor: pointer;
            margin: 10px;
            padding: 5px !important;
            text-align: center;
            h5 {
                font-size: 1.2rem !important;
            }
        }
        } 
        .alerts {
            position : absolute;
            top : 10%;
            right: 5px;
            .alert {
                position : relative;
                max-width: 300px;
                margin-bottom : 10px;
            }
        }
        
    </style>

    <div class="alerts">

    </div>
    <div class="container pb-5">
        <div class="cashier-head d-flex gap-5 py-5 text-center  justify-content-between">
            <h2 class="text-white">
                الإسم: {{ Auth::user()->name }}
            </h2>
            <h2 class="text-white">
                الوردية: {{ Carbon\Carbon::now()->format('H:i:s') > 12 ? 'مساءًا' : 'صباحًا' }}
            </h2>
        </div>
        <div class="row">
            <div class="col-md-8">

                {{-- Create All Category In Small Box --}}
                <div class="row mb-10 categoryHolder">
                    @foreach ($categories as $category)
                        <div class="col-md-2">
                            <div class="card">
                                <button class="btn btn-outline-primary categoryBtn" data-type="{{$category->type}}" data-id="{{$category->id}}">
                                    {{ $category->name_ar ?? $category->name }}
                                </button>
                            </div>
                        </div>
                    @endforeach
                </div>


                <div class="pop-up meals">
                    <div class="card">
                        {{-- Meals In Small Box--}}
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">قائمة الأصناف</h5>
                            <button class="btn closePopUp" style="color: red">
                                <i class="fas fa-times"></i>
                                إغلاق
                            </button>
                        </div>
                        <div class="card-body meals">
                            <div class="row">

                            </div>
                        </div>
                        {{-- Set Quantatity And Sizes --}}
                        <div class="card-body sizes">
                            <div class="row">

                            </div>
                        </div>

                    </div>

                </div>

                <div class="pop-up pay">
                    <div class="card">
                        {{-- Payment Methods (Cash, Credit, Insta Pay) In Small Box--}}
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">طرق الدفع</h5>
                            <button class="btn closePopUp" style="color: red">
                                <i class="fas fa-times"></i>
                                إغلاق
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-4 myHolder">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">كاش</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 myHolder">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">فيزا</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-4 myHolder">
                                    <div class="card">
                                        <div class="card-body">
                                            <h5 class="card-title">إنستا</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- نافذة خيارات الطاولة -->
                <div class="pop-up table-options">
                    <div class="card">
                        <div class="card-header d-flex justify-content-between align-items-center">
                            <h5 class="mb-0">خيارات الطاولة</h5>
                            <button class="btn closeTableOptions" style="color: red">
                                <i class="fas fa-times"></i>
                                إغلاق
                            </button>
                        </div>
                        <div class="card-body">
                            <div class="row">
                                <div class="col-md-6 myHolder">
                                    <div class="card table-option-card" data-action="add-order">
                                        <div class="card-body">
                                            <i class="fas fa-plus fa-2x mb-2"></i>
                                            <h5 class="card-title">إضافة طلب جديد</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 myHolder">
                                    <div class="card table-option-card" data-action="view-order">
                                        <div class="card-body">
                                            <i class="fas fa-eye fa-2x mb-2"></i>
                                            <h5 class="card-title">عرض الطلب الحالي</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 myHolder">
                                    <div class="card table-option-card" data-action="complete-payment">
                                        <div class="card-body">
                                            <i class="fas fa-credit-card fa-2x mb-2"></i>
                                            <h5 class="card-title">إتمام الدفع</h5>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-md-6 myHolder">
                                    <div class="card table-option-card" data-action="cancel">
                                        <div class="card-body">
                                            <i class="fas fa-times fa-2x mb-2"></i>
                                            <h5 class="card-title">إلغاء</h5>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>




                {{-- Create A 50 Table Number Boxes--}}
                <div class="d-flex gap-3 flex-wrap tablesHolder">
                    @for ($i = 1; $i <= 50; $i++)
                            <div class="col-md-1">
                                <div class="card">
                                    <button class="btn btn-outline-primary tableBtn">
                                        {{$i}}
                                    </button>
                                </div>
                            </div>
                    @endfor
                </div>

            </div>
            <div class="col-md-4">
                <!-- مؤشر تحميل البيانات -->
                <div class="card mb-3" id="loading-indicator" style="display: none;">
                    <div class="card-body text-center">
                        <div class="spinner-border text-primary" role="status">
                            <span class="visually-hidden">Loading...</span>
                        </div>
                        <p class="mt-2 mb-0">جاري تحميل بيانات الوجبات...</p>
                    </div>
                </div>

                <div class="card">
                    <div class="card-header">
                        <h5 class="mb-0">إضافة العميل</h5>
                    </div>
                    <div class="card-body">
                            <div class="mb-3">
                                <label for="client_id" class="form-label">العميل</label>
                                <input type="text" name="client_id" id="client_id" class="form-control" placeholder="معرف العميل">
                                <input type="hidden" name="client" />
                                <input type="hidden" name="payment_type" />
                                <input type="hidden" name="table_id" />
                                
                            </div>
                            <button type="button" class="btn btn-primary" id="add-client-btn">
                                إضافة عميل جديد
                            </button>

                            <!-- أزرار إدارة الطلبات -->
                            <div class="mt-3">
                                <button type="button" class="btn btn-info btn-sm" id="show-current-orders-btn">
                                    عرض الطلبات الحالية
                                </button>
                                <button type="button" class="btn btn-warning btn-sm" id="clear-all-orders-btn">
                                    مسح جميع الطلبات
                                </button>
                                <button type="button" class="btn btn-secondary btn-sm" id="show-instructions-btn">
                                    تعليمات الاستخدام
                                </button>
                                <button type="button" class="btn btn-success btn-sm" id="reload-data-btn">
                                    إعادة تحميل البيانات
                                </button>
                            </div>
                            <form action="{{ route('clients.store') }}" method="POST" class="mt-5 formClient">
                                @csrf
                                <div class="mb-3">
                                    <label for="name" class="form-label">الإسم</label>
                                    <input type="text" name="name" id="client_name" class="form-control" placeholder="الإسم">
                                </div>
                                <div class="mb-3">
                                    <label for="email" class="form-label">الإيميل</label>
                                    <input type="email" name="email" id="client_email" class="form-control" placeholder="الإيميل">
                                </div>
                                <button type="submit" class="btn btn-primary">حفظ</button>
                            </form>
                    </div>
                    
                </div>
            </div>
            




        </div>
    </div>

    <!-- حاوي التنبيهات -->
    <div class="alerts"></div>

    @extends('layouts.scripts')
    <script>
        const addClientBtn = document.getElementById('add-client-btn');
        const formClient = document.querySelector('.formClient');

        addClientBtn.addEventListener('click' , () => {
            formClient.classList.toggle('show');
        })

        document.querySelector('.formClient').addEventListener('submit' , (e) => {
            e.preventDefault();
            fetch( "{{ route('clients.store') }}" , {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    "name" : document.getElementById('client_name').value,
                    "email" : document.getElementById('client_email').value,
                    "type" : "customer",
                    "fromJs" : true
                })
            })
            .then(response => response.json())
            .then(data => {
                mainClientInput.value = data.client.id;
                clientInput.value = data.client.name;
            })
        })

        

        // متغير لحفظ table_id الحالي
        let currentTableId = null;

        // دالة الحصول على نص الحجم
        function getSizeText(size) {
            const sizeMap = {
                'sm': 'صغير',
                'md': 'متوسط',
                'lg': 'كبير',
                'single': 'فردي',
                'double': 'مزدوج'
            };
            return sizeMap[size] || size;
        }

        function completeOrder(table_id) {
            console.log('completeOrder called with table_id:', table_id);

            // التحقق من وجود الطلب للطاولة المحددة
            if (!orders[table_id]) {
                myAlert('لا يوجد طلب لهذه الطاولة!', 'alert-danger');
                return;
            }

            // حفظ table_id الحالي
            currentTableId = table_id;
            console.log('currentTableId set to:', currentTableId);

            // إظهار نافذة الدفع
            document.querySelector('.pop-up.pay').classList.add('show');

            // إزالة event listeners السابقة وإضافة جديدة مع table_id الصحيح
            document.querySelectorAll('.pop-up.pay .card').forEach(card => {
                // إزالة event listener السابق إن وجد
                card.removeEventListener('click', card.paymentHandler);

                // إنشاء event handler جديد
                card.paymentHandler = function() {
                    console.log('Payment card clicked for table_id:', currentTableId);
                    handlePaymentSelection(this, currentTableId);
                };

                // إضافة event listener الجديد
                card.addEventListener('click', card.paymentHandler);
            });
        }

        // متغير لمنع التنفيذ المتكرر
        let isProcessingOrder = false;

        function handlePaymentSelection(selectedCard , table_id) {
            // منع التنفيذ المتكرر
            if (isProcessingOrder) {
                console.log('Order is already being processed...');
                return;
            }

            console.log('handlePaymentSelection called with table_id:', table_id);
            console.log('Current orders object:', orders);
            console.log('Order for table_id:', orders[table_id]);

            const payType = selectedCard.querySelector('h5').textContent.trim();
            console.log('Selected payment type:', payType);

            // التحقق من وجود الطلب للطاولة المحددة
            if (!orders[table_id]) {
                myAlert('لا يوجد طلب لهذه الطاولة!', 'alert-danger');
                return;
            }

            // Add PayType In Obj
            orders[table_id].payment_type = payType;

            console.log('Updated order for table_id:', table_id, orders[table_id]);


            // إخفاء نافذة الدفع
            document.querySelector('.pop-up.pay').classList.remove('show');

            document.querySelector('input[name="payment_type"]').value = payType;

            // جمع البيانات وتحضيرها
            const orderItems = orders[table_id].items.map(item => ({
                meal_id: item.meal_id,
                quantity: item.quantity,
                special_instructions: item.size ? `الحجم: ${getSizeText(item.size)}` : null
            }));

            const clientId = orders[table_id].client_id;
            const tableNumber = orders[table_id].table_id;

            // التحقق من وجود items
            if (!orderItems || orderItems.length === 0) {
                myAlert('يرجى إضافة أصناف للطلب أولاً!', 'alert-warning');
                return;
            }

            // تعيين حالة المعالجة
            isProcessingOrder = true;

            // إرسال الطلب
            createOrder(orderItems, clientId, tableNumber, payType);
        }

        function createOrder(orderItems, clientId, tableNumber, payType) {

            console.log('Creating order with:', orderItems, clientId, tableNumber, payType)
            // Fetch And Create Order
            fetch('{{route('orders.store')}}', {
                method: 'POST',
                headers: {
                    'Content-Type': 'application/json',
                    'X-CSRF-TOKEN': '{{ csrf_token() }}'
                },
                body: JSON.stringify({
                    "client_id": clientId || null,
                    "table_number": tableNumber || null,
                    "items": orderItems,
                    "payment_type": payType,
                    "fromJs": true,
                    "order_type": "dine_in",
                })
            })
            .then(response => {
                if (!response.ok) {
                    throw new Error(`HTTP error! status: ${response.status}`);
                }
                return response.json();
            })
            .then(data => {
                console.log(data);
                if (data.success) {
                    myAlert('تم إنشاء الطلب بنجاح!', 'alert-success');

                    // إظهار نجاح الدفع على الطاولة
                    showPaymentSuccess(currentTableId);

                    // إعادة تعيين النموذج
                    resetOrderForm();
                } else {
                    myAlert('خطأ: ' + (data.message || 'خطأ غير معروف'), 'alert-danger');
                }
            })
            .catch(error => {
                console.error('Error:', error);
                myAlert('Error creating order: ' + error.message);
            })
            .finally(() => {
                // إعادة تعيين حالة المعالجة
                isProcessingOrder = false;
            });
        }

        function resetOrderForm() {
            // إعادة تعيين الحقول
            const tableIdInput = document.querySelector('input[name="table_id"]');
            const clientIdInput = document.querySelector('input[name="client_id"]');

            if (tableIdInput) tableIdInput.value = '';
            if (mainClientInput) mainClientInput.value = '';
            if (clientIdInput) clientIdInput.value = '';
            if (clientInput) clientInput.value = '';

            // إزالة الكلاسات
            document.querySelectorAll('.lets-pay').forEach(el => {
                el.classList.remove('lets-pay');
            });

            document.querySelectorAll('.tableBtn').forEach(btn => {
                btn.classList.remove('clicked', 'success', 'lastClicked', 'wantMeal');
                btn.disabled = false;
            });

            // تحديث المؤشر البصري للطاولة (إزالة اللون الأحمر)
            if (currentTableId) {
                updateTableVisualIndicator(currentTableId);
            }

            // إزالة الطلب من الكائن orders بعد إنشاؤه بنجاح
            if (currentTableId && orders[currentTableId]) {
                delete orders[currentTableId];
                console.log('Order removed from orders object for table:', currentTableId);
            }

            // إعادة تعيين currentTableId
            currentTableId = null;

            // إخفاء نموذج العميل
            if (formClient) {
                formClient.classList.remove('show');
            }
        }

        // إضافة event listeners للأزرار الجديدة
        document.getElementById('show-current-orders-btn').addEventListener('click', function() {
            showAllCurrentOrders();
        });

        document.getElementById('clear-all-orders-btn').addEventListener('click', function() {
            if (confirm('هل أنت متأكد من مسح جميع الطلبات؟')) {
                clearAllOrders();
            }
        });

        document.getElementById('show-instructions-btn').addEventListener('click', function() {
            showInstructions();
        });

        document.getElementById('reload-data-btn').addEventListener('click', function() {
            reloadMealsData();
        });

        // تحميل البيانات عند تحميل الصفحة
        document.addEventListener('DOMContentLoaded', function() {
            console.log('تحميل الصفحة مكتمل، جاري تحميل بيانات الوجبات...');
            loadAllMealsData();
        });

        // دالة عرض جميع الطلبات الحالية
        function showAllCurrentOrders() {
            const orderKeys = Object.keys(orders);

            if (orderKeys.length === 0) {
                myAlert('لا توجد طلبات حالية', 'alert-info');
                return;
            }

            let allOrdersSummary = 'الطلبات الحالية:\n\n';
            let grandTotal = 0;

            orderKeys.forEach(tableId => {
                const order = orders[tableId];
                let tableTotal = 0;

                allOrdersSummary += `الطاولة ${tableId}:\n`;

                order.items.forEach((item, index) => {
                    const itemTotal = item.meal_price * item.quantity;
                    tableTotal += itemTotal;
                    allOrdersSummary += `  ${index + 1}. ${item.meal_name}`;
                    if (item.size) {
                        allOrdersSummary += ` (${getSizeText(item.size)})`;
                    }
                    allOrdersSummary += ` × ${item.quantity} = ${itemTotal.toFixed(2)} جنيه\n`;
                });

                allOrdersSummary += `  إجمالي الطاولة: ${tableTotal.toFixed(2)} جنيه\n\n`;
                grandTotal += tableTotal;
            });

            allOrdersSummary += `الإجمالي العام: ${grandTotal.toFixed(2)} جنيه`;

            alert(allOrdersSummary);
        }

        // دالة مسح جميع الطلبات
        function clearAllOrders() {
            // مسح جميع الطلبات من الذاكرة
            for (let tableId in orders) {
                delete orders[tableId];
            }

            // إعادة تعيين حالة جميع الطاولات
            document.querySelectorAll('.tableBtn').forEach(btn => {
                btn.classList.remove('clicked', 'success', 'lastClicked', 'wantMeal', 'lets-pay');
                btn.disabled = false;
            });

            myAlert('تم مسح جميع الطلبات', 'alert-success');
        }

        // دالة عرض تعليمات الاستخدام
        function showInstructions() {
            const instructions = `
🔴 نظام ألوان الطاولات:
• 🟡 أصفر: طاولة فارغة (الحالة الافتراضية)
• 🔴 أحمر: طاولة عليها أشخاص (لديها طلب)
• 🟢 أخضر: تم الدفع بنجاح (لبضع ثوان ثم تتحول لأصفر)

📋 كيفية إضافة طلب جديد لطاولة فارغة:
1. اضغط على الطاولة الصفراء
2. اختر الفئة من الأعلى
3. اختر الوجبة والكمية والحجم
4. اضغط "إضافة للطلب"
5. كرر العملية لإضافة وجبات أخرى

➕ كيفية التعامل مع طاولة لديها طلب (حمراء):
1. اضغط على الطاولة الحمراء
2. ستظهر نافذة بالخيارات:
   • إضافة طلب جديد
   • عرض الطلب الحالي
   • إتمام الدفع
   • إلغاء
3. اختر الخيار المناسب

💰 كيفية إتمام الدفع:
1. اختر "إتمام الدفع" من نافذة الخيارات
2. اختر طريقة الدفع (كاش/فيزا/إنستا)
3. ستتحول الطاولة للأخضر ثم للأصفر

👁️ عرض الطلب الحالي:
• يمكنك رؤية تفاصيل الطلب
• حذف عناصر من الطلب
• معرفة الإجمالي

🔧 أزرار مساعدة:
• عرض الطلبات الحالية: لرؤية جميع الطلبات
• مسح جميع الطلبات: لحذف كل شيء
• إعادة تحميل البيانات: لتحديث قائمة الوجبات
• تعليمات الاستخدام: هذه الرسالة

⚡ تحسين الأداء:
• يتم تحميل جميع الوجبات مرة واحدة عند فتح الصفحة
• لا حاجة لانتظار السيرفر عند اختيار الفئات
• سرعة فائقة في عرض الوجبات
            `;

            alert(instructions);
        }

    </script>
    <script src="{{asset('js/cashier.js')}}"></script>
</body>
</html>