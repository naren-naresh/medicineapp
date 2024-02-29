<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DeliveryTypes;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function basicInfo(Request $request)
    {
        // dd($request->session()->get('categories'));
        $name['categories'] = Category::where('parent_category_id', null)->get();
        if ($request->ajax()) {
            $data = Category::where('parent_category_id', $request->parentId)->get();
            return response()->json($data);
        }
        return view('admin.products.basic_info', $name);
    }
    public function postBasicInfo(Request $request){
        $validatedValues=$request->validate([
            'createdFor'=>'required',
            'productName'=>'required',
        ]);

        return  redirect()->route('product.additionalInfo');
    }
    public function additionalInfo(Request $request)
    {
    //    $additional= $request->validate([
    //         'brand'=>'required',
    //         'manufacturer'=>'required',
    //         'manufacturerDate'=>'required',
    //         'expiryDate'=>'required',
    //     ]);
        $type['deliveryTypes'] = DeliveryTypes::all();
        return view('admin.products.additional_info', $type);
    }
    public function postAdditionalInfo(Request $request)
    {
        return redirect()->route('product.salesInfo');
    }
    public function salesInfo(Request $request)
    {
        return view('admin.products.sales_info');
    }
}
