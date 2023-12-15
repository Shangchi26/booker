<?php

namespace Database\Seeders;

use Faker\Factory as Faker;
use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class BookingDetailSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $faker = Faker::create();
        $bookingIds = DB::table("bookings")->pluck("id")->toArray();
        $roomIds = DB::table('rooms')->pluck('id')->toArray();

        foreach (range(1, max($bookingIds)) as $index) {
            $roomId = $faker->randomElement($roomIds);
            $roomPrice = DB::table('rooms')->where('id', $roomId)->value('price');

            DB::table('booking_details')->insert([
                'booking_id' => $index,
                'room_id' => $roomId,
                'checkin_date' => $checkinDate = $faker->dateTimeBetween('2022-07-01', '2022-10-31')->format('Y-m-d'),
                'checkout_date' => $faker->dateTimeBetween($checkinDate, $checkinDate . ' +5 days')->format('Y-m-d'),
                'price' => $roomPrice,
                'payments' => $faker->randomElement(['Bank', 'Cash']),
                'created_at' => now(),
                'updated_at' => now(),
            ]);
        }

    }
}
