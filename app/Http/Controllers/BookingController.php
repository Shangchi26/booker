<?php

namespace App\Http\Controllers;

use App\Mail\BookingConfirmation;
use App\Models\Amenity;
use App\Models\Booking;
use App\Models\BookingDetail;
use App\Models\Review;
use App\Models\Room;
use App\Models\RoomImage;
use DateTime;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;
use Srmklive\PayPal\Services\PayPal as PayPalClient;

class BookingController extends Controller
{
    //
    public function placeOrder(Request $request)
    {
        if (session()->has("order")) {
            $order = session()->get("order");

            $booking = new Booking();
            $booking->user_id = session('user')->id;

            $booking->price = $order['total_price'];
            $booking->payments = $request->input('payments');
            $booking->save();
            $bookingDetail = new BookingDetail();
            $bookingDetail->booking_id = $booking->id;
            $bookingDetail->room_id = $order['room_id'];
            $bookingDetail->checkin_date = $order['checkin_date'];
            $bookingDetail->checkout_date = $order['checkout_date'];
            $bookingDetail->save();

            $user = session()->get('user');
            $user->point = round($order['total_price'] / 100);
            $user->save();
            session()->forget('order');
            return redirect('/order')->with('success', 'Booking successfully');

        } else {
            $cart = session('cart');
            $totalPrice = session()->get('total_price');

            $booking = new Booking();
            $booking->user_id = session('user')->id;
            $booking->price = $totalPrice;
            $booking->payments = $request->input('payments');
            foreach ($cart as $id => $item) {
                $bookingDetail = new BookingDetail();
                $bookingDetail->booking_id = $booking->id;
                $bookingDetail->room_id = $item['id'];
                $bookingDetail->checkin_date = $item['checkin_date'];
                $bookingDetail->checkout_date = $item['checkout_date'];
                $bookingDetail->save();
            }

            $user = session()->get('user');
            $user->point = round($totalPrice / 100);
            $user->save();

            session()->forget('cart');
            session()->forget('total_price');
            return redirect('/order')->with('success', 'Booking successfully');
        };

    }
    public function delete($id)
    {
        $booking = Booking::find($id);
        if ($booking->status == 0) {
            $bookingDetails = BookingDetail::where('booking_id', $booking->id)
                ->get();
            foreach ($bookingDetails as $bookingDetail) {
                $bookingDetail->delete();
            }
            $booking->delete();
            return redirect()->back()->with('success', 'Delete Successfully');
        }
        return redirect()->back()->with('error', 'Confirmed reservations cannot be cancel');
    }
    public function booking($id)
    {

        $room = Room::find($id);
        $images = RoomImage::where("room_id", $id)->first();

        $room->image = $images->image;

        $checkinDateInput = session('checkin_date');
        $checkoutDateInput = session('checkout_date');
        $checkinDate = DateTime::createFromFormat('Y-m-d', $checkinDateInput);
        $checkoutDate = DateTime::createFromFormat('Y-m-d', $checkoutDateInput);
        $numberOfDays = $checkinDate->diff($checkoutDate)->days;

        $room = $room->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->where('rooms.id', $id)
            ->select('rooms.*', 'hotels.name as hotel_name', 'hotels.description as hotel_description')
            ->first();

        $user = session()->get('user');

        $order = [
            'name' => $room->name,
            'room_id' => $room->id,
            'image' => $images->image,
            'hotel_name' => $room->hotel_name,
            'checkin_date' => $checkinDateInput,
            'checkout_date' => $checkoutDateInput,
            'day' => $numberOfDays,
            'price' => $room->price,
            'total_price' => $room->price * $numberOfDays - $user->point * 10,
        ];

        session()->put('order', $order);

        return view('user.contents.checkout', compact('user'));
    }
    public function manage()
    {
        $employee = session()->get('employee');
        $hotelId = $employee->hotel_id;

        $bookings = Booking::join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->where('hotels.id', $hotelId)
            ->select('bookings.*', DB::raw('MAX(bookings.user_id) as user_id'))
            ->groupBy('bookings.id', 'bookings.user_id', 'bookings.status', 'bookings.price', 'bookings.payments', 'bookings.created_at', 'bookings.updated_at')
            ->get();

        return view('employee.contents.booking', compact('bookings'));
    }

