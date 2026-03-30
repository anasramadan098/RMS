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
        $tables = [
            'projects',
            'costs',
            'bills',
            'supply',
            'categories',
            'ingredients',
            'meals',
            'orders',
            'order_items',
            'clients',
            'tasks',
            'bookings',
            'ads',
            'feedbacks',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table)) {
                Schema::table($table, function (Blueprint $table) {
                    if (!Schema::hasColumn($table, 'tenant_id')) {
                        $table->foreignId('tenant_id')->nullable()->constrained('tenants')->onDelete('cascade');
                    }
                });
            }
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        $tables = [
            'projects',
            'costs',
            'bills',
            'supply',
            'categories',
            'ingredients',
            'meals',
            'orders',
            'order_items',
            'clients',
            'tasks',
            'bookings',
            'ads',
            'feedbacks',
        ];

        foreach ($tables as $table) {
            if (Schema::hasTable($table) && Schema::hasColumn($table, 'tenant_id')) {
                Schema::table($table, function (Blueprint $table) {
                    $table->dropForeign(['tenant_id']);
                    $table->dropColumn('tenant_id');
                });
            }
        }
    }
};
