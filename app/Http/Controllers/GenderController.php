<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use App\Models\Gender;

class GenderController extends Controller
{
    public function index(){
        $genders = Gender::get();

        return view('pages.masters.gender.index',[ 'genders'=>$genders
        ]);
    }

    public function create(Request $request){

        $imagePath = null;

        if ($request->hasFile('new_profile_pic')) {
            $image = $request->file('new_profile_pic');

            $directoryPath = base_path('assets/Master/gender/');

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $originalFileName = $image->getClientOriginalName();

            $uniqueFileName = $originalFileName;

            $image->move($directoryPath, $uniqueFileName);

            $imagePath = 'assets/Master/gender/' . $uniqueFileName;
            // dd($imagePath);
        }

        $genders = new Gender();
        $genders->gender_name = $request->new_gender_name;
        $genders->gender_image = $imagePath;
        $genders->save();

        return redirect()->route('master_gender')->withSuccess('Gender Saved Successfully!');
    }

    public function edit($id){
        $genders = Gender::where('id', $id)->first();

        if ($genders) {
            return response()->json($genders);
        } else {
            return response()->json(['error' => 'Product Tagline not found'], 404);
        }
    }

    public function update(Request $request){
// dd($request);
        $genders = Gender::find($request->gender_id);
        $genders->gender_name = $request->edit_gender_name;


        $imagePath = null;

        if ($request->hasFile('edit_profile_pic')) {
            $image = $request->file('edit_profile_pic');

            $directoryPath = base_path('assets/Master/gender/');

            if (!File::exists($directoryPath)) {
                File::makeDirectory($directoryPath, 0777, true, true);
            }

            $originalFileName = $image->getClientOriginalName();

            $uniqueFileName = $originalFileName;

            $image->move($directoryPath, $uniqueFileName);

            $imagePath = 'assets/Master/gender/' . $uniqueFileName;

            $genders->gender_image = $imagePath;

        }

        $genders->update();

        return redirect()->route('master_gender')->withSuccess('Gender Updated Successfully!');
    }

    public function delete($id){
        $gender = Gender::find($id);
        $gender->delete();

        return redirect()->route('master_gender')->withSuccess('Gender Delete Successfully!');

    }
}
