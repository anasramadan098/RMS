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
            $table->decimal('default_salary', 10, 2)->nullable();
            $table->decimal('hourly_rate', 8, 2)->nullable();
            $table->integer('working_hours_per_day')->nullable()->default(8);
            $table->boolean('is_active')->default(true);
            $table->text('notes')->nullable();
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
