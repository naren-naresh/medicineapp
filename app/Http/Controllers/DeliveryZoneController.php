<?php

namespace App\Http\Controllers;

use App\Models\Delivery_zone;
use App\Models\ZoneGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\Contracts\DataTable;
use Yajra\DataTables\Facades\DataTables;

class DeliveryZoneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        // $zone = Delivery_zone::latest()->get() ?? [];
        // dd($zone);
        $detail['zone_groups'] = ZoneGroup::all();
        if ($request->ajax()) {
            $zone = Delivery_zone::latest()->get() ?? [];
            return DataTables::of($zone)
                ->addIndexColumn()
                ->addColumn('zone_group_id', function ($zone) {
                    $check=ZoneGroup::where('id',$zone->zone_group_id)->value('name');
                    return $check ?? '-';
                })
                ->addColumn('postal_code', function ($zone) {
                    return $zone->postal_code;
                })
                ->addColumn('status', function ($zone) {
                    return ($zone->status != 0) ? '<span class=" badge bg-success">Active</span>' : '<span class=" badge bg-danger">InActive</span>';
                })
                ->addColumn('action', function ($zone) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $zone->id . '" data-original-title="Edit" class="edit btn  btn-sm editProduct">Edit</a>
                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $zone->id . '" data-original-title="Delete" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['name', 'parent_category', 'status', 'image', 'created_by', 'action'])
                ->make(true);
        }

        return view('admin.delivery_zone.index', $detail);
    }
    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        Delivery_zone::updateOrCreate([
            'id' => $request->id
        ], ['zone_group_id' => $request->zonegroup, 'postal_code' => $request->pcode, 'status' => $request->status]);
        return response()->json(['success' => 'Product saved successfully.']);
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $zones = Delivery_zone::find($id);
        return response()->json($zones);
    }

    /**
     * Remove the specified resource from storage.
     */
    /** delete category */
    public function destroy($id)
    {
        Delivery_zone::find($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
