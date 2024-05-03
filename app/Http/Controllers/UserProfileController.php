<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\User;
use Illuminate\Http\Request;

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
}
