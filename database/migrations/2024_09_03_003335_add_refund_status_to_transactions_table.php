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
            $table->enum('refund_status', [
                'belum_diproses',
                'pending',
                'selesai',
            ])->nullable()->after('shipment_address_id');

            $table->string('refund_no_rek')->nullable()->after('refund_status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropColumn('refund_status');
            $table->dropColumn('refund_no_rek');
        });
    }
};
