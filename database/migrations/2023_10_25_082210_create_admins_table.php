<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('admins', function (Blueprint $table) {
            $table->string('adminID', 10)->primary(); 
            $table->string('adminName', 40);
            $table->string('password', 20);
            $table->string('adminPhone', 12);
            $table->string('adminEmail', 50);
            $table->string('photo')->nullable();
            $table->dateTime('registrationDate');
            $table->timestamps();
        });
    }
    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('admins');
    }
};
