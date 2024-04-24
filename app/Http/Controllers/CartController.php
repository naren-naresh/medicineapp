<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantGroup;
use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request){
      $data['categories'] = Category::where('parent_category_id',null)->limit(6)->get();
      $data['cartItems'] = Cart::where('customer_id', auth()->id())->get();
      foreach ($data['cartItems'] as $value) {
        $variantIds[] = $value->variant_id;
        $productIds[] = $value->product_id;
      }
      if (!empty( $variantIds) && !empty($productIds)) {
        $data['variant_details'] = ProductVariant::whereIn('id',$variantIds)->where('status',1)->get();
        $data['productDetails'] = Product::whereIn('id',$productIds)->get();
      }else{
        $data['productDetails'] = [];
      }
      $data['relatedProducts'] = Product::latest()->limit(6)->get();
      return view('frontend.cart',$data);
    }
    public function cartDetails(Request $request){

      $productId = $request->input('product_id');
      $variantData = $request->input('variants_data', []);
      $quantity = $request->input('quantity');
      $zoneId = $request->input('zone_id');
      $VariantGroup = ProductVariantGroup::select('product_variant_id');
      $count = count($variantData);
      foreach ($variantData as $variantValue) {
        $VariantGroup->orWhere(function($query) use ($variantValue){
              $query->where('product_variant_option_id',$variantValue['variant_id'])->where('product_variant_option_value_id',$variantValue['optionId']);
        });
      }
      $VariantGroup->groupBy('product_variant_id')->havingRaw('count(product_variant_id) = ?',[$count]);
      $variantId = $VariantGroup->value('product_variant_id');
    //   if (!empty($variantId)) {
        Cart::create([
            'customer_id' => auth()->id(),
            'product_id' => $productId,
            'variant_id' => $variantId,
            'quantity' => $quantity,
            'zone_id' => $zoneId,
        ]);
        //  $variant_details = ProductVariant::where('id',$variantId)->where('status',1)->first();
        //  $data['retail_price'] = $variant_details->retail_price ?? 0;
        //  $data['selling_price'] = $variant_details->selling_price ?? 0;
        //  $data['stock'] = $variant_details->stock ?? 0;
        //  $data['threshold_qty'] = $variant_details->threshold_qty ?? 0;
        //  $data['sku'] = $variant_details->sku ?? 0;
    //   }else{
        $data['product_details'] = Product::where('id',$request->product_id)->get();
    //   }
      return response(['success'=> true, 'data' => $data]);
    }
    public function update(Request $request){
        if ($request->ajax()) {
            Cart::where('id',$request->cartId)->update(['quantity' => $request->quantity]);
            return response()->json(['success' => 'Product updated successfully.']);
        }
    }
     /** delete product from cart */
     public function destroy(Request $request)
     {
         if ($request->ajax()) {
             Cart::where('id',$request->cartId)->delete();
             return response()->json(['success' => 'Product deleted successfully.']);
         }
     }
}
