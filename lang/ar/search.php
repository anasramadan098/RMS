<?php

return [
    // مصطلحات البحث العامة
    'search' => 'بحث',
    'search_results' => 'نتائج البحث',
    'search_result' => 'نتائج البحث',
    'global_search' => 'البحث العام',
    'new_search' => 'بحث جديد',
    'start_searching' => 'ابدأ البحث للعثور على ما تحتاجه',
    'search_across' => 'البحث عبر المنتجات والعملاء والمبيعات والتكاليف والموردين والمشاريع',
    'search_placeholder' => 'بحث...',
    'search_for' => 'البحث عن',
    'search_all_records' => 'ابحث في جميع السجلات عن ":query"',
    'find_products' => 'ابحث عن المنتجات المطابقة لـ ":query"',
    'find_clients' => 'ابحث عن العملاء المطابقين لـ ":query"',
    'find_suppliers' => 'ابحث عن الموردين المطابقين لـ ":query"',
    'showing_results_for' => 'عرض النتائج لـ',
    'result_for' => 'النتائج لـ',
    'in' => 'في',
    'found' => 'موجود',
    'results' => 'نتائج',
    'no_results_found' => 'لم يتم العثور على نتائج',
    'no_results_for' => 'لم يتم العثور على نتائج لـ',
    'try_different_keywords' => 'جرب كلمات مفتاحية مختلفة أو تحقق من الإملاء',
    'enter_search_term' => 'أدخل مصطلح البحث للعثور على',
    'view_all' => 'عرض الكل',
    'actions' => 'الإجراءات',
    'view_all_products' => 'عرض كل المنتجات',
    'view_all_clients' => 'عرض كل العملاء',
    'view_all_sales' => 'عرض كل المبيعات',

    // فئات البحث
    'categories' => [
        'products' => 'المنتجات',
        'meals' => 'الوجبات',
        'ingredients' => 'المكونات',
        'clients' => 'العملاء',
        'sales' => 'المبيعات',
        'orders' => 'الطلبات',
        'costs' => 'التكاليف',
        'suppliers' => 'الموردين',
        'projects' => 'المشاريع',
    ],

    // رؤوس الجداول
    'headers' => [
        // المنتجات
        'product' => 'المنتج',
        'category' => 'الفئة',
        'price' => 'السعر',
        'stock' => 'المخزون',
        'supplier' => 'المورد',
        
        // العملاء
        'client' => 'العميل',
        'email' => 'البريد الإلكتروني',
        'phone' => 'الهاتف',
        'location' => 'الموقع',
        
        // المبيعات
        'sale' => 'البيع',
        'total' => 'المجموع',
        'status' => 'الحالة',

        // الوجبات/الطلبات
        'meal' => 'الوجبة',
        'order' => 'الطلب',
        
        // التكاليف
        'cost' => 'التكلفة',
        'amount' => 'المبلغ',
        'date' => 'التاريخ',
        
        // المشاريع
        'project' => 'المشروع',
        
        // عام
        'contact' => 'الاتصال',
        'products_count' => 'المنتجات',
        'meals_count' => 'الوجبات',
    ],

    // الرسائل
    'messages' => [
        'no_products_found' => 'لم يتم العثور على منتجات',
        'no_clients_found' => 'لم يتم العثور على عملاء',
        'no_sales_found' => 'لم يتم العثور على مبيعات',
        'no_costs_found' => 'لم يتم العثور على تكاليف',
        'no_suppliers_found' => 'لم يتم العثور على موردين',
        'no_projects_found' => 'لم يتم العثور على مشاريع',
        'no_meals_found' => 'لم يتم العثور على وجبات',
        'no_orders_found' => 'لم يتم العثور على طلبات',
        'no_match_search' => 'لا توجد :type تطابق بحثك عن ":query"',
        'enter_search_to_find' => 'أدخل مصطلح البحث للعثور على :type',
    ],

    // الأزرار
    'buttons' => [
        'view' => 'عرض',
        'edit' => 'تعديل',
        'view_all_products' => 'عرض جميع المنتجات',
        'view_all_clients' => 'عرض جميع العملاء',
        'view_all_sales' => 'عرض جميع المبيعات',
        'view_all_costs' => 'عرض جميع التكاليف',
        'view_all_suppliers' => 'عرض جميع الموردين',
        'view_all_projects' => 'عرض جميع المشاريع',
        'view_all_meals' => 'عرض جميع الوجبات',
        'view_all_orders' => 'عرض جميع الطلبات',
    ],

    // النصوص التوضيحية
    'placeholders' => [
        'search_products' => 'البحث في المنتجات...',
        'search_clients' => 'البحث في العملاء...',
        'search_sales' => 'البحث في المبيعات...',
        'search_costs' => 'البحث في التكاليف...',
        'search_suppliers' => 'البحث في الموردين...',
        'search_projects' => 'البحث في المشاريع...',
        'search_meals' => 'البحث في الوجبات...',
        'search_orders' => 'البحث في الطلبات...',
    ],
];
