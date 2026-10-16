<?php

namespace App\Http\Controllers;

use App\Models\Sport;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\File;

class SportController extends Controller
{
    public function index() {

        if(auth()->user()->can('manage activity logs')){

            $sports = Sport::orderBy('sport_name')->where('active', 1)->get();

            return view('pages.masters.sports.index', ['sports'=>$sports]);

        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request)
    {

        if($request->has('new_profile_pic')){
            $logoImagePath = self::uploadPofilePicture($request);

            $image = $request->file('new_profile_pic');


            $imagePath = null;

            if ($request->hasFile('new_catalog_pic')) {
                $imageCatalog = $request->file('new_catalog_pic');

                $directoryPath = base_path('assets/Master/sports/');

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $originalFileName = $imageCatalog->getClientOriginalName();

                $uniqueFileName = $originalFileName;

                $imageCatalog->move($directoryPath, $uniqueFileName);

                $imagePath = 'assets/Master/sports/' . $uniqueFileName;
            }

            $imageName = $image->getClientOriginalName();

            $sports = new Sport();
            $sports->sport_name = $request->sport_name;
            $sports->sport_image = 'img/icons/sports/'.$imageName;
            $sports->catalog_image = $imagePath;
            $sports->save();

            return redirect()->route('sports')->withSuccess('Sport Saved Successfully!');

        } else {
            $logoImagePath = "assets/img/organization/default.png";


            $imagePath = null;

            if ($request->hasFile('new_catalog_pic')) {
                $imageCatalog = $request->file('new_catalog_pic');

                $directoryPath = base_path('assets/Master/sports/');

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $originalFileName = $imageCatalog->getClientOriginalName();

                $uniqueFileName = $originalFileName;

                $imageCatalog->move($directoryPath, $uniqueFileName);

                $imagePath = 'assets/Master/sports/' . $uniqueFileName;
            }

            $sports = new Sport();
            $sports->sport_name = $request->sport_name;
            $sports->catalog_image = $imagePath;
            $sports->save();

            return redirect()->route('sports')->withSuccess('Sport Saved Successfully!');
        }


    }

    public function uploadPofilePicture(Request $request) {
        $file = $request->file('new_profile_pic');

        $destinationPath = 'assets/img/icons/sports';

        $file->move($destinationPath, $file->getClientOriginalName());

        return $destinationPath.'/'.$file->getClientOriginalName();
    }

    public function edit($sportId){
        $sports = Sport::find($sportId);
        return json_encode($sports);
    }

    public function update(Request $request) {

        if($request->has('edit_profile_pic')){
            $logoImagePath = self::updatePofilePicture($request);

            $image = $request->file('edit_profile_pic');

            $imageName = $image->getClientOriginalName();

            $sports = Sport::find($request->sport_id);
            $sports->sport_name = $request->sport_edit_name;
            $sports->sport_image = 'img/icons/sports/'.$imageName;

            $imagePath = null;

            if ($request->hasFile('edit_catalog_pic')) {
                $imageCatalog = $request->file('edit_catalog_pic');

                $directoryPath = base_path('assets/Master/sports/');

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $originalFileName = $imageCatalog->getClientOriginalName();

                $uniqueFileName = $originalFileName;

                $imageCatalog->move($directoryPath, $uniqueFileName);

                $imagePath = 'assets/Master/sports/' . $uniqueFileName;

                $sports->catalog_image = $imagePath;

            }

            $sports->update();

            return redirect()->route('sports')->withSuccess('Sport Updated Successfully!');

        } else {
            $logoImagePath = "assets/img/organization/default.png";

            $sports = Sport::find($request->sport_id);
            $sports->sport_name = $request->sport_edit_name;

            $imagePath = null;

            if ($request->hasFile('edit_catalog_pic')) {
                $imageCatalog = $request->file('edit_catalog_pic');

                $directoryPath = base_path('assets/Master/sports/');

                if (!File::exists($directoryPath)) {
                    File::makeDirectory($directoryPath, 0777, true, true);
                }

                $originalFileName = $imageCatalog->getClientOriginalName();

                $uniqueFileName = $originalFileName;

                $imageCatalog->move($directoryPath, $uniqueFileName);

                $imagePath = 'assets/Master/sports/' . $uniqueFileName;

                $sports->catalog_image = $imagePath;

            }
            
            $sports->update();

            return redirect()->route('sports')->withSuccess('Sport Updated Successfully!');
        }



    }

    public function updatePofilePicture(Request $request) {
        $file = $request->file('edit_profile_pic');

        $destinationPath = 'assets/img/icons/sports';

        $file->move($destinationPath, $file->getClientOriginalName());

        return $destinationPath.'/'.$file->getClientOriginalName();
    }

    public function delete($id){
        $sports = Sport::find($id);
        $sports->active = 0;
        $sports->update();

        return redirect()->route('sports')->withSuccess('Sport Delete Successfully!');
    }
}
