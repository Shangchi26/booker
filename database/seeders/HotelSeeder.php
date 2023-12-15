<?php

namespace Database\Seeders;

use Illuminate\Database\Seeder;
use Illuminate\Support\Facades\DB;

class HotelSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        //
        DB::table('hotels')->insert([
            [
                'name' => 'L\'Amor Boutique Hotel Quy Nhon',
                'province_id' => 4,
                'image' => 'hotel.pmg',
                'address' => '1H1 Nguyen Thi Dinh - Nguyen Van Cu - Quy Nhon - Binh Dinh',
                'hotline' => '0987xxxxxx',
            ],
            [
                'name' => 'Grand Hyams Hotel - Quy Nhon Beach',
                'province_id' => 4,
                'image' => 'hotel.pmg',
                'address' => '28 Nguyen Hue - Le Loi - Quy Nhon - Binh Dinh',
                'hotline' => '0987xxxxxx',
            ],
            [
                'name' => 'Fleur De Lys Hotel Quy Nhon',
                'province_id' => 4,
                'image' => 'hotel.pmg',
                'address' => '16 Nguyen Hue - Le Loi - Quy Nhon - Binh Dinh',
                'hotline' => '0987xxxxxx',
            ],
            [
                'name' => 'Avani Quy Nhon Resort',
                'province_id' => 4,
                'image' => 'hotel.pmg',
                'address' => 'Bai Dai - Ghenh Rang - Quy Nhon - Binh Dinh',
                'hotline' => '0987xxxxxx',
            ],
            [
                'name' => 'Maia Resort Quy Nhon',
                'province_id' => 4,
                'image' => 'hotel.pmg',
                'address' => 'Nhon Ly - Cat Tien - Quy Nhon - Binh Dinh',
                'hotline' => '0987xxxxxx',
            ],
            [
                'name' => 'Anya Premier Hotel Quy Nhon',
                'province_id' => 4,
                'image' => 'hotel.pmg',
                'address' => '44 An Duong Vuong - Quy Nhon - Binh Dinh',
                'hotline' => '0987xxxxxx',
            ],
        ]);
    }
}
