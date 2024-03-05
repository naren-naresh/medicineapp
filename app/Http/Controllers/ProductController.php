<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\DeliveryTypes;
use Illuminate\Http\Request;

class ProductController extends Controller
{
    public function basicInfo(Request $request)
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
    public function postBasicInfo(Request $request)
    {
        dd($request->all());
        $request->validate([
            'createdFor' => 'required',
            'productName' => 'required',
        ]);
        return  redirect()->route('product.additionalInfo');
    }
}
