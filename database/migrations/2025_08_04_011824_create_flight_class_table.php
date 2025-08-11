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
    Schema::create('flight_class', function (Blueprint $table) {
            $table->id();
            $table->foreignId('flight_id')->constrained('flights')->onDelete('cascade');
            $table->foreignId('flight_class_id')->constrained('flights_classes')->onDelete('cascade');
            $table->decimal('price', 10, 2);
            $table->integer('available_seats')->default(0);
            $table->timestamps();

            $table->unique(['flight_id', 'flight_class_id']);
     
     });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('flight_class');
    }
};
