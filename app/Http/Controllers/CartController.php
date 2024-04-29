<?php

namespace App\Http\Controllers;

use App\Models\Cart;
use App\Models\Category;
use App\Models\Product;
use App\Models\ProductVariant;
use App\Models\ProductVariantGroup;
use App\Models\ProductVariantOption;
use App\Models\ProductVariantOptionValue;
use App\Models\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use stdClass;

class CartController extends Controller
{
    public function index(Request $request)
    {
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
                'product_name' => $product->name,
                'product_image' => $product->cover_image,
                'product_retail_Price' =>  $product_retail_price ?? $product->retail_price,
                'product_selling_price' =>  $product_selling_price ??  $product->selling_price,
                'variant_data' => $variationInfoList,
                'product_quantity' => $cart->quantity,
            ];
        }
        $data['cartDataItems'] = $cartDataItems;
        $data['relatedProducts'] = Product::latest()->limit(8)->get();
        return view('frontend.cart', $data);
    }

    public function cartDetails(Request $request)
    {
        $guestId = $request->session()->get('guest-id') ?? null;
        $customer_id = Auth::check() ? Auth::id() : $guestId;

        if($customer_id == null) { // if customer-id null and the session variable null means create a new guest-id.
            $customer_id = User::create(['role_id' => 3])->id;
            $request->session()->put('guest-id', $customer_id);// put a guest-id into the session variable
        }

        $productId = $request->input('product_id');
        $variantData = $request->input('variants_data', []);
        $quantity = $request->input('quantity');
        $zoneId = $request->input('zone_id');
        $VariantGroup = ProductVariantGroup::select('product_variant_id');
        $count = count($variantData);
        foreach ($variantData as $variantValue) {
            $VariantGroup->orWhere(function ($query) use ($variantValue) {
                $query->where('product_variant_option_id', $variantValue['variant_id'])->where('product_variant_option_value_id', $variantValue['optionId']);
            });
        }
        $VariantGroup->groupBy('product_variant_id')->havingRaw('count(product_variant_id) = ?', [$count]);
        $variantId = $VariantGroup->value('product_variant_id');
        $cartData = Cart::where('product_id', $productId)->where('customer_id', $customer_id)->where('variant_id', $variantId)->value('quantity'); // same product with same variant means we want to update the quantity of the product.
        if ($cartData) {
            $addQuantity = $cartData + 1; // increasing the quantity if product and variant is same.
            Cart::where('product_id', $productId)->where('customer_id', $customer_id)->where('variant_id', $variantId)->update(['quantity' => $addQuantity]);
        } else {
            Cart::create([
                'customer_id' => $customer_id,
                'product_id' => $productId,
                'variant_id' => $variantId,
                'quantity' => $quantity,
                'zone_id' => $zoneId,
            ]);
        }
        $data['product_details'] = Product::where('id', $request->product_id)->get();
        return response(['success' => true, 'data' => $data]);
    }

    public function update(Request $request)
    {
        if ($request->ajax()) {
            Cart::where('id', $request->cartId)->update(['quantity' => $request->quantity]);
            return response()->json(['success' => 'Product updated successfully.']);
        }
    }

    /** delete product from cart */
    public function destroy(Request $request)
    {
        if ($request->ajax()) {
            Cart::where('id', $request->cartId)->delete();
            return response()->json(['success' => 'Product deleted successfully.']);
        }
    }
}
