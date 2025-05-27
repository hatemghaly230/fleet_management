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
        Schema::create('trip_stations', function (Blueprint $table) {
           $table->id();
        $table->foreignId('trip_id')->constrained()->onDelete('cascade');
        $table->foreignId('city_id')->constrained('cities')->onDelete('cascade');
        $table->unsignedInteger('station_order'); // ex: 1: Cairo, 2: Fayoum...
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('trip_stations');
    }
};
