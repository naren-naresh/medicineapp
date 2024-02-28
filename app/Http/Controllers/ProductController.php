<?php

namespace App\Http\Controllers;

use App\Models\Category;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function index(Request $request){
        $name['categories']=Category::where('parent_category_id',null)->get();
        if ($request->ajax()) {
            $parentCategory=Category::where('parent_category_id',$request->parentCategory)->get('name');
            return response()->json($parentCategory);
        }
        return view('admin.products.basic_info',$name);
          
       }
}
