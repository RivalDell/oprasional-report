<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('report_sales_finances', function (Blueprint $table) {
            $table->id();
            $table->foreignId('report_id')->constrained('reports')->cascadeOnDelete();
            $table->decimal('target_sales', 15, 2)->default(0);
            $table->decimal('actual_sales', 15, 2)->default(0);
            $table->decimal('cash_sales', 15, 2)->default(0);
            $table->decimal('qris_ewallet', 15, 2)->default(0);
            $table->decimal('debit_credit_card', 15, 2)->default(0);
            $table->decimal('online_delivery', 15, 2)->default(0);
            $table->integer('transaction_count')->default(0);
            $table->decimal('cash_in_drawer', 15, 2)->default(0);
            $table->decimal('cash_variance', 15, 2)->default(0);
            $table->string('cash_variance_status')->default('Match');
            $table->text('variance_explanation')->nullable();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('report_sales_finances');
    }
};