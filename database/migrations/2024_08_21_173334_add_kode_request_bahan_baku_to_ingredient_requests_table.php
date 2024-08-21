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
        Schema::table('ingredient_requests', function (Blueprint $table) {
            $table->string('kode_request_bahan_baku')->unique()->after('id')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('ingredient_requests', function (Blueprint $table) {
            $table->dropColumn('kode_request_bahan_baku');
        });
    }
};
