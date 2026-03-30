<?php
return [
    // عناوين عامة
    'orders' => 'المبيعات',
    'order' => 'طلب',
    'orders_list' => 'قائمة الطلبات',
    'add_order' => 'إضافة طلب',
    'create_order' => 'إنشاء طلب',
    'edit_order' => 'تعديل الطلب',
    'order_details' => 'تفاصيل الطلب',
    'create_bill' => 'إنشاء فاتورة',
    'back_to_orders_list' => 'العودة لقائمة الطلبات',
    'view_order' => 'عرض الطلب',
    'view_items' => 'عرض العناصر',
    'update_order' => 'تحديث الطلب',
    'delete_order' => 'حذف الطلب',

    // الحقول
    'table' => [
        'order_number' => 'رقم الطلب',
        'client' => 'العميل',
        'meal' => 'الوجبة',
        'quantity' => 'الكمية',
        'size' => 'الحجم',
        'total_amount' => 'الإجمالي',
        'order_status' => 'حالة الطلب',
        'order_date' => 'تاريخ الطلب',
        'actions' => 'الإجراءات',
        'table_number' => 'رقم الطاولة',
        'order_type' => 'نوع الطلب',
        'notes' => 'ملاحظات',
    ],
    'quantity' => 'الكمية',
    'size' => 'الحجم',
    'total_amount' => 'الإجمالي',
    'order_date' => 'تاريخ الطلب',
    'created_at' => 'تاريخ الإنشاء',
    'status' => 'الحالة',
    'notes' => 'ملاحظات',
    'table_number' => 'رقم الطاولة',
    'order_type' => 'نوع الطلب',
    'client' => 'العميل',
    'meal' => 'الوجبة',
    'price' => 'السعر',
    'total' => 'الإجمالي',
    'items' => 'العناصر',
    'order_items' => 'عناصر الطلب',
    'order_number' => 'رقم الطلب',
    'payment_method' => 'طريقة الدفع',
    'discount_amount' => 'قيمة الخصم',
    'discount_amount' => 'قيمة الخصم',

    // الرسائل
    'no_orders_found' => 'لا توجد طلبات',
    'order_created' => 'تم إنشاء الطلب بنجاح',
    'order_updated' => 'تم تحديث الطلب بنجاح',
    'order_deleted' => 'تم حذف الطلب بنجاح',
    'order_cancelled' => 'تم إلغاء الطلب بنجاح',
    'order_creation_failed' => 'فشل إنشاء الطلب',
    'confirm_delete' => 'هل أنت متأكد من حذف هذا الطلب؟',
    'delete_order_confirm' => 'هل أنت متأكد من حذف هذا الطلب؟',
    'no_items_found' => 'لا توجد عناصر',
    'no_items_selected' => 'لم يتم اختيار أي عناصر',

    // التحقق
    'form' => [
        'select_client' => 'اختر العميل',
        'select_meal' => 'اختر الوجبة',
        'add_new_client' => 'إضافة عميل جديد',
        'add_item' => 'إضافة عنصر',
        'enter_quantity' => 'أدخل الكمية',
    ],

    'placeholders' => [
        'enter_discount_amount' => 'أدخل قيمة الخصم',
        'enter_notes' => 'أدخل الملاحظات',
        'enter_price' => 'أدخل السعر',
        'enter_quantity' => 'أدخل الكمية',
        'enter_table_number' => 'أدخل رقم الطاولة',
    ],

    'select_order_type' => 'اختر نوع الطلب',
    'select_payment_method' => 'اختر طريقة الدفع',
    'select_status' => 'اختر الحالة',

    // الحالات
    'statuses' => [
        'pending' => 'في الانتظار',
        'preparing' => 'قيد التحضير',
        'ready' => 'جاهز',
        'delivered' => 'تم التسليم',
        'cancelled' => 'ملغي',
        'completed' => 'مكتمل',
    ],

    'order_types' => [
        'dine_in' => 'تناول في المطعم',
        'takeaway' => 'استلام',
        'delivery' => 'توصيل',
    ],

    'payment_methods' => [
        'cash' => 'نقدًا',
        'credit_card' => 'بطاقة ائتمان',
        'bank_transfer' => 'تحويل بنكي',
        'wallet' => 'محفظة',
        'other' => 'أخرى',
    ],
];
