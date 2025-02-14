<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTransactionStatusLogsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('transaction_status_logs', function (Blueprint $table) {
            $table->id();
            $table->uuid('transaction_id');  // Foreign key to transaction
            $table->string('column_name');   // The column that was changed
            $table->text('old_value')->nullable();  // The old value of the column
            $table->text('new_value')->nullable();  // The new value of the column
            $table->text('description')->nullable(); // Optional description for the log entry
            $table->timestamps();  // created_at and updated_at
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('transaction_status_logs');
    }
}
