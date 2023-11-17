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
        Schema::create('tenants', function (Blueprint $table) {
            $table->string('tenantID', 10)->primary();
            $table->string('tenantName', 40);
            $table->string('tenantEmail', 50);
            $table->string('tenantPhone', 12);
            $table->string('password', 20);
            $table->string('photo')->nullable();
            $table->string('tenantDOB', 10);
            $table->char('tenantGender', 1);
            $table->dateTime('lastLogin')->nullable();
            $table->dateTime('registrationDate');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tenants');
    }
};
