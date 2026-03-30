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
        Schema::create('categories', function (Blueprint $table) {
            $table->id();
            // أسماء الفئة باللغتين
            $table->string('name_ar'); // اسم الفئة بالعربية
            $table->string('name_en'); // اسم الفئة بالإنجليزية
            // وصف الفئة باللغتين
            $table->text('description_ar')->nullable(); // وصف الفئة بالعربية
            $table->text('description_en')->nullable(); // وصف الفئة بالإنجليزية
            $table->string('image')->nullable(); // صورة الفئة
            $table->boolean('is_active')->default(true); // حالة الفئة
            $table->string('type'); // نوع الفئة
            // Tenant relationship (for manual multi-tenancy)
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');
            $table->timestamps();

        });
        // إضافة أسماء إنجليزية افتراضية للفئات الموجودة
        $categories = \DB::table('categories')->get();
        foreach ($categories as $category) {
            $englishName = $this->translateToEnglish($category->name);
            \DB::table('categories')
                ->where('id', $category->id)
                ->update([
                    'name_en' => $englishName,
                    'description_en' => $category->description ? "Category for {$englishName}" : null
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('categories');
    }

        /**
     * ترجمة بسيطة للأسماء العربية إلى الإنجليزية
     */
    private function translateToEnglish($arabicName)
    {
        $translations = [
            'الأطباق الرئيسية' => 'Main Dishes',
            'المقبلات' => 'Appetizers',
            'الحلويات' => 'Desserts',
            'المشروبات' => 'Beverages',
            'السلطات' => 'Salads',
            'الشوربات' => 'Soups',
            'المعجنات' => 'Pastries',
            'الوجبات السريعة' => 'Fast Food',
            'المشروبات الساخنة' => 'Hot Beverages',
            'المشروبات الباردة' => 'Cold Beverages',
            'العصائر الطبيعية' => 'Fresh Juices',
            'القهوة والشاي' => 'Coffee & Tea',
            'الأطباق الشعبية' => 'Traditional Dishes',
            'الأطباق العالمية' => 'International Dishes',
            'الوجبات الخفيفة' => 'Snacks',
        ];

        return $translations[$arabicName] ?? $arabicName;
    }
};
