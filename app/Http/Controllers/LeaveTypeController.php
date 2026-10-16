<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\LeaveType;
use Illuminate\Http\Request;

class LeaveTypeController extends Controller
{

    // Create Master Leave Type
    public function storeMasterLeaveType(Request $request)
    {
        $request->validate([
            'leave_type_name' => 'required|string|max:100|unique:leave_types,name',
        ]);

        LeaveType::create([
            'name' => $request->leave_type_name,
            'active' => 1
        ]);

        return redirect()->back()->with('success', 'Master Leave Type created!');
        // return redirect()->back()->with('success', 'Leave type created successfully!');
    }

    // Update Master Leave Type
    public function updateMasterLeaveType(Request $request)
    {
        $request->validate([
            'leave_type_id' => 'required|exists:leave_types,id',
            'leave_type_name' => 'required|string|max:100|unique:leave_types,name,' . $request->leave_type_id,
        ]);

        $leaveType = LeaveType::find($request->leave_type_id);
        $leaveType->update(['name' => $request->leave_type_name]);

        return redirect()->back()->with('success', 'Leave Type updated!');
    }

    // Deactivate (Soft Delete)
    public function deleteMasterLeaveType($id)
    {
        $leaveType = LeaveType::find($id);
        if ($leaveType) {
            $leaveType->active = 0; // Status change instead of DB delete
            $leaveType->save();
            return response()->json(['success' => 'Type deactivated.']);
        }
        return response()->json(['error' => 'Not found.'], 404);
    }
}
