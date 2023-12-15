<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class AmenitySeeder extends Seeder
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
        $room_id = DB::table('rooms')->pluck('id')->toArray();

        $amenitiesList = ['BreakFast', 'Air Conditioning', 'Bath Tub', 'Garage', 'Pool', 'Bar', 'Internet', 'Sofa', 'Toilet Faucet', 'Love Chair Sofa'];

        foreach ($room_id as $roomId) {
            shuffle($amenitiesList); // Xáo trộn danh sách amenities để lựa chọn ngẫu nhiên
            $amenitiesCount = $faker->numberBetween(4, 8); // Số lượng amenities từ 4 đến 8

            $selectedAmenities = array_slice($amenitiesList, 0, $amenitiesCount);

            foreach ($selectedAmenities as $amenityName) {
                DB::table('amenities')->insert([
                    'room_id' => $roomId,
                    'name' => $amenityName,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);
            }
        }

    }
}
