<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Delivery_zone;
use App\Models\Product;
use App\Models\SliderImage;
use Illuminate\Http\Request;

class HomePageController extends Controller
{
     public function index(Request $request){
        if ($request->ajax()) {
            $checkPostalCode=Delivery_zone::where('postal_code',$request->postal_code)->exists();
            if ($checkPostalCode) {
                return response()->json(['valid' => true]);
            } else {
                return response()->json(['valid' => false]);
            }   
        }
        $data['products'] = Product::orderByDesc('id')->limit(12)->get();
        $data['categories'] = Category::where('parent_category_id',null)->limit(6)->get();
        $data['sliders'] = SliderImage::get();
        return view('frontend.index',$data);
     }
     // search function for page
     public function search(Request $request){
         if ($request->ajax()) {
            $result = Product::where('name','Like','%'.$request->search_data.'%')->get();
         }
         if ($result->isEmpty()) {
            return response()->json([]);
        }
        return response()->json($result);
     }
}
