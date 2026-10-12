<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->id();
            $table->foreignId('outlet_id')->constrained()->onDelete('cascade');
            $table->date('report_date');
            $table->string('shift');
            
            // Kolom JSON
            $table->json('sales_finance')->nullable();
            $table->json('top_products')->nullable();
            $table->boolean('is_stock_out')->default(false);
            $table->text('low_stock_items')->nullable();
            $table->json('attendances')->nullable();
            $table->json('action_plans')->nullable();
            
            // Kolom Teks / Rating
            $table->string('performance_rating');
            $table->string('key_achievement')->nullable();
            $table->string('main_problem')->nullable();
            $table->string('action_for_tomorrow')->nullable();
            
            // Penanggung Jawab
            $table->string('prepared_by');
            $table->string('supervisor_name')->nullable();
            $table->string('store_manager_name')->nullable();
            
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('reports');
    }
};