<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Category;
use Illuminate\Support\Facades\Auth;
use Yajra\DataTables\DataTables;



class CategoryController extends Controller
{
    /** showing categories table with datatables */
    public function index(Request $request)
    {
        $data['categories'] = Category::whereNull('parent_category_id')->get();
        if ($request->ajax()) {
            $categories = Category::latest()->get() ?? [];
            return DataTables::of($categories)
                ->addIndexColumn()
                ->addColumn('name', function ($category) {
                    return $category->name;
                })
                ->addColumn('parent_category_id', function ($category) {
                    $check=Category::with('children')->find($category->parent_category_id);
                    return $check->name ?? '-';
                })
                ->addColumn('status', function ($category) {
                    return ($category->status != 0) ? '<span class=" badge bg-success">Active</span>' : '<span class=" badge bg-danger">InActive</span>';
                })
                ->addColumn('image', function ($category) {
                    return($category->image !='') ? '<img src="assets/images/'.$category->image.'">':'<img src="assets/images/woocommerce-placeholder.webp" style="width:50px">';
                })
                ->addColumn('created_by', function ($category) {
                    $username = Category::find(1)->user->name;
                    return $username ?? '-';
                })
                ->addColumn('action', function ($category) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $category->id . '" data-original-title="Edit" class="edit btn  btn-sm editProduct">Edit</a>
                            <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $category->id . '" data-original-title="Delete" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['name', 'parent_category', 'status', 'image', 'created_by', 'action'])
                ->make(true);
        }

        return view('admin.products-category.index', $data);
    }
  /** update or create category */
    public function store(Request $request)
    {
        $request->validate([
            'cname' => 'required',
            'status' => 'required',
        ]);
        $oldimage=Category::where('id',$request->id)->value('image');
        if ($request->hasFile('img')) {
            $imageName = time() . "." . $request->file("img")->extension();
            $request->img->move(public_path('/assets/images'), $imageName);
            unlink(public_path('assets/images/'.$oldimage));
        } else {
            $imageName = $oldimage;
        }
        Category::updateOrCreate([
            'id' => $request->id
        ], ['name' => $request->cname, 'parent_category_id' => $request->pcategory, 'status' => $request->status, 'image' => $imageName, 'created_by' => Auth::user()->id]);
        return response()->json(['success' => 'Product saved successfully.']);
    }
   /** edit category */
    public function edit($id)
    {
        $productcategory = Category::find($id);
        return response()->json($productcategory);
    }
   /** delete category */
    public function destroy($id)
    {
        Category::find($id)->delete();
        return response()->json(['success' => 'Product deleted successfully.']);
    }
}
