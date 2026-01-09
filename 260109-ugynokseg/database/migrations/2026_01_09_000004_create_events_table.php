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
        Schema::create('events', function (Blueprint $table) {
            $table->id();

            $table->foreignId('agency_id')->constrained("agencies")->cascadeOnDelete();
            
            $table->string('name');

            $table->unsignedInteger('limit'); 
            $table->string('type', 50);
            $table->dateTime('date');
            $table->string('location');

            $table->unsignedTinyInteger('status')->default(0); // 0 aktív, 1 törölt, 2 lejárt
            

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('events');
    }
};
