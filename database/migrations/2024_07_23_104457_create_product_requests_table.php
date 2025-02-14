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
        Schema::create('product_requests', function (Blueprint $table) {
            $table->id();
            $table->uuid('product_id')->constrained();
            $table->bigInteger('qty_requested')->nullable();
            $table->text('notes')->nullable();
            $table->enum('status',[
                'pending',
                'success',
                'cancelled',
            ])->default('pending');
            $table->dateTime('success_at')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('product_requests');
    }
};
