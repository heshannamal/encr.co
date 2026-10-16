<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ProductTagline;
use Illuminate\Support\Facades\File;

class ProductTaglineController extends Controller
{
    public function index(){

        $productTaglines = ProductTagline::where('active', 1)->orderBy('tagline_name')->get();

        return view('pages.masters.product_taglines.index',[
                'productTaglines'=>$productTaglines
        ]);
    }

    public function create(Request $request) {
        $lastProductTagline = ProductTagline::latest('id')->first();
        $nextId = $lastProductTagline ? $lastProductTagline->id + 1 : 1;

        if ($request->hasFile('tagline_video')) {
            $video = $request->file('tagline_video');

            $originalFileName = $video->getClientOriginalName();
            $fileName = str_replace(' ', '_', $originalFileName);

            $directoryPath = base_path('assets/Master/ProductTagline/' . $nextId);

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $video->move($directoryPath, $fileName);

            $videoPath = 'assets/Master/ProductTagline/' . $nextId . '/' . $fileName;
        } else {
            $videoPath = null;
        }

        $productTaglineType = new ProductTagline();
        $productTaglineType->tagline_name = $request->new_product_tagline;
        $productTaglineType->description = $request->input('new_description', '');
        $productTaglineType->video_path = $videoPath;

        $productTaglineType->active = 1;
        $productTaglineType->save();



        return redirect()->route('product_tagline')->withSuccess('Product Tagline Saved Successfully!');
    }

    public function update(Request $request){

        $productTagline = ProductTagline::find($request->product_tagline_id);

        $videoStatus = $request->input('edit_product_tagline_video_status');

        if ($videoStatus === 'new' && $request->hasFile('edit_product_tagline_video')) {
            $video = $request->file('edit_product_tagline_video');
            $originalFileName = str_replace(' ', '_', $video->getClientOriginalName());
            $directoryPath = base_path('assets/Master/ProductTagline/' . $productTagline->id);

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $video->move($directoryPath, $originalFileName);
            $videoPath = 'assets/Master/ProductTagline/' . $productTagline->id . '/' . $originalFileName;

            $productTagline->video_path = $videoPath;
        } elseif ($videoStatus === 'remove') {
            $productTagline->video_path = null;
        }

        $productTagline->tagline_name = $request->edit_product_tagline;
        $productTagline->description = $request->edit_description;


        $productTagline->update();

        return redirect()->route('product_tagline')->withSuccess('Product Tagline Updated Successfully!');
    }

    public function edit($id){
        $productTagline = ProductTagline::where('id', $id)->first();

        if ($productTagline) {
            return response()->json($productTagline);
        } else {
            return response()->json(['error' => 'Product Tagline not found'], 404);
        }
    }

    public function delete(Request $request){
        $productTaglineId = $request->id;
        
        $productTagline = ProductTagline:: find($productTaglineId);
        $productTagline->active = 0;
        $productTagline->update();

        return response()->json(['success' => true]);
    }

}
