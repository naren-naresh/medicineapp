<?php

namespace App\Http\Controllers;

use App\Models\User;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;

class AuthController extends Controller
{
    protected $admin;
    /**constructor */
    public function __construct()
    {
        $this->admin = Auth::id();
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
        $user = User::where('id', Auth::user()->id)->first();
        // dd($user);
        return view('admin.adminprofile.profile', compact('user'));
    }
    /** User Profile View */
    public function edit($id)
    {
        $user = User::where('id', $id)->first();
        return view('admin.adminprofile.edit', compact('user'));
    }
    /** User Profile Update */
    public function update(Request $request, $id)
    {
        $request->validate([
            'name' => 'required|string|max:250',
            'email' => 'required|email|max:250',
            'contact' => 'required',
            'gender' => 'required',
        ]);
        $useremail = Auth::user()->email;
        $useroldimage = User::where('id', $id)->value('image');
        if ($request->hasFile('image')) {
            $imageName = time() . "." . $request->file("image")->extension();
            $request->image->move(public_path('/assets/images'), $imageName);
            unlink(public_path('/assets/images/' . $useroldimage));
        } else {
            $imageName = $useroldimage;
        }
        if ($request->email == $useremail) {
            User::where('id', $id)->update(['name' => $request->name, 'email' => $request->email, 'contact' => $request->contact, 'gender' => $request->gender, 'image' => $imageName]);
            return redirect('profile');
        } else {
            User::where('id', $id)->update(['name' => $request->name, 'email' => $request->email, 'contact' => $request->contact, 'gender' => $request->gender, 'image' => $imageName]);
            Auth::logout();

            $request->session()->flush();

            $request->session()->regenerateToken();

            return redirect('login')->with('message', 'email is updated');
        }
    }
    /** password update */
    public function passwordupdate(Request $request)
    {
        $hashedpassword = Auth::user()->password;
        $newpassword = $request->oldpassword;
        if (Hash::check($newpassword, $hashedpassword)) {
            User::where('id', Auth::user()->id)->update(['password' => Hash::make($request->cpassword)]);
            Auth::logout();
            return response()->json(['success' => true]);
        } else {
            return response()->json(['success' => false, 'message' => 'Password invalid!']);
        }
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
