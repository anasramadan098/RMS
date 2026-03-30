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
        Schema::create('order_items', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_id')->constrained()->onDelete('cascade'); // ربط بالطلب
            $table->foreignId('meal_id')->constrained()->onDelete('cascade'); // ربط بالوجبة
            $table->integer('quantity'); // الكمية المطلوبة
            $table->decimal('unit_price', 8, 2); // سعر الوحدة وقت الطلب
            $table->decimal('total_price', 8, 2); // السعر الإجمالي للصنف
            // Sizes That Have Multiple Options
            $table->enum('size', ['sm', 'md', 'lg' , 'single' , 'double'])->nullable(); // حجم الوجبة
            
            $table->text('special_instructions')->nullable(); // تعليمات خاصة للصنف
            // Tenant relationship (for manual multi-tenancy)
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_items');
    }
};
