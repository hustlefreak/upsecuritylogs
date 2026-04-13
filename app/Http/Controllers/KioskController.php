<?php

namespace App\Http\Controllers;

use App\Models\Visitor;
use App\Models\Office;
use App\Models\Staff;
use App\Models\VisitorAttendance;
use Carbon\Carbon;
use Illuminate\Http\Request;

class KioskController extends Controller
{
    // Show the public visitor fill out form
    public function index()
    {
        $offices = Office::all();
        $staff = Staff::all();
        return view('kiosk.index', compact('offices', 'staff'));
    }

    // Handle the submission of the form
    public function store(Request $request)
    {
        $request->validate([
            'firstName' => 'required|string|max:255',
            'lastName' => 'required|string|max:255',
            'phone' => 'nullable|string',
            'company' => 'nullable|string',
            'id_number' => 'nullable|string',
            'reason_for_visit' => 'required|string|max:500',
            'office_id' => 'nullable|exists:offices,id',
            'staff_to_visit' => 'nullable|exists:staff,id',
            'person_to_visit_name' => 'nullable|string|max:255',
        ]);

        // 1. Find or create the visitor based on Name and Phone (to avoid duplicates)
        // If phone is missing, it just checks first and last name.
        $visitor = Visitor::firstOrCreate(
            [
                'firstName' => $request->firstName,
                'lastName' => $request->lastName,
                'phone' => $request->phone,
            ],
            [
                'company' => $request->company,
                'id_number' => $request->id_number,
                'reason_for_visit' => $request->reason_for_visit,
            ]
        );
        
        // Update reason for visit if they are a returning visitor
        if (!$visitor->wasRecentlyCreated) {
            $visitor->update(['reason_for_visit' => $request->reason_for_visit]);
        }

        // 2. Automatically log them into the active attendance log
        VisitorAttendance::create([
            'visitor_id' => $visitor->id,
            'office_id' => $request->office_id,
            'staff_to_visit' => $request->staff_to_visit,
            'person_to_visit_name' => $request->person_to_visit_name,
            'purpose' => $request->reason_for_visit,
            'time_in' => Carbon::now()
        ]);

        return redirect()->route('kiosk.success');
    }

    public function success()
    {
        return view('kiosk.success');
    }

    public function monitor()
    {
        $activeVisitors = VisitorAttendance::with(['visitor', 'office', 'staff'])
            ->whereNull('time_out')
            ->orderBy('time_in', 'desc')
            ->get();
        return view('kiosk.monitor', compact('activeVisitors'));
    }

    public function checkout(Request $request, $id)
    {
        $attendance = VisitorAttendance::findOrFail($id);
        $attendance->update([
            'time_out' => Carbon::now(),
        ]);
        
        return redirect()->route('kiosk.monitor')->with('success', 'Visitor checked out successfully.');
    }
}
