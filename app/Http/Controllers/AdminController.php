<?php

namespace App\Http\Controllers;

use App\Models\Admin;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class AdminController extends Controller
{
    //
    public function adminLoginForm()
    {
        Auth::logout();
        return view('admin.login');
    }
    public function login(Request $request)
    {
        $admin = Admin::where('user_name', $request->user_name)->first();

        if (!$admin || !Hash::check($request->password, $admin->password)) {
            $error = 'admin name or Password is not matched';
            return view('admin.login', compact('error'));
        } else {
            session()->put('admin', $admin);
        }
        return redirect('/admin/hotel');
    }
    public function logout()
    {
        session()->forget('admin');
        return redirect('/admin/login');
    }
    public function admin()
    {
        $admins = Admin::all();
        return view('admin.contents.admin', compact('admins'));
    }
    public function create(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:admins|max:255',
            'user_name' => 'required|string|unique:admins|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $admin = Admin::create([
            'full_name' => $request->full_name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        return redirect()->back()->with('success','Create new admin successfully.');

    }
}
