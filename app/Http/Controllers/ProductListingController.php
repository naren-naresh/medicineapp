<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use Illuminate\Http\Request;

class ProductListingController extends Controller
{
    public function index(Request $request, $id = null)
    {
        if ($request->ajax()) {
            $sortType = $request->sortType;// Data from ajax call
            $parentCategory = Category::where('id', $request->catId)->first();   // Get the parent category
            $check = $parentCategory->catChildren;  // Get child categories
            $catIds = $check->pluck('id')->toArray(); // Get an array of category IDs
            // Add parent category ID to the array
            array_push($catIds, $parentCategory->id);
            // Sorting the products based on select menu value.
            if ($sortType == 1) {
                $products = Product::whereIn('category_id', $catIds)->orderBy('selling_price', 'asc')->Paginate(3);
            } else if ($sortType == 2) {
                $products = Product::whereIn('category_id', $catIds)->orderBy('selling_price', 'desc')->Paginate(3);
            }else{
                $products = Product::whereIn('category_id', $catIds)->Paginate(3);
            }
            $data['products'] = $products;
            $sorted_view = view('frontend.layouts.sorted_product_view', $data)->render();// getting the view with sorted products.
            $pagination = $products->links()->toHtml(); // Get pagination HTML
            return response()->json(['data' => $products,'sorted_view' => $sorted_view,'pagination' => $pagination]);
        } else {
            $parentCategory = Category::where('id', $id)->first();   // Get the parent category
            $check = $parentCategory->catChildren;  // Get child categories
            $catIds = $check->pluck('id')->toArray(); // Get an array of category IDs

            // Add parent category ID to the array
            array_push($catIds, $parentCategory->id);
            // Query products with category IDs and paginate the results
            $products = Product::whereIn('category_id', $catIds)->Paginate(3);
        }
        $data['products'] = $products;
        $data['categories'] = Category::where('parent_category_id', null)->get();
        $data['childCategories'] = Category::latest()->get();

        return view('frontend.product_list', $data);
    }
}
