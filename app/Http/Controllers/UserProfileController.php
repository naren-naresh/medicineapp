<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DeletionVerifyCode;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Mail;

class UserProfileController extends Controller
{
    public function index(){
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        $data['userInformation'] = User::where('id',auth()->id())->get();
        return view('frontend.profile.user-profile',$data);
    }

    public function update(Request $request){
           $oldimage = User::where('id', auth()->id())->value('image');
        if ($request->hasFile('image')) {
            $imageName = time() . "." . $request->file("image")->extension();
            $request->image->move(public_path('/assets/images/user/'.auth()->id().''), $imageName);
            if ($oldimage) {
                unlink(public_path('/assets/images/user/'.auth()->id().'/'.$oldimage));
            }
        } else {
            $imageName = $oldimage;
        }
        User::where('id',auth()->id())->update(['name' => $request->name , 'contact' => $request->contact , 'gender' => $request->gender ,'image' => $imageName]);

        return redirect()->route('useProfile.index')->with('message','profile updated successfully.');
    }

    public function emailConfirmation(Request $request){
        $existingEmail = user::where('id',auth()->id())->value('email');
        if ($existingEmail == $request->userEmail) {
            $code = str_pad(random_int(100000, 999999), 6, '0', STR_PAD_LEFT);
            DeletionVerifyCode::create(['customer_id' => auth()->id(),'verification_code' => $code]);
            // mail sending method
            Mail::send('email.verificationcode', ['VerificationCode' => $code], function ($message) use ($request) {
                $message->to($request->userEmail, 'Medicine Plus');
                $message->subject('Verification Mail');
            });
            return response()->json(['success' => 'We have emailed you reference code']);
        }else{
            return response()->json(['error' => 'If the given email is not valid']);
        }
    }

    public function confirmCode(Request $request){
        $verifyCodes = DeletionVerifyCode::where('customer_id',auth()->id())->where('verification_code', $request->verificationCode)->latest()->value('verification_code');
        if ($verifyCodes) {
            return response()->json(['success' => 'your are verified']);
        }else{
            return response()->json(['error' => 'Code is not matching please try again.']);
        }
    }

    public function destroy(Request $request){
          if ($request->confirmText == "Delete" || $request->confirmText == "delete") {
             user::where('id',auth()->id())->delete();
             Auth::logout();
             return redirect('home')->with('success', 'Your account was deleted successfully');
          }
          return redirect()->back()->with('error', 'Confirmation text did not match.');
    }
}
