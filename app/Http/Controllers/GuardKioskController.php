<?php

namespace App\Http\Controllers;

use App\Models\Guard;
use App\Models\ShiftReport;
use Illuminate\Http\Request;
use Carbon\Carbon;

class GuardKioskController extends Controller
{
    // Show the public guard shift logs form
    public function index()
    {
        $guards = Guard::all();
        return view('guard_kiosk.index', compact('guards'));
    }

    // Handle shift report submission
    public function store(Request $request)
    {
        $data = $request->validate([
            'guard_id' => 'required|exists:guards,id',
            'report_date' => 'required|date',
            'shift_start' => 'required',
            'shift_end' => 'nullable',
            'post_location' => 'required|string|max:255',
            'weather_conditions' => 'nullable|string|max:255',
            'activity_entries' => 'nullable|string',
            'incident_details' => 'nullable|string',
            'handover_notes' => 'nullable|string',
            'tech_access_logs' => 'nullable|string',
            'equipment_monitoring' => 'nullable|string',
        ]);
        
        // Find the guard name from the selected guard
        $guard = Guard::find($data['guard_id']);
        $data['guard_name'] = $guard->name;

        ShiftReport::create($data);

        return redirect()->route('guard_kiosk.success');
    }

    public function success()
    {
        return view('guard_kiosk.success');
    }
}
