<?php

namespace App\Http\Controllers;

use App\Jobs\SendEmail;
use App\Jobs\SendVerificationCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Validator;

class UserController extends Controller
{
    public function registerForm()
    {
        return view('user.auth.register');
    }
    public function register(Request $request)
    {
        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'email' => 'required|string|email|unique:users|max:255',
            'user_name' => 'required|string|unique:users|max:255',
            'password' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect('register')
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::create([
            'full_name' => $request->full_name,
            'user_name' => $request->user_name,
            'email' => $request->email,
            'password' => Hash::make($request->password),
        ]);

        // $verificationCode = mt_rand(100000, 999999);
        // $request->session()->put('verification_code', $verificationCode);

        session(['user', $user]);

        SendEmail::dispatch($user);

        // $verificationCode = $this->createVerificationCode();

        // return redirect('/')->with('verification_code', $verificationCode);
        return redirect('/');
    }
    public function createVerificationCode()
    {
        $verificationCode = mt_rand(100000, 999999);
        $expires = now()->addMinutes(1); // Set expiration time to 1 minute

        // Lưu mã xác minh và thời gian hết hạn vào cookie
        response()->cookie('verification_code', $verificationCode, $expires);

        // Gửi mã xác minh đến email của người dùng
        $user = Auth::user();
        SendVerificationCode::dispatch($user, $verificationCode);

        // Trả về mã xác minh đã tạo
        return response();
    }
    public function loginForm(Request $request)
    {
        return view('user.auth.login');
    }
    public function login(Request $request)
    {
        $user = User::where(['user_name' => $request->user_name])->first();
        if (!$user || !Hash::check($request->password, $user->password)) {
            $error = 'User name or Password is not matched';
            return view('user.auth.login', compact('error'));
        } else {
            $request->session()->put('user', $user);
            return redirect('/');
        }
    }
    public function logout()
    {
        session()->forget('user');
        session()->forget('cart');
        return redirect('/');
    }

    public function admin(Request $request)
    {
        $keyword = $request->input('keyword');
        $users = User::select('users.*');

        if (!empty($keyword)) {
            $users->where(function ($query) use ($keyword) {
                $query->where('users.user_name', 'like', '%' . $keyword . '%')
                    ->orwhere('users.full_name', 'like', '%' . $keyword . '%')
                    ->orWhere('users.email', 'like', '%' . $keyword . '%');
            });
        }

        $users = $users->paginate(10);

        return view('admin.user', compact('users'));

    }

    public function delete($id)
    {
        $user = User::find($id);
        $user->delete();

        return redirect()->back()->with('success', 'Successfully deleted.');
    }
    public function setting()
    {
        $user = session()->get('user');
        return view('user.contents.setting', compact('user'));
    }
    public function update(Request $request)
    {
        $user_id = session('user')->id;

        $validator = Validator::make($request->all(), [
            'full_name' => 'required|string|max:255',
            'user_name' => 'required|string|unique:users|max:255',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($user_id);

        $user->full_name = $request->input('full_name');
        $user->user_name = $request->input('user_name');
        $user->save();

        return redirect('/setting')->with('success', 'Update succsessfully.');
    }
    public function changePassword(Request $request)
    {
        $user_id = session('user')->id;
        $validator = Validator::make($request->all(), [
            'old_password' => 'required',
            'new_passsword' => 'required|string|min:8',
        ]);

        if ($validator->fails()) {
            return redirect()
                ->back()
                ->withErrors($validator)
                ->withInput();
        }

        $user = User::find($user_id);
        if (Hash::check($request->input('old_password'), $user->password)) {
            $user->password = $request->input('new_passsword');
            $user->save();
            return redirect()->back()->with('success','Password update successfully');
        } else {
            return redirect()->back()->withErrors('Password input is not correct.');
        }
    }
}
