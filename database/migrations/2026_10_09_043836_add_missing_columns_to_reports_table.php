<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            if (!Schema::hasColumn('reports', 'weather')) {
                $table->string('weather')->nullable()->after('shift');
            }
            if (!Schema::hasColumn('reports', 'sales_finance')) {
                $table->json('sales_finance')->nullable();
            }
            if (!Schema::hasColumn('reports', 'top_products')) {
                $table->json('top_products')->nullable();
            }
            if (!Schema::hasColumn('reports', 'is_stock_out')) {
                $table->boolean('is_stock_out')->default(false);
            }
            if (!Schema::hasColumn('reports', 'low_stock_items')) {
                $table->text('low_stock_items')->nullable();
            }
            if (!Schema::hasColumn('reports', 'attendances')) {
                $table->json('attendances')->nullable();
            }
            if (!Schema::hasColumn('reports', 'hygiene')) {
                $table->json('hygiene')->nullable();
            }
            if (!Schema::hasColumn('reports', 'equipment')) {
                $table->json('equipment')->nullable();
            }
            if (!Schema::hasColumn('reports', 'marketing')) {
                $table->json('marketing')->nullable();
            }
            if (!Schema::hasColumn('reports', 'action_plans')) {
                $table->json('action_plans')->nullable();
            }
            if (!Schema::hasColumn('reports', 'performance_rating')) {
                $table->string('performance_rating')->nullable();
            }
            if (!Schema::hasColumn('reports', 'key_achievement')) {
                $table->text('key_achievement')->nullable();
            }
            if (!Schema::hasColumn('reports', 'main_problem')) {
                $table->text('main_problem')->nullable();
            }
            if (!Schema::hasColumn('reports', 'action_for_tomorrow')) {
                $table->text('action_for_tomorrow')->nullable();
            }
            if (!Schema::hasColumn('reports', 'prepared_by')) {
                $table->string('prepared_by')->nullable();
            }
            if (!Schema::hasColumn('reports', 'supervisor_name')) {
                $table->string('supervisor_name')->nullable();
            }
            if (!Schema::hasColumn('reports', 'store_manager_name')) {
                $table->string('store_manager_name')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('reports', function (Blueprint $table) {
            $table->dropColumn([
                'weather', 'sales_finance', 'top_products', 'is_stock_out',
                'low_stock_items', 'attendances', 'hygiene', 'equipment',
                'marketing', 'action_plans', 'performance_rating',
                'key_achievement', 'main_problem', 'action_for_tomorrow',
                'prepared_by', 'supervisor_name', 'store_manager_name'
            ]);
        });
    }
};