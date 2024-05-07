<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Illuminate\Support\Facades\Auth;

class Product extends Model
{
    use HasFactory, SoftDeletes;
    protected $dates = ['deleted_at'];
    protected  $guarded = [];
   
    public function checkFavorite(){
        if (Auth::check()) {
           return WishList::where('product_id',$this->id)->where('customer_id',auth()->id())->exists();
        }else{
            return false;
        }
    }
}
