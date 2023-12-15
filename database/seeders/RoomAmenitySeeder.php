<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomAmenitySeeder extends Seeder
{
    public function run()
    {
        $faker = Faker::create();

        $roomIds = DB::table('rooms')->pluck('id')->toArray();

        foreach ($roomIds as $roomId) {
            $amenities = $faker->randomElements(['BreakFast', 'Air Conditioning', 'Bath Tub', 'Garage', 'Pool', 'Bar', 'Internet', 'Sofa', 'Toilet Faucet', 'Love Chair Sofa'], $faker->numberBetween(4, 8));

            foreach ($amenities as $amenity) {
                DB::table('amenities')->insert([
                    'room_id' => $roomId,
                    'name' => $amenity,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }
    }
}
