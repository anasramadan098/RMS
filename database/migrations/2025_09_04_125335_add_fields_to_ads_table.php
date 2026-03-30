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
        Schema::table('ads', function (Blueprint $table) {
            $table->string('name_ar')->nullable();
            $table->string('description_ar')->nullable();
            $table->string('name_en')->nullable();
            $table->string('description_en')->nullable();
            $table->string('path_en')->nullable();
            $table->time('start_time')->default('00:00:00');
            $table->time('end_time')->default('00:00:00');
            $table->boolean('active')->default('true');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ads', function (Blueprint $table) {
            $table->dropColumn(['name_ar', 'description_ar', 'name_en', 'description_en', 'path_en', 'start_time', 'end_time', 'active']);
        });
    }
};
