<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductListingController extends Controller
{
    public function index(Request $request, $id)
    {
        $parentCategory = Category::where('id', $id)->first();   // Get the parent category
        $check = $parentCategory->catChildren;  // Get child categories
        $catIds = $check->pluck('id')->toArray(); // Get an array of category IDs

        // Add parent category ID to the array
        array_push($catIds, $parentCategory->id);

        if ($request->ajax()) {
          dd($request->sortType);
        }
        // Query products with category IDs and paginate the results
        $products = Product::whereIn('category_id', $catIds)->Paginate(3);

        $data['products'] = $products;
        $data['categories'] = Category::where('parent_category_id', null)->get();
        $data['childCategories'] = Category::latest()->get();

        return view('frontend.product_list', $data);
    }
}
