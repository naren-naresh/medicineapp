<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;

class OrderController extends Controller
{
    public function index(){

    }

    public function store(Request $request){

         $year = date('y');
         $month = date('m');
         $data = $year."".$month."".auth()->id();
         $orderNumber = str_pad($data,12,'0',STR_PAD_RIGHT);
         return response($orderNumber);
    }
}
