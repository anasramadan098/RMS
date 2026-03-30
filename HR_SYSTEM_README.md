# نظام إدارة الموارد البشرية (HR System)

## نظرة عامة

تم إضافة نظام شامل لإدارة الموارد البشرية إلى نظام إدارة المطاعم، والذي يتضمن إدارة الموظفين، تسجيل الحضور والانصراف، وحساب المرتبات الشهرية.

## المميزات الرئيسية

### 1. إدارة الموظفين
- إضافة وتعديل وحذف الموظفين
- تحديد الراتب الافتراضي وقيمة الساعة لكل موظف
- تحديد ساعات العمل اليومية
- تفعيل/إلغاء تفعيل الموظفين
- إضافة ملاحظات للموظفين

### 2. نظام الحضور والانصراف
- تسجيل وقت الدخول والخروج يومياً
- حساب إجمالي ساعات العمل تلقائياً
- منع التسجيل المتكرر في نفس اليوم
- عرض حالة الحضور (في العمل، مكتمل، غير مسجل)

### 3. تقارير المرتبات الشهرية
- حساب تلقائي للمرتبات حسب المعادلة المحددة
- عرض تفصيلي لأيام الحضور والغياب
- حساب الساعات الإضافية والناقصة
- إنشاء تقارير شهرية لجميع الموظفين أو موظف محدد

### 4. معادلة حساب الراتب
```
الراتب النهائي = (الساعات الفعلية × قيمة الساعة) + (الساعات الإضافية × قيمة الساعة × 1.25) - (الساعات الناقصة × قيمة الساعة)
```

## الجداول المضافة

### 1. جدول الموظفين (employees)
- `id`: المعرف الفريد
- `name`: اسم الموظف
- `email`: البريد الإلكتروني (فريد)
- `phone`: رقم الهاتف
- `default_salary`: الراتب الافتراضي الشهري
- `hourly_rate`: قيمة الساعة
- `working_hours_per_day`: ساعات العمل اليومية
- `is_active`: حالة الموظف (نشط/غير نشط)
- `notes`: ملاحظات

### 2. جدول الحضور (attendances)
- `id`: المعرف الفريد
- `employee_id`: معرف الموظف
- `date`: التاريخ
- `check_in`: وقت الدخول
- `check_out`: وقت الخروج
- `total_hours`: إجمالي الساعات
- `notes`: ملاحظات

### 3. جدول تقارير المرتبات (salary_reports)
- `id`: المعرف الفريد
- `employee_id`: معرف الموظف
- `year`: السنة
- `month`: الشهر
- `days_in_month`: عدد أيام الشهر
- `attendance_days`: عدد أيام الحضور
- `absence_days`: عدد أيام الغياب
- `required_hours`: الساعات المطلوبة
- `actual_hours`: الساعات الفعلية
- `extra_hours`: الساعات الإضافية
- `missing_hours`: الساعات الناقصة
- `base_salary`: الراتب الأساسي
- `overtime_amount`: مبلغ الساعات الإضافية
- `deduction_amount`: مبلغ الخصم
- `final_salary`: الراتب النهائي

## الصفحات والمسارات

### صفحات النظام
1. **الصفحة الرئيسية للـ HR**: `/hr-system`
2. **إدارة الموظفين**: `/employees`
3. **تسجيل الحضور**: `/hr/attendance`
4. **تقارير المرتبات**: `/hr/salary-reports`

### المسارات (Routes)
```php
// HR System Routes (Owner only)
Route::get('/hr-system', [HRController::class, 'index'])->name('hr.index');
Route::get('/hr/attendance', [HRController::class, 'attendance'])->name('hr.attendance');
Route::post('/hr/record-attendance', [HRController::class, 'recordAttendance'])->name('hr.record-attendance');
Route::get('/hr/salary-reports', [HRController::class, 'salaryReports'])->name('hr.salary-reports');
Route::post('/hr/generate-salary-report', [HRController::class, 'generateSalaryReport'])->name('hr.generate-salary-report');

// Employee Management Routes
Route::resource('employees', EmployeeController::class);
Route::post('/employees/{employee}/toggle-status', [EmployeeController::class, 'toggleStatus'])->name('employees.toggle-status');

// PDF Export Routes
Route::get('/hr/salary-reports/export-pdf', [HRController::class, 'exportSalaryReportsPDF'])->name('hr.salary-reports.export-pdf');
```

