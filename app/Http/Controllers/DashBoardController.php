<?php

namespace App\Http\Controllers;

use Illuminate\Support\Facades\DB;

class DashBoardController extends Controller
{
    //
    public function index()
    {
        $employee = session()->get("employee");
        $hotel_id = $employee->hotel_id;

        $dayData = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereDate('bookings.updated_at', '=', now()->toDateString())
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $weekData = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereBetween('bookings.updated_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $monthData = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->year)
            ->whereMonth('bookings.updated_at', now()->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $lastMonthData = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(1)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(1)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $twoMonthAgoData = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(2)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(2)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $threeMonthAgoData = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(3)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(3)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $fourMonthAgoData = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(4)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(4)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $fiveMonthAgoData = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(5)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(5)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $dayBookingCount = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereDate('bookings.updated_at', '=', now()->toDateString())
            ->where('bookings.status', '2')
            ->count();

        $weekBookingCount = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereBetween('bookings.updated_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('bookings.status', '2')
            ->count();

        $monthBookingCount = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->year)
            ->whereMonth('bookings.updated_at', now()->month)
            ->where('bookings.status', '2')
            ->count();

        $lastMonthCount = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(1)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(1)->month)
            ->where('bookings.status', '2')
            ->count();

        $twoMonthAgoCount = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(2)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(2)->month)
            ->where('bookings.status', '2')
            ->count();

        $threeMonthAgoCount = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(3)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(3)->month)
            ->where('bookings.status', '2')
            ->count();

        $fourMonthAgoCount = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(4)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(4)->month)
            ->where('bookings.status', '2')
            ->count();

        $fiveMonthAgoCount = DB::table('bookings')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotel_id)
            ->whereYear('bookings.updated_at', now()->subMonths(5)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(5)->month)
            ->where('bookings.status', '2')
            ->count();

        return view('employee.contents.dashboard', compact('dayData', 'weekData', 'monthData',
            'lastMonthData', 'twoMonthAgoData', 'threeMonthAgoData', 'fourMonthAgoData', 'fiveMonthAgoData',
            'dayBookingCount', 'weekBookingCount', 'monthBookingCount', 'lastMonthCount', 'twoMonthAgoCount',
            'threeMonthAgoCount', 'fourMonthAgoCount', 'fiveMonthAgoCount'));
    }
    public function admin()
    {
        $dayData = DB::table('bookings')
            ->whereDate('bookings.updated_at', '=', now()->toDateString())
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $weekData = DB::table('bookings')
            ->whereBetween('bookings.updated_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $monthData = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->year)
            ->whereMonth('bookings.updated_at', now()->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $lastMonthData = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(1)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(1)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $twoMonthAgoData = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(2)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(2)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $threeMonthAgoData = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(3)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(3)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $fourMonthAgoData = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(4)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(4)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $fiveMonthAgoData = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(5)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(5)->month)
            ->where('bookings.status', '2')
            ->sum('bookings.price');

        $dayBookingCount = DB::table('bookings')
            ->whereDate('bookings.updated_at', '=', now()->toDateString())
            ->where('bookings.status', '2')
            ->count();

        $weekBookingCount = DB::table('bookings')
            ->whereBetween('bookings.updated_at', [now()->startOfWeek(), now()->endOfWeek()])
            ->where('bookings.status', '2')
            ->count();

        $monthBookingCount = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->year)
            ->whereMonth('bookings.updated_at', now()->month)
            ->where('bookings.status', '2')
            ->count();

        $lastMonthCount = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(1)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(1)->month)
            ->where('bookings.status', '2')
            ->count();

        $twoMonthAgoCount = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(2)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(2)->month)
            ->where('bookings.status', '2')
            ->count();

        $threeMonthAgoCount = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(3)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(3)->month)
            ->where('bookings.status', '2')
            ->count();

        $fourMonthAgoCount = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(4)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(4)->month)
            ->where('bookings.status', '2')
            ->count();

        $fiveMonthAgoCount = DB::table('bookings')
            ->whereYear('bookings.updated_at', now()->subMonths(5)->year)
            ->whereMonth('bookings.updated_at', now()->subMonths(5)->month)
            ->where('bookings.status', '2')
            ->count();

        return view('admin.contents.dashboard', compact('dayData', 'weekData', 'monthData',
            'lastMonthData', 'twoMonthAgoData', 'threeMonthAgoData', 'fourMonthAgoData', 'fiveMonthAgoData',
            'dayBookingCount', 'weekBookingCount', 'monthBookingCount', 'lastMonthCount', 'twoMonthAgoCount',
            'threeMonthAgoCount', 'fourMonthAgoCount', 'fiveMonthAgoCount'));
    }
}
