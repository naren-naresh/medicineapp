<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantGroup;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request){
      $data['categories'] = Category::where('parent_category_id',null)->limit(6)->get();
      return view('frontend.cart',$data);
    }
    public function cartDetails(Request $request){
      $variantData = $request->variants_data ?? [];
      $VariantGroup = ProductVariantGroup::select('product_variant_id');
      $count = count($variantData);
      foreach ($variantData as $variantValue) {
        $VariantGroup->orWhere(function($query) use ($variantValue){
              $query->where('product_variant_option_id',$variantValue['variant_id'])->where('product_variant_option_value_id',$variantValue['optionId']);
        });
      }
      $VariantGroup->groupBy('product_variant_id')->havingRaw('count(product_variant_id) = ?',[$count]);
      $variantId = $VariantGroup->value('product_variant_id');
      if (!empty($variantId)) {
         $variant_details = ProductVariant::where('id',$variantId)->where('status',1)->first();
         $data['retail_price'] = $variant_details->retail_price ?? 0;
         $data['selling_price'] = $variant_details->selling_price ?? 0;
         $data['stock'] = $variant_details->stock ?? 0;
         $data['threshold_qty'] = $variant_details->threshold_qty ?? 0;
         $data['sku'] = $variant_details->sku ?? 0;
      }else{
        $data['product_details'] = Product::where('id',$request->product_id)->get();
      }
      return response(['success'=> true, 'data' => $data]);
    }
}
