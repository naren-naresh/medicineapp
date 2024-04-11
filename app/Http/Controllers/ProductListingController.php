<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductListingController extends Controller
{
    public function index($id){
        $parentCategory = Category::find($id);
        $data['products'] = $parentCategory->catChildren;
        $data['categories'] = Category::where('parent_category_id',null)->get();
        $data['childCategories'] = Category::latest()->get();
        return view('frontend.product_list',$data);
    }
}
