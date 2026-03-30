<?php

return [
    // عام
    'sales' => 'المبيعات',
    'sale' => 'بيع',
    'sales_management' => 'إدارة المبيعات',
    'sales_list' => 'قائمة المبيعات',
    'sale_details' => 'تفاصيل البيع',
    'add_sale' => 'إضافة بيع',
    'edit_sale' => 'تعديل البيع',
    'create_sale' => 'إنشاء بيع',
    'update_sale' => 'تحديث البيع',
    'delete_sale' => 'حذف البيع',
    'view_sale' => 'عرض البيع',
    'select_payment_method' => 'اختر طريقة الدفع',
    'select_status' => 'اختر الحالة',
    'sale_information' => 'معلومات البيع',
    'sale_history' => 'تاريخ المبيعات',
    'sales_statistics' => 'إحصائيات المبيعات',

    'sales_overview' => 'نظرة عامة على المبيعات',
    'monthly_growth' => 'النمو الشهري',
    'revenue_distribution' => 'توزيع الإيرادات',
    'monthly_sales' => 'المبيعات الشهرية',
    'sales_vs_costs' => 'المبيعات مقابل التكاليف',
    'sales_funnel' => 'مسار المبيعات',

    


    // الحقول
    'invoice_number' => 'رقم الفاتورة',
    'sale_date' => 'تاريخ البيع',
    'client' => 'العميل',
    'client_name' => 'اسم العميل',
    'products' => 'المنتجات',
    'quantity' => 'الكمية',
    'unit_price' => 'سعر الوحدة',
    'total_amount' => 'المبلغ الإجمالي',
    'subtotal' => 'المجموع الفرعي',
    'tax' => 'الضريبة',
    'discount' => 'الخصم',
    'grand_total' => 'المجموع الكلي',
    'payment_method' => 'طريقة الدفع',
    'payment_status' => 'حالة الدفع',
    'payment_date' => 'تاريخ الدفع',
    'due_date' => 'تاريخ الاستحقاق',
    'notes' => 'ملاحظات',
    'salesperson' => 'مندوب المبيعات',
    'commission' => 'العمولة',
    'profit' => 'الربح',
    'cost' => 'التكلفة',
    'margin' => 'الهامش',

    // طرق الدفع
    'payment_methods' => [
        'cash' => 'نقداً',
        'credit_card' => 'بطاقة ائتمان',
        'debit_card' => 'بطاقة خصم',
        'bank_transfer' => 'تحويل بنكي',
        'check' => 'شيك',
        'online' => 'دفع إلكتروني',
        'installment' => 'تقسيط',
    ],

    // حالة الدفع
    'payment_statuses' => [
        'paid' => 'مدفوع',
        'unpaid' => 'غير مدفوع',
        'partial' => 'مدفوع جزئياً',
        'overdue' => 'متأخر',
        'refunded' => 'مسترد',
        'cancelled' => 'ملغي',
    ],

    // حالة البيع
    'sale_statuses' => [
        'pending' => 'في الانتظار',
        'confirmed' => 'مؤكد',
        'processing' => 'قيد المعالجة',
        'shipped' => 'تم الشحن',
        'delivered' => 'تم التسليم',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
        'returned' => 'مرتجع',
    ],

    // الإجراءات
    'add_new_sale' => 'إضافة بيع جديد',
    'edit_sale_info' => 'تعديل معلومات البيع',
    'delete_sale_confirm' => 'هل أنت متأكد من حذف هذا البيع؟',
    'view_sale_details' => 'عرض تفاصيل البيع',
    'print_invoice' => 'طباعة الفاتورة',
    'send_invoice' => 'إرسال الفاتورة',
    'export_sales' => 'تصدير المبيعات',
    'import_sales' => 'استيراد المبيعات',
    'mark_as_paid' => 'تحديد كمدفوع',
    'mark_as_delivered' => 'تحديد كمسلم',
    'process_refund' => 'معالجة الاسترداد',
    'add_product' => 'إضافة منتج',
    'remove_product' => 'إزالة منتج',

    // الرسائل
    'sale_created' => 'تم إنشاء البيع بنجاح.',
    'sale_updated' => 'تم تحديث البيع بنجاح.',
    'sale_deleted' => 'تم حذف البيع بنجاح.',
    'sale_not_found' => 'البيع غير موجود.',
    'no_sales_found' => 'لم يتم العثور على مبيعات.',
    'sales_exported' => 'تم تصدير المبيعات بنجاح.',
    'sales_imported' => 'تم استيراد المبيعات بنجاح.',
    'invoice_sent' => 'تم إرسال الفاتورة بنجاح.',
    'payment_recorded' => 'تم تسجيل الدفع بنجاح.',
    'refund_processed' => 'تم معالجة الاسترداد بنجاح.',

    // التحقق
    'client_required' => 'العميل مطلوب.',
    'products_required' => 'منتج واحد على الأقل مطلوب.',
    'quantity_required' => 'كمية المنتج مطلوبة.',
    'quantity_numeric' => 'كمية المنتج يجب أن تكون رقماً.',
    'price_required' => 'سعر المنتج مطلوب.',
    'price_numeric' => 'سعر المنتج يجب أن يكون رقماً.',
    'payment_method_required' => 'طريقة الدفع مطلوبة.',
    'sale_date_required' => 'تاريخ البيع مطلوب.',

    // الإحصائيات
    'total_sales' => 'إجمالي المبيعات',
    'total_revenue' => 'إجمالي الإيرادات',
    'total_profit' => 'إجمالي الربح',
    'average_sale_value' => 'متوسط قيمة البيع',
    'sales_this_month' => 'مبيعات هذا الشهر',
    'sales_this_year' => 'مبيعات هذا العام',
    'top_selling_products' => 'أفضل المنتجات مبيعاً',
    'top_clients' => 'أفضل العملاء',
    'sales_by_payment_method' => 'المبيعات حسب طريقة الدفع',
    'monthly_sales_trend' => 'اتجاه المبيعات الشهرية',
    'daily_sales' => 'المبيعات اليومية',
    'pending_payments' => 'المدفوعات المعلقة',

    // المرشحات
    'filter_by_client' => 'تصفية حسب العميل',
    'filter_by_date_range' => 'تصفية حسب نطاق التاريخ',
    'filter_by_payment_status' => 'تصفية حسب حالة الدفع',
    'filter_by_sale_status' => 'تصفية حسب حالة البيع',
    'filter_by_payment_method' => 'تصفية حسب طريقة الدفع',
    'filter_by_salesperson' => 'تصفية حسب مندوب المبيعات',
    'search_sales' => 'البحث في المبيعات',
    'search_by_invoice' => 'البحث برقم الفاتورة',

    // رؤوس الجدول
    'table' => [
        'id' => 'المعرف',
        'invoice_number' => 'رقم الفاتورة',
        'client' => 'العميل',
        'sale_date' => 'تاريخ البيع',
        'total_amount' => 'المبلغ الإجمالي',
        'payment_status' => 'حالة الدفع',
        'sale_status' => 'حالة البيع',
        'salesperson' => 'مندوب المبيعات',
        'actions' => 'الإجراءات',
    ],

    // تسميات النموذج
    'form' => [
        'sale_information' => 'معلومات البيع',
        'client_information' => 'معلومات العميل',
        'products_services' => 'المنتجات والخدمات',
        'payment_information' => 'معلومات الدفع',
        'additional_information' => 'معلومات إضافية',
        'select_client' => 'اختر العميل',
        'select_product' => 'اختر المنتج',
        'add_new_client' => 'إضافة عميل جديد',
    ],

    // الفاتورة
    'invoice' => [
        'invoice' => 'فاتورة',
        'invoice_number' => 'رقم الفاتورة',
        'invoice_date' => 'تاريخ الفاتورة',
        'due_date' => 'تاريخ الاستحقاق',
        'bill_to' => 'فاتورة إلى',
        'ship_to' => 'شحن إلى',
        'item' => 'البند',
        'description' => 'الوصف',
        'qty' => 'الكمية',
        'rate' => 'السعر',
        'amount' => 'المبلغ',
        'subtotal' => 'المجموع الفرعي',
        'tax' => 'الضريبة',
        'discount' => 'الخصم',
        'total' => 'المجموع',
        'payment_terms' => 'شروط الدفع',
        'notes' => 'ملاحظات',
        'thank_you' => 'شكراً لك على تعاملك معنا!',
    ],

    // التقارير
    'reports' => [
        'sales_report' => 'تقرير المبيعات',
        'revenue_report' => 'تقرير الإيرادات',
        'profit_report' => 'تقرير الأرباح',
        'client_sales_report' => 'تقرير مبيعات العملاء',
        'product_sales_report' => 'تقرير مبيعات المنتجات',
        'salesperson_report' => 'تقرير مندوبي المبيعات',
        'payment_report' => 'تقرير المدفوعات',
    ],

    // إضافية
    'sale_items' => 'عناصر البيع',
    'total_price' => 'السعر الإجمالي',
    'create_bill' => 'إنشاء فاتورة',
    'back_to_sales_list' => 'العودة لقائمة المبيعات',

    // النصوص التوضيحية
    'placeholders' => [
        'select_client' => 'اختر عميلاً',
        'select_product' => 'اختر منتجاً',
        'enter_quantity' => 'أدخل الكمية',
        'enter_price' => 'أدخل السعر',
        'enter_notes' => 'أدخل ملاحظات',
        'search_sales' => 'البحث في المبيعات...',
    ],
];
