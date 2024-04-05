<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
     public function index(){
        $data['products'] = Product::orderByDesc('id')->limit(6)->get();
        $data['categories'] = Category::where('parent_category_id',null)->limit(6)->get();
        $data['parent_categories'] = Category::where('parent_category_id',null)->get('name');
        return view('frontend.index',$data);
     }
}
