<?php

namespace App\Http\Controllers;

use App\Models\Brand;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class BrandController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $brands = Brand::latest()->get() ?? [];
            return DataTables::of($brands)
                ->addIndexColumn()
                ->addColumn('name', function ($brand) {
                    return $brand->name;
                })
                ->addColumn('status', function ($brand) {
                    return ($brand->status != 0) ? '<span class=" badge bg-success">Active</span>' : '<span class=" badge bg-danger">InActive</span>';
                })
                ->addColumn('image', function ($brand) {
                    return ($brand->image != '') ? '<img src="assets/images/brands/' . $brand->image . '" style="width:50px">' : '<img src="assets/images/woocommerce-placeholder.webp" style="width:50px">';
                })
                ->addColumn('action', function ($brand) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $brand->id . '" data-original-title="Edit" class="edit btn  btn-sm editProduct">Edit</a>
                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $brand->id . '" data-original-title="Delete" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['name', 'status', 'image', 'action'])
                ->make(true);
        }

        return view('admin.brands.index');
    }
    // create or update brand details
    public function store(Request $request)
    {
        $request->validate([
            'brandName' => 'required',
            'status' => 'required',
        ]);
        $oldimage = Brand::where('id', $request->id)->value('image');
        if ($request->hasFile('brandImage')) {
            $imageName = time() . "." . $request->file("brandImage")->extension();
            $request->brandImage->move(public_path('/assets/images/brands/'), $imageName);
            if ($oldimage) {
                unlink(public_path('assets/images/brands/' . $oldimage));
            }
        } else {
            $imageName = $oldimage;
        }
        Brand::updateOrCreate([
            'id' => $request->id
        ], ['name' => $request->brandName, 'status' => $request->status, 'image' => $imageName]);
        return response()->json(['success' => 'Brand saved successfully.']);
    }
    /** edit brand */
    public function edit($id)
    {
        $brandData = Brand::find($id);
        return response()->json($brandData);
    }
    /** delete brand  */
    public function destroy($id)
    {
        Brand::find($id)->delete();
        return response()->json(['success' => 'Brand deleted successfully.']);
    }
}
