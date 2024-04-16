<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Delivery_zone;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductThumbnailImage;
use App\Models\ProductVariantOption;
use App\Models\ProductVariantOptionValue;
use App\Models\ReturnPolicy;
use App\Models\ZoneGroup;
use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    public function index(Request $request, $id)
    {
        $data['products'] = Product::where('id', $id)->get();
        foreach ($data['products'] as $tId) {
            $thumbId = json_decode($tId->thumbnail_images) ?? [];
            $manufacturersId = $tId->manufacturer_id;
            $returnId = $tId->return_policy_id;
            $catId = $tId->category_id;
        }
        $data['relatedProducts'] = Product::where('category_id', $catId)->whereNotIn('id', [$id])->get(); // get all related product from the category exclude current one.
        $data['manufacturers'] = Manufacturer::where('id', $manufacturersId)->get();
        $data['returnPolicies'] = ReturnPolicy::where('id', $returnId)->get();
        $data['variantNames'] = ProductVariantOption::where('product_id',$id)->get();
        $data['variantOptions'] = ProductVariantOptionValue::where('product_id', $id)->get();
        $data['thumbnailImages'] = ProductThumbnailImage::whereIn('id', $thumbId)->get('image');
        $data['categories'] = Category::where('parent_category_id', null)->get();
        $data['childCategories'] = Category::latest()->get();
        return view('frontend.single_product_view', $data);
    }
    public function postalCodeCheck(Request $request)
    {
        if ($request->ajax()) {
            $postalCheck = Delivery_zone::where('postal_code', $request->postalCode)->exists();
            if ($postalCheck) {
                return response()->json(['success' => 'Delivery Available']);
            } else {
                return response()->json(['error' => 'Sorry! not serviceable here.']);
            }
            return response($request->postalCode);
        }
    }
}
