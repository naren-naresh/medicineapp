<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class CartController extends Controller
{
    public function index(Request $request){
       if ($request->ajax()) {
          dd($request->all());
          return response()->json(['data'=>$request->variants_data]);
       }
    }
}
