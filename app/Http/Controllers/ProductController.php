<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DeliveryTypes;
use App\Models\Product;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        $name['categories'] = Category::where('parent_category_id', null)->orderBy('name', 'asc')->get();
        $name['deliveryTypes'] = DeliveryTypes::all();
        if ($request->ajax()) {
            $data = Category::where('parent_category_id', $request->parentId)->get();
            return response()->json($data);
        }
        $name['product'] = $request->session()->get('product');
        return view('admin.products.basic_info', $name);
    }
    public function store(Request $request)
    {
        dd($request->all());
        $request->validate([
            'productName' => 'required',
            'category'=>'required',
            'descriptionContent' => 'required',
        ]);
        $product = Product::create([
            'name' => $request->productName,
            'category_id' => $request->category,
            'description' => $request->description,
            'cover_image' => json_encode($request->image),
            'thumbnail_images' => json_encode($request->image),
            'status' => $request->status,
            'brand_id' => $request->brand,
            'manufacturer_id' => $request->manufacturer,
            'manufacturer_date' => $request->manufacturerDate,
            'expiry_date' => $request->expiryDate,
            'delivery_type_id' => $request->deliveryType,
            'tax_include' => $request->taxInclude,
            'tax' => $request->texValue,
            'have_variation' => $request->variation,
            'variation_name' => json_encode($request->variationName),
            'retail_price' => $request->retailPrice,
            'selling_price' => $request->sellingPrice,
            'stock' => $request->stocks,
            'threshold_qty' => $request->thresholdQty,
            'sku' => $request->sku,
            'return_policy_applicable' => $request->returnPolicy,
            'return_policy_id' => $request->policyType,
            'created_by' => Auth::user()->id ]);
        return  redirect()->route('product.index');
    }
}
