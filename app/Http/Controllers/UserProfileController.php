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
        // $data['genders'] = user::distinct()->get('gender');
        return view('frontend.profile.user-profile',$data);
    }
}
