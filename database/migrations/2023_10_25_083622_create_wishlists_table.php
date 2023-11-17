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
        Schema::create('wishlists', function (Blueprint $table) {
            $table->string('propertyID', 10);
            $table->string('tenantID', 10);
            $table->dateTime('dateAdded');
            $table->timestamps();
            // Define primary keys and foreign keys
            $table->primary(['propertyID', 'tenantID']);
            
            $table->foreign('propertyID')->references('propertyID')->on('properties');
            $table->foreign('tenantID')->references('tenantID')->on('tenants');
      
          
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('wishlists');
    }
};
