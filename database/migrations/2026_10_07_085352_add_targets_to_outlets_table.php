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
    Schema::table('outlets', function (Blueprint $table) {
        $table->decimal('target_sales', 15, 2)->default(0)->after('name');
        $table->integer('target_transactions')->default(0)->after('target_sales');
    });
}

public function down(): void
{
    Schema::table('outlets', function (Blueprint $table) {
        $table->dropColumn(['target_sales', 'target_transactions']);
    });
}
};
