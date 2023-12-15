<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Province;
use App\Models\Room;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class ProvinceController extends Controller
{
    public function index()
    {
        $provinces = Province::all();
        return view('user.components.find', compact('provinces'));
    }

    public function image(Request $request, $id)
    {
        $province = Province::findOrFail($id);

        $province->image = Cloudinary::upload($request->file('image')->getRealPath())->getSecurePath();
        $province->save();
        return response()->json(['province' => $province]);
    }
    public function provinceDetail(Request $request)
    {
        // Get input from the request
        $provinceId = $request->input('province_id');
        $checkinDateInput = $request->input('checkin_date');
        $checkoutDateInput = $request->input('checkout_date');
        session()->put('checkin_date', $checkinDateInput);
        session()->put('checkout_date', $checkoutDateInput);

        if ($provinceId == null || $checkinDateInput == null || $checkoutDateInput == null) {
            return redirect('/');
        }

        // Find the province
        $province = Province::find($provinceId);

        // Get hotels in the province
        $hotels = Hotel::join('provinces', 'hotels.province_id', '=', 'provinces.id')
            ->select('hotels.*')
            ->where('provinces.id', $province->id)
            ->get();

        foreach ($hotels as $hotel) {
            $roomCount = Room::where('hotel_id', $hotel->id)
                ->where('available', 1)
                ->whereDoesntHave('bookingDetails', function ($query) use ($checkinDateInput, $checkoutDateInput) {
                    $query->where(function ($query) use ($checkinDateInput, $checkoutDateInput) {
                        $query->where('checkin_date', '<', $checkoutDateInput)
                            ->where('checkout_date', '>', $checkinDateInput);
                    });
                })
                ->count();

            $hotel->roomCount = $roomCount;
        }

        $minPrice = Hotel::join('rooms', 'hotels.id', '=', 'rooms.hotel_id')
            ->select('rooms.price as room_price')
            ->first();
        $hotels->min_price = $minPrice->room_price;

        return view('user.contents.province', compact('province', 'hotels'));
    }

    public function create(Request $request)
    {
        $province = new Province;
        $province->name = $request->input('name');
        $province->image = Cloudinary::upload($request->files('image')->getRealPath())->getSecurePath();
        $province->save();

        return redirect()->back()->with('success', 'Successfully created.');

    }
    public function update(Request $request, $id)
    {
        $province = Province::find($id);
        $province->name = $request->input('name');
        $province->image = Cloudinary::upload($request->files('image')->getRealPath())->getSecurePath();
        $province->save();

        return redirect()->back()->with('success', 'Successfully created.');

    }
    public function delete($id)
    {
        $province = Province::find($id);
        $province->delete();

        return redirect()->back()->with('success', 'Successfully deleted.');
    }

}
