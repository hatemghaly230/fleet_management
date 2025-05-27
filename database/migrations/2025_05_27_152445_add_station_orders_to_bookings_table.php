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
        Schema::table('bookings', function (Blueprint $table) {
           $table->unsignedTinyInteger('from_station_order')->after('from_city_id');
        $table->unsignedTinyInteger('to_station_order')->after('to_city_id');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('bookings', function (Blueprint $table) {
 $table->dropColumn(['from_station_order', 'to_station_order']);
        });
    }
};
