<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class AuthController extends Controller
{
    protected $admin;
    /**constructor */
    public function __construct()
    {

            $this->admin= Auth::id();



    }

    /** Admin login */
    public function login()
    {
        return view('admin.authentication.login');
    }
    /** Admin authentication */
    public function authenticate(Request $request)
    {
        $credentials = $request->validate([
            'email' => ['required', 'email'],
            'password' => ['required'],
        ]);
        if (Auth::attempt($credentials)) {
            $request->session()->regenerate();

            return redirect()->intended('dashboard');
        }

        return back()->withErrors([
            'email' => 'The provided credentials do not match our records.',
        ])->onlyInput('email');
    }
    /** Dashboard view */
    public function index()
    {
        return view('dashboard');
    }
    /** profile */
    public function profile()
    {
        $user = User::where('id',Auth::user()->id)->first();
        // dd($user);
        return view('admin.adminprofile.profile', compact('user'));
    }
    /** Logout */
    public function logout(Request $request): RedirectResponse
    {
        Auth::logout();

        $request->session()->flush();

        $request->session()->regenerateToken();

        return redirect('login')->with('message', 'You are logged out successfully');
    }
}
