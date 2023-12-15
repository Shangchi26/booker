<?php

namespace App\Http\Controllers;

use App\Models\Amenity;
use App\Models\BookingDetail;
use App\Models\Hotel;
use App\Models\Review;
use App\Models\Room;
use App\Models\RoomImage;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Validator;

class RoomController extends Controller
{
    //
    public function index(Request $request)
    {
        $keyword = $request->input('keyword');
        $rooms = Room::join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->select('rooms.*', 'hotels.name as hotel_name')
            ->orderBy('rooms.id', 'desc');

        $roomIds = $rooms->pluck('id');

        $amenities = Amenity::whereIn('room_id', $roomIds)
            ->select('room_id', DB::raw('GROUP_CONCAT(name SEPARATOR " - ") as amenities_list'))
            ->groupBy('room_id')
            ->get();

        $rooms = $rooms->paginate(10);

        $hotels = Hotel::all();
        return view('admin.room', compact('rooms', 'hotels', 'amenities'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'name' => 'required',
            'room_type' => 'required|in:Single Room,Double Room',
            'price' => 'required|numeric|min:0',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $room = new Room;
        $room->name = $request->input('name');
        $room->hotel_id = session()->get('employee')->hotel_id;
        $room->room_type = $request->input('room_type');
        $room->price = $request->input('price');
        $room->save();
        $roomImage = new RoomImage;
        $roomImage->room_id = $room->id;
        if ($request->hasFile('image')) {
            $roomImage->image = Cloudinary::upload($request->files('image')->getRealPath())->getSecurePath();
            $roomImage->save();
        }
        $amenity = new Amenity;
        $amenity->room_id = $room->id;
        $amenity->name = $request->input('amenity');
        $amenity->save();

        // $amenities = $request->input('amenities');
        // if (!empty($amenities)) {
        //     foreach ($amenities as $amenity) {
        //         $room->amenities()->create(['name' => $amenity]);
        //     }
        // }

        return redirect()->back()->with('success', 'Successfully created.');

    }
    public function update(Request $request, $id)
    {
        $employee = session()->get('employee');
        $room = Room::find($id);
        $room->name = $request->input('name');
        $room->hotel_id = $employee->hotel_id;
        $room->room_type = $request->input('room_type');
        $room->price = $request->input('price');
        $room->available = $request->input('available');
        $room->save();

        return redirect()->back()->with('success', 'Successfully updated.');
    }
    public function uploadImage(Request $request)
    {
        $image = new RoomImage;
        $image->room_id = $request->input('room_id');
        $image->image = Cloudinary::upload($request->files('image')->getRealPath())->getSecurePath();
        $image->save();

        return redirect()->back()->with('success', 'Successfully updated.');
    }
    public function delete(Request $request, $id)
    {
        $room = Room::find($id);
        $isRoomBooked = BookingDetail::where('room_id', $id)->exists();

        if ($isRoomBooked) {
            return redirect()->back()->withErrors('Room is associated with orders and cannot be deleted.');
        }
        $room->images()->delete();
        $room->amenities()->delete();
        $room->delete();

        return redirect()->back()->with('success', 'Successfully deleted.');
    }
    public function roomDetail(Request $request, $id)
    {
        $room = Room::find($id);

        $room = $room->join('hotels', 'rooms.hotel_id', '=', 'hotels.id')
            ->where('rooms.id', $room->id)
            ->select('rooms.*', 'hotels.address', 'hotels.hotline', 'hotels.name as hotel_name', 'hotels.description as hotel_description')
            ->first();

        $images = $room->join('room_images', 'rooms.id', '=', 'room_images.room_id')
            ->where('rooms.id', $room->id)
            ->pluck('room_images.image');

        $amenities = $room->join('amenities', 'rooms.id', '=', 'amenities.room_id')
            ->where('rooms.id', $room->id)
            ->pluck('amenities.name');

        $ratingFilter = $request->input('rating');

        $reviews = Review::join('booking_details', 'reviews.booking_detail_id', '=', 'booking_details.id')
            ->join('bookings', 'booking_details.booking_id', '=', 'bookings.id')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->where('booking_details.room_id', $room->id);

        if (!empty($ratingFilter)) {
            $reviews->where('reviews.rating', $ratingFilter);
        }

        $reviews = $reviews->select('users.full_name as user_name', 'reviews.rating', 'reviews.comment')
            ->get();

        $bookingCount = BookingDetail::where('room_id', $room->id)->count();

        $reviewCount = Review::join('booking_details', 'reviews.booking_detail_id', '=', 'booking_details.id')
            ->where('booking_details.room_id', $room->id)
            ->count();

        $averageRating = Review::join('booking_details', 'reviews.booking_detail_id', '=', 'booking_details.id')
            ->where('booking_details.room_id', $room->id)
            ->avg('reviews.rating');

        $room->images = $images;
        $room->amenities = $amenities;
        $room->reviews = $reviews;
        $room->bookingCount = $bookingCount;
        $room->reviewCount = $reviewCount;
        $room->averageRating = $averageRating;

        return view('user.contents.room', compact('room'));
    }

    public function detail($id)
    {
        $room = Room::find($id);

        $amenities = $room->amenities()
            ->select('amenities.id', 'amenities.name')
            ->get();

        $images = $room->images()
            ->select('room_images.id', 'room_images.image')
            ->get();

        return view('employee.contents.roomDetail', compact('room', 'amenities', 'images'));
    }
    public function addImage(Request $request)
    {
        $room = $request->input('id');
        $roomImage = new RoomImage;
        $roomImage->room_id = $room;
        if ($request->hasFile('image') && $request->file('image')->isValid()) {
            $imageFile = $request->file('image');
            $roomImage->image = Cloudinary::upload($imageFile->getRealPath())->getSecurePath();
            $roomImage->save();
            return redirect()->back()->with('success', 'Upload Image successfully');
        } else {
            return redirect()->back()->withErrors('Error');
        }
    }
    public function deleteImage($id)
    {
        $image = RoomImage::find($id);
        if ($image) {
            $image->delete();
            return redirect()->back()->with('success', 'Delete Image successful.');
        } else {
            return redirect()->back()->withErrors('Image not found.');
        }

    }

    public function deleteAmenity($amenityId)
    {
        $amenity = Amenity::find($amenityId);

        if ($amenity) {
            $amenity->delete();
            return redirect()->back()->with('success', 'Delete Amenity successful.');
        } else {
            return redirect()->back()->withErrors('Amenity not found.');
        }
    }
    public function addAmenity(Request $request, $id)
    {
        $amenity = new Amenity;
        $amenity->room_id = $id;
        $amenity->name = $request->name;
        $amenity->save();

        return redirect()->back()->with('success', 'Add amenity successfully.');
    }
}
