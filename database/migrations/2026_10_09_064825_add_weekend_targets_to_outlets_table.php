<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('outlets', function (Blueprint $table) {
            $table->decimal('target_sales_weekend', 15, 2)->nullable()->after('target_sales');
            $table->integer('target_transactions_weekend')->nullable()->after('target_transactions');
        });
    }

    public function down(): void
    {
        Schema::table('outlets', function (Blueprint $table) {
            $table->dropColumn(['target_sales_weekend', 'target_transactions_weekend']);
        });
    }
};