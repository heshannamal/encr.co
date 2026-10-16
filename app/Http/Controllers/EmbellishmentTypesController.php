<?php

namespace App\Http\Controllers;

use App\Models\ColumnLayout;
use Illuminate\Http\Request;
use App\Models\EmbellishmentType;
use App\Models\EmbellishmentTypeLayout;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\File;
use App\Models\Fabric;

class EmbellishmentTypesController extends Controller
{
    public function index(){
        if(auth()->user()->can('manage embellishment type')){
            $embellishmentTypes = EmbellishmentType::where('active', 1)->orderBy('embellishment_name')->get();

            $embellishmentLayout = EmbellishmentTypeLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 8)->where('user_id', Auth::user()->id)->first();

            $fabrics = Fabric::where('active', 1)->orderBy('fabric_name')->get();

            return view('pages.masters.embellishment_types.index',[
                'embellishmentTypes'=>$embellishmentTypes, 'embellishmentLayout'=>$embellishmentLayout, 'columnLayout'=>$columnLayout, 'fabrics'=>$fabrics
            ]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request) {
        $lastEmbellishment = EmbellishmentType::latest('id')->first();
        $nextId = $lastEmbellishment ? $lastEmbellishment->id + 1 : 1;

        if ($request->hasFile('embellishment_video')) {
            $video = $request->file('embellishment_video');

            $originalFileName = $video->getClientOriginalName();
            $fileName = str_replace(' ', '_', $originalFileName);

            $directoryPath = base_path('assets/Master/Embellishment/' . $nextId);

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $video->move($directoryPath, $fileName);

            $videoPath = 'assets/Master/Embellishment/' . $nextId . '/' . $fileName;
        } else {
            $videoPath = null;
        }
        $imagePaths = [];

        if ($request->hasFile('Embellishment_images')) {
            foreach ($request->file('Embellishment_images') as $image) {
                $directoryPath = base_path('assets/Master/Embellishment/' . $nextId);

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $originalFileName = $image->getClientOriginalName();

                $uniqueFileName = $originalFileName;
                $imagePath = $directoryPath . '/' . $uniqueFileName;

                $image->move($directoryPath, $uniqueFileName);

                $imagePaths[] = 'assets/Master/Embellishment/' . $nextId . '/' . $uniqueFileName;
            }
        }

        $embellishmentType = new EmbellishmentType();
        $embellishmentType->image_1 = $imagePaths[0] ?? null;
        $embellishmentType->image_2 = $imagePaths[1] ?? null;
        $embellishmentType->image_3 = $imagePaths[2] ?? null;
        $embellishmentType->image_4 = $imagePaths[3] ?? null;
        $embellishmentType->embellishment_name = $request->new_embellishment_types;
        $embellishmentType->description = $request->input('new_description', '');
        $embellishmentType->fabrics = json_encode($request->fabrics_select ?? null);
        $embellishmentType->video_path = $videoPath;

        if ($request->new_embellishment_type_price != "") {
            $embellishmentType->price = $request->new_embellishment_type_price;
        }

        $embellishmentType->active = 1;
        $embellishmentType->save();

        return redirect()->route('embellishment_types')->withSuccess('Embellishment Type Saved Successfully!');
    }


    public function delete($id){
        $embellishmentType = EmbellishmentType:: find($id);
        $embellishmentType->active = 0;
        $embellishmentType->update();

        return redirect()->route('embellishment_types')->withSuccess('Embellishment Type Delete Successfully!');
    }

     public function edit($id){
        $embellishmentType = EmbellishmentType::find($id);
        return json_encode($embellishmentType);
    }

    public function update(Request $request){

        $embellishmentType = EmbellishmentType::find($request->embellishment_type_id);

        $videoStatus = $request->input('edit_embellishment_video_status');

        if ($videoStatus === 'new' && $request->hasFile('edit_embellishment_video')) {
            $video = $request->file('edit_embellishment_video');
            $originalFileName = str_replace(' ', '_', $video->getClientOriginalName());
            $directoryPath = base_path('assets/Master/Embellishment/' . $embellishmentType->id);

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $video->move($directoryPath, $originalFileName);
            $videoPath = 'assets/Master/Embellishment/' . $embellishmentType->id . '/' . $originalFileName;

            $embellishmentType->video_path = $videoPath;
        } elseif ($videoStatus === 'remove') {
            $embellishmentType->video_path = null;
        }

            $imagePaths = [];

            if ($request->hasFile('edit_Embellishment_images')) {
                foreach ($request->file('edit_Embellishment_images') as $image) {
                    $directoryPath = base_path('assets/Master/Embellishment/' . $embellishmentType->id);

                    if (!File::exists($directoryPath)) {
                        File::makeDirectory($directoryPath, 0777, true, true);
                    }

                    $originalFileName = $image->getClientOriginalName();
                    $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);
                    $fileExtension = $image->getClientOriginalExtension();

                    $uniqueFileName = $originalFileName;
                    $imagePath = $directoryPath . '/' . $uniqueFileName;
                    $image->move($directoryPath, $uniqueFileName);
                    $imagePaths[] = 'assets/Master/Embellishment/' . $embellishmentType->id . '/' . $uniqueFileName;
                }
            }

            $existingImages = $request->input('existing_images', []);
            $allImages = array_merge($existingImages, $imagePaths);

            $embellishmentType->image_1 = $allImages[0] ?? null;
            $embellishmentType->image_2 = $allImages[1] ?? null;
            $embellishmentType->image_3 = $allImages[2] ?? null;
            $embellishmentType->image_4 = $allImages[3] ?? null;

        $embellishmentType->embellishment_name = $request->edit_embellishment_types;
        $embellishmentType->price = $request->edit_embellishment_type_price;
        $embellishmentType->description = $request->edit_description;
        $embellishmentType->fabrics = json_encode($request->fabrics_select ?? null);

        if($request->edit_embellishment_type_price!=""){
            $embellishmentType->price = $request->edit_embellishment_type_price;
        }

        $embellishmentType->update();

        return redirect()->route('embellishment_types')->withSuccess('Embellishment Type Updated Successfully!');
    }

    public function sortApphabet($id){
        $embellishmentType = EmbellishmentType::where('embellishment_name', 'LIKE', $id.'%')->where('active', 1)->get();
        return json_encode($embellishmentType);
    }

    public function layout(Request $request){
        if(EmbellishmentTypeLayout::where('user_id', Auth::user()->id)->first()){
            $embellishmentLayout = EmbellishmentTypeLayout::find($request->layout_id);
            $embellishmentLayout->embellishment_name = $request->embellishment_name;
            $embellishmentLayout->created = $request->created_at;
            $embellishmentLayout->updated = $request->updated_at;
            $embellishmentLayout->update();

            $successMsg = "Updated";

        } else {
            $embellishmentLayout = new EmbellishmentTypeLayout();
            $embellishmentLayout->user_id = Auth::user()->id;
            $embellishmentLayout->embellishment_name = 1;
            $embellishmentLayout->created = 1;
            $embellishmentLayout->updated = 1;
            $embellishmentLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }
}
