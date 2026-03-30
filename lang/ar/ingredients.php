<?php

return [
    // عناوين عامة
    'ingredients' => 'المكونات',
    'ingredient' => 'مكون',
    'ingredient_details' => 'تفاصيل المكون',
    'stock' => 'المخزون',
    'unit' => 'الوحدة',
    'available_stock' => 'المخزون المتاح',
    'out_of_stock' => 'نفد المخزون',
    'low_stock' => 'مخزون منخفض',
    

    // حقول النموذج
    'name' => 'الاسم',
    'description' => 'الوصف',
    'quantity' => 'الكمية',
    'stock_quantity' => 'كمية المخزون',
    'cost' => 'التكلفة',
    'price_per_unit' => 'السعر لكل وحدة',
    'expiry_date' => 'تاريخ الانتهاء',
    'supplier' => 'المورد',
    'supplier_id' => 'المورد',
    'created_at' => 'تاريخ الإنشاء',
    'updated_at' => 'تاريخ التحديث',

    // الإجراءات
    'add_ingredient' => 'إضافة مكون',
    'edit_ingredient' => 'تعديل المكون',
    'create_ingredient' => 'إنشاء مكون',
    'create' => 'إنشاء',
    'update_ingredient' => 'تحديث المكون',
    'delete_ingredient' => 'حذف المكون',
    'view_ingredient' => 'عرض المكون',
    'manage_ingredients' => 'إدارة المكونات',
    'ingredient_list' => 'قائمة المكونات',
    'ingredient_management' => 'إدارة المكونات',

    // رسائل الحالة
    'ingredient_created' => 'تم إنشاء المكون بنجاح',
    'ingredient_updated' => 'تم تحديث المكون بنجاح',
    'ingredient_deleted' => 'تم حذف المكون بنجاح',
    'ingredient_not_found' => 'المكون غير موجود',

    // رسائل التحقق
    'name_required' => 'اسم المكون مطلوب',
    'quantity_required' => 'الكمية مطلوبة',
    'unit_required' => 'الوحدة مطلوبة',
    'cost_required' => 'التكلفة مطلوبة',
    'supplier_required' => 'المورد مطلوب',

    // وحدات القياس
    'units' => [
        'kg' => 'كيلو',
        'g' => 'جرام',
        'l' => 'لتر',
        'ml' => 'مليلتر',
        'piece' => 'قطعة',
        'cup' => 'كوب',
        'spoon' => 'ملعقة',
    ],

    // حالة المخزون
    'in_stock' => 'متوفر',
    'running_low' => 'ينفد',
    'expired' => 'منتهي الصلاحية',
    'near_expiry' => 'قريب من الانتهاء',
    'good_condition' => 'حالة جيدة',

    // مفاتيح إضافية
    'ingredient_name' => 'اسم المكون',
    'create_new_ingredient' => 'إنشاء مكون جديد',
    'min_stock_level' => 'الحد الأدنى للمخزون',
    'select_supplier' => 'اختر المورد',
    'no_ingredients_found' => 'لا توجد مكونات',
    'confirm_delete' => 'هل أنت متأكد من حذف هذا المكون؟',
    'placeholders' => [
        'enter_ingredient_name' => 'أدخل اسم المكون',
        'enter_description' => 'أدخل وصف المكون',
        'enter_quantity' => 'أدخل الكمية',
        'enter_unit' => 'أدخل وحدة القياس',
        'enter_cost' => 'أدخل التكلفة',
        'enter_min_stock_level' => 'أدخل الحد الأدنى للمخزون',
    ],

    // رؤوس جدول المكونات
    'table' => [
        'id' => 'الرقم',
        'name' => 'الاسم',
        'quantity' => 'الكمية',
        'unit' => 'الوحدة',
        'cost' => 'التكلفة',
        'created_at' => 'تاريخ الإنشاء',
        'actions' => 'الإجراءات',
    ],
];
