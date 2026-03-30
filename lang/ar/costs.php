<?php

return [
    // عام
    'costs' => 'التكاليف',
    'cost' => 'تكلفة',
    'cost_management' => 'إدارة التكاليف',
    'cost_list' => 'قائمة التكاليف',
    'cost_details' => 'تفاصيل التكلفة',
    'add_cost' => 'إضافة تكلفة',
    'edit_cost' => 'تعديل التكلفة',
    'create_cost' => 'إنشاء تكلفة',
    'update_cost' => 'تحديث التكلفة',
    'delete_cost' => 'حذف التكلفة',
    'view_cost' => 'عرض التكلفة',
    'cost_information' => 'معلومات التكلفة',
    'cost_history' => 'تاريخ التكاليف',
    'cost_statistics' => 'إحصائيات التكاليف',

    'create_new_cost' => 'إنشاء تكلفة جديدة',
    // الحقول
    'name' => 'اسم التكلفة',
    'description' => 'الوصف',
    'amount' => 'المبلغ',
    'cost_type' => 'نوع التكلفة',
    'category' => 'الفئة',
    'date' => 'التاريخ',
    'due_date' => 'تاريخ الاستحقاق',
    'payment_date' => 'تاريخ الدفع',
    'payment_method' => 'طريقة الدفع',
    'payment_status' => 'حالة الدفع',
    'supplier' => 'المورد',
    'project' => 'المشروع',
    'department' => 'القسم',
    'employee' => 'الموظف',
    'notes' => 'ملاحظات',
    'receipt' => 'الإيصال',
    'invoice_number' => 'رقم الفاتورة',
    'reference' => 'المرجع',
    'tax_amount' => 'مبلغ الضريبة',
    'total_amount' => 'المبلغ الإجمالي',
    'currency' => 'العملة',

    // أنواع التكاليف
    'cost_types' => [
        'operational' => 'تشغيلية',
        'administrative' => 'إدارية',
        'marketing' => 'تسويقية',
        'equipment' => 'معدات',
        'maintenance' => 'صيانة',
        'utilities' => 'مرافق',
        'rent' => 'إيجار',
        'salaries' => 'رواتب',
        'travel' => 'سفر',
        'supplies' => 'مستلزمات',
        'other' => 'أخرى',
    ],

    // طرق الدفع
    'payment_methods' => [
        'cash' => 'نقداً',
        'credit_card' => 'بطاقة ائتمان',
        'debit_card' => 'بطاقة خصم',
        'bank_transfer' => 'تحويل بنكي',
        'check' => 'شيك',
        'online' => 'دفع إلكتروني',
    ],

    // حالة الدفع
    'payment_statuses' => [
        'paid' => 'مدفوع',
        'unpaid' => 'غير مدفوع',
        'partial' => 'مدفوع جزئياً',
        'overdue' => 'متأخر',
        'cancelled' => 'ملغي',
    ],

    // الإجراءات
    'add_new_cost' => 'إضافة تكلفة جديدة',
    'edit_cost_info' => 'تعديل معلومات التكلفة',
    'delete_cost_confirm' => 'هل أنت متأكد من حذف هذه التكلفة؟',
    'view_cost_details' => 'عرض تفاصيل التكلفة',
    'export_costs' => 'تصدير التكاليف',
    'import_costs' => 'استيراد التكاليف',
    'mark_as_paid' => 'تحديد كمدفوع',
    'upload_receipt' => 'رفع الإيصال',
    'download_receipt' => 'تحميل الإيصال',

    // الرسائل
    'cost_created' => 'تم إنشاء التكلفة بنجاح.',
    'cost_updated' => 'تم تحديث التكلفة بنجاح.',
    'cost_deleted' => 'تم حذف التكلفة بنجاح.',
    'cost_not_found' => 'التكلفة غير موجودة.',
    'no_costs_found' => 'لم يتم العثور على تكاليف.',
    'costs_exported' => 'تم تصدير التكاليف بنجاح.',
    'costs_imported' => 'تم استيراد التكاليف بنجاح.',
    'payment_recorded' => 'تم تسجيل الدفع بنجاح.',
    'receipt_uploaded' => 'تم رفع الإيصال بنجاح.',

    // التحقق
    'name_required' => 'اسم التكلفة مطلوب.',
    'amount_required' => 'مبلغ التكلفة مطلوب.',
    'amount_numeric' => 'مبلغ التكلفة يجب أن يكون رقماً.',
    'date_required' => 'تاريخ التكلفة مطلوب.',
    'cost_type_required' => 'نوع التكلفة مطلوب.',
    'payment_method_required' => 'طريقة الدفع مطلوبة.',

    // الإحصائيات
    'total_costs' => 'إجمالي التكاليف',
    'monthly_costs' => 'التكاليف الشهرية',
    'yearly_costs' => 'التكاليف السنوية',
    'average_cost' => 'متوسط التكلفة',
    'costs_this_month' => 'تكاليف هذا الشهر',
    'costs_this_year' => 'تكاليف هذا العام',
    'costs_by_category' => 'التكاليف حسب الفئة',
    'costs_by_department' => 'التكاليف حسب القسم',
    'pending_payments' => 'المدفوعات المعلقة',
    'overdue_payments' => 'المدفوعات المتأخرة',

    // المرشحات
    'filter_by_type' => 'تصفية حسب النوع',
    'filter_by_category' => 'تصفية حسب الفئة',
    'filter_by_date_range' => 'تصفية حسب نطاق التاريخ',
    'filter_by_payment_status' => 'تصفية حسب حالة الدفع',
    'filter_by_department' => 'تصفية حسب القسم',
    'search_costs' => 'البحث في التكاليف',
    'search_by_name' => 'البحث بالاسم أو الوصف',

    // رؤوس الجدول
    'table' => [
        'id' => 'المعرف',
        'name' => 'الاسم',
        'amount' => 'المبلغ',
        'type' => 'النوع',
        'category' => 'الفئة',
        'date' => 'التاريخ',
        'payment_status' => 'حالة الدفع',
        'employee' => 'الموظف',
        'actions' => 'الإجراءات',
        'created_at' => 'تاريخ الإنشاء',
    ],

    // تسميات النموذج
    'form' => [
        'cost_information' => 'معلومات التكلفة',
        'payment_information' => 'معلومات الدفع',
        'additional_information' => 'معلومات إضافية',
        'receipt_attachment' => 'مرفق الإيصال',
        'select_type' => 'اختر النوع',
        'select_category' => 'اختر الفئة',
        'select_department' => 'اختر القسم',
        'select_employee' => 'اختر الموظف',
    ],

    // التقارير
    'reports' => [
        'cost_report' => 'تقرير التكاليف',
        'expense_report' => 'تقرير المصروفات',
        'department_cost_report' => 'تقرير تكاليف الأقسام',
        'monthly_cost_report' => 'تقرير التكاليف الشهرية',
        'cost_analysis' => 'تحليل التكاليف',
    ],

    // النصوص التوضيحية
    'placeholders' => [
        'enter_cost_name' => 'أدخل اسم التكلفة',
        'enter_description' => 'أدخل الوصف',
        'enter_amount' => 'أدخل المبلغ',
        'select_date' => 'اختر التاريخ',
        'enter_notes' => 'أدخل ملاحظات',
        'search_costs' => 'البحث في التكاليف...',
    ],
];
