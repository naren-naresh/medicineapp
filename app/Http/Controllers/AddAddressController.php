<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use Illuminate\Http\Request;

class AddAddressController extends Controller
{
    public function index(){
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        $data['addresses'] = Address::where('customer_id',auth()->id())->orderBy('set_default','Desc')->get();
        return view('frontend.profile.index-page',$data);
    }

    public function create(){
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        return view('frontend.profile.add-address',$data);
    }

    public function store(Request $request){
        Address::create(['name' => $request->name ,'customer_id' => $request->customer_id,'address' => $request->address,'notes' => $request->notes,'postal_code' => $request->postal_code,'contact_number' => $request->number]);
        return redirect()->route('address.index')->with('message','address add successfully.');
    }

    public function edit($id){
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        $data['addresses'] = Address::where('customer_id',auth()->id())->where('id',$id)->get();
        return view('frontend.profile.edit-page',$data);
    }

    public function update(Request $request,$id){
        Address::where('id',$id)->where('customer_id',$request->customer_id)->update(['name' => $request->name ,'address' => $request->address,'notes' => $request->notes,'postal_code' => $request->postal_code,'contact_number' => $request->number]);
        return redirect()->route('address.index')->with('message','address updated successfully.');
    }

    public function default($id){
        Address::where('customer_id',auth()->id())->update(['set_default' => 0]);
        Address::where('id',$id)->where('customer_id',auth()->id())->update(['set_default' => 1]);
        return redirect()->route('address.index')->with('message','address updated successfully.');
    }

    public function destroy($id){
       Address::where('id',$id)->delete();
       return redirect()->route('address.index')->with('message','address deleted successfully.');
    }
}
