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
        Schema::table('transactions', function (Blueprint $table) {
            $table->string('snap_token')->after('total_price')->nullable();
            $table->dateTime('paid_at')->after('snap_token')->nullable();
            $table->text('paid_payload')->after('paid_at')->nullable();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('snap_token');
            $table->dropColumn('paid_at');
            $table->dropColumn('paid_payload');
        });
    }
};
