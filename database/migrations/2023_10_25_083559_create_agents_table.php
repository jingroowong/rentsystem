<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('agents', function (Blueprint $table) {
            $table->string('agentID', 10)->primary();
            $table->string('agentName', 40);
            $table->string('agentPhone', 12);
            $table->string('agentEmail', 50);
            $table->string('password', 20);
            $table->string('photo')->nullable();
            $table->string('licenseNum', 10)->nullable();
            $table->dateTime('lastLogin')->nullable();
            $table->string('status', 10);
            $table->dateTime('registrationDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};