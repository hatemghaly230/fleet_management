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
        Schema::create('bookings', function (Blueprint $table) {
           $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade'); // user who booked
            $table->foreignId('trip_id')->constrained()->onDelete('cascade'); // trip booked on
            $table->foreignId('seat_id')->constrained()->onDelete('cascade'); // seat booked
            $table->foreignId('from_city_id')->constrained('cities'); // start station
            $table->foreignId('to_city_id')->constrained('cities'); // end station
            $table->timestamps();
            $table->unique(['trip_id', 'seat_id', 'from_city_id', 'to_city_id'], 'unique_booking');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
