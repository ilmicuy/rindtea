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
        Schema::create('transaction_logs', function (Blueprint $table) {
            $table->bigIncrements('id'); // ID as bigint

            // Polymorphic relationship fields
            $table->unsignedBigInteger('loggable_id'); // Bigint ID for the related request
            $table->string('loggable_type'); // Class type of the loggable model (ProductRequest, IngredientRequest)

            $table->foreignId('user_id')->constrained()->onDelete('cascade');

            $table->enum('request_type', [
                'request_product',
                'request_ingredient',
            ]);

            $table->integer('quantity');
            $table->timestamp('request_date')->useCurrent();
            $table->text('description')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('transaction_logs');
    }
};
