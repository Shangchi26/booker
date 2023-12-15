<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $hotelIds = DB::table('hotels')->pluck('id');

        foreach ($hotelIds as $hotelId) {
            $roomCount = 1;
            $roomCountLimit = random_int(3, 5);
            $hotelName = strtoupper(substr(DB::table('hotels')->where('id', $hotelId)->value('name'), 0, 1));
            for ($i = 0; $i < $roomCountLimit; $i++) {
                DB::table('rooms')->insert([
                    'hotel_id' => $hotelId,
                    'name' => $hotelName . '-' . str_pad($roomCount, 2, '0', STR_PAD_LEFT),
                    'room_type' => $faker->randomElement(['Single Room', 'Double Room']),
                    'price' => $faker->randomFloat(2, 100.00, 500.00),
                    'available' => $faker->boolean,
                    'created_at' => now(),
                    'updated_at' => now(),
                ]);

                $roomCount++;
            }
        }

    }
}
