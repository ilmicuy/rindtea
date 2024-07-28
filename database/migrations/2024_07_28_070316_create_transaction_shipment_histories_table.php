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
        Schema::create('transaction_shipment_histories', function (Blueprint $table) {
            $table->id();
            $table->foreignId('transaction_shipment_id')->constrained('transaction_shipments')->onDelete('cascade');

            $table->dateTime('history_date')->nullable();
            $table->text('description')->nullable();
            $table->string('location')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_shipment_histories');
    }
};
