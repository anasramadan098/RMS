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
        Schema::create('meals', function (Blueprint $table) {
            $table->id();
            // أسماء الوجبة باللغتين
            $table->string('name_ar'); // اسم الوجبة بالعربية
            $table->string('name_en'); // اسم الوجبة بالإنجليزية
            // وصف الوجبة باللغتين
            $table->text('description_ar')->nullable(); // وصف الوجبة بالعربية
            $table->text('description_en')->nullable(); // وصف الوجبة بالإنجليزية
            $table->decimal('price', 8, 2); // سعر الوجبة
            $table->integer('preparation_time')->default(0)->nullable(); // وقت التحضير بالدقائق
            $table->string('image')->nullable(); // صورة الوجبة
            $table->boolean('is_available')->default(true); // متوفرة أم لا
            $table->boolean('is_active')->default(true); // حالة الوجبة
            $table->foreignId('category_id')->constrained()->onDelete('cascade'); // ربط بالفئة
            // SKU
            $table->string('sku')->nullable()->unique(); // رقم معرف فريد
            // Tenant relationship (for manual multi-tenancy)
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');
            $table->timestamps();


        });
        
        // إضافة أسماء إنجليزية افتراضية للوجبات الموجودة
        $meals = \DB::table('meals')->get();
        foreach ($meals as $meal) {
            $englishName = $this->translateToEnglish($meal->name);
            \DB::table('meals')
                ->where('id', $meal->id)
                ->update([
                    'name_en' => $englishName,
                    'description_en' => $meal->description ? "Delicious {$englishName}" : null
                ]);
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('meals');
    }

        /**
     * ترجمة بسيطة للأسماء العربية إلى الإنجليزية
     */
    private function translateToEnglish($arabicName)
    {
        $translations = [
            'كباب مشوي' => 'Grilled Kebab',
            'دجاج مشوي' => 'Grilled Chicken',
            'أرز بالخضار' => 'Vegetable Rice',
            'سلطة خضراء' => 'Green Salad',
            'شوربة عدس' => 'Lentil Soup',
            'فتة باللحم' => 'Meat Fatteh',
            'مندي دجاج' => 'Chicken Mandi',
            'برياني لحم' => 'Meat Biryani',
            'سمك مقلي' => 'Fried Fish',
            'كفتة بالطحينة' => 'Kofta with Tahini',
            'ملوخية بالدجاج' => 'Molokhia with Chicken',
            'محشي ورق عنب' => 'Stuffed Grape Leaves',
            'كنافة نابلسية' => 'Nablus Kunafa',
            'بقلاوة' => 'Baklava',
            'عصير برتقال طازج' => 'Fresh Orange Juice',
        ];

        return $translations[$arabicName] ?? $arabicName;
    }
};
