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

use function Laravel\Prompts\alert;

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
                ->addColumn('action', function ($product) {
                    $btn = '<a href="' . route('product.edit',$product->id) . '" class="edit btn  btn-sm editProduct">Edit</a>
                            <a href="'. route('product.destroy',$product->id) . '" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['cover_image', 'name', 'category_id', 'status', 'stocks', 'action'])
                ->make(true);
        }
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
            'tax' => $request->taxValue,
            'have_variation' => $request->is_variation,
            'variation_name' => json_encode($request->variationName),
            'retail_price' => $request->retailPrice,
            'selling_price' => $request->sellingPrice,
            'stock' => $request->stocks,
            'threshold_qty' => $request->thresholdQty,
            'sku' => $request->sku,
            'return_policy_applicable' => $request->returnPolicy,
            'return_policy_id' => $request->policyType ,
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
                $product_option_ids[] =  ProductVariantOption::create(['product_id' =>$product_id , 'variant' => $option])->id;
            }
            $product_variant_option_values = $request->options ?? [];
            $product_variant_option_value_ids = [];
            foreach ($product_variant_option_values as $key => $values) {
                $product_variant_option_value_ids[$key] = [];
                foreach ($values as $value) {
                    $product_option_value_ids[$key][] = ProductVariantOptionValue::create([
                        'product_id' => $product_id,
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

    public function Combinations($arr) // the input variable is an nested array
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
        $name['parentCatId'] = Category::where('id',$name['product']->category_id)->value('parent_category_id');
        $name['childCatId'] = Category::where('id',$name['product']->category_id)->value('id');
        $name['variants'] = ProductVariantOption::where('product_id',$id)->get();
        $name['options'] = ProductVariantOptionValue ::where('product_id',$id)->get();
        $name['product_variants'] = ProductVariant::where('product_id',$id)->get();
        $allVariants = []; // empty array
        foreach ($name['variants'] as $varValue) {
           $varVariant = $varValue->variant;
           $allVariants[$varVariant] = [];// store variants name in one dimensional
           $optionValues = $name['options']->where('variant_option_id',$varValue->id); // separate the option values for each variants
           foreach ($optionValues as $opValue) {
            $allVariants[$varVariant][] = $opValue->variant_option_values; // Add option value to another dimensional
           }
        }
        $combArray=[]; // another empty array to hold the values of options
        foreach ($allVariants as $key => $value) {
          $combArray[] = $value;
        }
        $name['existOptions'] = $this->Combinations($combArray);
        // end of the existing combination section
        $name['thumbnailImages'] =json_encode( ProductThumbnailImage :: where('product_id',$id)->get());
        if ($request ->ajax()) {
            $data = Category::where('parent_category_id', $request->parentId)->get();
             return response()->json($data);
        }
        $name['comboArray'] = json_encode($allVariants);
        return view('admin.products.edit', $name);
    }

    // delete the existing variant
    public function destroyVariant(Request $request){
        $old_thumbnail_image = ProductThumbnailImage::where('id',$request->thumbImgId)->value('image');
          if ($request->ajax()) {
              ProductVariant::where('product_id',$request->product_id)->delete();
              ProductVariantGroup::where('product_id',$request->product_id)->delete();
              ProductVariantOption::where('product_id',$request->product_id)->delete();
              ProductVariantOptionValue::where('product_id',$request->product_id)->delete();
              // separate thumbnail images deletion using thumbImgId
              if ($request->thumbImgId) {
                ProductThumbnailImage::where('id',$request->thumbImgId)->delete();
              unlink(public_path('/assets/images/products/'.$request->product_id.'/'.$old_thumbnail_image));// unlink the image from storage
              }
              // single variant deletion using variant_id
              if ($request->variant_id) {
                ProductVariant::where('id',$request->variant_id)->delete();
              }
          }
    }

    public function update(Request $request , $id){
        // dd($request->all());
        $old_cover_image =  Product::where('id',$id)->value('cover_image');
        if ($request->hasFile('coverImage')) {
             // cover image
             unlink(public_path('/assets/images/products/'.$id.'/'.$old_cover_image));
             $imageName = time() . "." . $request->file("coverImage")->extension();
             $request->coverImage->move(public_path('/assets/images/products/' . $id . ''), $imageName);
        }else{
            $imageName = $old_cover_image;
        }
        $product = Product::where('id',$id)->first();
        Product::where('id',$id)->update([
            'name' => $request->productName,
            'category_id' => $request->category,
            'description' => $request->descriptionContent,
            'cover_image' => $imageName,
            'thumbnail_images' => null,
            'status' => $request->status,
            'brand_id' => $request->brand ?? $product->brand_id,
            'manufacturer_id' => $request->manufacturer ?? $product->manufacturer_id,
            'manufacturer_date' => $request->manufacturerDate ?? $product->manufacturer_date,
            'expiry_date' => $request->expiryDate ?? $product->expiry_date,
            'delivery_type_id' => $request->deliveryType ?? $product->delivery_type_id,
            'tax_include' => $request->taxInclude ?? $product->tax_include,
            'tax' => $request->taxValue,
            'have_variation' => $request->is_variation ?? $product->have_variation,
            'variation_name' => json_encode($request->variationName) ?? json_encode($product->variation_name),
            'retail_price' => $request->retailPrice ?? $product->retail_price,
            'selling_price' => $request->sellingPrice ?? $product->selling_price,
            'stock' => $request->stocks ?? $product->stock,
            'threshold_qty' => $request->thresholdQty ?? $product->threshold_qty,
            'sku' => $request->sku ?? $product->sku,
            'return_policy_applicable' => $request->returnPolicy ?? $product->return_policy_applicable,
            'return_policy_id' => $request->policyType,
        ]);
         // thumbnail images
         $thumbnailImgData = $request->image ?? [];
         $thumbImgID=[];
         foreach ($thumbnailImgData as $tImage) {
             $thumbImageName =  uniqid() . '.' . $tImage->extension();
             $tImage->move(public_path('/assets/images/products/' . $id . ''), $thumbImageName);
             $thumbImgID[]=ProductThumbnailImage::create([
                 'product_id' => $id,
                 'image' => $thumbImageName,
             ])->id;
         }
         if ($thumbImgID) {
            Product::where('id',$id)->update(array('thumbnail_images' => $thumbImgID));
        }
        // update variants and it's values
        if ($request->is_variation) {
           if ($request->has('product_variants') && !$request->has('old_product_variants')) {
            $product_variantOptions = $request->variationName ?? [];
            $product_option_ids = [];
            foreach ($product_variantOptions as $key => $option) {
                $product_option_ids[] =  ProductVariantOption::create(['product_id' =>$product->id , 'variant' => $option])->id;
            }
            $product_variant_option_values = $request->options ?? [];
            $product_variant_option_value_ids = [];
            foreach ($product_variant_option_values as $key => $values) {
                $product_variant_option_value_ids[$key] = [];
                foreach ($values as $value) {
                    $product_option_value_ids[$key][] = ProductVariantOptionValue::create([
                        'product_id' =>$product->id,
                        'variant_option_id' => $product_option_ids[$key],
                        'variant_option_values' => $value
                    ])->id;
                }
            }
            $product_variants = $request->product_variants ?? [];
            foreach ($product_variants as $variants) {
                $product_variants_id = ProductVariant::create([
                    'product_id' => $product->id,
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
                        'product_id' => $product->id,
                        'product_variant_id' => $product_variants_id,
                        'product_variant_option_id' => $option_id,
                        'product_variant_option_value_id' => $option_value_id,
                    ]);
                }
            }
           }
        }
        if ($request->has('old_product_variants') && !$request->has('product_variants')) {
            $existing_product_variants = $request->old_product_variants ?? [];
            foreach ($existing_product_variants as $existVariant) {
                $checkVariant = ProductVariant::where('product_id',$id)->where('id',$existVariant['variant_id'])->first();
                if ($checkVariant) {
                    $checkVariant->update([
                        'retail_price' => $existVariant['retail_price'],
                        'selling_price' => $existVariant['selling_price'],
                        'stock' => $existVariant['stock'],
                        'threshold_qty' => $existVariant['threshold_qty'],
                        'sku' => $existVariant['sku'],
                        'status' => isset($existVariant['status']) ? $existVariant['status'] : 0,
                    ]);
                }
            }

        }
        return redirect()->route('product.index')->with('message','Product updated successfully.');
    }

    /** delete category */
    public function destroy($id)
    {
        dd('deletion');
        Product::find($id)->delete();
        return redirect()->route('product.index')->with('message','Product deleted successfully.');
    }
}
