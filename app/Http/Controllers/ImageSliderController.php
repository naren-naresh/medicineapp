<?php

namespace App\Http\Controllers;

use App\Models\SliderImage;
use Illuminate\Http\Request;
use Yajra\DataTables\DataTables;

class ImageSliderController extends Controller
{
    public function index(Request $request)
    {
        if ($request->ajax()) {
            $sliderImages = SliderImage::latest()->get() ?? [];
            return DataTables::of($sliderImages)
                ->addIndexColumn()
                ->addColumn('image', function ($slideImage) {
                    return($slideImage->image !='') ? '<img src="assets/images/sliderimages/'.$slideImage->image.'" style="width:50px">':'<img src="assets/images/woocommerce-placeholder.webp" style="width:50px">';
                })
                ->addColumn('heading', function ($slideImage) {
                    return $slideImage->heading;
                })
                ->addColumn('content', function ($slideImage) {
                    return $slideImage->content;
                })
                ->addColumn('link', function ($slideImage) {
                    return $slideImage->link;
                })
                ->addColumn('action', function ($slideImage) {
                    $btn = '<a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $slideImage->id . '" data-original-title="Edit" class="edit btn  btn-sm editProduct">Edit</a>
                        <a href="javascript:void(0)" data-toggle="tooltip"  data-id="' . $slideImage->id . '" data-original-title="Delete" class="btn btn-sm deleteProduct">Delete</a>';
                    return $btn;
                })
                ->rawColumns(['image','heading','content','link','action'])
                ->make(true);
        }
        return view('admin.silderimages.index');
    }
    // create or update return slider images
    public function store(Request $request)
    {
        $request->validate([
            'image' => 'required',
        ]);
        $oldimage = SliderImage::where('id', $request->id)->value('image');
        if ($request->hasFile('image')) {
            $imageName = time() . "." . $request->file("image")->extension();
            $request->image->move(public_path('/assets/images/sliderimages'), $imageName);
            if ($oldimage) {
                unlink(public_path('/assets/images/sliderimages/' . $oldimage));
            }
        } else {
            $imageName = $oldimage;
        }
        SliderImage::updateOrCreate([
            'id' => $request->id
        ], ['image' => $imageName,'heading' => $request->heading,'content' => $request->content,'link' => $request->link]);
        return response()->json(['success' => 'Return policy saved successfully.']);
    }
    /** edit return slider images */
    public function edit($id)
    {
        $policyData = SliderImage::find($id);
        return response()->json($policyData);
    }
    /** delete return slider images */
    public function destroy($id)
    {
        SliderImage::find($id)->delete();
        return response()->json(['success' => 'return policy details deleted successfully.']);
    }
}
