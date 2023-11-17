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
        Schema::create('chat_messages', function (Blueprint $table) {
            $table->string('messageID', 10)->primary();
            $table->string('content', 255);
            $table->dateTime('sTime');
            $table->string('senderID', 10);
            $table->string('recipientID', 10);
            $table->timestamps();

            // // Foreign key constraints
            // $table->foreign('senderID')->references('tenantID')->on('tenants');
            // $table->foreign('senderID')->references('agentID')->on('agents');
            // $table->foreign('recipientID')->references('tenantID')->on('tenants');
            // $table->foreign('recipientID')->references('agentID')->on('agents');
      
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('chat_messages');
    }
};
