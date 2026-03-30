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
        Schema::create('order_item_extras', function (Blueprint $table) {
            $table->id();
            $table->foreignId('order_item_id')->constrained()->onDelete('cascade'); // عنصر الطلب
            $table->foreignId('meal_extra_id')->constrained()->onDelete('cascade'); // الإضافة
            $table->decimal('price', 10, 2); // سعر الإضافة وقت الطلب
            $table->integer('quantity')->default(1); // كمية الإضافة
            $table->timestamps();

            // فهرس فريد لمنع تكرار نفس الإضافة لنفس العنصر
            $table->unique(['order_item_id', 'meal_extra_id']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('order_item_extras');
    }
};
