<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\User;
use App\Models\UserLeave;
use App\Models\LeaveGroup;
use App\Models\LeaveGroupItem;
use App\Models\LeaveType;
use Illuminate\Support\Facades\Auth;
use Carbon\Carbon;

class HRAdminLeaveController extends Controller
{
    /**
     * Return all active employees for the dropdown.
     * GET /admin-leave/get-employees
     */
    public function getEmployees()
    {
        $employees = User::where('active', 1)
            ->orderBy('name')
            ->get(['id', 'name']);

        return response()->json(['employees' => $employees]);
    }

    /**
     * Return leave types available to a specific user (via their leave group).
     * GET /admin-leave/get-user-leave-types?user_id=X
     */
    public function getUserLeaveTypes(Request $request)
    {
        $request->validate(['user_id' => 'required|integer|exists:users,id']);

        $user = User::with('userDetails')->findOrFail($request->user_id);

        // Get the leave group assigned to this user
        $leaveGroupId = optional($user->userDetails)->leavetype_id;

        if (!$leaveGroupId) {
            return response()->json([
                'leave_types' => [],
                'balance'     => 'No leave group assigned',
            ]);
        }

        // Fetch leave group items (leave type + days)
        $items = LeaveGroupItem::with('leaveType')
            ->where('leave_group_id', $leaveGroupId)
            ->get();

        $leaveTypes = $items->map(function ($item) {
            return [
                'id'         => $item->leave_type_id,
                'name'       => optional($item->leaveType)->name ?? 'Unknown',
                'leave_days' => $item->leave_days,
            ];
        });

        // Build a brief balance summary
        $balanceParts = $leaveTypes->map(function ($lt) {
            return $lt['name'] . ': ' . $lt['leave_days'] . 'd';
        })->implode(' | ');

        return response()->json([
            'leave_types' => $leaveTypes,
            'balance'     => $balanceParts,
        ]);
    }

    /**
     * Store a past leave record with status = 1 (Approved).
     * POST /admin-leave/store
     */
    public function store(Request $request)
    {
        $request->validate([
            'user_id'    => 'required|integer|exists:users,id',
            'title'      => 'required|string|max:255',
            'leave_type' => 'required|string|max:100',
            'day_type'   => 'required|in:half_day,one_day,multiple_days,short_leave',
            'note'       => 'nullable|string|max:1000',
        ]);

        $dayType = $request->day_type;

        // ── Build UserLeave based on day type ──────────────────────────
        $leave             = new UserLeave();
        $leave->user_id    = $request->user_id;
        $leave->title      = $request->title;
        $leave->leave_type = $request->leave_type;
        $leave->request_note = $request->note ?? '';
        $leave->status     = 1;   // Approved
        $leave->active     = 1;

        if ($dayType === 'half_day') {
            $request->validate([
                'date'      => 'required|string',
                'half_time' => 'required|in:0,1',
            ]);
            // Validate date format mm/dd/yyyy
            $this->assertDateFormat($request->date);

            $leave->start_date = $request->date;
            $leave->day_type   = (int) $request->half_time;
            $leave->type       = 0;
        } elseif ($dayType === 'one_day') {
            $request->validate(['date' => 'required|string']);
            $this->assertDateFormat($request->date);

            $leave->start_date = $request->date;
            $leave->type       = 1;
        } elseif ($dayType === 'multiple_days') {
            $request->validate([
                'from_date' => 'required|string',
                'to_date'   => 'required|string',
            ]);
            $this->assertDateFormat($request->from_date);
            $this->assertDateFormat($request->to_date);

            $from = Carbon::createFromFormat('m/d/Y', $request->from_date);
            $to   = Carbon::createFromFormat('m/d/Y', $request->to_date);

            if ($to->lt($from)) {
                return response()->json([
                    'success' => false,
                    'message' => 'End date must be on or after start date.',
                ], 422);
            }

            $leave->start_date = $request->from_date;
            $leave->end_date   = $request->to_date;
            $leave->type       = 2;
        } elseif ($dayType === 'short_leave') {
            $request->validate([
                'date'       => 'required|string',
                'short_from' => 'required|date_format:H:i',
                'short_to'   => 'required|date_format:H:i|after:short_from',
            ]);
            $this->assertDateFormat($request->date);

            $leave->start_date      = $request->date;
            $leave->short_from_time = $request->short_from;
            $leave->short_to_time   = $request->short_to;
            $leave->type            = 3;
        }

        $leave->save();

        return response()->json([
            'success' => true,
            'message' => 'Leave saved as Approved.',
            'leave_id' => $leave->id,
        ]);
    }

    // ── Private helper ───────────────────────────────────────────────
    private function assertDateFormat(string $date): void
    {
        if (!preg_match('/^\d{2}\/\d{2}\/\d{4}$/', $date)) {
            abort(422, 'Invalid date format. Expected mm/dd/yyyy, got: ' . $date);
        }
    }
}
