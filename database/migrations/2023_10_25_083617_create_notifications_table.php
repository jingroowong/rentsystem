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
        Schema::create('notifications', function (Blueprint $table) {
            $table->string('notificationID', 10)->primary();
            $table->string('subject', 40);
            $table->string('content', 255);
            $table->dateTime('timestamp');
            $table->string('status', 20);
            $table->string('userID', 7);
            
            // Add foreign key constraint to the 'Agent' or 'Tenant' table
            // $table->foreign('userID')->references('agentID')->on('agents')->onUpdate('cascade')->onDelete('cascade');
            // $table->foreign('userID')->references('tenantID')->on('tenants')->onUpdate('cascade')->onDelete('cascade');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('notifications');
    }
};
