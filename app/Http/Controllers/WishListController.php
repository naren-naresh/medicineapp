<?php

namespace App\Http\Controllers;

use App\Models\Category;
use App\Models\Product;
use App\Models\WishList;
use Illuminate\Http\Request;

class WishListController extends Controller
{
    public function index(){
        $data['categories'] = Category::where('parent_category_id', null)->limit(6)->get();
        $data['favProducts'] = WishList::where('customer_id',auth()->id())->get('product_id');
        $data['products'] = Product::all();
        return view('frontend.profile.my-wish-list',$data);
    }
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
    public function destroy($id){
        WishList::where('customer_id',auth()->id())->where('product_id',$id)->delete();
        return redirect()->route('wishlist.index')->with('message','address deleted successfully.');
     }
}
