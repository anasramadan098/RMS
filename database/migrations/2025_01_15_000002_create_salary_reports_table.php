<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('salary_reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade'); // الموظف (user)
            $table->integer('year'); // السنة
            $table->integer('month'); // الشهر
            $table->integer('days_in_month'); // عدد أيام الشهر
            $table->integer('attendance_days'); // عدد أيام الحضور
            $table->integer('absence_days'); // عدد أيام الغياب
            $table->decimal('required_hours', 8, 2); // عدد الساعات المطلوبة
            $table->decimal('actual_hours', 8, 2); // عدد الساعات الفعلية
            $table->decimal('extra_hours', 8, 2)->default(0); // الساعات الإضافية
            $table->decimal('missing_hours', 8, 2)->default(0); // الساعات الناقصة
            $table->decimal('base_salary', 10, 2); // الراتب الأساسي
            $table->decimal('overtime_amount', 10, 2)->default(0); // مبلغ الساعات الإضافية
            $table->decimal('deduction_amount', 10, 2)->default(0); // مبلغ الخصم
            $table->decimal('final_salary', 10, 2); // الراتب النهائي
            $table->text('notes')->nullable(); // ملاحظات
            $table->timestamps();

            // فهرس فريد لضمان عدم تكرار التقرير لنفس الموظف في نفس الشهر
            $table->unique(['employee_id', 'year', 'month']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('salary_reports');
    }
};
