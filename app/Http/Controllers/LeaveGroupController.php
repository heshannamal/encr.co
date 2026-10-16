<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\LeaveGroup;
use App\Models\LeaveGroupItem;
use Illuminate\Support\Facades\DB;

class LeaveGroupController extends Controller
{
    public function groupStore(Request $request)
    {
        $request->validate([
            'leave_group_name' => 'required|string|max:255|unique:leave_groups,name',
            'leave_days' => 'nullable|array',
            'leave_days.*' => 'nullable|integer|min:0',
        ]);

        DB::transaction(function () use ($request) {
            $group = LeaveGroup::create([
                'name' => $request->leave_group_name,
                'active' => 1
            ]);

            if ($request->has('leave_days')) {
                foreach ($request->leave_days as $typeId => $days) {
                    if ($days > 0) {
                        LeaveGroupItem::create([
                            'leave_group_id' => $group->id,
                            'leave_type_id' => $typeId,
                            'leave_days' => $days ?? 0
                        ]);
                    }
                }
            }
        });
        return redirect()->back()->with('success', 'Group Created Successfully');
    }

    public function groupUpdate(Request $request)
    {
        $request->validate(
            [
                'leave_group_name' => 'required|string|max:255|unique:leave_groups,name,' . $request->leave_group_id,
                'leave_days' => 'nullable|array',
                'leave_days.*' => 'nullable|integer|min:0',
            ],
            [
                'leave_group_name.unique' => 'This leave group name already exists.',
            ]
        );

        DB::transaction(function () use ($request) {
            // Matched to 'leave_group_id' hidden input in your Edit Modal
            $group = LeaveGroup::findOrFail($request->leave_group_id);
            $group->update(['name' => $request->leave_group_name]);

            LeaveGroupItem::where('leave_group_id', $group->id)->delete();

            if ($request->has('leave_days')) {
                foreach ($request->leave_days as $typeId => $days) {
                    if ($days > 0) {
                        LeaveGroupItem::create([
                            'leave_group_id' => $group->id,
                            'leave_type_id' => $typeId,
                            'leave_days' => $days ?? 0
                        ]);
                    }
                }
            }
        });
        return redirect()->back()->with('success', 'Group Updated Successfully');
    }

    public function groupDelete($id)
    {
        LeaveGroup::where('id', $id)->update(['active' => 0]);
        return response()->json(['success' => true]);
    }
}
// {

//     public function groupStore(Request $request)
//     {
//         DB::transaction(function () use ($request) {
//             $group = LeaveGroup::create([
//                 'name' => $request->group_name,
//                 'active' => 1
//             ]);

//             foreach ($request->leave_days as $typeId => $days) {
//                 if ($days !== null) {
//                     LeaveGroupItem::create([
//                         'leave_group_id' => $group->id,
//                         'leave_type_id' => $typeId,
//                         'leave_days' => $days ?? 0
//                     ]);
//                 }
//             }
//         });
//         return redirect()->back()->with('success', 'Group Created Successfully');
//     }

//     public function groupUpdate(Request $request)
//     {
//         DB::transaction(function () use ($request) {
//             $group = LeaveGroup::findOrFail($request->group_id);
//             $group->update(['name' => $request->group_name]);

//             // Clear old assignments and recreate
//             LeaveGroupItem::where('leave_group_id', $group->id)->delete();

//             foreach ($request->leave_days as $typeId => $days) {
//                 LeaveGroupItem::create([
//                     'leave_group_id' => $group->id,
//                     'leave_type_id' => $typeId,
//                     'leave_days' => $days ?? 0
//                 ]);
//             }
//         });
//         return redirect()->back()->with('success', 'Group Updated Successfully');
//     }

//     public function groupDelete($id)
//     {
//         LeaveGroup::where('id', $id)->update(['active' => 0]);
//         return response()->json(['success' => true]);
//     }
// }
