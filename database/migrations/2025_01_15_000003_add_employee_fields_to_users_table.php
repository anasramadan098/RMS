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
        Schema::table('users', function (Blueprint $table) {
            // Employee-specific fields (nullable for non-employee users)
            $table->string('phone')->nullable()->after('email');
            $table->decimal('default_salary', 10, 2)->nullable()->after('phone');
            $table->decimal('hourly_rate', 8, 2)->nullable()->after('default_salary');
            $table->integer('working_hours_per_day')->nullable()->default(8)->after('hourly_rate');
            $table->boolean('is_active')->default(true)->after('working_hours_per_day');
            $table->text('notes')->nullable()->after('is_active');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('users', function (Blueprint $table) {
            $table->dropColumn([
                'phone',
                'default_salary',
                'hourly_rate',
                'working_hours_per_day',
                'is_active',
                'notes'
            ]);
        });
    }
};
