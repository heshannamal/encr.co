<?php

namespace App\Http\Controllers;

use App\Models\ColumnLayout;
use Illuminate\Http\Request;
use App\Models\Fabric;
use App\Models\FabricLayout;
use Illuminate\Support\Facades\Auth;
use App\Models\EmbellishmentType;
use Illuminate\Support\Facades\File;

class FabricController extends Controller
{
    public function index(){
        if(auth()->user()->can('manage fabric')){
            $fabrics = Fabric::where('active', 1)->orderBy('fabric_name')->get();

            $fabricLayout = FabricLayout::where('user_id', Auth::user()->id)->first();

            $columnLayout = ColumnLayout::where('interface_id', 4)->where('user_id', Auth::user()->id)->first();

            $embellishmentTypes = EmbellishmentType::where('active', 1)->orderBy('embellishment_name')->get();

            return view('pages.masters.fabrics.index', ['fabrics'=>$fabrics, 'fabricLayout'=>$fabricLayout, 'columnLayout'=>$columnLayout, 'embellishmentTypes'=>$embellishmentTypes]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request)
    {
        $imagePaths = [];

        $lastFabric = Fabric::latest('id')->first();
        $nextId = $lastFabric ? $lastFabric->id + 1 : 1;

        if ($request->hasFile('fabric_images')) {
            foreach ($request->file('fabric_images') as $image) {
                $directoryPath = base_path('assets/Master/Fabrics/' . $nextId);

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $originalFileName = $image->getClientOriginalName();

                $uniqueFileName = $originalFileName;
                $imagePath = $directoryPath . '/' . $uniqueFileName;

                $image->move($directoryPath, $uniqueFileName);

                $imagePaths[] = 'assets/Master/Fabrics/' . $nextId . '/' . $uniqueFileName;
            }
        }
        $colors = [];
        if($request->add_fabric_colors){

            foreach ($request->add_fabric_colors as $index => $code) {
                $colors[] = [
                    'code' => $code,
                    'name' => $request->add_fabric_color_names[$index] ?? '',
                ];
            }
        }

        $fabric = new Fabric();
        $fabric->image_1 = $imagePaths[0] ?? null;
        $fabric->image_2 = $imagePaths[1] ?? null;
        $fabric->image_3 = $imagePaths[2] ?? null;
        $fabric->image_4 = $imagePaths[3] ?? null;
        $fabric->image_5 = $imagePaths[4] ?? null;

        $fabric->fabric_name = $request->new_fabric_name;
        $fabric->colors = json_encode($colors);
        $fabric->embellishments = json_encode($request->embellishments_select ?? null);
        $fabric->description = $request->input('new_description', '');
        $fabric->active = 1;

        $fabric->save();

        return redirect()->route('fabrics')->withSuccess('Fabric Saved Successfully!');
    }


    public function delete($id){
        $fabric = Fabric::find($id);
        $fabric->active = 0;
        $fabric->update();

        return redirect()->route('fabrics')->withSuccess('Fabric Deleted Successfully!');
    }

    public function edit($id)
    {
        $fabric = Fabric::findOrFail($id); // Ensure it retrieves the fabric or throws a 404 error


        return response()->json([
            'fabric_name' => $fabric->fabric_name,
            'description' => $fabric->description,
            'colors' => json_decode($fabric->colors ?? '[]'),
            'embellishmentTypes'=>json_decode($fabric->embellishments ?? '[]'),
            'images' => [
                $fabric->image_1,
                $fabric->image_2,
                $fabric->image_3,
                $fabric->image_4,
                $fabric->image_5
            ]
        ]);
    }

    public function update(Request $request)
    {
        if(auth()->user()->can('edit fabrics')){

            $fabric = Fabric::findOrFail($request->fabric_id);
            $colors = [];
            if($request->fabric_colors){

                foreach ($request->fabric_colors as $index => $code) {
                    $colors[] = [
                        'code' => $code,
                        'name' => $request->fabric_color_names[$index] ?? '',
                    ];
                }
            }

            $imagePaths = [];

            if ($request->hasFile('edit_fabric_images')) {
                foreach ($request->file('edit_fabric_images') as $image) {
                    $directoryPath = base_path('assets/Master/Fabrics/' . $request->fabric_id);

                    if (!File::exists($directoryPath)) {
                        File::makeDirectory($directoryPath, 0777, true, true);
                    }

                    $originalFileName = $image->getClientOriginalName();
                    $fileName = pathinfo($originalFileName, PATHINFO_FILENAME);
                    $fileExtension = $image->getClientOriginalExtension();

                    $uniqueFileName = $originalFileName;
                    $imagePath = $directoryPath . '/' . $uniqueFileName;
                    $image->move($directoryPath, $uniqueFileName);
                    $imagePaths[] = 'assets/Master/Fabrics/' . $request->fabric_id . '/' . $uniqueFileName;
                }
            }

            $existingImages = $request->input('existing_images', []);
            $allImages = array_merge($existingImages, $imagePaths);

            $fabric->image_1 = $allImages[0] ?? null;
            $fabric->image_2 = $allImages[1] ?? null;
            $fabric->image_3 = $allImages[2] ?? null;
            $fabric->image_4 = $allImages[3] ?? null;
            $fabric->image_5 = $allImages[4] ?? null;

            $fabric->fabric_name = $request->edit_fabric_name;
            $fabric->colors = json_encode($colors);
            $fabric->embellishments = json_encode($request->embellishments_select);
            $fabric->description = $request->input('edit_description', '');

            $fabric->save();

            return redirect()->route('fabrics')->withSuccess('Fabric Updated Successfully!');
        }else{
            if(auth()->user()->can('edit fabric description')){
                $fabric = Fabric::findOrFail($request->fabric_id);
                if($fabric){
                    $fabric->description = $request->input('edit_description', '');
                    $fabric->save();
                    return redirect()->route('fabrics')->withSuccess('Fabric Updated Successfully!');
                }else{
                    return redirect()->route('fabrics')->withError('Fabric Not Found!');
                }
            }else{
                return redirect()->route('fabrics')->withError('Permission Not Granted!');
            }
        }
    }


    public function sortApphabet($id){
        $fabric = Fabric::where('fabric_name', 'LIKE', $id.'%')->get();

        return json_encode($fabric);
    }

    public function layout(Request $request){
        if(FabricLayout::where('user_id', Auth::user()->id)->first()){
            $fabricLayout = FabricLayout::find($request->layout_id);
            $fabricLayout->fabric_name = $request->fabric_name;
            $fabricLayout->created = $request->created_at;
            $fabricLayout->updated = $request->updated_at;
            $fabricLayout->update();

            $successMsg = "Updated";

        } else {
            $fabricLayout = new FabricLayout();
            $fabricLayout->user_id = Auth::user()->id;
            $fabricLayout->fabric_name = 1;
            $fabricLayout->created = 1;
            $fabricLayout->updated = 1;
            $fabricLayout->save();

            $successMsg = "Saved";
        }

        return json_encode($successMsg);
    }
}
