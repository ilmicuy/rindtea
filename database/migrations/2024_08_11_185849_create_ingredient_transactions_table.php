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
        Schema::create('ingredient_transactions', function (Blueprint $table) {
            $table->id();

            $table->uuid('ingredient_id');
            $table->uuid('ingredient_request_id')->nullable();

            $table->foreign('ingredient_id')->references('id')->on('ingredients')->onDelete('cascade');
            $table->foreign('ingredient_request_id')->references('id')->on('ingredient_requests')->onDelete('cascade');

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->enum('transaction_type', [
                'initial',
                'restock',
                'request'
            ]);

            $table->integer('quantity');
            $table->integer('old_quantity')->nullable();
            $table->integer('new_quantity')->nullable();

            $table->timestamp('transaction_date')->useCurrent();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('ingredient_transactions');
    }
};
