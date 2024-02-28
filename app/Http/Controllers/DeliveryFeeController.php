<?php

namespace App\Http\Controllers;

use App\Models\Delivery_zone;
use App\Models\DeliveryFee;
use App\Models\DeliveryTypes;
use App\Models\ZoneGroup;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeliveryFeeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $detail['zone_groups'] =ZoneGroup::all();
        $detail['delivery_types'] = DeliveryTypes::where('status','1')->get();
        if ($request->ajax()) {
            $fee = DeliveryFee::latest()->get() ?? [];
            return DataTables::of($fee)
                ->addIndexColumn()
                ->addColumn('zone_group_id', function ($fee) {
                    $check=ZoneGroup::where('id',$fee->zone_group_id)->value('name');
                    return $check ?? '-';
                })
                ->addColumn('delivery_fee', function ($fee) {
                    return $fee->delivery_fee." $";
                })
                ->addColumn('delivery_type_id', function ($fee) {
                    $dtype=DeliveryTypes::where('id',$fee->delivery_type_id)->value('types');
                    return $dtype;
                })
                ->addColumn('status', function ($fee) {
                    return ($fee->status != 0) ? '<span class=" badge bg-success">Active</span>' : '<span class=" badge bg-danger">InActive</span>';
                })
                ->addColumn('action', function ($fee) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $fee->id . '" data-original-title="Edit" class="edit btn  btn-sm editProduct">Edit</a>
                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $fee->id . '" data-original-title="Delete" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['zone_group_id', 'delivery_fee', 'delivery_type', 'status', 'action'])
                ->make(true);
        }

        return view('admin.deliveryfee.index', $detail);
    }
     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'zgroup' => 'required',
            'dfee' => 'required',
            'dtype'=>'required',
            'status' => 'required',
        ]);
        DeliveryFee::updateOrCreate([
            'id' => $request->id
        ], ['zone_group_id' => $request->zgroup, 'delivery_fee' => $request->dfee,'delivery_type_id'=>$request->dtype, 'status' =>$request->status]);
        return response()->json(['success' => 'Product saved successfully.']);
    }
     /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $fees = DeliveryFee::find($id);
        return response()->json($fees);
    }
      /** delete category */
      public function destroy($id)
      {
          DeliveryFee::find($id)->delete();
          return response()->json(['success' => 'Product deleted successfully.']);
      }

}
