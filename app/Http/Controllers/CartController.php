<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Room;
use App\Models\RoomImage;
use DateTime;
use Illuminate\Http\Request;

class CartController extends Controller
{
    //
    public function checkout(Request $request)
    {
        // $room = Room::find($id);
        $user = session()->get('user');
        $cart = session()->get("cart");
        if (session()->has("order")) {
            $order = session()->forget("order");
        }

        return view("user.contents.checkout", compact("cart", "user"));
    }
    public function addCart(Request $request, $id)
    {
        $room = Room::find($id);
        $images = RoomImage::where("room_id", $id)->first();
        $room->image = $images->image;
        $checkinDateInput = session('checkin_date');
        $checkoutDateInput = session('checkout_date');
        $checkinDate = DateTime::createFromFormat('Y-m-d', $checkinDateInput);
        $checkoutDate = DateTime::createFromFormat('Y-m-d', $checkoutDateInput);
        $numberOfDays = $checkinDate->diff($checkoutDate)->days;
        $cart = session('cart', []);
        $totalPrice = 0;

        $cartModified = false;
        foreach ($cart as $key => $item) {
            if ($item['hotel'] != $room->hotel_id) {
                unset($cart[$key]);
                $cartModified = true;
            }
        }

        if (!isset($cart[$id])) {
            $cart[$id] = [
                "id" => $room->id,
                "hotel" => $room->hotel_id,
                "name" => $room->name,
                "image" => $room->image,
                "price" => $room->price * $numberOfDays,
                "checkin_date" => $checkinDateInput,
                "checkout_date" => $checkoutDateInput,
            ];
            $hotel = Hotel::find($room->hotel_id);
            $cart[$id]["hotel_name"] = $hotel->name;
            $cartModified = true;
        }

        foreach ($cart as $item) {
            $totalPrice += $item['price'];
        }

        if ($cartModified) {
            session()->put('cart', $cart);
        }

        session()->put('total_price', $totalPrice);

        return redirect()->back();
    }

    public function deleteRoom($id)
    {
        $cart = session()->get('cart', []);

        if (isset($cart[$id])) {
            unset($cart[$id]);

            session()->put('cart', $cart);

            return redirect()->back()->with('success', 'Room deleted from cart successfully.');
        }

        return redirect()->back()->with('error', 'Room not found in cart.');
    }
    public function clearCart()
    {
        session()->forget('cart');
        return redirect()->back()->with('success', 'Giỏ hàng đã được xóa thành công.');
    }
    public function show()
    {
        $cart = session()->get('cart');
        $totalPrice = 0;

        return view('user.components.cart', compact('cart'));
    }
}
