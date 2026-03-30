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
        Schema::create('meal_sizes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('meal_id')->constrained()->onDelete('cascade'); // الوجبة
            $table->string('name_ar'); // اسم الحجم بالعربية (صغير، متوسط، كبير)
            $table->string('name_en')->nullable(); // اسم الحجم بالإنجليزية
            $table->decimal('price', 10, 2); // سعر هذا الحجم
            $table->boolean('is_active')->default(true); // هل الحجم متاح
            $table->integer('sort_order')->default(0); // ترتيب العرض
            $table->text('description')->nullable(); // وصف الحجم
            $table->timestamps();

            // فهرس لتحسين الأداء
            $table->index(['meal_id', 'is_active']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meal_sizes');
    }
};
