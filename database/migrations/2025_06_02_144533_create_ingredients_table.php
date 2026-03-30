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
        Schema::create('ingredients', function (Blueprint $table) {
            $table->id();
            $table->string('name'); // اسم المكون
            $table->text('description')->nullable(); // وصف المكون
            $table->string('unit'); // وحدة القياس (كيلو، جرام، لتر، إلخ)
            $table->decimal('price_per_unit', 8, 2)->default(0); // سعر الوحدة
            $table->integer('stock_quantity')->default(0); // الكمية المتوفرة
            $table->integer('min_stock_level')->default(0); // الحد الأدنى للمخزون
            $table->string('image')->nullable(); // صورة المكون
            $table->boolean('is_active')->default(true); // حالة المكون
            $table->date('expiry_date')->nullable()->after('min_stock_level');
            
            $table->foreignId('supplier_id')->constrained()->onDelete('cascade'); // Supplier
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
        Schema::dropIfExists('ingredients');
    }
};
