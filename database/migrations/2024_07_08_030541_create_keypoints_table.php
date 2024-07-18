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
        Schema::create('keypoints', function (Blueprint $table) {
            $table->uuid('id')->primary();
            $table->uuid('about_id');
            $table->foreign('about_id')->references('id')->on('abouts')->onDelete('cascade');
            $table->string('keypoint');
            $table->softDeletes();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('keypoints');
    }
};