    public function detail($id)
    {
        $booking = Booking::find($id);

        if (!$booking) {
            return response()->json([
                'message' => 'Booking not found',
            ], 404);
        }

        $bookingDetails = BookingDetail::where('booking_id', $booking->id)->get();
        $bookingDetails = BookingDetail::where('booking_id', $booking->id)
            ->join('rooms', 'rooms.id', '=', 'booking_details.room_id')
            ->join('hotels', 'hotels.id', '=', 'rooms.hotel_id')
            ->select('booking_details.*', 'rooms.name as room', 'hotels.name as hotel')
            ->get();

        return view("employee.contents.manageDetail", compact("booking", "bookingDetails"));
    }
    public function update($id)
    {
        $booking = Booking::find($id);

        if ($booking->status == '0') {
            $booking->status = '1';
            Mail::to($booking->user->email)->send(new BookingConfirmation($booking));
            $booking->save();
            return redirect('/employee/all-booking')->with("success", "Booking has been confirmed");
        } elseif ($booking->status == '1') {
            $booking->status = '2';
            $booking->save();
            return redirect('/employee/all-booking')->with("success", "Booking has been checked");
        } else {
            return redirect("/employee/all-booking")->withErrors("Booking has checked");
        }
    }
    public function offline()
    {
        $hotel_id = session("employee")->hotel_id;
        $rooms = Room::where("hotel_id", $hotel_id)->get();
        $today = now()->format('Y-m-d');

        $roomAvailability = [];

        foreach ($rooms as $room) {
            $isAvailable = BookingDetail::where('room_id', $room->id)
                ->whereDate('checkin_date', '<=', $today)
                ->whereDate('checkout_date', '>=', $today)
                ->doesntExist();

            $roomAvailability[$room->id] = $isAvailable;

            $images = RoomImage::where('room_id', $room->id)->get();

            $amenities = Amenity::where('room_id', $room->id)->get();

            $roomDetails[$room->id] = [
                'room' => $room,
                'images' => $images,
                'amenities' => $amenities,
            ];
        }
        return view('employee.contents.offlineBooking', compact('rooms', 'roomAvailability', 'roomDetails'));
    }
    public function offlineBooking($id)
    {
        $room = Room::find($id);
        $today = now()->format('Y-m-d');
        $tomorrow = now()->addDay()->format('Y-m-d');

        $isAvailable = BookingDetail::where('room_id', $room->id)
            ->whereDate('checkin_date', '<=', $today)
            ->whereDate('checkout_date', '>=', $today)
            ->doesntExist();

        if ($isAvailable == 0 || $room->available == 0) {
            return redirect()->back()->withErrors('Room is not available, cant booking.');
        }

        $booking = new Booking();
        $booking->user_id = null;
        $booking->status = 1;
        $booking->price = $room->price;
        $booking->payments = 'Cash';
        $booking->save();

        $bookingDetail = new BookingDetail();
        $bookingDetail->room_id = $room->id;
        $bookingDetail->booking_id = $booking->id;
        $bookingDetail->checkin_date = $today;
        $bookingDetail->checkout_date = $tomorrow;
        $bookingDetail->save();

        return redirect()->back()->with('success', 'Booking completed.');
    }
    public function admin()
    {
        $bookings = Booking::all();
        return view('admin.contents.order', compact('bookings'));
    }
    public function review()
    {
        $employee = session()->get('employee');

        $reviews = Review::join('booking_details', 'reviews.booking_detail_id', '=', 'booking_details.id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->join('bookings', 'booking_details.booking_id', '=', 'bookings.id')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->where('rooms.hotel_id', $employee->hotel_id)
            ->select('reviews.*', 'users.full_name as user_name', 'rooms.name as room_name')
            ->get();

        return view('employee.contents.review', compact('reviews'));
    }
    public function success()
    {
        return view('user.contents.success');
    }
    public function cancel()
    {
        return view('user.contents.success');
    }
    public function getNotifications(Request $request)
    {
        $employee = session()->get('employee');

        $hotelId = $employee->hotel_id;

        $bookings = DB::table('bookings')
            ->select('bookings.*', 'users.full_name', 'rooms.name as hotel_name')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->join('booking_details', 'bookings.id', '=', 'booking_details.booking_id')
            ->join('rooms', 'booking_details.room_id', '=', 'rooms.id')
            ->where('rooms.hotel_id', $hotelId)
            ->get();

        return response()->json($bookings);
    }

}
