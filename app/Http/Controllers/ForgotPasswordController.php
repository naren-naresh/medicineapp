<?php

namespace App\Http\Controllers;

use App\Models\forget_password;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Str;
use Illuminate\Support\Carbon;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class ForgotPasswordController extends Controller
{
    public function showForgetPasswordForm()
    {
        return view('admin.authentication.forgetpassword');
    }
    public function submitForgetPasswordForm(Request $request)
    {
        $request->validate([
            'email' => 'required|email|exists:users'
        ]);
        $token = str::random(64);
        $created_at = Carbon::now();
        forget_password::create(['email' => $request->email, 'token' => $token, 'created_at' => $created_at]);

        // mail sending method
        Mail::send('email.forgetpassword', ['token' => $token], function ($message) use ($request) {
            $message->to($request->input('email'), 'John Doe');
            $message->subject('Reset Password');
        });

        return back()->with('message', 'We have emailed you password link');
    }
    public function showResetPasswordForm($token)
    {
        return view('admin.authentication.forgetpasswordlink', ['token' => $token]);
    }
    public function submitResetPasswordForm(Request $request)
    {
        $request->validate([
            'password' => 'required|min:6|confirmed',
            'password_confirmation' => 'required'
        ]);

        $data = forget_password::join('users', 'users.email', '=', 'password_reset_tokens.email')->where('password_reset_tokens.token', '=', $request->token)->value('password_reset_tokens.email');
        $password_reset_request = forget_password::where('email', $data)->where('token', $request->token)->first();
        if (!$password_reset_request) {
            return back()->with('error', 'Invalid Token');
        }

        User::where('email', $data)->update(['password' => Hash::make($request->password)]);

        forget_password::where('email', $data)->delete();

        return redirect('login')->with('message', 'your password has been changed!');
    }
}
