<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\LeadSource;
use App\Models\Organization;
use Maatwebsite\Excel\Facades\Excel;

class LeadSourceController extends Controller
{
    public function index(){

            $lead_sources = LeadSource::where('active', 1)->orderBy('lead_source_name')->get();

            return view('pages.masters.lead_sources.index', ['lead_sources'=>$lead_sources,]);
    }

    public function create(Request $request){
        $lead_source = new LeadSource();
        $lead_source->lead_source_name = $request->lead_source_name;
        $lead_source->active = 1;
        $lead_source->save();

        return redirect()->route('lead_sources')->withSuccess('Lead Source Saved Successfully!');
    }

    public function delete($id){
        $lead_source = LeadSource::find($id);
        $lead_source->active = 0;
        $lead_source->update();

        return redirect()->route('lead_sources')->withSuccess('Lead Source Deleted Successfully!');
    }

    public function edit($id){
        $lead_sources = LeadSource::orderBy('lead_source_name')->find($id);
        return json_encode($lead_sources);
    }

    public function update(Request $request){
        $lead_source = LeadSource::find($request->lead_source_id);
        $lead_source->lead_source_name = $request->edit_lead_source_name;
        $lead_source->update();

        return redirect()->route('lead_sources')->withSuccess('Lead Source Updated Successfully!');
    }

    public function update_organization_source(){
        $lead_sources = LeadSource::where('active', 1)->orderBy('lead_source_name')->get();

        return view('pages.masters.lead_sources.upload_organization_list', ['lead_sources'=>$lead_sources,]);
    }

    public function update_organization(Request $request)
    {

        $file = $request->file('updated_organization_list');
        $rows = \Maatwebsite\Excel\Facades\Excel::toArray([], $file)[0];

        $header = array_map('trim', $rows[0]);
        unset($rows[0]);

        $updated = 0;
        $notFoundOrganizations = [];
        $notFoundLeadSources = [];

        foreach ($rows as $row) {

            $data = array_combine($header, $row);

            $organizationName = trim($data['ORGANIZATION NAME'] ?? '');
            $correctedLeadSource = trim($data['CORRECTED LEAD SOURCE'] ?? '');

            if (!$organizationName || !$correctedLeadSource) continue;

            $organization = Organization::whereRaw(
                'LOWER(organization_name) = ?',
                [strtolower($organizationName)]
            )->first();

            if (!$organization) {
                $notFoundOrganizations[] = $organizationName;
                continue;
            }

            $leadSource = LeadSource::whereRaw(
                'LOWER(lead_source_name) = ?',
                [strtolower($correctedLeadSource)]
            )->first();

            if (!$leadSource) {
                $notFoundLeadSources[] = $correctedLeadSource;
                continue;
            }

            $organization->lead_source = $leadSource->id;
            $organization->save();

            $updated++;
        }

        return response()->json([
            'message' => "$updated organizations updated successfully.",
            'not_found_organizations' => $notFoundOrganizations,
            'not_found_lead_sources' => $notFoundLeadSources
        ]);
    }
}
