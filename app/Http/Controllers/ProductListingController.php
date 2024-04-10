<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductListingController extends Controller
{
    public function index(){
        // $data['products'] = Product::orderByDesc('id')->limit(12)->get();
        $data['categories'] = Category::where('parent_category_id',null)->get();
        $data['childCategories'] = Category::where('parent_category_id',1)->get();
        // dd($data['childCategories']);
        return view('frontend.product_list',$data);
    }
}
