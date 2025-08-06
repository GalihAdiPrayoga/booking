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
       Schema::create('tickets', function (Blueprint $table) {
           $table->id();
           $table->foreignId('flight_id')->constrained('flights');
           $table->foreignId('class_id')->constrained('flights_classes');
           $table->decimal('price', 10, 2);
           $table->integer('seat_number'); 
           $table->timestamps();
       });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('tickets');
    }
};
