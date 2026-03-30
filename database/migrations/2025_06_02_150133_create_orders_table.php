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
        Schema::create('orders', function (Blueprint $table) {
            $table->id();
            $table->string('order_number')->unique(); // رقم الطلب
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // المستخدم الذي أنشأ الطلب
            $table->enum('status', ['pending', 'preparing', 'ready', 'delivered', 'cancelled'])
                  ->default('pending'); // حالة الطلب
            $table->enum('order_type', ['dine_in', 'takeaway', 'delivery'])
                  ->default('dine_in'); // نوع الطلب
            $table->decimal('subtotal', 10, 2); // المجموع الفرعي
            $table->decimal('tax_amount', 10, 2)->default(0); // قيمة الضريبة
            $table->decimal('delivery_fee', 10, 2)->default(0); // رسوم التوصيل
            $table->decimal('discount_amount', 10, 2)->default(0); // قيمة الخصم
            $table->decimal('total_amount', 10, 2); // المجموع الكلي

            $table->text('notes')->nullable(); // ملاحظات الطلب
            $table->timestamp('prepared_at')->nullable(); // وقت تحضير الطلب
            $table->timestamp('delivered_at')->nullable(); // وقت تسليم الطلب
            $table->timestamp('completed_at')->nullable();
            $table->foreignId('completed_by')->nullable()->constrained('users');
            $table->foreignId('client_id')->nullable()->constrained()->onDelete('set null');

            $table->string('table_number')->nullable(); // رقم الطاولة
            $table->enum('payment_method' , ['cash', 'credit_card', 'bank_transfer', 'wallet' , 'other'])->nullable()->default('cash'); // طريقة الدفع

            // Tenant relationship (for manual multi-tenancy)
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');

            // إضافة فهرس للأداءx
            $table->index(['client_id']);
            $table->index(['table_number']);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('orders');
    }
};
