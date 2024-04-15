<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductThumbnailImage;
use App\Models\ProductVariantOption;
use App\Models\ProductVariantOptionValue;
use App\Models\ReturnPolicy;
use Illuminate\Http\Request;

class SingleProductController extends Controller
{
    public function index(Request $request,$id)
    {
        $data['products'] = Product::where('id', $id)->get();
        foreach ($data['products'] as $tId) {
            $thumbId = json_decode($tId->thumbnail_images) ?? [];
            $manufacturersId = $tId->manufacturer_id;
            $returnId = $tId->return_policy_id;
        }
        $data['manufacturers'] = Manufacturer::where('id',$manufacturersId)->get();
        $data['returnPolicies'] = ReturnPolicy :: where('id',$returnId)->get();
        $data['variantOptions'] = ProductVariantOptionValue::where('product_id',$id)->get();
        $data['thumbnailImages'] = ProductThumbnailImage::whereIn('id',$thumbId)->get('image');
        $data['categories'] = Category::where('parent_category_id', null)->get();
        $data['childCategories'] = Category::latest()->get();
        return view('frontend.single_product_view', $data);
    }
}
