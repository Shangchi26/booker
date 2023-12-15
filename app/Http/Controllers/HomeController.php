<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use App\Models\Province;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class HomeController extends Controller
{
    //
    public function index(Request $request)
    {
        $banner = Banner::all();
        $provinces = Province::all();
        $topProvinces = DB::table('provinces')
            ->join('hotels', 'provinces.id', '=', 'hotels.province_id')
            ->join('rooms', 'hotels.id', '=', 'rooms.hotel_id')
            ->join('booking_details', 'rooms.id', '=', 'booking_details.room_id')
            ->join('bookings', 'booking_details.booking_id', '=', 'bookings.id')
            ->select('provinces.name as name', 'provinces.image as image', DB::raw('count(*) as total_bookings'))
            ->groupBy('provinces.id', 'provinces.name', 'provinces.image')
            ->orderByDesc('total_bookings')
            ->limit(6)
            ->get();

        return view("user.contents.home", compact("banner", "provinces", 'topProvinces'));
    }
    public function contact()
    {
        return view("user.contents.contact");
    }
    public function about()
    {
        return view("user.contents.about");
    }
}
