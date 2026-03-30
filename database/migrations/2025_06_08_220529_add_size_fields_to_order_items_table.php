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
        Schema::table('order_items', function (Blueprint $table) {
            $table->foreignId('meal_size_id')->nullable()->constrained()->onDelete('set null'); // حجم الوجبة
            $table->string('size_name')->nullable(); // اسم الحجم وقت الطلب (للحفظ التاريخي)
            $table->decimal('size_price', 10, 2)->nullable(); // سعر الحجم وقت الطلب
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('order_items', function (Blueprint $table) {
            $table->dropForeign(['meal_size_id']);
            $table->dropColumn(['meal_size_id', 'size_name', 'size_price']);
        });
    }
};
