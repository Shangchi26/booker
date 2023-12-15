<?php

namespace App\Http\Controllers;

use App\Models\Hotel;
use App\Models\Province;
use App\Models\Room;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class HotelController extends Controller
{
    //
    public function index()
    {
        return redirect('/home');
    }

    public function roomInHotel(Request $request, $id)
    {
        $checkinDateInput = session('checkin_date');
        $checkoutDateInput = session('checkout_date');
        $rooms = Room::where('hotel_id', $id)
            ->where('available', 1)
            ->whereDoesntHave('bookingDetails', function ($query) use ($checkinDateInput, $checkoutDateInput) {
                $query->where(function ($query) use ($checkinDateInput, $checkoutDateInput) {
                    $query->where('checkin_date', '<', $checkoutDateInput)
                        ->where('checkout_date', '>', $checkinDateInput);
                });
            })
            ->select('rooms.*', DB::raw('(SELECT image FROM room_images WHERE room_images.room_id = rooms.id LIMIT 1) as image'))
            ->get();

        $hotel = Hotel::find($id);
        return view('user.contents.hotel', compact('rooms', 'hotel'));
    }

    public function admin(Request $request)
    {
        $keyword = $request->input('keyword');
        $provinces = Province::all();
        $hotels = Hotel::join('provinces', 'hotels.province_id', '=', 'provinces.id')
            ->select('hotels.*', 'provinces.id as province_id', 'provinces.name as province_name')
            ->orderBy('hotels.id', 'desc');

        if (!empty($keyword)) {
            $hotels->where(function ($query) use ($keyword) {
                $query->where('hotels.name', 'like', '%' . $keyword . '%')
                    ->orWhere('hotels.address', 'like', '%' . $keyword . '%')
                    ->orWhere('hotels.hotline', 'like', '%' . $keyword . '%');
            });
        }

        $admin = Auth::user();

        $hotels = $hotels->paginate(5);

        return view('admin.hotel', compact('hotels', 'provinces', 'admin'));
    }

    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string',
            'hotline' => 'required|string',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect('/admin')
                ->withErrors($validator)
                ->withInput();
        }

        $hotel = new Hotel;
        $hotel->name = $request->input('name');
        $hotel->province_id = $request->input('province_id');
        $image = $request->file('image');
        $imagePath = Cloudinary::upload($image->getRealPath())->getSecurePath();
        $hotel->image = $imagePath;
        $hotel->address = $request->input('address');
        $hotel->hotline = $request->input('hotline');
        $hotel->description = $request->input('description');
        $hotel->save();

        return redirect('/admin')->with('success', 'Successfully created.');
    }

    public function update(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required|string|max:255',
            'province_id' => 'required|exists:provinces,id',
            'image' => 'required|image|mimes:jpeg,png,jpg,gif|max:2048',
            'address' => 'required|string',
            'hotline' => 'required|string',
            'description' => 'string',
        ]);

        if ($validator->fails()) {
            return redirect('/admin')
                ->withErrors($validator)
                ->withInput();
        }
        $hotel = Hotel::find($id);
        $hotel->name = $request->input('name');
        $hotel->province_id = $request->input('province_id');
        $image = $request->file('image');
        $imagePath = Cloudinary::upload($image->getRealPath())->getSecurePath();
        $hotel->image = $imagePath;
        $hotel->address = $request->input('address');
        $hotel->hotline = $request->input('hotline');
        $hotel->description = $request->input('description');
        $hotel->save();

        return redirect('/admin')->with('success', 'Successfully updated.');
    }
    public function delete($id)
    {
        $hotel = Hotel::find($id);
        $haveRoom = Room::where('hotel_id', $hotel->id)->exists();
        if ($haveRoom) {
            return redirect()->back()->withErrors('Can not delete this hotel');
        }
        $hotel->delete();

        return redirect()->back()->with('success', 'Successfully deleted.');
    }
}
