<?php

namespace App\Http\Controllers;

use App\Models\Office;
use App\Models\Staff;
use App\Models\StaffAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class StaffKioskController extends Controller
{
    public function index()
    {
        $offices = Office::all();
        $staff = Staff::all();
        return view('staff_kiosk.index', compact('offices', 'staff'));
    }

    public function process(Request $request)
    {
        $request->validate([
            'office_id' => 'required|exists:offices,id',
            'staff_id' => 'required|exists:staff,id',
        ]);

        $staff = Staff::where('id', $request->staff_id)
            ->where('office_id', $request->office_id)
            ->firstOrFail();

        $today = Carbon::today();

        // Check if there is an active check-in (time_out is null) for today
        $attendance = StaffAttendance::where('staff_id', $staff->id)
            ->where('date', $today)
            ->whereNull('time_out')
            ->first();

        if ($attendance) {
            // Clock Out
            $attendance->update([
                'time_out' => Carbon::now(),
            ]);
            $action = 'out';
        } else {
            // Clock In
            StaffAttendance::create([
                'staff_id' => $staff->id,
                'date' => $today,
                'time_in' => Carbon::now(),
                'status' => 'present',
            ]);
            $action = 'in';
        }

        return redirect()->route('staff_kiosk.success')->with([
            'action' => $action,
            'staff_name' => $staff->firstName . ' ' . $staff->lastName
        ]);
    }

    public function success()
    {
        if (!session('action')) {
            return redirect()->route('staff_kiosk.index');
        }
        return view('staff_kiosk.success');
    }

    public function monitor()
    {
        $activeStaff = StaffAttendance::with(['staff.office'])
            ->whereNull('time_out')
            ->orderBy('time_in', 'desc')
            ->get();
        return view('staff_kiosk.monitor', compact('activeStaff'));
    }

    public function checkout(Request $request, $id)
    {
        $attendance = StaffAttendance::findOrFail($id);
        $attendance->update([
            'time_out' => Carbon::now(),
        ]);

        return redirect()->route('staff_kiosk.monitor')
            ->with('success', 'Staff member successfully checked out.');
    }
}
