<?php

namespace App\Http\Controllers;

use App\Models\ReturnPolicy;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ReturnPolicyController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $policies = ReturnPolicy::latest()->get() ?? [];
            return DataTables::of($policies)
                ->addIndexColumn()
                ->addColumn('policy_name', function ($policy) {
                    return $policy->policy_name;
                })
                ->addColumn('policy_details', function ($policy) {
                    return $policy->policy_details;
                })
                ->addColumn('status', function ($policy) {
                    return ($policy->status != 0) ? '<span class=" badge bg-success">Active</span>' : '<span class=" badge bg-danger">InActive</span>';
                })
                ->addColumn('action', function ($policy) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $policy->id . '" data-original-title="Edit" class="edit btn  btn-sm editProduct">Edit</a>
                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $policy->id . '" data-original-title="Delete" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['policy_name', 'policy_details', 'status', 'action'])
                ->make(true);
        }

        return view('admin.returnpolicy.index');
    }
    // create or update return policy details
    public function store(Request $request)
    {
        $request->validate([
            'policyName' => 'required',
            'status' => 'required',
        ]);
        ReturnPolicy::updateOrCreate([
            'id' => $request->id
        ], ['policy_name' => $request->policyName, 'policy_details' => $request->policyDetails , 'status' => $request->status]);
        return response()->json(['success' => 'Return policy saved successfully.']);
    }
     /** edit return policy details */
     public function edit($id)
     {
         $policyData = ReturnPolicy::find($id);
         return response()->json($policyData);
     }
     /** delete return policy details */
     public function destroy($id)
     {
        ReturnPolicy::find($id)->delete();
         return response()->json(['success' => 'return policy details deleted successfully.']);
     }
}
