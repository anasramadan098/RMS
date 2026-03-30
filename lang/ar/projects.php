<?php

return [
    // عام
    'projects' => 'المشاريع',
    'project' => 'مشروع',
    'project_management' => 'إدارة المشاريع',
    'project_list' => 'قائمة المشاريع',
    'project_details' => 'تفاصيل المشروع',
    'add_project' => 'إضافة مشروع',
    'edit_project' => 'تعديل المشروع',
    'create_project' => 'إنشاء مشروع',
    'update_project' => 'تحديث المشروع',
    'delete_project' => 'حذف المشروع',
    'view_project' => 'عرض المشروع',
    'project_information' => 'معلومات المشروع',
    'project_history' => 'تاريخ المشروع',
    'project_statistics' => 'إحصائيات المشروع',
    'name' => 'الاسم',
    'user' => 'المستخدم',
    'completed' => 'مكتمل',
    'on_hold' => 'معلّق',
  
    // الحقول
    'project_name' => 'اسم المشروع',
    'project_title' => 'عنوان المشروع',
    'description' => 'الوصف',
    'client' => 'العميل',
    'manager' => 'مدير المشروع',
    'team' => 'الفريق',
    'start_date' => 'تاريخ البداية',
    'end_date' => 'تاريخ النهاية',
    'deadline' => 'الموعد النهائي',
    'budget' => 'الميزانية',
    'cost' => 'التكلفة',
    'progress' => 'التقدم',
    'status' => 'الحالة',
    'priority' => 'الأولوية',
    'category' => 'الفئة',
    'tags' => 'العلامات',
    'notes' => 'ملاحظات',
    'attachments' => 'المرفقات',
    'completion_percentage' => 'نسبة الإنجاز',
    'estimated_hours' => 'الساعات المقدرة',
    'actual_hours' => 'الساعات الفعلية',

    // الحالة
    'statuses' => [
        'planning' => 'التخطيط',
        'in_progress' => 'قيد التنفيذ',
        'on_hold' => 'معلق',
        'completed' => 'مكتمل',
        'cancelled' => 'ملغي',
        'delayed' => 'متأخر',
    ],

    // الأولوية
    'priorities' => [
        'low' => 'منخفضة',
        'medium' => 'متوسطة',
        'high' => 'عالية',
        'urgent' => 'عاجل',
        'critical' => 'حرج',
    ],

    // الفئات
    'categories' => [
        'web_development' => 'تطوير الويب',
        'mobile_app' => 'تطبيق الهاتف',
        'design' => 'التصميم',
        'marketing' => 'التسويق',
        'consulting' => 'الاستشارات',
        'research' => 'البحث',
        'other' => 'أخرى',
    ],

    // الإجراءات
    'add_new_project' => 'إضافة مشروع جديد',
    'edit_project_info' => 'تعديل معلومات المشروع',
    'delete_project_confirm' => 'هل أنت متأكد من حذف هذا المشروع؟',
    'view_project_details' => 'عرض تفاصيل المشروع',
    'export_projects' => 'تصدير المشاريع',
    'import_projects' => 'استيراد المشاريع',
    'assign_team' => 'تعيين الفريق',
    'update_progress' => 'تحديث التقدم',
    'mark_completed' => 'تحديد كمكتمل',
    'archive_project' => 'أرشفة المشروع',

    // الرسائل
    'project_created' => 'تم إنشاء المشروع بنجاح.',
    'project_updated' => 'تم تحديث المشروع بنجاح.',
    'project_deleted' => 'تم حذف المشروع بنجاح.',
    'project_not_found' => 'المشروع غير موجود.',
    'no_projects_found' => 'لم يتم العثور على مشاريع.',
    'projects_exported' => 'تم تصدير المشاريع بنجاح.',
    'projects_imported' => 'تم استيراد المشاريع بنجاح.',
    'progress_updated' => 'تم تحديث تقدم المشروع بنجاح.',

    // التحقق
    'project_name_required' => 'اسم المشروع مطلوب.',
    'description_required' => 'وصف المشروع مطلوب.',
    'client_required' => 'العميل مطلوب.',
    'start_date_required' => 'تاريخ البداية مطلوب.',
    'end_date_required' => 'تاريخ النهاية مطلوب.',
    'budget_required' => 'الميزانية مطلوبة.',
    'budget_numeric' => 'الميزانية يجب أن تكون رقماً.',

    // الإحصائيات
    'total_projects' => 'إجمالي المشاريع',
    'active_projects' => 'المشاريع النشطة',
    'completed_projects' => 'المشاريع المكتملة',
    'overdue_projects' => 'المشاريع المتأخرة',
    'projects_this_month' => 'مشاريع هذا الشهر',
    'average_completion_time' => 'متوسط وقت الإنجاز',
    'total_budget' => 'إجمالي الميزانية',
    'spent_budget' => 'الميزانية المنفقة',

    // المرشحات
    'filter_by_status' => 'تصفية حسب الحالة',
    'filter_by_priority' => 'تصفية حسب الأولوية',
    'filter_by_category' => 'تصفية حسب الفئة',
    'filter_by_client' => 'تصفية حسب العميل',
    'filter_by_date_range' => 'تصفية حسب نطاق التاريخ',
    'search_projects' => 'البحث في المشاريع',
    'search_by_name_description' => 'البحث بالاسم أو الوصف',

    // رؤوس الجدول
    'table' => [
        'id' => 'المعرف',
        'project_name' => 'اسم المشروع',
        'client' => 'العميل',
        'manager' => 'المدير',
        'start_date' => 'تاريخ البداية',
        'end_date' => 'تاريخ النهاية',
        'budget' => 'الميزانية',
        'progress' => 'التقدم',
        'status' => 'الحالة',
        'priority' => 'الأولوية',
        'actions' => 'الإجراءات',
        'created_at' => 'تاريخ الإنشاء',
    ],

    // تسميات النموذج
    'form' => [
        'basic_information' => 'المعلومات الأساسية',
        'project_details' => 'تفاصيل المشروع',
        'timeline' => 'الجدول الزمني',
        'budget_information' => 'معلومات الميزانية',
        'team_assignment' => 'تعيين الفريق',
        'additional_information' => 'معلومات إضافية',
        'select_client' => 'اختر العميل',
        'select_manager' => 'اختر المدير',
        'select_status' => 'اختر الحالة',
        'select_priority' => 'اختر الأولوية',
        'select_category' => 'اختر الفئة',
    ],

    // التقارير
    'reports' => [
        'project_report' => 'تقرير المشاريع',
        'progress_report' => 'تقرير التقدم',
        'budget_report' => 'تقرير الميزانية',
        'timeline_report' => 'تقرير الجدول الزمني',
        'team_performance' => 'أداء الفريق',
        'client_projects' => 'مشاريع العملاء',
    ],

    // النصوص التوضيحية
    'placeholders' => [
        'enter_project_name' => 'أدخل اسم المشروع',
        'enter_description' => 'أدخل وصف المشروع',
        'enter_budget' => 'أدخل مبلغ الميزانية',
        'enter_notes' => 'أدخل ملاحظات المشروع',
        'search_projects' => 'البحث في المشاريع...',
    ],

    // التقدم
    'progress_labels' => [
        'not_started' => 'لم يبدأ',
        'in_progress' => 'قيد التنفيذ',
        'almost_done' => 'شبه مكتمل',
        'completed' => 'مكتمل',
    ],

    // الجدول الزمني
    'timeline' => [
        'project_created' => 'تم إنشاء المشروع',
        'project_started' => 'بدء المشروع',
        'milestone_reached' => 'تم الوصول لمعلم',
        'project_completed' => 'اكتمل المشروع',
        'project_delayed' => 'تأخر المشروع',
        'budget_exceeded' => 'تجاوز الميزانية',
    ],
];
