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
        if (!Schema::hasTable('train_location'))
        {
        Schema::create('train_location', function (Blueprint $table) {
                $table->bigIncrements('train_location_id');   
                $table->string('train_location_name',255)->nullable();     
                $table->timestamps();
            });
        }
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('train_location');
    }
};
