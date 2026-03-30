<?php

return [
    // Main headings
    'bookings' => 'الحجوزات',
    'booking' => 'الحجز',
    'booking_list' => 'قائمة الحجوزات',
    'booking_details' => 'تفاصيل الحجز',
    'add_booking' => 'إضافة حجز',
    'edit_booking' => 'تعديل الحجز',
    'view_booking' => 'عرض الحجز',
    'delete_booking' => 'حذف الحجز',
    'new_booking' => 'حجز جديد',

    // Messages
    'booking_created' => 'تم إنشاء الحجز بنجاح!',
    'booking_updated' => 'تم تحديث الحجز بنجاح!',
    'booking_deleted' => 'تم حذف الحجز بنجاح!',
    'booking_save_failed' => 'فشل في حفظ الحجز',
    'booking_delete_failed' => 'فشل في حذف الحجز',
    'booking_not_found' => 'الحجز غير موجود',
    'delete_booking_confirm' => 'هل أنت متأكد من حذف هذا الحجز؟',
    'status_updated' => 'تم تحديث حالة الحجز بنجاح!',
    'status_update_failed' => 'فشل في تحديث حالة الحجز',

    // Form labels
    'customer_name' => 'اسم العميل',
    'phone_number' => 'رقم الهاتف',
    'number_of_guests' => 'عدد الضيوف',
    'date_time' => 'التاريخ والوقت',
    'event_description' => 'وصف المناسبة',
    'status' => 'الحالة',
    'client' => 'العميل',
    'link_to_client' => 'ربط بعميل',
    'select_client_optional' => 'اختر عميل (اختياري)',

    // Status values
    'status_pending' => 'في الانتظار',
    'status_confirmed' => 'مؤكد',
    'status_cancelled' => 'ملغي',
    'status_completed' => 'مكتمل',

    // Table headers
    'table' => [
        'name' => 'الاسم',
        'phone' => 'الهاتف',
        'guests' => 'الضيوف',
        'datetime' => 'التاريخ والوقت',
        'event' => 'المناسبة',
        'client' => 'العميل',
        'status' => 'الحالة',
        'actions' => 'الإجراءات',
        'created_at' => 'تاريخ الإنشاء',
        'updated_at' => 'تاريخ التحديث',
    ],

    // Form placeholders and help text
    'placeholders' => [
        'name' => 'أدخل اسم العميل',
        'phone' => 'أدخل رقم الهاتف',
        'guests' => '1',
        'event' => 'اوصف تفاصيل المناسبة (حفلة عيد ميلاد، اجتماع عمل، إلخ)',
        'search_name' => 'البحث بالاسم...',
        'search_phone' => 'البحث بالهاتف...',
    ],

    // Sections
    'customer_information' => 'معلومات العميل',
    'booking_details' => 'تفاصيل الحجز',
    'record_information' => 'معلومات السجل',
    'quick_status_update' => 'تحديث سريع للحالة',

    // Validation messages
    'validation' => [
        'name_required' => 'اسم العميل مطلوب',
        'phone_required' => 'رقم الهاتف مطلوب',
        'guests_required' => 'عدد الضيوف مطلوب',
        'guests_min' => 'يجب أن يكون هناك ضيف واحد على الأقل',
        'guests_max' => 'الحد الأقصى 100 ضيف',
        'datetime_required' => 'التاريخ والوقت مطلوب',
        'datetime_future' => 'يجب أن يكون تاريخ الحجز في المستقبل',
        'event_required' => 'وصف المناسبة مطلوب',
        'status_invalid' => 'الحالة المختارة غير صالحة',
        'client_exists' => 'العميل المختار غير موجود',
    ],

    // Additional text
    'guest' => 'ضيف',
    'guests_plural' => 'ضيوف',
    'no_bookings_found' => 'لا توجد حجوزات',
    'no_client' => 'لا يوجد عميل',
    'linked_client' => 'العميل المرتبط',
    'upcoming' => 'قادم',
    'past' => 'سابق',
    'yes' => 'نعم',
    'no' => 'لا',
    'created' => 'تم الإنشاء',
    'last_updated' => 'آخر تحديث',
    'update_status' => 'تحديث الحالة',
    'back_to_bookings' => 'العودة إلى الحجوزات',
    'cancel' => 'إلغاء',
    'create_booking' => 'إنشاء حجز',
    'update_booking' => 'تحديث الحجز',
    'save' => 'حفظ',
    'edit' => 'تعديل',
    'delete' => 'حذف',
    'view' => 'عرض',

    // Filter text
    'all_statuses' => 'جميع الحالات',
    'filter_by_name' => 'تصفية بالاسم',
    'filter_by_phone' => 'تصفية بالهاتف',
    'filter_by_status' => 'تصفية بالحالة',
    'filter_by_date' => 'تصفية بالتاريخ',
];