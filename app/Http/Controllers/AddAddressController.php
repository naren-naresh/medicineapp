<?php

namespace App\Http\Controllers;

use App\Models\Address;
use App\Models\Category;
use Illuminate\Http\Request;

class AddAddressController extends Controller
{
    public function index(){
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        $data['addresses'] = Address::where('customer_id',auth()->id())->get();
        // dd($data['addresses']);
        return view('frontend.profile.index-page',$data);
    }
    public function create(){
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        return view('frontend.profile.add-address',$data);
    }
    public function store(Request $request){
        Address::create(['customer_id' => $request->customer_id,'address' => $request->address,'postal_code' => $request->postal_code,'contact_number' => $request->number]);
        return redirect()->route('address.index')->with('message','address add successfully.');
    }
    public function show($id){
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        $data['addresses'] = Address::where('customer_id',auth()->id())->where('id',$id)->get();
        return view('frontend.profile.edit-page',$data);
    }
    public function edit(){

    }
    public function update(){

    }
    public function destroy(){

    }
}
