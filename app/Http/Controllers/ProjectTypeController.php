<?php

namespace App\Http\Controllers;

use App\Models\ProjectType;
use Illuminate\Http\Request;
use App\Http\Controllers\Controller;

class ProjectTypeController extends Controller
{
    public function index(){

        if(auth()->user()->can('manage activity logs')){

            $projectType = ProjectType::select('id', 'type_name', 'created_at')->orderBy('id')->where('active', 1)->get();
            // dd($projectType);
            return view('pages.masters.project_type.index', ['projectType'=>$projectType]);
        } else {
            return redirect()->back()->withError('Permission Not Granted!');
        }
    }

    public function create(Request $request){
        $projectType = new ProjectType();
        $projectType->type_name = $request->new_project_type_name;
        $projectType->active = 1;
        $projectType->save();

        return redirect()->route('project_type')->withSuccess('Project Type Saved Successfully!');
    }

    public function update(Request $request){
        $project = ProjectType:: find($request->type_id);
        $project->type_name = $request->edit_type_name;
        $project->update();

        return redirect()->route('project_type')->withSuccess('Project Type Updated Successfully!');
    }

    public function delete($id){
        $projectType = ProjectType::find($id);
        $projectType->active = 0;
        $projectType->update();

        return redirect()->route('project_type')->withSuccess('Project Type Delete Successfully!');
    }

}
