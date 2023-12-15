<?php

namespace App\Http\Controllers;

use App\Models\BookingDetail;
use App\Models\Review;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ReviewController extends Controller
{
    //
    public function add(Request $request, $id)
    {
        $validator = Validator::make($request->all(), [
            'rating' => 'required|integer|between:1,5',
            'comment' => 'required|string',
        ]);

        if ($validator->fails()) {
            return redirect()->back()
                ->withErrors($validator)
                ->withInput();
        }

        $review = new Review();
        $review->booking_detail_id = $id;
        $review->rating = $request->input('rating');
        $review->comment = $request->input('comment');
        $review->save();

        return redirect()->back()->with('success', 'Add review successfully.');
    }
    public function show($id)
    {
        $review = Review::find($id);

        return view('user.contents.orderDetail', compact('review'));
    }
    public function delete($id)
    {
        $review = Review::find($id);
        $review->delete();
        return redirect()->back()->with('success', 'Your Review has been delete.');
    }
    public function get($id)
    {
        $bookingDetails = BookingDetail::whereHas('room', function ($query) use ($id) {
            $query->where('id', $id);
        })->with('review')->get();

        return view('room_reviews', compact('bookingDetails'));
    }
}
