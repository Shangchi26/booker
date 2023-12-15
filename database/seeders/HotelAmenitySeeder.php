<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;
use Faker\Factory as Faker;

class HotelAmenitySeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        $faker = Faker::create();

        $amenityIds = DB::table('amenities')->pluck('id')->toArray();
        $hotelIds = DB::table('rooms')->pluck('id')->toArray();

        foreach ($hotelIds as $hotelId) {
            $amenityCount = $faker->numberBetween(4, 10);

            $selectedAmenities = $faker->randomElements($amenityIds, $amenityCount);

            foreach ($selectedAmenities as $amenityId) {
                DB::table('room_amenities')->insert([
                    'amenity_id' => $amenityId,
                    'room_id' => $hotelId,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

    }
}
