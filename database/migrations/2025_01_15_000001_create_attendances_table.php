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
        Schema::create('attendances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('employee_id')->constrained('users')->onDelete('cascade'); // الموظف (user)
            $table->date('date'); // التاريخ
            $table->time('check_in')->nullable(); // وقت الدخول
            $table->time('check_out')->nullable(); // وقت الخروج
            $table->decimal('total_hours', 5, 2)->nullable(); // عدد الساعات
            $table->text('notes')->nullable(); // ملاحظات
            $table->timestamps();

            // Tenant
            $table->foreignId('tenant_id')->constrained()->onDelete('cascade');

            // فهرس فريد لضمان عدم تكرار التسجيل لنفس الموظف في نفس اليوم
            $table->unique(['employee_id', 'date']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('attendances');
    }
};
