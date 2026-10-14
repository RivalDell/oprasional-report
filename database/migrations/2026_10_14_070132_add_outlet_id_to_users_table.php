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
        // Sesuaikan tipe data (unsignedBigInteger atau integer) dengan primary key tabel outlets Anda
        $table->unsignedBigInteger('outlet_id')->nullable()->after('email'); 
        
        // Jika ingin langsung menghubungkan dengan Foreign Key (opsional):
        // $table->foreign('outlet_id')->references('id')->on('outlets')->onDelete('set null');
    });
}

public function down(): void
{
    Schema::table('users', function (Blueprint $table) {
        // $table->dropForeign(['outlet_id']);
        $table->dropColumn('outlet_id');
    });
}
};
