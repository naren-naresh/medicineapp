<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantGroup;
use App\Models\ProductVariantOption;
use App\Models\ProductVariantOptionValue;
use Illuminate\Http\Request;
use stdClass;


class SummaryPageController extends Controller
{
    public function index(Request $request){
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        $data['cartItems'] = Cart::where('customer_id', auth()->id() ?? $request->session()->get('guest-id') )->get();
        $cartDataItems = []; // empty array for cart items

        foreach ($data['cartItems'] as $cart) {
            $product = Product::where('id', $cart->product_id)->first();

            $product_retail_price = null;
            $product_selling_price = null;
            $variationInfoList = [];
            if ($product->have_variation) {
                $variant_groups = ProductVariantGroup::where('product_variant_id', $cart->variant_id)->get();
                foreach ($variant_groups as $variantGroup) {
                    $variationInfo = new stdClass(); // object for holding variant details
                    $variationInfo->variantData = ProductVariantOptionValue::getProductVariantOptionValue($cart->product_id, $variantGroup->product_variant_option_id, $variantGroup->product_variant_option_value_id); // getting option names
                    $variationInfo->variantName = ProductVariantOption::getProductVariantValue($cart->product_id, $variantGroup->product_variant_option_id); // getting variant names
                    $variationInfoList[] = $variationInfo; // store all variants object into the array
                }
                $product_variants = ProductVariant::where('id', $cart->variant_id)->where('status', 1)->get();
                foreach ($product_variants as $variantPrice) {
                    $product_retail_price = $variantPrice->retail_price;
                    $product_selling_price = $variantPrice->selling_price;
                }
            }
            $cartDataItems[] = [
                'cart_id' => $cart->id,
                'product_id' => $product->id,
                'variant_id' => $cart->variant_id,
                'product_name' => $product->name,
                'product_image' => $product->cover_image,
                'Product_sku' => $product->sku,
                'product_retail_Price' =>  $product_retail_price ?? $product->retail_price,
                'product_selling_price' =>  $product_selling_price ??  $product->selling_price,
                'variant_data' => $variationInfoList,
                'variant_name' => $variationInfo->variantData ?? [],
                'product_quantity' => $cart->quantity,
            ];
        }
        $data['cartDataItems'] = $cartDataItems;
        $data['addresses'] = Address::where('customer_id',auth()->id())->get();
        return view('frontend.checkout_summery', $data);

    }
}
