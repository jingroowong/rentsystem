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
        Schema::create('reviews', function (Blueprint $table) {
            $table->string('reviewID', 10)->primary();
            $table->string('comment', 200);
            $table->integer('rating');
            $table->dateTime('reviewDate');
            $table->string('reviewItemID', 10);
            $table->string('parentReviewID', 10)->nullable();

            $table->foreign('reviewItemID')->references('propertyID')->on('properties');
            // $table->foreign('reviewItemID')->references('agentID')->on('agents');
            // $table->foreign('parentReviewID')->references('reviewID')->on('reviews');
    
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('reviews');
    }
};
