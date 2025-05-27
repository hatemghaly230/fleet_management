<?php

namespace Database\Seeders;

use Carbon\Carbon;
use App\Models\Bus;
use App\Models\City;
use App\Models\Seat;
use App\Models\Trip;
use App\Models\User;
use App\Models\TripStation;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\Hash;

class TripSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // City names in order
        $cityNames = ['Cairo', 'AlFayyum', 'AlMinya', 'Asyut'];

        // Check if the cities exist
        $cities = City::whereIn('name', $cityNames)->get()->keyBy('name');

        if ($cities->count() !== count($cityNames)) {
            $missing = array_diff($cityNames, $cities->keys()->toArray());
            $this->command->error('Missing cities in DB: ' . implode(', ', $missing));
            return;
        }

        // Create the trip with today's date
        $trip = Trip::create([
            'from_city_id' => $cities['Cairo']->id,
            'to_city_id' => $cities['Asyut']->id,
            'date' => Carbon::today(),
        ]);

        // Create trip stations
        foreach ($cityNames as $index => $name) {
            TripStation::create([
                'trip_id' => $trip->id,
                'city_id' => $cities[$name]->id,
                'station_order' => $index + 1,
            ]);
        }

        // Create the bus associated with the trip
        $bus = Bus::create([
            'trip_id' => $trip->id,
            'name' => 'Bus 1',                  // Bus name
            'number_plate' => 'ABC-1234',       // License plate number
            'seats' => 12,
        ]);

        // Create seats for the bus
        for ($i = 1; $i <= 12; $i++) {
            Seat::create([
                'bus_id' => $bus->id,
                'seat_number' => 'A' . $i,
            ]);
        }

        // Create users
        $users = [
            [
                'name' => 'Ali Hamed',
                'email' => 'ali.hamed@golyv.co',
                'password' => Hash::make('12345678'), // Change password in production
                'type' => 'admin',
            ],
            [
                'name' => 'Mohamed Saeed',
                'email' => 'mohamed.saeed@golyv.co',
                'password' => Hash::make('12345678'),
                'type' => 'admin',
            ],
            [
                'name' => 'User One',
                'email' => 'user1@example.com',
                'password' => Hash::make('12345678'),
                'type' => 'user',
            ],
            [
                'name' => 'User Two',
                'email' => 'user2@example.com',
                'password' => Hash::make('12345678'),
                'type' => 'user',
            ],
            [
                'name' => 'User Three',
                'email' => 'user3@example.com',
                'password' => Hash::make('12345678'),
                'type' => 'user',
            ],
        ];

        foreach ($users as $userData) {
            User::updateOrCreate(
                ['email' => $userData['email']], // Prevent duplicates
                $userData
            );
        }

        $this->command->info('Users seeded successfully.');
        $this->command->info('Trip, stations, bus and seats seeded successfully.');
    }
}
