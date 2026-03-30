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
        Schema::create('meal_extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->onDelete('cascade'); // الوجبة
            $table->string('name_ar'); // اسم الإضافة بالعربية
            $table->string('name_en')->nullable(); // اسم الإضافة بالإنجليزية
            $table->decimal('price', 10, 2); // سعر الإضافة
            $table->boolean('is_active')->default(true); // هل الإضافة متاحة
            $table->integer('sort_order')->default(0); // ترتيب العرض
            $table->text('description')->nullable(); // وصف الإضافة
            $table->string('category')->nullable(); // فئة الإضافة (جبن، خضار، لحوم، إلخ)
            $table->timestamps();
            // Tenant relationship (for manual multi-tenancy)
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');
            // فهرس لتحسين الأداء
            $table->index(['meal_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_extras');
    }
};
