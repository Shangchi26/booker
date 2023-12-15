<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class VerificationController extends Controller
{
    public function index()
    {
        return view('auth.verify');
    }
    public function verify(Request $request)
    {
        $verificationCode = $request->input('verification_code');

        $cookieVerificationCode = $request->cookie('verification_code');

        if (($verificationCode === $cookieVerificationCode) && Auth::check()) {
            $email = Auth::user()->email;

            $user = User::where('email', $email)->first();
            $user->is_verify = 1;
            $user->save();

            return redirect('/');

        } else {
            return redirect()->back()->withErrors(['verification_code' => 'Verification code is incorrect. Please check again.']);
        }
    }

}
