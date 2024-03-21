<?php

namespace App\Http\Controllers;

use App\Models\Customer;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class CustomerController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $customers = Customer::latest()->get() ?? [];
            return DataTables::of($customers)
            ->addIndexColumn()
            ->addColumn('image', function ($customer) {
                return($customer->image !='') ? '<img src="assets/images/products/'.$customer->id.'/'.$customer->image.'" style="width:50px">':'<img src="assets/images/woocommerce-placeholder.webp" style="width:50px">';
            })
            ->addColumn('first_name', function ($customer) {
                return $customer->first_name;
            })
            ->addColumn('last_name', function ($customer) {
                return $customer->last_name ?? '-';
            })
            ->addColumn('email', function ($customer) {
                return $customer->email;
            })
            ->addColumn('phone_number', function ($customer) {
                return $customer->phone_number;
            })
            ->addColumn('gender', function ($customer) {
                return $customer->gender ?? '-';
            })
            ->addColumn('dob', function ($customer) {
                return $customer->dob;
            })
            ->addColumn('action', function ($customer) {
                $toggleSwitch = '<input type="checkbox" id="toggle_' . $customer->id . '" class="toggle-switch" data-toggle="toggle" data-on="Block" data-off="UnBlock"  data-onstyle="danger" data-offstyle="success" ' . ($customer->is_blocked ? 'checked' : '') . '>';
                return $toggleSwitch;
            })
            ->rawColumns(['image', 'first_name', 'last_name','email', 'phone_number','gender', 'dob', 'action'])
            ->make(true);
        }
        return view('admin.customer.index');
    }
}
