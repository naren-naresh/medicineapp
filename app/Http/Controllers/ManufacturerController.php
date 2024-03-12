<?php

namespace App\Http\Controllers;

use App\Models\Manufacturer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ManufacturerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $menus = Manufacturer::latest()->get() ?? [];
            return DataTables::of($menus)
                ->addIndexColumn()
                ->addColumn('name', function ($menu) {
                    return $menu->name;
                })
                ->addColumn('company_name', function ($menu) {
                    return $menu->company_name;
                })
                ->addColumn('company_logo', function ($menu) {
                    return ($menu->company_logo != '') ? '<img src="assets/images/manufacturers/' . $menu->company_logo . '" style="width:50px">' : '<img src="assets/images/woocommerce-placeholder.webp" style="width:50px">';
                })
                ->addColumn('address', function ($menu) {
                    return $menu->address;
                })
                ->addColumn('status', function ($menu) {
                    return ($menu->status != 0) ? '<span class=" badge bg-success">Active</span>' : '<span class=" badge bg-danger">InActive</span>';
                })
                ->addColumn('action', function ($menu) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $menu->id . '" data-original-title="Edit" class="edit btn  btn-sm editProduct">Edit</a>
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $menu->id . '" data-original-title="Delete" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['name','company_name','company_logo','address','status', 'action'])
                ->make(true);
        }
        return view('admin.manufacturer.index');
    }
    // create or update brand details
    public function store(Request $request)
    {
        $request->validate([
            'manufacturerName' => 'required',
            'status' => 'required',
        ]);
        $oldimage = Manufacturer::where('id', $request->id)->value('company_logo');
        if ($request->hasFile('companyLogo')) {
            $imageName = time() . "." . $request->file("companyLogo")->extension();
            $request->companyLogo->move(public_path('/assets/images/manufacturers/'), $imageName);
            if ($oldimage) {
                unlink(public_path('assets/images/manufacturers/' . $oldimage));
            }
        } else {
            $imageName = $oldimage;
        }
        Manufacturer::updateOrCreate([
            'id' => $request->id
        ], ['name' => $request->manufacturerName,'company_name' => $request->companyName, 'company_logo' => $imageName ,'address' => $request->address ,'status' => $request->status]);
        return response()->json(['success' => 'Manufacturer saved successfully.']);
    }
    /** edit manufacturer */
    public function edit($id)
    {
        $menuData = Manufacturer::find($id);
        return response()->json($menuData);
    }
    /** delete manufacturer  */
    public function destroy($id)
    {
        Manufacturer::find($id)->delete();
        return response()->json(['success' => 'Manufacturer deleted successfully.']);
    }
}
