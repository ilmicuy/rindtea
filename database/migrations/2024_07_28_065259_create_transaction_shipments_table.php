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
        Schema::create('transaction_shipments', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_id')->nullable();
            $table->foreign('transaction_id')->references('id')->on('transactions')->onDelete('cascade');

            $table->string('awb', 150)->unique();
            $table->string('courier')->nullable();
            $table->string('service')->nullable();
            $table->string('status')->nullable();

            $table->dateTime('date')->nullable();
            $table->text('description')->nullable();

            $table->string('amount')->nullable();
            $table->string('weight')->nullable();

            $table->string('origin')->nullable();
            $table->string('destination')->nullable();
            $table->string('shipper')->nullable();
            $table->string('receiver')->nullable();

            $table->boolean('is_crawlable')->default(true)->nullable();

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_shipments');
    }
};
