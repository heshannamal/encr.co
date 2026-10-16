<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\ThemeSetting;

class ThemeSettingController extends Controller
{
    public function index(){

        $themeActions = ThemeSetting::where('active', 1)->get();

        return view('pages.masters.theme_setting.index',[
            'themeActions'=>$themeActions
        ]);
    }

    public function create(Request $request){

        $themeAction = $request->has('themeActionToggle') ? true : false;

        $themeSetting = new ThemeSetting();
        $themeSetting->theme_name = $request->new_theme_setting_name;

        $themeSetting->action = $themeAction ? 1 : 0;

        $themeSetting->save();

        return redirect()->route('theme_setting')->withSuccess('Theme Setting Saved Successfully!');
    }

    public function edit($id)
    {
        $themeSetting = ThemeSetting::findOrFail($id);

        return response()->json([
            'theme_name' => $themeSetting->theme_name,
            'themeActionToggle' => $themeSetting->action,
        ]);
    }

    public function update(Request $request){
        $themeAction = $request->has('themeActionToggleEdit') ? true : false;
        $themeSetting = ThemeSetting::find($request->theme_setting_id);

        $themeSetting->theme_name = $request->edit_theme_setting;
        $themeSetting->action = $themeAction ? 1 : 0;


        $themeSetting->update();

        return redirect()->route('theme_setting')->withSuccess('Theme Setting Updated Successfully!');
    }

    public function delete(Request $request){
        $themeSettingId = $request->id;

        $themeSetting = ThemeSetting:: find($themeSettingId);
        $themeSetting->active = 0;
        $themeSetting->update();

        return response()->json(['success' => true]);
    }

}
