<?php

namespace App\Http\Controllers;

use App\Models\DeliveryFee;
use App\Models\DeliveryTypes;
use Illuminate\Http\Request;
use Yajra\DataTables\Facades\DataTables;

class DeliveryTypeController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $types = DeliveryTypes::latest()->get() ?? [];
            return DataTables::of($types)
                ->addIndexColumn()
                ->addColumn('types', function ($types) {
                    return $types->types;
                })
                ->addColumn('status', function ($types) {
                    return ($types->status != 0) ? '<span class=" badge bg-success">Active</span>' : '<span class=" badge bg-danger">InActive</span>';
                })
                ->addColumn('action', function ($types) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $types->id . '" data-original-title="Edit" class="edit btn  btn-sm editProduct">Edit</a>
                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $types->id . '" data-original-title="Delete" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['types', 'status','action'])
                ->make(true);
        }

        return view('admin.deliverytypes.index');
    }
     /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'type' => 'required',
            'status' => 'required',
        ]);
        DeliveryFee::where('delivery_type_id',$request->id)->update(['status' => $request->status]);
        DeliveryTypes::updateOrCreate([
            'id' => $request->id
        ], ['types' => $request->type,'status' => $request->status]);
        return response()->json(['success' => 'Product saved successfully.']);
    }
     /**
     * Show the form for editing the specified resource.
     */
    public function edit($id)
    {
        $tid = DeliveryTypes::find($id);
        return response()->json($tid);
    }
      /** delete category */
      public function destroy($id)
      {
          DeliveryTypes::find($id)->delete();
          return response()->json(['success' => 'Product deleted successfully.']);
      }
}
