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
        Schema::create('suppliers', function (Blueprint $table) {
            $table->id();
            $table->string('supplier_name'); // اسم المورد
            $table->string('contact_number')->nullable(); // الشخص المسؤول
            $table->string('email')->nullable(); // البريد الإلكتروني
            $table->text('notes')->nullable(); // ملاحظات
            $table->boolean('is_active')->default(true); // حالة المورد
            $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');

            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('suppliers');
    }
};
