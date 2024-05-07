<?php

namespace App\Http\Controllers;

use App\Models\WishList;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function create_or_delete(Request $request)
    {
        $exist = WishList::where('customer_id', $request->customer_id)->where('product_id', $request->product_id)->exists();
        if ($exist) {
            WishList::where('customer_id', $request->customer_id)->where('product_id', $request->product_id)->delete();
            return response()->json(['removed' => 'Successfully removed from your wishlist','exist' => $exist]);
        } else {
            WishList::create(['customer_id' => $request->customer_id, 'product_id' => $request->product_id]);
            return response()->json(['added' => 'Successfully added on your wishlist', 'exist' => $exist]);
        }
    }
}