## الصلاحيات

- **Owner فقط**: يمكنه الوصول لجميع مميزات نظام HR
- **Employee**: لا يمكنه الوصول لنظام HR

## الملفات المضافة

### Controllers
- `app/Http/Controllers/HRController.php`
- `app/Http/Controllers/EmployeeController.php`

### Models
- `app/Models/Employee.php`
- `app/Models/Attendance.php`
- `app/Models/SalaryReport.php`

### Views
- `resources/views/hr/index.blade.php`
- `resources/views/hr/attendance.blade.php`
- `resources/views/hr/salary-reports.blade.php`
- `resources/views/hr/salary-reports-pdf.blade.php`
- `resources/views/hr/employees/index.blade.php`
- `resources/views/hr/employees/create.blade.php`
- `resources/views/hr/employees/edit.blade.php`
- `resources/views/hr/employees/show.blade.php`

### Services
- `app/Services/SalaryCalculationService.php`

### Helpers
- `app/Helpers/WorkingDaysHelper.php`

### Form Requests
- `app/Http/Requests/StoreEmployeeRequest.php`
- `app/Http/Requests/UpdateEmployeeRequest.php`

### Migrations
- `database/migrations/2025_06_07_104851_create_employees_table.php`
- `database/migrations/2025_01_15_000001_create_attendances_table.php`
- `database/migrations/2025_01_15_000002_create_salary_reports_table.php`

### Factories
- `database/factories/EmployeeFactory.php`
- `database/factories/AttendanceFactory.php`
- `database/factories/SalaryReportFactory.php`

### Seeders
- `database/seeders/EmployeeSeeder.php`

### Commands
- `app/Console/Commands/GenerateMonthlySalaryReports.php`

### Tests
- `tests/Feature/HRSystemTest.php`

## كيفية الاستخدام

### 1. إضافة موظف جديد
1. اذهب إلى `/employees`
2. اضغط على "إضافة موظف"
3. املأ البيانات المطلوبة
4. احفظ

### 2. تسجيل الحضور
1. اذهب إلى `/hr/attendance`
2. اختر الموظف
3. اختر نوع التسجيل (دخول/خروج)
4. اضغط تسجيل

### 3. إنشاء تقرير مرتبات
1. اذهب إلى `/hr/salary-reports`
2. اختر الشهر والسنة
3. اختر الموظف (اختياري)
4. اضغط "إنشاء تقرير"

### 4. تصدير التقارير
- **PDF**: اضغط على زر "تصدير PDF"
- **Excel**: اضغط على زر "تصدير Excel"
- **طباعة**: اضغط على زر "طباعة التقرير"

## الأوامر المفيدة

### إنشاء تقارير المرتبات تلقائياً
```bash
# إنشاء تقارير للشهر الماضي لجميع الموظفين
php artisan hr:generate-salary-reports

# إنشاء تقرير لشهر محدد
php artisan hr:generate-salary-reports --month=12 --year=2024

# إنشاء تقرير لموظف محدد
php artisan hr:generate-salary-reports --employee=1

# إعادة إنشاء التقارير الموجودة
php artisan hr:generate-salary-reports --force
```

### إنشاء بيانات تجريبية
```bash
php artisan db:seed --class=EmployeeSeeder
```

## ملاحظات مهمة

1. **أيام العمل**: النظام يعتبر جميع الأيام عمل عدا يوم الجمعة
2. **الساعات الإضافية**: تُحسب بمعدل 1.25 من قيمة الساعة العادية
3. **الخصومات**: تُخصم الساعات الناقصة بقيمة الساعة العادية
4. **الصلاحيات**: النظام متاح للـ Owner فقط
5. **التحقق**: يتم منع التسجيل المتكرر في نفس اليوم

## التحديثات المستقبلية المقترحة

1. إضافة نظام الإجازات
2. إضافة تقارير أداء الموظفين
3. إضافة نظام المكافآت والخصومات
4. إضافة إشعارات تلقائية
5. إضافة تصدير تقارير أكثر تفصيلاً
6. إضافة لوحة تحكم للموظفين لعرض بياناتهم
