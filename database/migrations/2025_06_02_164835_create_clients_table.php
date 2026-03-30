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
        Schema::create('clients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم العميل
            $table->string('email')->unique()->nullable(); // البريد الإلكتروني
            $table->string('phone')->nullable(); // رقم الهاتف
            $table->string('whatsapp_phone')->nullable(); // رقم الواتساب
            $table->boolean('whatsapp_notifications')->nullable(); // تفعيل الإشعارات على الواتساب
            $table->text('address')->nullable(); // العنوان
            $table->string('city')->nullable(); // المدينة
            $table->string('state')->nullable(); // المحافظة/الولاية
            $table->string('country')->nullable(); // البلد
            $table->enum('type', ['customer', 'lead', 'prospect', 'other'])->default('customer'); // نوع العميل
            $table->string('profile_picture')->nullable(); // صورة العميل
            $table->text('notes')->nullable(); // ملاحظات
            $table->timestamp('last_activity')->nullable(); // آخر نشاط
            $table->boolean('is_active')->default(true); // حالة العميل
            $table->date('date_of_birth')->nullable(); // تاريخ الميلاد
            $table->enum('gender', ['male', 'female', 'other'])->nullable(); // الجنس
            $table->string('preferred_language', 2)->default('en'); // اللغة المفضلة
            // Tenant relationship (for manual multi-tenancy)
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');
            $table->timestamps();

            // Indexes for better performance
            $table->index(['email']);
            $table->index(['phone']);
            $table->index(['whatsapp_phone']);
            $table->index(['whatsapp_notifications']);
            $table->index(['is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('clients');
    }
};
