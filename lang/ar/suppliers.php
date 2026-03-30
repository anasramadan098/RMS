<?php

return [
    // عام
    'suppliers' => 'الموردين',
    'supplier' => 'مورد',
    'supplier_management' => 'إدارة الموردين',
    'supplier_list' => 'قائمة الموردين',
    'supplier_details' => 'تفاصيل المورد',
    'add_supplier' => 'إضافة مورد',
    'edit_supplier' => 'تعديل المورد',
    'create_supplier' => 'إنشاء مورد',
    'update_supplier' => 'تحديث المورد',
    'delete_supplier' => 'حذف المورد',
    'view_supplier' => 'عرض المورد',
    'supplier_information' => 'معلومات المورد',
    'supplier_history' => 'تاريخ المورد',
    'supplier_statistics' => 'إحصائيات المورد',

    // الحقول
    'supplier_name' => 'اسم المورد',
    'company_name' => 'اسم الشركة',
    'contact_person' => 'رقم تواصل',
    'email' => 'البريد الإلكتروني',
    'phone' => 'الهاتف',
    'mobile' => 'الهاتف المحمول',
    'fax' => 'الفاكس',
    'website' => 'الموقع الإلكتروني',
    'address' => 'العنوان',
    'city' => 'المدينة',
    'state' => 'المحافظة',
    'country' => 'البلد',
    'postal_code' => 'الرمز البريدي',
    'tax_number' => 'الرقم الضريبي',
    'registration_number' => 'رقم التسجيل',
    'bank_name' => 'اسم البنك',
    'bank_account' => 'رقم الحساب البنكي',
    'payment_terms' => 'شروط الدفع',
    'credit_limit' => 'حد الائتمان',
    'discount_rate' => 'معدل الخصم',
    'category' => 'الفئة',
    'status' => 'الحالة',
    'is_active' => 'نشط',
    'notes' => 'ملاحظات',
    'logo' => 'الشعار',
    'rating' => 'التقييم',
    'established_date' => 'تاريخ التأسيس',

    // الفئات
    'categories' => [
        'raw_materials' => 'المواد الخام',
        'equipment' => 'المعدات',
        'services' => 'الخدمات',
        'technology' => 'التكنولوجيا',
        'logistics' => 'اللوجستيات',
        'maintenance' => 'الصيانة',
        'consulting' => 'الاستشارات',
        'other' => 'أخرى',
    ],

    // الحالة
    'statuses' => [
        'active' => 'نشط',
        'inactive' => 'غير نشط',
        'pending' => 'في الانتظار',
        'suspended' => 'معلق',
        'blacklisted' => 'في القائمة السوداء',
    ],

    // شروط الدفع
    'payment_terms_options' => [
        'net_30' => 'صافي 30 يوم',
        'net_60' => 'صافي 60 يوم',
        'net_90' => 'صافي 90 يوم',
        'cash_on_delivery' => 'الدفع عند التسليم',
        'advance_payment' => 'دفع مقدم',
        'credit' => 'ائتمان',
    ],

    // الإجراءات
    'add_new_supplier' => 'إضافة مورد جديد',
    'edit_supplier_info' => 'تعديل معلومات المورد',
    'delete_supplier_confirm' => 'هل أنت متأكد من حذف هذا المورد؟',
    'view_supplier_details' => 'عرض تفاصيل المورد',
    'export_suppliers' => 'تصدير الموردين',
    'import_suppliers' => 'استيراد الموردين',
    'contact_supplier' => 'الاتصال بالمورد',
    'view_products' => 'عرض المنتجات',
    'view_orders' => 'عرض الطلبات',
    'view_invoices' => 'عرض الفواتير',
    'rate_supplier' => 'تقييم المورد',

    // الرسائل
    'supplier_created' => 'تم إنشاء المورد بنجاح.',
    'supplier_updated' => 'تم تحديث المورد بنجاح.',
    'supplier_deleted' => 'تم حذف المورد بنجاح.',
    'cannot_delete_supplier_has_ingredients' => 'لا يمكن حذف هذا المورد لأنه مرتبط بـ :count مكون/مكونات. يرجى حذف المكونات أولاً.',
    'error_deleting_supplier' => 'حدث خطأ أثناء حذف المورد. يرجى المحاولة مرة أخرى.',
    'supplier_not_found' => 'المورد غير موجود.',
    'no_suppliers_found' => 'لم يتم العثور على موردين.',
    'suppliers_exported' => 'تم تصدير الموردين بنجاح.',
    'suppliers_imported' => 'تم استيراد الموردين بنجاح.',
    'contact_sent' => 'تم إرسال رسالة الاتصال بنجاح.',

    // التحقق
    'supplier_name_required' => 'اسم المورد مطلوب.',
    'company_name_required' => 'اسم الشركة مطلوب.',
    'email_required' => 'عنوان البريد الإلكتروني مطلوب.',
    'email_valid' => 'يرجى إدخال عنوان بريد إلكتروني صحيح.',
    'email_unique' => 'عنوان البريد الإلكتروني هذا مسجل بالفعل.',
    'phone_required' => 'رقم الهاتف مطلوب.',
    'phone_valid' => 'يرجى إدخال رقم هاتف صحيح.',
    'address_required' => 'العنوان مطلوب.',

    // الإحصائيات
    'total_suppliers' => 'إجمالي الموردين',
    'active_suppliers' => 'الموردين النشطين',
    'new_suppliers_this_month' => 'موردين جدد هذا الشهر',
    'top_suppliers' => 'أفضل الموردين',
    'supplier_performance' => 'أداء الموردين',
    'average_rating' => 'متوسط التقييم',
    'total_orders' => 'إجمالي الطلبات',
    'total_amount' => 'إجمالي المبلغ',

    // المرشحات
    'filter_by_status' => 'تصفية حسب الحالة',
    'filter_by_category' => 'تصفية حسب الفئة',
    'filter_by_city' => 'تصفية حسب المدينة',
    'filter_by_country' => 'تصفية حسب البلد',
    'filter_by_rating' => 'تصفية حسب التقييم',
    'search_suppliers' => 'البحث في الموردين',
    'search_by_name_company' => 'البحث بالاسم أو الشركة',

    // رؤوس الجدول
    'table' => [
        'id' => 'المعرف',
        'logo' => 'الشعار',
        'supplier_name' => 'اسم المورد',
        'company_name' => 'اسم الشركة',
        'contact_person' => 'الشخص المسؤول',
        'email' => 'البريد الإلكتروني',
        'phone' => 'الهاتف',
        'city' => 'المدينة',
        'status' => 'الحالة',
        'rating' => 'التقييم',
        'created_at' => 'تاريخ الإنشاء',
        'update_supplier' => 'تحديث المورد',
        'actions' => 'الإجراءات',
    ],

    // تسميات النموذج
    'form' => [
        'basic_information' => 'المعلومات الأساسية',
        'contact_information' => 'معلومات الاتصال',
        'address_information' => 'معلومات العنوان',
        'business_information' => 'المعلومات التجارية',
        'financial_information' => 'المعلومات المالية',
        'additional_information' => 'معلومات إضافية',
        'upload_logo' => 'رفع الشعار',
        'change_logo' => 'تغيير الشعار',
        'remove_logo' => 'إزالة الشعار',
        'select_supplier' => 'اختر المورد',
    ],

    // الأداء
    'performance' => [
        'delivery_time' => 'وقت التسليم',
        'quality_rating' => 'تقييم الجودة',
        'service_rating' => 'تقييم الخدمة',
        'price_competitiveness' => 'تنافسية السعر',
        'reliability' => 'الموثوقية',
        'communication' => 'التواصل',
        'overall_rating' => 'التقييم العام',
    ],

    // التقارير
    'reports' => [
        'supplier_report' => 'تقرير الموردين',
        'performance_report' => 'تقرير الأداء',
        'order_history_report' => 'تقرير تاريخ الطلبات',
        'payment_report' => 'تقرير المدفوعات',
        'supplier_analysis' => 'تحليل الموردين',
    ],

    // النصوص التوضيحية
    'placeholders' => [
        'enter_supplier_name' => 'أدخل اسم المورد',
        'enter_company_name' => 'أدخل اسم الشركة',
        'enter_contact_person' => 'أدخل اسم الشخص المسؤول',
        'enter_email' => 'أدخل عنوان البريد الإلكتروني',
        'enter_phone' => 'أدخل رقم الهاتف',
        'enter_address' => 'أدخل العنوان',
        'enter_city' => 'أدخل المدينة',
        'enter_notes' => 'أدخل ملاحظات حول المورد',
        'search_suppliers' => 'البحث في الموردين...',
    ],
];
