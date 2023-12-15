<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Review;

class OrderController extends Controller
{
    //
    public function index()
    {
        $bookings = Booking::where("user_id", session()->get("user")->id)
            ->orderBy('created_at', 'desc')
            ->get();

        return view("user.contents.order", compact("bookings"));
    }
    public function detail($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }

        $bookingDetails = BookingDetail::where('booking_id', $booking->id)
            ->join('rooms', 'rooms.id', '=', 'booking_details.room_id')
            ->join('hotels', 'hotels.id', '=', 'rooms.hotel_id')
            ->join('bookings', 'bookings.id','=', 'booking_details.booking_id')
            ->select('booking_details.*', 'rooms.name as room', 'hotels.name as hotel', 'bookings.status as status')
            ->get();

        $reviews = [];

        foreach ($bookingDetails as $bookingDetail) {
            $review = Review::where('booking_detail_id', $bookingDetail->id)->first();

            if ($review) {
                $reviews[$bookingDetail->id] = $review;
            }
        }

        return view("user.contents.orderDetail", compact("booking", "bookingDetails", "reviews"));
    }

}
