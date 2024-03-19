<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use App\Models\Category;
use App\Models\DeliveryTypes;
use App\Models\Manufacturer;
use App\Models\Product;
use App\Models\ProductThumbnailImage;
use App\Models\ProductVariant;
use App\Models\ProductVariantGroup;
use App\Models\ProductVariantOption;
use App\Models\ProductVariantOptionValue;
use App\Models\ReturnPolicy;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;

class ProductController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $products = Product::latest()->get() ?? [];
            return DataTables::of($products)
                ->addIndexColumn()
                ->addColumn('cover_image', function ($product) {
                    return($product->cover_image !='') ? '<img src="assets/images/products/'.$product->id.'/'.$product->cover_image.'" style="width:50px">':'<img src="assets/images/woocommerce-placeholder.webp" style="width:50px">';
                })
                ->addColumn('name', function ($product) {
                    return $product->name;
                })
                ->addColumn('category_id', function ($category) {
                    $check=Category::where('id',$category->category_id)->value('name');
                    return $check  ?? '-';
                })
                ->addColumn('status', function ($product) {
                    return ($product->status != 0) ? '<span class=" badge bg-success">Active</span>' : '<span class=" badge bg-danger">InActive</span>';
                })
                ->addColumn('stocks', function ($product) {
                    return $product->stock;
                })
                ->addColumn('action', function ($category) {
                    $btn = '<a href="' . route('product.edit',$category->id) . '" class="edit btn  btn-sm editProduct">Edit</a>
                            <a href="'. route('product.destroy',$category->id) . '" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['cover_image', 'name', 'category_id', 'status', 'stocks', 'action'])
                ->make(true);
        }
        $name['product'] = $request->session()->get('product');
        return view('admin.products.index');
    }
    public function add(Request $request){
        $name['categories'] = Category::where('parent_category_id', null)->orderBy('name', 'asc')->get();
        $name['deliveryTypes'] = DeliveryTypes::all();
        $name['brands'] = Brand::all();
        $name['manufacturers'] = Manufacturer::all();
        $name['returnPolicies'] = ReturnPolicy::all();
        if ($request ->ajax()) {
            $data = Category::where('parent_category_id', $request->parentId)->get();
             return response()->json($data);
        }
        return view('admin.products.create', $name);
    }

    public function store(Request $request)
    {
        $request->validate([
            'productName' => 'required',
            'category' => 'required',
            'descriptionContent' => 'required',
        ]);

        // cover image
        $imageName = time() . "." . $request->file("coverImage")->extension();

        //Save Product Data
        $product = Product::create([
            'name' => $request->productName,
            'category_id' => $request->category,
            'description' => $request->descriptionContent,
            'cover_image' => $imageName,
            'thumbnail_images' => null,
            'status' => $request->status,
            'brand_id' => $request->brand,
            'manufacturer_id' => $request->manufacturer,
            'manufacturer_date' => $request->manufacturerDate,
            'expiry_date' => $request->expiryDate,
            'delivery_type_id' => $request->deliveryType,
            'tax_include' => $request->taxInclude,
            'tax' => $request->texValue,
            'have_variation' => $request->is_variation,
            'variation_name' => json_encode($request->variationName),
            'retail_price' => $request->retailPrice,
            'selling_price' => $request->sellingPrice,
            'stock' => $request->stocks,
            'threshold_qty' => $request->thresholdQty,
            'sku' => $request->sku,
            'return_policy_applicable' => $request->returnPolicy,
            'return_policy_id' => $request->policyType,
            'created_by' => Auth::user()->id
        ]);

        $product_id = $product->id;

        // cover image
        $request->coverImage->move(public_path('/assets/images/products/' . $product_id . ''), $imageName);

        // thumbnail images
        $thumbnailImgData = $request->image ?? [];
        $thumbImgID=[];
        foreach ($thumbnailImgData as $tImage) {
            $thumbImageName =  uniqid() . '.' . $tImage->extension();
            $tImage->move(public_path('/assets/images/products/' . $product_id . ''), $thumbImageName);
            $thumbImgID[]=ProductThumbnailImage::create([
                'product_id' => $product_id,
                'image' => $thumbImageName,
            ])->id;
        }
        if ($thumbImgID) {
            Product::where('id',$product_id)->update(array('thumbnail_images' => $thumbImgID));
        }
        // generate variants options and it's values
        if ($request->is_variation) {
            $product_variantOptions = $request->variationName ?? [];
            $product_option_ids = [];
            foreach ($product_variantOptions as $key => $option) {
                $product_option_ids[] =  ProductVariantOption::create(['product_id' => 1, 'variant' => $option])->id;
            }
            $product_variant_option_values = $request->options ?? [];
            $product_variant_option_value_ids = [];
            foreach ($product_variant_option_values as $key => $values) {
                $product_variant_option_value_ids[$key] = [];
                foreach ($values as $value) {
                    $product_option_value_ids[$key][] = ProductVariantOptionValue::create([
                        'product_id' => 1,
                        'variant_option_id' => $product_option_ids[$key],
                        'variant_option_values' => $value
                    ])->id;
                }
            }
            $product_variants = $request->product_variants ?? [];
            foreach ($product_variants as $variants) {
                $product_variants_id = ProductVariant::create([
                    'product_id' => $product_id,
                    'retail_price' => $variants['retail_price'],
                    'selling_price' => $variants['selling_price'],
                    'stock' => $variants['stock'],
                    'threshold_qty' => $variants['threshold_qty'],
                    'sku' => $variants['sku'],
                    'status' => $variants['status'] ?? null
                ])->id;
                $variant_values = $variants['value'] ?? [];
                foreach ($variant_values as $key => $variantValue) {
                    $option_id = $product_option_ids[$key];
                    $option_value_index = array_search($variantValue, $product_variant_option_values[$key]);
                    $option_value_id = $product_option_value_ids[$key][$option_value_index];
                    ProductVariantGroup::create([
                        'product_id' => $product_id,
                        'product_variant_id' => $product_variants_id,
                        'product_variant_option_id' => $option_id,
                        'product_variant_option_value_id' => $option_value_id,
                    ]);
                }
            }
        }

        return redirect()->route('product.index')->with('message','Product saved successfully.');
    }

    public function productVariant(Request $request)
    {
        if ($request->has('selected_variants')) {
            $selectedVariants = $request->selected_variants;
            $data = $array = $head = [];
            foreach ($selectedVariants as $key => $value) {
                $head[] = $key;
                $array[] = $value;
            }
            $data['headings'] = $head;
            $data['options'] = $this->Combinations($array);
            $data['retail_price'] = $request->retail_price;
            $data['selling_price'] = $request->selling_price;
            $data['sku'] = $request->sku;
            $data['stock'] = $request->stock;
            $data['threshold_qty'] = $request->threshold_qty;
            return view('admin.products.variants', $data);
        } else {
            return view('admin.products.create')->with('error', 'Something Went Wrong Please Try Again!');
        }
    }

    function Combinations($arr) // the input variable is an nested array
    {
        if (count($arr) == 0) return [];
        $n = count($arr);
        $indices = []; // it will create a array that includes zero's and it's length is dependent on the input array's length
        for ($i = 0; $i < $n; $i++) {
            array_push($indices, 0);
        }
        $all_variants = array(); // the empty array will created to store all possible combination of product's
        while (1) {
            $variations = []; // another empty array for temp storage for values
            for ($i = 0; $i < $n; $i++) {
                $variations[] = $arr[$i][$indices[$i]];
            }
            array_push($all_variants, $variations);
            $next = $n - 1;
            while ($next >= 0 && ($indices[$next] + 1 >= count($arr[$next]))) {
                $next -= 1;
            }
            if ($next < 0) {
                break;
            }
            $indices[$next] += 1;
            for ($i = $next + 1; $i < $n; $i++) {
                $indices[$i] = 0;
            }
        }
        return $all_variants;
    }
    public function edit(Request $request,$id){
        $name['categories'] = Category::where('parent_category_id', null)->orderBy('name', 'asc')->get();
        $name['deliveryTypes'] = DeliveryTypes::all();
        $name['brands'] = Brand::all();
        $name['manufacturers'] = Manufacturer::all();
        $name['returnPolicies'] = ReturnPolicy::all();
        $name['product'] = Product::find($id);
        if ($request ->ajax()) {
            $data = Category::where('parent_category_id', $request->parentId)->get();
             return response()->json($data);
        }
        return view('admin.products.edit', $name);
    }
    /** delete category */
    public function destroy($id)
    {
        Product::find($id)->delete();
        return redirect()->route('product.index')->with('message','Product deleted successfully.');
    }
}
