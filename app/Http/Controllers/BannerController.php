<?php

namespace App\Http\Controllers;

use App\Models\Banner;
use CloudinaryLabs\CloudinaryLaravel\Facades\Cloudinary;
use Illuminate\Http\Request;

class BannerController extends Controller
{
    //
    public function index(Request $request)
    {
        $banner = Banner::all();
        return view("user.contents.home", compact("banner"));
    }
    public function create(Request $request)
    {
        $banner = new Banner();

        $image = $request->file('src');
        $imagePath = Cloudinary::upload($image->getRealPath())->getSecurePath();
        $banner->src = $imagePath;

        $banner->save();
        return redirect()->back()->with('success','Upload new image to banner successfully!');
    }
    public function store()
    {
        $banners = Banner::all();
        return view('admin.contents.banner', compact('banners'));
    }
    public function delete($id)
    {
        $banner = Banner::find($id);
        $banner->delete();
        return redirect()->back()->with('success','Delete banner successfully!');
    }
}
